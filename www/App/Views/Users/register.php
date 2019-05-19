<?php 

namespace App;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
	<div class="container">
		<div class="columns is-centered">
			<form method="POST" action="<?= Helpers::route('Users#register') ?>" class="box column is-one-third">
				<div class="field">
				  <label class="label">Nom d'utilisateur</label>
				  <div class="control has-icons-left has-icons-right">
						<input name="username" class="input <?php if (array_search('busy_username', $this->errors) !== false) echo 'is-danger'; ?>" type="text" placeholder="xavdu17">
						<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
						<?php if (array_search('busy_email', $this->errors) !== false) { ?>
							<span class="icon is-small is-right"><i class="fas fa-exclamation-triangle"></i></span>
						<?php } ?>
				  </div>
					<?php if (array_search('busy_username', $this->errors) !== false) { ?>
						<p class="help is-danger">Cet utilisateur existe deja</p>
					<?php } ?>
				</div>

				<div class="field">
				  <label class="label">Email</label>
				  <div class="control has-icons-left has-icons-right">
						<input name="email" class="input <?php if (array_search('invalid_email', $this->errors) !== false || array_search('busy_email', $this->errors) !== false) echo 'is-danger'; ?>" type="email" placeholder="xavier@free.fr">
						<span class="icon is-small is-left">
						  <i class="fas fa-envelope"></i>
						</span>
						<?php if (array_search('busy_email', $this->errors) !== false) { ?>
							<span class="icon is-small is-right"><i class="fas fa-exclamation-triangle"></i></span>
						<?php } ?>
				  </div>
					<?php if (array_search('invalid_email', $this->errors) !== false) { ?>
						<p class="help is-danger">Adresse mail invalide</p>
					<?php } ?>
					<?php if (array_search('busy_email', $this->errors) !== false) { ?>
						<p class="help is-danger">Un compte est deja associe a cet email</p>
					<?php } ?>
				</div>
				
				<div class="field">
				  <label class="label">Prenom</label>
				  <div class="control">
						<input name="firstname" class="input" type="text" placeholder="Xavier">
				  </div>
					<?php if (array_search('invalid_firstname', $this->errors) !== false) { ?>
						<p class="help is-danger">Prenom invalide</p>
					<?php } ?>
				</div>

				<div class="field">
				  <label class="label">Nom de famille</label>
				  <div class="control">
						<input name="lastname" class="input" type="text" placeholder="Niel">
				  </div>
					<?php if (array_search('invalid_lastname', $this->errors) !== false) { ?>
						<p class="help is-danger">Nom de famille invalide</p>
					<?php } ?>
				</div>

				<div class="field">
				  <label class="label">Mot de passe</label>
				  <div class="control has-icons-left has-icons-right">
						<input type="password" name="password" class="input <?php if (array_search('invalid_password', $this->errors) !== false) echo 'is-danger'; ?>" placeholder="cNiL-Pr00f">
						<span class="icon is-small is-left"><i class="fas fa-key"></i></span>
				  </div>
					<?php if (array_search('invalid_password', $this->errors) !== false) { ?>
						<p class="help is-danger">Mot de passe invalide</p>
					<?php } ?>
				</div>

				<div class="field">
				  <label class="label">Confirmation de mot de passe</label>
				  <div class="control has-icons-left has-icons-right">
						<input type="password" name="password_confirm" class="input <?php if (array_search('invalid_password', $this->errors) !== false || array_search('passwords_mismatch', $this->errors) !== false) echo 'is-danger'; ?>" placeholder="cNiL-Pr00f">
						<span class="icon is-small is-left"><i class="fas fa-key"></i></span>
				  </div>
					<?php if (array_search('invalid_password', $this->errors) !== false) { ?>
						<p class="help is-danger">Confirmation de mot de passe invalide</p>
					<?php } ?>
					<?php if (array_search('passwords_mismatch', $this->errors) !== false) { ?>
						<p class="help is-danger">Les mots de passe ne correspondent pas</p>
					<?php } ?>
				</div>

				<div class="field">
				  <div class="control">
						<label class="checkbox"><input type="checkbox"> J'accepte les <a href="#">termes et conditions</a>.</label>
				  </div>
				</div>
				
				<div class="field is-grouped">
					<div class="control"><input type="submit" class="button is-link" value="Inscription"></div>
					<div class="control"><a href="<?= Helpers::route('Users#login') ?>"><button type="button" class="button is-text">Deja inscrit ?</button></a></div>
				</div>	
			</form>
		</div>
		</div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
