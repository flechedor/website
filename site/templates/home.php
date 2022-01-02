<?= snippet('header') ?>

<div class="events-container" id="events" style="display:none">
  <?php if ($events->count()) : ?>
    <?php foreach ($events as $event) : ?>
      <?= snippet('event_card', ['event' => $event]) ?>
    <?php endforeach; ?>
  <?php else : ?>
    <p class="empty">Aucun événement programmé</p>
  <?php endif ?>
</div>


<?= $page->htmlcontent()->kt(); ?>

<script>
  document.getElementById('next-events').after(document.getElementById('events'))
  document.getElementById('events').style.display = "flex"
</script>

<?= snippet('footer') ?>