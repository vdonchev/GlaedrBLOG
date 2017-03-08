<div class="col-md-9">
    <form class="form-horizontal" method="post" action="<?=\Framework\Core\Config::APP_ROOT;?>/user/login">
        <fieldset>
            <legend>Login</legend>
            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Username
                </label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-10">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                           autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>