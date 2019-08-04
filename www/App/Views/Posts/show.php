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
			  <a class="level-item"><span class="icon is-small"><i class="fas fa-retweet"></i></span></a>
			  <?php /*<form id="likeForm" method="POST" action="<?= Helpers::route('Posts#like', ['id' => $post->getId()]) ?>"><a onclick="document.getElementById('likeForm').submit();" class="level-item"><span class="icon is-small"><i class="fas fa-heart"></i></span></a></form> */ ?>
				<?php if (isset($_SESSION['id'])): ?>
				  <a onclick="like(<?= $post->getId() ?>);" class="level-item"><span class="icon is-small"><i id="likeicon" class="fa<?= $this->liked ? 's' : 'r' ?> fa-heart"></i></span></a>
				<?php else: ?>
				  <a href="/login" class="level-item"><span class="icon is-small"><i id="likeicon" class="far fa-heart"></i></span></a>
				<?php endif; ?>
			  <div class="level-item"><span id="likecount" class="icon is-small"><?= $this->likes_count ?></span></div>
			</div>
		  </nav>
		</div>

		<?php foreach ($this->comments as $comment) { ?>
			<article class="media">
  			  <figure class="media-left">
  			    <p class="image is-64x64"><img class="is-rounded" src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($comment->getAuthor()->getEmail()))); ?>?default=https%3A%2F%2Fbulma.io%2Fimages%2Fplaceholders%2F128x128.png"></p>
  			  </figure>
  			  <div class="media-content">
  			    <div class="content">
  			      <p>
  			    	<strong><?= $comment->getAuthor()->getFirstname(), ' ', $comment->getAuthor()->getLastname() ?></strong> <small><?= '@', $comment->getAuthor()->getUsername() ?></small>
  			    	<br>
					<?php
						$url = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
						$tag = '~#([a-zA-z0-9]+)~i';
						$formatted = $comment->getContent() ;
						$formatted = preg_replace($url, '<a href="$0" target="_blank" title="$2">$2</a>', $formatted);
						$formatted = preg_replace($tag, '<a href="/tags/$1" target="_blank" title="$1">$0</a>', $formatted); //TODO: ::route('', $1)
						echo $formatted;
					?>
  			    	<br>
  			    	<small><?= strftime('%Hh%M', strtotime($comment->getCreatedAt())), ' - ', ucwords(strftime('%A %d %B', strtotime($comment->getCreatedAt()))) ?></small>
  			      </p>
  			    </div>
  			  </div>
			</article>
		<?php } ?>

		<article class="media">
		  <figure class="media-left">
			<p class="image is-64x64"><img src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($this->loggedin_mail))); ?>?default=https%3A%2F%2Fbulma.io%2Fimages%2Fplaceholders%2F128x128.png"></p>
		  </figure>
		  <div class="media-content">
            <form method="POST" action="<?= Helpers::route('Posts#comment', ['id' => $post->getId()]) ?>" enctype="multipart/form-data">
			  <div class="field">
			    <p class="control">
			  	  <textarea name="comment" class="textarea" placeholder="Ajouter un commentaire..."></textarea>
			    </p>
			  </div>
			  <div class="field">
			    <p class="control">
			  	  <button class="button">Commenter</button>
			    </p>
			  </div>
			</form>
		  </div>
		</article>

		<?php if (isset($_SESSION['id']) && $post->getCreator_id() == $_SESSION['id']): ?>
		  <br>
          <form method="POST" action="<?= Helpers::route('Posts#delete', ['id' => $post->getId()]) ?>" enctype="multipart/form-data">
		    <button class="button is-danger is-fullwidth">Supprimer la publication</button>
		  </form>
		<?php endif; ?>

	  </div>
	</article>	
  </section>
</main>

<?php if (isset($_SESSION['id'])): ?>
<script>
  function like(id) {
	icon  = document.querySelector('#likeicon');
    count = document.querySelector('#likecount');
    if (icon.classList.contains('far')) {
      count.innerText = parseInt(count.innerText) + 1;
  	  icon.classList.remove('far');
  	  icon.classList.add('fas');
    } else {
  	  count.innerText = parseInt(count.innerText) - 1;
  	  icon.classList.remove('fas');
  	  icon.classList.add('far');
    }
    fetch('/posts/' + id + '/like', { method: 'POST' });
}
</script>
<?php endif; ?>

<?php Helpers::partial('footer'); ?>
