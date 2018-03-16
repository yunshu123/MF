<?php

//api路由

$app->get('/api/v1/article/{id}', '\app\controller\v1\PostController:getArticleById');