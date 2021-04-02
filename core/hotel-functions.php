<?php
	function chi_tiet_khach_san($post_data){
		$url = 'http://api.vemaybay.website/index.php/hotels/Api_v1/show_hotels';
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'NP-API-KEY: a81c7ff7e800a451a646136146c29a36557f0061'
	    ));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $search_data = curl_exec($ch);
	    $result = json_decode($search_data,true);
	    $hotel = $result['hotels'][0];
	    return $hotel;
	}

	function dat_phong_khach_san($post_data){
		$url = 'http://api.vemaybay.website/index.php/bookings/Api_v1/save_hotel_booking';
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'NP-API-KEY: a81c7ff7e800a451a646136146c29a36557f0061'
	    ));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	    $search_data = curl_exec($ch);
	    $result = json_decode($search_data,true);
	    return $result;
	}
    