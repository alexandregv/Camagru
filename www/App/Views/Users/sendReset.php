<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
	<div class="container box">
	  <form method="POST" action="<?= Helpers::route('Users#sendReset') ?>">
	   <input class="input" type="text" name="email" placeholder="Votre email"> 
	   <button class="button" type="submit">Reset mon mot de passe</button> 
	  </form>
	</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
