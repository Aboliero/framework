<?php
/**
* @var string $content
* @var UserPanelWidget $this
*/
?>

<?php if ($this->app->user->isAuthenticated()) { ?>
    Вы зашли под логином <b><?= $this->app->user->getModel()->username ?></b>
    <a href="/authentication/changePassword"><small>[Редактировать]</small></a><br>
    <a href="/authentication/logout">[Выйти из профиля]</a><br>
<?php } else { ?>
    <a href="/authentication/login">Войти на сайт</a><br>
<?php } ?>
