<?php 
$GLOBALS['api_key'] = '70cd2199f6dc871824ea9fed45170af354ffe9e6';

function getSabreInterFlight($airline, $dep_code, $arv_code, $dep_date, $ret_date = '', $trip_type = 1, $adt_count = 1, $chd_count = 0, $inf_count = 0, $is_inter = false, $format = 'json', $timeout = 30, $use_proxy = false)
{
    $allowed_airlines = array('VN', 'VJ', 'BL', 'QH', 'SABRE');
    $airline = strtoupper(preg_replace('/\W/', '', $airline));
    if (empty($airline) || !in_array($airline, $allowed_airlines)) {
        return false;
    }

    $dep_code = strtoupper(preg_replace('/\W/', '', $dep_code));
    $arv_code = strtoupper(preg_replace('/\W/', '', $arv_code));
    $dep_date = str_replace('/', '-', preg_replace('/[^\d\/]/', '', $dep_date));
    $ret_date = !empty($ret_date) ? str_replace('/', '-', preg_replace('/[^\d\/]/', '', $ret_date)) : $dep_date;

    if ($airline == 'VN' || $airline == 'QH' || $airline == 'SABRE') {
        $urls = array(
            'http://fs2.vietjet.net',
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
    } else if ($airline == 'BL' || $airline == 'VJ') {
        $timeout = 35;
        $use_proxy = true;
        $urls = array(
            'http://fs.vietjet.net',
        );
    } 
    
    $url = $urls[array_rand($urls)];
    $url .= '/index.php/apiv1/api/flight_search' . ($is_inter ? '_inter' : '') . '/format/' . $format . '/use_proxy/' . ($use_proxy ? '1' : '0');
    if ($is_inter) {
        $url .= '/airline/' . $airline . '/depcode/' . $dep_code . '/arvcode/' . $arv_code;
        $url .= '/depdate/' . $dep_date . '/retdate/' . $ret_date . '/triptype/' . $trip_type;
        $url .= '/adult/' . $adt_count . '/child/' . $chd_count . '/infant/' . $inf_count;
        if ($airline == 'SABRE') {
            $url .= '/agentid/' . preg_replace('/\W/', '', get_option('opt_sabre_agent_id'));
        }
    } 
    // else {
    //     $url .= '/airline/' . $airline . '/depcode/' . $dep_code . '/descode/' . $arv_code;
    //     $url .= '/departdate/' . $dep_date . '/returndate/' . $ret_date . '/direction/' . $trip_type;
    // }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-API-KEY: ' . $GLOBALS['api_key']));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($json, true);

    return $result;
}

function pushHTMLSabre($rows, $airportCode, $tripType = 1, $adtCount = 1, $chdCount = 0, $infCount = 0) {
    $xhtml = '';
    $idKey = 0;
    
        foreach ($rows as $row) {
            /* GET VALUES ONE-WAYS */
            $depNameAirlines = strpos($row['dep']['airline'], '-') ? substr($row['dep']['airline'], 0, strpos($row['dep']['airline'], '-')) : $row['dep']['airline'];
            $depNameAirlinesCode = strpos($row['dep']['airlinecode'], '-') ? substr($row['dep']['airlinecode'], 0, strpos($row['dep']['airlinecode'], '-')) : $row['dep']['airlinecode'];
            $depDepTime = $row['dep']['deptime'];
            $depArvTime = $row['dep']['arvtime'];
            $depDuration = $row['dep']['duration'];
            $depNDuration = $row['dep']['nduration'];
            $depStop = $row['dep']['stop'];
            $depBreakingPoint = ($row['dep']['stop'] == 0 ? 'Bay thẳng' : $row['dep']['stop'] . ' điểm dừng');
            $deptotalTimeDetail = convertHour($depDuration);   
            $depDepCity = $row['dep']['dep'];   
            $depArvCity = $row['dep']['arv'];        
            /* GET VALUES ROUND-TRIP */
            $retNameAirlines = strpos($row['ret']['airline'], '-') ? substr($row['ret']['airline'], 0, strpos($row['ret']['airline'], '-')) : $row['ret']['airline'];
            $retNameAirlinesCode = strpos($row['ret']['airlinecode'], '-') ? substr($row['ret']['airlinecode'], 0, strpos($row['ret']['airlinecode'], '-')) : $row['ret']['airlinecode'];
            $retDepTime = $row['ret']['deptime'];
            $retArvTime = $row['ret']['arvtime'];
            $retDuration = $row['ret']['duration'];
            $retNDuration = $row['ret']['nduration'];
            $retStop = $row['ret']['stop'];
            $retBreakingPoint = ($row['ret']['stop'] == 0 ? 'Bay thẳng' : $row['ret']['stop'] . ' điểm dừng');
            $rettotalTimeDetail = convertHour($retDuration);
            $retDepCity = $row['ret']['dep'];   
            $retArvCity = $row['ret']['arv'];
            /* GET PRICE + FEETAX - ADULT - CHILD - INFANT */
            if (!$tripType) {
                $totalAdult = $adtCount * 2;
                $totalChild = $chdCount * 2;
                $totalInfant = $infCount * 2;
            }else {
                $totalAdult = $adtCount;
                $totalChild = $chdCount;
                $totalInfant = $infCount;
            }
            $serviceFee = getInterServiceFeeV2($airportCode, $totalAdult, $totalChild, $totalInfant);                                
            $totalPayPrice = $row['total'] + $serviceFee['totalsvfee'];
    
            $idInterKey = $depNameAirlinesCode.time().$idKey;
            session_start();					
            $_SESSION['result_inter'][$idInterKey] = $row;
            session_write_close();
    
        $xhtml.= '<tr data-airline="'.$depNameAirlinesCode.'" data-ischeapairline="1" class="box-result select-flight best-price-hightlight" id="0" data-id="departureFlight" data-stopno="'.$depStop.'" data-duration="'.$depDuration.'" data-returnduration="'.$retDuration.'" data-departure="'.$depDepTime.'" data-arrivaltime="'.$depArvTime.'" data-price="'.$totalPayPrice.'">
                    <td>
                        <span class="departure">
                            <span class="info-airlines">
                                <span class="airline">
                                    <img src="'.imgdir.'/airlines-logo/'.$depNameAirlinesCode.'.png" alt="'.$depNameAirlines.'">
                                    <span style="display:none" class="fightAirline" data-val="'.$depNameAirlines.'"></span>
                                    <span class="name-airlines">'.$depNameAirlines.'</span>
                                </span>
                            </span>
                            <span class="airlines-city-departure">'.$depDepCity.' - '.$depArvCity.'</span>
                            <span class="flight-time">
                                <span class="time">'.$depDepTime.' - '.$depArvTime.'</span>
                                <span class="flgiht-time-more">
                                    <span class="duration">'.$depNDuration.'</span>
                                    <span class="breakingPoint stop-info" data-no="'.$depStop.'">'.$depBreakingPoint.'</span>
                                </span>
                            </span>
                        </span>';
                        if(!$tripType) {
        $xhtml.=        '<span class="return">
                            <span class="info-airlines">
                                <span class="airline">
                                    <img src="'.imgdir.'/airlines-logo/'.$retNameAirlinesCode.'.png" alt="'.$retNameAirlines.'">
                                    <span style="display:none" class="fightAirline" data-val="'.$retNameAirlines.'"></span>
                                    <span class="name-airlines">'.$retNameAirlines.'</span>
                                </span>
                            </span>
                            <span class="airlines-city-return">'.$retDepCity.' - '.$retArvCity.'</span>
                            <span class="flight-time">
                                <span class="time">'.$retDepTime.' - '.$retArvTime.'</span>
                                <span class="flgiht-time-more">
                                    <span class="duration">'.$retNDuration.'</span>
                                    <span class="breakingPoint stop-info" data-no="'.$retStop.'">'.$retBreakingPoint.'</span>
                                </span>
                            </span>
                        </span>';                                    
                        }    
        $xhtml.=    '</td>  
                    <td class="flight-price">
                        <strong class="multi-cury" data-val="'.$totalPayPrice.'">'.format_price_nocrc($totalPayPrice).' <small>VND</small></strong>
                        <i>(Đã bao gồm Thuế &amp; Phí)</i>';
                        if(!$tripType) {
        $xhtml.=            '<input type="radio" name="selectflightdep" class="selectflight" value="'.$idInterKey.'" id="sm_fselect'.$idInterKey.'" hidden="true">
                            <label for="sm_fselect'.$idInterKey.'" class="flag-choose-flight" onclick="selectFlightInter('.$tripType.',\''.$idInterKey.'\');">Chọn</label>';                                        
                        }
                        else {
        $xhtml.=            '<input type="radio" name="selectflightdep" class="selectflight" value="'.$idInterKey.'" id="sm_fselect'.$idInterKey.'" hidden="true">
                            <label for="sm_fselect'.$idInterKey.'" class="flag-choose-flight" onclick="selectFlightInter('.$tripType.',\''.$idInterKey.'\');">Chọn</label>';                                        
                        }
        $xhtml.=    '</td>
                    <td class="view-flight-info">
                        <a href="javascript:void(0);" class="viewflightinfo class-view-fdetail" id="button-click-view">Chi tiết</a>
                    </td>
                    <td class="flight-detail-content-inline" style="display:none">
                        <h4>1. Chi tiết chiều đi <span>(Tổng thời gian: '.$deptotalTimeDetail.')</span></h4>
                        <input type="hidden" name="DepartureFlightsTotalTime" value="'.$deptotalTimeDetail.'" />';
                        $i = 0;
                        foreach ($row['dep']['fdetail'] as $key => $fdetail) {   
        $xhtml.=        '<div id="flight-info-route">
                            <div class="clearfix">
                                <div class="departure-time">
                                    <b class="time">'.$fdetail['deptime'].'</b>
                                    <span>'.date('d/m/Y', strtotime($fdetail['depdate'])).'</span>
                                    <span class="location">'.$fdetail['depcityname'].'  ('.$fdetail['dep'].')</span>
                                </div>
                                <div class="arrival-time">
                                    <b class="time">'.$fdetail['arvtime'].'</b>
                                    <span>'.date('d/m/Y', strtotime($fdetail['arvdate'])).'</span>
                                    <span class="location">'.$fdetail['arvcityname'].'  ('.$fdetail['arv'].')</span>
                                </div>
                                <div class="airlines-info">
                                    <span class="airlines-code"><u class="text">Hãng:</u> <b>'.$fdetail['airline'].'</b></span>
                                    <span class="airlines-code"><u class="text">Mã chuyến bay:</u> <b>'.$fdetail['flightno'].'</b></span>
                                    <span class="airlines-type"><u class="text">Loại máy bay:</u> <b>'.$fdetail['aircraft'].'</b></span>
                                    <span><u class="text">Hạng chỗ:</u> <b>'.$fdetail['class'].'</b></span>
                                    <span><u class="text">Thời gian bay:</u> <b>'.$fdetail['nduration'].'</b></span>
                                </div>
                            </div>';
                            if (isset($row['dep']['transit'][$i]['arv'])) {
        $xhtml.=                '<div class="flight-info-transit">
                                    <span>Thay đổi máy bay tại <b>'.$row['dep']['transit'][$i]['arvcityname'].'  ('.$row['dep']['transit'][$i]['arvcity'].')</b>
                                    - Thời gian giữa các chuyến bay: <b>'.$row['dep']['transit'][$i]['nduration'].'</b></span>
                                </div>'; 
                            }
        $xhtml.=        '</div>';
                        $i++;
                        }
                        if(!$tripType) {
        $xhtml.=        '<h4>2. Chi tiết chiều về <span>(Tổng thời gian: '.$rettotalTimeDetail.')</span></h4>';
                        } 
                        if (!empty($row['ret']['fdetail'][0]['dep'])) {
                        $j = 0;
                        foreach ($row['ret']['fdetail'] as $fdetail) {
        $xhtml.=        '<div id="flight-info-route">
                            <div class="clearfix">
                                <div class="departure-time">
                                    <b class="time">'.$fdetail['deptime'].'</b>
                                    <span>'.date('d/m/Y', strtotime($fdetail['depdate'])).'</span>
                                    <span class="location">'.$fdetail['depcityname'].'  ('.$fdetail['dep'].')</span>
                                </div>
                                <div class="arrival-time">
                                    <b class="time">'.$fdetail['arvtime'].'</b>
                                    <span>'.date('d/m/Y', strtotime($fdetail['arvdate'])).'</span>
                                    <span class="location">'.$fdetail['arvcityname'].'  ('.$fdetail['arv'].')</span>
                                </div>
                                <div class="airlines-info">
                                    <span class="airlines-name"><u class="text">Hãng:</u> <b>'.$fdetail['airline'].'</b></span>
                                    <span class="airlines-code"><u class="text">Mã chuyến bay:</u> <b>'.$fdetail['flightno'].'</b></span>
                                    <span class="airlines-type"><u class="text">Loại máy bay:</u> <b>'.$fdetail['aircraft'].'</b></span>
                                    <span><u class="text">Hạng chỗ:</u> <b>'.$fdetail['class'].'</b></span>
                                    <span><u class="text">Thời gian bay:</u> <b>'.$fdetail['nduration'].'</b></span>
                                </div>
                            </div>';
                            if (isset($row['ret']['transit'][$j]['arv'])) {
        $xhtml.=                '<div class="flight-info-transit">
                                    <span>Thay đổi máy bay tại <b>'.$row['ret']['transit'][$j]['arvcityname'].'  ('.$row['ret']['transit'][$j]['arvcity'].')</b>
                                    - Thời gian giữa các chuyến bay: <b>'.$row['ret']['transit'][$j]['nduration'].'</b></span>
                                </div>';                                                    
                            }
        $xhtml.=        '</div>';
                        $j++;
                        }                    
                        }              
        $xhtml.=    '</td>  
                        </tr>';   
            $idKey++;
        }
    
        return $xhtml;
    
    
}

function convertHour($value) {
    $hours = abs(floor($value / 3600));
    $minutes = abs(floor(($value / 60) % 60));
    return $hours.'h'.' '.$minutes.'m';
}

function getInterServiceFee($airportCode, $adt_count = 1, $chd_count = 0, $inf_count = 0, $optPrefix = 'opt_') {
    $southeast_asia = explode(',', get_option($optPrefix . 'southeast_asia_airport'));
    $northeast_asia = explode(',', get_option($optPrefix . 'northeast_asia_airport'));
    $europe_airport = explode(',', get_option($optPrefix . 'europe_airport'));
    $americas = explode(',', get_option($optPrefix . 'americas_airport'));
    $australia = explode(',', get_option($optPrefix . 'australia_airport'));
    $africa = explode(',', get_option($optPrefix . 'africa_airport'));
    $data = array();
    if (!empty($southeast_asia[0]) && in_array($airportCode, $southeast_asia)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'southeast_asia_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'southeast_asia_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'southeast_asia_infant_svfee');
    } elseif (!empty($northeast_asia[0]) && in_array($airportCode, $northeast_asia)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'northeast_asia_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'northeast_asia_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'northeast_asia_infant_svfee');
    } elseif (!empty($europe_airport[0]) && in_array($airportCode, $europe_airport)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'europe_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'europe_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'europe_infant_svfee');
    } elseif (!empty($americas[0]) && in_array($airportCode, $americas)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'americas_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'americas_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'americas_infant_svfee');
    } elseif (!empty($australia[0]) && in_array($airportCode, $australia)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'australia_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'australia_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'australia_infant_svfee');
    } elseif (!empty($africa[0]) && in_array($airportCode, $africa)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'africa_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'africa_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'africa_infant_svfee');
    } else {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'inter_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'inter_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'inter_infant_svfee');
    }

    $data['adtsvfee'] += ($data['adtsvfee'] * $adt_count);
    $data['chdsvfee'] += ($data['chdsvfee'] * $chd_count);
    $data['infsvfee'] += ($data['infsvfee'] * $inf_count);
    $data['totalsvfee'] = $data['adtsvfee'] + $data['chdsvfee'] + $data['infsvfee'];

    return $data;
}

