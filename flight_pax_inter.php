<?php
    $is_inter = $_SESSION["search"]["isinter"];
    $flight = $_SESSION['dep'];
    $need = '<font style="color:#ED0000;font-weight:bold">*</font>';
    $needNew = '<font style="color:#ED0000;font-weight:bold">**</font>';
    $dem = 1;
    
    // ĐIỀU KIỆN TÌM KIÊM
    $way_flight = (int)$_SESSION['search']['way_flight'];
    $source = $_SESSION['search']['source'];
    $destination = $_SESSION['search']['destination'];
    $source_ia = getCityName($source);
    $destination_ia = getCityName($destination);
    $depart = $_SESSION['search']['depart'];   // dd/mm/yyyy
    $return = $_SESSION['search']['return'] ;
    $adults = (int)$_SESSION['search']['adult'];
    $children = (int)$_SESSION['search']['children'];
    $infants = (int)$_SESSION['search']['infant'];

    
    ($children != 0) ? $qty_children = ', '.$children.' Trẻ em' : $qty_children = '';
    ($infants != 0) ? $qty_infants = ', '.$infants.' Trẻ sơ sinh' : $qty_infants = '';
    
    #DON GIA
    $qty_passenger = $adults + $children + $infants;
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
    $totalPayPrice = $flight['total'] + $serviceFee['totalsvfee'];
   
    /*POST PASSENGER*/
    if(count($_POST) && isset($_POST['sm_bookingflight']) && !empty($_SESSION['dep']) ){
    	
    	// contact
        $_SESSION['contact']=array(
            'flight_type' => $way_flight,
            'airline' => '',
            'airline_inbound' => '',
            'contact_name' => ucwords(utf8convert(strtolower($_POST['contact_name']))),
            'email' => $_POST['contact_email'],
            'country' => $_POST['contact_country'],
            'phone' => $_POST['contact_phone'],
            'address' => utf8convert($_POST['contact_address']),
            'city' => $_POST['contact_city'],
            'description' => $_POST['special_request'],
        );

        // Lưu thông tin hành khách
        for($i = 0; $i < $qty_passenger; $i++){
    
            $_SESSION['pax'][$i]=array(
                'type' => $_POST['passenger_type'][$i],
                'salutation' => $_POST['passenger_title'][$i],
                'name' => strtoupper(utf8convert(strtolower($_POST['passenger_name'][$i]))),
                'birthday' => $_POST['passenger_birthyear'][$i].'-'.$_POST['passenger_birthmonth'][$i].'-'.$_POST['passenger_birthday'][$i],
                'luggage_price' => 0,
                'luggage_price_inbound' => 0,
                'eticket_outbound' => '',
                'eticket_inbound' => '',
                'pnr_outbound' => '',
                'pnr_inbound' => '',
            );
    
        }
        
        header("Location: "._page('payment'));
    
    }
    get_header();
    ?>
