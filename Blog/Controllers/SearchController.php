<?php


namespace Blog\Controllers;


use Framework\Controllers\Controller;

class SearchController extends Controller
{
    public function index()
    {
        $this->redirect("home");
    }

    public function tag(array $searchData)
    {
        $tag = $searchData[0];
        var_dump(urldecode($tag));
        // todo

        $this->renderView("search/tag");
    }
}