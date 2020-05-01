<?php
/**
 * @var App\models\Good[] $goods
 */
?>
<?php foreach ($goods as $good) : ?>
    <h1>
        <a href="?c=good&a=one&id=<?= $good->getId()?>">
            <?= $good->getNameGood()?>
        </a>
    </h1>
    <p>
        Price: <?= $good->getPrice()?> c.u.
    </p>
    <p>
        Infomation: <?= $good->getInfo()?>
    </p>
    <hr>
<?php endforeach; ?>