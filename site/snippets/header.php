<?php
if(!$kirby->user() && $site->maintenance()->isTrue() && $page->uid() != 'maintenance') {
  go('maintenance');
}
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <base href="<?= site()->url() ?>'">

    <title><?= $site->title() ?> | <?= $page->title() ?></title>
    <?= $page->metaTags() ?>

  </head>
  <body>
    <div class="wrapper">
      <nav id="main-nav" class="navbar navbar-expand-lg fixed-top navbar-light">
        <div class="container-xl">
          <div class="navbar-header">
            <a class="navbar-brand" href="<?= $site->url() ?>"><span class="title"><img src="<?= $site->url() ?>/assets/img/flechedor-logo.png" alt="Flèche d'Or"></span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ml-auto">
              <?php foreach ($site->children()->listed() as $item): ?>
                <a href="<?= $item->url() ?>"><?= html($item->title()) ?></a>
              <?php endforeach ?>
            </ul>
          </div>
        </div>
      </nav>
