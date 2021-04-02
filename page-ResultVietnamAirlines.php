<?php
/**
 * Template Name: RS VNAir
 */
ini_set('max_execution_time', 120);
date_default_timezone_set("Asia/Ho_Chi_Minh");
$curr_time = time();
$startime = microtime(true);
$refer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domain = preg_replace('(^https?://)', '', get_bloginfo('url'));
$ip_address = get_ip_address_from_client();
$sessionid = clearvar($_POST["enCode"]);
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$req_count_allow = $_SESSION['fl_req_count_allow'];
$req_count = $_SESSION['fl_req_count'];
//$geoip_country_code = getenv(GEOIP_COUNTRY_CODE);
$expired_time = 0; // in seconds
$file = dirname(__FILE__)."/flight_config/squery.json";
$squery = json_decode(file_get_contents($file),true);

if( !isset($_POST[$_SESSION['fl_token']])
	|| (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') // if not ajax
    || empty($ip_address)
    || $ip_address == 'UNKNOWN'
    || (checkCIDRBlacklist($ip_address) && !$_SESSION['fl_captcha_ok'])
    || empty($_POST["enCode"])
    || !isset($_SESSION["SSID"][$sessionid])
    || ($req_count > $req_count_allow && !$_SESSION['fl_captcha_ok'])
	|| $refer != $domain
    //|| ($geoip_country_code !== 'VN' && !$_SESSION['fl_captcha_ok'])
    || (empty($squery[$sessionid]) && $expired_time > 0 && ($curr_time - $_SESSION["SSID"][$sessionid]["s"]["exp"]) > $expired_time)
    || (!empty($squery[$sessionid]) && $expired_time > 0 && ($curr_time - $squery[$sessionid]["exp"]) > $expired_time)
    //|| $iPhone
){
    header('HTTP/1.0 403 Forbidden');
    exit;
}

//if($_POST["enCode"] && $_SESSION["SSID"][$_POST["enCode"]] && $refer == $domain){
	
    //$startime=microtime(true);
    //ini_set('max_execution_time', 130);
    //$sessionid=$_POST["enCode"];	
    $s=$_SESSION["SSID"][$sessionid]["s"];
	session_write_close();
	
    $direction=$s['way_flight'];
    $dep=$s['source'];
    $des=$s['destination'];
    $depdate=$s['depart'];
    $retdate=$s['return'];
    $adult=$s['adult'];
    $child=$s['children'];
    $infant=$s['infant'];
    
	$arr=get_flight_from_ws('VN', $dep, $des, $depdate, $retdate, $direction);
    //print_r($arr);
    //exit ;
	$rs=$arr['data'];
	$deprs=($direction==1)?$rs:$rs["dep"];
	$retrs=($direction==1)?array():$rs["ret"];     

    $kq=array();
    $index=0;
    if($direction==0){

        for($i=0;$i<count($deprs);$i++){
            $item=$deprs[$i];
            $crkey="vna".time().$index;

            $baseprice=$item['price'];
            $adultprice=$baseprice;
            $childprice=get_price_child($baseprice,'vietnamairline');
            $infantprice=get_price_infant($baseprice,'vietnamairline');

            $adulttax=getTaxFee_adult(($baseprice),'vietnamairline');
            $totaladult=($adultprice+$adulttax)*$adult;
            $totalchild=0;
            $totalinfant=0;

            $item['deptime']=trim(str_replace("Next Day Indicator","",$item['deptime']));
            $item['arvtime']=trim(str_replace("Next Day Indicator","",$item['arvtime']));

            $kq[0][$crkey]=array(
                'flightid'=>$crkey,
                'depcode'=>$item['dep'],
                'descode'=>$item['arv'],
                'depcity'=>getCityVn($item['dep']),
                'descity'=>getCityVn($item['arv']),
                'depdate'=>$depdate,
                'arvdate'=>$depdate,
                'deptime'=>$item['deptime'],
                'arvtime'=>$item['arvtime'],
                'baseprice'=>$baseprice,
                //'subtotal'=>$totaladult,
                'airline'=>'Vietnam Airlines',
                'depairport'=>$GLOBALS['AIRPORT'][$item['dep']],
                'desairport'=>$GLOBALS['AIRPORT'][$item['arv']],
                'flightno'=>$item['flightno'],
                'faretype'=>$item['class'],
                'adult'=>array(
                            'taxfee'=>$adulttax,
                            'total'=>$totaladult,
                        )
            );
            if($child>0){
                $childtax=getTaxFee_child($baseprice,'vietnamairline');
                $totalchild=($childtax+get_price_child($baseprice,'vietnamairline'))*$child;
                $kq[0][$crkey]['child']=array(
                    'baseprice'=>get_price_child($baseprice,'vietnamairline'),
                    'taxfee'=>$childtax,
                    'total'=>$totalchild,
                );
            }
            if($infant>0){
                $infanttax=getTaxFee_infant($baseprice,'vietnamairline');
                $totalinfant=($infanttax+get_price_infant($baseprice,'vietnamairline'))*$infant;
                $kq[0][$crkey]['infant']=array(
                    'baseprice'=>get_price_infant($baseprice,'vietnamairline'),
                    'taxfee'=>$infanttax,
                    'total'=>$totalinfant,
                );
            }
            $kq[0][$crkey]['subtotal']=($totaladult+$totalinfant+$totalchild);

            $index++;
        }

        for($i=0;$i<count($retrs);$i++){
            $item=$retrs[$i];
            $crkey="vna".time().$index;

            $baseprice=$item['price'];
            $adultprice=$baseprice;
            $childprice=get_price_child($baseprice,'vietnamairline');
            $infantprice=get_price_infant($baseprice,'vietnamairline');

            $adulttax=getTaxFee_adult(($baseprice),'vietnamairline');
            $totaladult=($adultprice+$adulttax)*$adult;
            $totalchild=0;
            $totalinfant=0;

            $item['deptime']=trim(str_replace("Next Day Indicator","",$item['deptime']));
            $item['arvtime']=trim(str_replace("Next Day Indicator","",$item['arvtime']));

            $kq[1][$crkey]=array(
                'flightid'=>$crkey,
                'depcode'=>$item['dep'],
                'descode'=>$item['arv'],
                'depcity'=>getCityVn($item['dep']),
                'descity'=>getCityVn($item['arv']),
                'depdate'=>$retdate,
                'arvdate'=>$retdate,
                'deptime'=>$item['deptime'],
                'arvtime'=>$item['arvtime'],
                'baseprice'=>$baseprice,
                'airline'=>'Vietnam Airlines',
                'depairport'=>$GLOBALS['AIRPORT'][$item['dep']],
                'desairport'=>$GLOBALS['AIRPORT'][$item['arv']],
                'flightno'=>$item['flightno'],
                'faretype'=>$item['class'],
                'adult'=>array(
                    'taxfee'=>$adulttax,
                    'total'=>$totaladult,
                )
            );

            if($child>0){
                $childtax=getTaxFee_child($baseprice,'vietnamairline');
                $totalchild=($childtax+get_price_child($baseprice,'vietnamairline'))*$child;
                $kq[1][$crkey]['child']=array(
                    'baseprice'=>get_price_child($baseprice,'vietnamairline'),
                    'taxfee'=>$childtax,
                    'total'=>$totalchild,
                );
            }
            if($infant>0){
                $infanttax=getTaxFee_infant($baseprice,'vietnamairline');
                $totalinfant=($infanttax+get_price_infant($baseprice,'vietnamairline'))*$infant;
                $kq[1][$crkey]['infant']=array(
                    'baseprice'=>get_price_infant($baseprice,'vietnamairline'),
                    'taxfee'=>$infanttax,
                    'total'=>$totalinfant,
                );
            }
            $kq[1][$crkey]['subtotal']=($totaladult+$totalinfant+$totalchild);

            $index++;
        }

    }
    else{
        for($i=0;$i<count($deprs);$i++){
            $item=$deprs[$i];
            $crkey="vna".time().$index;

            $baseprice=$item['price'];
            $adultprice=$baseprice;
            $childprice=get_price_child($baseprice,'vietnamairline');
            $infantprice=get_price_infant($baseprice,'vietnamairline');

            $adulttax=getTaxFee_adult(($baseprice),'vietnamairline');
            $totaladult=($adultprice+$adulttax)*$adult;
            $totalchild=0;
            $totalinfant=0;

            $item['deptime']=trim(str_replace("Next Day Indicator","",$item['deptime']));
            $item['arvtime']=trim(str_replace("Next Day Indicator","",$item['arvtime']));

            $kq[0][$crkey]=array(
                'flightid'=>$crkey,
                'depcode'=>$item['dep'],
                'descode'=>$item['arv'],
                'depcity'=>getCityVn($item['dep']),
                'descity'=>getCityVn($item['arv']),
                'depdate'=>$depdate,
                'arvdate'=>$depdate,
                'deptime'=>$item['deptime'],
                'arvtime'=>$item['arvtime'],
                'baseprice'=>$baseprice,
                'airline'=>'Vietnam Airlines',
                'depairport'=>$GLOBALS['AIRPORT'][$item['dep']],
                'desairport'=>$GLOBALS['AIRPORT'][$item['arv']],
                'flightno'=>$item['flightno'],
                'faretype'=>$item['class'],
                'adult'=>array(
                    'taxfee'=>$adulttax,
                    'total'=>$totaladult,
                )
            );
            if($child>0){
                $childtax=getTaxFee_child($baseprice,'vietnamairline');
                $totalchild=($childtax+get_price_child($baseprice,'vietnamairline'))*$child;
                $kq[0][$crkey]['child']=array(
                    'baseprice'=>get_price_child($baseprice,'vietnamairline'),
                    'taxfee'=>$childtax,
                    'total'=>$totalchild,
                );
            }
            if($infant>0){
                $infanttax=getTaxFee_infant($baseprice,'vietnamairline');
                $totalinfant=($infanttax+get_price_infant($baseprice,'vietnamairline'))*$infant;
                $kq[0][$crkey]['infant']=array(
                    'baseprice'=>get_price_infant($baseprice,'vietnamairline'),
                    'taxfee'=>$infanttax,
                    'total'=>$totalinfant,
                );
            }
            $kq[0][$crkey]['subtotal']=($totaladult+$totalinfant+$totalchild);

            $index++;
        }
    }

    @session_start();
   //$_SESSION['result']=array();
    $price_min=0;
    if(!empty($kq[0])){
        foreach($kq[0] as $key=>$val){
			
			if($price_min==0 ||  $val['baseprice']<$price_min){
                 $price_min=$val['baseprice'];
			}
			
            $_SESSION['result'][$key]=array(
                'airline' => 'vietnamairline',
                'dep' => $val['depcode'],
                'arv' => $val['descode'],
                'deptime' => $val['deptime'],
                'arvtime' => $val['arvtime'],
                'flightno' => $val['flightno'],
                'price' => $val['baseprice'],
                'class' => $val['faretype'],
                'stop' => 0
            );
        }
    }
    if(!empty($kq[1])){
        foreach($kq[1] as $key=>$val){
            $_SESSION['result'][$key]=array(
                'airline' => 'vietnamairline',
                'dep' => $val['depcode'],
                'arv' => $val['descode'],
                'deptime' => $val['deptime'],
                'arvtime' => $val['arvtime'],
                'flightno' => $val['flightno'],
                'price' => $val['baseprice'],
                'class' => $val['faretype'],
                'stop' => 0
            );
        }
    }
   
	if($price_min!=0){
        $file = dirname(__FILE__)."/flight_config/srecent.json";
        $json = json_decode(file_get_contents($file),true);
        if($json==NULL || empty($json)){
            $squery=array();
            $squery[$sessionid]=array(
                "depdate"=>date("d/m",time()),
                "from"=>$arrplace[$dep],
                "to"=>$arrplace[$des],
                "direction"=>($direction==0)?"Khứ hồi":"Một chiều",
                "total"=>($adult+$child+$infant),
                "price"=>$price_min,
                "ssid"=>$sessionid,
                "airline"=>"VN",
                "stime"=>time()
            );
            file_put_contents($file, json_encode($squery));
        }else{
            if($json[$sessionid]){
                if($json[$sessionid]["price"]>$price_min){
                    $json[$sessionid]["price"]=$price_min;
                    $json[$sessionid]["airline"]="vna";
                }
            }else{
                $tmpdate=explode("/",$depdate);
                $json[$sessionid]=array(
                    "depdate"=>$tmpdate[0]."/".$tmpdate[1],
                    "from"=>$arrplace[$dep],
                    "to"=>$arrplace[$des],
                    "direction"=>($direction==0)?"Khứ hồi":"Một chiều",
                    "total"=>($adult+$child+$infant),
                    "price"=>$price_min,
                    "ssid"=>$sessionid,
                    "airline"=>"VN",
                    "stime"=>time()
                );
            }
            file_put_contents($file, json_encode($json));
        }
    }
	session_write_close();
    echo json_encode($kq);
    if(current_user_can("moderate_comments"))
    {
        //echo "Total time ".(microtime(true)-$startime);
    }
    exit();
//}
?>