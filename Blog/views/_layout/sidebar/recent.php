<h1 class="h2">Recent Posts</h1>
<hr>
<?php /** @var $model \Blog\Models\AppModel */; ?>
<?php $model = $this->getAppModel(); ?>
<?php $posts = $model->getPostsModel()->getRecentPosts(); ?>
<?php /** @var $post \Blog\Models\Entities\PostEntity */; ?>
<ul class="list-group">
    <?php foreach ($posts as $post): ?>
        <li class="list-group-item">
            <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/view/<?= $post->getId(); ?>">
                <?= renderInView($post->getTitle()); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>