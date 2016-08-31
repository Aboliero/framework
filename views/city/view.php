<?php
/**
 * @var array[] $city
 */

?>
Город: "<?= htmlspecialchars($city['name']) ?>"<br>
Население: <?= htmlspecialchars($city['population']) ?> чел.<br>
Дата создания: <?= !htmlspecialchars($city['creationDate']) ? 'неизвестна' : htmlspecialchars($city['creationDate']) ?><br>
Уровень безработицы: <?= $city['unemploymentRate'] * 100 ?>%<br>
Страна: "<?= htmlspecialchars($city['countryName']) ?>"<br>
<br>
<br>
    <a href="/city/edit?id=<?= urlencode($city['id']) ?>"><small>Редактировать</small></a> <br>
<br>
<a href="/city/list">Вернуться к списку городов</a>