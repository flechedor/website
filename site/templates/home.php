<?= snippet('header') ?>
<?php
$text = $page->htmlcontent()->kt();
$test = preg_match('/<h1>(.*)<\/h1>/', $text, $matches);
if($test) {
  $h1 = $matches[1];
  $text = trim(str_replace('<h1>'.$h1.'</h1>', '', $text));
} else {
  $h1 = $page->title();
}
$ids = explode('/', $page->id());
?>
  <main class="container-xl">
	
    <h1><?= $h1 ?></h1>
    <section class="section_<?= array_pop($ids) ?>">
      <div class="presentation">
        <?= $text ?>
      </div>

      <?php if($events->count()): ?>
      <hr>
      <h2>les prochains événements</h2>
      <div class="events">
        <?php foreach($events as $event): ?>
        <div class="event">
          <div class="event-container">
            <span class="date"><?= html_entity_decode($event->formatDate()) ?></span>
            <?php if($event->reservations()->value() != "sans réservation"): ?>
              <div class="ribbon">
                <span class="<?= $reservations[$event->reservations()->value()]['class'] ?>"><?= $reservations[$event->reservations()->value()]['text'] ?></span>
              </div>
            <?php endif ?>
            <div class="content">
              <?php if($cover = $event->vignette()->toImage()): ?>
                <a href="<?= $event->url() ?>" class="event-open">
                  <figure>
                    <?= $cover->clip(480,360) ?>
                  </figure>
                </a>
                <div class="title">
              <?php elseif($cover = $event->cover()->toFile()): ?>
                  <a href="<?= $event->url() ?>" class="event-open">
                    <figure>
                      <?= $cover->thumb([
                        'width' => 480,
                        'height' => 360,
                        'crop' => true,
                      ])->html() ?>
                    </figure>
                  </a>
                  <div class="title">
              <?php else: ?>
                <div class="title title-alone">
              <?php endif ?>

                <a href="<?= $event->url() ?>" class="event-open">
                  <h3><?= $event->title() ?></h3>
                  <?php if($event->headline()->isNotEmpty()): ?>
                    <p class="headline"><?= $event->headline()->html() ?></p>
                  <?php endif; ?>
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif ?>
    </section>

  </main>

<?= snippet('footer') ?>