<?php
/**
 * @var string $content
 */
?>
Меню:
<a href="/city/list">Список городов</a>
<a href="/country/list">Список стран</a>
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
<a href="/authentication/login">Войти на сайт</a>
Контакты - в разработке