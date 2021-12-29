<?= snippet('header') ?>

<?php if ($events->count()) : ?>
  <div class="events-container" id="events" style="display:none">
    <?php foreach ($events as $event) : ?>
      <?= snippet('event_card', ['event' => $event]) ?>
    <?php endforeach; ?>
  </div>
<?php endif ?>

<?= $page->htmlcontent()->kt(); ?>

<script>
  document.getElementById('next-events').after(document.getElementById('events'))
  document.getElementById('events').style.display = "flex"
</script>

<?= snippet('footer') ?>