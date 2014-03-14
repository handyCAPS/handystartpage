<?php
	require_once 'scripts/get-bestof.php';
	require_once 'scripts/layout.php';

	$num_best = get_num_bestof($db);
  ?>

<div class="sub-sections wide" id='bestof'>
	<h2>Best Of</h2>
	<div class="range_wrap">
		<div class="range_display">13</div>
		<input type="range" min='10' max='30' value="13" name='bestOfRange' id='bestOfRange' title='Select number of bestofs. From 10 to 30'>
	</div><!--  end .range_wrap  -->
	<div id='bestOfWrap'>
		<?php
		echo get_bestof($db, $num_best);
		?>
		</div>
</div>
