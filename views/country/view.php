<?php
/**
 * @var Country $country
 */

?>
Страна: "<?= htmlspecialchars($country->name) ?>"<br>
Площадь: <?= htmlspecialchars($country->area) ?> км.кв.<br>
Количество городов: <?= $country->citysum ?><br>
Столица: "<?= $country->getCapital() ? htmlspecialchars($country->getCapital()->name) : 'Не указана' ?>"<br>
<br>
<br>
<a href="/country/edit?id=<?= urlencode($country->id) ?>"><small>Редактировать</small></a> <br>
<br>
<br><a href="/country/list">Вернуться к списку стран</a>
<br><a href="/city/list">К списку городов</a>
