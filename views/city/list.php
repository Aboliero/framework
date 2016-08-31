<?php
/**
 * @var array[] $cities
 */

foreach ($cities as $city) { 
    ?><a href="/city/view?id=<?= urlencode($city['id']) ?>"><?= $city['name'] ?></a> —
    <a href="/city/edit?id=<?= urlencode($city['id']) ?>"><small>Редактировать</small></a> <br><?
} ?> <br>
<a href="/"><b>На главную</b></a>