<?php
/**
* @var array[] $countries
 */

foreach ($countries as $country) {
    ?><a href="/country/view?id=<?= urlencode($country['id']) ?>"><?= $country['name'] ?></a><br>
    <?
} ?>

<!-- <a href="/country/edit?id=<?= urlencode($country['id']) ?>"><small>Редактировать</small></a> <br> -->
