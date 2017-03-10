<div class="col-md-9">
    <h1 class="h2">Create post:</h1>
    <hr>
    <form class="form-horizontal" method="post" action="<?=\Framework\Core\Config::APP_ROOT;?>/posts/add">
        <fieldset>
            <div class="form-group">
                <label for="postTitle" class="col-lg-2 control-label">Title
                </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="Title"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="postBody" class="col-lg-2 control-label">Body</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="postBody" name="postBody" placeholder="Body"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary" name="createPost">Create</button>
                    <button type="reset" class="btn btn-default">Cancel</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>