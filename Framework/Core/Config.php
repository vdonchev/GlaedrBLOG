<?php


namespace Framework\Core;


class Config
{
    private function __construct()
    {
    }

    // edit

    const DB_HOST = "127.0.0.1";
    const DB_NAME = "blog_php";
    const DB_USER = "root";
    const DB_PASS = "";

    const APP_ROOT = "/blog";
    const PUBLIC = self::APP_ROOT . "/public/";
    const DEFAULT_CONTROLLER = "home";
    const DEFAULT_ACTION = "index";
    const CONTROLLER_SUFFIX = "Controller";
    const MODEL_SUFFIX = "Model";
    const CONTROLLERS_NAMESPACE = "Blog\\Controllers\\";
    const MODELS_NAMESPACE = "Blog\\Models\\";

    const SHARED_VIEWS_PATH = "_layout/";
    const VIEWS_PATH = "Blog/views/";

    const USER_ID = "userId";
    const USER_ADMIN = "isAdmin";
    const SESSION_MESSAGES_KEY = "___MESSAGES___";
}