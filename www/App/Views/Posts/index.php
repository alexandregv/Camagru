<?php 

namespace App;

Helpers::partial('head');
Helpers::partial('navbar');

?>
<main>
  <section class="section">
    <div class="container">
      <div class="columns">
        <?php for ($i = 1; $i <= 3; $i++) { ?>
          <div class="column card">
            <div class="card-image">
              <figure class="image is-4by3">
				<a href="/posts/42"><img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image"></a>
              </figure>
            </div>
            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
                  </figure>
                </div>
                <div class="media-content">
                  <p class="title is-4">A. Guiot--Valentin</p>
                  <p class="subtitle is-6">@aguiot--</p>
                </div>
              </div>

              <div class="content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Phasellus nec iaculis mauris. <a>@aguiot--</a>
                <a href="#">#42</a> <a href="#">#camagru</a>
                <br>
                <time datetime="2016-1-1">21h42 - 30 Février 2019</time>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>
</main>
<?php Helpers::partial('footer'); ?>
