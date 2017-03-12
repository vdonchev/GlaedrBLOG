<div class="col-md-9">
    <h1 class="h2">Create post:</h1>
    <hr>
    <form class="form-horizontal" method="post" action="<?= \Framework\Core\Config::APP_ROOT; ?>/posts/add">
        <fieldset>
            <div class="form-group">
                <label for="postTitle" class="col-lg-2 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text"
                           class="form-control"
                           id="postTitle"
                           name="postTitle"
                           placeholder="Title"
                           autocomplete="off"
                           required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="postBody" class="col-lg-2 control-label">Body</label>
                <div class="col-lg-10">
                    <textarea class="form-control"
                              rows="5"
                              name="postBody"
                              id="postBody"
                              placeholder="Body"
                              required="required"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="tags" class="col-lg-2 control-label">Tags</label>
                <div class="col-lg-10">
                    <textarea class="form-control"
                              rows="2"
                              name="tags"
                              id="tags"
                              placeholder="tag1,tag2,tag3 ..."
                              required="required"></textarea>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <a href="<?= \Framework\Core\Config::APP_ROOT; ?>/posts" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary" name="createPost">Create</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>