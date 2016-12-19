<?php
/**
 * @var City $city
 * @var Country[] $countries
 * @var bool $isSaved
 */


$form = new Form($city);
?>

<?= $form->open('post') ?>
    <?= $form->label('name') ?><br>
    <?= $form->input('name') ?><br>
    <?= $form->label('population') ?><br>
<!--    <label for="population">Население</label><br>-->
    <?= $form->input('population') ?><br>
    <label for="creationDateObject">Дата создания</label><br>
    <?= $form->dateInput('creationDateObject') ?>Укажите в формате дд.мм.гггг<br>
    <label for="unemploymentRate">Уровень безработицы</label><br>
    <input name="unemploymentRate" id="unemploymentRate" value="<?= $city->unemploymentRate * 100 ?>"><br>
    <label for="countryId">Страна</label><br>
    <select name="countryId" id="countryId">
        <?php foreach ($countries as $country) { ?>
            <option <?= $country->id == $city->countryId ? 'selected' : '' ?> value="<?= htmlspecialchars($country->id) ?>"><?= htmlspecialchars($country->name) ?></option> <!-- id - что посылает мащин. name - что видить чиляфек -->
        <?php } ?>
    </select>
    <br>
    <br>

    <button type="submit" name="submit" value="1">Отправить</button> <!-- пame это ключ, value - значение -->
<?= $form->close() ?>
<?php if ($isSaved) { ?>
    <strong>Сохранено</strong> <br>
    
<? } ?>
    
<br>

<a href="/city/list">Вернуться к списку городов</a>