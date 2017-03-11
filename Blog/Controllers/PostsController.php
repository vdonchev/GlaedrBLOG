<?php


namespace Blog\Controllers;

use Blog\Models\Entities\PostEntity;
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
        if (!$this->isAdmin()) {
            $this->getSession()->addMessage("We are too protected for you, looser!", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        if (isset($_POST['createPost'])) {
            /**
             * @var PostsModel $postModel
             */
            $postModel = $this->getModel();

            $authorId = $this->getSession()->getProperty("userId");
            $title = trim($this->getRequest()["postTitle"]);
            $body = trim($this->getRequest()["postBody"]);
            $createdOn = (new \DateTime())->format('Y-m-d H:i:s');
            $updatedOn = $createdOn;
            $tags = array_unique(array_filter(array_map("trim", explode(",", $this->getRequest()["tags"]))));

            if (strlen($title) <= 0) {
                $this->getSession()->addMessage("Title should be at least 1 characters long!", Messages::DANGER);
            }

            if (strlen($body) <= 0) {
                $this->getSession()->addMessage("The description can not be empty!", Messages::DANGER);
            }

            if ($this->getSession()->getMessagesCount(Messages::DANGER) <= 0) {
                if ($postModel->addPost($authorId, $title, $body, $createdOn, $updatedOn)) {
                    $postId = $postModel->getLastPostId();
                    foreach ($tags as $tag) {
                        $postModel->addTag($postId, $tag);
                    }
                    $this->getSession()->addMessage("The post was created!", Messages::SUCCESS);
                    $this->redirect("posts", "all");
                } else {
                    $this->getSession()->addMessage("There was a problem creating the post!", Messages::DANGER);
                    $this->redirect("posts", "add");
                }
            }
        }

        if (isset($_POST['cancelAdding'])) {
            $this->getSession()->addMessage("You cancelled adding a post!", Messages::INFO);
            $this->redirect("posts", "all");
        }

        $this->renderView("posts/add");

    }

    public function view($id)
    {
        /**
         * @var $model PostsModel
         */
        $model = $this->getModel();

        $id = $id[0];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if ($id === false) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        if (!$model->postExists($id)) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        $post = $model->getPostWithCommentsById($id);

        $this->addData("post", $post);
        $this->renderView("posts/single");
    }

    public function edit($postIdStr)
        {
        if (!$this->isAdmin()) {
        $this->getSession()->addMessage("We are too protected for you, looser!", Messages::DANGER);
        $this->redirect("posts", "all");
        }

        /**
         * @var PostsModel $postModel
         */
        $postModel = $this->getModel();

        if ($this->isPost()) {
            if (isset($_POST['cancelEditing'])) {
                $this->getSession()->addMessage("You cancelled editing the post!", Messages::INFO);
                $this->redirect("posts", "all");
            }

            $title = trim($this->getRequest()["editTitle"]);
            $body = trim($this->getRequest()["editBody"]);
            $postId = filter_var($this->getRequest()["postId"], FILTER_VALIDATE_INT);

            if ($postId === false || !$postModel->postExists($postId)) {
                $this->getSession()->addMessage("Invalid post id supplied!", Messages::DANGER);
                $this->redirect("posts", "all");
            }

            if (strlen($title) <= 0) {
                $this->getSession()->addMessage("Title can not be empty!", Messages::DANGER);
            }

            if (strlen($body) <= 0) {
                $this->getSession()->addMessage("Description can not be empty!", Messages::DANGER);
            }

            if ($this->getSession()->getMessagesCount(Messages::DANGER) > 0) {
                $this->redirect("posts", "edit", [$postId]);
            }

            if ($postModel->editPost($title, $body, $postId)) {
                $this->getSession()->addMessage("The post was edited!", Messages::SUCCESS);
                $this->redirect("posts", "edit", [$postId]);
            } else {
                $this->getSession()->addMessage("There was a problem editing the post!", Messages::DANGER);
                $this->redirect("posts", "edit", [$postId]);
            }
        }

        $postId = filter_var($postIdStr[0], FILTER_VALIDATE_INT);
        if ($postId === false || !$postModel->postExists($postId)) {
            $this->getSession()->addMessage("Invalid post id supplied!", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        /**
         * @var $model PostsModel
         */
        $model = $this->getModel();
        $post = $model->getPostById($postId);

        $tags = $model->getPostTags($postId);
        $post->setTags($tags);
        $this->addData("post", $post);

        $this->renderView("posts/edit");
    }

    public function del($postId)
    {
        /**
         * @var $model PostsModel
         */
        $model = $this->getModel();

        $postId = $postId[0];
        $postId = filter_var($postId, FILTER_VALIDATE_INT);
        if (!$this->isAdmin()) {
            $this->getSession()->addMessage("We are too protected for you, looser!", Messages::DANGER);
            $this->redirect("posts", "all");
        }
        if ($postId === false) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }
        if (!$model->postExists($postId)) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }
        if ($model->deletePost($postId)) {
            $this->getSession()->addMessage("The post was deleted!", Messages::SUCCESS);
            $this->redirect("posts", "all");
        } else {
            $this->getSession()->addMessage("There was a problem deleting the post!", Messages::DANGER);
            $this->redirect("posts", "all");
        }


    }
}