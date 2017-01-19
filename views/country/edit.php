<?php
/**
 * @var Country $country
 * @var bool $isSaved
 */

?>
<form method="post">
    <label for="name">Название</label><br>
    <input name="name" id="name" value="<?= $country->name ?>"><br>
    <label for="area">Площадь</label><br>
    <input name="area" id="area" value="<?= htmlspecialchars($country->area) ?>"><br>
    <label for="citysum">Количество городов</label><br>
    <input name="citysum" id="citysum" value="<?= $country->citysum ?>"><br>
    <label for="capitalId">Столица</label><br>
    <select name="capitalId" id="capitalId">
        <?php foreach ($country->getCities() as $city) { ?>
            <option <?= $city->id == $country->capitalId ? 'selected' : '' ?> value="<?= htmlspecialchars($city->id) ?>"><?= htmlspecialchars($city->name) ?></option> <!-- id - что посылает мащин. name - что видить чиляфек -->
        <?php } ?>
        <option value="">Не выбирать</option>
    </select>
    <br>
    <br>

    <button type="submit" name="submit" value="1">Отправить</button> <!-- пame это ключ, value - значение -->
</form>
<?php if ($isSaved) { ?>
    <strong>Сохранено</strong> <br>

<? } ?>

<br>

<a href="/country/list">Вернуться к списку стран</a>
