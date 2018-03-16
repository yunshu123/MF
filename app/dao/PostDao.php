<?php
namespace app\dao;

use app\library\DB;

class PostDao extends BaseDao
{
    public $db;
    const TBL = 'post';

    public function __construct($conn)
    {
        $this->db = DB::instance($conn);
    }
}