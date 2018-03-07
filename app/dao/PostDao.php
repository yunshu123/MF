<?php
namespace app\dao;

use mphp\Db;

class PostDao extends BaseDao
{
    public $db;
    const TBL = 'post';

    public function __construct($conn)
    {
        $this->db = Db::instance($conn);
    }
}