function getInterServiceFeeV2($airportCode, $adt_count = 1, $chd_count = 0, $inf_count = 0 ,$optPrefix = 'opt_') {
    $southeast_asia = explode(',', get_option($optPrefix . 'southeast_asia_airport'));
    $northeast_asia = explode(',', get_option($optPrefix . 'northeast_asia_airport'));
    $europe_airport = explode(',', get_option($optPrefix . 'europe_airport'));
    $americas = explode(',', get_option($optPrefix . 'americas_airport'));
    $australia = explode(',', get_option($optPrefix . 'australia_airport'));
    $africa = explode(',', get_option($optPrefix . 'africa_airport'));
    $data = array();
    if (!empty($southeast_asia[0]) && in_array($airportCode, $southeast_asia)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'southeast_asia_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'southeast_asia_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'southeast_asia_infant_svfee');
    } elseif (!empty($northeast_asia[0]) && in_array($airportCode, $northeast_asia)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'northeast_asia_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'northeast_asia_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'northeast_asia_infant_svfee');
    } elseif (!empty($europe_airport[0]) && in_array($airportCode, $europe_airport)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'europe_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'europe_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'europe_infant_svfee');
    } elseif (!empty($americas[0]) && in_array($airportCode, $americas)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'americas_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'americas_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'americas_infant_svfee');
    } elseif (!empty($australia[0]) && in_array($airportCode, $australia)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'australia_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'australia_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'australia_infant_svfee');
    } elseif (!empty($africa[0]) && in_array($airportCode, $africa)) {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'africa_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'africa_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'africa_infant_svfee');
    } else {
        $data['adtsvfee'] = (int) get_option($optPrefix . 'inter_adult_svfee');
        $data['chdsvfee'] = (int) get_option($optPrefix . 'inter_child_svfee');
        $data['infsvfee'] = (int) get_option($optPrefix . 'inter_infant_svfee');
    }

    $data['adtsvfee'] = (int)$data['adtsvfee'] * $adt_count;
    $data['chdsvfee'] = (int)$data['chdsvfee'] * $chd_count;
    $data['infsvfee'] = (int)$data['infsvfee'] * $inf_count;
    $data['totalsvfee'] = $data['adtsvfee'] + $data['chdsvfee'] + $data['infsvfee'];

    return $data;
}

