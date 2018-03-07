<?php
namespace app\dao;

use mphp\Db;

class Post extends Base
{
    public $db;
    const TBL = 'post';

    public function __construct($conn)
    {
        $this->db = Db::instance($conn);
    }
}