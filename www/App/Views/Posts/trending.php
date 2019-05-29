<?php
namespace App;

Helpers::partial('head');
Helpers::partial('navbar');

//$res = \App\Facades\Query::select('*')->from('users')->where('id >= 1')->where("username = aguiot--")->exec();
//var_dump($res);
//exit;
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
