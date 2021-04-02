<?php
$siteurl = get_bloginfo('siteurl');
if(empty($_SESSION['booking']) || !$_SESSION['search']['isinter'] || empty($_SESSION['contact']) || empty($_SESSION['dep'])){
    header('Location:'.$siteurl);
    exit();
}

require(TEMPLATEPATH . '/flight_config/sugarrest/sugar_rest.php');
$sugar = new Sugar_REST();
$error = $sugar->get_error();

// LAY THONG TIN BOOKING
$booking_id = $_SESSION['booking']['id'];
// _debug($booking_id);
$options['limit'] = 1;
$options['where'] = 'ec_flight_bookings.id="'.$booking_id .'"';
$select = array('name','contact_name','email','phone','address','flight_type','total_amount','payment_type');
$result = $sugar->get("EC_Flight_Bookings", $select, $options);
// _debug($result);

$flight = $_SESSION['dep'];
// _debug($flight);
$booking_num = $result[0]['name'];
$flight_type = $GLOBALS['way_flight_list'][$result[0]['flight_type']];
$contact_name = $result[0]['contact_name'];
$contact_email = $result[0]['email'];
$contact_phone = $result[0]['phone'];
$contact_address = $result[0]['address'];
$payment_type = $GLOBALS['payment_type'][$result[0]['payment_type']];
$total_amount = $result[0]['total_amount'];

$source_ia = getCityName($_SESSION['search']['source']);
$destination_ia = getCityName($_SESSION['search']['destination']);
$depdate = $_SESSION['search']['depart'];
if($_SESSION['search']['way_flight'] == 0) $retdate = $_SESSION['search']['return'];
$adult = $_SESSION['search']['adult'];
$children = $_SESSION['search']['children'];
$infant = $_SESSION['search']['infant'];
$paxsAdult = $adult.' người lớn';
// if($children > 0) $paxs .= ','.$children.' trẻ em';
// if($infant > 0)	$paxs .= ','.$infant.' em bé';

if($children != 0 || $children == 0)
    $qty_children = ', '.$children.' trẻ em';
if($infant != 0 || $infant == 0)
    $qty_infants = ', '.$infant.' trẻ sơ sinh.';

$com_hotline1 = get_option('opt_hotline');
$com_hotline2 = get_option('opt_hotline2');
$com_hotline3 = get_option('opt_hotline3');
$com_phone = get_option('opt_phone');
$com_email1 = get_option('opt_contactemail');
$com_email2 = get_option('opt_contactemail2');

