<?php
declare(strict_types = 1);

use Blog\Models\AppModel;
use Blog\Models\PostsModel;
use Blog\Models\UserModel;
use Framework\Core\App;
use Framework\Core\Config;
use Framework\Core\Database\PDODatabase;
use Framework\Core\Session\Session;

require_once "Framework/Core/functions/functions.php";

mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");
date_default_timezone_set("Europe/Sofia");
session_start();

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    if (file_exists("{$class}.php")) {
        require_once "{$class}.php";
    }
});

$database = new PDODatabase(Config::DB_HOST, Config::DB_NAME, Config::DB_USER, Config::DB_PASS);
$session = new Session($_SESSION);

$userModel = new UserModel($database);
$postsModel = new PostsModel($database);

$appModel = new AppModel($database, $userModel, $postsModel);

$app = new App($database, $session, $appModel);
$app->start($_SERVER["REQUEST_URI"]);