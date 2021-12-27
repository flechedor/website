<?= snippet('header') ?>
<?php
$text = $page->description()->kt();
$test = preg_match('/<h1>(.*)<\/h1>/', $text, $matches);
if($test) {
  $h1 = $matches[1];
  $text = trim(str_replace('<h1>'.$h1.'</h1>', '', $text));
} else {
  $h1 = $page->title();
}
$ids = explode('/', $page->id());
?>
<main class="container-xl event">
  <nav class="events-nav">
    <a class="back" href="<?= $page->parent()->url() ?>">retour</a>
    <?php if ($page->hasPrevListed()): ?>
      / <a class="prev" href="<?= $page->prevListed()->url() ?>">précédent</a>
    <?php endif ?>
    <?php if ($page->hasNextListed()): ?>
      <a class="next" href="<?= $page->nextListed()->url() ?>">suivant</a>
    <?php endif ?>
  </nav>
  <div class="params">
    <div class="reservation">
      <?php if($resa != 'sans réservation'): ?>
      <span class=" <?= $reservations[$resa]['class'] ?>"><?= $reservations[$resa]['text'] ?></span>
      <?php endif ?>
    </div>
    <p class="dates"><?= html_entity_decode($page->formatDate()) ?></p>
    <div class="colors">
    <?php if(count($filters)): ?>
      <ul class="filters">
        <?php foreach($filters as $filter): ?>
          <li style="color: <?= $filter->color() ?>">
            <span class="color" style="background: <?= $filter->color() ?>"></span>
            <?= $filter->name(); ?>
            </span>
          </li>
        <?php endforeach ?>
      </ul>
    <?php endif; ?>
    </div>
  </div>
  <header>
    <h1><?= $h1 ?></h1>
    <?php if($page->headline()->isNotEmpty()): ?>
      <p class="headline"><?= $page->headline() ?></p>
    <?php endif ?>
  </header>
  <section class="content">
    <?php if($image = $page->cover()->toFile()): ?>
      <figure ><img src="<?= $image->url() ?>" alt=""></figure>
    <?php endif ?>
    <?= $text ?>
  </section>
</main>

<?= snippet('footer') ?>
