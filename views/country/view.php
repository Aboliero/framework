<?php
/**
 * @var array[] $country
 */

?>
Страна: "<?= htmlspecialchars($country['name']) ?>"<br>
Площадь: <?= htmlspecialchars($country['area']) ?> км.кв.<br>
Количество городов: <?= $country['citysum'] ?><br>
Столица: "<?php if (is_null($country['capitalId'])) {?>
    <?= "Не указана";} ?>
<?= htmlspecialchars($country['capitalId']) ?>"<br>
<br>
<br>
<a href="/city/edit?id=<?= urlencode($country['id']) ?>"><small>Редактировать</small></a> <br>
<br>
<br><a href="/country/list">Вернуться к списку стран</a>
<br><a href="/city/list">К списку городов</a>
