<div class="col-md-9">
    <h1 class="h2">Add comment:</h1>
    <hr>
    <form class="form-horizontal" method="post" action="<?= \Framework\Core\Config::APP_ROOT; ?>/comments/add">
        <input type="hidden" name="id" value="<?= $this->getData()["postId"]; ?>">
        <fieldset>
            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Name</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Your name">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your email">
                </div>
            </div>
            <div class="form-group">
                <label for="comment" class="col-lg-2 control-label">Comment body</label>
                <div class="col-lg-10">
                    <textarea class="form-control" rows="5" name="comment"
                              id="comment" placeholder="Your comment"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="addComment">Add Comment</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>