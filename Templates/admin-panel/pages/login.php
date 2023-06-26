<?php
/** @var $view Core\ViewDriver */

$vars['title'] = 'Login';
$errors = request_errors();
?>
<form method="post" action="<?= url('/admin-panel/login') ?>">
    <div class="admin-login-content">
        <h2>Admin System</h2>
        <input type="hidden" name="csrf" value="<?= csrf() ?>">
        <input type="text"
               name="username"
               value="<?= old('username') ?>"
               placeholder="Login"
               data-required="required"
               aria-label=""/>
        <?php if (isset($errors['username'])) { ?>
            <div style="color: red">
                <?= implode(", ", $errors['username']) ?>
            </div>
        <?php } ?>
        <input type="password" name="password" placeholder="Password" data-required="required" aria-label=""/>
        <?php if (isset($errors['password'])) { ?>
            <div style="color: red">
                <?= implode(", ", $errors['password']) ?>
            </div>
        <?php } ?>
        <button type="submit">Continue</button>
    </div>
</form>