function _debug($data) {

    echo '<pre style="background: #000; color: #fff; width: 100%; overflow: auto">';
    echo '<div>Your IP: ' . $_SERVER['REMOTE_ADDR'] . '</div>';

    $debug_backtrace = debug_backtrace();
    $debug = array_shift($debug_backtrace);

    echo '<div>File: ' . $debug['file'] . '</div>';
    echo '<div>Line: ' . $debug['line'] . '</div>';

    if(is_array($data) || is_object($data)) {
        print_r($data);
    }
    else {
        var_dump($data);
    }
    echo '</pre>';
}

/* FIX API ONE WAYS AND ROUND TRIP - MEL - SYD */
function removeItemOneWays($arrayInput, $oneways = 'dep') {
    $data = $arrayInput['data'];
    $check = false;
    $result = array();
    foreach ($data as $key => $value){
        foreach($value[$oneways] as $key => $valueChild){
            if(gettype($valueChild) == 'array'){
                foreach($valueChild as $key => $valueSubChild){
                    if($valueSubChild['arv'] == '')
                    $check = true;
                    break;
                }
                continue;
            }
            if($valueChild == ""){
                $check = true;
            } 
            break;  
        }
        if($check == true){
         // NOT: your code here!
        }else{
            array_push($result,$value);
        }
        $check = false;
    }
    return $result = array('data' => $result);
}

function removeItemRoudTrip($arrayInput, $oneways = 'dep', $roudtrip = 'ret') {
    $data = $arrayInput['data'];
    $result = array();
    $check = false;
    foreach ($data as $key => $value) {
        foreach($value[$oneways] as $key => $valueDepart){
            if($valueDepart == '')
            $check = true;
            break;
        }
        foreach ($value[$roudtrip] as $key => $valueReturn) {
            if($valueReturn == '')
            $check = true;
            break;
        }
        if($check == true){
         // NOT: your code here!
        }else{
            array_push($result,$value);
        }
        $check = false;
    }
    return $result = array('data' => $result);
}