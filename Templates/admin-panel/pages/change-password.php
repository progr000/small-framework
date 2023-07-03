<?php
/** @var $view Core\ViewDriver */
/** @var $users Models\User[] */

$vars['title'] = __('Change password');

$errors = request_errors();
?>

<form method="post" action="<?= url('/admin-panel/change-password') ?>">
    <div class="ad-panel-content active">
        <div class="narrow-center">
            <h2><?= $vars['title'] ?></h2>
            <input type="hidden" name="csrf" value="<?= csrf() ?>">

            <input type="password"
                   name="old_password"
                   value="<?= old('old_password') ?>"
                   placeholder="<?= __('Old password') ?>"
                   data-off-required="required"
                   aria-label="">
            <?php if (isset($errors['old_password'])) { ?>
                <div class="request-error">
                    <?= implode(", ", $errors['old_password']) ?>
                </div>
            <?php } ?>

            <input type="password"
                   name="password"
                   value="<?= old('password') ?>"
                   placeholder="<?= __('New password') ?>"
                   data-off-required="required"
                   aria-label="">
            <?php if (isset($errors['password'])) { ?>
                <div class="request-error">
                    <?= implode(", ", $errors['password']) ?>
                </div>
            <?php } ?>

            <input type="password"
                   name="repeat_password"
                   value="<?= old('repeat_password') ?>"
                   placeholder="<?= __('Repeat new password') ?>"
                   data-off-required="required"
                   aria-label="">
            <?php if (isset($errors['repeat_password'])) { ?>
                <div class="request-error">
                    <?= implode(", ", $errors['repeat_password']) ?>
                </div>
            <?php } ?>

            <button><?= __('Change') ?></button>
        </div>
    </div>
</form>
