<?php

namespace Blog\Models;

use Framework\Models\Model;
use Blog\Models\Entities\PostEntity;

class SearchModel extends Model
{
    public function getPostsByTagsByName(string $name){
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
                                        INNER JOIN post_tags
                                            ON posts.id = post_tags.postId
                                        WHERE posts.deletedOn IS NULL
                                        AND post_tags.name = ?");

        $stmt->execute([$name]);
        $posts = [];
        /**
         * @var $post PostEntity
         */
        while ($post = $stmt->fetchObj(PostEntity::class)) {
            $post->setTags($this->getPostsByTagsByName($post->getId()));
            $posts[] = $post;
        }

        return $posts;
    }
}