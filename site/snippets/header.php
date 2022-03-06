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

  <?= css('assets/css/main.css?v=1.0.6') ?>
</head>

<?php $isEvent = $page->parent() && $page->parent()->uid() == "agenda" ?>

<body>
  <menu>
    <div class="menu-header">
      <a href="<?= $site->url() ?>">
        <img class="logo" src="<?= $kirby->url('assets') ?>/img/logo.png" alt="Flèche d'Or" />
      </a>
      <span class="menu-button">
        <div></div>
        <div></div>
        <div></div>
      </span>
    </div>
    <nav>
      <?php foreach ($site->children()->listed() as $item) : ?>
        <?php $isAgendaOrEvent = ($page->uid() == "agenda" || $isEvent) && $item->uid() == "agenda" ?>
        <a href="<?= $item->url() ?>" class="<?= $item->uid() ?> <?= ($page->uid() == $item->uid() || $isAgendaOrEvent) ? 'active' : '' ?>">
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

    <?= snippet('infos') ?>

  </menu>

  <!-- Donate button -->
  <a class="donate" href="<?= $site->donate() ?>" target="_blank">
    <img class="background" src="<?= $kirby->url('assets') ?>/img/donate/FOND PAPIER.png" alt="Fond" />
    <img class="heart" src="<?= $kirby->url('assets') ?>/img/donate/COEUR.png" alt="Coeur" />
    <img class="text" src="<?= $kirby->url('assets') ?>/img/donate/NOUS SOUTENIR.png" alt="Nous soutenir" />
  </a>

  <main class="content page-<?= $page->uid() ?> <?= $isEvent ? 'page-event' : '' ?>">