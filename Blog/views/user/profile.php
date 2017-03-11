<?php /** @var $user \Blog\Models\Entities\UserEntity */ ?>
<?php $user = $this->getData()["user"]; ?>
<div class="col-md-9">
    <h1 class="h2">Your Profile</h1>
    <hr>
    <table class="table table-bordered table-responsive">
        <thead>
        <tr>
            <th colspan="2">Your Details</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Username</td>
            <td><strong><?= renderInView($user->getUsername()) ?></strong></td>
        </tr>
        <tr>
            <td><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Name</td>
            <td><strong><?= renderInView($user->getName()) ?></strong></td>
        </tr>
        <tr>
            <td><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Email</td>
            <td><strong><?= renderInView($user->getEmail()) ?></strong></td>
        </tr>
        <tr>
            <td><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Role</td>
            <td><strong><?= renderInView(ucfirst($user->getRole())) ?></strong></td>
        </tr>
        <tr>
            <td><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Registration date</td>
            <td><?= renderInView($user->getCreatedOn()) ?></td>
        </tr>
        <tr>
            <?php /** @var $templates \Blog\Models\Entities\TemplateEntity[] */ ?>
            <?php $templates = $this->getData()["templates"]; ?>
            <td><span class="glyphicon glyphicon-picture" aria-hidden="true"></span> Site Template</td>
            <td>
                <form class="form-inline" method="post" action="<?= \Framework\Core\Config::APP_ROOT; ?>/user/template">
                    <select class="form-control" name="template" id="template" title="Templates">
                        <?php foreach ($templates as $template): ; ?>
                            <option value="<?= $template->getId(); ?>"
                                <?php if ($user->getTemplateFile() === $template->getCssFile()) : ; ?>
                                    <?= " selected='true'"; ?>
                                <?php endif; ?>>
                                <?= ucfirst($template->getName()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input class="btn btn-success" type="submit" value="Update">
                </form>
            </td>
        </tr>
        </tbody>
    </table>
</div>