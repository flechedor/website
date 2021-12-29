<?= snippet('header') ?>

<?php if ($success) : ?>
  <div class="alert success">
    <?= $page->success()->kt() ?>
  </div>
<?php endif ?>

<h1>Écrivez-nous</h1>
<p>Pour nous contacter, veuillez emplit le formulaire ci-dessous</p>
<form method="post" action="<?= $page->url() ?>">
  <input type="hidden" name="csrf" value="<?= csrf() ?>">

  <?php if ($alert) : ?>
    <?php foreach ($alert as $msg) : ?>
      <div class="alert error"><?= $msg ?></div>
    <?php endforeach ?>
  <?php endif ?>

  <input type="text" placeholder="Nom/Prénom" name="name" required />
  <input type="email" placeholder="E-mail" name="email" required />
  <textarea id="text" placeholder="Message" name="text" rows="8" required></textarea>
  <button type="submit" name="submit" data-shape="ENVOYER">Envoyer</button>
</form>

<h1>Inscrivez-vous à la newsletter </h1>
<form action="https://gmail.us19.list-manage.com/subscribe/post?u=28d0a436313a02c8b4b15e719&amp;id=10b0d80558" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank">
  <input type="text" name="EMAIL" placeholder="E-mail">
  <button type="submit" name="subscribe" data-shape="ENVOYER">Envoyer</button>
  <div style="position: absolute; left: -5000px;" aria-hidden="true">
    <input type="text" name="b_28d0a436313a02c8b4b15e719_10b0d80558" tabindex="-1" value="">
  </div>
</form>

<?= snippet('footer') ?>