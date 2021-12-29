<?= snippet('header') ?>

<?php if ($events->count()) : ?>
  <h2>Cette semaine à la flèche</h2>
  <div class="events-container">
    <?php foreach ($events as $event) : ?>
      <?= snippet('event_card', ['event' => $event]) ?>
    <?php endforeach; ?>
  </div>
<?php endif ?>

<?= $page->htmlcontent()->kt(); ?>

<?= snippet('footer') ?>