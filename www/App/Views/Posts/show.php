<?php 

namespace App;

Helpers::partial('head');
Helpers::partial('navbar');

?>
<main>
  <section class="section">
	<article class="media">
	  <figure class="media-content">
		<p class="image is-square"><img style="width: 50vw; height: 80vh;" src="https://bulma.io/images/placeholders/128x128.png"></p>
	  </figure>

	  <div class="media-right">
		<div style="margin-bottom: 0.75rem;">
		  <div class="content">
			<p>
			  <strong>A. Guiot--Valentin</strong> <small>@aguiot--</small> <small>42m</small>
			  <br>
			  Voici ma dernière photo, il s'agit d'un placeholder de 128 par 128 d'un style assez classique et épuré. Je rends les likes. 
			</p>
		  </div>
		  <nav class="level is-mobile">
			<div class="level-left">
			  <a class="level-item"><span class="icon is-small"><i class="fas fa-reply"></i></span></a>
			  <a class="level-item"><span class="icon is-small"><i class="fas fa-retweet"></i></span></a>
			  <a class="level-item"><span class="icon is-small"><i class="fas fa-heart"></i></span></a>
			</div>
		  </nav>
		</div>

		<article class="media">
  		  <figure class="media-left">
  		    <p class="image is-64x64"><img src="https://bulma.io/images/placeholders/128x128.png"></p>
  		  </figure>
  		  <div class="media-content">
  		    <div class="content">
  		      <p>
  		    	<strong>Baptiste Martin</strong> <small>@bapmarti</small>
  		    	<br>
  		    	Vraiment beau, classique mais original, j'adore.	
  		    	<br>
  		    	<small><a>Like</a> · 3 hrs</small>
  		      </p>
  		    </div>

  		  </div>
		</article>

		<article class="media">
  		  <figure class="media-left">
  		    <p class="image is-64x64"><img src="https://bulma.io/images/placeholders/128x128.png"></p>
  		  </figure>
  		  <div class="media-content">
  		    <div class="content">
  		      <p>
  		    	<strong>Alex Moulinneuf</strong> <small>@amoulinn</small>
  		    	<br>
  		    	Fdp c flou.	
  		    	<br>
  		    	<small><a>Like</a> · 3 hrs</small>
  		      </p>
  		    </div>

  		  </div>
		</article>

		<article class="media">
		  <figure class="media-left">
			<p class="image is-64x64"><img src="https://bulma.io/images/placeholders/128x128.png"></p>
		  </figure>
		  <div class="media-content">
			<div class="field">
			  <p class="control">
				<textarea class="textarea" placeholder="Add a comment..."></textarea>
			  </p>
			</div>
			<div class="field">
			  <p class="control">
				<button class="button">Post comment</button>
			  </p>
			</div>
		  </div>
		</article>
	  </div>
	</article>	
  </section>
</main>
<?php Helpers::partial('footer'); ?>
