<?php
/**
 * @var string $content
 * @var Controller $this
 */
?>

Меню:
<a href="/city/list" style="margin-right: 15px">Список городов</a>
<a href="/country/list" style="margin-right: 15px">Список стран</a>
<a href="/">Главная страница</a>
<hr>

<?php if ($messages = $this->app->flashMessages->getAll()) { ?>
    <?php foreach ($messages as $message) { ?>
        <?= $message ?> <br>
    <?php } ?>
    <hr>
<?php } ?>
<?= $content ?>

<hr>
<?= $this->simpleRender('userPanel') ?>