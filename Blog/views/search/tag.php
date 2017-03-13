<?php $tag = $this->getData()["searchedTag"]; ?>
<div class="col-md-9">
    <h1 class="h2">Search results by tag "<?="{$tag}"?>" :</h1>
    <hr>
</div>

<?php $posts = $this->getData()["searchedPosts"]; ?>
<?php /** @var $posts \Blog\Models\Entities\PostEntity[] */; ?>
<div class="col-md-9">
    <?php if(count($posts) > 0): ?>
    <?php foreach ($posts as $post): ; ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="h3">
                    <strong>
                        <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/view/<?= $post->getId(); ?>">
                            <?= renderInView($post->getTitle()); ?>
                        </a>
                    </strong>
                </h2>
                <hr>
                <p class="post-content">
                    <?= renderInView($post->getBody()); ?>
                </p>
                <hr>
                <div>
                    <?php if (count($post->getTags()) > 0) :; ?>
                        <div class="h4">
                            Tags:
                            <?php foreach ($post->getTags() as $tag): ; ?>
                                <span class="label label-primary">
                                        <a class="post-tag" href="<?= \Framework\Core\Config::APP_ROOT; ?>/search/tag/<?= urlencode($tag); ?>"><?= renderInView($tag); ?></a>
                                    </span>&nbsp;
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text-right">
                    <div class="h5">
                        Comments: <?= $post->getCommentsCount(); ?>&nbsp;
                        <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/comments/add/<?= $post->getId(); ?>">
                                <span>
                                    <span class="glyphicon glyphicon-plus-sign text-success" aria-hidden="true"></span>
                                </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="panel panel-default post-meta">
                            <div class="panel-body ">
                                <ul class="post-meta list-unstyled list-inline">
                                    <li>Posted on: <?= $post->getCreatedOn(); ?></li>
                                    <li>Author: <strong><?= renderInView($post->getAuthor()); ?></strong></li>
                                    <li>Viewed: <?= $post->getViews(); ?> times</li>
                                </ul>

                                <?php if ($post->getCreatedOn() !== $post->getUpdatedOn()): ; ?>
                                    <ul class="post-meta list-unstyled list-inline">
                                        <li class="text-muted"><em>Updated on: <?= $post->getUpdatedOn(); ?></em></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->isAuthorized() && $this->isAdmin()): ; ?>
                        <div class="col-sm-4 text-right">
                            <a class="btn btn-warning btn-sm"
                               href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/edit/<?= $post->getId(); ?>">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                            </a>
                            <a class="btn btn-danger btn-sm delete-item"
                               href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/del/<?= $post->getId(); ?>">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else : ?>
        <div class="col-md-9">
            <h1 class="h4">No results by tag "<?="{$tag}"?>". </h1>
        </div>
    <?php endif; ?>
</div>