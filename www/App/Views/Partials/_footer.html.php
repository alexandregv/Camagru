
    <footer class="footer is-fixed-bottom">
      <div class="content has-text-centered">
        <p>
          <strong>Camagru</strong> par <a href="https://profile.intra.42.fr/users/aguiot--" target="_blank" rel="noreferrer noopener">aguiot--</a>. Sources disponnibles sur
          <a href="http://github.com/alexandregv/Camagru" target="_blank" rel="noreferrer noopener">github.com/alexandregv/Camagru</a>
        </p>
      </div>
    </footer>

	<script>
	  document.addEventListener('DOMContentLoaded', () => {
  	  (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
  	    $notification = $delete.parentNode;
  	    $delete.addEventListener('click', () => {
  	      $notification.parentNode.removeChild($notification);
  	    });
  	  });
	  });


	  let csrf = '<?= $_SESSION['csrf'] ?>';
      function like(id) {
        icon  = document.querySelector('#likeicon-' + id);
        count = document.querySelector('#likecount-' + id);
        if (icon.classList.contains('far')) {
          count.innerText = parseInt(count.innerText) + 1;
      	  icon.classList.remove('far');
      	  icon.classList.add('fas');
        } else {
      	  count.innerText = parseInt(count.innerText) - 1;
      	  icon.classList.remove('fas');
      	  icon.classList.add('far');
        }

        const formData = new FormData();
        formData.append('csrf', csrf);

        fetch('/posts/' + id + '/like', {
        	method: 'POST',
        	body: formData
		})
		.then(response => response.text())
		.then(text => csrf = text);

      }
	</script>

  </body>
</html>
