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

    <?= css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', [
      'integrity' => "sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z",
      'crossorigin' => "anonymous"
    ]) ?>
    <?= css([
      'https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap',
      'assets/css/styles.css?v=1.02',
    ]) ?>
    <?= js('https://code.jquery.com/jquery-3.5.1.min.js', [
      'integrity' => "sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=",
      'crossorigin' => "anonymous",
    ]) ?>
    <?= js('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', [
      'integrity' => "sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN",
      'crossorigin' => "anonymous"
    ]) ?>
    <?= js('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', [
      'integrity' => "sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV",
      'crossorigin' => "anonymous"
    ]) ?>
    <?php if($page->intendedTemplate() == "agenda"): ?>
      <?= js(['assets/js/vertical-timeline.js', 'assets/js/lazysizes.min.js']) ?>
    <?php endif ?>
  </head>
  <body>
  <div class="wrapper">
  <nav id="main-nav" class="navbar navbar-expand-lg fixed-top navbar-light">
    <div class="container-xl">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?= $site->url() ?>"><span class="title"><img src="<?= $site->url() ?>/assets/img/flechedor-logo-x60gold.png" alt="Flèche d'Or"></span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ml-auto">
          <?php foreach ($site->children()->listed() as $item): ?>
            <?php if($item->hasListedChildren() && $item->slug() != 'agenda'): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= html($item->title()) ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php foreach($item->children()->listed() as $child): ?>
                  <a class="dropdown-item <?php e($child->isOpen(), 'active') ?>" href="<?= $child->url() ?>"><?= html($child->title()) ?></a>
                  <?php endforeach ?>
                </div>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <a class="nav-link <?php e($item->isOpen(), 'active') ?>" href="<?= $item->url() ?>"><?= html($item->title()) ?></a>
              </li>
            <?php endif ?>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </nav>
