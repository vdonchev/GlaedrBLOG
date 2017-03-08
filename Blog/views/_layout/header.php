<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?=\Framework\Core\Config::APP_ROOT;?>/public/styles/bootstrap.min.css">
    <script src="<?=\Framework\Core\Config::APP_ROOT;?>/public/js/jquery-3.1.1.min.js"></script>
    <script src="<?=\Framework\Core\Config::APP_ROOT;?>/public/js/bootstrap.min.js"></script>
    <script src="<?=\Framework\Core\Config::APP_ROOT;?>/public/js/scripts.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gleadr Blog</title>
</head>
<body>

<?php if (!$this->isAuthorized()) : ?>
    <?php include_once "top_menu-guest.php"; ?>
<?php else: ?>
    <?php if ($this->isAdmin()) : ?>
        <?php include_once "top_menu-admin.php"; ?>
    <?php else: ?>
        <?php include_once "top_menu-user.php"; ?>
    <?php endif; ?>
<?php endif; ?>

<div class="container">
<?php include_once "messages.php"; ?>
    <div class="row">