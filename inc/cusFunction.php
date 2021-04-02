<?php
/**
 * Created by Notepad.
 * User: Lak
 * Date: 10/29/13
 */

function _page($var){
	$ext = "";
    switch($var):
    	case "flightairticket":
    		return get_bloginfo('url')."/ve-may-bay".$ext;
        case "flightresult":
            return get_bloginfo('url')."/chon-hanh-trinh".$ext;
        case "passenger":
            return get_bloginfo('url')."/thong-tin-hanh-khach".$ext;
        case "payment":
            return get_bloginfo('url')."/thong-tin-thanh-toan".$ext;
        case "complete":
            return get_bloginfo('url')."/hoan-tat-don-hang".$ext;
        case "flightinfo":
            return get_bloginfo('url')."/get-flight-info".$ext;
        case "flightdetail":
            return get_bloginfo('url')."/get-flight-detail".$ext;
        case "paymentinfo":
            return get_bloginfo("url")."/huong-dan-thanh-toan".$ext;
		case "bookguideinfo":
            return get_bloginfo("url")."/huong-dan-dat-ve".$ext;
        case "vnalink":
            return get_bloginfo("url")."/resultvietnamairlines".$ext;
        case "vjlink":
            return get_bloginfo("url")."/resultvietjet".$ext;
        case "jslink":
            return get_bloginfo("url")."/resultjetstar".$ext;
        case "qhlink":
            return get_bloginfo("url")."/resultbambooairways".$ext;
        case "sabrelink":
            return get_bloginfo("url")."/resultsabre".$ext;
		case "airportlink":
            return get_bloginfo("url")."/get-airportcode".$ext;
		case "checkcaptcha":
            return get_bloginfo("url")."/check-captcha".$ext;
		case "hotelresult":
            return get_bloginfo("url")."/core/hotel-search.php";		
		case "hotelguest":
            return get_bloginfo("url")."/dat-phong";	
		case "hotelcomplete":
            return get_bloginfo("url")."/hoan-tat-dat-phong";
			
		case "cheapflightsearch":
            return get_bloginfo("url")."/ve-re-trong-thang";	
			
    endswitch;
}

function _getHinhDaiDien($postID=""){

    if($postID=="")
    {
        global $post;
        $postID=$post->ID;
    }
    $imgID=get_post_thumbnail_id($postID);

    if($imgID!=""){
        $img=wp_get_attachment_image_src($imgID,"medium");

        return $img[0];
    }else
        return "";
}

function _getDes($postID=""){
    if($postID=="")
    {
        global $post;
        $postID=$post->ID;
    }
    if(is_front_page() || is_home()){
        return get_option('opt_description');
    }
    if(is_singular()){
        return get_post_meta($postID,"fl_description",true);
    }

    if(is_category()){
        global $page, $paged;
        $category = get_category( get_query_var( 'cat' ) );
        $cat_id = $category->cat_ID;
        $pagetext='';
        if ( $paged >= 2 || $page >= 2 ){
            $pagetext=", Trang ".max( $paged, $page );
        }
        return strip_tags(category_description($cat_id)).$pagetext;
    }

    if(is_tax()){
        global $page, $paged;
        $termid=get_queried_object()->term_id;

        $pagetext='';
        if ( $paged >= 2 || $page >= 2 ){
            $pagetext=", Trang ".max( $paged, $page );
        }
        return strip_tags(term_description($termid)).$pagetext;
    }


}

function _getKey($postID=""){
    if($postID=="")
    {
        global $post;
        $postID=$post->ID;
    }
    if(is_home() || is_front_page()){
        return get_option('opt_keywords');
    }
    if(is_singular()){
        return get_post_meta($postID,"fl_keywords",true);
    }
}

function get_attachment_id_from_src($image_src) {
     global $wpdb;
     $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
     $id = $wpdb->get_var($query);
     return $id;
}

