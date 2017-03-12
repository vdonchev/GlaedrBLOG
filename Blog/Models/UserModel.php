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

    public function isAdmin(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT users.roleId FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return intval($stmt->fetchRow()["roleId"]) === 1;
    }

    public function userExistsById(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchRow() != null;
    }

    public function userExistsByName(string $username): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchRow() != null;
    }

    public function getUserById(int $id): UserEntity
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                            users.id,
                                            users.username,
                                            users.`password`,
                                            users.name,
                                            users.email,
                                            users.roleId,	
                                            user_roles.name AS role,
                                            templates.name AS templateName,
                                            templates.cssFile AS templateFile,
                                            users.createdOn,
                                            users.updatedOn
                                        FROM 
                                            users
                                        INNER JOIN templates 
                                            ON templates.id = users.templateId
                                        INNER JOIN user_roles
                                            ON user_roles.id = users.roleId
                                        WHERE users.id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchObj(UserEntity::class);
    }

    public function getUserByName(string $username): UserEntity
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                            users.id,
                                            users.username,
                                            users.`password`,
                                            users.name,
                                            users.email,
                                            users.roleId,	
                                            user_roles.name AS role,
                                            templates.name AS templateName,
                                            templates.cssFile AS templateFile,
                                            users.createdOn,
                                            users.updatedOn
                                        FROM 
                                            users
                                        INNER JOIN templates 
                                            ON templates.id = users.templateId
                                        INNER JOIN user_roles
                                            ON user_roles.id = users.roleId
                                        WHERE users.username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchObj(UserEntity::class);
    }

    public function templateExists(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM templates WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchRow() != null;
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

