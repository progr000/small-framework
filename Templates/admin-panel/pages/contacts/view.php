<?php
/** @var $view Core\ViewDriver */
/** @var $contact Models\Contact */

$vars['title'] = 'Contact id=' . $contact->id;
?>
<div class="ad-panel-content active">
    <h2>Info about Contact: <?= $contact->name ?></h2>

    <a href="<?= url("/admin-panel/contacts") ?>">&lt;&lt;&lt;Zurück</a>
    <table class="list-of-something">
        <tr><td>Id:</td><td><?= $contact->id ?></td></tr>
        <tr><td>Datum:</td><td><?= $contact->created_at ?></td></tr>
        <tr><td>Name:</td><td><?= $contact->name ?></td></tr>
        <tr><td>E-Mail:</td><td><?= $contact->email ?></td></tr>
        <tr><td>Nummer:</td><td><?= $contact->phone ?></td></tr>
        <tr><td>Thema:</td><td><?= $contact->subject ?></td></tr>
        <tr><td>Mitteilung:</td><td><?= nl2br($contact->msg) ?></td></tr>
    </table>

</div>