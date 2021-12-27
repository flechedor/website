<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>La Flèche d'Or - maintenance en cours</title>
  <?= css('assets/css/styles.css') ?>
</head>
<body>
<?php
$text = $page->htmlcontent()->kt();
$test = preg_match('/<h1>(.*)<\/h1>/', $text, $matches);
if($test) {
  $h1 = $matches[1];
  $text = trim(str_replace("<h1>$h1</h1>", '', $text));
} else {
  $h1 = $page->title();
}
$ids = explode('/', $page->id());
?>
<main class="container-xl">
  <h1><?= $h1 ?></h1>
  <section class="content section_<?= array_pop($ids) ?>" style="text-align: center;">
    <?= $text ?>
  </section>
</main>
</body>
</html>