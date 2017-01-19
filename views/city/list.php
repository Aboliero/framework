<?php
/**
 * @var $this Controller
 * @var City[] $cities
 */
?>




<h4>Список городов</h4>
<?php foreach ($cities as $city) { ?>
    <a href="/city/view?id=<?= urlencode($city->id) ?>"><?= $city->name ?></a>
        <?php if ($this->app->user->isAuthenticated()) {?>
        — <a href="/city/edit?id=<?= urlencode($city->id) ?>"><small>Редактировать</small></a>
          <a href="/city/delete?id=<?= urlencode($city->id) ?>"><small>Удалить</small></a> <br>
        <?php } else { ?>
            <br>
            <?php } ?>
<?php } ?>
<br> <br>
<a href="/city/add"><b>Добавить новый город</b></a>