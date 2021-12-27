
<?php
$socials = [$site->instagram(), $site->facebook()];
$output = '';
foreach($socials as $social) {
  if($social->isNotEmpty()) {
    $output .= '<a href="'. $social .'" target="_blank"><i class="icon-'. strtolower($social->key()) .'"></i></a>';
  }
}
?>
    <footer id="main-footer" class="container-fluid">
      <div class="container-xl">
        <nav><?= $output ?></nav>
        <address><strong>La Flèche d'Or</strong><br>102bis, rue de Bagnolet<br>75020 Paris</address>
        <form action="https://gmail.us19.list-manage.com/subscribe/post?u=28d0a436313a02c8b4b15e719&amp;id=10b0d80558" method="post" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
          <label for="newsletter-email">Inscrivez-vous à la newsletter !</label>
          <input type="text" name="EMAIL" placeholder="@email"><input type="submit" name="subscribe" value="OK">
          <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_28d0a436313a02c8b4b15e719_10b0d80558" tabindex="-1" value=""></div>
        </form>
        <!--<p>site en construction</p>-->
      </div>
    </footer>
    </div>

    <?= js('assets/js/main.js') ?>
  </body>
</html>