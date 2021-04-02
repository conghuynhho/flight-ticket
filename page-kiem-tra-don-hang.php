<?php
/*
Template Name: Re Check Booking
*/
?>
<?php get_header(); ?>
<div class="row"> <div class="block">
	    <div class="col-md-8">  
 
	   <div id="mainDisplay" class="single">
            <h1 class="posttitle"><?php the_title(); ?></h1>	
            
            <div class="check-order">
            
            <?php  if( count($_POST) > 0 && isset($_POST['sm-frmrechech-booking']) ) : ?>
            <?php
                    $booking_email = trim($_POST['booking-email']);
                    $booking_phone = trim($_POST['booking-phone']);
                    $booking_code = trim($_POST['booking-code']);
                    $querywhere = '';
                    if($booking_phone != '')
                        $querywhere .= ' AND ec_flight_bookings.phone = "'.$booking_phone.'"';
                    if($booking_email != '')
                        $querywhere .= ' AND ec_flight_bookings.email = "'.$booking_email.'"';
                    
                    require(TEMPLATEPATH . '/flight_config/sugarrest/sugar_rest.php');				
                    $sugar = new Sugar_REST();
                    
                                    
                    $options['where'] = 'ec_flight_bookings.name="'.$booking_code .'" '.$querywhere;
                    $select = array('id','name','email','phone','booking_status','flight_type','total_amount', 'is_paid','payment_type');
                    $result = $sugar->get("EC_Flight_Bookings", $select, $options);
                    $result = $result[0];
                    
                    if(!empty($result)){
                        $way_flight = $result['flight_type']; 				// Một chiều or Khứ hồi
                        $total_amount = $result['total_amount'];			// Tổng giá tiền của booking
                        $booking_status = $result['booking_status'];		// Trạng thái booking
                        ($result['is_paid'] == 0) ? $is_paid='Chưa thanh toán' : $is_paid='Đã thanh toán';
                        $payment_type = $GLOBALS['payment_type'][$result['payment_type']];
                        
                        // lấy thông tin chuyến bay
                        $options_itinerary['where'] = "ec_booking_itineraries.booking_id = '".$result['id']."'"; 
                        $select_itinerary = array('direction','departure', 'arrival', 'departure_date', 'arrival_date','flight_number','ticket_class','airline_code');
                        $res_itinerary = $sugar->get("EC_Booking_Itineraries", $select_itinerary, $options_itinerary);
                        
                        foreach($res_itinerary as $key => $val){
                            if($val['direction'] == 0){
                                $depart_date = date('d/m/Y', strtotime($val['departure_date']));  		// Ngày đi
                                $dep_deptime = date('H:i', strtotime($val['departure_date']));			// Giờ đi
                                $dep_arvtime = date('H:i', strtotime($val['arrival_date']));
                                $dep_source = $val['departure'];
                                $dep_destination = $val['arrival'];
                                $dep_flightno = $val['flight_number'];
                                $dep_class = $val['ticket_class'];
                                if($val['airline_code'] == 'VNA'){
                                    $dep_logo = 'bg_vnal';
                                }
                                elseif($val['airline_code'] == 'JET'){
                                    $dep_logo = 'bg_js';
                                }
                                elseif($val['airline_code'] == 'AMK'){
                                    $dep_logo = 'bg_amk';
                                }
                                elseif($val['airline_code'] == 'VJA'){
                                    $dep_logo = 'bg_vj';
                                }
                            }
                            if($val['direction'] == 1){
                                $return_date = date('d/m/Y', strtotime($val['departure_date']));			// Ngày về
                                $ret_deptime = date('H:i', strtotime($val['departure_date']));	
                                $ret_arvtime = date('H:i', strtotime($val['arrival_date']));			// Giờ về
                                $ret_source = $val['departure'];
                                $ret_destination = $val['arrival'];
                                $ret_flightno = $val['flight_number'];
                                $ret_class = $val['ticket_class'];
                                if($val['airline_code'] == 'VNA'){
                                    $ret_logo = 'bg_vnal';
                                }
                                elseif($val['airline_code'] == 'JET'){
                                    $ret_logo = 'bg_js';
                                }
                                elseif($val['airline_code'] == 'AMK'){
                                    $ret_logo = 'bg_amk';
                                }
                                elseif($val['airline_code'] == 'VJA'){
                                    $ret_logo = 'bg_vj';
                                }
                            }
                        }
                        
                        // lấy thông tin hành khách
                        $options_passenger['where'] = "ec_booking_passengers.booking_id = '".$result['id'] ."'";
                        $select_passenger = array('type');
                        $res_passenger = $sugar->get("EC_Booking_Passengers", $select_passenger, $options_passenger);
                        $adults = 0;
                        $children = 0;
                        $infants = 0;
                        foreach($res_passenger as $key => $val){
                            if($val['type'] == 0)
                                $adults++;
                            if($val['type'] == 1)
                                $children++;
                            if($val['type'] == 2)
                                $infants ++;
                        }
                        if($children != 0)
                            $qty_children = ', '.$children.' trẻ em';
                        if($infants != 0)
                            $qty_infants = ', '.$infants.' trẻ sơ sinh.';	
            ?>
                <!-- THONG TIN BOOKING -->
                    <p class="bookingcode">Đơn hàng của bạn có mã số: <b style="font-size:18px; color:#f20000; font-weight:bold;"><?php echo $result['name']; ?></b></p>
                    <div id="printarea">
                    <table class="field-table">
                        <tr>
                            <td>Trạng thái:</td><td><strong><?php getBookingStatus($result['booking_status']); ?></strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="15%">Chuyến bay:</td><td><strong><?php echo ($way_flight == 0 ? 'Khứ hồi' : 'Một chiều') ?></strong></td>
                            <td width="20%">Số hành khách:</td><td><strong><?php echo $adults ?> người lớn<?php echo $qty_children.$qty_infants?></strong></td>
                        </tr>
                        <tr>
                            <td>Ngày đi:</td><td><strong><?php echo $depart_date ?></strong></td>
                            <?php if($way_flight == 0)
                                echo '<td>Ngày về:</td><td><strong>'.$return_date.'</strong></td>';
                            ?>
                            
                        </tr>
                    </table>
                    <table class="field-table">
                        <tr>
                            <td style="width:60px;background:#F20000;color:#FFF;font-weight:bold;">Lượt đi</td>
                            <td colspan="3" style="background:#E8E8E8">Khởi hành từ <strong><?php echo $GLOBALS['CODECITY'][$dep_source] ?></strong></td>
                        </tr>
                        <tr>
                            <td class="<?php echo $dep_logo ?>"></td>
                            <td><b><?php echo $GLOBALS['CODECITY'][$dep_source] ?> (<?php echo $dep_source ?>)</b><p style="font-size:11px;"><?php echo $depart_date ?>, <b><?php echo $dep_deptime ?></b></p></td>
                            <td><b><?php echo $GLOBALS['CODECITY'][$dep_destination] ?> (<?php echo $dep_destination ?>)</b><p style="font-size:11px;"><?php echo $depart_date ?>, <b><?php echo $dep_arvtime ?></b></p></td>
                            <td>Mã chuyến: <b><?php echo $dep_flightno ?></b><br />Loại vé: <b><?php echo $dep_class ?></b></td>
                        </tr>
                <?php if($way_flight == 0){ ?>
                        <tr>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td style="width:60px;background:#ED0000;color:#FFF;font-weight:bold">Lượt về</td>
                            <td colspan="3" style="background:#E8E8E8">Khởi hành từ <strong><?php echo $GLOBALS['CODECITY'][$ret_source] ?></strong></td>
                        </tr>
                        <tr>
                            <td class="<?php echo $ret_logo ?>"></td>
                            <td><b><?php echo $GLOBALS['CODECITY'][$ret_source] ?> (<?php echo $ret_source ?>)</b><p style="font-size:11px;"><?php echo $return_date ?>, <b><?php echo $ret_deptime ?></b></p></td>
                            <td><b><?php echo $GLOBALS['CODECITY'][$ret_destination] ?> (<?php echo $ret_destination ?>)</b><p style="font-size:11px;"><?php echo $return_date ?>, <b><?php echo $ret_arvtime ?></b></p></td>
                            <td>Mã chuyến: <b><?php echo $ret_flightno ?></b><br />Loại vé: <b><?php echo $ret_class ?></b></td>
                        </tr>
                <?php } ?>
                    </table>
                    <br />
                    <p><b>Tổng giá tiền: </b><font style="font-weight:bold;font-size:18px;color:#f20000"><?php echo format_price($total_amount);?></font></p>
                    <p>Bạn đã chọn hình thức thanh toán: <font style="font-weight:bold;font-size:16px;color:#2481C6"><?php echo $payment_type ?></font>.</p>
                    <p>Trạng thái thanh toán: <font style="font-weight:bold;font-size:16px;color:#2481C6"><?php echo $is_paid; ?></font>.</p>
                    </div>
                <?php }else{ # END if?>    
                    <div class="errormsg" style="width:100%; margin:10px auto;">
                        <p style="padding:10px; border:1px solid #f20000; background:#FFD8C2; line-height:16px; font-size:13px;">Thông tin đặt vé của bạn không có thật.<br />Vui lòng <a href="<?php bloginfo('siteurl') ?>/lien-he" title="Liên hệ <?php bloginfo('name'); ?>"><b>Liên hệ <?php bloginfo('name'); ?></b></a> hoặc <a href="<?php the_permalink() ?>" title=""><b>Thử lại</b></a>.</p>
                    </div>	         
                <?php } #END ELSE ?>
                <!-- END THONG TIN BOOKING -->				
            <?php  else : ?>
            
                <div id="editor-area">		
                <?php if (have_posts() && !is_page('slider')) : while (have_posts()) : the_post();?>
                
                <?php the_content();?>
            
                <?php endwhile; else: ?>
                <p><?php _e('Lỗi không tìm thấy trang hoặc nội dung không tìm thấy'); ?></p>
                <?php endif;?>
                </div>
                <!-- END #editor-area -->
                <p>Booking vé máy bay, check-in online. Bạn hãy nhập email hoặc số điện thoại kèm theo mã đơn hàng (booking). Hệ thống sẽ giúp bạn tra cứu vé của <strong>Vietjet, Jetstar và Vietnam Airlines</strong>. Liên hệ booker để được trợ giúp : <?php echo get_option('opt_hotline'); ?>.</p>
                <div class="row block-blue">
                  <p class="errormsg" style="text-align:center;display:none;margin-bottom:10px;"></p>
                  <form action="" method="post" id="frmrechech-booking">
                    <div class="col-md-6 col-sm-12 bcheck">
                            <div class="form-group secs">
                            <label for="booking-email">Email:</label>
                            <input type="text" name="booking-email" id="booking-email" class="form-control" autocomplete="off" />
                            </div>
                            
                            <div class="form-group secs">
                            <label for="booking-phone">Hoặc điện thoại:</label>
                            <input type="text" name="booking-phone" id="booking-phone" class="form-control" autocomplete="off" />
                            </div>
               
                            
                            <div class="form-group secs">
                            <label for="booking-code">Mã đơn hàng:</label>
                            <input type="text" name="booking-code" id="booking-code" class="form-control" autocomplete="off" />
                            </div>
                            
                            <div class="form-group secs">
                            <input type="submit" name="sm-frmrechech-booking" value="Kiểm tra" title="Kiểm tra" class="button pull-right" />
                            </div>
                              <div class="clearfix"></div>
                        </div>
                  </form>
                </div>
    
                
            <?php endif; # END else 	?>
            </div> <!-- end .check-order -->
            
        </div><!--- end #mainDisplay -->  
              	
    	</div><!--#colLeft-->
 
   
    
     <div class="col-md-4">
        <?php get_sidebar(); ?>
        <div class="clearfix"></div>
    </div><!--#colRight-->
    
    <div class="clearfix"></div>
</div></div>    
<?php
get_footer();
?>