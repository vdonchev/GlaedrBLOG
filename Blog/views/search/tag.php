<div class="col-md-9">
    <?php /** @var $posts \Blog\Models\Entities\PostEntity[] */; ?>
    <?php $posts = $this->getData()["searchedPosts"]; ?>
    <?php $tag = $this->getData()["searchedTag"]; ?>
    <div>
        <h1 class="h2">Search results for tag "<strong><?= renderInView($tag) ?></strong>" (<?= count($posts); ?>
            matches):</h1>
        <hr>
    </div>
    <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ; ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 class="h4">
                        <strong>
                            <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/view/<?= $post->getId(); ?>">
                                <?= renderInView($post->getTitle()); ?>
                            </a>
                        </strong>
                    </h2>
                    <hr>
                    <p class="post-content">
                        <?= renderInView(truncateText($post->getBody(), 35)); ?>
                    </p>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default post-meta">
                                <div class="panel-body ">
                                    <ul class="post-meta list-unstyled list-inline">
                                        <li>Posted on: <?= $post->getCreatedOn(); ?></li>
                                        <?php if ($post->getCreatedOn() !== $post->getUpdatedOn()): ; ?>
                                            <li class="text-muted"><em>Updated on: <?= $post->getUpdatedOn(); ?></em>
                                            </li>
                                        <?php endif; ?>
                                        <li>Author: <strong><?= renderInView($post->getAuthor()); ?></strong></li>
                                        <li>Viewed: <strong><?= $post->getViews(); ?></strong> times</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="col-md-9">
            <h1 class="h4">No results by tag "<?= "{$tag}" ?>". </h1>
        </div>
    <?php endif; ?>
</div>