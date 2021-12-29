<?php snippet('header'); ?>

<div class="events-container">
  <?php if (count($events)) : ?>
    <?php foreach ($events as $event) : ?>
      <?= snippet('event_card', ['event' => $event]) ?>
    <?php endforeach ?>
  <?php else : ?>
    <p class="empty">Aucun événement programmé.</p>
  <?php endif; ?>
</div>

<?= snippet('footer') ?>