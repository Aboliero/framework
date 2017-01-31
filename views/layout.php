<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous">
</script>

<?php
/**
 * @var string $content
 * @var Controller $this
 */
?>

Меню:
<a href="/city/list" style="margin-right: 15px" class="cities">Список городов</a>
<a href="/country/list" style="margin-right: 15px">Список стран</a>
<a href="/">Главная страница</a>
<hr>

<?php if ($messages = $this->app->flashMessages->getAll()) { ?>
    <?php foreach ($messages as $message) { ?>
        <?= $message ?> <br>
    <?php } ?>
    <hr>
<?php } ?>
<?= $content ?>

<hr>
<?php $widget = new UserPanelWidget($this->app); ?>
<?= $widget->run() ?>

<hr>
<a href="/demo/jsTest">test</a>

<script src="/static/country-tooltip.js"></script>
<script>
    $(function () {
        var $tooltip = $('<div />').appendTo('body').css('display', 'none').css('position', 'absolute').css('background', 'white').css('border', '1px solid black');
        $('.country-tooltip')
            .on('mouseenter', function (e) {
                var id = $(this).data('country-id');
                var url = '/country/jsonGet?id=' + id;
                $.ajax(url, {dataType: 'json'}).done(function (country) {
                    $tooltip.css('display', 'block').text(country.name).css('top', e.clientY+16).css('left', e.clientX+16);
                })
            })
            .on('mouseleave', function () {
                $tooltip.hide().empty();
            })
            .on ('mousemove', function (e) {
                $tooltip.css('top', e.clientY+16).css('left', e.clientX+16);
            });
    });
</script>