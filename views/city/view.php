<?php
/**
 * @var array[] $city
 */
$creationDate = is_null($city['creationDate']) ? null : DateTime::createFromFormat('Y-m-d', $city['creationDate']);
?>
Город: "<?= htmlspecialchars($city['name']) ?>"<br>
Население: <?= htmlspecialchars($city['population']) ?> чел.<br>
Дата создания: <?= is_null($creationDate) ? 'неизвестна' : htmlspecialchars($creationDate->format('d.m.Y')) ?><br>
Уровень безработицы: <?= $city['unemploymentRate'] * 100 ?>%<br>
Страна: "<?= htmlspecialchars($city['countryName']) ?>"<br>
<br>
<br>
    <a href="/city/edit?id=<?= urlencode($city['id']) ?>"><small>Редактировать</small></a> <br>
<br>
<a href="/city/list">Вернуться к списку городов</a>
<br>
<br>
<a href="/country/list">Перейти к списку стран</a>