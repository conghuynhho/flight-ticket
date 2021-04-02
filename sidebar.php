<?php
    /**
     * Created by Notepad.
     * User: Lak
     * Date: 11/12/13
     */
?>
<?php
    if(is_single()){
      global $wp_query;
      // $dep_code = get_post_meta( $post->ID, $prefix.'arv_code', true );
      $postid = $wp_query->post->ID;
      $dep_code = get_post_meta($postid, 'fl_dep_code', true);
      $arv_code = get_post_meta($postid, 'fl_arv_code', true);
      wp_reset_query();
     
    }
    //

?>
<div class="panel-group" id="accordion">
    <div  id="wgbox">
        <div class="panel">
            <div class="heading-search mb10">
                <div class="heading-title"><a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSearch">Tìm kiếm mới </a></div>
            </div>
            <div  id="collapseSearch"  class="panel-collapse collapse in">
                <div class="wg-search">
                    <div class="tab-content">
                        <div class="tab-pane fade no-padding active in" id="wgflighttab">
                            <div class="mb10" id="wgsform">
                                <form class="search-flight-form" action="<?= _page("flightresult") ?>" method="post" id="frmwgsearch">
                                    <?php if(isset($arv_code) && !empty($arv_code)){ ?>
                                    <div class="row" style="padding-left: 10px;">
                                        <h2>Vé máy bay đi <?php echo $GLOBALS['CODECITY'][$arv_code]; ?></h2>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="radio">
                                            <input type="radio" class="wgdirection checkbox-custom" name="direction" id="wgoneway" value="1" <?php echo (!$_SESSION["search"]["way_flight"] || $_SESSION["search"]["way_flight"] == "1") ? "checked='checked'" : ""; ?> />
                                            <span class="outer"><span class="inner"></span></span>Một chiều </label>
                                            </label>
                                            <label class="radio">
                                            <input type="radio" class="wgdirection checkbox-custom" name="direction" id="wgroundtrip" value="0"   <?php echo ($_SESSION["search"]["way_flight"] == "0") ? "checked='checked'" : ""; ?>/>
                                            <span class="outer"><span class="inner"></span></span>Khứ hồi </label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <?php
                                                $crsource=(isset($dep_code) && !empty($dep_code)) ? $dep_code : (isset($_SESSION["search"]["source"]) && !empty($_SESSION["search"]["source"]) ? $_SESSION["search"]["source"] : 'SGN');
                                                $crdestination=(isset($arv_code) && !empty($arv_code)) ? $arv_code : (isset($_SESSION["search"]["destination"]) && !empty($_SESSION["search"]["destination"]) ? $_SESSION["search"]["destination"] : 'HAN');
                                                $crdepdate=isset($arv_code) && !empty($arv_code) ? date('d/m/Y', time() + 259200) : (isset($_SESSION["search"]["depart"]) ? $_SESSION["search"]["depart"] : date('d/m/Y', time() + 259200));
                                                $crretdate=($_SESSION["search"]["return"])?$_SESSION["search"]["return"]:"--/--/----";
                                                $cradult=($_SESSION["search"]["adult"])?$_SESSION["search"]["adult"]:1;
                                                $crchild=($_SESSION["search"]["children"])?$_SESSION["search"]["children"]:0;
                                                $crinfant=($_SESSION["search"]["infant"])?$_SESSION["search"]["infant"]:0;
                                                
                                                $deptime_tmp=date("d/m/Y",time()+(60*60*(48+24)));
                                                $maxtime_tmp=date("d/m/Y",time()+(60*60*(8760)));
                                                $crrttime_tmp=date("d/m/Y",time());
                                                ?>
                                            <label>Nơi đi</label>
                                            <select name="dep" id="wgdep" class="form-control inputTxtLarge">
                                                <?php echo getAirportGroup($crsource, 'FULL_'); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="padding-top-sidebar">Nơi đến</label>
                                            <select name="des" id="wgdes" class="form-control inputTxtLarge">
                                                <?php echo getAirportGroup($crdestination, 'FULL_'); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="padding-top-sidebar">Ngày đi</label>
                                            <div class="datepicker-wrap inner-addon left-addon">
                                                <i class="icon-calendar1 ico22 widgetCalIcon " style="top:10px"></i>
                                                <input type="text" class="dates form-control inputTxtLarge" data-next="#wgretdate" after_function="change_start_date" minDate="<?= $crrttime_tmp?>" maxdate="<?=$maxtime_tmp?>"  default_max_date="<?=$maxtime_tmp?>" default="<?=$crdepdate?>" value="<?= $crdepdate?>"  name="depdate" id="wgdepdate"   autocomplete="off" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="padding-top-sidebar">Ngày về</label>
                                            <div class="datepicker-wrap inner-addon left-addon">
                                                <i class="icon-calendar1 ico22 widgetCalIcon " style="top:10px"></i>
                                                <input type="text" class="dates form-control inputTxtLarge" after_function="change_return_date" minDate="<?= $deptime_tmp?>" maxdate="<?=$maxtime_tmp?>"  default="<?=$crretdate?>" value="<?=$crretdate?>"   name="retdate" id="wgretdate"   autocomplete="off" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row tcb-wgquantity">
                                        <div class="col-md-4 col-md-4 col-sm-4 col-xs-4 wgquantity">
                                            <label for="wgadult" class="padding-top-sidebar">Người lớn</label>
                                            <select id="wgadult" name="adult" class="form-control inputTxtLarge">
                                                <?php for($i=1;$i<=30;$i++): ?>
                                                <option value="<?=$i?>" <?=($cradult==$i)?"selected='selected'":""; ?> >
                                                    <?=$i?>
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-md-4 col-sm-4 col-xs-4 wgquantity">
                                            <label for="wgchild" class="padding-top-sidebar">Trẻ em</label>
                                            <select id="wgchild" name="child" class="form-control inputTxtLarge">
                                                <?php for($i=0;$i<=5;$i++): ?>
                                                <option value="<?=$i?>" <?=($crchild==$i)?"selected='selected'":""; ?> >
                                                    <?=$i?>
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <!--fqtity-->
                                        <div class="col-md-4 col-md-4 col-sm-4 col-xs-4 wgquantity">
                                            <label for="wginfant" class="padding-top-sidebar">Em bé</label>
                                            <select id="wginfant" name="infant" class="form-control inputTxtLarge">
                                                <?php for($i=0;$i<=5;$i++): ?>
                                                <option value="<?=$i?>" <?=($crinfant==$i)?"selected='selected'":""; ?> >
                                                    <?=$i?>
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button class="button x-large pull-right config-button-search" type="submit" style="width:100%;margin-top:10px" name="wgbtnsearch" id="wgbtnsearch">Tìm chuyến bay</button>
                                            
                                        </div>
                                    </div>
                                </form>
                                <!--#frmwgsearch--> 
                            </div>
                        </div>
                    </div>
                </div>
                <!--wg-search--> 
            </div>
        </div>
        <!--panel-->
        <?php if(is_page("chon-hanh-trinh") && !$_SESSION['search']['isinter']): ?>
        <div class="box margin-box-filter-flight hidden-xs" id="flightsort">
            <div class="heading-with-icon">
                <div class="heading-link"> <a href="#" data-role="clear-all-filters-link" class="filters-container-clear-all-selected-filters" style="display: none;"> Clear all </a> </div>
                <div class="heading-icon"><i class="icons-sprite icons-magic_wand_encircled"></i></div>
                <div class="heading-title">Điều kiện</div>
            </div>
            <form id="frmsoftflight">
                <div class="panel">
                    <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Sắp xếp</a></p>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <ul>
                            <li>
                                <label for="byairline" class="radio radio-inline">
                                <input type="radio" name="rdsort" class="rdsort " value="airline" id="byairline" checked="checked" />
                                <span class="outer"><span class="inner"></span></span>Hãng hàng không</label>
                            </li>
                            <li>
                                <label for="byprice" class="radio radio-inline">
                                <input type="radio" name="rdsort" class="rdsort" value="price" id="byprice" />
                                <span class="outer"><span class="inner"></span></span>Giá từ thấp tới cao</label>
                            </li>
                            <li>
                                <label for="bytime" class="radio radio-inline">
                                <input type="radio" name="rdsort" class="rdsort" value="time" id="bytime" />
                                <span class="outer"><span class="inner"></span></span>Thời gian khởi hành</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--.panel.panel-default-->
            </form>
        </div>
        <!--#flightsort-->
        <div class="box hidden-xs" id="filterflight">
            <form id="frmfilterflight">
                <div class="panel">
                    <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse2">Lọc theo hãng</a></p>
                    <div id="collapse2" class="panel-collapse collapse in">
                        <ul>
                            <li class="checked">
                                <label for="filterall">
                                <input type="checkbox" name="ckfilter" class="flightfilter checkbox" value="all" id="filterall" checked="checked" />
                                Tất cả</label>
                            </li>
                            <li class="vna al checked">
                                <label for="filtervna">
                                <input type="checkbox" name="ckfilter" class="flightfilter checkbox" value="vna" id="filtervna" checked="checked" />
                                VietNam Airlines</label>
                            </li>
                            <li class="vj al checked">
                                <label for="filtervj">
                                <input type="checkbox" name="ckfilter" class="flightfilter checkbox" value="vj" id="filtervj" checked="checked" />
                                Vietjet Air</label>
                            </li>
                            <li class="js al checked">
                                <label for="filterjs">
                                <input type="checkbox" name="ckfilter" class="flightfilter checkbox" value="js" id="filterjs" checked="checked" />
                                Jetstar</label>
                            </li>
                            <li class="qh al checked">
                                <label for="filterqh">
                                <input type="checkbox" name="ckfilter" class="flightfilter checkbox" value="qh" id="filterqh" checked="checked" />
                                Bamboo Airways</label>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--.panel.panel-default-->
            </form>
        </div>
        <!--#filterflight-->
        <?php endif; ?>
        <?php if(is_page("chon-hanh-trinh") && $_SESSION['search']['isinter']): ?>
        <div class="box hidden-xs">
            <!-- VE QUOC TE -->
            <div id="filter">
                <div class="heading-with-icon">
                    <div class="heading-link"> <a href="#" data-role="clear-all-filters-link" class="filters-container-clear-all-selected-filters" style="display: none;"> Clear all </a> </div>
                    <div class="heading-icon"><i class="icons-sprite icons-magic_wand_encircled"></i></div>
                    <div class="heading-title">Điều kiện lọc</div>
                </div>
                <div class="panel">
                    <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse3">Chế độ hiển thị</a></p>
                    <div id="collapse3" class="panel-collapse collapse in">
                        <div class="borderSort">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="checked"><label  class="radio" for="sort-price">
                                            <input type="radio" name="rblDisplayMode" checked="checked" value="price" id="sort-price">
                                            <span class="outer"><span class="inner"></span></span>Giá từ thấp đến cao</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="checked"><label  class="radio" for="sort-airlines">
                                            <input type="radio" name="rblDisplayMode" value="airlines" id="sort-airlines">
                                            <span class="outer"><span class="inner"></span></span>Hãng hàng không</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End Theo theo gia  co ban-->
                <div class="panel">
                    <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse5">Số trạm chuyển tiếp</a></p>
                    <div id="collapse5" class="panel-collapse collapse in">
                        <div class="borderSort">
                            <table class="theo-hang-bay table">
                                <tbody>
                                    <tr>
                                        <td class="checked"><label class="radio" for="TypeFlight_1">
                                            <input type="radio" value="all" checked="checked" name="rblTypeFlight" id="TypeFlight_1">
                                            <span class="outer"><span class="inner"></span></span>&nbsp;Tất cả</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="radio" for="TypeFlight_2">
                                            <input type="radio" value="0" name="rblTypeFlight" id="TypeFlight_2">
                                            <span class="outer"><span class="inner"></span></span>&nbsp;Bay thẳng</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="radio" for="TypeFlight_3">
                                            <input type="radio" value="1" name="rblTypeFlight" id="TypeFlight_3">
                                            <span class="outer"><span class="inner"></span></span>&nbsp;1 trạm chuyển tiếp</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="radio" for="TypeFlight_4">
                                            <input type="radio" value="2" name="rblTypeFlight" id="TypeFlight_4">
                                            <span class="outer"><span class="inner"></span></span>&nbsp;2 trạm chuyển tiếp</label>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- FILTER DEPARTURE TIME & ARRIVAL TIME -->
                <div class="panel" id="hidden-box-category">
                    <div class="airports-time-flight small-block">
                        <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse5">Giờ cất cánh (chuyến đi)</a></p>
                        <div class="padding-time-flight-sort">
                            <p class="content-font-size">
                                <label for="time-departure">Chuyến đi:</label>
                                <input type="text" id="time-departure" class="border-none bold">
                            </p>
                            <div class="text-center-point-slider">
                                <div id="slider-rangeld" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                    <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 100%;"></a>
                                </div>
                            </div>
                            <div class="rule">
                                <span class="h-6">0h</span>
                                <span class="h-4">6h</span>
                                <span class="h-4">10h</span>
                                <span class="h-4">14h</span>
                                <span class="h-4">18h</span>
                                <span class="h-6 last-text-right">24h</span>
                            </div>
                        </div>
                        
                        <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse5">Giờ hạ cánh (chuyến đi)</a></p>
                        <div class="padding-time-flight-sort">
                            <p class="content-font-size">
                                <label for="time-arrival">Chuyến về:</label>
                                <input type="text" id="time-arrival" class="border-none bold">
                            </p>
                            <div class="text-center-point-slider">
                                <div id="slider-rangelv" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                    <div class="ui-slider-range ui-widget-header" style="left: 0%; width: 100%;"></div>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a>
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 100%;"></a>
                                </div>
                            </div>
                            <div class="rule">
                                <span class="h-6">0h</span>
                                <span class="h-4">6h</span>
                                <span class="h-4">10h</span>
                                <span class="h-4">14h</span>
                                <span class="h-4">18h</span>
                                <span class="h-6 last-text-right">24h</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--End theo tram chuyen tiep-->
                <div class="panel">
                    <p class="titleSort panel-title"><i class="fa fa-sort-desc yellow-color"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse6">Hãng hàng không</a></p>
                    <div id="collapse6" class="panel-collapse collapse in">
                        <div class="borderSort">
                            <table id="inter-airlines" class="theo-hang-bay table">
                                <tbody>
                                    <tr>
                                        <td class="checked"><label class="radio" style=" text-align:left; float:left; " for="rblAirline_0">
                                            <input style="float:left;" type="radio" value="" name="rblAirline" checked="checked" id="rblAirline_0">
                                            <span class="outer"><span class="inner"></span></span> &nbsp;Hiển thị tất cả</label>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End theo hang--> 
            </div>
            <!---End filter----> 
        </div>
        <?php endif; ?>
        <div class="summary-info box-can-you-know">
            <div class="heading-with-icon hidden-mobile-cs">
                <div class="heading-icon"><i class="icons-sprite icons-magnify_lens_encircled"></i></div>
                <div class="heading-title">Bạn cần biết</div>
            </div>
            <div class="box-content">
                <ul>
                    <li class="hidden-mobile-cs"> <a href="<?php bloginfo('url')?>/huong-dan-dat-ve" title=""> <img src="<?php bloginfo('template_directory')?>/images/icon01.png">&nbsp;&nbsp;&nbsp;Hướng dẫn đặt vé</a> </li>
                    <li class="hidden-mobile-cs"> <a href="<?php bloginfo('url')?>/cau-hoi-thuong-gap" title=""> <img src="<?php bloginfo('template_directory')?>/images/icon01.png">&nbsp;&nbsp;&nbsp;Câu hỏi thường gặp</a> </li>
                    <li class="margin-top-info-cs">
                        <img src="<?php bloginfo('template_directory')?>/images/icon03.png" class="icon-order-ticket-des">
                        <p class="phone-order-ticket">Tổng đài đặt vé: </p>
                        <span class="tel-number-ticket"><?php  echo get_option('opt_hotline'); ?></span> 
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php if(is_single()) { ?>
        <div class="Recent_posts mt20">
            <ul>
                <?php
                    global $post;
                    $post_id = $post->ID; // current post id
                    $cat = get_the_category(); 
                    $current_cat_id = $cat[0]->cat_ID; // current category Id 
                    
                    $args = array( 'numberposts' => 5, 'order'=> 'DESC', 'orderby' => 'date','post_status' => 'publish',  "category__in"=>8, "post__not_in" => array($post->ID));
                    $myposts = get_posts( $args );
                    foreach( $myposts as $post ) :  setup_postdata($post);
                ?>
                <li class="post format-">
                    <a href="<?php the_permalink() ?>">
                        <div class="photo"> <img src="<?php echo (_getHinhDaiDien($post->ID) != '' ? _getHinhDaiDien($post->ID) : v5s_catch_that_image()); ?>" width="108" height="80" class="scale-with-grid wp-post-image" ></div>
                        <div class="desc">
                            <h6 class=""><?php echo  wp_trim_words(get_the_title(),7) ?></h6>
                            <span class="date">
                            <?php the_time('d/m/Y');?>
                            </span>
                        </div>
                    </a>
                </li>
                <?php endforeach; wp_reset_postdata(); ?>
            </ul>
        </div>
        <?php  
            }
            ?>
        <div id="sidebar-support" class="mt20"> <img class="img-responsive" src="<?php bloginfo('template_directory')?>/images/ads1.jpg" alt=""/><br>
            <img class="img-responsive" src="<?php bloginfo('template_directory')?>/images/ads2.jpg" alt=""/> 
        </div>
    </div>
    <!--End #wgbox--> 
</div>
<!--End #accordion-->