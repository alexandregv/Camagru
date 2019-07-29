<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
<?= var_dump(Helpers::route('Posts#new')); ?>
	<form method="POST" action="<?= Helpers::route('Posts#new') ?>" enctype="multipart/form-data">
	  <input type="file" id="picture" name="picture" accept="image/png, image/jpeg" onchange="readURL(this);">
	  <input type="submit">
	<form>
	<img id="img" src="#"/>
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
