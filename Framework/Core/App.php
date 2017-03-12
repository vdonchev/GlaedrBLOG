<?php


namespace Framework\Core;


use Blog\Models\AppModel;
use Framework\Core\Database\DatabaseInterface;
use Framework\Core\Session\SessionInterface;
use Framework\Core\Utilities\Constants;
use Framework\Core\View\View;

class App implements AppInterface
{
    private $controller;
    private $action;
    private $parameters;

    private $database;
    private $session;
    private $appModel;

    public function __construct(
        DatabaseInterface $database,
        SessionInterface $session,
        AppModel $appModel)
    {
        $this->database = $database;
        $this->session = $session;
        $this->appModel = $appModel;
    }

    public function start(string $url)
    {
        try {
            $this->parse($url);
            $this->process();
        } catch (\Exception $exception) {
            echo htmlentities($exception->getMessage());
        }
    }

    private function parse(string $url)
    {
        if (substr($url, 0, strlen(Config::APP_ROOT . "/")) != Config::APP_ROOT . "/") {
            throw new \Exception(Constants::APP_ROOT_NOT_SET);
        }

        $url = array_map("urldecode",
            array_filter(
                explode("/",
                    trim(
                        substr($url, strlen(Config::APP_ROOT)), "/"))));

        $this->controller = array_shift($url) ?? Config::DEFAULT_CONTROLLER;
        $this->action = array_shift($url) ?? Config::DEFAULT_ACTION;
        $this->parameters = $url ?? [];
    }

    private function process()
    {
        $controllerClass = $this->formatClassName(
            $this->controller,
            Config::CONTROLLERS_NAMESPACE,
            Config::CONTROLLER_SUFFIX);

        $modelClass = $this->formatClassName(
            $this->controller,
            Config::MODELS_NAMESPACE,
            Config::MODEL_SUFFIX);

        $model = null;
        if (class_exists($modelClass)) {
            $model = new $modelClass($this->database);
        }

        if (!class_exists($controllerClass)) {
            throw new \Exception(Constants::INVALID_CONTROLLER);
        }

        $this->controller = new $controllerClass($this->session, $this->appModel, $model);

        call_user_func([$this->controller, $this->action], $this->parameters);
    }

    private function formatClassName(string $name, string $namespace, string $suffix)
    {
        return $namespace . ucfirst($name) . $suffix;
    }
}