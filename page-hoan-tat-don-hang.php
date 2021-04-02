<?php
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
$siteurl = get_bloginfo('siteurl');
if (empty($_SESSION['booking'])) {
    header('Location:' . $siteurl);
    exit();
}

if ($_SESSION['search']['isinter'] && !empty($_SESSION['contact']) && !empty($_SESSION['dep'])) {
    require_once('flight_complete_inter.php');
    exit();
}

require(TEMPLATEPATH . '/flight_config/sugarrest/sugar_rest.php');
$sugar = new Sugar_REST();
$error = $sugar->get_error();

$booking_id = $_SESSION['booking']['id'];
$options['limit'] = 1;
// lấy thông tin booking
$options['where'] = 'ec_flight_bookings.id="' . $booking_id . '"';
$select = array('name', 'email', 'phone', 'booking_status', 'flight_type', 'total_amount', 'is_paid', 'payment_type', 'ticket_type');
$result = $sugar->get("EC_Flight_Bookings", $select, $options);
$result = $result[0];

$way_flight = $result['flight_type'];                 // Một chiều or Khứ hồi
$way_flight_text = ($way_flight == 0) ? "Khứ hồi" : "Một chiều";                 // Một chiều or Khứ hồi

$total_amount = $result['total_amount'];            // Tổng giá tiền của booking
$booking_status = $result['booking_status'];        // Trạng thái booking
($result['is_paid'] == 0) ? $is_paid = 'Chưa thanh toán' : $is_paid = 'Đã thanh toán';
$payment_type = $GLOBALS['payment_type'][$result['payment_type']];
// lấy thông tin chuyến bay

$options_itinerary['where'] = "ec_booking_itineraries.booking_id = '" . $booking_id . "'";
$select_itinerary = array('direction', 'departure', 'arrival', 'departure_date', 'arrival_date', 'flight_number', 'ticket_class', 'airline_code', 'description', 'duration', 'airline_name');
$res_itinerary = $sugar->get("EC_Booking_Itineraries", $select_itinerary, $options_itinerary);

foreach ($res_itinerary as $key => $val) {
    if ($val['direction'] == 0) {
        $depart_date = date('d/m/Y', strtotime($val['departure_date']));          // Ngày đi
        $dep_deptime = date('H:i', strtotime($val['departure_date']));            // Giờ đi
        $dep_arvtime = date('H:i', strtotime($val['arrival_date']));
        $dep_source = $val['departure'];
        $dep_destination = $val['arrival'];
        $dep_flightno = $val['flight_number'];
        $dep_class = $val['ticket_class'];
        if ($val['airline_code'] == 'VNA') {
            // $dep_logo = 'bg_vnal';
            $dep_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smVN.png"';
        } elseif ($val['airline_code'] == 'JET') {
            // $dep_logo = 'bg_js';
            $dep_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smBL.png"';
        } elseif ($val['airline_code'] == 'AMK') {
            $dep_logo = 'bg_amk';
        } elseif ($val['airline_code'] == 'VJA') {
            // $dep_logo = 'bg_vj';
            $dep_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smVJ.png"';
        } elseif ($val['airline_code'] == 'BBA') {
            // $dep_logo = 'bg_qh';
            $dep_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smQH.png"';
        }
    }
    if ($val['direction'] == 1) {
        $return_date = date('d/m/Y', strtotime($val['departure_date']));            // Ngày về
        $ret_deptime = date('H:i', strtotime($val['departure_date']));
        $ret_arvtime = date('H:i', strtotime($val['arrival_date']));            // Giờ về
        $ret_source = $val['departure'];
        $ret_destination = $val['arrival'];
        $ret_flightno = $val['flight_number'];
        $ret_class = $val['ticket_class'];
        if ($val['airline_code'] == 'VNA') {
            // $ret_logo = 'bg_vnal';
            $ret_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smVN.png"';
        } elseif ($val['airline_code'] == 'JET') {
            // $ret_logo = 'bg_js';
            $ret_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smBL.png"';
        } elseif ($val['airline_code'] == 'AMK') {
            $ret_logo = 'bg_amk';
        } elseif ($val['airline_code'] == 'VJA') {
            // $ret_logo = 'bg_vj';
            $ret_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smVJ.png"';
        } elseif ($val['airline_code'] == 'BBA') {
            // $ret_logo = 'bg_qh';
            $ret_logo = '<img src="' . get_template_directory_uri() . '/images/airline-icons/smQH.png"';
        }
    }
}

