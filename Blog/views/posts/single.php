<?php $post = $this->getData()["post"]; ?>
<?php /** @var $post \Blog\Models\Entities\PostEntity */; ?>
    <div class="col-md-9">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="h3">
                    <strong><?= renderInView($post->getTitle()); ?></strong>
                </h2>
            </div>
            <div class="panel-body">
                <p class="post-content">
                    <?= renderInView($post->getBody()); ?>
                </p>
                <hr>
                <div>
                    <?php if (count($post->getTags()) > 0) :; ?>
                        <div class="h4">
                            Tags:
                            <?php foreach ($post->getTags() as $tag): ; ?>
                                <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/search/tag/<?= urlencode($tag); ?>">
                            <span class="label label-primary">
                                <?= renderInView($tag); ?>
                            </span>
                                </a>&nbsp;
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
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

                                <?php if ($post->getCreatedOn() !== $post->getUpdatedOn()): ; ?>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        Comments (<?= $post->getCommentsCount(); ?>)
                    </div>
                    <div class="col-md-6 text-right">

                        <a class="btn btn-sm btn-default"
                           href="<?= \Framework\Core\Config::APP_ROOT; ?>/comments/add/<?= $post->getId(); ?>">
                                <span>
                                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add Comment
                                </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <?php if ($post->getCommentsCount() === 0): ; ?>
                    <span>No comments...</span>
                <?php else: ; ?>
                    <?php /** @var $comment \Blog\Models\Entities\CommentEntity */; ?>
                    <?php foreach ($post->getComments() as $comment): ; ?>
                        <div class="panel panel-default">
                            <div class="panel-body" id="post-id-<?= renderInView($comment->getId()); ?>">
                                <strong><?= renderInView($comment->getAuthorName()); ?></strong>
                                (<?= renderInView($comment->getAuthorEmail()); ?>)
                                Posted on: <?= renderInView($comment->getCreatedOn()); ?>
                                <hr>
                                <p><?= renderInView($comment->getBody()); ?></p>
                                <div class="text-right">
                                    <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/comments/delete/<?= $comment->getId(); ?>"
                                       class="delete-item">
                                        <span class="text-danger glyphicon glyphicon-remove-circle"
                                              aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php //if ($this->isAuthorized() && $this->isAdmin()): ; ?>