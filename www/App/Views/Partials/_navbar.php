<?php
use \App\Helpers;
?>
<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/">
      <img src="<?= Helpers::image('logo.png'); ?>">
    </a>

    <a role="button" class="navbar-burger" data-target="navbar" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbar" class="navbar-menu">
    <div class="navbar-start">
	<a href="<?= Helpers::route('Posts#index') ?>" class="navbar-item <?= Helpers::active('Posts#index') ?>">
  	  <span class="icon has-text-grey-lighter"><i class="fas fa-book"></i></span>
  	  <span>Publications<span>
  	</a>
  	<a href="<?= Helpers::route('Posts#trending') ?>" class="navbar-item <?= Helpers::active('Posts#trending') ?>">
  	  <span class="icon has-text-warning"><i class="fas fa-star"></i></span>
  	  <span>Trending<span>
  	</a>
  	<a href="<?= Helpers::route('Posts#favs') ?>" class="navbar-item <?= Helpers::active('Posts#favs') ?>">
  	  <span class="icon has-text-danger"><i class="fas fa-heart"></i></span>
  	  <span>Favoris<span>
  	</a>
    </div>

    <div class="navbar-end">
			<?php if (isset($_SESSION['loggedin'])) { ?>
      	<div class="navbar-item has-dropdown is-hoverable">
	  			<a class="navbar-link">Mon compte</a>
      	  <div class="navbar-dropdown">
						<a href="<?= Helpers::route('Users#profile') ?>" class="navbar-item">Mon profil</a>
      	    <a href="<?= Helpers::route('Posts#mine') ?>" class="navbar-item">Mes publications</a>
    		  <hr class="navbar-divider">
    		  <a href="<?= Helpers::route('Users#logout') ?>" class="navbar-item">Déconnexion</a>
      	  </div>
      	</div>
      	<div class="navbar-item">
        	<div class="buttons">
          	<a href="<?= Helpers::route('Posts#new') ?>" class="button is-primary gradient"><strong>Poste ta dernière création !</strong></a>
        	</div>
        </div>
			<?php } else {?>
      <div class="navbar-item">
        <div class="buttons">
          <a href="<?= Helpers::route('Users#register') ?>" class="button is-primary gradient"><strong>Inscris toi !</strong></a>
          <a href="<?= Helpers::route('Users#login') ?>" class="button is-light">Se connecter</a>
        </div>
      </div>
			<?php }?>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {

  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});
</script>
