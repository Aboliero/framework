<?php
/**
 * @var $this Controller
 * @var array[] $cities
 */
?>




<h4>Список городов</h4>
<?php foreach ($cities as $city) { ?>
    <a href="/city/view?id=<?= urlencode($city['id']) ?>"><?= $city['name'] ?></a> —
    <a href="/city/edit?id=<?= urlencode($city['id']) ?>"><small>Редактировать</small></a>
    <a href="/city/delete?id=<?= urlencode($city['id']) ?>"><small>Удалить</small></a> <br>
<?php } ?>
<br> <br>
<a href="/city/add"><b>Добавить новый город</b></a>