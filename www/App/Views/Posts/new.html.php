<?php
use \App\Helpers;

Helpers::partial('head');
Helpers::partial('navbar');
?>
<main>
  <section class="section">
	<!-- <div class="box">
      <h3 class="title is-3">Nouvelle publication</h3>
	  <hr> -->
      <div class="tile is-ancestor">
        <div class="tile is-vertical is-8">
          <div class="tile">
            <div class="tile is-parent">
              <article class="tile is-child box">
      		    <div class="column">
      		      <div id="camera" class="column">
      		        <canvas id="camera--sensor" hidden></canvas>
                    <div class="frame">
      		          <video id="camera--view" autoplay playsinline></video>
      		          <img id="camera--border" src="http://png-pixel.com/400x400-00000000.png">
      		        </div>
      		      </div>
         	      <form method="POST" action="<?= Helpers::route('Posts#new') ?>" enctype="multipart/form-data">
      	            <label for="picture">Image</label>
                    <div class="file">
                      <label class="file-label">
                        <input class="file-input" type="file" id="picture" accept="image/png, image/jpeg" onchange="readURL(this);">
                        <span class="file-cta">
                          <span class="file-icon"><i class="fas fa-upload"></i></span>
                          <span class="file-label">Choisir un fichier</span>
                        </span>
      		          </label>
      		          <span style="margin: 5px 5px;"> OU </span>
          	          <button id="camera--trigger" class="button is-light" type="button">Prendre une photo</button>
      		      	  <input id="img" name="img" type="text" hidden="hidden">
      		      	  <input id="border" name="border" type="text" hidden="hidden">
      		        </div>

      	            <br>
						
                    <div class="tile is-parent">
                      <article class="tile is-child box">
						<?php foreach($this->borders as $border): ?>
						<img src="/public/assets/img/borders/<?= $border ?>" class="border-layer" onclick="selectBorder(this, '<?= $border ?>')">
						<?php endforeach; ?>
                      </article>
                    </div>

      	            <br>
      	            <label for="description">Description</label>
      	            <textarea class="textarea" rows="3" name="description" placeholder="Ajoutez une breve description..."></textarea>
      	            <br>
         	        <input type="submit" class="button is-primary is-rounded is-outlined is-fullwidth" id="submit" value="Publier" disabled>
         	      <form>
                </div>
        	  </div>
            </article>
        </div>
      </div>
      <div class="tile is-parent">
        <article class="tile is-child box" id="camera--container">
          <img src="//:0" alt="" id="camera--output-0">
        </article>
      </div>
      </div>
    <!-- </div> -->
  </section>
</main>

<script type="text/javascript">
	// Webcam
	var constraints = { video: { facingMode: "user" }, audio: false };
	
	const cameraView  = document.querySelector("#camera--view"),
	    cameraSensor  = document.querySelector("#camera--sensor"),
	    cameraTrigger = document.querySelector("#camera--trigger")
	
	function cameraStart() {
	    navigator.mediaDevices
	        .getUserMedia(constraints)
	        .then(function(stream) {
	        track = stream.getTracks()[0];
	        cameraView.srcObject = stream;
	    })
	    .catch(function(error) {
	        console.error("Oops. Something is broken.", error);
	    });
	}

	cameraTrigger.onclick = function() {
		const cameraOutput = document.createElement('img');
		cameraOutput.src = '//:0';
		cameraOutput.id = 'camera--output-' + (parseInt(document.querySelector("#camera--container").lastElementChild.id.split('-')[3]) + 1);
	    document.querySelector("#camera--container").appendChild(cameraOutput);

	    cameraSensor.width = cameraView.videoWidth;
	    cameraSensor.height = cameraView.videoHeight;
	    cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
	    cameraOutput.src = cameraSensor.toDataURL("image/png");
		cameraOutput.classList.add("taken");
		document.querySelector('#img').setAttribute('value', cameraSensor.toDataURL("image/png"));
	};
	
	window.addEventListener("load", cameraStart, false);

// ----------

	function selectBorder(elem, border) {
		document.querySelector('#border').setAttribute('value', border);
		document.querySelector('#camera--border').setAttribute('src', '/public/assets/img/borders/' + border);
		let elems = document.querySelectorAll('.border-layer');
		elems.forEach(function(el) { el.classList.remove("border-active"); });
		elem.classList.add('border-active');
		document.querySelector('#submit').disabled = false;
	}

// ----------

	// File upload
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
				document.querySelector('#camera--output').classList.add("taken");
	            document.querySelector('#camera--output').setAttribute('src', e.target.result);
				document.querySelector('#img').setAttribute('value', e.target.result);
	        }
	
	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>
<?php Helpers::partial('footer'); ?>
