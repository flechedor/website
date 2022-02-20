<div class="infos">
  <div class="socials">
    <?php foreach (['facebook', 'spotify', 'instagram'] as $social) : ?>
      <div class="col">
        <a href="<?= $site->$social() ?>" class="<?= $social ?>" target="_blank"><?= $social ?></a>
      </div>
    <?php endforeach ?>
  </div>

  <div class="address-openhours">
    <div class="col col-left">
      <div class="address"><?= $site->address() ?></div>
      <div class="openhours-abstract"><?= $site->openhours_abstract() ?></div>
    </div>    
    <div class="col col-right">
      <div class="openhours"><?= $site->openhours() ?></div>
    </div>
  </div>
</div>