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
