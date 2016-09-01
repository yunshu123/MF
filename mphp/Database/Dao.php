<?php
namespace Mphp\Database;

use Mphp\Libraries\Fake;

abstract class Dao
{
	protected $conn = null;

	protected $dbConfig = '';

	protected $field = '';

	protected $where;

	protected $order;

	protected $group;

	protected $limit;

	public function __construct()
	{
	}

	abstract function prepareQueryType($condition, $query_type = 0);

	protected function getList($condition, $page = 1, $size = 10, $query_type=1)
	{
		$page = (int)$page;
		$size = (int)$size;
		$page > 0 or $page = 1;

		$this->prepareQueryType($condition, $query_type);
		$preArr = $this->prepareSql();
		$sql    = $preArr['sql'];
		$cond   = $preArr['cond'];
		$sql    = "SELECT " . $this->field . " FROM <DB.TABLE>  WHERE " . $sql;

		if ($size) {
			$offset = ($page - 1) * $size;
			$sql .= " LIMIT $offset, $size";
		}
		$ret = $this->getDb()->queryAll($sql, $cond);
		if ($ret === false) {
			return Fake::error(1001);
		}

		$rets['rows']  = $ret;
		$rets['total'] = $this->getDb()->getCount($preArr['where'], $preArr['cond']);
		$rets['page']  = $page;
		$rets['size']  = $size;

		return $rets;
	}

	public function updateData($aParam, $aWhere = array())
	{
		$sWhere = '';
		foreach ($aWhere as $k => $v) {
			if ($sWhere) {
				$sWhere .= " AND $k = '$v'";
			} else {
				$sWhere = "$k = '$v'";
			}
		}
		$ret = $this->getDb()->update($aParam, $sWhere);

		if (Fake::check($ret)) {
			return $ret;
		}

		if ($ret === false) {
			return Fake::error(1001);
		}

		return $ret;
	}

	/**
	 * 获取单条记录
	 *
	 * @param array $condition
	 *
	 * @return array
	 */
	public function getOne($condition, $query_type=0)
	{
		if (!in_array($query_type, $this->queryTypes)) {
			return Fake::error(2004);
		}
		$this->prepareQueryType($condition, $query_type);
		$where = '';
		if ( ! empty($condition)) {
			foreach ($condition as $k => $v) {
				if ($where) {
					$where .= " AND $k = ?";
				} else {
					$where = "$k = ?";
				}
				$cond[] = $v;
			}
		}

		$sql      = " SELECT " . $this->field . " FROM <DB>.<TABLE> WHERE " . $where;
		$ret_data = $this->getDb()->queryRow($sql, $cond);

		if (Fake::check($ret_data)) {
			return Fake::error(1001);
		}

		if ($ret_data === false) {
			$ret_data = [];
		}

		return $ret_data;
	}

	public function insert($param=[])
	{
		$ret = $this->getDb()->insert($param);

		if (Fake::check($ret)) {
			return $ret;
		}

		if ($ret === false) {
			return Fake::error(1001);
		}

		return $ret;
	}

	protected function prepareSql()
	{
		$arr    = array();
		$where  = '';
		$where1 = '';
		$cond = array();
		if ( ! empty($this->where)) {
			foreach ($this->where as $k => $v) {
				if (is_array($v)) {
					if ($v['op'] == 'in') {
						$placeholder = '(' . implode(",", array_fill(0, count($v['val']), "?")) . ")";
						foreach ($v['val'] as $par) {
							$cond[] = $par;
						}
					} else {
						$placeholder = '?';
						$cond[] = $v['val'];
					}
					if ($where) {
						$where .= " AND $k {$v['op']} {$placeholder}";   // AND age > ?
					} else {
						$where  = "$k {$v['op']} {$placeholder}";
					}
				} else {
					if ($where) {
						$where .= " AND $k = ?";
					} else {
						$where  = "$k = ?";
					}
					$cond[] = $v;
				}
			}
		}

		$arr['cond']   = $cond;
		$arr['where']  = $where;
		if ($this->order) {
			$where .= " ORDER BY " . $this->order;
		}
		if ($this->group) {

		}
		$arr['sql'] = $where;

		return $arr;
	}

	protected function getDb($conn=null, $dbConfig=null)
	{
		$conn = $conn ? $conn : $this->conn;
		$dbConfig = $dbConfig ? $dbConfig : $this->dbConfig;

		return Db::conn($conn, $dbConfig);
	}

	protected function pageInfo($aData, $page = 1, $size = 20)
	{
		$page = (int)$page;
		$size = (int)$size;
		$page > 0 or $page = 1;
		$size > 0 or $size = 20;
		$total      = (int)count($aData);
		$page_total = ceil($total / $size);
		$page > $page_total and $page = $page_total;
		$offset = ($page - 1) * $size;
		if ($total > $size) {
			$ret = array_slice($aData, $offset, $size);
		} else {
			$ret = $aData;
		}

		$rets['rows']       = $ret;
		$rets['total']      = $total;
		$rets['page']       = $page;
		$rets['size']       = $size;
		$rets['page_total'] = $page_total;

		return $rets;
	}

	protected function startTrans()
	{
		return $this->getDb()->beginTransaction();
	}

	public function commit()
	{
		return $this->getDb()->commit();
	}

	public function rollback()
	{
		return $this->getDb()->rollback();
	}

	protected function fetchRows($str_sql)
	{
		return $this->getDb()->queryAll($str_sql);
	}
}