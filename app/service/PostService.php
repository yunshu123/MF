<?php
namespace app\service;

class Post extends Base
{
    protected $conn = 'A';
    protected $postDao;

	public function __construct()
	{
		$this->postDao = new \app\dao\Post($this->conn);
	}

	public function getOne($id)
	{
//        return $this->postDao->db->select(\app\dao\Post::TBL, [], ['id'=>$id]);
	    return ['hello'];
    }
}