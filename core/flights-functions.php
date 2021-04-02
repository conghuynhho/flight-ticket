<?php
    function dat_ve_may_bay($post_data){
        $url = 'http://api.vemaybay.website/index.php/bookings/Api_v1/save_flight_booking';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        $result = json_decode($data,true);
        return $result;
    }
    function lay_gia_hanh_ly($post_data){
        $url = 'http://api.vemaybay.website/index.php/fares/Flights_v1/get_baggage';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        $result = json_decode($data,true);
        return $result;
    }
    function tim_ve_gia_re($post_data){
        $url = 'http://api.vemaybay.website/index.php/cheapflights/Api_v1/domes_searchs';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        $result = json_decode($data,true);
        return $result;
    }
    function tinh_gia_chuyen_bay($post_data){
        $url = 'http://api.vemaybay.website/index.php/fares/Flights_v1/calc_domes_fare';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $data = curl_exec($ch);
        $result = json_decode($data,true);
        return $result;
    }
    function xep_theo_gia_chuyen_bay($data){
        foreach ($data as $row) {
          foreach ($row as $key => $value){
            ${$key}[]  = $value;
          }  
        }
        array_multisort($base_price, SORT_ASC, $data);
        return $data; 
    }
    function tim_chuyen_bay($post_data){
    $url = 'http://api.vemaybay.website/index.php/flights/Api_v1/domes_searchs';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $search_data = curl_exec($ch);
    $result = json_decode($search_data,true);
    return $result;
    }
    function tim_chuyen_bay_vj($post_data){
    $url = 'http://api.vemaybay.website/index.php/flights/Api_v1/searchs';
    $ch = curl_init();
    $post_data['provider_code'] = 'VJ';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $search_data = curl_exec($ch);
    $result = json_decode($search_data,true);
    return $result;
    }
    function tim_chuyen_bay_vn($post_data){
    $url = 'http://api.vemaybay.website/index.php/flights/Api_v1/searchs';
    $ch = curl_init();
    $post_data['provider_code'] = 'VN';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $search_data = curl_exec($ch);
    $result = json_decode($search_data,true);
    return $result;
    }
    function tim_chuyen_bay_bl($post_data){
    $url = 'http://api.vemaybay.website/index.php/flights/Api_v1/searchs';
    $ch = curl_init();
    $post_data['provider_code'] = 'BL';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'NP-API-KEY: ed38c7ab82be8888f8ff0370f4d49c8bf00d5293'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $search_data = curl_exec($ch);
    $result = json_decode($search_data,true);
    return $result;
    }
    function re_date_vn($date){
        $day = substr($date,8,2);
        $mon = substr($date,5,2);
        $year = substr($date,0,4);
        $re_date = $day."-".$mon."-".$year;
        return $re_date;
    }
    function re_date($date){
        $day = substr($date,0,2);
        $mon = substr($date,3,2);
        $year = substr($date,6,4);
        $re_date = $year."-".$mon."-".$day;
        return $re_date;
    }
     function re_date_cheap($date){
        $day_now = date('d');
        $mon_now = date('m');
        if ($mon_now == substr($date,0,2)){
            $day = sprintf('%02d',$day_now);
        } else {
            $day = '01';
        }
        $re_date = substr($date,3,4)."-".substr($date,0,2)."-".$day;
        return $re_date;
    }
    function price_dot($strNum){
        if ($strNum == 0){
            return $strNum;
        } else {
            $len = strlen($strNum);
            $counter = 3;
            $result = "";
            while ($len - $counter >= 0)
            {
                $con = substr($strNum, $len - $counter , 3);
                $result = '.'.$con.$result;
                $counter+= 3;
            }
            $con = substr($strNum, 0 , 3 - ($counter - $len) );
            $result = $con.$result;
            if(substr($result,0,1)=='.'){
                $result=substr($result,1,$len+1);   
            }
            $price = substr($result,0,-3);
            return $price."000";
        }  
    }