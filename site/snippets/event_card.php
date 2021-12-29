<div class="event">
  <?php if ($cover = $event->vignette()->toImage()) : ?>
    <!-- extract src attribute from HTML string -->
    <?php preg_match('/src="([^"]+)"/', $cover->clip(), $src); ?>
    <?php if (isset($src[1])) : ?>
      <img data-src="<?= $src[1] ?>" class="lazyload">
    <?php else : ?>
      <?= $cover->clip() ?>
    <?php endif ?>
  <?php endif ?>

  <div class="overlay">
    <div><?= $event->debut()->toDate('%d/%m') ?></div>
    <div>
      <?php $minutes = $event->opentime()->toDate('%M') ?>
      <!-- Display 17H instead of 17h00 -->
      <?= $event->opentime()->toDate('%HH') . ($minutes == '00' ? '' : $minutes) ?>
    </div>
  </div>
</div>

<!-- TODO make filters work
  <?php foreach ($event->filters()->toData() as $filter) : ?>
    <?= $filter ?>
  <?php endforeach; ?>
  -->