<?php $post = $this->getData()["post"]; ?>
<?php /** @var $post \Blog\Models\Entities\PostEntity */; ?>
<div class="col-md-9">
    <h1 class="h2">Edit post:</h1>
    <hr>
    <form class="form-horizontal" method="post" action="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/edit">
        <input type="hidden" value="<?= $post->getId(); ?>" name="postId">
        <fieldset>
            <div class="form-group">
                <label for="postTitle" class="col-lg-2 control-label">Title
                </label>
                <div class="col-lg-10">
                    <input type="text"
                           class="form-control"
                           id="editTitle"
                           name="editTitle"
                           value="<?= renderInView($post->getTitle()); ?>"
                           required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="postBody" class="col-lg-2 control-label">Body</label>
                <div class="col-lg-10">
                    <textarea class="form-control"
                              rows="5"
                              name="editBody"
                              id="editBody"
                              required="required"><?= renderInView($post->getBody()); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="tags" class="col-lg-2 control-label">Tags</label>
                <div class="col-lg-10">
                    <textarea class="form-control"
                              rows="2"
                              name="editTags"
                              id="editTags"
                              required="required"
                    ><?= renderInView(implode(",", $post->getTags())); ?></textarea>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts" class="btn btn-default" >Cancel</a>
                    <button type="submit" class="btn btn-primary" name="editPost">Edit</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>