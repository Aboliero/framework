<?php
/**
* @var Country[] $countries
 */

foreach ($countries as $country) {
    ?><a href="/country/view?id=<?= urlencode($country->id) ?>"><?= $country->name ?></a> —
      <a href="/country/edit?id=<?= urlencode($country->id) ?>"><small>Редактировать</small></a>
      <a href="/country/delete?id=<?= urlencode($country->id) ?>"><small>Удалить</small></a><br>
    <?
} ?>
<br><br><br>
<a href="/country/add"><b>Добавить новую страну</b></a>

