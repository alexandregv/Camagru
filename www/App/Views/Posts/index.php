<?php

namespace App;

?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Camagru</title>
	<link rel="stylesheet" href="<?= Helpers::css('style'); ?>">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
  </head>

  <body class="has-navbar-fixed-top">
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
		<a class="navbar-item is-active">
		  <span class="icon has-text-grey-lighter"><i class="fas fa-book"></i></span>
		  <span>Publications<span>
		</a>
		<a class="navbar-item">
		  <span class="icon has-text-warning"><i class="fas fa-star"></i></span>
		  <span>Trending<span>
		</a>
		<a class="navbar-item">
		  <span class="icon has-text-danger"><i class="fas fa-heart"></i></span>
		  <span>Favoris<span>
		</a>
      </div>

      <div class="navbar-end">
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link">Mon compte</a>
          <div class="navbar-dropdown">
            <a class="navbar-item">Mon profil</a>
            <a class="navbar-item">Mes paramètres</a>
      	  <hr class="navbar-divider">
      	  <a class="navbar-item">Déconnexion</a>
          </div>
        </div>
        <div class="navbar-item">
          <div class="buttons">
            <a class="button is-primary gradient"><strong>Inscris toi !</strong></a>
            <a class="button is-light">Se connecter</a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main>
    <section class="section">
      <div class="container">
        <div class="columns">
          <?php for ($i = 1; $i <= 3; $i++) { ?>
            <div class="column card">
              <div class="card-image">
                <figure class="image is-4by3">
                  <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                </figure>
              </div>
              <div class="card-content">
                <div class="media">
                  <div class="media-left">
                    <figure class="image is-48x48">
                      <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                    </figure>
                  </div>
                  <div class="media-content">
                    <p class="title is-4">A. Guiot--Valentin</p>
                    <p class="subtitle is-6">@aguiot--</p>
                  </div>
                </div>

                <div class="content">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                  Phasellus nec iaculis mauris. <a>@aguiot--</a>
                  <a href="#">#42</a> <a href="#">#camagru</a>
                  <br>
                  <time datetime="2016-1-1">21h42 - 30 Février 2019</time>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer is-fixed-bottom">
    <div class="content has-text-centered">
      <p>
        <strong>Camagru</strong> par <a href="https://profile.intra.42.fr/users/aguiot--" target="_blank" rel="noreferrer noopener">aguiot--</a>. Sources disponnibles sur
        <a href="http://github.com/alexandregv/Camagru" target="_blank" rel="noreferrer noopener">github.com/alexandregv/Camagru</a>
      </p>
    </div>
  </footer>

  </body>
</html>
