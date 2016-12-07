<?php
/** @var City $city */
?>
Вы действительно хотите удалить город <?= $city->name ?>? <br>
<br>

<form method="post">
    <button type="submit" name="confirm" value="1">Удалить</button>
    <button type="submit" name="cancel" value="1">Не удалить</button>
</form>
