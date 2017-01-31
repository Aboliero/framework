<?php
/**
* @var Country[] $countries
 */

foreach ($countries as $country) {
    ?><a href="/country/view?id=<?= urlencode($country->id) ?>"><?= $country->name ?></a> —
      <a href="/city/ajaxView?id=<?= urlencode($country->capitalId)?>" class="capital"><small>Столица</small></a>
      <a href="/country/edit?id=<?= urlencode($country->id) ?>"><small>Редактировать</small></a>
      <a href="/country/delete?id=<?= urlencode($country->id) ?>"><small>Удалить</small></a><br>
    <?
} ?>
<br><br><br>
<a href="/country/add"><b>Добавить новую страну</b></a>
<div id="popup" style="position: absolute; top: 0; right: 0; display: none; background: white; border: 2px solid black;"></div>

<script>
    $(function () {
        var $popup = $('#popup');
        $('.capital').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax(url).done(function (response) {
                $popup.html(response).css('display', 'block');
            });
        });
    });
</script>