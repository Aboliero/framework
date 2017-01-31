<?php
/**
 * @var City $city
 */


$form = new Form($city);

?>

<?= $form->open('post') ?>
    <?= $form->label('name') ?><br>
    <?= $form->input('name') ?><br>
    <?= $form->label('population') ?><br>
    <?= $form->input('population') ?><br>
    <?= $form->label('creationDateObject') ?> <br>
    <?= $form->dateInput('creationDateObject') ?>Укажите в формате дд.мм.гггг<br>
    <?= $form->label('unemploymentRate') ?><br>
    <?= $form->unemployInput('unemploymentRate') ?> <br>
    <?= $form->label('countryId') ?><br>
    <?= $form->select('countryId', Helpers::getMap($city->getCountries(), 'id', 'name')) ?>

    <br>
    <br>

    <button type="submit" name="submit" value="1">Отправить</button> <!-- пame это ключ, value - значение -->
<?= $form->close() ?>
    
<br>

<a href="/city/list">Вернуться к списку городов</a>