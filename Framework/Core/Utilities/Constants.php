<?php


namespace Framework\Core\Utilities;


class Constants
{
    private function __construct()
    {
    }

    const INVALID_NOTIFICATION_TYPE = "Invalid notification type.";
    const INVALID_CONTROLLER = "Invalid controller.";
    const MISSING_VIEW_FILE = "Requested view file was not found.";
    const APP_ROOT_NOT_SET = "Invalid application root.";
}