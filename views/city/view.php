<?php
/**
 * @var array[] $city
 */

?>
Город: "<?= $city['name'] ?>"<br>
Население: <?= $city['population'] ?> чел.<br>
Дата создания: <?= !$city['creationDate'] ? 'неизвестна' : $city['creationDate'] ?><br>
Уровень безработицы: <?= $city['unemploymentRate'] * 100 ?>%
