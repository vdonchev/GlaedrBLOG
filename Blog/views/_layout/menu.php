<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?=\Framework\Core\Config::APP_ROOT;?>/home" class="navbar-brand">
                <span class="glyphicon glyphicon-book" aria-hidden="true"></span> Gleadr Blog
            </a>
        </div>
        <form class="navbar-form navbar-left" role="search" method="post"
              action="<?= \Framework\Core\Config::APP_ROOT; ?>/search">
            <div class="form-group">
                <input type="text" name="searchTag" class="form-control" placeholder="Find posts by tag">
            </div>
            <button type="submit" class="btn btn-default" name="search">Search</button>
        </form>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/home">Home</a></li>
                <?php if (!$this->isAuthorized()) : ?>
                    <li><a href="<?= \Framework\Core\Config::APP_ROOT; ?>/user/login">Login</a></li>
                    <li><a href="<?= \Framework\Core\Config::APP_ROOT; ?>/user/register">Register</a></li>
                <?php else: ?>
                    <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/user/profile">Profile</a></li>
                    <?php if ($this->isAdmin()) : ?>
                        <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/posts/add">Add post</a></li>
                    <?php endif; ?>

                    <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/user/logout">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>