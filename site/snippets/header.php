<?php
if (!$kirby->user() && $site->maintenance()->isTrue() && $page->uid() != 'maintenance') {
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

  <?= css('assets/css/main.css') ?>
</head>

<body>
  <menu>
    <a href="<?= $site->url() ?>">
      <img src="<?= $kirby->url('assets') ?>/img/logo.png" alt="Flèche d'Or" />
    </a>
    <nav>
      <?php foreach ($site->children()->listed() as $item) : ?>
        <a href="<?= $item->url() ?>" class="<?= $page->uid() == $item->uid() ? 'active' : '' ?>">
          <?= html($item->title()) ?>
        </a>
        <div class="sub-items">
          <!-- Dynamically populated by javascript based on content titles -->
        </div>

        <!-- Agenda filters -->
        <?php if ($page->uid() == "agenda" && $item->uid() == "agenda" && isset($filters)) : ?>
          <div class="agenda-filters">
            <?php foreach ($filters as $filter) : ?>
              <a class="sub-item event-filter" data-filter="<?= $filter ?>"><?= $filter ?></a>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </nav>
    <p>TODO: Horaires d'ouverture</p>
  </menu>

  <?php $pageId = explode('/', $page->id()) ?>
  <main class="content page-<?= array_pop($pageId) ?>">