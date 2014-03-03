<?php
	require_once 'scripts/get-bestof.php';
  ?>

<div class="sub-sections wide" id='bestof'>
	<h2>Best Of</h2>
		<?php
		echo get_bestof($db);
		?>
</div>
