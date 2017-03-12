<h1 class="h2">Most Viewed</h1>
<hr>
<?php /** @var $model \Blog\Models\AppModel */; ?>
<?php $model = $this->getAppModel(); ?>
<?php $posts = $model->getPostsModel()->getMostViewedPosts(); ?>
<?php /** @var $post \Blog\Models\Entities\PostEntity */; ?>
<ul class="list-group">
    <?php foreach ($posts as $post): ?>
        <li class="list-group-item">
            <span class="badge"><?= $post->getViews(); ?></span>
            <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/view/<?= $post->getId(); ?>">
                <?= $post->getTitle(); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
