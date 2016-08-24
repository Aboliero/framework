<?php
/**
 * @var array[] $city
 * @var bool $isSaved
 */
?>
<form method="post">
    <label for="name">Название</label><br>
    <input name="name" id="name" value="<?= htmlspecialchars($city['name']) ?>"><br>
    <label for="population">Население</label><br>
    <input name="population" id="population" value="<?= htmlspecialchars($city['population']) ?>"><br>
    
    <button type="submit" name="submit" value="1">Отправить</button> <!-- пame это ключ, value - значение -->
</form>
<?php if ($isSaved) { ?>
    <strong>Сохранено</strong> <br>
<? } ?>
    
<br>
<a href="/city/list">Вернуться к списку городов</a>


<?php
/**
<!--
    <label for="creationDate">Дата создания</label><br>
    <input name="creationDate" id="creationDate" value="<?= !$city['creationDate'] ? 'неизвестна' : $city['creationDate'] ?>"><br>
    <label for="unemploymentRate">Уровень безработицы</label><br>
    <input name="unemploymentRate" id="unemploymentRate" value="<?= $city['unemploymentRate'] * 100 ?>"><br> -->
*/