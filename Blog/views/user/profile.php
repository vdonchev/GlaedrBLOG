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
            <td><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Role</td>
            <td><strong><?= renderInView(ucfirst($user->getRole())) ?></strong></td>
        </tr>
        <tr>
            <td><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Registration date</td>
            <td><?= renderInView($user->getCreatedOn()) ?></td>
        </tr>
        </tbody>
    </table>
</div>