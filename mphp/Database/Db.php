<?php
namespace Mphp\Database;
use Mphp\Libraries\Fake;

//数据库封装类
class Db extends \Pdo
{
	private static $_instances;

	private $_conn;

	protected $queryTypes = [0];

	public static $sql = [];

	protected $pdo = null;

	public function __construct($dsn = null, $usr = null, $pwd = null, $opt = array())
	{
		if ($dsn) {
			$this->pdo = parent::__construct($dsn, $usr, $pwd, $opt);
		}
	}

	public function __call($method, $args)
	{
		return Fake::error(2000, "Method [$method] Does Not Exist");
	}

	public static function conn($conn = null, $data = null, $time = 5, $char = 'utf8')
	{
		$mysql_config = get_config('database');
		if (empty($conn)) {
			$conn = current(array_keys($mysql_config));
		}

		if (! self::$_instances[$conn] instanceof PDO) {
			$arg = $mysql_config[$conn];
			if (empty($arg)) {
				return new Fake(1000, "DB Connection [$conn] Does Not Exist");
			}
			try {
				$dsn = "{$arg['type']}:host={$arg['host']};port={$arg['port']};";
				$opt = [
					\PDO::ATTR_TIMEOUT            => $time,
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '$char'",
				];
				$pdo = new self($dsn, $arg['user'], $arg['pass'], $opt);
			} catch (PDOException $e) {
				$errno = $e->errorInfo[1] ? $e->errorInfo[1] : $e->getCode();
				$error = $e->errorInfo[2] ? $e->errorInfo[2] : $e->getMessage();

				return new Fake($errno, $error);
			}
			self::$_instances[$conn] = $pdo;
		}
		list($d, $t) = explode('.', $data);
		self::$_instances[$conn]->_conn = array('D' => $d, 'T' => $t ? $t : $d);

		return self::$_instances[$conn];
	}

	private function parseSql($sql)
	{
		if (empty($this->_conn['T'])) {
			return $sql;
		}

		$needle  = array('<DB.TABLE>', '<DB>', '<TABLE>');
		$replace = array("{$this->_conn['D']}.{$this->_conn['T']}", "{$this->_conn['D']}", "{$this->_conn['T']}");

		return str_replace($needle, $replace, $sql);
	}

	private function buildStmt($sql, $param = [])
	{
		try {
			$sql = $this->parseSql($sql);

			if (is_array($param) and $param) {
				$stmt = $this->prepare($sql);
				$info = $this->errorInfo();
				if ($info[1]) {
					throw new PDOException($info[2], $info[1]);
				}
				$stmt->execute(array_values($param));
//				var_dump($stmt);
			} else {
				$stmt = $this->query($sql);
				$info = $this->errorInfo();
				if ($info[1]) {
					throw new PDOException($info[2], $info[1]);
				}
			}

			self::$sql[] = self::showQuery($sql, $param);

			return $stmt;
		} catch (PDOException $e) {
			$errno = $e->errorInfo[1] ? $e->errorInfo[1] : $e->getCode();
			$error = $e->errorInfo[2] ? $e->errorInfo[2] : $e->getMessage();
			$error .= ' SQL: ' . $sql;

			return new Fake($errno, $error);
		}
	}

	//返回错误信息
	private function checkData($data)
	{
		if ($data === false) {
			$error = $this->errorInfo();
			if ($error[1]) {
				return Fake::error($error[1], $error[2]);
			}
		}

		return $data;
	}

	//使用预处理返回结果集行数
	public function executeSQL($sql, $param = [])
	{
		return $param ? $this->checkData($this->buildStmt($sql, $param)->rowCount())
			: $this->checkData($this->exec($this->parseSql($sql)));
	}

	//使用预处理返回全部结果集
	public function queryAll($sql, $param = [])
	{
		return $this->checkData($this->buildStmt($sql, $param)->fetchAll(\PDO::FETCH_ASSOC));
	}

	//返回一条结果集,关联数组
	public function queryRow($sql, $param = [])
	{
		return $this->checkData($this->buildStmt($sql, $param)->fetch(\PDO::FETCH_ASSOC));
	}

	//返回一条结果集,数字索引数组
	public function queryOne($sql, $param = [])
	{
		$data = $this->checkData($this->buildStmt($sql, $param)->fetch(\PDO::FETCH_NUM));

		return Fake::check($data) ? $data : $data[0];
	}

	//获取表记录数
	public function getCount($cond, $cond_param = [])
	{
		$sql = "SELECT COUNT(1) FROM <DB.TABLE> WHERE $cond";

		return $this->queryOne($sql, $cond_param);
	}

	//插入记录,返回插入id
	public function insert($param=[])
	{
		is_array($param) or $param = [];
		$values = [];
		foreach ($param as $key => $val) {
			$values[] = '?';
		}
		$insert_keys = array_keys($param);
		$sql = 'INSERT INTO <DB.TABLE> (' . implode(', ', $insert_keys)
		       . ') VALUES (' . implode(', ', $values) . ')';
		$data = $this->executeSQL($sql, $param);
		if ( ! Fake::check($data)) {
			$insert_id = $this->lastInsertId();
			if ($insert_id) {
				return $insert_id;
			}
		}

		return $data;
	}

	//更新表,$con必须为字符串作为更新条件
	public function update($param, $cond, $cond_param = array())
	{
		is_array($param) or $param = [];
		$update_keys = [];
		foreach ($param as $key => $val) {
			$update_keys[] = "$key = ?";
		}
		$sql   = 'UPDATE <DB.TABLE> SET ' . implode(', ', $update_keys)
		         . " WHERE $cond";
		$param = array_merge(array_values($param),
			is_array($cond_param) ? array_values($cond_param) : []);

		return $this->executeSQL($sql, $param);
	}

	public function addQuoteIdentifier($field)
	{
		$driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
		switch ($driver) {
			case 'mysql':
				$field = sprintf('`%s`', $field);
				break;
			case 'sqlite':
				$field = sprintf('"%s"', $field);
				break;
			default:
				break;
		}
		return $field;
	}

	//根据预处理格式获取SQL语句
	public static function showQuery($query, $params)
	{
		$keys   = array();
		$values = array();

		# build a regular expression for each parameter
		foreach ($params as $key => $value) {
			if (is_string($key)) {
				$keys[] = '/:' . $key . '/';
			} else {
				$keys[] = '/[?]/';
			}

			if (is_numeric($value)) {
				$values[] = intval($value);
			} else {
				$values[] = '"' . $value . '"';
			}
		}

		$query = preg_replace($keys, $values, $query, 1, $count);

		return $query;
	}
}
