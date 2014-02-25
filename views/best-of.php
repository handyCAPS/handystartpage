<?php
	require_once 'scripts/get-bestof.php';
  ?>

<div class="sub-sections wide">
	<h2>Best Of</h2>
	<p>
		<?php
		echo get_bestof($db);
		?>
	</p>
</div>
