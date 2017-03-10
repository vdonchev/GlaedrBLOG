<?php


namespace Blog\Controllers;


use Blog\Models\PostsModel;
use Framework\Controllers\Controller;
use Framework\Core\Config;
use Framework\Core\Utilities\Messages;

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
        if (!$this->isAuthorized()) {
            $this->getSession()->addMessage("We are too protected for you, looser!", Messages::DANGER);
            $this->redirect("posts", "all");
        }
        if(isset($_POST['createPost'])) {
            /**
             * @var PostsModel $postModel
             */
            $postModel = $this->getModel();

            $authorId = $this->getSession()->getProperty("userId");
            $title = trim($this->getRequest()["postTitle"]);
            $body = trim($this->getRequest()["postBody"]);
            $createdOn = (new \DateTime())->format('Y-m-d H:i:s');
            $updatedOn = $createdOn;

            if (strlen($title) <= 0) {
                $this->getSession()->addMessage("Title should be at least 1 characters long!", Messages::DANGER);
            }

            if (strlen($body) <= 0) {
                $this->getSession()->addMessage("The description can not be empty!", Messages::DANGER);
            }

            if ($this->getSession()->getMessagesCount(Messages::DANGER) <= 0) {
                if ($postModel->addPost($authorId, $title, $body, $createdOn, $updatedOn)) {
                    $this->getSession()->addMessage("The post was created!", Messages::SUCCESS);
                    $this->redirect("posts", "all");
                }else{
                    $this->getSession()->addMessage("There was a problem creating the post!", Messages::DANGER);
                    $this->redirect("posts", "add");
                }
            }
        }
        if(isset($_POST['cancelAdding'])) {
            $this->getSession()->addMessage("You cancelled adding a post!", Messages::INFO);
            $this->redirect("posts", "all");
        }
            $this->renderView("posts/add");

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