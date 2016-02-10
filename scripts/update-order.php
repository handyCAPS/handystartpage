<?php


require_once 'db/connection.php';
require_once 'query.php';

$sql = array();

foreach ($_GET['linkid'] as $key => $linkid) {
    $sql[] = "UPDATE links SET link_order = $key WHERE id = $linkid";
}

$result = $db->multi_query(implode(';', $sql));

echo json_encode(array('success' => $result));