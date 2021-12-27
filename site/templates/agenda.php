<?php
snippet('header');
$ids = explode('/', $page->id());
?>
<main class="container-xl section_<?= array_pop($ids) ?>">
  <aside>
    <nav id="sections" class="sections">
      <ul class="filters">
        <li><a href="#" data-section="prochainement" class="<?php if($section == 'prochainement'):?> active<?php endif ?>">Prochainement</a></li>
        <li><a href="#" data-section="archives" class="<?php if($section == 'archives'):?> active<?php endif ?>">Archives</a></li>
      </ul>
    </nav>
    <ul id="filters" class="filters colors">
      <?php foreach($filters as $filter_name => $filter_color): ?>
        <li>
          <a href="#" style="color: <?= $filter_color ?>;" data-filter="<?= $filter_name ?>" class="filter <?php if($filter_name == $filter):?> active<?php endif ?>">
            <span class="color" style="background-color: <?= $filter_color ?>"></span>
            <?= $filter_name ?>
          </a>
        </li>
      <?php endforeach ?>
    </ul>
    <!--<ul id="reservations" class="filters reservations">
      <li><a href="#" data-resa="sans réservation" class="resa <?php if($resa == "sans réservation"): ?>active<?php endif ?>">Sans réservation</a></li>
      <li><a href="#" data-resa="avec réservation" class="resa <?php if($resa == "avec réservation"): ?>active<?php endif ?>">Avec réservation</a></li>
    </ul>-->
  </aside>
  <section class="content">
    <h1><?= $page->title() ?></h1>
    <div id="events" class="events">
      <?php if(count($events)): ?>
      <div id="timeline" class="timeline">
          <?php foreach($events as $event): ?>
            <div data-vtdate="<?= $event->formatDate() ?>">
              <?php if($event->reservations()->value() != "sans réservation"): ?>
              <div class="ribbon">
                <span class="<?= $reservations[$event->reservations()->value()]['class'] ?>"><?= $reservations[$event->reservations()->value()]['text'] ?></span>
              </div>
              <?php endif ?>
              <div class="content">
                <ul class="filters"><?php foreach($event->filters()->toData() as $f): ?><li><span class="color" style="background-color: <?= $filters[$f] ?>"></span></li><?php endforeach; ?></ul>
                <?php if($cover = $event->cover()->toFile()): ?>
                <a href="<?= $event->url() ?>" class="event-open">
                  <figure>
                    <img data-src="<?= $cover->url() ?>" class="lazyload" alt="">
                  </figure>
                </a>
                <?php endif ?>
                <div class="title">
                  <a href="<?= $event->url() ?>" class="event-open">
                    <h3><?= $event->title() ?></h3>
                    <?php if($event->headline()->isNotEmpty()): ?>
                      <p class="headline"><?= $event->headline()->html() ?></p>
                    <?php endif; ?>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach ?>
      </div>
      <?php else: ?>
        <p class="empty">Aucun événement trouvé.</p>
      <?php endif; ?>
    </div>
  </section>
</main>
<script>
  $(function() {
    $('#sections a').click(function() {
      document.location.href = '<?= $page->url() ?>?section=' + $(this).data('section');
      return false;
    });
    $('#filters a').click(function() {
      if($(this).hasClass('active')) {
        document.location.href = '<?= $page->url() ?>?section=<?= $section ?>';
      } else {
        document.location.href = '<?= $page->url() ?>?section=<?= $section ?>' + '&filter=' + $(this).data('filter');
      }
      return false;
    });
    $('#reservations a.resa').click(function(e) {
      var url = '<?= $page->url() ?>?section=<?= $section ?>';
      <?php if(!empty($filter)): ?>
      url += '&filter=<?= $filter ?>';
      <?php endif; ?>
      if($(this).hasClass('active')) {
        document.location.href = url;
      } else {
        document.location.href = url + '&resa=' + $(this).data('resa');
      }
      return false;
    });
  });

</script>
<?= snippet('footer') ?>
