<?php
/*
Template Name: tim-chuyen-bay-bl-core
*/ 
if(!empty($_GET['out']) && !empty($_GET['dep']) && !empty($_GET['arv'])){
	if(!empty($_SESSION['data_bl'])){
		$data_bl = $_SESSION['data_bl'];
	} else {
		$post_data = array();
		$post_data['dep_code'] = $_GET['dep'];
		$post_data['arv_code'] = $_GET['arv'];
		$post_data['outbound_date'] = re_date($_GET['out']);
		$post_data['domain'] = 'dulichbalo.org';
		if(!empty($_GET['in'])){ $post_data['inbound_date'] = re_date($_GET['in']);}
		if(!empty($_GET['adt'])){ $post_data['adt_count'] = $_GET['adt'];}	
		if(!empty($_GET['chd'])){ $post_data['chd_count'] = $_GET['chd'];}
		if(!empty($_GET['inf'])){ $post_data['inf_count'] = $_GET['inf'];}
		$data_bl = tim_chuyen_bay_bl($post_data);
		$_SESSION['data_bl'] = $data_bl;
	}
	$bl_out = xep_theo_gia_chuyen_bay($data_bl['data']['outbound']);
		if(!empty($_GET['in'])){
			$bl_in = xep_theo_gia_chuyen_bay($data_bl['data']['inbound']);
	}
?>
<?php foreach($bl_out as $out) { ?>
<?php
    $flights_oneway_code = $out['base_price'].str_replace(":", "", $out['dep_time'].$out['airline']['code']);
    $in_session = "0";
    if(!empty($_SESSION["flights_oneway_cart"])) {
        $session_oneway_code_array = array_keys($_SESSION["flights_oneway_cart"]);
        if(in_array($flights_oneway_code,$session_oneway_code_array)) {
            $in_session = "1";
        }
    }
?>
<div id="booking-bl-list">
<script type="text/javascript">
NProgress.done();
</script>
<li>
    <div class="booking-item-container booking-bl-item-container">
        <div class="booking-item booking-bl-item">
             <div class="row">
                <div class="col-md-2">
                    <div class="booking-item-airline-logo">
                        <img src="<?= $out['airline']['img_sqrt'] ?>" alt="Image Alternative text" title="Image Title" />
                        <p><?= $out['airline']['name'] ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="booking-item-flight-details">
                        <div class="booking-item-departure"><i class="fa fa-plane"></i>
                            <h5><small>Đi</small> <?= $out['dep_time'] ?></h5>
                            <p class="booking-item-date"><?= re_date_vn($out['dep_date']) ?></p>
                            <p class="booking-item-destination"><?= $out['dep_airport'] ?></p>
                        </div>
                        <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-horizontal"></i>
                            <h5><small>Đến</small> <?php if($out['stop'] != 0) { ?><?= $out['arv_time2'] ?> <?php } else {echo $out['arv_time'];}?></h5>
                            <p class="booking-item-date"><?php if($out['stop'] != 0) { ?><?= re_date_vn($out['arv_date2']) ?> <?php } else {echo re_date_vn($out['arv_date']);}?></p>
                            <p class="booking-item-destination"><?php if($out['stop'] != 0) { ?><?= $out['arv_airport2'] ?> <?php } else {echo $out['arv_airport'];}?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                	<span class="booking-item-price"><?= price_dot($out['base_price']) ?></span>
                    <p class="booking-item-flight-class"><?= $out['ticket_class'] ?><?php if ($out['stop'] != 0) { ?>/Quá cảnh<?php } ?></p>
                </div>
                <div class="col-md-2">
                    <input type="button" id="add_<?php echo $flights_oneway_code; ?>" value="Chọn" class="addout btnAddAction cart-action" onClick = "cartFlightout('add','<?php echo $flights_oneway_code; ?>')" <?php if($in_session != "0") { ?>style="display:none" <?php } ?> />
                    <input type="button" id="added_<?php echo $flights_oneway_code; ?>" value="Đã chọn" class="addedout btnAdded" <?php if($in_session != "1") { ?>style="display:none" <?php } ?> />
                </div>
            </div>
        </div>
        <div class="booking-item-details">
            <div class="row">
                <div class="col-md-5">
                    <p>Thông tin chi tiết</p>
                    <h5 class="list-title"><?= $out['dep_airport'] ?> <small>đến</small> <?= $out['arv_airport'] ?></h5>
                    <ul class="list">
                        <li>Mã chuyến bay: <strong><?= $out['flight_no'] ?></strong></li>
                        <li>Hạng vé: <strong><?= $out['ticket_class'] ?></strong></li>
                        <li>Từ <strong><?= $out['dep_time'] ?></strong> đến <strong><?= $out['arv_time'] ?></strong></li>
                    </ul>
                    <p>Tổng thời gian bay: <strong><?= $out['nice_duration'] ?></strong></p>
                </div>
                <?php if ($out['stop'] != 0) { ?>
                <div class="col-md-3">
                    <p>Quá cảnh</p>
                    <h5 class="list-title"><?= $out['dep_airport2'] ?> <small>đến</small></h5>
                    <h5><?= $out['arv_airport2'] ?></h5>
                    <ul class="list">
                        <li>Mã chuyến bay: <strong><?= $out['flight_no2'] ?></strong></li>
                        <li>Hạng vé: <strong><?= $out['ticket_class'] ?></strong></li>
                        <li>Từ <strong><?= $out['dep_time2'] ?></strong> đến <strong><?= $out['arv_time2'] ?></strong></li>
                    </ul>
                </div>
                <?php } ?>
                <div class="col-md-4">
                    <p>Thông tin chi phí</p>
                    <h5 class="list-title"><?= $_GET['adt'] ?> người lớn <?= $_GET['chd'] ?> trẻ em <?= $_GET['inf'] ?> sơ sinh</h5>
                    <ul class="list">
                        <li>Người lớn: <strong><?= price_dot($out['fares']['adt_base_price1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li>
                        <?php if($_GET['chd'] != 0) { ?><li>Trẻ em: <strong><?= price_dot($out['fares']['chd_base_price1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                        <?php if($_GET['inf'] != 0) { ?><li>Sơ sinh: <strong><?= price_dot($out['fares']['inf_base_price1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                        <li>Thuế phí người lớn: <strong><?= price_dot($out['fares']['adt_tax_fee1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li>
                        <?php if($_GET['chd'] != 0) { ?><li>Thuế phí trẻ em: <strong><?= price_dot($out['fares']['chd_tax_fee1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                        <?php if($_GET['inf'] != 0) { ?><li>Thuế phí sơ sinh: <strong><?= price_dot($out['fares']['inf_tax_fee1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                    </ul>
                    <p>Tổng cộng: <strong><?= price_dot($out['fares']['total_amount'])?></strong></p>
                </div>
            </div>
        </div>
    </div>
</li>
</div>
<?php } ?>
<?php foreach($bl_in as $in) { ?>
	<?php
        $flights_return_code = $in['base_price'].str_replace(":", "", $in['dep_time'].$in['airline']['code']);
        $in_session = "0";
        if(!empty($_SESSION["flights_return_cart"])) {
            $session_return_code_array = array_keys($_SESSION["flights_return_cart"]);
            if(in_array($flights_return_code,$session_return_code_array)) {
                $in_session = "1";
            }
        }
    ?>
<div id="booking-bl-return-list">
<li>
    <div class="booking-item-container booking-bl-return-item-container">
        <div class="booking-item booking-bl-return-item">
            <div class="row">
                <div class="col-md-2">
                    <div class="booking-item-airline-logo">
                        <img src="<?= $in['airline']['img_sqrt'] ?>" alt="Image Alternative text" title="Image Title" />
                        <p><?= $in['airline']['name'] ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="booking-item-flight-details">
                        <div class="booking-item-departure"><i class="fa fa-plane"></i>
                            <h5><small>Đi</small> <?= $in['dep_time'] ?></h5>
                            <p class="booking-item-date"><?= re_date_vn($in['dep_date']) ?></p>
                            <p class="booking-item-destination"><?= $in['dep_airport'] ?></p>
                        </div>
                        <div class="booking-item-arrival"><i class="fa fa-plane fa-flip-horizontal"></i>
                            <h5><small>Đến</small> <?php if($in['stop'] != 0) { ?><?= $in['arv_time2'] ?> <?php } else {echo $in['arv_time'];}?></h5>
                            <p class="booking-item-date"><?php if($in['stop'] != 0) { ?><?= re_date_vn($in['arv_date2']) ?> <?php } else {echo re_date_vn($in['arv_date']);}?></p>
                            <p class="booking-item-destination"><?php if($in['stop'] != 0) { ?><?= $in['arv_airport2'] ?> <?php } else {echo $in['arv_airport'];}?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                	<span class="booking-item-price"><?= price_dot($in['base_price']) ?></span>
                    <p class="booking-item-flight-class"><?= $in['ticket_class'] ?><?php if ($in['stop'] != 0) { ?>/Quá cảnh<?php } ?></p>
                </div>
                <div class="col-md-2">
                    <input type="button" id="add_<?php echo $flights_return_code; ?>" value="Chọn" class="addin btnAddAction cart-action" onClick = "cartFlightin('add','<?php echo $flights_return_code; ?>')" <?php if($in_session != "0") { ?>style="display:none" <?php } ?> />
                    <input type="button" id="added_<?php echo $flights_return_code; ?>" value="Đã chọn" class="addedin btnAdded" <?php if($in_session != "1") { ?>style="display:none" <?php } ?> />
                </div>
            </div>
        </div>
        <div class="booking-item-details">
            <div class="row">
                <div class="col-md-5">
                    <p>Thông tin chi tiết</p>
                    <h5 class="list-title"><?= $in['dep_airport'] ?> <small>đến</small> <?= $in['arv_airport'] ?></h5>
                    <ul class="list">
                        <li>Mã chuyến bay: <strong><?= $in['flight_no'] ?></strong></li>
                        <li>Hạng vé: <strong><?= $in['ticket_class'] ?></strong></li>
                        <li>Còn lại: <strong><?= $in['seat_left'] ?></strong> ghế trống</li>
                        <li>Từ <strong><?= $in['dep_time'] ?></strong> đến <strong><?= $in['arv_time'] ?></strong></li>
                    </ul>
                    <p>Tổng thời gian bay: <strong><?= $in['nice_duration'] ?></strong></p>
                </div>
                <?php if ($in['stop'] != 0) { ?>
                <div class="col-md-3">
                    <p>Quá cảnh</p>
                    <h5 class="list-title"><?= $in['dep_airport2'] ?> <small>đến</small></h5>
                    <h5><?= $in['arv_airport2'] ?></h5>
                    <ul class="list">
                        <li>Mã chuyến bay: <strong><?= $in['flight_no2'] ?></strong></li>
                        <li>Từ <strong><?= $in['dep_time2'] ?></strong> đến <strong><?= $in['arv_time2'] ?></strong></li>
                    </ul>
                </div>
                <?php } ?>
                <div class="col-md-4">
                    <p>Thông tin chi phí</p>
                    <h5 class="list-title"><?= $_GET['adt'] ?> người lớn <?= $_GET['chd'] ?> trẻ em <?= $_GET['inf'] ?> sơ sinh</h5>
                    <ul class="list">
                        <li>Người lớn: <strong><?= price_dot($in['fares']['adt_base_price1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li>
                        <?php if($_GET['chd'] != 0) { ?><li>Trẻ em: <strong><?= price_dot($in['fares']['chd_base_price1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                        <?php if($_GET['inf'] != 0) { ?><li>Sơ sinh: <strong><?= price_dot($in['fares']['inf_base_price1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                        <li>Thuế phí người lớn: <strong><?= price_dot($in['fares']['adt_tax_fee1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li>
                        <?php if($_GET['chd'] != 0) { ?><li>Thuế phí trẻ em: <strong><?= price_dot($in['fares']['chd_tax_fee1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                        <?php if($_GET['inf'] != 0) { ?><li>Thuế phí sơ sinh: <strong><?= price_dot($in['fares']['inf_tax_fee1'])?></strong> x <strong><?= $_GET['adt'] ?></strong></li><?php }?>
                    </ul>
                    <p>Tổng cộng: <strong><?= price_dot($in['fares']['total_amount'])?></strong></p>
                </div>
            </div>
        </div>
    </div>
</li>
</div>
<?php } ?>
<?php } ?>