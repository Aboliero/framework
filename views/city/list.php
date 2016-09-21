<?php
/**
 * @var $this Controller
 * @var array[] $cities
 */
?>
<?php if ($messages = $this->app->flashMessages->getAll()) { ?>
    <?php foreach ($messages as $message) { ?>
        <?= $message ?> <br>
    <?php } ?>
    <br>
    <br>
<?php } ?>

<?php if (isset($_GET['deletedCityName'])) { ?>
    <strong>ВНЕМАНИЕ!!! ГОРАД <?= $_GET['deletedCityName'] ?> УДАЛЁН!!!</strong> <br>
    <br>
    <br>
<?php } ?>

<h4>Список городов</h4>
<?php foreach ($cities as $city) { ?>
    <a href="/city/view?id=<?= urlencode($city['id']) ?>"><?= $city['name'] ?></a> —
    <a href="/city/edit?id=<?= urlencode($city['id']) ?>"><small>Редактировать</small></a>
    <a href="/city/delete?id=<?= urlencode($city['id']) ?>"><small>Удалить</small></a> <br>
<?php } ?>
<br> <br>
<br>
<br>
<br> <a href="/country/list">К списку стран</a>
<br>
<br>
<a href="/"><b>На главную</b></a>
<br>
<br>
<br>
<br>
<br>
<a href="/city/add"><b>Добавить новый город</b></a>