// get flight from webservice
function get_flight_from_ws($airline, $depcode, $descode, $depdate, $retdate, $direction=1, $format='json'){
	
	$airline = strtoupper(trim($airline));
	$depcode = strtoupper(trim($depcode));
	$descode = strtoupper(trim($descode));
	$depdate = str_replace('/','-',$depdate);
	$retdate = isset($retdate) && !empty($retdate) ? str_replace('/','-',$retdate) : $depdate; 
	$api_key = '70cd2199f6dc871824ea9fed45170af354ffe9e6';
    
    $timeout = 30;
    
	if ($airline == 'VN' || $airline == 'QH') {
        $urls = array(
            // 'http://fs2.vietjet.net',
            'http://fs3.vietjet.net',
            'http://fs4.vietjet.net',
            'http://fs5.vietjet.net',
            'http://fs6.vietjet.net',
            'http://fs7.vietjet.net',
            'http://fs8.vietjet.net',
            'http://fs9.vietjet.net',
            'http://fs10.vietjet.net',
            'http://fs11.vietjet.net',
            'http://fs12.vietjet.net',
            'http://fs13.vietjet.net',
            'http://fs14.vietjet.net',
            'http://fs15.vietjet.net',
            'http://fs16.vietjet.net',
            'http://fs17.vietjet.net',
            'http://fs18.vietjet.net',
            'http://fs19.vietjet.net',
            'http://fs20.vietjet.net',
            'http://fs21.vietjet.net',
            'http://fs22.vietjet.net',
            'http://fs23.vietjet.net',
            'http://fs24.vietjet.net',
            'http://fs25.vietjet.net',
            'http://fs26.vietjet.net',
            'http://fs27.vietjet.net',
            'http://fs28.vietjet.net',
            'http://fs29.vietjet.net',
            'http://fs30.vietjet.net',
        );
    } else if ($airline == 'VJ' || $airline == 'BL'){
        $timeout = 35;
        $urls = array(
            'http://fs2.vietjet.net',
        );
    }

    shuffle($urls);
    $url = $urls[array_rand($urls)];
	$url .= '/index.php/apiv1/api/flight_search/format/'.$format;
	$url .= '/airline/'.$airline.'/depcode/'.$depcode.'/descode/'.$descode.'/departdate/'.$depdate.'/returndate/'.$retdate.'/direction/'.$direction;

	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_ENCODING, 'gzip');
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('X-API-KEY: '.$api_key));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    $buffer = curl_exec($curl_handle);

    curl_close($curl_handle);
    $result = json_decode($buffer, true);

	return $result;
}

function remove_today_past_time_flight($data, $plus_hours = 3)
{
    $new_data = array();
    $today = date('Y-m-d');
    $curr_time = strtotime('+' . $plus_hours . ' hours');
    foreach ($data as $flight) {
        $dep_time = strtotime($today . ' ' . $flight['deptime']);
        if ($dep_time >= $curr_time) {
            $new_data[] = $flight;
        }
    }

    return $new_data;
}

// get flight inter from webservice
function get_flight_inter_from_ws($depcode, $arvcode, $outbound_date, $inbound_date, $adult, $child, $infant, $triptype='ROUND_TRIP', $format='json'){
	
	$outbound_date = str_replace('/','-',$outbound_date);
	$inbound_date = isset($inbound_date) && !empty($inbound_date) ? str_replace('/','-',$inbound_date) : $outbound_date;
	$api_key = '70cd2199f6dc871824ea9fed45170af354ffe9e6';
	$supplier = 'hnh';
	
	$url = 'http://api.vemaybaynamphuong.com/index.php/apiv1/api/flight_search_inter/format/'.$format;
	$url .= '/supplier/'.$supplier;
	$url .= '/depcode/'.$depcode;
	$url .= '/arvcode/'.$arvcode;
	$url .= '/outbound_date/'.$outbound_date;
	$url .= '/inbound_date/'.$inbound_date;
	$url .= '/adult/'.$adult;
	if($child > 0){
		$url .= '/child/'.$child;
	}
	if($infant > 0){
		$url .= '/infant/'.$infant;
	}
	$url .= '/triptype/'.$triptype;
	
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('X-API-KEY: '.$api_key));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	$result = json_decode($buffer, true);
	return $result;
}

