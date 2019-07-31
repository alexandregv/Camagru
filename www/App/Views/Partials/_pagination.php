<nav class="pagination is-centered">
  <ul class="pagination-list">
    <?php if ($pages_count <= 3): ?>
      <li><a class="pagination-link <?php if ($page == 1) echo 'is-current'; ?>" href="/posts?page=1">1</a></li>
      <?php if ($pages_count >= 2): ?>
        <li><a class="pagination-link <?php if ($page == 2) echo 'is-current'; ?>" href="/posts?page=2">2</a></li>
      <?php endif; ?>
      <?php if ($pages_count == 3): ?>
        <li><a class="pagination-link <?php if ($page == 3) echo 'is-current'; ?>" href="/posts?page=3">3</a></li>
      <?php endif; ?>
    <?php else: ?>
      <?php if ($pages_count >= 3): ?>
       	<li><a class="pagination-link" href="/posts?page=1">1</a></li>
       	<li><span class="pagination-ellipsis">&hellip;</span></li>
	  <?php endif; ?>
      <?php if ($page <= 3): ?>
        <li><a class="pagination-link <?php if ($page == 1) echo 'is-current' ?>" href="/posts?page=1">1</a></li>
		<li><a class="pagination-link <?php if ($page == 2) echo 'is-current' ?>" href="/posts?page=2">2</a></li>
        <li><a class="pagination-link <?php if ($page == 3) echo 'is-current' ?>" href="/posts?page=3">3</a></li>
      <?php else: ?>
	    <li><a class="pagination-link" href="/posts?page=<?= $page-1 ?>"><?= $page-1 ?></a></li>
        <li><a class="pagination-link is-current"><?= $page ?></a></li>	
      <?php if ($pages_count >= 3): ?>
       	<li><a class="pagination-link" href="/posts?page=<?= $page+1 ?>"><?= $page+1 ?></a></li>
      <?php endif; ?>
      <?php endif; ?>
      <?php if ($pages_count >= 3): ?>
       	<li><span class="pagination-ellipsis">&hellip;</span></li>
       	<li><a class="pagination-link" href="/posts?page=<?= $pages_count ?>"><?= $pages_count ?></a></li>
      <?php endif; ?>
    <?php endif; ?>
  </ul>
</nav>
