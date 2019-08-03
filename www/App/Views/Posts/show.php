<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');

$post = $this->post;
?>
<main>
  <section class="section">
	<article class="media">
	  <figure class="media-content">
			<p class="image is-square"><img style="width: 50vw; height: 80vh;" src="<?= $post->getImage() ?>"></p>
	  </figure>

	  <div class="media-right">
		<div style="margin-bottom: 0.75rem;">
		  <div class="content">
			<p>
				<strong><?= $post->getCreator()->getFirstname(), ' ', $post->getCreator()->getLastname() ?></strong>
				<small><?= '@', $post->getCreator()->getUsername() ?></small>
				<small><?= strftime('%Hh%M', strtotime($post->getCreatedAt())), ' - ', ucwords(strftime('%A %d %B', strtotime($post->getCreatedAt()))) ?></small>
			  <br>
				<?php
					$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
					$tag = '~#([a-zA-z0-9]+)~i';
					$formatted = $post->getDescription();
					$formatted = preg_replace($url, '<a href="$0" target="_blank" title="$2">$2</a>', $formatted);
					$formatted = preg_replace($tag, '<a href="/tags/$1" target="_blank" title="$1">$0</a>', $formatted); //TODO: ::route('', $1)
					echo $formatted;
				?>
			</p>
		  </div>
		  <nav class="level is-mobile">
			<div class="level-left">
			  <a class="level-item"><span class="icon is-small"><i class="fas fa-reply"></i></span></a>
			  <a class="level-item"><span class="icon is-small"><i class="fas fa-retweet"></i></span></a>
			  <?php /*<form id="likeForm" method="POST" action="<?= Helpers::route('Posts#like', ['id' => $post->getId()]) ?>"><a onclick="document.getElementById('likeForm').submit();" class="level-item"><span class="icon is-small"><i class="fas fa-heart"></i></span></a></form> */ ?>
			  <a onclick="document.getElementById('likeForm').submit();" class="level-item"><span class="icon is-small"><i class="fas fa-heart"></i></span></a>
			  <div class="level-item"><span class="icon is-small"><?= $this->likes_count ?></span></div>
			</div>
		  </nav>
		</div>

		<?php foreach ($this->comments as $comment) { ?>
			<article class="media">
  			  <figure class="media-left">
  			    <p class="image is-64x64"><img src="https://bulma.io/images/placeholders/128x128.png"></p>
  			  </figure>
  			  <div class="media-content">
  			    <div class="content">
  			      <p>
  			    	<strong><?= $comment->getAuthor()->getFirstname(), ' ', $comment->getAuthor()->getLastname() ?></strong> <small><?= '@', $comment->getAuthor()->getUsername() ?></small>
  			    	<br>
  			  		<?= $comment->getContent(); ?>
  			    	<br>
  			    	<small><?= strftime('%Hh%M', strtotime($comment->getCreatedAt())), ' - ', ucwords(strftime('%A %d %B', strtotime($comment->getCreatedAt()))) ?></small>
  			      </p>
  			    </div>
  			  </div>
			</article>
		<?php } ?>

		<article class="media">
		  <figure class="media-left">
			<p class="image is-64x64"><img src="https://bulma.io/images/placeholders/128x128.png"></p>
		  </figure>
		  <div class="media-content">
			<div class="field">
			  <p class="control">
				<textarea class="textarea" placeholder="Ajouter un commentaire..."></textarea>
			  </p>
			</div>
			<div class="field">
			  <p class="control">
				<button class="button">Commenter</button>
			  </p>
			</div>
		  </div>
		</article>

		<?php if ($post->getCreator_id() == $_SESSION['id']): ?>
		  <br>
          <form method="POST" action="<?= Helpers::route('Posts#delete', ['id' => $post->getId()]) ?>" enctype="multipart/form-data">
		    <button class="button is-danger is-fullwidth">Supprimer la publication</button>
		  </form>
		<?php endif; ?>

	  </div>
	</article>	
  </section>
</main>
<?php Helpers::partial('footer'); ?>
