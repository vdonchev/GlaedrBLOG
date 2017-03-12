<?php


namespace Blog\Controllers;


use Blog\Models\CommentsModel;
use Blog\Models\Entities\CommentEntity;
use Framework\Controllers\Controller;
use Framework\Core\Config;
use Framework\Core\Utilities\Messages;

class CommentsController extends Controller
{
    public function add($data = [])
    {
        /**
         * @var $model CommentsModel
         */
        $model = $this->getModel();

        if ($this->isPost() && isset($this->getRequest()["addComment"])) {
            $postId = trim($this->getRequest()["id"]);
            $postId = filter_var($postId, FILTER_VALIDATE_INT);
            if ($postId === false) {
                $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
                $this->redirect("posts", "all");
            }

            if (!$model->postExists($postId)) {
                $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
                $this->redirect("posts", "all");
            }

            $commentBody = trim($this->getRequest()["comment"]);
            if ($this->isAuthorized()) {
                if (empty($commentBody)) {
                    $this->getSession()->addMessage("Comment cannot be empty", Messages::DANGER);
                    $this->redirect("comments", "add", [$postId]);
                }

                $userId = $this->getSession()->getProperty(Config::USER_ID);
                if (!$model->addCommentByUser($userId, $postId, $commentBody)) {
                    $this->getSession()->addMessage(
                        "Internal error! Your comment was not added. Try again.",
                        Messages::DANGER);
                    $this->redirect("comments", "add", [$postId]);
                }
            } else {
                $ip = ip2long($_SERVER["REMOTE_ADDR"]);
                $name = trim($this->getRequest()["name"]);
                $email = trim($this->getRequest()["email"]);

                if (empty($name)) {
                    $this->getSession()->addMessage("Name cannot be empty", Messages::DANGER);
                }

                if (empty($email)) {
                    $this->getSession()->addMessage("Email cannot be empty", Messages::DANGER);
                }

                $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                if ($email === false) {
                    $this->getSession()->addMessage("Email is not valid", Messages::DANGER);
                }

                if ($this->getSession()->getMessagesCount(Messages::DANGER) > 0) {
                    $this->redirect("comments", "add", [$postId]);
                }

                $guestId = $model->addGuestAsCommentAuthor($name, $email, $ip);
                if ($guestId === false) {
                    $this->getSession()->addMessage(
                        "Internal error! Your comment was not added. Try again.",
                        Messages::DANGER);
                    $this->redirect("comments", "add", [$postId]);
                }

                if (!$model->addCommentByGuest($guestId, $postId, $commentBody)) {
                    $this->getSession()->addMessage(
                        "Internal error! Your comment was not added. Try again.",
                        Messages::DANGER);
                    $this->redirect("comments", "add", [$postId]);
                }
            }

            $this->getSession()->addMessage("Your comment was added successfully.", Messages::SUCCESS);
            $this->redirect("posts", "view", [$postId]);
        }

        if (!isset($data[0])) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        $postId = filter_var($data[0], FILTER_VALIDATE_INT);
        if ($postId === false) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        if (!$model->postExists($postId)) {
            $this->getSession()->addMessage("Invalid post id.", Messages::DANGER);
            $this->redirect("posts", "all");
        }

        $this->addData("postId", $postId);
        if ($this->isAuthorized()) {
            $this->renderView("comments/add");
        } else {
            $this->renderView("comments/add_as_guest");
        }
    }

    public function delete(array $commentId)
    {
        if (!$this->isAuthorized() || !$this->isAdmin()) {
            $this->getSession()->addMessage("You are not authorized to perform this action", Messages::DANGER);
            $this->redirect("posts");
        }

        /**
         * @var $model CommentsModel
         */
        $model = $this->getModel();

        if (!isset($commentId[0])) {
            $this->getSession()->addMessage("Invalid comment id.", Messages::DANGER);
            $this->redirect("posts");
        }

        $commentId = filter_var($commentId[0], FILTER_VALIDATE_INT);
        if ($commentId === false) {
            $this->getSession()->addMessage("Invalid comment id.", Messages::DANGER);
            $this->redirect("posts");
        }

        if (!$model->commentExists($commentId)) {
            $this->getSession()->addMessage("Invalid comment id.", Messages::DANGER);
            $this->redirect("posts");
        }

        if (!$model->removeComment($commentId)) {
            $this->getSession()->addMessage("Internal error. Comment was not deleted.", Messages::DANGER);
        } else {
            $this->getSession()->addMessage("Comment deleted successfully.", Messages::SUCCESS);
        }

        $postId = $model->getPostIdForComment($commentId);
        $this->redirect("posts", "view", [$postId]);
    }
}