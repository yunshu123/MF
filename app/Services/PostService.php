<?php
namespace App\Services;

use App\Dao\PostDao;
use Mphp\Service;
use Mphp\Model;
use Mphp\Libraries\Fake;

//关于文章的处理业务
class PostService extends Service
{

	private $postDao;

	public function __construct()
	{
		$this->postDao = new PostDao();
	}

	/**
	 * getArticles  获取文章列表
	 *
	 * @param array $cond  条件
	 * @param mixed $limit
	 * @param string $order
	 *
	 * @return array
	 */
	public function getList($cond, $page, $size, $query_type)
	{
		$data = $this->postDao->getList($cond, $page, $size, $query_type);

		return $data;
	}

	public function getOne($condition)
	{
		$data = $this->postDao->getOne($condition);

		return $data;
	}
}