<?php


namespace Blog\Controllers;


use Framework\Controllers\Controller;

class PostsController extends Controller
{
    public function index($pageIndex = 0)
    {
        echo "Posts controller - index action";
        // TODO
    }

    public function add()
    {
        echo "Posts controller - add action";
        // TODO
    }

    public function view($postId)
    {
        echo "Posts controller - view action";
        // TODO
    }

    public function comment($postId)
    {
        echo "Posts controller - comment action";
        // TODO
    }

    public function edit($postId)
    {
        echo "Posts controller - edit action";
        // TODO
    }

    public function del($postId)
    {
        echo "Posts controller - del action";
        // TODO
    }
}