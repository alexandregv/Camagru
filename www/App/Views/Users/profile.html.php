<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
	<section class="section">
		<div class="container">
			<div class="box">
				<h3 class="title is-3">Mon profil</h3>
				<hr>
				<form method="POST" action="<?= Helpers::route('Users#profile') ?>">
					<div class="columns">
						<div class="column is-one-fifth has-text-centered">
							<figure class="image is-128x128 container content">
							<img class="is-rounded" src="<?= $this->user->getProfilePicture() ?>">
							</figure>
							<a class="button is-info is-outlined" disabled>Changer ma photo</a>
							<hr>
							<input type="checkbox" id="likeNotifications" name="likeNotifications" value="1" <?php if ($this->user->getLikeNotifications() == 1) echo 'checked'; ?>>
							<label for="likeNotifications">Notifier mes likes par mail</label>
						</div>

						<div class="column">
							<div class="field">
								<label class="label">Nom d'utilisateur</label>
								<div class="control has-icons-left has-icons-right">
									<input name="username" class="input <?php if (array_search('busy_username', $this->errors) !== false || array_search('invalid_username', $this->errors) !== false) echo 'is-danger'; ?>" type="text" value="<?= $this->user->getUsername() ?>">
									<span class="icon is-small is-left"><i class="fas fa-user"></i></span>
									<?php if (array_search('busy_email', $this->errors) !== false) { ?>
									<span class="icon is-small is-right"><i class="fas fa-exclamation-triangle"></i></span>
									<?php } ?>
								</div>
								<?php if (array_search('busy_username', $this->errors) !== false) { ?>
								<p class="help is-danger">Cet utilisateur existe deja</p>
								<?php } ?>
								<?php if (array_search('invalid_username', $this->errors) !== false) { ?>
								<p class="help is-danger">Utilisateur invalide</p>
								<?php } ?>
							</div>

							<div class="field">
								<label class="label">Email</label>
								<div class="control has-icons-left has-icons-right">
									<input name="email" class="input <?php if (array_search('invalid_email', $this->errors) !== false || array_search('busy_email', $this->errors) !== false) echo 'is-danger'; ?>" type="email" value="<?= $this->user->getEmail() ?>">
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
									<input name="firstname" class="input" type="text" value="<?= $this->user->getFirstname() ?>">
								</div>
								<?php if (array_search('invalid_firstname', $this->errors) !== false) { ?>
								<p class="help is-danger">Prenom invalide</p>
								<?php } ?>
							</div>

							<div class="field">
								<label class="label">Nom de famille</label>
								<div class="control">
									<input name="lastname" class="input" type="text" value="<?= $this->user->getLastname() ?>">
								</div>
								<?php if (array_search('invalid_lastname', $this->errors) !== false) { ?>
								<p class="help is-danger">Nom de famille invalide</p>
								<?php } ?>
							</div>

							<div class="field">
								<label class="label">Nouveau mot de passe</label>
								<div class="control has-icons-left has-icons-right">
									<input type="password" name="new_password" class="input <?php if (array_search('invalid_new_password', $this->errors) !== false) echo 'is-danger'; ?>" placeholder="••••••••••">
									<span class="icon is-small is-left"><i class="fas fa-key"></i></span>
								</div>
								<?php if (array_search('invalid_new_password', $this->errors) !== false) { ?>
								<p class="help is-danger">Nouveau mot de passe invalide</p>
								<?php } ?>
							</div>

<?php /*
							<div class="field">
								<label class="label">Ancien mot de passe</label>
								<div class="control has-icons-left has-icons-right">
									<input type="password" name="old_password" class="input <?php if (array_search('invalid_old_password', $this->errors) !== false || array_search('passwords_mismatch', $this->errors) !== false) echo 'is-danger'; ?>" placeholder="••••••••••">
									<span class="icon is-small is-left"><i class="fas fa-key"></i></span>
								</div>
								<?php if (array_search('invalid_old_password', $this->errors) !== false) { ?>
								<p class="help is-danger">Ancien mot de passe invalide</p>
								<?php } ?>
							</div>
 */ ?>

							<div class="field is-grouped">
								<div class="control"><input type="submit" class="button is-link" value="Modifier mon profil"></div>
							</div>	

						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
</main>
<?php Helpers::partial('footer'); ?>
