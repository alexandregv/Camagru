<?php
use \App\Helpers;
?>
<article class="media">
  <figure class="media-left">
    <p class="image is-64x64"><img class="is-rounded" src="https://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($comment->getAuthor()->getEmail()))); ?>?default=https%3A%2F%2Fbulma.io%2Fimages%2Fplaceholders%2F128x128.png"></p>
  </figure>
  <div class="media-content">
    <div class="content">
      <p>
    	<strong><?= $comment->getAuthor()->getFirstname(), ' ', $comment->getAuthor()->getLastname() ?></strong> <small><?= '@', $comment->getAuthor()->getUsername() ?></small>
    	<br>
		<?= Helpers::parse($comment->getContent()) ?>
    	<br>
    	<small><?= Helpers::date($comment->getCreatedAt()) ?></small>
      </p>
    </div>
  </div>
</article>
