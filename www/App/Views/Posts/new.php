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

		<!-- Camera -->
		<div id="camera" class="column">
		  <!-- Camera sensor -->
		  <canvas id="camera--sensor" hidden></canvas>

		  <!-- Camera view -->
		  <video id="camera--view" autoplay playsinline></video>

		  <!-- Camera output -->
		  <img src="//:0" alt="" id="camera--output">

		  <!-- Camera trigger -->
    	  <button id="camera--trigger" class="button is-info" type="button">Take a picture</button>
		</div>
		
        <div class="column">
   	      <img id="img" src=""/>
      </div>
    </div>
  </section>
</main>

<script>
// Set constraints for the video stream
var constraints = { video: { facingMode: "user" }, audio: false };

// Define constants
const cameraView  = document.querySelector("#camera--view"),
    cameraOutput  = document.querySelector("#camera--output"),
    cameraSensor  = document.querySelector("#camera--sensor"),
    cameraTrigger = document.querySelector("#camera--trigger")

// Access the device camera and stream to cameraView
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

// Take a picture when cameraTrigger is tapped
cameraTrigger.onclick = function() {
    cameraSensor.width = cameraView.videoWidth;
    cameraSensor.height = cameraView.videoHeight;
    cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);
    cameraOutput.src = cameraSensor.toDataURL("image/png");
    cameraOutput.classList.add("taken");
};

// Start the video stream when the window loads
window.addEventListener("load", cameraStart, false);
</script>

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
