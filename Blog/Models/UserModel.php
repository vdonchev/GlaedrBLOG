<?php


namespace Blog\Models;


use Blog\Models\Entities\TemplateEntity;
use Blog\Models\Entities\UserEntity;
use Framework\Models\Model;

class UserModel extends Model
{
    public function register(string $username, string $password, string $name, string $email): bool
    {
        $stmt = $this->getDb()->prepare("INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $password, $name, $email]);
    }

    public function userExists(string $username): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchRow() != null;
    }

    public function userExistsById(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchRow() != null;
    }

    public function templateExists(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM templates WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchRow() != null;
    }

    public function getUser(string $username)
    {
        $stmt = $this->getDb()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchObj(UserEntity::class);
    }

    public function getAllTemplates(): array
    {
        $stmt = $this->getDb()->prepare("SELECT id, name, cssFile FROM templates");
        $stmt->execute();

        $templates = [];
        while ($template = $stmt->fetchObj(TemplateEntity::class)) {
            $templates[] = $template;
        }

        return $templates;
    }

    public function setTemplate(int $templateId, int $userId): bool
    {
        if (!$this->userExistsById($userId) || !$this->templateExists($templateId)) {
            return false;
        }

        $stmt = $this->getDb()->prepare("UPDATE users SET templateId = ? WHERE id = ?");
        $stmt->execute([$templateId, $userId]);

        return true;
    }
}

