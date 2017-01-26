<script
    src="https://code.jquery.com/jquery-3.1.1.slim.min.js"
    integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc="
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