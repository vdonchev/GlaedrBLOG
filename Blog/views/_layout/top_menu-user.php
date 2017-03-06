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
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/home">Home</a></li>
                <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/user/profile">Profile</a></li>
                <li><a href="<?=\Framework\Core\Config::APP_ROOT;?>/user/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>