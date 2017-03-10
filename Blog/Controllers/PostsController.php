<?php


namespace Blog\Controllers;


use Blog\Models\PostsModel;
use Framework\Controllers\Controller;
use Framework\Core\Config;

class PostsController extends Controller
{
    public function index()
    {
        $this->redirect("posts", "all");
    }

    public function all($data)
    {
        if (!isset($data[0])) {
            $data[0] = 1;
        }

        $selectedPage = filter_var($data[0], FILTER_VALIDATE_INT);
        if ($selectedPage === false) {
            $selectedPage = 1;
        }

        if ($selectedPage <= 0) {
            $selectedPage = 1;
        }

        /**
         * @var $model PostsModel
         */
        $model = $this->getModel();

        $numberOfPosts = $model->getNumberOfPosts();
        $firstPage = 1;
        $lastPage = ceil($numberOfPosts / Config::POSTS_PER_PAGE);

        if ($lastPage < $selectedPage) {
            $selectedPage = $lastPage;
        }

        $this->addData("posts", $model->getPostsPerPage($selectedPage));
        $this->addData("firstPage", $firstPage);
        $this->addData("lastPage", $lastPage);
        $this->addData("selectedPage", $selectedPage);

        $this->renderView("posts/all");
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