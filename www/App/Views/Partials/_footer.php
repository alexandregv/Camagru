
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
		</script>

  </body>
</html>