// lấy thông tin hành khách
$options_passenger['where'] = "ec_booking_passengers.booking_id = '" . $booking_id . "'";
$select_passenger = array('type');
$res_passenger = $sugar->get("EC_Booking_Passengers", $select_passenger, $options_passenger);
$adults = 0;
$children = 0;
$infants = 0;
foreach ($res_passenger as $key => $val) {
    if ($val['type'] == 0)
        $adults++;
    if ($val['type'] == 1)
        $children++;
    if ($val['type'] == 2)
        $infants++;
}
if ($children != 0 || $children == 0)
    $qty_children = ', ' . $children . ' trẻ em';
if ($infants != 0 || $infants == 0)
    $qty_infants = ', ' . $infants . ' trẻ sơ sinh.';

if (!isset($_SESSION[$booking_id]['sendmail'])) {
    if ($result['ticket_type'] == 2) {
        //include(get_stylesheet_directory()."/flight_config/mailconfirm_inter.php");
    } else {
        #include(get_stylesheet_directory()."/flight_config/mailconfirm.php");
    }

    $_SESSION[$booking_id]['sendmail'] = true;
}
//Car Rentall
$pickuptime_tmp = date("d/m/Y", time() + (60 * 60));
$maxtime_tmp = date("d/m/Y", time() + (60 * 60 * (8760)));
$crrttime_tmp = date("d/m/Y", time());
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
            <div id="mainDisplay">
                <div class="confirmbox">
                    <h2 class="text-info-save-seat"> Thông tin giữ chỗ đã ghi nhận</h2>
                    <h3 class="h3-text-booking">Booking : <b style="font-size:25px;color:#F20000;font-weight:bold;"><?php echo  $result['name'] ?></b></h3>
                    <div>
                        <p style="text-align: justify; margin: 5px 0; font-size: 14px;" class="p-text-booking">
                            Sau quá trình xác nhận này quý khách cần chuyển khoản thanh toán để bảo vệ giá. Sau khi chuyển khoản xin vui lòng nhắn tin báo vào số :
                            <span style="font-weight: bold; color:#FE5815" class="span-hotline-booking"><?php echo get_option('opt_accountant_phone'); ?></span></p>
                        <p class="text-complete-order-success">
                            Tổng đài hỗ trợ bạn 24/7: <span style="font-weight: bold; color:#FE5815" class="cs-color-back"><?php echo get_option('opt_phone'); ?></span>.
                        </p>

                        <!-- <p style="text-align: justify;margin: 5px 0;">
                   Chi tiết hành trình : thông tin chuyến bay và code vé (PNR) sẽ được gửi tới email của bạn : <b><?= $result['email'] ?></b>
                </p> -->
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--.confirmbox-->
                <!-- <div class="row" id="carRental-wrap">
				<div class="col-md-4">
				<img src="<?php bloginfo('template_directory') ?>/images/carRental-icon.png" alt="Dịch vụ đưa đón sân bay">
				</div>
				<div class="col-md-8">
						<a href="#carRentalContainer" id="carRental"  class="nav-toggle">Bạn muốn sử dụng dịch vụ <br><b>XE ĐƯA ĐÓN SÂN BAY?</b> 
						<span class="button config-button-box-shadow">ĐĂNG KÝ NGAY</span></a>
				</div>
			</div> -->
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
                                        <input id="pickupDate" name="pickupDate" readonly class="form-control" after_function="change_pickup_date" minDate="<?= $crrttime_tmp ?>" maxdate="<?= $maxtime_tmp ?>" default_max_date="<?= $maxtime_tmp ?>" type="text" default="<?= $pickuptime_tmp ?>" value="<?= $pickuptime_tmp ?>" autocomplete="off">
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
                                        <input id="dropoffDate" name="dropoffDate" readonly class="form-control" after_function="change_dropoff_date" minDate="<?= $pickuptime_tmp ?>" maxdate="<?= $maxtime_tmp ?>" type="text" default="--/--/----" value="--/--/----" autocomplete="off">
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
                                        for ($i = 1; $i <= 16; $i++) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <a href="#couponControl" onclick="toggle_visibility('couponContainer');" class="moduleControl">Mã khuyến mãi</a>
                                <div class="couponContainer" id="couponContainer" style="display: none;">
                                    <input type="text" id="couponEntry" name="coupon" maxlength="25" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input type="submit" name="sm_rentalCar" value="ĐĂNG KÝ NGAY" id="BtnSearch" class="button pull-right">
                            </div>
                        </div>
                        <div class="row" id="moto-pickup">Dịch vụ đưa đón sân bay bằng xe máy, xe 4 chỗ, 7 chỗ, 16 chỗ.
                            Quý khách di chuyển 1 mình ít hành lý nên sử dụng dịch vụ xe máy nhanh chóng, an toàn, tiết kiệm thời gian, chi phí.</div>

                    </form>
                    <span class="notice-success">Hệ thống đang xử lý .....</span>

                </div>
                <?php
                if (isset($_POST['sm_rentalCar']) && trim($_POST['cusPhone']) != '') {
                    //******************************************//
                    $pickupDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['pickupDate'])));
                    $dropoffDate = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['dropoffDate'])));
                    $pickupTime = date('H:i:s', strtotime(str_replace('', '', $_POST['pickupTime'])));
                    $dropoffTime = date('H:i:s', strtotime(str_replace('', '', $_POST['dropoffTime'])));
                    $ob_datetime = $pickupDate . ' ' . $pickupTime;
                    $ib_datetime = $dropoffDate . ' ' . $dropoffTime;
                    //print_r($ob_datetime);
                    //exit();
                    $post_data = array();
                    $post_data['departure'] = $_POST['pickupLocation'];
                    $post_data['arrival'] = $_POST['dropoffLocation'];
                    $post_data['ob_datetime'] = $ob_datetime;
                    $post_data['ib_datetime'] = $ib_datetime;
                    $post_data['contact_mobile'] = $_POST['cusPhone'];
                    $post_data['total_pax'] = $_POST['cusQty'];
                    $post_data['address'] = '';
                    $post_data['contact_name'] = '';
                    $post_data['contact_email'] = '';
                    $post_data['description'] = '';

                    $result = dat_xe(http_build_query($post_data, 'flags_'));
                } ?>
                <!--End car rental-content-->
                <div id="pagecontent" class="cs-order-page-content">
                    <table id="printit" width="98%" style="margin-bottom: 10px;">
                        <tr>
                            <td width="80%">
                                <h2 style="font-size: 18px;">CHI TIẾT ĐƠN HÀNG SỐ : <?php echo  $result['name'] ?> </h2>
                            </td>
                            <td style="text-align: right;font-size: 12px;">&nbsp;</td>
                        </tr>
                    </table>
                    <div id="printarea" class="cs-order-table-ticket">
                        <a href="javascript:window.print()" id="btnprint" class="hidden-xs">Print</a>
                        <?php
                        if ($result['ticket_type'] == 2) { #CHUYEN QUOC TE
                            ?>
                            <table class="field-table">
                                <tr>
                                    <td>Mã số (Booking):</td>
                                    <td><strong><?php echo  $result['name'] ?></strong></td>
                                    <td>Trạng thái:</td>
                                    <td><strong>Chưa xác nhận</strong></td>
                                </tr>
                                <tr>
                                    <td width="15%">Chuyến bay:</td>
                                    <td><strong><?php echo  $way_flight_text ?></strong></td>
                                    <td width="20%">Số hành khách:</td>
                                    <td><strong><?php echo  $adults ?> người lớn<?php echo  $qty_children . $qty_infants ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Ngày đi:</td>
                                    <td><strong><?php echo  $depart_date ?></strong></td>
                                    <?php if ($way_flight == 0)
                                            echo '<td>Ngày về:</td><td><strong>' . $return_date . '</strong></td>';
                                        ?>

                                </tr>
                            </table>
                            <!--HANH TRINH CHUYEN BAY-->
                            <?php
                                /*echo '<pre>';
                       print_r($res_itinerary);
                       echo '</pre>';*/
                                if ($way_flight == 1) {
                                    $dep_int = $res_itinerary;
                                } else {
                                    foreach ($res_itinerary as $ht) {
                                        if ($ht['direction'] == 0)
                                            $dep_int[] = $ht;
                                        else
                                            $ret_int[] = $ht;
                                    }
                                }
                                $dep_source = $dep_int[0]['departure'];
                                ?>

                            <table class="field-table">
                                <tr>
                                    <td colspan="4" class="go-icon">Khởi hành từ <strong><?php echo  $dep_source ?></strong></td>
                                </tr>
                                <?php foreach ($dep_int as $ht) :
                                        $dep_logo = get_stylesheet_directory_uri() . "/images/inter_airline_icon/" . $ht['airline_code'] . ".gif";
                                        $dep_destination = $ht['arrival'];
                                        $dep_source = $ht['departure'];
                                        $dep_flightno = $ht['flight_number'];
                                        $depart_date = date('d/m/Y', strtotime($ht['departure_date']));          // Ngày đi
                                        $arv_date   = date('d/m/Y', strtotime($ht['arrival_date'])); // Ngày tới
                                        $dep_deptime = date('H:i', strtotime($ht['departure_date']));          // giờ đi đi
                                        $dep_arvtime = date('H:i', strtotime($ht['arrival_date']));
                                        ?>
                                    <tr>
                                        <td class="logo"><img src="<?php echo  $dep_logo ?>" /> </td>
                                        <td><b><?php echo  $dep_source ?></b>
                                            <p><?php echo  $depart_date ?>, <b><?php echo  $dep_deptime ?></b></p>
                                        </td>
                                        <td><b><?php echo  $dep_destination ?></b>
                                            <p><?php echo  $arv_date ?>, <b><?php echo  $dep_arvtime ?></b></p>
                                        </td>
                                        <td><?php echo  $ht['airline_name'] ?> <br />
                                            Mã chuyến bay: <b><?php echo  $dep_flightno ?></b></td>
                                    </tr>
                                <?php
                                        if ($ht['description'] != "") echo '<tr><td colspan="4"><p style="background: #FFECCA;text-align:center;padding:5px;">' . $ht['description'] . '</p></td> </tr>';
                                    endforeach;
                                    ?>

                                <?php if ($way_flight == 0) { # 2 chieu 
                                        ?>
                                    <?php
                                            $ret_from = $ret_int[0]['departure'];
                                            ?>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="back-icon">Khởi hành từ <strong><?php echo  $ret_from ?></strong></td>
                                    </tr>
                                    <?php foreach ($ret_int as $ht) :
                                                $ret_logo = get_stylesheet_directory_uri() . "/images/inter_airline_icon/" . $ht['airline_code'] . ".gif";
                                                $ret_destination = $ht['arrival'];
                                                $ret_source = $ht['departure'];
                                                $ret_flightno = $ht['flight_number'];
                                                $return_date = date('d/m/Y', strtotime($ht['departure_date']));          // Ngày đi
                                                $arv_date   = date('d/m/Y', strtotime($ht['arrival_date'])); // Ngày tới
                                                $ret_deptime = date('H:i', strtotime($ht['departure_date']));          // giờ đi đi
                                                $ret_arvtime = date('H:i', strtotime($ht['arrival_date']));
                                                ?>
                                        <tr>
                                            <td class="logo"><img src="<?php echo  $dep_logo ?>" /> </td>
                                            <td><b><?php echo  $ret_source ?></b>
                                                <p style="font-size:11px;"><?php echo  $return_date ?>, <b><?php echo  $ret_deptime ?></b></p>
                                            </td>
                                            <td><b><?php echo  $ret_destination ?></b>
                                                <p style="font-size:11px;"><?php echo  $arv_date ?>, <b><?php echo  $ret_arvtime ?></b></p>
                                            </td>
                                            <td><?php echo  $ht['airline_name'] ?> <br />
                                                Mã chuyến: <b><?php echo  $ret_flightno ?></b></td>
                                        </tr>
                                    <?php
                                                if ($ht['description'] != "") echo '<tr><td colspan="4"><p style="background: #FFECCA;text-align:center;padding:5px;">' . $ht['description'] . '</p></td> </tr>';
                                            endforeach;
                                            ?>
                                <?php } ?>
                            </table>

                        <?php
                        } else { #CHUYEN NOI DIA
                            ?>
                            <!-- THONG TIN DON HANG -->
                            <table class="field-table" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td class="csm-booking-order"><strong><?= $result['name'] ?></strong></td>
                                    <td class="csm-info-flight-order hidden-xs"><strong><?= $way_flight_text ?></strong></td>
                                    <td class="csm-quality-order"><strong><?= $adults ?> người lớn<?= $qty_children . $qty_infants ?></strong></td>
                                </tr>

                            </table>
                            <!-- THONG TIN HANH TRINH -->
                            <table class="field-table hidden-xs" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr style="line-height:1px;">
                                    <td width="13%">&nbsp;</td>
                                    <td width="26%">&nbsp;</td>
                                    <td width="26%">&nbsp;</td>
                                    <td width="35%">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="go-icon">Khởi hành từ <strong><?php echo  $GLOBALS['CODECITY'][$dep_source] ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="logo"><?php echo  $dep_logo ?></td>
                                    <td class="cs-td-departure"><b><?php echo  $GLOBALS['CODECITY'][$dep_source] ?> (<?php echo  $dep_source ?>)</b>
                                        <p style="font-size:11px;" class="cs-font-size-departure"><b><?php echo  $dep_deptime ?></b>, <?php echo  $depart_date ?></p>
                                    </td>
                                    <td class="cs-td-arrvial"><b><?php echo  $GLOBALS['CODECITY'][$dep_destination] ?> (<?php echo  $dep_destination ?>)</b>
                                        <p style="font-size:11px;" class="cs-font-size-arrival"><b><?php echo  $dep_arvtime ?></b>, <?php echo  $depart_date ?></p>
                                    </td>
                                    <td>Mã chuyến: <b><?php echo  $dep_flightno ?></b><br />Loại vé: <b><?php echo  $dep_class ?></b></td>
                                </tr>
                                <?php if ($way_flight == 0) { ?>
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="back-icon">Khởi hành từ <strong><?php echo  $GLOBALS['CODECITY'][$ret_source] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="logo"><?php echo  $ret_logo ?></td>
                                        <td><b><?php echo  $GLOBALS['CODECITY'][$ret_source] ?> (<?php echo  $ret_source ?>)</b>
                                            <p style="font-size:11px;"><b><?php echo  $ret_deptime ?></b>, <?php echo  $return_date ?></p>
                                        </td>
                                        <td><b><?php echo  $GLOBALS['CODECITY'][$ret_destination] ?> (<?php echo  $ret_destination ?>)</b>
                                            <p style="font-size:11px;"><b><?php echo  $ret_arvtime ?></b>, <?php echo  $return_date ?></p>
                                        </td>
                                        <td>Mã chuyến: <b><?php echo  $ret_flightno ?></b><br />Loại vé: <b><?php echo  $ret_class ?></b></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <div class="row mobile-info-custommer-dep hidden-sm hidden-md hidden-lg">
                                <div class="mobile-go-air mb-float-left">
                                    <b><?= $GLOBALS['CODECITY'][$dep_source] ?></b>
                                </div>
                                <div class="mobile-images-arrows-right mb-float-left">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right-black.png" />
                                    <b><?= $GLOBALS['CODECITY'][$dep_destination] ?></b>
                                </div>
                                <div class="mobile-go-date-air"><?= $depart_date ?></div>
                                <div class="mobile-logo-air">
                                    <?php echo $dep_logo; ?>
                                </div>
                                <p class="mobile-name-aircode"><b><?= $dep_flightno ?></b></p>
                                <div class="mobile-dep-arv-time">
                                    <b><?= $dep_deptime ?></b> - <b><?= $dep_arvtime ?></b>
                                </div>
                            </div>
                    </div>
                    <!--END MOBILE-->
                    <? if ($way_flight == 0) { ?>
                        <!--MOBILE CHIỀU VỀ-->
                        <div class="row mobile-info-custommer-dep hidden-sm hidden-md hidden-lg">
                            <div class="mobile-go-air mb-float-left">
                                <b><?= $GLOBALS['CODECITY'][$ret_source] ?></b>
                            </div>
                            <div class="mobile-images-arrows-right mb-float-left">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/arrow-right-black.png" />
                                <b><?= $GLOBALS['CODECITY'][$ret_destination] ?></b>
                            </div>
                            <div class="mobile-go-date-air"><?= $return_date ?></div>
                            <div class="mobile-logo-air">
                                <?php echo $ret_logo; ?>
                            </div>
                            <p class="mobile-name-aircode"><b><?= $ret_flightno ?></b></p>
                            <div class="mobile-dep-arv-time">
                                <b><?= $ret_deptime ?></b> - <b><?= $ret_arvtime ?></b>
                            </div>
                        </div>
                </div>
                <!--END MOBILE-->
            <? } ?>

        <?php } # END ELSE
        ?>

        <div style="border-top:1px dashed #ccc; padding-top:10px; line-height:30px;">
            <label style="display: inline-block;width: 145px;margin-right: 10px;" class="cs-table-total">Tổng cộng: </label>
            <span style="font-weight:bold;font-size:20px;color:#F20000;"><?php echo format_price($total_amount); ?></span>
            <label style="display: inline-block;width: 145px;margin-right: 10px;" class="cs-table-payment">Hình thức thanh toán:</label>
            <span style="font-weight:bold;font-size:16px;color:#59A800"><?php echo  $payment_type ?></span>
            <label style="display: inline-block;width: 145px;margin-right: 10px;" class="cs-table-status">Trạng thái thanh toán:</label>
            <span style="font-weight:bold;font-size:16px;color:#59A800"><?php echo  $is_paid; ?></span>
        </div>

            </div><!-- #printarea -->

            <div class="confirm_info cs-cofirm-info">
                <p style="font-size: 13px;">Quý khách chuyển khoản thanh toán cho chúng tôi vui lòng gọi vào đây để báo có : <br />
                    <span style="font-weight:bold;color:#FE5815; font-size: 22px; line-height: 200%;"><?php echo get_option('opt_phone'); ?></strong></span> <br />

                    Quý khách gởi mail là tốt nhất, vào một trong hai địa chỉ sau : <strong><?php echo get_option('opt_contactemail'); ?></strong>
                    bao gồm thông tin số ĐT, mã đơn hàng, tên người liên hệ.
                    Trong thời gian 30p nếu chưa nhận được phản hồi, xin gọi đến tổng đài để xác nhận.
                </p>
                <br />
            </div><!-- .confirm_info -->

        </div>
    </div>
    <!--#mainDisplay-->

</div><!-- #colLeftNoBorder -->
<div class="col-md-4">
    <?php get_sidebar(); ?>
    <div class="clearfix"></div>
</div><!-- #colRight -->
</div>
</div>
<?php get_footer(); ?>