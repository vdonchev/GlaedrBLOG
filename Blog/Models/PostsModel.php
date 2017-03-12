<?php


namespace Blog\Models;


use Blog\Models\Entities\CommentEntity;
use Blog\Models\Entities\PostEntity;
use Blog\Models\Entities\TagEntity;
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
                                             posts.views,
                                             posts.createdOn,
                                             posts.updatedOn,
                                             (SELECT COUNT(comments.id) 
                                              FROM comments 
                                              WHERE comments.postId = posts.id
                                              AND comments.deletedOn IS NULL ) as commentsCount
                                        FROM posts 
                                        INNER JOIN users
                                            ON users.id = posts.authorId
                                        WHERE posts.deletedOn IS NULL
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
        $stmt = $this->getDb()->prepare("SELECT COUNT(posts.id) AS total FROM posts WHERE deletedOn IS NULL");
        $stmt->execute();

        return intval($stmt->fetchRow()["total"]);
    }

    public function addPost(int $authorId, string $title, string $body)
    {
        $stmt = $this->getDb()->prepare("INSERT INTO posts (authorId,title, body) VALUES (?, ?, ?)");
        return $stmt->execute([$authorId, $title, $body]);
    }

    public function editPost(string $title, string $body, int $postId, array $tags): bool
    {
        $stmt = $this->getDb()->prepare("UPDATE posts SET title = ?, body = ? WHERE id = ?");
        if (!$stmt->execute([$title, $body, $postId])) {
            return false;
        }

        if (!$this->deleteTags($postId)) {
            return false;
        }

        foreach ($tags as $tag) {
            if (!$this->addTag($postId, $tag)) {
                return false;
            }
        }

        return true;
    }

    public function deletePost(int $postId): bool
    {
        $stmt = $this->getDb()->prepare("UPDATE posts SET deletedOn = NOW() WHERE id = ?");
        return $stmt->execute([$postId]);
    }

    public function addTag(int $postId, string $tagName)
    {
        $stmt = $this->getDb()->prepare("INSERT INTO post_tags (postId, name) VALUES (?, ?)");
        return $stmt->execute([$postId, $tagName]);
    }

    public function deleteTags(int $postId): bool
    {
        $stmt = $this->getDb()->prepare("DELETE FROM post_tags WHERE postId = ?");
        return $stmt->execute([$postId]);
    }

    public function getPostById(int $id): PostEntity
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                             posts.id,
                                             users.username AS author,
                                             posts.title,
                                             posts.body,
                                             posts.views,
                                             posts.createdOn,
                                             posts.updatedOn,
                                             (SELECT COUNT(comments.id) 
                                              FROM comments 
                                              WHERE comments.postId = posts.id 
                                              AND comments.deletedOn IS NULL) AS commentsCount
                                        FROM posts 
                                        INNER JOIN users
                                            ON users.id = posts.authorId
                                        WHERE posts.deletedOn IS NULL
                                        AND posts.id = ?");
        $stmt->execute([$id]);

        /**
         * @var $post PostEntity
         */
        $post = $stmt->fetchObj(PostEntity::class);

        return $post;
    }

    public function getPostWithCommentsById(int $id): PostEntity
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                             posts.id,
                                             users.username AS author,
                                             posts.title,
                                             posts.body,
                                             posts.views,
                                             posts.createdOn,
                                             posts.updatedOn
                                        FROM posts 
                                        INNER JOIN users
                                            ON users.id = posts.authorId
                                        WHERE posts.deletedOn IS NULL
                                        AND posts.id = ?");
        $stmt->execute([$id]);
        /**
         * @var $post PostEntity
         */
        $post = $stmt->fetchObj(PostEntity::class);

        $post->setComments($this->getCommentsForPost($id));
        $post->setTags($this->getPostTags($id));

        return $post;
    }

    /**
     * @param int $id
     * @return CommentEntity[]
     */
    public function getCommentsForPost(int $id): array
    {
        $stmt = $this->getDb()->prepare("SELECT
                                            comments.id,
                                            COALESCE(users.name, guests.name) AS authorName,
                                            COALESCE(users.email, guests.email) AS authorEmail,
                                            comments.body,
                                            comments.createdOn
                                        FROM comments
                                        LEFT JOIN users
                                            ON comments.authorId = users.id
                                        LEFT JOIN guests
                                            ON comments.guestId = guests.id
                                        WHERE comments.postId = ?
                                        AND comments.deletedOn IS NULL
                                        ORDER BY comments.id DESC");

        $stmt->execute([$id]);
        $comments = [];
        while ($comment = $stmt->fetchObj(CommentEntity::class)) {
            $comments[] = $comment;
        }

        return $comments;
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

    public function incrementViews(int $postId)
    {
        $stmt = $this->getDb()->prepare("UPDATE posts SET posts.views = (posts.views + 1) WHERE posts.id = ?");
        return $stmt->execute([$postId]);
    }

    public function getLastPostId(): int
    {
        $stmt = $this->getDb()->getLastId();
        return $stmt;
    }

    public function postExists(int $postId)
    {
        $stmt = $this->getDb()->prepare("SELECT id FROM posts WHERE id = ?");
        $stmt->execute([$postId]);

        return $stmt->fetchRow() != null;
    }

    /**
     * @param int $count
     * @return \Generator|PostEntity[]
     */
    public function getMostViewedPosts(int $count = 5)
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                      posts.id,
                                      posts.title,
                                      posts.views
                                 FROM posts
                                 WHERE posts.deletedOn IS NULL 
                                 ORDER BY posts.views DESC 
                                 LIMIT {$count}");

        $stmt->execute();
        while ($row = $stmt->fetchObj(PostEntity::class)) {
            yield $row;
        }
    }

    /**
     * @param int $count
     * @return \Generator|PostEntity[]
     */
    public function getRecentPosts(int $count = 5)
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                      posts.id,
                                      posts.title,
                                      posts.createdOn
                                 FROM posts
                                 WHERE posts.deletedOn IS NULL 
                                 ORDER BY posts.createdOn DESC 
                                 LIMIT {$count}");

        $stmt->execute();
        while ($row = $stmt->fetchObj(PostEntity::class)) {
            yield $row;
        }
    }

    /**
     * @param int $count
     * @return \Generator|PostEntity[]
     */
    public function getMostCommentedPosts(int $count = 5)
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                            posts.id,
                                            posts.title,
                                        (SELECT COUNT(comments.id) 
                                        FROM comments 
                                        WHERE comments.postId = posts.id 
                                        AND comments.deletedOn IS NULL) AS commentsCount
                                        FROM posts
                                        WHERE posts.deletedOn IS NULL 
                                        ORDER BY commentsCount DESC 
                                        LIMIT {$count}");

        $stmt->execute();
        while ($row = $stmt->fetchObj(PostEntity::class)) {
            yield $row;
        }
    }

    /**
     * @param int $count
     * @return \Generator|TagEntity[]
     */
    public function getMostPopularTags(int $count = 50)
    {
        $stmt = $this->getDb()->prepare("SELECT 
                                            post_tags.id,
                                            post_tags.name, 
                                            COUNT(post_tags.name) AS popularity,
                                            (SELECT COUNT(post_tags.name) AS p 
                                            FROM post_tags 
                                            GROUP BY post_tags.name 
                                            ORDER BY p 
                                            LIMIT 1) AS minPopularity,
                                            (SELECT COUNT(post_tags.name) AS p 
                                        FROM post_tags 
                                        GROUP BY post_tags.name 
                                        ORDER BY p DESC 
                                        LIMIT 1) AS maxPopularity
                                        FROM post_tags 
                                        INNER JOIN posts
                                        ON posts.id = post_tags.postId
                                        WHERE posts.deletedOn IS NULL
                                        GROUP BY post_tags.name 
                                        ORDER BY post_tags.name ASC
                                        LIMIT {$count}");

        $stmt->execute();

        while ($row = $stmt->fetchObj(TagEntity::class)) {
            yield $row;
        }
    }
}