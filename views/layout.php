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
<?php if ($this->app->session->isUserAuthenticated) {?>
    <?php $authenticatedUserId = $this->app->session->authenticatedUserId; ?>
    <?php $query = new Query($this->app->db); ?>
    <?php $query->select('username')->from('authentic')->where(['=', 'id', $authenticatedUserId]); ?>
    <?php $authenticatedUserName = $query->getRow(); ?>
    <?= 'Вы зашли под логином ' . $authenticatedUserName['username'] ?> <br>
<?php } else {?>
<?= '<a href="/authentication/login">Войти на сайт</a>' ?>
<?php } ?>
<?= '<a href="/">Контакты - в разработке</a>' ?>