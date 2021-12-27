<?= snippet('header') ?>

  <main class="container-xl">
    <h1><?= $page->title() ?></h1>
    <section class="content section_<?= $page->id() ?>">
      <div class="columns">
        <div class="column form">
          <?php if ($success): ?>
            <div class="alert success">
              <?= $page->success()->kt() ?>
            </div>
          <?php else: ?>
            <?php if (isset($alert['error'])): ?>
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
        </div>
        <div class="column">
          <figure>
            <img src="<?= $page->image()->resize(600)->url() ?>" alt="">
            <figcaption>
              <small>© photo Pierrick Bourgault</small>
            </figcaption>
          </figure>
        </div>
      </div>
    </section>
  </main>
  <script>
    $('input, textarea').on('change', function() {
      $(this).next('span.error').hide();
    });

    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
  </script>
<?= snippet('footer') ?>