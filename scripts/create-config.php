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

	$sql_array = explode(';', $setup_sql);

	$new = array_pop($sql_array);

	$setup = TRUE;

	foreach ($sql_array as $key => $query_string) {
		if (!$db->query($query_string)) {
			$setup = FALSE;
		}
	}

	if ($setup) {

		if ($result = $db->query("INSERT INTO `layout` (name, num_best) VALUES ('default', '13')")) {
			header('Location: ../index.php');
		} else {
			// if (DEBUG) {
				echo $db->error;
				var_dump($sql_array);
			// }
		}
	} else {
		// if (DEBUG) {
			echo $db->error;
			var_dump($sql_array);
		// }
	}

}