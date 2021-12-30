<?= snippet('header') ?>

<!-- Back button -->
<a href="<?= $page->parent()->url() ?>" class="event-back">
  <img src="<?= $kirby->url('assets') ?>/img/buttons/RETOUR (RESPONSIVE).png" />
</a>
<!-- Date -->
<h2 class="event-date">
  <span><?= "{$page->formatedDate()} {$page->formatedTime(true)}" ?></span>
</h2>
<!-- Title -->
<h1 class="event-title"><?= $page->title() ?></h1>
<!-- Headline -->
<?php if ($page->headline()->isNotEmpty()) : ?>
  <h3 class="event-headline"><?= $page->headline() ?></h3>
<?php endif ?>
<!-- Image -->
<?php if ($image = $page->vignette()->toImage()) : ?>
  <figure>
    <img src="<?= $image->url() ?>" alt="">
    <?php if ($page->attribution()->isNotEmpty()) : ?>
      <figcaption><?= $page->attribution() ?></figcaption>
    <?php endif ?>
  </figure>
<?php endif ?>
<!-- Description -->
<?= $page->description()->kt() ?>

<?= snippet('footer') ?>