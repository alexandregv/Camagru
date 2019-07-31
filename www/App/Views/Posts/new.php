<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
	<div class="box">
      <h3 class="title is-3">Nouvelle publication</h3>
	  <hr>

	  <div class="columns">
	  <div class="column">
   	    <form method="POST" action="<?= Helpers::route('Posts#new') ?>" enctype="multipart/form-data">
	      <label for="picture">Image</label>
          <div class="file">
            <label class="file-label">
              <input class="file-input" type="file" id="picture" name="picture" accept="image/png, image/jpeg" onchange="readURL(this);">
              <span class="file-cta">
                <span class="file-icon"><i class="fas fa-upload"></i></span>
                <span class="file-label">Choose a file</span>
              </span>
            </label>
          </div>
	      <br>
	      <label for="description">Description</label>
		  <textarea class="textarea" rows="7" name="description" placeholder="Ajoutez une breve description..."></textarea>
	      <br>
   	      <input type="submit" class="button is-primary">
   	    <form>
	  </div>
	  <div class="column">
   	    <img id="img" src=""/>
      </div>
    </div>
  </section>
</main>
<script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    document.querySelector('#img').setAttribute('src', e.target.result);
					console.log("eeee");
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
<?php Helpers::partial('footer'); ?>
