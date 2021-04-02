<?php
/**
 * Template Name: RS Inter
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

//if($_POST["enCode"] && $_SESSION["SSID"][$sessionid] && $refer == $domain){
	    
    $s=$_SESSION["SSID"][$sessionid]["s"];
	session_write_close();
	
    $direction=(int)$s['way_flight'];
    $dep=$s['source'];
    $des=$s['destination'];
    $depdate=$s['depart'];
    $retdate=$s['return'];
    $adult=(int)$s['adult'];
    $child=(int)$s['children'];
    $infant=(int)$s['infant'];
	$triptype=($direction==0?'ROUND_TRIP':'ONE_WAY');
	$total_paxs = $adult+$child+$infant;
  	
	$pax = $adult.' người lớn';
	if($child>0)
		$pax .= ', '.$child.' trẻ em';
	if($infant>0)
		$pax .= ', '.$infant.' em bé';
	
    $res = get_flight_inter_from_ws($dep,$des,$depdate,$retdate,$adult,$child,$infant,$triptype);
	
	if(isset($res) && $res['code'] == 1){
		
		$flights = $res['data'];
		$source_ia = getCityName($dep);
    	$destination_ia = getCityName($des); 
		$inter_airlines = '';
		
		foreach($res['all_airlines'] as $airline){
			$inter_airlines .= '<tr><td><label class="airname radio" for="rblAirline_'.$airline['code'].'"><input class="airname" type="radio" value="'.$airline['code'].'" name="rblAirline" id="rblAirline_'.$airline['code'].'"><span class="outer"><span class="inner"></span></span> &nbsp;'.wp_trim_words($airline['name'], 3, '...').'</label></td><td><img class="airlogo" alt="'.$airline['code'].'" src="'.interimgdir.'/'.$airline['code'].'.png" alt="'.$airline['code'].'"></td></tr>';
		}
	?>
    
	<script type="text/javascript">
		$(function(){
			$('#inter-airlines').append('<?php echo $inter_airlines; ?>');
		});
	</script>
    
    <!--Thong Tin Chung-->
    <div class="sinfo">
        <p class="location">
            <span class="fontplace"><?php echo $source_ia; ?></span> <span class="separator"></span> <span class="fontplace"><?php echo $destination_ia; ?></span>
        </p>
        <table class="info">
            <tbody>
                <tr>
                    <td><span>Loại vé : </span><strong><?php echo($direction == 0 ? 'Khứ hồi' : 'Một chiều'); ?></strong></td>
                    <td><span>Hành khách: </span> <strong><?php echo $pax; ?></strong></td>
                </tr>
                <tr>
                    <td><span class="indate">Ngày đi : <strong><?php echo $depdate; ?></strong></span></td>
                    <td><span class="indate"><?php echo($direction == 0 ? 'Ngày về : <strong>'.$retdate.'</strong>' : ''); ?></span></td>
                </tr>
        	</tbody>
        </table>
    </div>
    
    <?php
		 
			$index = 0;
			$exchange_rate = (int)get_option("opt_exchange_rate");
			$exchange_rate = (!$exchange_rate || $exchange_rate <= 0) ? 1 : $exchange_rate;
			$eur_exchange_rate = (int)get_option("opt_eur_exchange_rate");
			$eur_exchange_rate = (!$eur_exchange_rate || $eur_exchange_rate <= 0) ? 1 : $eur_exchange_rate;
			
			foreach($flights as $flight){
				// avg taxes
				$taxes = ($flight['taxes'] * $exchange_rate) / ($adult + $child); // thuế trung bình
				// adult
				$price_adult = ($adult > 0 ? ($flight['price_adult'] / $adult) : 0) * $exchange_rate;
				$tax_adult = $taxes + (int)get_option("opt_inter_adt_svfee");
				$amount_adult = ($price_adult + $tax_adult) * $adult;
				// child
				$price_child = ($child > 0 ? ($flight['price_child'] / $child) : 0) * $exchange_rate;
				$tax_child = $taxes + (int)get_option("opt_inter_chd_svfee");
				$amount_child = ($price_child + $tax_child) * $child;
				// infant
				$price_infant = ($infant > 0 ? ($$flight['price_infant'] / $infant) : 0) * $exchange_rate;
				$tax_infant = (int)get_option("opt_inter_inf_svfee");
				$amount_infant = ($price_infant + $tax_infant) * $infant;
				// total
				$total_amount = $amount_adult + $amount_child + $amount_infant;
				$total_tax = ($tax_adult * $adult) + ($tax_child * $child) + ($tax_infant * $infant);
				$total_amount_notax = $total_amount - $total_tax;
				// base price
				$vnd_base_price_no_tax = $price_adult;
				$vnd_base_price_incl_tax = $total_amount / $total_paxs;
				$usd_base_price_no_tax = round(($vnd_base_price_no_tax / $exchange_rate), 2);
				$usd_base_price_incl_tax = round(($total_amount / $exchange_rate / $total_paxs), 2);
				$eur_base_price_no_tax = round(($vnd_base_price_no_tax / $eur_exchange_rate), 2);
				$eur_base_price_incl_tax = round(($total_amount / $eur_exchange_rate / $total_paxs), 2);
				
				//1108 nhi bo sung chi tiet gia//
				$vnd_price_adult = $price_adult;
				$usd_price_adult = $price_adult  / $exchange_rate;
				$eur_price_adult = $price_adult  / $eur_exchange_rate;
				
				$vnd_tax_adult = $tax_adult;
				$usd_tax_adult = $tax_adult  / $exchange_rate;
				$eur_tax_adult = $tax_adult  / $eur_exchange_rate;
				
				$vnd_amount_adult = $amount_adult;
				$usd_amount_adult = $amount_adult / $exchange_rate;
				$eur_amount_adult = $amount_adult / $eur_exchange_rate;
				
				//children
				$vnd_price_child = $price_child;
				$usd_price_child = $price_child  / $exchange_rate;
				$eur_price_child = $price_child  / $eur_exchange_rate;

				$vnd_tax_child = $tax_child;
				$usd_tax_child = $tax_child  / $exchange_rate;
				$eur_tax_child = $tax_child  / $eur_exchange_rate;

				$vnd_amount_child = $amount_child;
				$usd_amount_child = $amount_child / $exchange_rate;
				$eur_amount_child = $amount_child / $eur_exchange_rate;
				//infant
				$vnd_price_infant = $price_infant;
				$usd_price_infant = $price_infant  / $exchange_rate;
				$eur_price_infant = $price_infant  / $eur_exchange_rate;

				$vnd_tax_infant = $tax_infant;
				$usd_tax_infant = $tax_infant  / $exchange_rate;
				$eur_tax_infant = $tax_infant  / $eur_exchange_rate;

				$vnd_amount_infant = $amount_infant;
				$usd_amount_infant = $amount_infant / $exchange_rate;
				$eur_amount_infant = $amount_infant / $eur_exchange_rate;
				
				$vnd_total_amount = $total_amount;
				$usd_total_amount = $total_amount / $exchange_rate;
				$eur_total_amount = $total_amount / $eur_exchange_rate;
				//end nhi 1108//
				
				// save to session
				$crkey="inter".time().$index;
				@session_start();					
				$_SESSION['result_inter'][$crkey]=$flight;
				session_write_close();
				
	?>
    <form action="<?php echo _page("passenger")?>" method="post" name="frmSelectFlight">
		 <section class="inter-fl-block" stop="<?php echo strtolower($flight['outbound_stop']); ?><?php echo ($direction == 0 ? '|'.strtolower($flight['inbound_stop']) : ''); ?>">
          <div class="card-body">
		    <div class="card-head hidden-xs">
				<div class="route-and-dates">
					<span class="routes-depart col-xs-5">Chiều đi</span> 
					<?php if($direction==0){ ?>	
						<span class="routes-return col-xs-5">Chiều về</span> 
					<?php }else{?>
					<span class="routes-return col-xs-5"></span> 
					<?php } ?>					
				<span class=class="col-xs-2">Giá cơ bản</span>
				</div>
            </div>
            <div class="card-main">
			<?php if($direction==0){ ?>	
				<div class="col-md-10 col-xs-12"><div class="row">	
				<div class="outbound-segment col-sm-6  col-xs-12">			
				<strong class="visible-xs">Chiều đi</strong>
				<?php
				foreach($flight['outbound_aircode'] as $aircode){
				?>
					<img align="absmiddle" src="<?php echo interimgdir; ?>/<?php echo $aircode['code']; ?>.png" alt="<?php echo $aircode['code']; ?>" /> 
					<span class="airline-name <?php echo $aircode['code']; ?>"><?php echo $aircode['name']; ?></span><br>
				<?php }?> 
				<span class="stops"><?php echo str_replace(array('direct','stop'),array('Trực tiếp','điểm dừng'),strtolower($flight['outbound_stop'])); ?></span> 
				<span class="duration"><?php echo $flight['outbound_duration']; ?></span>
					
				<span class="travel-summary">
					<span class="travel-time">
						<span class="departure-time"><?php echo date('H:i',strtotime($flight['outbound_deptime'])); ?></span> <i class="fa fa-long-arrow-right"></i> 
						<span class="arrival-time"> <?php echo date('H:i',strtotime($flight['outbound_arvtime'])); ?></span><br>
						 
					</span>
				</span>
				</div>
			   <div class="inbound-segment col-sm-6  col-xs-12">
				<strong class="visible-xs">Chiều về</strong>				
				<?php
					foreach($flight['inbound_aircode'] as $aircode){
					?>
					<img align="absmiddle" src="<?php echo interimgdir; ?>/<?php echo $aircode['code']; ?>.png" alt="<?php echo $aircode['code']; ?>" /> 
					<span class="airline-name <?php echo $aircode['code']; ?>"><?php echo $aircode['name']; ?></span><br>
				<?php }?> 
					<span class="stops"><?php echo str_replace(array('direct','stop'),array('Trực tiếp','điểm dừng'),strtolower($flight['inbound_stop'])); ?></span>
					<span class="duration"><?php echo $flight['inbound_duration']; ?></span>
				
					<span class="travel-summary">
						<span class="travel-time">
							<span class="departure-time"><?php echo date('H:i',strtotime($flight['inbound_deptime'])); ?></span>  <i class="fa fa-long-arrow-right"></i> 
							<span class="arrival-time"> <?php echo date('H:i',strtotime($flight['inbound_arvtime'])) ; ?></span><br>
							 
						</span>
					</span>
             
	
              </div>
			 </div></div>
			 <?php }else{?>
			  <div class="outbound-segment col-md-10  col-xs-12">			
				<div class="row">
					<div class="col-md-6">
					<?php
					foreach($flight['outbound_aircode'] as $aircode){
					?>
						<img align="absmiddle" src="<?php echo interimgdir; ?>/<?php echo $aircode['code']; ?>.png" alt="<?php echo $aircode['code']; ?>" /> 
						<span class="airline-name <?php echo $aircode['code']; ?>"><?php echo $aircode['name']; ?></span><br>
					<?php }?> 
					</div>
					<div class="col-md-6">
					<span class="stops"><?php echo str_replace(array('direct','stop'),array('Trực tiếp','điểm dừng'),strtolower($flight['outbound_stop'])); ?></span>
					<span class="duration"><?php echo $flight['outbound_duration']; ?></span><br>
						
					<span class="travel-summary">
						<span class="travel-time">
							<span class="departure-time"><?php echo date('H:i',strtotime($flight['outbound_deptime'])); ?></span> <i class="fa fa-long-arrow-right"></i>
							<span class="arrival-time"> <?php echo date('H:i',strtotime($flight['outbound_arvtime'])); ?></span><br>
							 
						</span>
					</span>
					</div>
				 </div>
				</div>
			  <?php }?>
              <!--end direction-->
              
			  <div class="route-best-fare booking  col-md-2 col-xs-12">
                <strong class="visible-xs">Giá cơ bản</strong>
				<div class="fare-price price js-fare-price"> 
                
					<span class="rate no-tax" vnd="<?php echo format_number($vnd_base_price_no_tax); ?>|đ" usd="<?php echo format_number($usd_base_price_no_tax); ?>|$" eur="<?php echo format_number($eur_base_price_no_tax); ?>|€"><strong class="amount"><?php echo format_number($vnd_base_price_no_tax); ?></strong> <strong class="currency"><sup>đ</sup></strong></span>
                    
                    <span class="rate incl-tax" style="display:none" vnd="<?php echo format_number($vnd_base_price_incl_tax); ?>|đ" usd="<?php echo format_number($usd_base_price_incl_tax); ?>|$" eur="<?php echo format_number($eur_base_price_incl_tax); ?>|€"><strong class="amount"><?php echo format_number($vnd_base_price_incl_tax); ?></strong> <strong class="currency"><sup>đ</sup></strong></span>
                    
                </div>
				<div class="mb10">	
					<input type="hidden" name="selectflightdep" value="<?php echo $crkey?>" />
                    <input type="submit" name="sm_fselect" value="Tiếp tục" title="Tiếp tục" class="button" />
                </div>   
              </div>
            </div>
            
			
			<div class="card-bottom route-fares-summary hidden-xs">
              <div class="card-show-details js-show-details"> 
              		<a class="fl-view-detail" href="#"><span>Chi tiết</span></a> 
              </div>
            </div>
          </div>
          <div class="card-drawer fl-route-detail  hidden-xs">
            <div class="card-drawer-details">
              <div class="flight-direction-outbound flight-direction flight-legs-1">
                <h4> <strong>Chiều đi</strong></h4>
				<div class="row flight-leg2 fl-header">
                  <div class="fl-flightno col-xs-4">Chuyến bay</div>
                  <div class="fl-from col-xs-4">Từ</div>
                  <div class="fl-to col-xs-4">Đến</div>
                </div>  
				<?php 
					$fn=0;
					foreach($flight['outbound_detail'] as $detail){
						if($detail['type']=='route'){
				?>
				
                <div class="row flight-leg2">
				<div class="fl-flightno  col-xs-4"> 
					<img align="absmiddle" src="<?php echo interimgdir; ?>/<?php echo $detail['aircode']; ?>.png" alt="<?php echo $detail['aircode']; ?>" />
					<p><?php echo $detail['airline']; ?><br />
					(<strong><?php echo $detail['flightno']; ?></strong>)</p>
				</div>                
				<div class="fl-from  col-xs-4"> 
						<strong><?php echo date('H:i',strtotime($detail['deptime'])); ?></strong>, <?php echo date('d/m/Y',strtotime($detail['deptime'])); ?></strong> <br>
							<span class="fl-code"><?php echo $detail['depname'] ; ?></span><br>
						<strong><?php echo $detail['depairport']; ?></strong>
					</div>
                  <div class="fl-to col-xs-4">
						<strong><?php echo date('H:i',strtotime($detail['arvtime'])); ?></strong>, <?php echo date('d/m/Y',strtotime($detail['arvtime'])); ?></strong> <br>
						<span class="fl-code"><?php echo $detail['arvname'] ; ?></span><br>
						<strong><?php echo $detail['arvairport']; ?></strong>
					</div>
				</div>
               <?php 
						$fn++;
						} else {
				?>
				<div class="layover">
					<div>Thay đổi máy bay tại <strong><?php echo $detail['depname']; ?></strong>
					Thời gian giữa các chuyến bay: <strong><?php echo $detail['duration']; ?></strong></div>
				</div>
				<?php
						} // end else
					} // end foreach detail
				?>
			  
			  </div>
            
				<?php 
				if($direction==0){
					?>
			 <div class="flight-direction-inbound flight-direction flight-legs-1">
               <h4> <strong>Chiều về</strong></h4>
				 
                <div class="row flight-leg2 fl-header">
                  <div class="fl-flightno col-xs-4">Chuyến bay</div>
                  <div class="fl-from col-xs-4">Từ</div>
                  <div class="fl-to col-xs-4">Đến</div>
                </div>
                
				<?php 
					$fn=0;
					foreach($flight['inbound_detail'] as $detail){
						if($detail['type']=='route'){
				?>
				<div class="row flight-leg2">
					<div class="fl-flightno  col-xs-4"> 
						<img align="absmiddle" src="<?php echo interimgdir; ?>/<?php echo $detail['aircode']; ?>.png" alt="<?php echo $detail['aircode']; ?>" />
						<p><?php echo $detail['airline']; ?><br />
						(<strong><?php echo $detail['flightno']; ?></strong>)</p>
					</div>
                  <div class="fl-from  col-xs-4"> 
						<strong><?php echo date('H:i',strtotime($detail['deptime'])); ?></strong>, <?php echo date('d/m/Y',strtotime($detail['deptime'])); ?></strong> <br>
							<span class="fl-code"><?php echo $detail['depname'] ; ?></span><br>
						<strong><?php echo $detail['depairport']; ?></strong>
					</div>
                  <div class="fl-to col-xs-4">
						<strong><?php echo date('H:i',strtotime($detail['arvtime'])); ?></strong>, <?php echo date('d/m/Y',strtotime($detail['arvtime'])); ?></strong> <br>
						<span class="fl-code"><?php echo $detail['arvname'] ; ?></span><br>
						<strong><?php echo $detail['arvairport']; ?></strong>
					</div>
				</div>
               <?php 
						$fn++;
						} else {
				?>
				<div class="layover">
					<div>Thay đổi máy bay tại <strong><?php echo $detail['depname']; ?></strong>
					Thời gian giữa các chuyến bay: <strong><?php echo $detail['duration']; ?></strong></div>
				</div>
				<?php
						} // end else
					} // end foreach detail
				?>
			  </div>
            
			</div>
			        <?php
				}// end if direction
			?>
			<!-- PRICE -->
            <table   class="inter-fl-price bg-gray table" cellspacing="0" cellpadding="0" border="0">
            	   
                    	 
                        	<tr>
                            	<th width="20%">Loại hành khách</th>
                                <th width="20%">Số lượng vé</th>
                                <th width="20%">Giá mỗi vé</th>
                                <th width="20%">Thuế & Phí</th>
                                <th width="20%">Tổng giá</th>
                            </tr>
                            <tr>
                            	<td align="center">Người lớn</td>
								<td align="center"><?php echo $adult; ?></td>
                                <td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_price_adult); ?>|đ" usd="<?php echo format_number($usd_price_adult); ?>|$" eur="<?php echo format_number($eur_price_adult); ?>|€"><span class="amount"><?php echo format_number($vnd_price_adult); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_tax_adult); ?>|đ" usd="<?php echo format_number($usd_tax_adult); ?>|$" eur="<?php echo format_number($eur_tax_adult); ?>|€"><span class="amount"><?php echo format_number($vnd_tax_adult); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_amount_adult); ?>|đ" usd="<?php echo format_number($usd_amount_adult); ?>|$" eur="<?php echo format_number($eur_amount_adult); ?>|€"><span class="amount"><?php echo format_number($vnd_amount_adult); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td> 
                            </tr>
                            <?php 
								if($child>0){
									?>
                            <tr>
                            	<td align="center">Trẻ em</td>
								<td align="center"><?php echo $child; ?></td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_price_child); ?>|đ" usd="<?php echo format_number($usd_price_child); ?>|$" eur="<?php echo format_number($eur_price_child); ?>|€"><span class="amount"><?php echo format_number($vnd_price_child); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_tax_child); ?>|đ" usd="<?php echo format_number($usd_tax_child); ?>|$" eur="<?php echo format_number($eur_tax_child); ?>|€"><span class="amount"><?php echo format_number($vnd_tax_child); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_amount_child); ?>|đ" usd="<?php echo format_number($usd_amount_child); ?>|$" eur="<?php echo format_number($eur_amount_child); ?>|€"><span class="amount"><?php echo format_number($vnd_amount_child); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
                            </tr>
                                    <?php
								}
							?>
                            <?php 
								if($infant>0){
									?>
                            <tr>
                            	<td align="center">Em bé</td>
                                <td align="center"><?php echo $infant; ?></td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_price_infant); ?>|đ" usd="<?php echo format_number($usd_price_infant); ?>|$" eur="<?php echo format_number($eur_price_infant); ?>|€"><span class="amount"><?php echo format_number($vnd_price_infant); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_tax_infant); ?>|đ" usd="<?php echo format_number($usd_tax_infant); ?>|$" eur="<?php echo format_number($eur_tax_infant); ?>|€"><span class="amount"><?php echo format_number($vnd_tax_infant); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
								<td align="right">
									<span class="incl-tax"  vnd="<?php echo format_number($vnd_amount_infant); ?>|đ" usd="<?php echo format_number($usd_amount_infant); ?>|$" eur="<?php echo format_number($eur_amount_infant); ?>|€"><span class="amount"><?php echo format_number($vnd_amount_infant); ?></span> <span class="currency"><sup>đ</sup></span></span>
								</td>
                            </tr>
                                    <?php
								}
							?>
                            <tr>
                            	<td colspan="4" align="right"><strong>Tổng giá <?php echo $total_paxs; ?> người</strong></td>
                                <td align="right">
									<strong class="total-amount red-color">
										<span class="rate incl-tax" vnd="<?php echo format_number($vnd_total_amount); ?>|đ" usd="<?php echo format_number($usd_total_amount); ?>|$" eur="<?php echo format_number($eur_total_amount); ?>|€"><strong class="amount"><?php echo format_number($vnd_total_amount); ?></strong> <strong class="currency"><sup>đ</sup></strong></span>
									</strong>
							</td>
                            </tr>
                        
            </table>
        
          </div>
        </section>
       
		<!-- .inter-fl-block -->
        </form>
        <?php
				$index++;
			} // end foreach
			
	} else {
		// NO FLIGHT FOUND
		include_once(TEMPLATEPATH."/tplpart-emptyflight.php");
	}
//}
?>