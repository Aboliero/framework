<?php

/** @var string[] $numbers */
/** @var string[] $errors */

?>
<form method="post">
    <textarea name="numbers"></textarea><br>
    <button type="submit">Отправить</button>
</form>
<hr>
<?php if ($errors) { ?>
    Произошли ошибки: <br>
    <?= join('<br>', $errors) ?>
<?php } elseif (isset($numbers)) {?>
    <?= join(' ', $numbers) ?>
<?php } ?>
<br>
<a href="/city/list">Вернуться к списку городов</a>