<?php


namespace Blog\Controllers;


use Blog\Models\Entities\UserEntity;
use Blog\Models\UserModel;
use Framework\Controllers\Controller;
use Framework\Core\Config;
use Framework\Core\Utilities\Messages;

class UserController extends Controller
{
    public function index()
    {
        $this->redirect("user", "profile");
    }

    public function login()
    {
        if ($this->isAuthorized()) {
            $this->redirect("user", "profile");
        }

        if ($this->isPost() && isset($this->getRequest()["login"])
        ) {
            /**
             * @var UserModel $model
             */
            $model = $this->getModel();

            $username = trim($this->getRequest()["username"]);
            $password = $this->getRequest()["password"];

            /**
             * @var UserEntity $user
             */
            $user = $model->getUser($username);

            if ($user == null || !password_verify($password, $user->getPassword())) {
                $this->getSession()->addMessage("Username or password is incorrect.", Messages::DANGER);

            } else {
                $this->getSession()->setProperty(Config::USER_ID, $user->getId());
                if ($user->getRoleId() === 1) {
                    $this->getSession()->setProperty(Config::USER_ADMIN, true);
                }
                $this->getSession()->addMessage("You are logged in! Welcome!", Messages::SUCCESS);
                $this->redirect("user", "profile");
            }
        }

        $this->renderView("user/login");
    }

    public function register()
    {
        if ($this->isAuthorized()) {
            $this->redirect("user", "profile");
        }

        if ($this->isPost() && isset($this->getRequest()["register"])
        ) {
            /**
             * @var UserModel $model
             */
            $model = $this->getModel();

            $username = trim($this->getRequest()["username"]);
            $password = $this->getRequest()["password"];
            $passwordRepeat = $this->getRequest()["password-repeat"];
            $name = trim($this->getRequest()["name"]);
            $email = trim($this->getRequest()["email"]);

            if (strlen($username) < 3) {
                $this->getSession()->addMessage("Username should be at least 3 characters long.", Messages::DANGER);
            }

            if ($model->userExists($username)) {
                $this->getSession()->addMessage("Username already exists.", Messages::DANGER);
            }

            if (strlen($password) < 8) {
                $this->getSession()->addMessage("Password should be at least 8 characters long.", Messages::DANGER);
            }

            if ($password !== $passwordRepeat) {
                $this->getSession()->addMessage("Passwords does not match.", Messages::DANGER);
            }

            if (empty($name)) {
                $this->getSession()->addMessage("Name cannot be empty.", Messages::DANGER);
            }

            if (empty($email)) {
                $this->getSession()->addMessage("Email cannot be empty.", Messages::DANGER);
            }

            $email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                $this->getSession()->addMessage("Email is not valid.", Messages::DANGER);
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            if ($this->getSession()->getMessagesCount(Messages::DANGER) <= 0) {
                if ($model->register($username, $hashedPassword, $name, $email)) {
                    $this->getSession()->addMessage("Registration successful", Messages::SUCCESS);
                    $this->redirect("user", "login");
                }
            }
        }

        $this->renderView("user/register");
    }

    public function profile()
    {
        if (!$this->isAuthorized()) {
            $this->redirect("user", "login");
        }

        /**
         * @var $model UserModel
         */
        $model = $this->getModel();

        $user = $model->getUserById($this->getSession()->getProperty(Config::USER_ID));
        $this->addData("user", $user);

        $templates = $model->getAllTemplates();
        $this->addData("templates", $templates);

        $this->renderView("user/profile");
    }

    public function logout()
    {
        if (!$this->isAuthorized()) {
            $this->redirect("user");
        }

        $this->getSession()->unsetProperty(Config::USER_ID);
        $this->getSession()->addMessage("Logged out successfully", Messages::INFO);
        $this->redirect("home");
    }

    public function template()
    {
        if (!$this->isPost() || !$this->isAuthorized()) {
            $this->getSession()->addMessage("Access denied", Messages::DANGER);
            $this->redirect("user", "profile");
        }

        $templateId = filter_var($_POST["template"], FILTER_VALIDATE_INT);
        if ($templateId === false) {
            $this->redirect("user", "profile");
        }

        $userId = $this->getSession()->getProperty(Config::USER_ID);

        /**
         * @var $model UserModel
         */
        $model = $this->getModel();
        if ($model->setTemplate($templateId, $userId)) {
            $this->getSession()->addMessage("Template changed successfully", Messages::SUCCESS);
            $this->redirect("user", "profile");
        }

        $this->getSession()->addMessage("Template change error. Try again", Messages::DANGER);
        $this->redirect("user", "profile");
    }
}