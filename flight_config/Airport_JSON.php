<?php

sleep( 1 );
// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;
$q = strtolower($_GET["term"]);
// remove slashes if they were magically added
if (get_magic_quotes_gpc()) $q = stripslashes($q);

$string = file_get_contents("http://vemaybay5s.com/wp-content/themes/flight/flight_config/JSON/airports.json");
$json_a=json_decode($string,true);

$count_arr = count($json_a);

$result_array = array();
for($i = 0; $i < $count_arr; $i++){
	
 	if (strpos(strtolower($json_a[$i]['code']), $q) !== false || strpos(strtolower($json_a[$i]['name']), $q) !== false || strpos(strtolower($json_a[$i]['location']), $q) !== false) {
		array_push($result_array, array(
										"label" => $json_a[$i]['location'].' ('.$json_a[$i]['code'].')'
									  , "value" => $json_a[$i]['location'].' ('.$json_a[$i]['code'].')'
									  , "code" => strip_tags($json_a[$i]['code'])
									  , "location" => $json_a[$i]['location']
									  ));
	}
	
	if (count($result_array) > 11)
		break;
		
}


echo json_encode($result_array);


?>