// search airport
function get_airport_from_ws($term, $case_sensitive=0, $format='json'){
	$url = 'http://api.vemaybaynamphuong.com/index.php/apiv1/api/airport_search/format/'.$format.'/term/'.$term.'/case_sensitive/'.$case_sensitive;
	$api_key = '70cd2199f6dc871824ea9fed45170af354ffe9e6';
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('X-API-KEY: '.$api_key));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	$result = json_decode($buffer, true);
	return $result;
}

// check client request
function check_client_request($domain, $ip_address, $req_time_allow){
	$api_key = '70cd2199f6dc871824ea9fed45170af354ffe9e6';
	$url = 'http://api.vemaybaynamphuong.com/index.php/apiv1/clientrequestlogs/get_client_request/format/json/';
	$url .= 'domain/'.$domain.'/ip_address/'.$ip_address.'/req_time_allow/'.$req_time_allow;
	
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('X-API-KEY: '.$api_key));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	$result = json_decode($buffer, true);
	return $result;
}

// log client request
function log_client_request($domain, $ip_address, $req_content){
	$api_key = '70cd2199f6dc871824ea9fed45170af354ffe9e6';
	$url = 'http://api.vemaybaynamphuong.com/index.php/apiv1/clientrequestlogs/create_client_request/format/json/';
	$url .= 'domain/'.$domain.'/ip_address/'.$ip_address.'/req_content/'.$req_content;
	
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('X-API-KEY: '.$api_key));
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	$result = json_decode($buffer, true);
	return $result;
}

// Function to get the client ip address
function get_ip_address_from_client() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
function dat_xe($post_data){
	$url = 'http://api.vemaybay.website/index.php/bookings/Api_v1/save_car_booking';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'NP-API-KEY: 70cd2199f6dc871824ea9fed45170af354ffe9e6'
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	$search_data = curl_exec($ch);
	$result = json_decode($search_data,true);
	return $result;
}

/**
 * Check IP address in CIDR blacklist
 * @params string $ip ip address
 * @return bool
 */
function checkCIDRBlacklist($ip)
{
    $us_backlist = array(
        //'23','24','50','63','64','65','66','67','68','69','70','71','72','73','74','75','76','96','97',
        //'98','99','100','104','107','108','142','162','163','172','173','174','184','192','198','199','204','205','206','207','208','209','216'
    );
    $cidr = substr($ip, 0, strpos($ip, '.')); // xxx
    if(!empty($us_backlist) && in_array($cidr, $us_backlist))
        return true;

    $blacklist = array(
        //'27.67',
        //'27.74',
        //'171.253',
        //'171.249',
        //'59.153',
        //'113.185',
        //'113.161',
        //'115.84',
        //'115.73',
        //'117.0',
        //'117.1',
        //'117.2',
        //'117.3',
        //'117.4',
        //'117.5',
        //'125.212',
        //'123.31',
        //'123.24',
        //'101.99',
        //'58.187', // FPT
        //'183.80', // FPT
        //'183.81', // FPT
        //'42.112', // FPT
        //'42.117', // FPT
        //'1.52', // FPT
        //'1.53', // FPT
    );
    //$cidr = substr($ip, 0, strrpos($ip, '.')); // xxx.xxx.xxx
    $cidr = substr($ip, 0, strpos($ip, '.', strpos($ip, '.') + 1)); // xxx.xxx
    if(!empty($blacklist) && in_array($cidr, $blacklist))
        return true;
    else
        return false;
}

function gen_random_string($len = 12)
{
    return substr(sha1(microtime()), 0, $len);
}
