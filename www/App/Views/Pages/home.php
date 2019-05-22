<?php 

namespace App;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
	<div class="container">
		<div class="tile is-ancestor" style="padding-left: 4em;">
			<div class="tile is-vertical is-8">
			  <div class="tile">
				<div class="tile is-parent is-vertical">
				  <article class="tile is-child is-primary">
					<figure class="image is-4by3">
					<img style="border-radius: 5px;" src="<?= Helpers::image('home4.png') ?>">
					</figure>
				  </article>
				</div>
				<div class="tile is-parent">
				  <article class="tile is-child">
					<figure class="image is-4by3">
					<img style="border-radius: 5px;" src="<?= Helpers::image('home3.png') ?>">
					</figure>
				  </article>
				</div>
			  </div>
			  <div class="tile is-parent">
				<article class="tile is-child is-danger">
					<figure class="image is-3by1">
					<img style="border-radius: 5px;" src="<?= Helpers::image('home2.png') ?>">
					</figure>
				</article>
			  </div>
			</div>
			<div class="tile is-parent">
			  <article class="tile is-child is-success">
				<figure class="image is-2by3" style="margin-right: 4em;">
				<img style="border-radius: 5px;" src="<?= Helpers::image('home1.png') ?>">
				</figure>
			  </article>
			</div>
		</div>

		<nav class="level">
		  <div class="level-item has-text-centered">
			<div>
			  <p class="heading">Utilisateurs</p>
				<p class="title"><?= $this->users_count ?></p>
			</div>
		  </div>
		  <div class="level-item has-text-centered">
			<div>
			  <p class="heading">Publications</p>
			  <p class="title"><?= $this->posts_count ?></p>
			</div>
		  </div>
		  <div class="level-item has-text-centered">
			<div>
			  <p class="heading">Commentaires</p>
			  <p class="title">456K</p>
			</div>
		  </div>
		  <div class="level-item has-text-centered">
			<div>
			  <p class="heading">Likes</p>
			  <p class="title">789</p>
			</div>
		  </div>
		</nav>
	</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
