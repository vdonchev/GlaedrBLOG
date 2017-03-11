<?php


namespace Framework\Models;


use Blog\Models\Entities\UserEntity;
use Framework\Core\Database\DatabaseInterface;

abstract class Model implements ModelInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    protected function getDb(): DatabaseInterface
    {
        return $this->db;
    }

    public function isAdmin(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT users.roleId FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return intval($stmt->fetchRow()["roleId"]) === 1;
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
}