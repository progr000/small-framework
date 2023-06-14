<?php
/** @var Core\ViewDriver $view */
/** @var $users \Models\User[] */

$vars['title'] = 'Change password';

$errors = request_errors();
?>

<form method="post" action="/admin-panel/change-password">
    <div class="ad-panel-content active">
        <h2>Change password</h2>
        <input type="hidden" name="csrf" value="<?= csrf() ?>">

        <input type="password" name="old_password" value="<?= old('old_password') ?>" placeholder="Old password" data-off-required="required" aria-label="">
        <?php if (isset($errors['old_password'])) { ?>
            <div style="color: red">
                <?= implode(", ", $errors['old_password']) ?>
            </div>
        <?php } ?>

        <input type="password" name="password" value="<?= old('password') ?>" placeholder="New password" data-off-required="required" aria-label="">
        <?php if (isset($errors['password'])) { ?>
            <div style="color: red">
                <?= implode(", ", $errors['password']) ?>
            </div>
        <?php } ?>

        <input type="password" name="repeat_password" value="<?= old('repeat_password') ?>" placeholder="Repeat new password" data-off-required="required" aria-label="">
        <?php if (isset($errors['repeat_password'])) { ?>
            <div style="color: red">
                <?= implode(", ", $errors['repeat_password']) ?>
            </div>
        <?php } ?>

        <button>Change</button>
    </div>
</form>

