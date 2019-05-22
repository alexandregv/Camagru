<?php
namespace App;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
	<div class="container">
	  <div class="columns is-centered">
		<?php
		foreach ($this->posts as $post)
			Helpers::render('Posts/_post', ['post' => $post]);
		?>
	  </div>
	</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
