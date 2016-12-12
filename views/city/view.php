<?php
/**
 * @var City $city
 * @var Country $country
 */

?>
Город: "<?= htmlspecialchars($city->name) ?>"<br>
Население: <?= htmlspecialchars($city->population) ?> чел.<br>
Дата создания: <?= !$city->creationDateObject ? 'неизвестна' : htmlspecialchars($city->creationDateObject->format('d.m.Y')) ?><br>
Уровень безработицы: <?= $city->unemploymentRate * 100 ?>%<br>
Страна: "<?= htmlspecialchars($city->getCountry()->name) ?>"<br>
<br>
<br>
    <a href="/city/edit?id=<?= urlencode($city->id) ?>"><small>Редактировать</small></a> <br>
<br>
<a href="/city/list">Вернуться к списку городов</a>
<br>
<br>
<a href="/country/list">Перейти к списку стран</a>