<?php $posts = $this->getData()["posts"]; ?>
<?php /** @var $posts \Blog\Models\Entities\PostEntity[] */; ?>
<div class="col-md-9">
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
                <?php if (count($post->getTags()) > 0) :; ?>
                    <hr>
                    <div class="h4">
                        Tags:
                        <span class="label label-primary"><?php echo implode("</span> <span class='label label-primary'>", array_map("renderInView", $post->getTags())); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default post-meta">
                            <div class="panel-body ">
                                <ul class="post-meta list-unstyled list-inline">
                                    <li>Posted on: <?= $post->getCreatedOn(); ?></li>
                                    <li>Author: <strong><?= renderInView($post->getAuthor()); ?></strong></li>
                                </ul>

                                <?php if ($post->getCreatedOn() !== $post->getUpdatedOn()): ;?>
                                    <ul class="post-meta list-unstyled list-inline">
                                        <li class="text-muted"><em>Updated on: <?= $post->getUpdatedOn(); ?></em></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->isAuthorized() && $this->isAdmin()): ; ?>
                        <div class="col-sm-6 text-right">
                            <a class="btn btn-warning btn-sm"
                               href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/edit/<?= $post->getId(); ?>">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                            </a>
                            <a class="btn btn-danger btn-sm"
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
    <?php $selectedPage = $this->getData()["selectedPage"]; ?>
    <?php $firstPage = $this->getData()["firstPage"]; ?>
    <?php $lastPage = $this->getData()["lastPage"]; ?>
    <ul class="pager">
        <?php if ($firstPage < $selectedPage): ; ?>
            <li class="previous"><a
                        href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/all/1">&lt;&lt;</a></li>
            <li class="previous"><a
                        href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/all/<?= $selectedPage - 1; ?>">&larr;
                    Newer </a></li>
        <?php else: ; ?>
            <li class="previous disabled"><span>&larr; Newer </span></li>
        <?php endif; ?>

        <?php if ($lastPage > $selectedPage): ; ?>
            <li class="next"><a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/all/<?= $lastPage; ?>">
                    &gt;&gt;</a></li>
            <li class="next"><a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/all/<?= $selectedPage + 1; ?>">
                    Older &rarr;</a></li>
        <?php else: ; ?>
            <li class="next disabled"><span> Older &rarr;</span></li>
        <?php endif; ?>
    </ul>
</div>