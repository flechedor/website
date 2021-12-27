<?= snippet('header') ?>

    <main class="container-xl section_benevoles">
        <h1><?= $page->title() ?></h1>
        <section class="content">
            <?php if ($success): ?>
                <div class="alert success">
                    <?= $page->success()->kt() ?>
                </div>
            <?php else: ?>
            <?= $page->htmlcontent()->kt(); ?>
            <div class="form">
                <?php if (isset($alert['error'])): ?>
                    <div class="error">
                        <p><?= $alert['error'] ?></p>
                    </div>
                <?php else : ?>
                    <p class="infos">
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
                        <label for="phone">Téléphone</label>
                        <input type="text" id="phone" name="phone" value="<?= $data['phone'] ?? '' ?>" required>
                        <?= isset($alert['phone']) ? '<span class="alert error">' . html($alert['phone']) . '</span>' : '' ?>
                    </div>
                    <div class="field">
                        <label for="postal">Code postal</label>
                        <input type="text" id="postal" name="postal" value="<?= $data['postal'] ?? '' ?>" required>
                        <?= isset($alert['postal']) ? '<span class="alert error">' . html($alert['postal']) . '</span>' : '' ?>
                    </div>
                    <div class="submit">
                        <input type="submit" name="submit" value="Envoyer">
                        <input type="hidden" name="csrf" value="<?= csrf() ?>">
                    </div>
                </form>
                <?php endif ?>
            </div>
        </section>
    </main>
    <script>
        $('input, textarea').on('change', function () {
            $(this).next('span.error').hide();
        });

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

<?= snippet('footer') ?>