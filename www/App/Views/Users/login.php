<?php

namespace App;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
		<div class="container">
			<div class="columns is-centered">
				<form method="POST" action="<?= Helpers::route('Users#login') ?>" class="box column is-one-third">
					<div class="field">
					  <label class="label">Email</label>
					  <div class="control has-icons-left has-icons-right">
						<input type="email" name="email" class="input <?php if (array_search('invalid_email', $this->errors) !== false) echo 'is-danger'; ?>" placeholder="xavier@free.fr">
							<span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
						</div>
						<?php if (array_search('invalid_email', $this->errors) !== false) { ?>
							<p class="help is-danger">Aucun utilisateur avec cet email</p>
						<?php } ?>
					</div>
					
					<div class="field">
					  <label class="label">Mot de passe</label>
					  <div class="control has-icons-left has-icons-right">
							<input type="password" name="password" class="input <?php if (array_search('invalid_password', $this->errors) !== false) echo 'is-danger'; ?>" placeholder="cNiL-Pr00f">
							<span class="icon is-small is-left"><i class="fas fa-key"></i></span>
					  </div>
						<?php if (array_search('invalid_password', $this->errors) !== false) { ?>
							<p class="help is-danger">Mot de passe incorrect</p>
						<?php } ?>
					</div>
					
					<div class="field">
					  <div class="control">
							<label class="checkbox"><input type="checkbox" name="remember"> Se souvenir de moi</label>
					  </div>
					</div>
					
					<div class="field is-grouped">
					  <div class="control"><input type="submit" class="button is-link" value="Connexion"></div>
					  <div class="control"><a href="<?= Helpers::route('Users#register') ?>"><button type="button" class="button is-text">Pas encore inscrit ?</button></a></div>
					</div>	
				</form>
			</div>
		</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
