<?php


namespace Blog\Models;


use Blog\Models\Entities\PostEntity;
use Framework\Core\Config;
use Framework\Models\Model;

class PostsModel extends Model
{
    /**
     * @param int $pageIndex
     * @return PostEntity[]
     */
    public function getPostsPerPage(int $pageIndex): array
    {
        $from = $pageIndex * Config::POSTS_PER_PAGE - Config::POSTS_PER_PAGE;
        $numOfPosts = Config::POSTS_PER_PAGE;
        $limit = "LIMIT {$from},{$numOfPosts}";

        $stmt = $this->getDb()->prepare("SELECT 
                                            posts.id,
                                            users.username as author,
                                            posts.title,
                                            posts.body,
                                            posts.createdOn
                                        FROM posts
                                        INNER JOIN users
                                        ON users.id = posts.authorId
                                        ORDER BY createdOn DESC {$limit}");

        $stmt->execute();
        $posts = [];
        /**
         * @var $post PostEntity
         */
        while ($post = $stmt->fetchObj(PostEntity::class)) {
            $post->setTags($this->getPostTags($post->getId()));
            $posts[] = $post;
        }

        return $posts;
    }

    public function getNumberOfPosts(): int
    {
        $stmt = $this->getDb()->prepare("SELECT COUNT(posts.id) AS total FROM posts");
        $stmt->execute();

        return intval($stmt->fetchRow()["total"]);
    }

    public function getPostTags(int $postId): array
    {
        $stmt = $this->getDb()->prepare("SELECT name FROM post_tags WHERE postId = ?");
        $stmt->execute([$postId]);

        $tags = [];
        foreach ($stmt->fetchAll() as $tag) {
            $tags[] = $tag["name"];
        }

        return $tags;
    }

    public function addPost(int $authorId,string $title,string $body,string $createdOn,string $updatedOn)
    {
        $stmt = $this->getDb()->prepare("INSERT INTO posts (authorId,title, body, createdOn, updatedOn) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$authorId, $title, $body, $createdOn, $updatedOn]);
    }

    public function register(string $username, string $password, int $roleId = 2): bool
    {
        $stmt = $this->getDb()->prepare("INSERT INTO users (username, password, roleId) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $password, $roleId]);
    }
}