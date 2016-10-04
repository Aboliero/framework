<?php if ($this->app->session->isUserAuthenticated) {?>
    <?php $query = new Query($this->app->db); ?>
    <?php $query->select('username')->from('authentic')->where(['=', 'id', $this->app->session->authenticatedUserId]); ?>
    <?php $authenticatedUser = $query->getRow(); ?>
    Вы зашли под логином <b><?= $authenticatedUser['username'] ?></b>
    <a href="/authentication/profile"><small>[Редактировать]</small></a><br>
    <a href="/authentication/logout">[Выйти из профиля]</a><br>
<?php } else { ?>
    <a href="/authentication/login">Войти на сайт</a><br>
<?php } ?>
