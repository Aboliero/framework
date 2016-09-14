<?php
/**
 * @var
 * @var array[] $cities
 */
?>
<?php if (isset($_GET['addedCityId'])) { ?>
    <strong>ВНЕМАНИЕ!!! ГОРАД ДАБАВЛИН!!!</strong> <br>
    <a href="/city/edit?id=<?= urlencode($_GET['addedCityId']) ?>">Редактировать новый город</a>
    <br>
    <br>
<?php } ?>

<h4>Список городов</h4>
<?php foreach ($cities as $city) {
    ?><a href="/city/view?id=<?= urlencode($city['id']) ?>"><?= $city['name'] ?></a> —
    <a href="/city/edit?id=<?= urlencode($city['id']) ?>"><small>Редактировать</small></a> <br><?
} ?> <br>
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