<?php

$dbname = $_POST['databaseName'];
$dbpw = $_POST['databasePassword'];
$dbuser = $_POST['databaseUser'];
$dbhost = $_POST['databaseHost'];

// define('DBNAME', $dbname);
// define('DBHOST', $dbhost);
// define('DBUSER', $dbuser);
// define('DBPASSWORD', $dbpw);

$config_string = "<?php

	define('DBNAME', '$dbname');
	define('DBHOST', '$dbhost');
	define('DBUSER', '$dbuser');
	define('DBPASSWORD', '$dbpw');

	define('DEBUG', FALSE);
";

if (file_put_contents('db/sp-config.php', $config_string)) {
	require_once 'db/connection.php';

	$setup_sql = file_get_contents('startpage.sql');

	if ($setup_result = $db->query($setup_sql)) {

		if ($result = $db->query("INSERT INTO `layout` (name, num_best) VALUES ('default', '13')")) {
			header('Location: ../index.php');
		} else {
			// if (DEBUG) {
				echo $db->error;
			// }
		}
	} else {
		// if (DEBUG) {
			echo $db->error;
			echo $setup_sql;
			// echo $setup_result;
		// }
	}

}