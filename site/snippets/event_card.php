<a class="event" data-filters="<?= $event->filters() ?>" href="<?= $event->url() ?>">
  <?php if ($cover = $event->vignette()->toImage()) : ?>
    <!-- extract src attribute from HTML string -->
    <?php preg_match('/src="([^"]+)"/', $cover->clip(), $src); ?>
    <?php if (isset($src[1])) : ?>
      <img src="<?= $src[1] ?>">
    <?php else : ?>
      <?= $cover->clip() ?>
    <?php endif ?>
  <?php endif ?>

  <div class="overlay">
    <div><?= $event->title() ?></div>
    <div><?= $event->formatedDate() ?></div>
    <div><?= $event->formatedTime() ?></div>
  </div>
</a>