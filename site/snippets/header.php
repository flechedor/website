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

<?php $isEvent = $page->parent() && $page->parent()->uid() == "agenda" ?>

<body>
  <menu>
    <a href="<?= $site->url() ?>">
      <img src="<?= $kirby->url('assets') ?>/img/logo.png" alt="Flèche d'Or" />
    </a>
    <nav>
      <?php foreach ($site->children()->listed() as $item) : ?>
        <?php $isAgendaOrEvent = ($page->uid() == "agenda" || $isEvent) && $item->uid() == "agenda" ?>
        <a href="<?= $item->url() ?>" class="<?= ($page->uid() == $item->uid() || $isAgendaOrEvent) ? 'active' : '' ?>">
          <?= html($item->title()) ?>
        </a>

        <div class="sub-items">
          <!-- Dynamically populated by javascript based on content titles -->
        </div>

        <!-- Agenda filters -->
        <?php if ($isAgendaOrEvent) : ?>
          <div class="agenda-filters">
            <?php $filters = $isEvent ? $page->parent()->filters() : $page->filters() ?>
            <?php foreach ($filters->yaml() as $filter) : ?>
              <?php $active = $isEvent && strpos($page->filters(), $filter['name']) !== false ?>
              <a class="sub-item event-filter <?= $active ? 'active' : '' ?>" data-filter="<?= $filter['name'] ?>">
                <?= $filter['name'] ?>
              </a>
            <?php endforeach ?>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </nav>

    <?= $site->address() ?>
    <?= $site->openhours_abstract() ?>
    <?= $site->openhours() ?>

  </menu>

  <main class="content page-<?= $page->uid() ?> <?= $isEvent ? 'page-event' : '' ?>">