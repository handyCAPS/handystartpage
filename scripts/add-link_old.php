<?php

require_once 'db/connection.php';

$link = $db->real_escape_string(trim($_POST['link']));
// $link = urlencode($link);
$name = $db->real_escape_string(trim(ucfirst($_POST['name'])));
$cat_id = $db->real_escape_string(trim($_POST['cat_id']));
$image = $db->real_escape_string(trim($_POST['image']));
$link_order = $db->real_escape_string(trim($_POST['link_order']));
$description = $db->real_escape_string(trim($_POST['description']));

$sql = "
	INSERT INTO `links` (`link`, `name`, `image`, `cat_id`, `link_order`, `description`) VALUES ('$link', '$name', '$image', '$cat_id', '$link_order', '$description')
";

$db->query($sql);

header('Location: ../');