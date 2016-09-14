<?php
/**
* @var array[] $countries
 */

foreach ($countries as $country) {
    ?><a href="/country/view?id=<?= urlencode($country['id']) ?>"><?= $country['name'] ?></a> —
    <a href="/country/edit?id=<?= urlencode($country['id']) ?>"><small>Редактировать</small></a> <br><?
} ?>
<br> <a href="/city/list">К списку городов</a>
<br>
<br>
<a href="/"><b>На главную</b></a>