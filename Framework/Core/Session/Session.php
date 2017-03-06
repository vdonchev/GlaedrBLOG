<?php


namespace Framework\Core\Session;


use Framework\Core\Config;
use Framework\Core\Utilities\Constants;
use Framework\Core\Utilities\Messages;

class Session implements SessionInterface
{
    private $session;

    public function __construct(&$session)
    {
        $this->session = &$session;

        if (!isset($this->session[Config::SESSION_MESSAGES_KEY])) {
            $this->session[Config::SESSION_MESSAGES_KEY] = [];
        }
    }

    public function setProperty(string $name, $value)
    {
        $this->session[$name] = $value;
    }

    public function unsetProperty(string $name)
    {
        unset($this->session[$name]);
    }

    public function propertyExists(string $name): bool
    {
        return isset($this->session[$name]);
    }

    public function getProperty(string $name)
    {
        return $this->session[$name];
    }

    public function addMessage(string $text, int $type)
    {
        if (!Messages::typeExists($type)) {
            throw new \Exception(Constants::INVALID_NOTIFICATION_TYPE);
        }

        $type = Messages::getTypeName($type);
        $this->session[Config::SESSION_MESSAGES_KEY][$type][] = $text;
    }

    public function getMessages(): array
    {
        $messages = $this->session[Config::SESSION_MESSAGES_KEY] ?? [];
        unset($this->session[Config::SESSION_MESSAGES_KEY]);

        return $messages;
    }

    public function getMessagesCount(int $type): int
    {
        if (!Messages::typeExists($type)) {
            throw new \Exception(Constants::INVALID_NOTIFICATION_TYPE);
        }

        $type = Messages::getTypeName($type);

        if (!isset($this->session[Config::SESSION_MESSAGES_KEY][$type])) {
            return 0;
        }

        return count($this->session[Config::SESSION_MESSAGES_KEY][$type]);
    }

    public function destroy()
    {
        $this->session = null;
        session_destroy();
    }

    public function flushMessages()
    {
        unset($this->session[Config::SESSION_MESSAGES_KEY]);
    }
}