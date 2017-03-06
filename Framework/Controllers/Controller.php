<?php


namespace Framework\Controllers;


use Framework\Core\Config;
use Framework\Core\Session\SessionInterface;
use Framework\Core\Utilities\Constants;
use Framework\Models\ModelInterface;

abstract class Controller implements ControllerInterface
{
    const MESSAGES = "messages";

    private $session;
    private $model;
    private $request;
    private $viewData = [];

    private $isAuthorized = false;
    private $isPost = false;

    public function __construct(
        SessionInterface $session,
        ModelInterface $model = null)
    {
        $this->session = $session;
        $this->model = $model;

        $this->isPost = $_SERVER["REQUEST_METHOD"] === "POST";
        $this->isAuthorized = $this->session->propertyExists(Config::USER_ID);

        $this->request = $_GET;
        if ($this->isPost()) {
            $this->request = $_POST;
        }

        $this->onInitialize();
    }

    public function getModel(): ModelInterface
    {
        return $this->model;
    }

    public function onInitialize()
    {
    }

    protected function getSession()
    {
        return $this->session;
    }

    protected function redirect(
        string $controller,
        string $action = Config::DEFAULT_ACTION,
        array $params = [])
    {
        $this->redirectToUrl(
            Config::APP_ROOT . "/"
            . $controller . "/"
            . $action . "/"
            . implode("/", array_map("urlencode", $params)));
    }

    public function getRequest()
    {
        return $this->request;
    }

    protected function redirectToUrl(string $url)
    {
        header("Location: {$url}");
        exit;
    }

    public function isAuthorized(): bool
    {
        return $this->isAuthorized;
    }

    public function isAdmin(): bool
    {
        $id = intval($this->getSession()->getProperty(Config::USER_ID));
        return $this->model->isAdmin($id);
    }

    public function isPost(): bool
    {
        return $this->isPost;
    }

    public function renderView(string $view, bool $includeTemplate = true)
    {
        ob_start();
        $viewFile = Config::VIEWS_PATH . $view . ".php";
        if (!file_exists($viewFile)) {
            throw new \Exception(Constants::MISSING_VIEW_FILE);
        }

        include_once $viewFile;

        $output = ob_get_contents();
        ob_end_clean();

        if ($includeTemplate) {
            include_once Config::VIEWS_PATH . Config::SHARED_VIEWS_PATH . "header.php";
            echo $output;
            include_once Config::VIEWS_PATH . Config::SHARED_VIEWS_PATH . "footer.php";
        } else {
            echo $output;
        }
    }

    public function addData(string $key, $data)
    {
        $this->viewData[$key] = $data;
    }

    public function getData(): array
    {
        return $this->viewData;
    }
}