<div class="row">
    <div class="block">
        <div id="nav-flightsearch" class="step2 row">
            <ul id="progressbar" class="hidden-xs">
                <li class="pass">
                    <span class="pull-left">1. Chọn hành trình</span>
                    <div class="bread-crumb-arrow"></div>
                </li>
                <li class="current">
                    <span class="pull-left">2. Thông tin hành khách</span>
                    <div class="bread-crumb-arrow"></div>
                </li>
                <li><span class="pull-left">3. Thanh toán</span></li>
                <div class="bread-crumb-arrow"></div>
                <li><span class="pull-left">4. Hoàn tất</span></li>
            </ul>
        </div>
        <div id="colLeftNoBorder" class="col-md-8 sidebar-separator">
            <div class="passsenger">
                <?php if($noflight===true): ?>
                <!--Redirect ve trang tim chuyen bay neu chuyen bay duoc chon ko ton tai-->
                <script type="text/javascript" language="javascript">
                $(document).ready(function() {
                    $("#mainDisplay").html(
                        "<p style='color: red;padding: 20px 10px;'>Chuyến bay bạn chọn không tồn tại, trang web sẽ tự động quay lại trang tìm chuyến bay.</p>"
                        )
                    setTimeout(function() {
                        window.location.href = "<?php echo _page("
                        flightresult ")?>";
                    }, 2000);
                })
                </script>
                <?php endif; /*End no flight*/ ?>
                <div id="mainDisplay">
                    <form action="" method="post" id="frmBookingFlight">
                        <div id="ctleft" class="passsenger">
                            <fieldset>
                                <div class="heading-with-icon-and-ruler">
                                    <div class="heading-icon"><i class="icons-sprite icons-plane_3d_encircled"></i>
                                    </div>
                                    <div class="heading-title">Thông tin chuyến bay</div>
                                    <hr>
                                </div>
                                <div class="field-table" width="100%">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12"><label>Chuyến bay :
                                                <strong><?= $GLOBALS['way_flight_list'][$_SESSION['search']['way_flight']] ?></strong></label>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12"><label>Số lượng :
                                                <strong><?= $adults ?> người
                                                    lớn<?= $qty_children.$qty_infants?></strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12"><label>Ngày đi :
                                                <strong><?= $depart ?></strong></label></div>
                                        <?php 
                                            if(!$way_flight) {
                                                $html = '<div class="col-md-6 col-sm-6 col-xs-12"><label>Ngày về : <strong>'.$return.'</strong></label></div>';
                                                echo $html;
                                            }
                                        ?>
                                    </div>
                                </div>
                                <!-- CODE NEW -->
                                <div class="searchresults">
                                    <table class="searchresults-tbl international inter-pax-detail-outbound">
                                        <tbody>
                                            <?php
                                                /* GET VALUES ONE-WAYS */
                                                $depNameAirlines = strpos($flight['dep']['airline'], '-') ? substr($flight['dep']['airline'], 0, strpos($flight['dep']['airline'], '-')) : $flight['dep']['airline'];
                                                $depNameAirlinesCode = strpos($flight['dep']['airlinecode'], '-') ? substr($flight['dep']['airlinecode'], 0, strpos($flight['dep']['airlinecode'], '-')) : $flight['dep']['airlinecode'];
                                                $depDepTime = $flight['dep']['deptime'];
                                                $depArvTime = $flight['dep']['arvtime'];
                                                $depDuration = $flight['dep']['duration'];
                                                $depNDuration = $flight['dep']['nduration'];
                                                $depStop = $flight['dep']['stop'];
                                                $depBreakingPoint = ($flight['dep']['stop'] == 0 ? 'Bay thẳng' : $flight['dep']['stop'] . ' điểm dừng');
                                                $deptotalTimeDetail = convertHour($depDuration);
                                            ?>
                                            <tr class="tr-flight-text">
                                                <td colspan="2">
                                                    <div class="router-text-departure">
                                                        <p>Chiều đi:<span class="span-router-departure"><?php echo $source_ia; ?> - <?php echo $destination_ia; ?></span></p>     
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="departure">
                                                        <span class="info-airlines">
                                                            <span class="airline">
                                                                <img src="<?php echo imgdir ?>/airlines-logo/<?php echo $depNameAirlinesCode; ?>.png" alt="<?php echo $depNameAirlines; ?>">
                                                                <span class="name-airlines"><?php echo $depNameAirlines; ?></span>
                                                            </span>
                                                        </span>
                                                        <span class="flight-time">
                                                            <span class="time"><?php echo $depDepTime; ?> - <?php echo $depArvTime; ?></span>
                                                            <span class="flgiht-time-more">
                                                                <span class="duration"><?php echo $depNDuration; ?></span>
                                                                <span class="breakingPoint stop-info" data-no="<?php echo $depStop; ?>"><?php echo $depBreakingPoint; ?></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </td>
                                                <td class="view-flight-info">
                                                    <a href="javascript:void(0);" class="viewflightinfo class-view-fdetail inter-view-outbound-detail" id="button-click-view">Chi tiết</a>
                                                </td>
                                                <td class="flight-detail-content-inline inter-outbound" style="display: none;">
                                                    <h4>Chi tiết chiều đi <span>(Tổng thời gian: <?php echo $deptotalTimeDetail; ?>)</span></h4>
                                                    <?php  $i = 0;
                                                            foreach ($flight['dep']['fdetail'] as $key => $fdetail) { ?>
                                                    <div id="flight-info-route">
                                                        <div class="clearfix">
                                                            <div class="departure-time">
                                                                <b class="time"><?php echo $fdetail['deptime']; ?></b>
                                                                <span class="date"><?php echo date('d/m/Y',strtotime($fdetail['depdate'])); ?></span>
                                                                <span
                                                                    class="location"><?php echo $fdetail['depcityname']; ?>
                                                                    (<?php echo $fdetail['dep']; ?>)</span>
                                                            </div>
                                                            <div class="arrival-time">
                                                                <b class="time"><?php echo $fdetail['arvtime']; ?></b>
                                                                <span class="date"><?php echo date('d/m/Y',strtotime($fdetail['arvdate'])); ?></span>
                                                                <span
                                                                    class="location"><?php echo $fdetail['arvcityname']; ?>
                                                                    (<?php echo $fdetail['arv']; ?>)</span>
                                                            </div>
                                                            <div class="airlines-info">
                                                                <span class="airlines-code"><u class="text">Hãng:</u>
                                                                    <b><?php echo $fdetail['airline']; ?></b></span>
                                                                <span class="airlines-code"><u class="text">Mã chuyến
                                                                        bay:</u>
                                                                    <b><?php echo $fdetail['flightno']; ?></b></span>
                                                                <span class="airlines-type"><u class="text">Loại máy
                                                                        bay:</u>
                                                                    <b><?php echo $fdetail['aircraft']; ?></b></span>
                                                                <span><u class="text">Hạng chỗ:</u>
                                                                    <b><?php echo $fdetail['class']; ?></b></span>
                                                                <span><u class="text">Thời gian bay:</u>
                                                                    <b><?php echo $fdetail['nduration']; ?></b></span>
                                                            </div>
                                                        </div>
                                                        <?php if (isset($flight['dep']['transit'][$i]['arv'])) { ?>
                                                        <div class="flight-info-transit">
                                                            <span>Thay đổi máy bay tại
                                                                <b><?php echo $flight['dep']['transit'][$i]['arvcityname'] ?>
                                                                    (<?php echo $flight['dep']['transit'][$i]['arvcity']; ?>)</b>
                                                                - Thời gian giữa các chuyến bay:
                                                                <b><?php echo $flight['dep']['transit'][$i]['nduration'] ?></b></span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php $i++; } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php if(!$way_flight) { ?>                        
                                    <table class="searchresults-tbl international inter-pax-detail-inbound">
                                        <tbody>
                                            <?php
                                                /* GET VALUES ROUND-TRIP */
                                                $retNameAirlines = strpos($flight['ret']['airline'], '-') ? substr($flight['ret']['airline'], 0, strpos($flight['ret']['airline'], '-')) : $flight['ret']['airline'];
                                                $retNameAirlinesCode = strpos($flight['ret']['airlinecode'], '-') ? substr($flight['ret']['airlinecode'], 0, strpos($flight['ret']['airlinecode'], '-')) : $flight['ret']['airlinecode'];
                                                $retDepTime = $flight['ret']['deptime'];
                                                $retArvTime = $flight['ret']['arvtime'];
                                                $retDuration = $flight['ret']['duration'];
                                                $retNDuration = $flight['ret']['nduration'];
                                                $retStop = $flight['ret']['stop'];
                                                $retBreakingPoint = ($flight['ret']['stop'] == 0 ? 'Bay thẳng' : $flight['ret']['stop'] . ' điểm dừng');
                                                $rettotalTimeDetail = convertHour($retDuration);
                                            ?>
                                            <tr class="tr-flight-text">
                                                <td colspan="2">
                                                    <div class="router-text-arrival">
                                                        <p>Chiều về: <span class="span-router-arrival"><?php echo $destination_ia; ?> - <?php echo $source_ia; ?></span></p>  
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="return">
                                                        <span class="info-airlines">
                                                            <span class="airline">
                                                                <img src="<?php echo imgdir ?>/airlines-logo/<?php echo $retNameAirlinesCode; ?>.png"
                                                                    alt="<?php echo $retNameAirlines; ?>">
                                                                <span class="name-airlines"><?php echo $retNameAirlines; ?></span>
                                                            </span>
                                                        </span>
                                                        <span class="flight-time">
                                                            <span class="time"><?php echo $retDepTime; ?> -
                                                                <?php echo $retArvTime; ?></span>
                                                            <span class="flgiht-time-more">
                                                                <span class="duration"><?php echo $retNDuration; ?></span>
                                                                <span class="breakingPoint stop-info" data-no="<?php echo $retStop; ?>"><?php echo $retBreakingPoint; ?></span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </td>
                                                <td class="view-flight-info">
                                                    <a href="javascript:void(0);" class="viewflightinfo class-view-fdetail inter-view-inbound-detail" id="button-click-view">Chi tiết</a>
                                                </td>
                                                <td class="flight-detail-content-inline inter-inbound" style="display: none;">
                                                    <h4>Chi tiết chiều về <span>(Tổng thời gian: <?php echo $rettotalTimeDetail; ?>)</span></h4>
                                                    <?php if (!empty($flight['ret']['fdetail'][0]['dep'])) { ?>
                                                    <?php $j = 0; foreach ($flight['ret']['fdetail'] as $fdetail) { ?>
                                                    <div id="flight-info-route">
                                                        <div class="clearfix">
                                                            <div class="departure-time">
                                                                <b class="time"><?php echo $fdetail['deptime']; ?></b>
                                                                <span class="date"><?php echo date('d/m/Y',strtotime($fdetail['depdate'])); ?></span>
                                                                <span class="location"><?php echo $fdetail['depcityname']; ?> (<?php echo $fdetail['dep']; ?>)</span>
                                                            </div>
                                                            <div class="arrival-time">
                                                                <b class="time"><?php echo $fdetail['arvtime']; ?></b>
                                                                <span class="date"><?php echo date('d/m/Y',strtotime($fdetail['arvdate'])); ?></span>
                                                                <span class="location"><?php echo $fdetail['arvcityname']; ?> (<?php echo $fdetail['arv']; ?>)</span>
                                                            </div>
                                                            <div class="airlines-info">
                                                                <span class="airlines-code"><u class="text">Hãng:</u>
                                                                    <b><?php echo $fdetail['airline']; ?></b></span>
                                                                <span class="airlines-code"><u class="text">Mã chuyến
                                                                        bay:</u>
                                                                    <b><?php echo $fdetail['flightno']; ?></b></span>
                                                                <span class="airlines-type"><u class="text">Loại máy
                                                                        bay:</u>
                                                                    <b><?php echo $fdetail['aircraft']; ?></b></span>
                                                                <span><u class="text">Hạng chỗ:</u>
                                                                    <b><?php echo $fdetail['class']; ?></b></span>
                                                                <span><u class="text">Thời gian bay:</u>
                                                                    <b><?php echo $fdetail['nduration']; ?></b></span>
                                                            </div>
                                                        </div>
                                                        <?php if (isset($flight['ret']['transit'][$j]['arv'])) { ?>
                                                        <div class="flight-info-transit">
                                                            <span>Thay đổi máy bay tại
                                                                <b><?php echo $flight['ret']['transit'][$j]['arvcityname'] ?>
                                                                    (<?php echo $flight['ret']['transit'][$j]['arvcity']; ?>)</b>
                                                                - Thời gian giữa các chuyến bay:
                                                                <b><?php echo $flight['ret']['transit'][$j]['nduration'] ?></b></span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <?php $j++; } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php } ?>
                                </div>
                                <!-- END CODE NEW -->
                            </fieldset>
                            <div class="heading-with-icon-and-ruler">
                                <div class="heading-icon"><i class="icons-sprite icons-users_encircled"></i></div>
                                <div class="heading-title"> Thông tin hành khách</div>
                                <hr>
                            </div>
                            <!-- THÔNG TIN HÀNH KHÁCH -->
                            <!-- THÔNG TIN HÀNH KHÁCH : ADULT -->
                            <? for($k = 1; $k <= $adults; $k++){ ?>
                            <div>
                                <p><strong><?= $dem ?>. Người lớn</strong> <b class="color-text-CMND">Tên đúng với CMND / Thẻ căn cước</b></p>
                                <div class="field-table">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-4">
                                            <div class="form-group"> 
                                                <label>Giớ tính</label>
                                                <select name="passenger_title[]" class="form-control passenger_title">
                                                    <option style="display:none;" value=""></option>
                                                    <option value="0">Ông</option>
                                                    <option value="1">Bà</option>
                                                    <option value="0">Anh</option>
                                                    <option value="1">Chị</option>
                                                </select>
                                                <input type="hidden" name="passenger_type[]" value="0" />
                                            </div>
                                        </div>
                                        <div class="col-md-10 col-sm-12 col-xs-12 col-xs-8-mobile">
                                            <div class="form-group"> 
                                            <label>Họ và tên</label> 
                                            <input type="text" name="passenger_name[]" class="passenger_name form-control" id="passenger_name" placeholder="NGUYEN TUAN ANH" onkeyup="validateCheckPassengerName();"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12" style="display:none;">
                                            <label  style="font-weight:bold">Ngày sinh <?= $need ?></label>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthday[]" class="birthday">
                                                        <option value="0">Ngày</option>
                                                        <?php for($i = 1; $i <= 31; $i++) { ?>
                                                            <option value="<?php echo  $i ?>" <?php if($birthday[2] == $i) echo "selected"; ?> ><?php echo  $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthmonth[]" class="birthmonth">
                                                        <option value="0">Tháng</option>
                                                        <?php for($i = 1; $i <= 12; $i++) { ?>
                                                            <option value="<?php echo  $i ?>" <?php if($birthday[1] == $i) echo "selected"; ?> ><?php echo  $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthyear[]" class="birthyear">
                                                        <option value="0">Năm</option>
                                                        <?php
                                                            (int)$youngest = (int)date('Y') - 12;
                                                            (int)$oldest = (int)date('Y') - 85;
                                                            for($i = $youngest; $i >= $oldest; $i--) {
                                                        ?>
                                                        <option value="<?php echo  $i ?>" <?php if($birthday[0] == $i) echo "selected"; ?> ><?php echo  $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <table class="field-table">
                                    <tr>
                                        <td colspan="2" style="height:10px;">
                                            <p><strong>Hành lý <?php echo ($way_flight == 0 ? 'lượt đi' : '') ?></strong></p>
                                        </td>
                                    </tr>
                                    <?php Dep_addBaggage($dep_airline, $dep_class); ?>
                                    <tr>
                                        <td style="width:120px; height:10px;"></td><td></td>
                                    </tr>
                                    
                                    <? if($way_flight == 0) { ?>
                                        <tr>
                                            <td colspan="2" style="height:10px;"><p><strong>Hành lý lượt về</strong></p></td>
                                        </tr>
                                        <?php Ret_addBaggage($ret_airline, $ret_class);?>
                                    <? } ?>
                                </table>
                            </div>
                            <? $dem++; } // END FOR ADULTS // THÔNG TIN HÀNH KHÁCH: CHILDREN
                                for($k = 1; $k <= $children; $k++){
                            ?>
                            <div>
                                <p><strong><?= $dem ?>. Trẻ em</strong></p>
                                <div class="field-table">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                            <label>Giới tính</label>
                                                <select name="passenger_title[]" class="form-control passenger_title">
                                                    <option style="display:none;" value=""></option>
                                                    <option value="0">Nam</option>
                                                    <option value="1">Nữ</option>
                                                </select>
                                                <input type="hidden" name="passenger_type[]" value="1" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                                <label>Họ và tên</label>
                                                <input type="text" name="passenger_name[]" class="passenger_name form-control" id="passenger_name" placeholder="NGUYEN TUAN ANH" onkeyup="validateCheckPassengerName();"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label>Ngày sinh</label>
                                            <div class="form-group row">
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthday[]" class="birthday form-control">
                                                        <option value="0">Ngày</option>
                                                        <? for($i = 1; $i <= 31; $i++) { ?>
                                                            <option value="<?= $i ?>" <? if($birthday[2] == $i) echo "selected"; ?> ><?= $i ?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                <select name="passenger_birthmonth[]" class="birthmonth form-control">
                                                    <option value="0">Tháng</option>
                                                    <? for($i = 1; $i <= 12; $i++) { ?>
                                                        <option value="<?= $i ?>" <? if($birthday[1] == $i) echo "selected"; ?> ><?= $i ?></option>
                                                    <? } ?>
                                                </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthyear[]" class="birthyear form-control">
                                                        <option value="0">Năm</option>
                                                        <? (int)$youngest = (int)date('Y') - 3; 
                                                            (int)$oldest = (int)date('Y') - 18;
                                                            for($i = $youngest; $i >= $oldest; $i--) { ?>
                                                            <option value="<?= $i ?>" <? if($birthday[0] == $i) echo "selected"; ?> ><?= $i ?></option>
                                                            <? if($i % 10 == 0) echo '<option value="0">------</option>'; } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table class="field-table">
                                    <tr>
                                        <td colspan="2" style="height:10px;">
                                            <p><strong>Hành lý <?php echo ($way_flight == 0 ? 'lượt đi' : '') ?></strong></p>
                                        </td>
                                    </tr>
                                    <?php Dep_addBaggage($dep_airline, $dep_class); ?>
                                    <tr>
                                        <td style="width:120px; height:10px;"></td><td></td>
                                    </tr>
                                    
                                    <? if($way_flight == 0) { ?>
                                        <tr>
                                            <td colspan="2" style="height:10px;"><p><strong>Hành lý lượt về</strong></p></td>
                                        </tr>
                                        <?php Ret_addBaggage($ret_airline, $ret_class);?>
                                    <? } ?>
                                </table>
                            </div>
                            <? $dem++; }// END FOR CHILDREN
                            //	THÔNG TIN HÀNH KHÁCH: INFANT
                            for($k = 1; $k <= $infants; $k++){ ?>
                            <div>
                                <p><strong><?= $dem ?>. Em bé</strong></p>
                                <div class="field-table">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-4">
                                            <div class="form-group">
                                                <label>Giới tính</label>
                                                <select name="passenger_title[]" class="form-control passenger_title">
                                                    <option style="display:none;" value=""></option>
                                                    <option value="0">Bé trai</option>
                                                    <option value="1">Bé gái</option>
                                                </select>
                                                <input type="hidden" name="passenger_type[]" value="2" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-8 col-xs-8">
                                            <div class="form-group">
                                            <label>Họ và tên</label>
                                                <input type="text" name="passenger_name[]" class="passenger_name form-control" id="passenger_name" placeholder="NGUYEN TUAN ANH" onkeyup="validateCheckPassengerName();"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <label>Ngày sinh</label>
                                            <div class="form-group row">
                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                        <select name="passenger_birthday[]" class="birthday form-control">
                                                            <option value="0">Ngày</option>
                                                            <? for($i = 1; $i <= 31; $i++) { ?>
                                                                <option value="<?= $i ?>" <? if($birthday[2] == $i) echo "selected"; ?> ><?= $i ?></option>
                                                            <? } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthmonth[]" class="birthmonth form-control">
                                                        <option value="0">Tháng</option>
                                                        <? for($i = 1; $i <= 12; $i++) { ?>
                                                            <option value="<?= $i ?>" <? if($birthday[1] == $i) echo "selected"; ?> ><?= $i ?></option>
                                                        <? } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-4">
                                                    <select name="passenger_birthyear[]" class="birthyear form-control">
                                                        <option value="0">Năm</option>
                                                        <?
                                                            (int)$youngest = (int)date('Y');
                                                            (int)$oldest = (int)date('Y')-2;
                                                            for($i = $youngest; $i >= $oldest; $i--) { ?>
                                                            <option value="<?= $i ?>" <? if($birthday[0] == $i) echo "selected"; ?> ><?= $i ?></option>
                                                        <? if($i % 10 == 0) echo '<option value="0">------</option>'; } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <? $dem++; } ?>
                            <!-- END FOR INFANT -->
                            <!-- END THÔNG TIN HÀNH KHÁCH -->
                            <div class="heading-with-icon-and-ruler">
                                <div class="heading-icon"><i class="icons-sprite icons-phone_encircled"></i></div>
                                <div class="heading-title"> Thông tin liên hệ</div>
                                <hr>
                            </div>
                            <p style="margin:0 0 5px 0px;">(<?= $needNew ?>) Vui lòng cung cấp đầy đủ thông tin chi tiết liên hệ chính xác: họ tên, số ĐT chính, gmail</p>
                            <div class="field-table">
                                <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4">
                                        <div class="form-group">
                                            <label for="contact_title" style="font-weight:bold">Quý danh
                                                <?= $need ?></label>
                                            <select name="contact_title" id="contact_title" class="form-control">
                                                <option value="0">Ông</option>
                                                <option value="1">Bà</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-8">
                                        <div class="form-group">
                                            <label for="contact_name" style="font-weight:bold">Họ và tên
                                                <?= $need ?></label>
                                            <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="NGUYEN TUAN ANH" onkeyup="validateCheckContactName();"/>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <div class="form-group">
                                            <label for="contact_phone" style="font-weight:bold">Điện thoại di động
                                                <?= $need ?></label>
                                            <input type="text" name="contact_phone" id="contact_phone"
                                                class="form-control" onkeypress="validateCheckNumber();" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="contact_email" style="font-weight:bold">Gmail
                                                <?= $need ?></label>
                                            <input type="text" name="contact_email" id="contact_email"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="contact_address" style="font-weight:bold">Địa chỉ</label>
                                            <input type="text" name="contact_address" id="contact_address"
                                                class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p id="err_info" class="line_error"></p>
                            <h3 class="title">Yêu cầu đặc biệt</strong></h3>
                            <p style="margin:0 0 10px 0px;">Khi bạn có thêm yêu cầu, hãy viết vào ô bên dưới.</p>
                            <div class="field-table">
                                <div><textarea name="special_request" class="form-control" rows="5"></textarea></div>
                                <input type="submit" value="Tiếp tục" title="Tiếp tục" name="sm_bookingflight"
                                    class="button pull-right mt20" id="sm_bookingflight" />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
                <!--#mainDisplay-->
            </div>
        </div>
        <!-- #colLeftNoBorder -->
        <div id="colRight" class="col-md-4">
            <div class="box" id="reviewprice">
                <div class="heading-with-icon">
                    <div class="heading-icon skip-horizontal-flip"><i
                            class="currency_tags-sprite currency_tags-EUR_tag_large"></i></div>
                    <div class="heading-title">Chi tiết giá</div>
                </div>
                <div class="widgetblock-content">
                    <fieldset>
                        <table class="field-table">
                            <tr>
                                <td colspan="5">
                                    <input type="hidden" id="wayflight" value="<?= $way_flight; ?>"  />
                                    <strong>Giá vé</strong>
                                </td>
                            </tr>
                            <tr class="calcuprice">
                                <td colspan="3"><b><?php echo $adults; ?></b> x Người lớn </td>
                                <td style="padding-right:2px;padding-left:2px;text-align:center">=</td>
                                <td style="text-align: right;"><b><?= format_price($flight['adtprice'])?></b></td>
                            </tr>
                            <?php if($children != 0) { ?>
                            <tr class="calcuprice">
                                <td colspan="3"><b><?php echo $children; ?></b> x Trẻ em </td>
                                <td style="padding-right:2px;padding-left:2px;text-align:center">=</td>
                                <td style="text-align: right;"><b><?= format_price($flight['chdprice'])?></b></td>
                            </tr>
                            <?php } ?>
                            <?php if($infants != 0) {?>
                            <tr class="calcuprice">
                                <td colspan="3"><b><?php echo $infants ?></b> x Em bé </td>
                                <td style="padding-right:2px;padding-left:2px;text-align:center">=</td>
                                <td style="text-align: right;"><b><?= format_price($flight['infprice']) ?></b></td>
                            </tr>
                            <?php } ?>
                            <tr class="calcuprice">
                                <td colspan="3">Thuế và phí </td>
                                <td style="padding-right:2px;padding-left:2px;text-align:center">=</td>
                                <td style="text-align: right;"><b><?php echo format_price($flight['tax'] + $serviceFee['totalsvfee']); ?></b></td>
                            </tr> 
                            <tr>
                                <td colspan="5" style="border-top:1px solid #DDD"></td>
                            </tr>
                        </table>
                    </fieldset>
                    <div class="total">
                        <div class="cont">Tổng cộng</div>
                        <p><span id="amounttotal"><?php echo format_price_nocrc($totalPayPrice);?></span> VND</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!--#reviewprice-->
            <?php get_sidebar(); ?>
        </div>
        <!--#colRight-->
        <div class="clearfix"></div>
    </div>
</div>
<!--end row wrap col_main+sidebar-->
<?php get_footer(); ?>
