<?php
  function ic($current_page, $link_page)
  {
	  if ($current_page == $link_page)
		  echo 'is-current';
  }
?>

<nav class="pagination is-centered">
  <ul class="pagination-list">
    <?php if ($pages_count > 3): ?>
       	<li><a class="pagination-link" href="<?= $url ?>?page=1">1</a></li>
       	<li><span class="pagination-ellipsis">&hellip;</span></li>
    <?php endif; ?>

    <?php if ($pages_count == 1): ?>
	  <li><a class="pagination-link <?= ic($page, 1) ?>" href="<?= $url ?>?page=1">1</a></li>
    <?php elseif ($pages_count == 2): ?>
	  <li><a class="pagination-link <?= ic($page, 1) ?>" href="<?= $url ?>?page=1">1</a></li>
	  <li><a class="pagination-link <?= ic($page, 2) ?>" href="<?= $url ?>?page=2">2</a></li>
    <?php elseif ($pages_count == 3): ?>
	  <li><a class="pagination-link <?= ic($page, 1) ?>" href="<?= $url ?>?page=1">1</a></li>
	  <li><a class="pagination-link <?= ic($page, 2) ?>" href="<?= $url ?>?page=2">2</a></li>
	  <li><a class="pagination-link <?= ic($page, 3) ?>" href="<?= $url ?>?page=3">3</a></li>
    <?php elseif ($pages_count > 3): ?>
        <?php if ($page <= 2): ?>
	      <li><a class="pagination-link <?= ic($page, 1) ?>" href="<?= $url ?>?page=1">1</a></li>
		  <li><a class="pagination-link <?= ic($page, 2) ?>" href="<?= $url ?>?page=2">2</a></li>
	      <li><a class="pagination-link" href="<?= $url ?>?page=3">3</a></li>
        <?php else: ?>
          <li><a class="pagination-link" href="<?= $url ?>?page=<?= $page-1 ?>"><?= $page-1 ?></a></li>
          <li><a class="pagination-link is-current"><?= $page ?></a></li>	
          <?php if ($page < $pages_count): ?>
       	    <li><a class="pagination-link" href="<?= $url ?>?page=<?= $page+1 ?>"><?= $page+1 ?></a></li>
          <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($pages_count > 3): ?>
       	<li><span class="pagination-ellipsis">&hellip;</span></li>
       	<li><a class="pagination-link" href="<?= $url ?>?page=<?= $pages_count ?>"><?= $pages_count ?></a></li>
    <?php endif; ?>
  </ul>
</nav>
