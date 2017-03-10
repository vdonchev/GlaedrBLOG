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
                    <textarea class="form-control" rows="5" id="postBody" data-gramm="true" data-txt_gramm_id="9e48ac4c-c047-baf8-838a-2751c15854ee" data-gramm_id="9e48ac4c-c047-baf8-838a-2751c15854ee" spellcheck="false" data-gramm_editor="true" style="z-index: auto; position: relative; line-height: 21.4286px; font-size: 15px; transition: none; background: transparent !important; resize: none"></textarea>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary" name="createPost">Create</button>
                    <button type="submit" class="btn btn-default" name="cancelAdding">Cancel</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>