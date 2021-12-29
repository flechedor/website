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

<script>
  document.querySelectorAll('.event-filter').forEach(filter => {
    filter.addEventListener('click', function() {
      if (this.classList.contains('active')) {
        // Reset filters
        this.classList.remove('active')
        document.querySelectorAll('.event').forEach((event) => {
          event.style.display = "block"
        })
      } else {
        // Filter events
        document.querySelectorAll('.event-filter').forEach(otherFilter => otherFilter.classList.remove('active'))
        this.classList.add('active')

        document.querySelectorAll('.event').forEach((event) => {
          event.style.display = event.dataset['filters'].includes(this.dataset['filter']) ? "block" : "none"
        })
      }
    })
  })
</script>

<?= snippet('footer') ?>