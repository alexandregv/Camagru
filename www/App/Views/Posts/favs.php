<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');

$page = $this->page;
$pages_count = $this->pages_count;
$posts = $this->posts;
?>
<main>
  <section class="section">
	<div class="container">
	  <div class="columns is-centered">
		<?php
		foreach (array_slice($this->posts, 0, 3) as $post)
			Helpers::render('Posts/_post', ['post' => $post]);
		?>
	  </div>
	  <div class="columns is-centered">
		<?php
		foreach (array_slice($this->posts, 3, 3) as $post)
			Helpers::render('Posts/_post', ['post' => $post]);
		?>
	  </div>
	
	  <?php Helpers::partial('pagination', ['url' => '/favs', 'page' => $page, 'pages_count' => $pages_count]); ?>
	</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