//Car Rentall
$pickuptime_tmp = date("d/m/Y",time()+(60*60));
$maxtime_tmp = date("d/m/Y",time()+(60*60*(8760)));
$crrttime_tmp = date("d/m/Y",time());
//End Car Rentall
?>
<?php get_header(); ?>
<div class="row">
    <div class="block">
        <ul id="progressbar" class="hidden-xs">
            <li><span class="pull-left">Chọn hành trình</span>
                <div class="bread-crumb-arrow"></div>
            </li>
            <li><span class="pull-left">2. Thông tin hành khách</span>
                <div class="bread-crumb-arrow"></div>
            </li>
            <li><span class="pull-left">3. Thanh toán</span>
                <div class="bread-crumb-arrow"></div>
            </li>
            <li class="current"><span class="pull-left">4. Hoàn tất</span></li>
        </ul>
        <div class="gap-small"></div>
        <div id="colLeftNoBorder" class="col-md-8 sidebar-separator">
            <div id="mainDisplay" class="flight-complete-inter">
                <div class="confirmbox">
                    <h2 class="text-info-save-seat"> Thông tin giữ chỗ đã ghi nhận</h2>
                    <h3 class="h3-text-booking">Booking : <b
                            style="font-size:25px;color:#F20000;font-weight:bold;"><?php echo $booking_num; ?></b></h3>
                    <div>
                        <p style="text-align: justify; margin: 5px 0; font-size: 14px;" class="p-text-booking">
                            Sau quá trình xác nhận này quý khách cần chuyển khoản thanh toán để bảo vệ giá. Sau khi
                            chuyển khoản xin vui lòng nhắn tin báo vào số :
                            <span style="font-weight: bold; color:#FE5815"
                                class="span-hotline-booking"><?php echo get_option('opt_accountant_phone'); ?></span>
                        </p>
                        <p class="text-complete-order-success">
                            Trong giờ hành chính gọi điện vào <span style="font-weight: bold; color:#FE5815"
                                class="cs-color-back"><?php echo get_option('opt_phone'); ?></span>.
                        </p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--.confirmbox-->
                <div class="carRentalContainer" id="carRentalContainer" style="display: none;">
                    <form method="post" action="" id="frmBooking" name="frmBooking">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label>Nơi đi</label>
                                <div class="location-wrap form-group">
                                    <select name="pickupLocation" id="pickupLocation" class="form-control">
                                        <option value="Quận 1">Quận 1</option>
                                        <option value="Quận 2">Quận 2</option>
                                        <option value="Quận 3">Quận 3</option>
                                        <option value="Quận 4">Quận 4</option>
                                        <option value="Quận 5">Quận 5</option>
                                        <option value="Bình Thạnh">Bình Thạnh</option>
                                        <option value="Phú Nhuận">Phú Nhuận</option>
                                        <option value="Sân bay TSN">Sân bay TSN</option>
                                        <option value="Bình Dương">Bình Dương</option>
                                        <option value="Bình Phước">Bình Phước</option>
                                        <option value="Củ Chi">Củ Chi</option>
                                        <option value="Long AN">Long An</option>
                                        <option value="Bến Tre">Bến Tre</option>
                                        <option value="Tiền Giang">Tiền Giang</option>
                                        <option value="Đồng Tháp">Đồng Tháp</option>
                                        <option value="Vũng Tàu">Vũng Tàu</option>
                                        <option value="Đồng Nai">Đồng Nai</option>
                                        <option value="Địa điểm khác">Địa điểm khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-7">
                                <div class="form-group">
                                    <label>Ngày đi</label>
                                    <i class="fa fa-calendar input-icon font-blue"></i>
                                    <div class="datepicker-wrap">
                                        <input id="pickupDate" name="pickupDate" readonly class="form-control"
                                            after_function="change_pickup_date" minDate="<?= $crrttime_tmp?>"
                                            maxdate="<?=$maxtime_tmp?>" default_max_date="<?=$maxtime_tmp?>" type="text"
                                            default="<?=$pickuptime_tmp?>" value="<?=$pickuptime_tmp?>"
                                            autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-5">
                                <div class="form-group">
                                    <label>Giờ </label>
                                    <select name="pickupTime" id="pickupTime" class="time-pick form-control">
                                        <option value="07:00">7:00 AM</option>
                                        <option value="07:30">7:30 AM</option>
                                        <option value="08:00">8:00 AM</option>
                                        <option value="08:30">8:30 AM</option>
                                        <option value="09:00">9:00 AM</option>
                                        <option value="09:30">9:30 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="10:30">10:30 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="11:30">11:30 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="12:30">12:30 PM</option>
                                        <option value="13:00">1:00 PM</option>
                                        <option value="13:30">1:30 PM</option>
                                        <option value="14:00">2:00 PM</option>
                                        <option value="14:30">2:30 PM</option>
                                        <option value="15:00">3:00 PM</option>
                                        <option value="15:30">3:30 PM</option>
                                        <option value="16:00">4:00 PM</option>
                                        <option value="16:30">4:30 PM</option>
                                        <option value="17:00">5:00 PM</option>
                                        <option value="17:30">5:30 PM</option>
                                        <option value="18:00">6:00 PM</option>
                                        <option value="18:30">6:30 PM</option>
                                        <option value="19:00">7:00 PM</option>
                                        <option value="19:30">7:30 PM</option>
                                        <option value="20:00">8:00 PM</option>
                                        <option value="20:30">8:30 PM</option>
                                        <option value="21:00">9:00 PM</option>
                                        <option value="21:30">9:30 PM</option>
                                        <option value="22:00">10:00 PM</option>
                                        <option value="22:30">10:30 PM</option>
                                        <option value="23:00">11:00 PM</option>
                                        <option value="23:30">11:30 PM</option>
                                        <option value="00:00">12:00 AM</option>
                                        <option value="00:30">12:30 AM</option>
                                        <option value="01:00">1:00 AM</option>
                                        <option value="01:30">1:30 AM</option>
                                        <option value="02:00">2:00 AM</option>
                                        <option value="02:30">2:30 AM</option>
                                        <option value="03:00">3:00 AM</option>
                                        <option value="03:30">3:30 AM</option>
                                        <option value="04:00">4:00 AM</option>
                                        <option value="04:30">4:30 AM</option>
                                        <option value="05:00">5:00 AM</option>
                                        <option value="05:30">5:30 AM</option>
                                        <option value="06:00">6:00 AM</option>
                                        <option value="06:30">6:30 AM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <label>Nơi đến</label>
                                <div class="location-wrap form-group">
                                    <select name="dropoffLocation" id="dropoffLocation" class="form-control">
                                        <option value="Quận 1">Quận 1</option>
                                        <option value="Quận 2">Quận 2</option>
                                        <option value="Quận 3">Quận 3</option>
                                        <option value="Quận 4">Quận 4</option>
                                        <option value="Quận 5">Quận 5</option>
                                        <option value="Bình Thạnh">Bình Thạnh</option>
                                        <option value="Phú Nhuận">Phú Nhuận</option>
                                        <option value="Sân bay TSN">Sân bay TSN</option>
                                        <option value="Bình Dương">Bình Dương</option>
                                        <option value="Bình Phước">Bình Phước</option>
                                        <option value="Củ Chi">Củ Chi</option>
                                        <option value="Long AN">Long An</option>
                                        <option value="Bến Tre">Bến Tre</option>
                                        <option value="Tiền Giang">Tiền Giang</option>
                                        <option value="Đồng Tháp">Đồng Tháp</option>
                                        <option value="Vũng Tàu">Vũng Tàu</option>
                                        <option value="Đồng Nai">Đồng Nai</option>
                                        <option value="Địa điểm khác">Địa điểm khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-7">
                                <div class="form-group">
                                    <label>Ngày về</label>
                                    <i class="fa fa-calendar input-icon font-blue"></i>
                                    <div class="datepicker-wrap">
                                        <input id="dropoffDate" name="dropoffDate" readonly class="form-control"
                                            after_function="change_dropoff_date" minDate="<?=$pickuptime_tmp?>"
                                            maxdate="<?=$maxtime_tmp?>" type="text" default="--/--/----"
                                            value="--/--/----" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-5">
                                <label>Giờ </label>
                                <div class="form-group">
                                    <select name="dropoffTime" id="dropoffTime" class="time-pick form-control">
                                        <option value="07:00">7:00 AM</option>
                                        <option value="07:30">7:30 AM</option>
                                        <option value="08:00">8:00 AM</option>
                                        <option value="08:30">8:30 AM</option>
                                        <option value="09:00">9:00 AM</option>
                                        <option value="09:30">9:30 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="10:30">10:30 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="11:30">11:30 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="12:30">12:30 PM</option>
                                        <option value="13:00">1:00 PM</option>
                                        <option value="13:30">1:30 PM</option>
                                        <option value="14:00">2:00 PM</option>
                                        <option value="14:30">2:30 PM</option>
                                        <option value="15:00">3:00 PM</option>
                                        <option value="15:30">3:30 PM</option>
                                        <option value="16:00">4:00 PM</option>
                                        <option value="16:30">4:30 PM</option>
                                        <option value="17:00">5:00 PM</option>
                                        <option value="17:30">5:30 PM</option>
                                        <option value="18:00">6:00 PM</option>
                                        <option value="18:30">6:30 PM</option>
                                        <option value="19:00">7:00 PM</option>
                                        <option value="19:30">7:30 PM</option>
                                        <option value="20:00">8:00 PM</option>
                                        <option value="20:30">8:30 PM</option>
                                        <option value="21:00">9:00 PM</option>
                                        <option value="21:30">9:30 PM</option>
                                        <option value="22:00">10:00 PM</option>
                                        <option value="22:30">10:30 PM</option>
                                        <option value="23:00">11:00 PM</option>
                                        <option value="23:30">11:30 PM</option>
                                        <option value="00:05">12:00 AM</option>
                                        <option value="00:30">12:30 AM</option>
                                        <option value="01:00">1:00 AM</option>
                                        <option value="01:30">1:30 AM</option>
                                        <option value="02:00">2:00 AM</option>
                                        <option value="02:30">2:30 AM</option>
                                        <option value="03:00">3:00 AM</option>
                                        <option value="03:30">3:30 AM</option>
                                        <option value="04:00">4:00 AM</option>
                                        <option value="04:30">4:30 AM</option>
                                        <option value="05:00">5:00 AM</option>
                                        <option value="05:30">5:30 AM</option>
                                        <option value="06:00">6:00 AM</option>
                                        <option value="06:30">6:30 AM</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Điện thoại</label>
                                <div class="form-group">
                                    <input id="cusPhone" name="cusPhone" class="form-control" type="text" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label>Số khách</label>
                                <div class="form-group">
                                    <select id="cusQty" name="cusQty" class="form-control">
                                        <?php 
                                          for($i = 1; $i <= 16; $i++){
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#couponControl" onclick="toggle_visibility('couponContainer');"
                                    class="moduleControl">Mã khuyến mãi</a>
                                <div class="couponContainer" id="couponContainer" style="display: none;">
                                    <input type="text" id="couponEntry" name="coupon" maxlength="25"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="submit" name="sm_rentalCar" value="ĐĂNG KÝ NGAY" id="BtnSearch"
                                    class="button pull-right">
                            </div>
                        </div>
                        <div class="row" id="moto-pickup">
                            <?php 
                                $html = 'Dịch vụ đưa đón sân bay bằng xe máy, xe 4 chỗ, 7 chỗ, 16 chỗ. Quý khách di chuyển 1 mình ít hành lý nên sử dụng dịch vụ xe máy nhanh chóng, an toàn, tiết kiệm thời gian, chi phí.';
                                echo $html;
                            ?>
                        </div>
                    </form>
                    <span class="notice-success">Hệ thống đang xử lý .....</span>
                </div>
                <?php 
                    if(isset($_POST['sm_rentalCar']) && trim($_POST['cusPhone']) != ''){
                        $pickupDate = date( 'Y-m-d',strtotime(str_replace('/','-',$_POST['pickupDate'])));
                        $dropoffDate = date( 'Y-m-d',strtotime(str_replace('/','-',$_POST['dropoffDate'])));
                        $pickupTime = date( 'H:i:s',strtotime(str_replace('','',$_POST['pickupTime'])));
                        $dropoffTime = date( 'H:i:s',strtotime(str_replace('','',$_POST['dropoffTime'])));
                        $ob_datetime = $pickupDate.' '.$pickupTime;
                        $ib_datetime = $dropoffDate.' '.$dropoffTime;
                        //print_r($ob_datetime);
                        //exit();
                        $post_data = array();
                        $post_data['departure']=$_POST['pickupLocation'];
                        $post_data['arrival']=$_POST['dropoffLocation'];
                        $post_data['ob_datetime']= $ob_datetime;
                        $post_data['ib_datetime']= $ib_datetime;
                        $post_data['contact_mobile']=$_POST['cusPhone'];
                        $post_data['total_pax']=$_POST['cusQty'];
                        $post_data['address']='';
                        $post_data['contact_name']='';
                        $post_data['contact_email']='';
                        $post_data['description']='';

                        $result = dat_xe(http_build_query($post_data, 'flags_'));				   
                    }
                ?>
                <!--End car rental-content-->

                <div id="pagecontent" class="cs-order-page-content">
                    <table id="printit" width="98%" style="margin-bottom: 10px;">
                        <tr>
                            <td width="80%">
                                <h2 style="font-size: 18px;">CHI TIẾT ĐƠN HÀNG SỐ : <?php echo $booking_num; ?> </h2>
                            </td>
                            <td style="text-align: right;font-size: 12px;">&nbsp;</td>
                        </tr>
                    </table>
                    <div id="printarea" class="cs-order-table-ticket">
                        <!-- THONG TIN DON HANG -->
                        <table class="field-table" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="csm-booking-order"><strong><?php echo $booking_num; ?></strong></td>
                                <td class="csm-info-flight-order hidden-xs"><strong><?php echo $flight_type; ?></strong></td>
                                <td class="csm-quality-order"><strong><?= $adult ?> người lớn<?= $qty_children.$qty_infants?></strong></td>
                            </tr>
                        </table>
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
                                            <?php  $i = 0; foreach ($flight['dep']['fdetail'] as $key => $fdetail) { ?>
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
                                                        <span class="airlines-code"><u class="text">Hãng:</u><b><?php echo $fdetail['airline']; ?></b></span>
                                                        <span class="airlines-code"><u class="text">Mã chuyến bay:</u><b><?php echo $fdetail['flightno']; ?></b></span>
                                                        <span class="airlines-type"><u class="text">Loại máy bay:</u><b><?php echo $fdetail['aircraft']; ?></b></span>
                                                        <span><u class="text">Hạng chỗ:</u><b><?php echo $fdetail['class']; ?></b></span>
                                                        <span><u class="text">Thời gian bay:</u><b><?php echo $fdetail['nduration']; ?></b></span>
                                                    </div>
                                                </div>
                                                <?php if (isset($flight['dep']['transit'][$i]['arv'])) { ?>
                                                <div class="flight-info-transit">
                                                    <span>
                                                        Thay đổi máy bay tại
                                                        <b><?php echo $flight['dep']['transit'][$i]['arvcityname'] ?>
                                                            (<?php echo $flight['dep']['transit'][$i]['arvcity']; ?>)</b>
                                                        - Thời gian giữa các chuyến bay:
                                                        <b><?php echo $flight['dep']['transit'][$i]['nduration'] ?></b>
                                                    </span>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php $i++; } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if(!$_SESSION['search']['way_flight']) { ?>
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
                                                        <img src="<?php echo imgdir ?>/airlines-logo/<?php echo $retNameAirlinesCode; ?>.png" alt="<?php echo $retNameAirlines; ?>">
                                                        <span class="name-airlines"><?php echo $retNameAirlines; ?></span>
                                                    </span>
                                                </span>
                                                <span class="flight-time">
                                                    <span class="time"><?php echo $retDepTime; ?> - <?php echo $retArvTime; ?></span>
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
                                                        <span class="airlines-code"><u class="text">Hãng:</u><b><?php echo $fdetail['airline']; ?></b></span>
                                                        <span class="airlines-code"><u class="text">Mã chuyến bay:</u><b><?php echo $fdetail['flightno']; ?></b></span>
                                                        <span class="airlines-type"><u class="text">Loại máy bay:</u><b><?php echo $fdetail['aircraft']; ?></b></span>
                                                        <span><u class="text">Hạng chỗ:</u><b><?php echo $fdetail['class']; ?></b></span>
                                                        <span><u class="text">Thời gian bay:</u><b><?php echo $fdetail['nduration']; ?></b></span>
                                                    </div>
                                                </div>
                                                <?php if (isset($flight['ret']['transit'][$j]['arv'])) { ?>
                                                <div class="flight-info-transit">
                                                    <span>
                                                        Thay đổi máy bay tại
                                                        <b><?php echo $flight['ret']['transit'][$j]['arvcityname'] ?>
                                                            (<?php echo $flight['ret']['transit'][$j]['arvcity']; ?>)</b>
                                                        - Thời gian giữa các chuyến bay:
                                                        <b><?php echo $flight['ret']['transit'][$j]['nduration'] ?></b>
                                                    </span>
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



                        <div class="flight-top-total-complete">
                            <label class="text-total">Tổng cộng: </label>
                            <span class="span-text-total"><?php echo format_price($total_amount); ?></span>
                            <br />
                            <label class="text-method-payment">Hình thức thanh toán:</label>
                            <span class="span-text-method-payment"><?php echo $payment_type ?></span>
                            <br />
                            <label class="text-status-method-payment">Trạng thái thanh toán:</label>
                            <span class="span-status-method-payment">Chưa thanh toán</span>
                        </div>
                    </div><!-- #printarea -->

                    <div class="confirm_info cs-cofirm-info">
                        <p style="font-size: 13px;">Quý khách chuyển khoản thanh toán cho chúng tôi vui lòng gọi vào đây
                            để báo có : <br />
                            <span
                                style="font-weight:bold;color:#FE5815; font-size: 22px; line-height: 200%;"><?php echo get_option('opt_phone'); ?></strong></span>
                            <br />

                            Quý khách gởi mail là tốt nhất, vào một trong hai địa chỉ sau :
                            <strong><?php echo get_option('opt_contactemail'); ?></strong>
                            bao gồm thông tin số ĐT, mã đơn hàng, tên người liên hệ.
                            Trong thời gian 30p nếu chưa nhận được phản hồi, xin gọi đến tổng đài để xác nhận.
                        </p>
                        <br />
                    </div><!-- .confirm_info -->
                </div>
            </div>
            <!--#mainDisplay-->
        </div>

        <div id="colRight" class="col-md-4">
            <div class="passsenger">
                <?php get_sidebar(); ?>
            </div><!-- #colRight -->
        </div>
    </div>
</div>
<!--end row wrap col_main+sidebar-->

<?php get_footer(); ?>