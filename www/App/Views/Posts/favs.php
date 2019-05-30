<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');

$posts = $this->posts;
?>
<main>
  <section class="section">
	<div class="container">
	  <div class="columns is-centered">
		<?php
		foreach ($posts as $post)
			Helpers::render('Posts/_post', ['post' => $post]);
		?>
	  </div>
	</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
