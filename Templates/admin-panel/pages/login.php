<?php
/** @var $view Core\ViewDriver */

$vars['title'] = __('Protected area');
$errors = request_errors();
?>
<form method="post" action="<?= url('/admin-panel/login') ?>">
    <div class="admin-login-content">
        <h2><?= __('Protected area') ?></h2>
        <input type="hidden" name="csrf" value="<?= csrf() ?>">
        <input type="text"
               name="username"
               value="<?= old('username') ?>"
               placeholder="<?= __('Login') ?>"
               data-required="required"
               aria-label=""/>
        <?php if (isset($errors['username'])) { ?>
            <div class="request-error">
                <?= implode(", ", $errors['username']) ?>
            </div>
        <?php } ?>
        <input type="password"
               name="password"
               placeholder="<?= __('Password') ?>"
               data-required="required"
               aria-label=""/>
        <?php if (isset($errors['password'])) { ?>
            <div class="request-error">
                <?= implode(", ", $errors['password']) ?>
            </div>
        <?php } ?>
        <button type="submit"><?= __('Enter') ?></button>
    </div>
</form>
