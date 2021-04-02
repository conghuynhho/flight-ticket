<?php
    if(empty($_GET['term'])) exit;
	$term = $_GET['term'];
	$result = get_airport_from_ws($term);
    echo json_encode($result['data']);
?>