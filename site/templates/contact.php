<?= snippet('header') ?>

<?php if ($success) : ?>
  <div class="alert success">
    <?= $page->success()->kt() ?>
  </div>
<?php else : ?>
  <?php if (isset($alert['error'])) : ?>
    <div class="error">
      <p><?= $alert['error'] ?></p>
    </div>
  <?php else : ?>
    <p class="infos">
      Pour nous contacter, veuillez remplir le formulaire ci-dessous.<br>
      <small>Tous les champs sont requis.</small>
    </p>
  <?php endif ?>
  <form method="post" action="<?= $page->url() ?>" novalidate>

    <div class="field">
      <label for="name">Nom / prénom</label>
      <input type="text" id="name" name="name" value="<?= $data['name'] ?? '' ?>" required>
      <?= isset($alert['name']) ? '<span class="alert error">' . html($alert['name']) . '</span>' : '' ?>
    </div>
    <div class="field">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= $data['email'] ?? '' ?>" required>
      <?= isset($alert['email']) ? '<span class="alert error">' . html($alert['email']) . '</span>' : '' ?>
    </div>
    <div class="field confirm">
      <label for="confirm">Mot de passe</label>
      <input type="text" id="confirm" name="confirm" tabindex="-1" autocomplete="off">
    </div>
    <div class="field">
      <label for="text">Message</label>
      <textarea id="text" name="text" rows="8" required><?= $data['text'] ?? '' ?></textarea>
      <?= isset($alert['text']) ? '<span class="alert error">' . html($alert['text']) . '</span>' : '' ?>
    </div>
    <div class="submit">
      <input type="submit" name="submit" value="Envoyer">
      <input type="hidden" name="csrf" value="<?= csrf() ?>">
    </div>
  </form>
<?php endif ?>

<form action="https://gmail.us19.list-manage.com/subscribe/post?u=28d0a436313a02c8b4b15e719&amp;id=10b0d80558" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
  <label for="newsletter-email">Inscrivez-vous à la newsletter !</label>
  <input type="text" name="EMAIL" placeholder="@email"><input type="submit" name="subscribe" value="OK">
  <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_28d0a436313a02c8b4b15e719_10b0d80558" tabindex="-1" value=""></div>
</form>

<?= snippet('footer') ?>