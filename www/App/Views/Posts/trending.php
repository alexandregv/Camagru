<?php
namespace App;

Helpers::partial('head');
Helpers::partial('navbar');

$res1 = (new \App\QueryBuilder())->select('*')->from('users')->where('id >= 1')->where("username = aguiot--")->exec();
$res2 = \App\Facades\Query::select('*')->from('users')->where('id >= 1')->where("username = aguiot--")->exec();
var_dump($res1);
var_dump($res2);
exit;
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
