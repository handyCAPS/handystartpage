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
	header('Location: ../index.php');
}