<?php
use MF\Database\Dao;
use MF\Libraries\Fake;

class PostDao extends Dao {

	//连接的标识id,在database.php中配置
	protected $conn = 'A';

	//配置连接的数据库与数据表
	protected $dbConfig = 'mf.mf_post';

	protected $queryTypes = [1];

	protected $field = '*';

	public function __construct()
	{
		parent::__construct();
	}

	public function prepareQueryType($condition, $query_type = 0)
	{
		if (!in_array($query_type, $this->queryTypes)){
			return Fake::error(2004);
		}
		$this->where = $condition;
		switch($query_type){
			case 1:
				$this->field = 'id,title,create_time';
				$this->order = 'id';
				$this->sort = 'DESC';
				break;
		}
	}

	public function getList($condition, $page = 1, $size = 10, $query_type=1)
	{
//		使用SQL语句查询
//		$id = $_GET['id'];
//		$res = $this->getDb()->queryAll("select * from <DB>.<TABLE> where id=".intval($id));
		$data = parent::getList($condition, $page, $size, $query_type);
//		查看执行的SQL
//		dump(\MF\Database\Db::$sql);
		return $data;
	}

	public function getOne($condition, $query_type = 1)
	{
		$data = parent::getOne($condition, $query_type);
//		dump(\MF\Database\Db::$sql);

		return $data;
	}

}