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
    <section class="content section_<?= array_pop($ids) ?>">
      <?= $text ?>
    </section>
  </main>

<?= snippet('footer') ?>