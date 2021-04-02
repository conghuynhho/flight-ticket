<?php

// Deny all except VN
// $geoip_country_code = getenv(GEOIP_COUNTRY_CODE);
// if($geoip_country_code !== 'VN') exit;
// End deny all except VN

$now = time(); // DDOS
$expired_time = 0; // in seconds
$ran = rand(99, 999999);
$enCode = md5(time() . $ran . "NpTcbCom");
date_default_timezone_set("Asia/Ho_Chi_Minh");
$refer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domain = parse_url(get_bloginfo('url'), PHP_URL_HOST);

//echo 'Hệ thống đang bảo trì, xin vui lòng gọi để được booker phục vụ nhanh chóng : (08) 7300 1886 - 1900 63 6060. Hỗ trợ 24/7 : 0909 58 8080. Hoặc truy cập <a href="http://vietjet.net">vietjet.net</a>';

//if ((isset($_POST['btnsearch'.$_SESSION['fl_btn_search']]) || isset($_POST['btnchdate'.$_SESSION['fl_btn_chdate']]) || isset($_POST['wgbtnsearch'.$_SESSION['fl_wgbtn_search']])) && isset($_POST['dep']) && !isset($_GET["SessionID"]) && $refer == $domain) {
if (isset($_POST[$_SESSION['fl_btn_search']]) && !empty($_POST['dep'])&& !empty($_POST['des'])&& !empty($_POST['depdate'])&& empty($_GET["SessionID"])&& $refer == $domain) {
    $_SESSION["SSID"] = null;
    $_SESSION["search"] = null;
    $_SESSION["card"] = null;
    $_SESSION["result"] = null;
    $_SESSION["result_inter"] = null;
    $_SESSION['booking'] = null;
    $_SESSION['dep'] = null;
    $_SESSION['ret'] = null;
    $_SESSION['contact'] = null;
    $_SESSION['int'] = null;
    $_SESSION['pax'] = null;
    $_SESSION['dep_flight'] = null;
    $_SESSION['ret_flight'] = null;
    $_SESSION['fl_captcha_ok'] = null;
    $_SESSION['fl_req_count'] = null;
    $_SESSION['fl_req_count_allow'] = null;

    unset($_SESSION["SSID"]);
    unset($_SESSION["search"]);
    unset($_SESSION["card"]);
    unset($_SESSION["result"]);
    unset($_SESSION["result_inter"]);
    unset($_SESSION['booking']);
    unset($_SESSION['dep']);
    unset($_SESSION['ret']);
    unset($_SESSION['contact']);
    unset($_SESSION['int']);
    unset($_SESSION['pax']);
    unset($_SESSION['dep_flight']);
    unset($_SESSION['ret_flight']);
    unset($_SESSION['fl_captcha_ok']);
    unset($_SESSION['fl_req_count']);
    unset($_SESSION['fl_req_count_allow']);

    $_SESSION["SSID"]["ID"] = $enCode;
    $_SESSION["SSID"][$enCode]['s'] = array();
    $condition = array(
      'way_flight' => $_POST['direction'],
      'source' => $_POST['dep'],
      'destination' => $_POST['des'],
      'depart' => $_POST['depdate'],
      'return' => $_POST['retdate'],
      'adult' => $_POST['adult'],
      'children' => $_POST['child'],
      'infant' => $_POST['infant']
    );

    $isactive = checkactive($_POST['dep'], $_POST['des']);
    if ($isactive['vj'] || $isactive['vna'] || $isactive['qh']) {
        if ($isactive['vj']) { $condition['active']['vj'] = true; } else { $condition['active']['vj'] = false;}
        if ($isactive['vna']) { $condition['active']['vna'] = true; } else { $condition['active']['vna'] = false;}
        if ($isactive['qh']) { $condition['active']['qh'] = true; } else { $condition['active']['qh'] = false;}
    }

  if (!$GLOBALS['CODECITY'][$condition['source']] || !$GLOBALS['CODECITY'][$condition['destination']]) {
      $condition["isinter"] = true;
  } else {
      $condition["isinter"] = false;
  }

  // Check if inter flight
  if($condition['isinter']){
    $condition['active']['vj'] = true;
    $condition['active']['vna'] = false;
    $condition['active']['qh'] = true;
    $condition['active']['sabre'] = true;
  }

  $expsearch = getexpsearch($condition["depart"]) + $expired_time;
  $_SESSION["SSID"][$enCode]['s'] = $condition;
  $_SESSION["SSID"][$enCode]['s']['exp'] = $expsearch; // SessionID expired
  $_SESSION["search"] = $condition;

  //cached it
  /*S query file*/
  $file = dirname(__FILE__) . "/flight_config/squery.json";
  $json = json_decode(file_get_contents($file), true);
  $exp = $expsearch;
  if ($json == null || empty($json)) {
      $squery = array();
      $squery[$enCode] = array();
      $squery[$enCode] = $condition;
      $squery[$enCode]["exp"] = $exp;
      file_put_contents($file, json_encode($squery));
  } else {
      $json[$enCode] = $condition;
      $json[$enCode]["exp"] = $exp;
      file_put_contents($file, json_encode($json));
  }

  header("Location: " . _page("flightresult") . "?SessionID=" . $enCode);
  exit;

  //} elseif (isset($_GET["SessionID"]) && !isset($_POST['btnsearch5']) && !isset($_POST['btnchangedate']) && !isset($_POST['wgbtnsearch5']) && !isset($_POST['dep']) && !isset($_POST['sm_request'])) {
} 
elseif (isset($_GET["SessionID"]) && !isset($_POST['dep']) && !isset($_POST['sm_request'])) {
  $crssid = clearvar(trim($_GET["SessionID"]));
  $condition = array();
  if ($_SESSION["SSID"][$crssid]) {
      $condition = array(
        'way_flight' => $_SESSION['search']['way_flight'],
        'source' => $_SESSION['search']['source'],
        'destination' => $_SESSION['search']['destination'],
        'depart' => $_SESSION['search']['depart'],
        'return' => $_SESSION['search']['return'],
        'adult' => $_SESSION['search']['adult'],
        'children' => $_SESSION['search']['children'],
        'infant' => $_SESSION['search']['infant'],
        'isinter' => $_SESSION['search']['isinter'],
        'active'    => $_SESSION['search']['active']
      );

      // DDOS
      $exp = $_SESSION["SSID"][$crssid]["s"]["exp"];
      $diff = $now - $exp;
      if ($expired_time > 0 && $diff > $expired_time) {
        header("Location: " . get_bloginfo("url"));
        exit;
      }
  } else {
      $file = dirname(__FILE__) . "/flight_config/squery.json";
      $squery = json_decode(file_get_contents($file), true);
      if (empty($squery[$crssid])) {
        header("Location: " . get_bloginfo("url"));
        exit;
      } else {
        $condition = $squery[$crssid];
        $_SESSION["SSID"]["ID"] = $crssid;
        $_SESSION["SSID"][$crssid]['s'] = $condition;
        $_SESSION["search"] = $condition;

        // DDOS
        $exp = $condition["exp"];
        $diff = $now - $exp;
        if ($expired_time > 0 && $diff > $expired_time) {
          header("Location: " . get_bloginfo("url"));
          exit;
        }
      }
  }

  $direction = $condition['way_flight'];
  $source = $condition['source'];
  $destination = $condition['destination'];
  $source_ia = getCityName($condition['source']);
	$destination_ia = getCityName($condition['destination']);
  $direction_fulltext = ($condition['way_flight'] == 1) ? "Một chiều" : "Khứ hồi";
  $adults = $condition['adult'];
  $depart_fulltext = $condition['depart'];
  $returndate_fulltext = $condition['return'];
  $child = $condition['children'];
  $infant = $condition['infant'];
  $passfulltext = $adults . " người lớn";
  $passfulltext .= ($child != 0) ? ", " . $child . " Trẻ em" : "";
  $passfulltext .= ($infant != 0) ? ", " . $infant . " Trẻ sơ sinh" : "";
  $countactive = (($condition['active']['vna']) ? 1 : 0) + (($condition['active']['vj']) ? 1 : 0) + (($condition['active']['js']) ? 1 : 0) + (($condition['active']['qh']) ? 1 : 0) + (($condition['active']['sabre']) ? 1 : 0);
  $arrlinkrs = array();
  if ($condition['active']['vna']) {$arrlinkrs[] = _page('vnalink');}
  if ($condition['active']['vj']) {$arrlinkrs[] = _page('vjlink');}
  if ($condition['active']['qh']) {$arrlinkrs[] = _page('qhlink');}
  if($condition['active']['sabre']) $arrlinkrs[]=_page('sabrelink');

  // Gen token
  if (empty($_SESSION['fl_token'])) {
    $_SESSION['fl_token'] = gen_random_string(rand(9, 18));
  }

  // Reset request count
  $_SESSION['fl_req_count'] = null;
  $_SESSION['fl_req_count_allow'] = null;
  unset($_SESSION['fl_req_count']);
  unset($_SESSION['fl_req_count_allow']);
} else {
  // wp_redirect(get_bloginfo('url'));
  exit;
}

