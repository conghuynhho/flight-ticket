<?php
/**
 * Template Name: RS Sabre
 */

 ini_set('max_execution_time', 120);
 date_default_timezone_set('Asia/Ho_Chi_Minh');
 $curr_time = time();
 $startime = microtime(true);
 $refer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
 $domain = parse_url(get_bloginfo('url'), PHP_URL_HOST);
 $ip_address = get_ip_address_from_client();
 $sessionid = clearvar($_POST['enCode']);
 $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
 $req_count_allow = $_SESSION['fl_req_count_allow'];
 $req_count = $_SESSION['fl_req_count'];
 $expired_time = 0; // in seconds
 $file = dirname(__FILE__) . '/flight_config/squery.json';
 $squery = json_decode(file_get_contents($file), true);
 
 if (!isset($_POST[$_SESSION['fl_token']])
     || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') // if not ajax
     || empty($ip_address)
     || $ip_address == 'UNKNOWN'
     || (checkCIDRBlacklist($ip_address) && !$_SESSION['fl_captcha_ok'])
     || empty($_POST['enCode'])
     || !isset($_SESSION['SSID'][$sessionid])
     || ($req_count > $req_count_allow && !$_SESSION['fl_captcha_ok'])
     || $refer != $domain
     || (empty($squery[$sessionid]) && $expired_time > 0 && ($curr_time - $_SESSION['SSID'][$sessionid]['s']['exp']) > $expired_time)
     || (!empty($squery[$sessionid]) && $expired_time > 0 && ($curr_time - $squery[$sessionid]['exp']) > $expired_time)
 ) {
     header('HTTP/1.0 403 Forbidden');
     exit;
 }

$s = $_SESSION["SSID"][$sessionid]["s"];
session_write_close();
	
$direction = $s['way_flight'];
$dep = $s['source'];
$des = $s['destination'];
$depdate = $s['depart'];
$retdate = $s['return'];
$adult = $s['adult'];
$child = $s['children'];
$infant = $s['infant'];
$is_inter = $s['isinter'];

$res = getSabreInterFlight('SABRE', $dep, $des, $depdate, $retdate, $direction, $adult, $child, $infant, $is_inter);
$rss = $res['data'];
// _debug($rss);
if($is_inter) {
    $filterAirlines = $res['airlines'];
    $interAirlines = '';
    foreach ($filterAirlines as $keyAirlines => $nameAirlines) {
        $interAirlines .= '<tr><td><label class="airname radio" for="rblAirline_'.$keyAirlines.'"><input class="airname" type="radio" value="'.$keyAirlines.'" name="rblAirline" id="rblAirline_'.$keyAirlines.'"><span class="outer"><span class="inner"></span></span> &nbsp;'.$nameAirlines.'</label></td><td><img class="airlogo" alt="'.$keyAirlines.'" src="'.imgdir.'/airlines-logo/'.$keyAirlines.'.png" alt="'.$keyAirlines.'"></td></tr>'; 
    }
    if(!empty($rss)) {
        echo pushHTMLSabre($rss, $des, $direction, $adult, $child, $infant);
    }
    // else {
    //     include_once(TEMPLATEPATH."/tplpart-emptyflight.php");
    // }
    
}

?>
<script type="text/javascript">
    $(function() {
        $('#inter-airlines').append('<?php echo $interAirlines; ?>');
    });
    $('#tblInterFlightList tr.select-flight').each(function() {
        var $showDrop = $(this);
        $("a.viewflightinfo", $showDrop).on("click",function(event) {
            event.preventDefault();
            $classDetail = $(".flight-detail-content-inline", $showDrop).addClass('show-box-flight-detail').show();
            $('.show-box-flight-detail').css("display", "block");
            $classDetail.toggle();
            $(".flight-detail-content-inline").not($classDetail).removeClass('show-box-flight-detail').hide();
            $('.show-box-flight-detail').css("display", "none");
            $classDetail.toggle();
            return false;
        });
    });

    $('html').on("click", function(e) {
        $('.flight-detail-content-inline').removeClass('show-box-flight-detail').hide();
        $('.flight-detail-content-inline').hide();
    });
</script>