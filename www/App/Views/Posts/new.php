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
                <input class="file-input" type="file" id="picture" accept="image/png, image/jpeg" onchange="readURL(this);">
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

		<!-- Camera -->
		<div id="camera" class="column">
		  <!-- Camera sensor -->
		  <canvas id="camera--sensor" hidden></canvas>

		  <!-- Camera view -->
		  <video id="camera--view" autoplay playsinline></video>

		  <!-- Camera output -->
		  <img src="//:0" alt="" id="camera--output">

		  <!-- Image base64 -->
		  <input id="img" name="img" type="text" hidden="hidden">

		  <!-- Camera trigger -->
    	  <button id="camera--trigger" class="button is-info" type="button">Take a picture</button>
		</div>
      </div>
    </div>
  </section>
</main>

<script type="text/javascript">
	// Webcam
	var constraints = { video: { facingMode: "user" }, audio: false };
	
	const cameraView  = document.querySelector("#camera--view"),
	    cameraOutput  = document.querySelector("#camera--output"),
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
	    cameraSensor.width = cameraView.videoWidth;
	    cameraSensor.height = cameraView.videoHeight;
	    cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
	    cameraOutput.src = cameraSensor.toDataURL("image/png");
		cameraOutput.classList.add("taken");
		document.querySelector('#img').setAttribute('value', cameraSensor.toDataURL("image/png"));
	};
	
	window.addEventListener("load", cameraStart, false);
</script>

<script type="text/javascript">
	// File upload
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	
	        reader.onload = function (e) {
	            document.querySelector('#camera--output').setAttribute('src', e.target.result);
			    document.querySelector('#img').setAttribute('value', e.target.result);
	        }
	
	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>
<?php Helpers::partial('footer'); ?>
