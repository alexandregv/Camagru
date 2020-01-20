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
			  <?= Helpers::parse($post->getDescription()) ?>
			</p>
		  </div>
		  <nav class="level is-mobile">
			<div class="level-left">
			  <a class="level-item" href="https://twitter.com/intent/tweet?text=<?= $post->getDescription() ?>%20%23Camagru"><span class="icon is-small"><i class="fas fa-retweet"></i></span></a>
				<?php if (isset($_SESSION['id'])): ?>
				  <a onclick="like(<?= $post->getId() ?>);" class="level-item"><span class="icon is-small"><i id="likeicon-<?= $post->getId() ?>" class="fa<?= $this->liked ? 's' : 'r' ?> fa-heart"></i></span></a>
				<?php else: ?>
				  <a href="/login" class="level-item"><span class="icon is-small"><i id="likeicon-<?= $post->getId() ?>" class="far fa-heart"></i></span></a>
				<?php endif; ?>
			  <div class="level-item"><span id="likecount-<?= $post->getId() ?>" class="icon is-small"><?= $this->likes_count ?></span></div>
			</div>
		  </nav>
		</div>

        <div id="comments">
		  <?php foreach ($this->comments as $comment) { ?>
		  	<?= Helpers::render('Posts/_comment', ['comment' => $comment]) ?>
		  <?php } ?>
        </div>

		<article class="media">
		  <figure class="media-left">
		  <p class="image is-64x64"><img src="<?= $post->getCreator()->getProfilePicture() ?>"></p>
		  </figure>
		  <div class="media-content">
			  <div class="field">
			    <p class="control">
			  	  <textarea id="comment-content" name="comment" class="textarea" placeholder="Ajouter un commentaire..."></textarea>
			    </p>
			  </div>
			  <div class="field">
			    <p class="control">
			  	  <button onclick="comment(<?= $post->getId() ?>)" class="button">Commenter</button>
			    </p>
			  </div>
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
  let csrf = '<?= (isset($_SESSION['csrf']) ? $_SESSION['csrf'] : '') ?>';
  function comment(id) {
	textarea = document.querySelector('#comment-content');

	const formData = new FormData();
    formData.append('comment', textarea.value);
    formData.append('csrf', csrf);
	textarea.value = "";

	fetch('/posts/' + id + '/comment', {
	  method: 'POST',
	  body: formData
	})
	.then(function(response) {
	  return response.text();
	})
	.then(function(text) {
		var d = document.createElement("div");
		d.innerHTML = text;
		document.querySelector('#comments').appendChild(d);
    });
  }

  window.twttr = (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0],
      t = window.twttr || {};
    if (d.getElementById(id)) return t;
    js = d.createElement(s);
    js.id = id;
    js.src = "https://platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js, fjs);

    t._e = [];
    t.ready = function(f) {
      t._e.push(f);
    };

    return t;
  }(document, "script", "twitter-wjs"));
</script>
<?php endif; ?>

<?php Helpers::partial('footer'); ?>
