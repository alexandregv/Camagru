<?php
use \App\Helpers;
use \App\Facades\Query;

$likes_count = Query::select('COUNT(*)')->from('likes')->where(   ['post_id' => $post->getId()])->fetch()['COUNT(*)']; //TODO: :nauseated_face:
$comms_count = Query::select('COUNT(*)')->from('comments')->where(['post_id' => $post->getId()])->fetch()['COUNT(*)']; //TODO: :nauseated_face:
$liked 		 = (isset($_SESSION['id']) && Query::select('*')->from('likes')->where(['post_id' => $post->getId()])->where(['author_id' => $_SESSION['id']])->limit(1)->fetch(1) != false);
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
			<div>
			    <span id="likecount-<?= $post->getId() ?>" class="icon is-small"><?= $likes_count ?></span>
				<?php if (isset($_SESSION['id'])): ?>
				  <a onclick="like(<?= $post->getId() ?>);"><span class="icon is-small"><i id="likeicon-<?= $post->getId() ?>" class="fa<?= $liked ? 's' : 'r' ?> fa-heart"></i></span></a>
				<?php else: ?>
				  <a href="/login" class="level-item"><span class="icon is-small"><i id="likeicon-<?= $post->getId() ?>" class="far fa-heart"></i></span></a>
				<?php endif; ?>
			</div>
		</div>

		<div class="content">
			<p><?= Helpers::parse($post->getDescription()) ?></p>
			<time datetime="<?= $post->getCreatedAt() ?>"><?= Helpers::date($post->getCreatedAt()) ?></time>
		</div>
	</div>
</div>
