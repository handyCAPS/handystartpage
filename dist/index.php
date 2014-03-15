<?php

	// These scripts are required on every page (so far)
	require_once 'scripts/db/connection.php';
	require_once 'scripts/query.php';
	require_once 'scripts/get-categories.php';


	include 'views/header.php' ;

	// Deciding what views to include based on the parameters in the url
	switch (true) {

		case isset($_REQUEST["update"]) :

			require_once 'scripts/get-update-forms.php';

			// If update is set, we check what to update
			switch ($_REQUEST['update']) {

				case 'links' :

					include 'views/update-list.php';
					break;

				case 'cats' :

					include 'views/update-cat-list.php';
					break;
			}

			break;

		// If no parameters are set, the default frontpage is called
		default :

			require_once 'scripts/get-subsections.php';
			include 'views/best-of.php' ;
			include 'views/add-link-form.php' ;
			include 'views/add-cat-form.php' ;
			include 'views/sub-sections.php' ;
			break;
	}

	include 'views/footer.php' ;