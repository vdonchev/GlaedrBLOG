<?php $posts = $this->getData()["posts"]; ?>
<?php /** @var $posts \Blog\Models\Entities\PostEntity[] */; ?>
<div class="col-md-9">
    <?php foreach ($posts as $post): ; ?>
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="h3">
                    <strong>
                        <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/view/<?= $post->getId(); ?>">
                            <?= $post->getTitle(); ?>
                        </a>
                    </strong>
                </h2>
                <hr>
                <p class="post-content">
                    <?= $post->getBody(); ?>
                </p>
                <?php if (count($post->getTags()) > 0) :; ?>
                    <hr>
                    <div class="">
                        Tags:
                        <strong><?php echo implode(", ", $post->getTags()); ?></strong>
                    </div>
                <?php endif; ?>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled list-inline">
                            <li>
                                <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/edit/<?= $post->getId(); ?>">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit
                                </a>
                            </li>
                            <li>
                                <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/del/<?= $post->getId(); ?>">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled list-inline text-right">
                            <li><span>Posted on: <?= $post->getCreatedOn(); ?></span></li>
                            <li><span>By: <strong><?= $post->getAuthor(); ?></strong></span></li>
                        </ul>
                    </div>
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
                        href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/all/<?= $selectedPage - 1; ?>">&larr;
                    Newer </a></li>
        <?php else: ; ?>
            <li class="previous disabled"><span>&larr; Newer </span></li>
        <?php endif; ?>

        <?php if ($lastPage > $selectedPage): ; ?>
            <li class="next"><a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/all/<?= $selectedPage + 1; ?>">
                    Older &rarr;</a></li>
        <?php else: ; ?>
            <li class="next disabled"><span> Older &rarr;</span></li>
        <?php endif; ?>
    </ul>
</div>