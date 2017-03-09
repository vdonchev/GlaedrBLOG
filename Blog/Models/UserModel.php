<?php


namespace Blog\Models;


use Blog\Models\Entities\UserEntity;
use Framework\Models\Model;

class UserModel extends Model
{
    public function register(string $username, string $password, int $roleId = 2): bool
    {
        $stmt = $this->getDb()->prepare("INSERT INTO users (username, password, roleId) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $password, $roleId]);
    }


    public function userExists(string $username): bool
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchRow() != null;
    }

    public function getUser(string $username)
    {
        $stmt = $this->getDb()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);

        return $stmt->fetchObj(UserEntity::class);
    }

    public function getUserById(int $id)
    {
        $stmt = $this->getDb()->prepare(
            "SELECT u.id, u.username, u.createdOn, r.name AS role FROM users AS u LEFT JOIN user_roles AS r ON u.roleId = r.id WHERE u.id = ?");
        $stmt->execute([$id]);

        return $stmt->fetchObj(UserEntity::class);
    }
}

