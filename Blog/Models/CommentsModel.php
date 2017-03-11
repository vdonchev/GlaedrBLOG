<?php


namespace Blog\Models;


use Framework\Models\Model;

class CommentsModel extends Model
{
    public function addCommentByUser(int $userId, int $postId, string $body): bool
    {
        $stmt = $this->getDb()->prepare("INSERT INTO comments (authorId, postId, body) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $postId, $body]);
    }

    public function addCommentByGuest(int $guestId, int $postId, string $body): bool
    {
        $stmt = $this->getDb()->prepare("INSERT INTO comments (guestId, postId, body) VALUES (?, ?, ?)");
        return $stmt->execute([$guestId, $postId, $body]);
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $ip
     * @return bool | int
     */
    public function addGuestAsCommentAuthor(string $name, string $email, string $ip)
    {
        $stmt = $this->getDb()->prepare("INSERT INTO guests (name, email, ip) VALUES (?, ?, ?)");
        $res = $stmt->execute([$name, $email, $ip]);
        if ($res === false) {
            return false;
        }

        return $this->getDb()->getLastId();
    }

    public function postExists(int $postId)
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM posts WHERE id = ?");
        $stmt->execute([$postId]);

        return $stmt->fetchRow() != null;
    }
}