// BEGIN LOG CLIENT REQUEST
$ip_address = get_ip_address_from_client();
$domain = preg_replace('(^https?://)', '', get_bloginfo('url'));
$req_content = $condition['way_flight'] . $condition['source'] . $condition['destination'] . $condition['depart'] . $condition['return'] . $condition['adult'] . $condition['children'] . $condition['infant'];
$req_content = preg_replace('/[^a-zA-Z0-9]/', '', $req_content);
log_client_request($domain, $ip_address, $req_content);
// END LOG CLIENT REQUEST
get_header();
?>

<div class="row" id="colLeftNoBorder">
  <div class="block">
    <?php
    if ($condition) {
      // BEGIN CHECK CLIENT REQUEST
      $req_count_allow = 29;
      $req_time_allow = 1800; // in seconds
      $req_count = (int) check_client_request($domain, $ip_address, $req_time_allow);
      $_SESSION['fl_req_count'] = $req_count;
      $_SESSION['fl_req_count_allow'] = $req_count_allow;
      $geoip_country_code = getenv(GEOIP_COUNTRY_CODE);

      //if(!$ip_address || strtoupper($ip_address) == 'UNKNOWN' || ($geoip_country_code !== 'VN' && !$_SESSION['fl_captcha_ok']) || (checkCIDRBlacklist($ip_address) && !$_SESSION['fl_captcha_ok']) || ($req_count > $req_count_allow && !$_SESSION['fl_captcha_ok'])) {
      if (!$ip_address || strtoupper($ip_address) == 'UNKNOWN' || (checkCIDRBlacklist($ip_address) && !$_SESSION['fl_captcha_ok']) || ($req_count > $req_count_allow && !$_SESSION['fl_captcha_ok'])) {
        $_SESSION['fl_captcha'] = simple_php_captcha(array('characters' => '0123456789'));
        $_SESSION['fl_captcha_ok'] = false;
        include_once(TEMPLATEPATH . "/tplpart-captchaform.php");
      } else {

        /*Neu tu search form*/
        ($condition['children'] != 0) ? $qty_children = ', ' . $condition['children'] . ' Trẻ em' : $qty_children = '';
        ($condition['infant'] != 0) ? $qty_infants = ', ' . $condition['infant'] . ' Trẻ sơ sinh' : $qty_infants = '';

        if ($condition['way_flight'] == 0 && $condition['return'] != '') {
          $str_return = 'Ngày về:</td><td><strong>' . $condition['return'] . '</strong>';
        } else {
          $str_return = '</td><td>';
        }

        # KIỂM TRA NẾU LÀ CHUYẾN NỘI ĐỊA
        // if (!$condition["isinter"]) {
          if(!$condition["isinter"]) {
            $waiting_notices = '<div class="row"><div class="col-md-8 col-md-offset-2 col-sm-12 waiting_block" style="margin: 20px;"><h2><span class="fontplace">' . $GLOBALS['CODECITY'][$condition['source']] . '</span> <i class="fa fa-long-arrow-right"></i> <span class="fontplace">' . $GLOBALS['CODECITY'][$condition['destination']] . '</span></h2><table><tr><td style="padding-left: 0px;">Loại vé:</td><td><strong>' . $GLOBALS['way_flight_list'][$condition['way_flight']] . '</strong></td><td>Số khách:</td><td><strong>' . $condition['adult'] . ' người lớn' . $qty_children . $qty_infants . '</strong></td></tr><tr><td style="padding-left: 0px;">Ngày đi:</td><td><strong>' . $condition['depart'] . '</strong></td><td>' . $str_return . '</td></tr></table><p class="notice-waiting">Mời bạn vui lòng chờ trong giây lát ...</p></div></div>';
          }else {
            $waiting_notices = '<div class="row"><div class="col-md-8 col-md-offset-2 col-sm-12 waiting_block"><h2><span class="fontplace">'.$source_ia.'</span> <i class="fa fa-long-arrow-right"></i> <span class="fontplace">'.$destination_ia.'</span></h2><table><tr><td>Loại vé:</td><td><strong>'.$GLOBALS['way_flight_list'][$condition['way_flight']].'</strong></td><td>Số khách:</td><td><strong>'.$adults.' người lớn'.$qty_children.$qty_infants.'</strong></td></tr><tr><td>Ngày đi:</td><td><strong>'.$condition['depart'].'</strong></td><td>'.$str_return.'</td></tr></table><p class="notice-waiting">Mời bạn vui lòng chờ trong giây lát ...</p></div></div>';
          }
          
          if(!$condition['active']['vna'] 
            && !$condition['active']['vj'] 
            && !$condition['active']['qh'] 
            && !$condition['active']['sabre']){ /*Neu duong bay ko co tuyen nay*/
            $isempty_flight=true; 
        }else{
            ?>
            <script type="text/javascript">
              var SessionID = '<?php echo $crssid ?>';
              var Direction = <?php echo $direction ?>;
              var DirectionText = '<?php echo $direction_fulltext ?>';
              var Source = '<?php echo $source ?>';
              var Destination = '<?php echo $destination ?>';
              var checkInter = <?php echo ($condition['isinter'] ? 1 : 0); ?>;
              if(checkInter) {
                var SourceCity='<?=$source_ia?>';
								var DesCity='<?=$destination_ia?>';
              }else {
                var SourceCity = '<?php echo $GLOBALS['CODECITY'][$source] ?>';
                var DesCity = '<?php echo $GLOBALS['CODECITY'][$destination] ?>';
              }
              
              var Departdate = '<?php echo $condition['depart'] ?>';
              var Returndate = '<?php echo $condition['return'] ?>';
              var Adult = <?php echo $adults ?>;
              var Child = <?php echo $child ?>;
              var Infant = <?php echo $infant ?>;
              var PassengerText = '<?php echo $passfulltext ?>';
              var CountActive = <?php echo $countactive ?>;
              var Hotline = '<?php echo  get_option("fl_phone") ?>';
              var Getrs = new Array(<?php echo "'" . implode("','", $arrlinkrs) . "'"; ?>);
              var XhrRequest=new Array();
              var ArrayResult=new Array();

              windowsDefer();

              function windowsDefer() {
                if (window.jQuery){
                  for (var i = 0; i < Getrs.length; i++) {
                    XhrRequest[i] = $.ajax({
                      url: Getrs[i],
                      cache: false,
                      traditional: true,
                      type: "POST",
                      data: "enCode=" + SessionID + "&cache=<?php echo ($_GET["clearcache"]) ? 0 : 1; ?>&<?php echo $_SESSION['fl_token']; ?>=",
                      timeout: 45000,
                      dataType: "html"
                    }).done(function(data) {
                     
                      $(function() {
                                    if (checkInter) {
                                        processResultInter(data);
                                    } else {
                                        processResult(data);
                                    }
                                })
                                            
                    }).error(function() {
                      CountActive--;
                      $(document).ready(function() {
                        if (CountActive == 0 && ArrayResult['count'] == 0) {
                          var emptyhtml = emptyflight();
                          console.log(emptyhtml);
                          $(document).ready(function() {
                            $("#result").html(emptyhtml)
                          });
                        }
                      })
                    })
                  }
                  $(document).ready(function() {
                    $("#loadresultfirst").html('<?php echo $waiting_notices ?>')
                  });
                } else {
                  setTimeout(function() { windowsDefer() }, 50);
                }
              }
              
              
            </script>
          <?php }
                # ELSE LÀ VÉ QUỐC TẾ
              } 
               
      // <?php
      //     }
        //} // END CHECK CLIENT REQUEST
      } // END IF

      elseif (isset($_POST['sm_request'])) { /*######If submit from request form#########*/ ?>
      <?php

        // Everything is ok and you can proceed by executing your login, signup, update etc scripts
        require(TEMPLATEPATH . '/flight_config/sugarrest/sugar_rest.php');
        $sugar = new Sugar_REST();
        $error = $sugar->get_error();
        $arr_req = array(
          'contact_name'   => trim($_POST['fullname']),
          'phone'      => trim($_POST['phone']),
          'request_detail' => $_POST['content_request'],
          'request_type'   => 3,
          'request_status' => 0,
        );
        $req_id = $sugar->set("EC_Request_Flight", $arr_req);

        if ($req_id) {
          ?>
        <div class="emptyflight_block">
          <h3>Yêu cầu của bạn đã được gửi thành công</h3>
          <p>Hệ thống đã nhận được yêu cầu của bạn! Nhân viên chúng tôi sẽ liên hệ lại với bạn trong vòng 5 phút.</p>
          <p>Cần trợ giúp bạn hãy gọi theo số <strong style="font-size:16px;color:#FE5815;"><?php echo  get_option('opt_phone'); ?></strong>.</p>
          <p style="color:#03F"><a href="<?php bloginfo('siteurl'); ?>">&laquo; Trở về trang chủ &raquo;</a></p>
        </div>
      <?php
        } else {
          ?>
        <div class="emptyflight_block">
          <h3>Gửi thất bại!</h3>
          <p>Bạn hãy liên hệ theo số <strong style="font-size:16px;color:#FE5815;"><?php echo  get_option('opt_phone'); ?></strong>, để được trợ giúp</p>
          <p style="color:#03F"><a href="<?php bloginfo('siteurl'); ?>">&laquo; Trở về trang chủ &raquo;</a></p>
        </div>
      <?php
        }
      } else {
        ?>
      <div class="emptyflight_block">
        <h3 class="noinfo">Vui lòng chọn Thông tin tìm kiếm chuyến bay</h3>
      </div>
    <?php
    }
    ?>
    <div id="loadresultfirst"></div>
    <div class="col-md-6 col-md-offset-3 col-sm-12">
      <?php if ($isempty_flight) {
        include_once(TEMPLATEPATH . "/tplpart-emptyflight.php");
      } ?>
    </div>
    <div id="mainDisplay" class="col-md-8 sidebar-separator">
      <div id="result" class="tpl-none-result">
        <form action="<?php echo _page("passenger") ?>" method="post" name="frmSelectFlight" id="frmSelectFlight">
          <!--Thong Tin Chang Di-->
          <?php if($condition["isinter"]) { ?>
              <div class="searchresults">
                <div style="position: relative;" class="lld-result list-search-result">
                  <div class="ftable-extra ftable-extra-int"><h4>Chọn Chuyến bay</h4></div>
                  <!-- ONE-WAYS-->
                  <div class="row sinfo box">
                    <div class="headerBlock col-md-12" style="padding-left: 0px; padding-right: 0px; margin-bottom: 0px; margin-top: 0px;">
                      <div class="headerArea">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="stepHeader stepInstruction">
                              <span class="big big-inter"><?php echo $source_ia . "&nbsp;&nbsp;&nbsp;<i class='fa fa-long-arrow-right'></i>&nbsp;&nbsp;&nbsp;" . $destination_ia ?></span>
                            </div>
                          </div>
                          <div class="col-xs-6" style="padding-left: 0px;">
                            <span style="float:right;text-align:right;" id="date-dep">Ngày: <?php echo $condition['depart']; ?></span>
                          </div>
                        </div>
                      </div>
                      <div class="hidden-xs location contload"></div>
                    </div>
                  </div>
                  <ul id="depDatePicker" class="date-picker hidden-xs" style="display: block;">
                    <?php
                        $arr_depDate = date_of_currentdate($depart_fulltext);
                        $classli = 'class="firstli"';
                        foreach ($arr_depDate as $val) { ?>
                          <li <?php if ($classli != "") { echo $classli; $classli = ""; } ?> <?php if ($val == $depart_fulltext) { echo 'class="active"'; } ?>> <a rel="<?php echo  $val ?>" class="changedepartflight"> <span><?php echo  echoDate($val); ?></span> <span><?php echo  $val ?></span></a></li>
                    <?php } ?>
                  </ul>
                  <!-- END ONE-WAYS -->     
                  <!-- ROUND-TRIP -->
                  <?php if (isset($_SESSION['search']['way_flight']) && $_SESSION['search']['way_flight'] == "0") { ?>
                    <div class="row sinfo box">
                      <div class="headerBlock col-md-12" style=" padding-left: 0px; padding-right: 0px;margin-bottom: 0px;margin-top: 0px;">
                        <div class="headerArea">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="stepHeader stepInstruction">
                                <span class="big big-inter"><?php echo $destination_ia . "  &nbsp;&nbsp;&nbsp;<i class='fa fa-long-arrow-right'></i> &nbsp;&nbsp;&nbsp; " . $source_ia ?></span></div>
                            </div>
                            <div class="col-xs-6" style="padding-left: 0px;">
                              <?php if ($condition['way_flight'] == 0 && $condition['return'] != '') {
                                  echo "<span style='float:right;text-align:right;' id='date-ret'> Ngày: " . $condition['return'] . "</span>";
                                }
                              ?>
                            </div>
                          </div>
                        </div>
                        <div class="hidden-xs location contload"></div>
                      </div>
                    </div>
                    <ul id="desDatePicker" class="date-picker  hidden-xs" style="display: block;">
                      <?php
                          $arr_retDate = date_of_currentdate($returndate_fulltext);
                          $classli = 'class="firstli"';
                          foreach ($arr_retDate as $val) { ?>
                          <li <?php if ($classli != "") { echo $classli; $classli = ""; } ?> <?php if ($val == $returndate_fulltext) { echo 'class="active"'; } ?>> <a rel="<?php echo  $val ?>" class="changereturnflight"> <span><?php echo  echoDate($val); ?></span> <span><?php echo  $val ?></span> </a> </li>
                      <?php } ?>
                    </ul>
                  <?php }?>
                  <!-- END ROUND-TRIP -->
                    <?php 
                    if(!$direction) {
                        echo '<table id="tblInterFlightList" class="tablesorter interFlightList searchresults-tbl international lld-searchresults-tbl roundtrip" data-sortlist="[[1,0]]">';
                      }
                      else {
                        echo '<table id="tblInterFlightList" class="tablesorter interFlightList searchresults-tbl international lld-searchresults-tbl oneways" data-sortlist="[[1,0]]">';
                      }
                    ?>
                    <thead>
                      <tr style="height: 40px" class="lld-icon-result">
                          <th width="10%">Hãng bay</th>
                          <th width="20%" class="header headersortdown">Giá vé</th>
                          <th width="15%">Hành trình</th>
                          <th width="18%">Giờ bay</th>
                          <th width="12%">Thời lượng</th>
                          <th width="15%">Điểm dừng</th>
                          <th width="10%">Chi tiết</th>
                      </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                  </div>
                </div>
          <?php } else { ?>
          <div class="row sinfo box">
            <div class="headerBlock col-md-12" style="padding-left: 0px; padding-right: 0px; margin-bottom: 0px; margin-top: 0px;">
              <div class="headerArea">
                <div class="row">
                  <div class="col-md-6">
                    <div class="stepHeader stepNumber">
                      <div class="roundNumber">
                        <div class="stepNumberValue">1</div>
                      </div>
                    </div>
                    <div class="stepHeader stepInstruction">
                      <span class="big"><?php echo $GLOBALS['CODECITY'][$source] . "&nbsp;&nbsp;&nbsp;<i class='fa fa-long-arrow-right'></i>&nbsp;&nbsp;&nbsp;" . $GLOBALS['CODECITY'][$destination] ?></span>
                    </div>
                  </div>
                  <div class="col-xs-6" style="padding-left: 0px;">
                    <span style="float:right;text-align:right;" id="date-dep">Ngày: <?php echo $condition['depart']; ?></span>
                  </div>
                </div>
              </div>
              <div class="hidden-xs location contload"></div>
            </div>
          </div>
          <ul id="depDatePicker" class="date-picker hidden-xs" style="display: block;">
            <?php
                $arr_depDate = date_of_currentdate($depart_fulltext);
                $classli = 'class="firstli"';
                foreach ($arr_depDate as $val) { ?>
                  <li <?php if ($classli != "") { echo $classli; $classli = ""; } ?> <?php if ($val == $depart_fulltext) { echo 'class="active"'; } ?>> <a rel="<?php echo  $val ?>" class="changedepartflight"> <span><?php echo  echoDate($val); ?></span> <span><?php echo  $val ?></span></a></li>
            <?php } ?>
          </ul>
          <table class="table flightlist" border="0" id="OutBound">
            <thead>
              <tr>
                <th class="type-string sortairport col-md-3  col-sm-3 col-xs-3"> <span><i class="fa fa-plane"></i></span> <span class="hidden-xs">Chuyến bay </span> </th>
                <th class="type-string sorttime col-md-2  col-sm-2 col-xs-2" style="text-align:center"> <span><i class="fa fa-clock-o"></i></span> <span class="hidden-xs">Khởi hành </span> </th>
                <th class="type-string sorttime col-md-2  col-sm-2 col-xs-2 visible-xs" style="text-align:center"> <span class="hidden-xs"></span> </th>
                <th class="type-string sorttime col-md-2  col-sm-2" style="text-align:center"> <span><i class="fa fa-clock-o"></i></span> <span class="hidden-xs">Đến </span> </th>
                <th class="type-string sortprice col-md-3  col-sm-3 col-xs-4" style="text-align:center;"> <span><i class="fa fa-ticket"></i></span> <span class="hidden-xs">Giá vé </span> </th>
                <th align="center" class="col-md-2 col-sm-2 col-xs-1"> <span><i class="fa fa-angle-double-down"></i></span> <span class="hidden-xs">Xem</span> </th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <?php if (isset($_SESSION['search']['way_flight']) && $_SESSION['search']['way_flight'] == "0") { ?>
            <!--Thong Tin Chang Di-->
            <div class="row sinfo box">
              <div class="headerBlock col-md-12" style=" padding-left: 0px; padding-right: 0px;margin-bottom: 0px;margin-top: 0px;">
                <div class="headerArea">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="stepHeader stepNumber">
                        <div class="roundNumber">
                          <div class="stepNumberValue">2</div>
                        </div>
                      </div>
                      <div class="stepHeader stepInstruction">
                        <span class="big"><?php echo $GLOBALS['CODECITY'][$destination] . "  &nbsp;&nbsp;&nbsp;<i class='fa fa-long-arrow-right'></i> &nbsp;&nbsp;&nbsp; " .  $GLOBALS['CODECITY'][$source] ?></span></div>
                    </div>
                    <div class="col-xs-6" style="padding-left: 0px;">
                      <?php if ($condition['way_flight'] == 0 && $condition['return'] != '') {
                          echo "<span style='float:right;text-align:right;' id='date-ret'> Ngày: " . $condition['return'] . "</span>";
                        }
                      ?>
                    </div>
                  </div>
                </div>
                <div class="hidden-xs location contload"></div>
              </div>
            </div>
            <ul id="desDatePicker" class="date-picker  hidden-xs" style="display: block;">
              <?php
                  $arr_retDate = date_of_currentdate($returndate_fulltext);
                  $classli = 'class="firstli"';
                  foreach ($arr_retDate as $val) { ?>
                  <li <?php if ($classli != "") { echo $classli; $classli = ""; } ?> <?php if ($val == $returndate_fulltext) { echo 'class="active"'; } ?>> <a rel="<?php echo  $val ?>" class="changereturnflight"> <span><?php echo  echoDate($val); ?></span> <span><?php echo  $val ?></span> </a> </li>
              <?php } ?>
            </ul>
            <table class="table flightlist" border="0" id="InBound">
              <thead>
                <tr>
                  <th class="type-string sortairport col-md-3 col-sm-3 col-xs-3"> <span><i class="fa fa-plane"></i></span> <span class="hidden-xs">Chuyến bay </span> </th>
                  <th class="type-string sorttime col-md-2  col-sm-2 col-xs-2" style="text-align:center"> <span><i class="fa fa-clock-o"></i></span> <span class="hidden-xs">Khởi hành </span> </th>
                  <th class="type-string sorttime col-md-2  col-sm-2" style="text-align:center"> <span><i class="fa fa-clock-o"></i></span> <span class="hidden-xs">Đến </span> </th>
                  <th class="type-string sortprice col-md-3  col-sm-3 col-xs-4" style="text-align:center;"> <span><i class="fa fa-ticket"></i></span> <span class="hidden-xs">Giá vé</span> </th>
                  <th align="center" class="col-md-2 col-sm-2 col-xs-1"> <span><i class="fa fa-angle-double-down"></i></span> <span class="hidden-xs">Xem</span> </th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          <?php } ?>
          <div class="clearfix"></div>
          <?php } ?>
        </form>
        <form class="search-flight-form" name="changedate" method="post" action="<?php echo  _page("flightresult") ?>" style="display: none;" id="frmchangedate"></form>
      </div>
    </div>
    <div class="col-md-4">
      <?php get_sidebar(); ?>
    </div>
    <!--#ctright-->

  </div>
</div>
<!-- #colLeftNoBorder -->
<div id="req-select"></div>

<?php
get_footer();
?>
