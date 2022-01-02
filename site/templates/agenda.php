<?php snippet('header'); ?>

<?php if (count($groupedEvents)) : ?>
  <?php foreach ($groupedEvents as $title => $events) : ?>
    <div class="events-container">
      <h2><?= $title ?></h2>
      <?php foreach ($events as $event) : ?>
        <?= snippet('event_card', ['event' => $event]) ?>
      <?php endforeach ?>
    </div>
  <?php endforeach ?>
<?php else : ?>
  <p class="empty">Aucun événement programmé</p>
<?php endif; ?>

<script>
  // Filter events by category
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

      // Hide empty events-container
      document.querySelectorAll('.events-container').forEach((eventsContainer) => {
        let show = eventsContainer.querySelectorAll('.event:not([style*="display:none"]):not([style*="display: none"])').length > 0
        eventsContainer.style.display = show ? "flex" : "none"
      })
    })
  })
</script>

<?= snippet('footer') ?>