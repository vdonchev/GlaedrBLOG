<?php $allMessages = $this->getSession()->getMessages(); ?>
<?php if (isset($allMessages)): ; ?>
    <?php foreach ($allMessages as $type => $messages): ; ?>
        <?php foreach ($messages as $msg): ; ?>
            <div class="alert alert-dismissable alert-<?= $type ?>" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <?= $msg; ?>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>
