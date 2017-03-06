<?php


namespace Blog\Controllers;


use Framework\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->renderView('home/index');
    }
}