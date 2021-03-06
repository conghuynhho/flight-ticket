<?php  
$siteurl = get_bloginfo('siteurl');
if((empty($_SESSION['dep']) && empty($_SESSION['interfinishflight'])) || empty($_SESSION['search'])){
  header('Location:'.$siteurl);
  exit();
}
if(!empty($_SESSION['booking'])){
  $bkid=$_SESSION['booking']['id'];
  if($_SESSION[$bkid]['saved']==true){
      header("Location:"._page("complete")); 
	  exit();
  }
}
if(isset($_POST['sm_transfer_method']) ||
   isset($_POST['sm_office_method']) ||
   isset($_POST['sm_home_method']) ||
   isset($_POST['sm_home_method']) ||
   isset($_POST['sm_nganluong_method'])
){

  $payment_type='';
  if(isset($_POST['sm_transfer_method'])) $payment_type=3;
  elseif(isset($_POST['sm_office_method'])) $payment_type=2;
  elseif(isset($_POST['sm_home_method'])) $payment_type=1;
  elseif(isset($_POST['sm_nganluong_method'])) $payment_type=4;
  
  $way_flight = (int)$_SESSION['search']['way_flight'];
  $source = $_SESSION['search']['source'];
  $destination = $_SESSION['search']['destination'];
  $depart = $_SESSION['search']['depart'];   // dd/mm/yyyy
  $return = $_SESSION['search']['return'] ;
  $adults = (int)$_SESSION['search']['adult'];
  $children = (int)$_SESSION['search']['children'];
  $infants = (int)$_SESSION['search']['infant'];
  $is_inter = $_SESSION['search']['isinter'];

    if (!$way_flight) {
      $totalAdult = $adults * 2;
      $totalChild = $children * 2;
      $totalInfant = $infants * 2;
    }else {
      $totalAdult = $adults;
      $totalChild = $children;
      $totalInfant = $infants;
    }
    $serviceFee = getInterServiceFeeV2($destination, $totalAdult, $totalChild, $totalInfant);
  // print_r($serviceFee); exit;
  
  require(TEMPLATEPATH.'/flight_config/sugarrest/sugar_rest.php');
  $sugar = new Sugar_REST();
  $error = $sugar->get_error();
  $booking_id = array();
  

if ($is_inter && !empty($_SESSION['contact']) && !empty($_SESSION['dep']) && $_SESSION['pax']) {
    $flight = $_SESSION['dep'];
    // echo '111111111111';
    // echo 'quoc te';
    // exit;
    // print_r($flight);

    $args_booking = array();
    /*Ghi Thong Tin Booking va Thong Tin Lien He*/
    $args_booking = $_SESSION['contact'];
    $args_booking['payment_type']= $payment_type;
    $args_booking['ticket_type']= '2';
    $args_booking['airline'] = strtoupper($flight['dep']['airlinecode']);
    $args_booking['airline_inbound'] = strtoupper($flight['ret']['airlinecode']);
    $args_booking['ip_address']= get_ip_address_from_client();
    $args_booking['user_agent']= $_SERVER['HTTP_USER_AGENT'];
    $booking_id = $sugar->set("EC_Flight_Bookings", $args_booking);

    /*Ghi Thong Tin Hanh khach*/
    foreach ($_SESSION['pax'] as $pass) {
        $passenger_arr=array();
        $passenger_arr=$pass;
        $passenger_arr['booking_id']= $booking_id['id'];
        $sugar->set("EC_Booking_Passengers", $passenger_arr);
    }

    $i = 0;
    foreach ($flight['dep']['fdetail'] as $fdetail) {
        $transit = '';
        if (isset($flight['dep']['transit'][$i])) {
            $transit .= 'Trung chuy???n t???i: ' . $flight['dep']['transit'][$i]['arvcityname'] . ' (' . $flight['dep']['transit'][$i]['arv'] . ')';
            $transit .= ' - Th???i gian d???ng: ' . $flight['dep']['transit'][$i]['nduration'];
        }
        $_SESSION['dep_flight'][$i] = array(
                'direction' => 0,
                'name' => $fdetail['flightno'],
                'airline_code' => $fdetail['airlinecode'],
                'flight_number' => $fdetail['flightno'],
                'ticket_class' => $fdetail['class'],
                'departure' => $fdetail['dep'],
                'arrival' => $fdetail['arv'],
                'departure_date' => $fdetail['depdate'] . ' ' . $fdetail['deptime'],
                'arrival_date' => $fdetail['arvdate'] . ' ' . $fdetail['arvtime'],
                'description' => $transit,
                
            );
        $i++;
    }
    foreach ($_SESSION['dep_flight'] as $arrayDepFlight) {
        $arrayDepFlight['booking_id'] = $booking_id['id'];
        $itinerary_id_dep = $sugar->set("EC_Booking_Itineraries", $arrayDepFlight);
    }
    // CHI???U V???
    if (!$way_flight) {
        $j = 0;
        foreach ($flight['ret']['fdetail'] as $fdetail) {
            $transit = '';
            if (isset($flight['ret']['transit'][$j])) {
                $transit .= 'Trung chuy???n t???i: ' . $flight['ret']['transit'][$j]['arvcityname'] . ' (' . $flight['ret']['transit'][$j]['arv'] . ')';
                $transit .= ' - Th???i gian d???ng: ' . $flight['ret']['transit'][$j]['nduration'];
            }
            $_SESSION['ret_flight'][$j] = array(
                    'direction' => 1,
                    'name' => $fdetail['flightno'],
                    'airline_code' => $fdetail['airlinecode'],
                    'flight_number' => $fdetail['flightno'],
                    'ticket_class' => $fdetail['class'],
                    'departure' => $fdetail['dep'],
                    'arrival' => $fdetail['arv'],
                    'departure_date' => $fdetail['depdate'] . ' ' . $fdetail['deptime'],
                    'arrival_date' => $fdetail['arvdate'] . ' ' . $fdetail['arvtime'],
                    'description' => $transit,
                );
            $j++;
        }
        foreach ($_SESSION['ret_flight'] as $arrayRetFlight) {
            $arrayRetFlight['booking_id'] = $booking_id['id'];
            $itinerary_id_ret = $sugar->set("EC_Booking_Itineraries", $arrayRetFlight);
        }
    }
    // GHI TH??NG TIN H??NH KH??CH NG?????I L???N TR??? EM S?? SINH
    $args_detail = array();
    $args_detail['name']='Ng?????i l???n';
    $args_detail['passenger_type']='0';
    $args_detail['quantity']= $way_flight == 0 ? $adults * 2 : $adults;
    $args_detail['unit_price']= $flight['adtprice']; // gi?? c?? b???n
    $args_detail['tax_and_fee'] = $flight['adttaxfee']; // thu??? ph??
    $args_detail['direction']='0';
    $args_detail['service_fee']= $serviceFee['adtsvfee'];
    $args_detail['total_price']= $flight['adtprice'] + $flight['adttaxfee'] + $serviceFee['adtsvfee'];
        
    $args_detail['booking_id']= $booking_id['id'];
    $sugar->set("EC_Booking_Details", $args_detail);
    if ($children>0) {
        $args_detail = array();
        $args_detail['name']='Tr??? em';
        $args_detail['passenger_type']='1';
        $args_detail['quantity']= $way_flight == 0 ? $children * 2 : $children;
        $args_detail['unit_price']= $flight['chdprice'];
        $args_detail['tax_and_fee']= $flight['chdtaxfee'];
        $args_detail['direction']='0';
        $args_detail['service_fee']= $serviceFee['chdsvfee'];
        $args_detail['total_price']= $flight['chdprice'] + $flight['chdtaxfee'] + $serviceFee['chdsvfee'];
        $args_detail['booking_id']=$booking_id['id'];
        $sugar->set("EC_Booking_Details", $args_detail);
    }
    if ($infants>0) {
        $args_detail = array();
        $args_detail['name']='Em b??';
        $args_detail['passenger_type']='2';
        $args_detail['quantity']= $way_flight == 0 ? $infants * 2 : $infants;
        $args_detail['unit_price']= $flight['infprice'];
        $args_detail['tax_and_fee']= $flight['inftaxfee'];
        $args_detail['direction']='0';
        $args_detail['service_fee']= $serviceFee['infsvfee'];
        $args_detail['total_price']= $flight['infprice'] + $flight['inftaxfee'] + $serviceFee['infsvfee'];
        $args_detail['booking_id']=$booking_id['id'];
        $sugar->set("EC_Booking_Details", $args_detail);
    }
    $totalPriceBoooking = $flight['total'] + $serviceFee['totalsvfee'];

    $args_booking_update=array();
    $args_booking_update['other_fee']=($payment_type == 1 ? $delivery_fee : 0);
    $args_booking_update['subtotal_amount']= $totalPriceBoooking;
    $args_booking_update['total_amount']= $args_booking_update['subtotal_amount']; // check
    $args_booking_update['id']=$booking_id['id'];
    $sugar->set("EC_Flight_Bookings", $args_booking_update);
        
    $_SESSION['booking'] = $booking_id;
    $_SESSION[$booking_id['id']]['saved']=true;
    header("Location:"._page("complete"));
    exit();

} // else not inter
else if(!$is_inter && !empty($_SESSION['contact']) && !empty($_SESSION['dep']) && $_SESSION['pax']) {
    // echo '2222222222222';
    // echo 'noi dia';
    // exit;

    	  $args_booking=array();
	  /*Ghi Thong Tin Booking va Thong TIn Lien He*/
	  $args_booking = $_SESSION['contact'];
	  $args_booking['payment_type']=$payment_type;
	  $args_booking['ip_address']=get_ip_address_from_client();
	  $args_booking['user_agent']=$_SERVER['HTTP_USER_AGENT'];
	  $booking_id = $sugar->set("EC_Flight_Bookings",$args_booking);
	  /*Ghi Thong Tin Hanh Trinh Chuyen Di*/
	  $args_itinerary=array();
	  $args_itinerary = $_SESSION['dep_flight'];
	  $args_itinerary['booking_id']=$booking_id['id'];
	  $itinerary_id_dep = $sugar->set("EC_Booking_Itineraries",$args_itinerary);
	  /*Ghi Hanh Trinh chuyen ve*/
	  if($way_flight == 0){
		  $args_itinerary_ret=array();
		  $args_itinerary_ret=$_SESSION['ret_flight'];
		  $args_itinerary_ret['booking_id']=$booking_id['id'];
		  $itinerary_id_ret = $sugar->set("EC_Booking_Itineraries",$args_itinerary_ret);
	  }
	  // L??u th??ng tin h??nh kh??ch
	  for($i=0;$i<count($_SESSION['pax']);$i++){
		  $passenger_arr=array();
		  $passenger_arr=$_SESSION['pax'][$i];
		  $passenger_arr['booking_id']=$booking_id['id'];
		  $passenger_info[]=$sugar->set("EC_Booking_Passengers",$passenger_arr);
	  }
	  #########LUOT DI############
	  // L??u chi ti???t ?????t v?? - Nguoi L???n
	  $arrticket_adult=array();
	  $arrticket_adult=$_SESSION['card']['dep']['adult'];
	  $arrticket_adult['booking_id']=$booking_id['id'];
	  $articket_adult_id =  $sugar->set("EC_Booking_Details",$arrticket_adult);
	  if($children!=0){
		  $arrticket_child=array();
		  $arrticket_child=$_SESSION['card']['dep']['child'];
		  $arrticket_child['booking_id']=$booking_id['id'];
		  $articket_child_id =  $sugar->set("EC_Booking_Details",$arrticket_child);
	  }
	  if($infants != 0){
		  $arrticket_inf=array();
		  $arrticket_inf=$_SESSION['card']['dep']['infant'];
		  $arrticket_inf['booking_id']=$booking_id['id'];
		  $articket_inf_id=$sugar->set("EC_Booking_Details",$arrticket_inf);
	  }
	  if($way_flight == 0){
		  $arrticket_adult_ret=array();
		  $arrticket_adult_ret=$_SESSION['card']['ret']['adult'];
		  $arrticket_adult_ret['booking_id']=$booking_id['id'];
		  $articket_adult_id =  $sugar->set("EC_Booking_Details",$arrticket_adult_ret);
		  if($children!=0){
			  $arrticket_child_ret=array();
			  $arrticket_child_ret=$_SESSION['card']['ret']['child'];
			  $arrticket_child_ret['booking_id']=$booking_id['id'];
			  $articket_child_id =  $sugar->set("EC_Booking_Details",$arrticket_child_ret);
		  }
		  if($infants != 0){
			  $arrticket_inf_ret=array();
			  $arrticket_inf_ret=$_SESSION['card']['ret']['infant'];
			  $arrticket_inf_ret['booking_id']=$booking_id['id'];
			  $articket_inf_id=$sugar->set("EC_Booking_Details",$arrticket_inf_ret);
		  }
	  }
	  $args_booking_update=array();
	  $args_booking_update=$_SESSION['card']['price'];
	  $args_booking_update['id']=$booking_id['id'];
	  $booking_update = $sugar->set("EC_Flight_Bookings",$args_booking_update);
	  $_SESSION['booking'] = $booking_id;
	  $_SESSION[$booking_id['id']]['saved']=true;
	  header("Location:"._page("complete"));
	  exit();
	
}

} // end if submit
?>
<?php get_header(); ?>
<div class="row">
    <div class="block">
        <ul id="progressbar" class="hidden-xs">
            <li>
                <span class="pull-left">1. Ch???n h??nh tr??nh</span>
                <div class="bread-crumb-arrow"></div>
            </li>
            <li>
                <span class="pull-left">2. Th??ng tin h??nh kh??ch</span>
                <div class="bread-crumb-arrow"></div>
            </li>
            <li class="current">
                <span class="pull-left">3. Thanh to??n</span>
                <div class="bread-crumb-arrow"></div>
            </li>
            <li><span class="hidden-xs">4. Ho??n t???t</span></li>
        </ul>
        <div class="gap-small"></div>
        <div class="col-md-8  sidebar-separator" id="colLeftNoBorder">
            <div id="mainDisplay">
                <div id="ctleft" class="payment">
                    <p style="padding: 10px;line-height: 22px;font-size: 14px;" class="text-info-payment-method">
                        Sau khi Qu?? kh??ch ch???n xong h??nh th???c thanh to??n, vui l??ng nh???n n??t "<strong style="font-size: 16px; color: #f60;">?????t v??</strong>". 
                        Booker s??? g???i ?????n x??c th???c th??ng tin. H??y ?????m b???o s??? ??T v?? email l?? ch??nh x??c. 
                    </p>
                    <form action="<?php echo  _page("payment"); ?>" method="post" id="frm_selectpaymentmethod" >
                        <!-- THANH TOAN CHUY???N KHO???N -->
                        <div class="methods payment-method-info-cs">
                            <div class="methods-header transfer checked">
                                <label for="method_transfer"  class="methods-header radio radio-inline active checked">
                                    <input type="radio" id="method_transfer" name="radio" />
                                    <span style="color: #f26722;" class="config-color-white">Chuy???n kho???n qua ng??n h??ng</span>
                                    <p>????y l?? h??nh th???c thanh to??n t???t nh???t : kh??ng m???t ph??, nhanh v?? an to??n (do l?? ng??n h??ng b???o v??? b???n). L??u ?? n??n chuy???n c??ng h??? th???ng ????? nhanh.</p>
                                </label>
                            </div>
                            <div class="methods-content" id="content_transfer" style="display: block;">
                                <p style="padding-left: 10px;" class="config-padding-left-info">
								Khi chuy???n kho???n vui l??ng ghi s??? ??T ????? ch??ng t??i ch??? ?????ng li??n h??? x??c th???c. Ho???c nh???n tin / g???i ??i???n v??o ????y: <strong style="font-size: 16px; color: #f60;" class="strong-hotline-first"><?php echo get_option('opt_accountant_phone'); ?></strong></p>
                                <p>T???ng ????i h??? tr??? b???n 24/7: <strong style="font-size: 16px; color: #f60;" class="phone-last-mobile"><?php echo get_option('opt_phone'); ?></strong></p>
                                <p class="config-info-example">C?? ph??p: "0989 456 789 mua ve JS3153SDA"</p>
								<p class="staff-notification">Nh??n vi??n ch??ng t??i s??? g???i l???i qu?? kh??ch ????? h??? tr??? thanh to??n. Vui l??ng chuy???n c??ng h??? th???ng ????? thu???n ti???n h??n. T??i kho???n s??? ???????c cung c???p trong qu?? tr??nh g???i ??i???n.</p>
                                <p class="work-notification">Vi???c th??ng b??o chuy???n kho???n ch???m tr??? ho???c qu??n s??? d???n ?????n h???y ?????t ch??? ????n h??ng, t??ng gi?? v?? do m?? ?????t ch??? m???i ??? m???nh gi?? cao h??n. Xin qu?? kh??ch vui l??ng l??u ?? vi???c n??y, c??c tranh c??i v??? sau s??? kh??ng ???????c c??ng ty gi???i quy???t.
								</p>
								<span style="font-weight:bold" class="ticket-no-return">V?? khuy???n m??i kh??ng ho??n ?????i !!</span>
                                <p class="select">
                                    <input type="submit" name="sm_transfer_method" value="?????t v??" class="selectpaymentmethod button config-button-search-size"/>
                                    <span class="waiting">H??? th???ng ??ang x??? l??...</span>
                                </p>
                            </div>
                        </div>
                        <!--.methods-->
                        <!-- THANH TOAN T???I V??N PH??NG -->
                        <div class="methods payment-method-info-cs">
                            <div class="methods-header office">
                                <label for="method_office" class="methods-header radio radio-inline">
                                    <input type="radio" id="method_office" name="radio" />
                                    <span style="color: #f26722;" class="config-color-white">?????n v??n ph??ng thanh to??n</span>
                                    <p>Sau khi ho??n t???t ?????t gi??? ch??? v??, b???n gh?? v??n ph??ng ch??ng t??i ????? thanh to??n tr???c ti???p: <?php echo get_option('opt_primary_address'); ?></p>
                                </label>
                            </div>
                            <div class="methods-content" id="content_office">
                                <p style="padding: 0px 0; font-weight:bold" class="ticket-no-return"> V?? khuy???n m??i kh??ng ho??n ?????i !!</p>
                                <div class="clearfix"></div>
                                <p class="select">
                                    <input type="submit" name="sm_office_method" value="?????t v??" class="selectpaymentmethod button config-button-search-size" />
                                    <span class="waiting">H??? th???ng ??ang x??? l??...</span>
                                </p>
                            </div>
                        </div>
                        <!--.methods-->
                        <!-- THANH TOAN T???I NH?? -->
                        <div class="methods payment-method-info-cs">
                            <div class="methods-header home">
                                <label for="method_athome" class="methods-header radio radio-inline">
                                    <input type="radio" id="method_athome" name="radio" />
                                    <span style="color: #f26722;" class="config-color-white"> Thanh to??n t???i nh?? (Ph?? <?php echo number_format(get_option('opt_delivery_fee',0,'.',',')); ?> VND)</span>
                                    <p>B???n ?????t gi??? ch??? v?? xong, xem l???i k??? c??ng v?? ?????m b???o th??ng tin ch??nh x??c. Ch??ng t??i s??? in m???t v?? v?? giao ?????n t???n nh??. Ph?? giao v?? s??? tu??? thu???c qu??ng ???????ng v?? th???i gian.</p>
                                </label>
                            </div>
                            <div class="methods-content" id="content_athome">
                                <p style="padding: 0px 0;" class="payment-athome-hcm">Thanh to??n t???i nh?? ch??? ??p d???ng cho c??c qu???n huy???n trong TP.HCM.</p>
								<span style="font-weight:bold" class="ticket-no-return">V?? khuy???n m??i kh??ng ho??n ?????i !!</span>
                                <p class="select">
                                    <input type="submit" name="sm_home_method" value="?????t v??" class="selectpaymentmethod button config-button-search-size" />
                                    <span class="waiting">H??? th???ng ??ang x??? l??...</span>
                                </p>
                            </div>
                        </div>
                        <!--.method-->
                    </form>
                </div>
                <!--#ctleft-->
            </div>
            <!--#mainDisplay-->
        </div>
		<!-- end #colLeftNoBorder -->
        <div class="col-md-4 col-right-info-method"> 
            <?php get_sidebar(); ?>
        </div>
        <!-- #colRight -->
        <div class="clearfix"></div>
    </div>
</div>
<!--end row wrap col_main+sidebar--> 
<?php get_footer(); ?>
