<?php
/** @var Country $country */
?>
Вы действительно хотите удалить страну <?= $country->name ?>? <br>
<br>

<form method="post">
    <button type="submit" name="confirm" value="1">Удалить</button>
    <button type="submit" name="cancel" value="1">Не удалить</button>
</form>
