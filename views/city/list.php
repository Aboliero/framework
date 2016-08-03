<?php
/**
 * @var array[] $cities
 */

foreach ($cities as $city) {
    ?><a href="/city/view?id=<?= $city['id'] ?>"><?= $city['name'] ?></a> <br><?
}