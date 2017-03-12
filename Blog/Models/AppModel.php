<?php


namespace Blog\Models;


use Blog\Models\Entities\TemplateEntity;
use Framework\Core\Database\DatabaseInterface;

class AppModel
{
    private $db;
    private $userModel;
    private $postsModel;

    public function __construct(DatabaseInterface $db, UserModel $userModel, PostsModel $postsModel)
    {
        $this->db = $db;
        $this->userModel = $userModel;
        $this->postsModel = $postsModel;
    }

    protected function getDb(): DatabaseInterface
    {
        return $this->db;
    }

    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }

    public function getPostsModel(): PostsModel
    {
        return $this->postsModel;
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
        if (!$this->getUserModel()->userExistsById($userId) || !$this->templateExists($templateId)) {
            return false;
        }

        $stmt = $this->getDb()->prepare("UPDATE users SET templateId = ? WHERE id = ?");
        $stmt->execute([$templateId, $userId]);

        return true;
    }
}