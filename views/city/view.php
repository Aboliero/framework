<?php
/**
 * @var array[] $city
 */

?>
Город: "<?= htmlspecialchars($city['name']) ?>"<br>
Население: <?= htmlspecialchars($city['population']) ?> чел.<br>
Дата создания: <?= !htmlspecialchars($city['creationDate']) ? 'неизвестна' : htmlspecialchars($city['creationDate']) ?><br>
Уровень безработицы: <?= $city['unemploymentRate'] * 100 ?>%<br>
<br>
<br>
<a href="/city/list">Вернуться к списку городов</a>