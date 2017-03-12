<h1 class="h2">Popular Tags</h1>
<hr>
<?php /** @var $model \Blog\Models\AppModel */; ?>
<?php $model = $this->getAppModel(); ?>
<?php $tags = $model->getPostsModel()->getMostPopularTags(); ?>
<?php /** @var $tag \Blog\Models\Entities\TagEntity */; ?>
<ul class="list-inline list-unstyled text-center">
    <?php foreach ($tags as $tag): ?>
        <li class="">
            <a style="font-size: <?= $tag->getPopularityRatio() + 1; ?>em"
               href="<?= \Framework\Core\Config::APP_ROOT; ?>/search/tag/<?= urlencode($tag->getName()); ?>">
                <?= renderInView($tag->getName()); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>