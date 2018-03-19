<?php
use PHPUnit\Framework\TestCase;

/**
 * author: yunshu
 * create: 18/3/19
 * description:
 */
class RouteTest extends TestCase
{
    public function testPost()
    {
        $this->assertEquals('post', 'post');
    }
}