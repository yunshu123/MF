<?php
namespace app\service;

use app\dao\PostDao;

class PostService extends BaseService
{
    protected $conn = 'A';
    protected $postDao;

	public function __construct()
	{
		$this->postDao = new PostDao($this->conn);
	}

	public function getOne($id)
	{
        return $this->postDao->db->get(PostDao::TBL, '*', ['id'=>(int)$id]);
    }
}