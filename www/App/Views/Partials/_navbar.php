<?php namespace App; ?>
<nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="/">
      <img src="<?= Helpers::image('logo.png'); ?>">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbar">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbar" class="navbar-menu">
    <div class="navbar-start">
	<a href="<?= Helpers::route('Posts#index') ?>" class="navbar-item is-active">
  	  <span class="icon has-text-grey-lighter"><i class="fas fa-book"></i></span>
  	  <span>Publications<span>
  	</a>
  	<a href="<?= Helpers::route('Posts#trending') ?>" class="navbar-item">
  	  <span class="icon has-text-warning"><i class="fas fa-star"></i></span>
  	  <span>Trending<span>
  	</a>
  	<a href="<?= Helpers::route('Posts#favs') ?>" class="navbar-item">
  	  <span class="icon has-text-danger"><i class="fas fa-heart"></i></span>
  	  <span>Favoris<span>
  	</a>
    </div>

    <div class="navbar-end">
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Mon compte</a>
        <div class="navbar-dropdown">
		<a href="<?= Helpers::route('Users#profile') ?>" class="navbar-item">Mon profil</a>
          <a href="<?= Helpers::route('Users#settings') ?>" class="navbar-item">Mes paramètres</a>
    	  <hr class="navbar-divider">
    	  <a href="<?= Helpers::route('Users#logout') ?>" class="navbar-item">Déconnexion</a>
        </div>
      </div>
      <div class="navbar-item">
        <div class="buttons">
          <a href="<?= Helpers::route('Users#register') ?>" class="button is-primary gradient"><strong>Inscris toi !</strong></a>
          <a href="<?= Helpers::route('Users#login') ?>" class="button is-light">Se connecter</a>
        </div>
      </div>
    </div>
  </div>
</nav>

