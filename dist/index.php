<?php

	// These scripts are required on every page (so far)

	if (is_file('scripts/db/sp-config.php')) {
		require_once 'scripts/db/connection.php';
		require_once 'scripts/query.php';
		require_once 'scripts/get-categories.php';
	}

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

		// If no configs are set, show a form to enter them
		case !is_file('scripts/db/sp-config.php'):

			include 'views/db-form.php';
			break;

		// If no parameters are set, the default frontpage is called
		default :

			include 'views/best-of.php' ;
			include 'views/forms.php';
			include 'views/sub-sections.php' ;
			break;
	}

	include 'views/footer.php' ;