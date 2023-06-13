<div class="flash-container">
    <?php
    $messages = get_flash_messages();
    foreach ($messages as $message) {
        ?>
        <div id="<?= $message['id'] ?>"
             class="flash-message flash-<?= $message['type'] ?>"
             data-ttl="<?= $message['ttl'] ?>">
            <?= $message['message'] ?>
        </div>
        <?php
    }
    ?>
</div>