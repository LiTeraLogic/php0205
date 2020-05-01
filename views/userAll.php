<?php
/**
 * @var \App\models\User[] $users
 */
?>
<?php foreach ($users as $user) : ?>
    <h1>
        <a href="?c=user&a=one&id=<?= $user->getId()?>">
            <?= $user->getLogin()?>
        </a>
    </h1>
    <p>
        <?= $user->getAddress()?>
    </p>
    <p>
        <?= $user->getTel()?>
    </p>
    <hr>
<?php endforeach; ?>