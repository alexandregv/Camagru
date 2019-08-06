<?php
use \App\Helpers;
?>
<div class="column card is-one-third">
	<div class="card-image">
		<figure class="image is-4by3">
		<a href="<?= Helpers::route('Posts#show', ['id' => $post->getId()]) ?>"><img src="<?= $post->getImage() ?>" alt="Placeholder image"></a>
		</figure>
	</div>
	<div class="card-content">
		<div class="media">
			<div class="media-left">
				<figure class="image is-48x48">
				<a href="<?= Helpers::route('Posts#user', ['user' => $post->getCreator()->getUsername()]) ?>"><img class="is-rounded" src="<?= $post->getCreator()->getProfilePicture() ?>"></a>
				</figure>
			</div>
			<div class="media-content">
			<p class="title is-4"><?= $post->getCreator()->getFirstname(), ' ', $post->getCreator()->getLastname() ?></p>
				<p class="subtitle is-6"><?= '@', $post->getCreator()->getUsername() ?></p>
			</div>
		</div>

		<div class="content">
			<p>
				<?php
					$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
					$tag = '~#([a-zA-z0-9]+)~i';
					$formatted = $post->getDescription();
					$formatted = preg_replace($url, '<a href="$0" target="_blank" title="$2">$2</a>', $formatted);
					$formatted = preg_replace($tag, '<a href="' . Helpers::route('Posts#show', ['id' => '$1']) . '" target="_blank" title="$1">$0</a>', $formatted);
					echo $formatted;
				?>
			</p>
			<time datetime="<?= $post->getCreatedAt() ?>"><?= Helpers::date($post->getCreatedAt()) ?></time>
		</div>
	</div>
</div>
