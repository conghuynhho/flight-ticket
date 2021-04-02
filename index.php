<?php
    $pickuptime_tmp = date("d/m/Y", time() + (60 * 60));
    $deptime_tmp = date("d/m/Y", time() + (60 * 60 * (48 + 24)));
    $maxtime_tmp = date("d/m/Y", time() + (60 * 60 * (8760)));
    $crrttime_tmp = date("d/m/Y", time());
    get_header();
?>
<!--START MAIN CONTAINER-->
<div class="gray-area">
    <!-- TOP AREA -->
    <div class="container homeContainerInner bg-front bg-front-mob-rel">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <div class="homeWidgetWrap blueBg searchForm" id="flighttab">
                    <h1 class="white-color tcb-h1-title hidden-xs">
                        <?php echo get_option('opt_introcontent') ?>
                    </h1>
                    <form class="search-flight-form" method="post" action="<?php echo _page('flightresult'); ?>" id="frmFlightSearch" name="frmFlightSearch">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <span class="pull-left padR20">
                                    <label class="radio">
                                        <input type="radio" name="direction" id="rdbFlightTypeOneWay" value="1" checked="checked" class="rdbFlightType rdbdirection">
                                        <span class="outer"><span class="inner"></span></span>Một chiều
                                    </label>
                                </span>
                                <span class="pull-left">
                                    <label class="radio">
                                        <input type="radio" name="direction" id="rdbFlightTypeReturn" value="0" class="rdbFlightType rdbdirection">
                                        <span class="outer"><span class="inner"></span></span>Khứ hồi
                                    </label>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Nơi đi</label>
                                <input name="depinput" type="text" id="depinput" class="form-control depart desktop-input desktop-input-mobile" placeholder="Nơi đi" value="Hồ Chí Minh (SGN)">
                            </div>
                            <!--- DESKTOP -->
                            <div id="listDep" class="listcity list-airports-direction list-direction-animate">
                                <div class="suggestion-container">
                                    <div class="tcb-hot-city-box">
                                        <div class="tcb-hot-city-box-cnt">
                                            <div class="tcb-hot-city-box-tit">
                                                <div id="city-tabs-dep" class="city-tabs">
                                                    <a id="tab1-tab-dep" href="#tab1-dep" class="active">Nội địa</a>
                                                    <a id="tab2-tab-dep" href="#tab2-dep">Quốc tế</a>
                                                </div>
                                            </div>
                                            <div class="tab-content">
                                                <div id="tab1-dep">
                                                    <ul>
                                                        <li class="tcb-hot-city-box-item tcb-hot-city-box-single u-clearfix">
                                                            <?php echo getAirportsDesktop($GLOBALS['FULL_AIRPORT_GROUP_VN_DESKTOP']); ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div id="tab2-dep">
                                                    <ul>
                                                        <li class="tcb-hot-city-box-item tcb-hot-city-box-single u-clearfix">
                                                            <?php echo getAirportsDesktop($GLOBALS['FULL_AIRPORT_GROUP_INTER_DESKTOP']); ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:;" data-toggle="close" class="tcb-hot-city-box-close close-arv">
                                            <i class="fa fa-close fi-close"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- END DESKTOP -->
                            <!--.listcity-->
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Nơi đến</label>
                                <input name="desinput" type="text" id="desinput" class="form-control arrival desktop-input desktop-input-mobile" placeholder="Nơi đến" value="Hà Nội (HAN)">
                            </div>
                            <div id="listDes" class="listcity listcity list-airports-direction list-direction-animate">
                                <div class="suggestion-container">
                                    <div class="tcb-hot-city-box">
                                        <div class="tcb-hot-city-box-cnt">
                                            <div class="tcb-hot-city-box-tit">
                                                <div id="city-tabs-arv" class="city-tabs">
                                                    <a id="tab1-tab-arv" href="#tab1-arv" class="active">Nội địa</a>
                                                    <a id="tab2-tab-arv" href="#tab2-arv">Quốc tế</a>
                                                </div>
                                            </div>
                                            <div class="tab-content">
                                                <div id="tab1-arv">
                                                    <ul>
                                                        <li class="tcb-hot-city-box-item tcb-hot-city-box-single u-clearfix" style="display: block">
                                                            <?php echo getAirportsDesktop($GLOBALS['FULL_AIRPORT_GROUP_VN_DESKTOP']); ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div id="tab2-arv">
                                                    <ul>
                                                        <li class="tcb-hot-city-box-item tcb-hot-city-box-single u-clearfix">
                                                            <?php echo getAirportsDesktop($GLOBALS['FULL_AIRPORT_GROUP_INTER_DESKTOP']); ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="javascript:;" data-toggle="close" class="tcb-hot-city-box-close close-arv">
                                            <i class="fa fa-close fi-close"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--.listcity-->
                        <div class="col-md-12 col-sm-12 col-xs-12 pd0">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label>Ngày đi</label>
                                    <div class="datepicker-wrap inner-addon left-addon"> <i class="icon-calendar1 ico22 widgetCalIcon "></i>
                                        <input id="depdate" readonly class="form-control" data-next="#retdate" after_function="change_start_date" minDate="<?= $crrttime_tmp ?>" maxdate="<?= $maxtime_tmp ?>" default_max_date="<?= $maxtime_tmp ?>" name="depdate" type="text" default="<?= $deptime_tmp ?>" value="<?= $deptime_tmp ?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <label>Ngày về</label>
                                    <div class="datepicker-wrap inner-addon left-addon"> <span class="icon-calendar1 ico22 widgetCalIcon"></span>
                                        <input id="retdate" readonly class="form-control" after_function="change_return_date" minDate="<?= $deptime_tmp ?>" maxdate="<?= $maxtime_tmp ?>" name="retdate" type="text" default="--/--/----" value="--/--/----" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 pd0 type-passenger">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group selector">
                                    <label>Người lớn</label>
                                    <select name="adult" id="adult" class="full-width">
                                        <?php for ($i = 1; $i <= 30; $i++) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group selector">
                                    <label>Trẻ em</label>
                                    <select name="child" id="child" class="full-width">
                                        <option selected="selected" value="0">0</option>
                                        <?php for ($i = 1; $i <= 4; $i++) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group  selector">
                                    <label>Em bé</label>
                                    <select name="infant" id="infant" class="full-width">
                                        <option selected="selected" value="0">0</option>
                                        <?php for ($i = 1; $i <= 4; $i++) : ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="submit" name="btnsearch" value="Tìm chuyến bay" id="BtnSearch" class="button x-large pull-right config-button-search" style="width:100%;margin-top:10px;">
                            <input name="dep" type="hidden" id="dep" value="SGN">
                            <input name="des" type="hidden" id="des" value="HAN">
                            <input name="adult" type="hidden" id="adultNo" value="1">
                            <input name="child" type="hidden" id="childNo" value="0">
                            <input name="infant" type="hidden" id="infantNo" value="0">
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Search Flight Form -->
            <div class="col-md-7 col-sm-7 hidden-xs">
                <div id="owl-slide" class="owl-carousel owl-theme">
                    <?php
                        $theme_slider = get_option('theme_slider');
                        $slider_html = '';
                        if ($theme_slider) {
                            foreach ($theme_slider as $slider) {
                                $slider_html .= '<div class="item">';
                                if ($slider['link'] && trim($slider['link']) != '')
                                    $slider_html .= '<a href="' . $slider['link'] . '">
                                                        <img style="width:630px" src="' . $slider['img'] . '" alt="' . $slider['title'] . '">
                                                    </a>';
                                else
                                    $slider_html .= '<img style="width:630px" src="' . $slider['img'] . '" alt="' . $slider['title'] . '">';
                                $slider_html .= '</div>';
                            }
                        } else {
                            $slider_html .= '<div class="item">
                                                <img style="width:630px" src="' . imgdir . '/banner-tet-2019.jpg" alt="' . get_option('opt_introcontent') . '">
                                            </div>';
                        }
                        echo $slider_html;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END TOP AREA  -->
    <div class="container company-description">
        <div class="row">
            <div class="col-md-8 col-sm-8 content-left-tcb-2020 hidden-xs">
                <a href="/meo-san-ve-may-bay-gia-re" target="_blank" style="float: left;">
                    <span style="font-size:1.6em"> &nbsp; 
                        <?php 
                            $title = get_option('opt_title_cheap_airline'); 
                            echo $title;
                        ?>
                    </span>
                </a>
            </div>
            <div class="col-md-4 col-sm-4 hidden-xs">
                <div class="mobile-app__links" style="text-align: center;background: #fff;float: left;padding: 2px;width: 100%;">
                    <?php 
                        $app_android = get_option('opt_app_android_link');
                        $app_ios = get_option('opt_app_ios_link');
                    ?>
                    <a href="<?php echo $app_android; ?>" rel="nofollow" target="_blank" class="hide-text mobile-app__links--google-play js-mobile-app-link" data-mobile-app="Google Play" title="Tải ứng dụng dành cho Android" style="background: #fff url(https://timchuyenbay.com/assets/uploads/2018/09/button-sprite-91938960aaa71fc5d40c44c0ce3a4f07.png) no-repeat 0;"></a>
                    <a href="<?php echo $app_ios; ?>" rel="nofollow" target="_blank" class="hide-text js-mobile-app-link" data-mobile-app="Apple" title="Tải ứng dụng dành cho iOS" style="background: #fff url(https://timchuyenbay.com/assets/uploads/2018/09/button-sprite-91938960aaa71fc5d40c44c0ce3a4f07.png) no-repeat 0 0;"></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- Advantage -->
<div class="tcb-flightHome-advantage">
    <div class="tcb-advantage-content">
        <div class="tcb-advantage-item">
            <div class="tcb-advantage-worldwide"></div>
            <div class="tcb-advantage-item-title">
                <a href="/san-ve-may-bay-gia-re" title="Săn vé máy bay giá rẻ">Săn vé máy bay giá rẻ KM</a>
            </div>
            <div class="tcb-advantage-item-info">Săn vé máy bay giá rẻ KM từ Vietjet, Jetstar và Vietnam Airlines, BamBooAirways với nhiều hành trình giá chỉ từ 99K, 199, 299 và 399K ... 1900 63 6060</div>
        </div>
        <div class="tcb-advantage-item">
            <div class="tcb-advantage-oneStop"></div>
            <div class="tcb-advantage-item-title">
                <a href="https://vietjet.net/tim-ve-noi-dia/" title="Vé máy bay giá rẻ">Vé máy bay khuyến mãi nội địa</a>
            </div>
            <div class="tcb-advantage-item-info">Vé máy bay khuyến mãi nội địa Sài Gòn, Hà Nội, Đà Nẵng, Huế, Vinh, Nha Trang, Đà Lạt, Phú Quốc, Cần Thơ. Mẹo săn vé máy bay giá rẻ ... 1900 63 6060</div>
        </div>
        <div class="tcb-advantage-item">
            <div class="tcb-advantage-secure"></div>
            <div class="tcb-advantage-item-title"><a href="/ve-may-bay" title="Vé máy bay giá rẻ khuyến mãi">Vé máy bay giá rẻ khuyến mãi</a></div>
            <div class="tcb-advantage-item-info">Vé máy bay giá rẻ Vietjet, Bamboo, Vietnam Airlines và Jetstar. Đặt vé máy bay giá rẻ nội địa & quốc tế, giá vé máy trực tuyến bay cập nhật 2020.</div>
        </div>
    </div>
</div>
<!-- End Advantage -->
<!-- NỌI ĐỊA -->
<div class="container destination margintop20">
    <div class="form-title">
        <h2 class="padding40">ĐIỂM ĐẾN VIỆT NAM</h2><span>&nbsp;</span>
    </div>
    <div class="row">
        <?php 
            $data = array(
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-HAN.jpg|Hà Nội|199000|https://timchuyenbay.com/ve-may-bay-di-ha-noi/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-SGN.jpg|Sài Gòn|199000|https://timchuyenbay.com/ve-may-bay-di-sai-gon/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-PQC.jpg|Phú Quốc|99000|https://timchuyenbay.com/ve-may-bay-di-phu-quoc/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-DAD.jpg|Đà Nẵng|99000|https://timchuyenbay.com/ve-may-bay-di-da-nang/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-CXR.jpg|Nha Trang|55000|https://timchuyenbay.com/ve-may-bay-di-nha-trang/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-HPH.jpg|Hải Phòng|199000|https://timchuyenbay.com/ve-may-bay-di-hai-phong/',
            ); 
            $i = 0;
            $arrData =  array();
            foreach ($data as $key => $value) {
                $expodeValue = explode("|", $value);
                $arrData[$i] = array(
                    'url-OP'.$i.'' => $expodeValue[0], 
                    'nameCity-OP'.$i.'' => $expodeValue[1], 
                    'price-OP'.$i.'' => $expodeValue[2], 
                    'link-OP'.$i.'' => $expodeValue[3]
                );
                $i++;
            }      
            $html = '';
            if(!empty($arrData)) {
                $option0 = showContentOptions($arrData[0]['url-OP0'], $arrData[0]['nameCity-OP0'], $arrData[0]['price-OP0'], $arrData[0]['link-OP0']);
                $option1 = showContentOptions($arrData[1]['url-OP1'], $arrData[1]['nameCity-OP1'], $arrData[1]['price-OP1'], $arrData[1]['link-OP1']);
                $option2 = showContentOptions($arrData[2]['url-OP2'], $arrData[2]['nameCity-OP2'], $arrData[2]['price-OP2'], $arrData[2]['link-OP2']);
                $option3 = showContentOptions($arrData[3]['url-OP3'], $arrData[3]['nameCity-OP3'], $arrData[3]['price-OP3'], $arrData[3]['link-OP3']);
                $option4 = showContentOptions($arrData[4]['url-OP4'], $arrData[4]['nameCity-OP4'], $arrData[4]['price-OP4'], $arrData[4]['link-OP4']);
                $option5 = showContentOptions($arrData[5]['url-OP5'], $arrData[5]['nameCity-OP5'], $arrData[5]['price-OP5'], $arrData[5]['link-OP5']);
                $html.= '<div class="col-sm-4 col-xs-12 col-promotions">'.$option0.'</div>  
                         <div class="col-sm-4 col-xs-12 col-promotions">'.$option1.'</div>
                         <div class="col-sm-4 col-xs-12 medium col-promotions">'.$option2.$option3.'</div>
                         <div class="col-sm-6 col-xs-12 medium col-promotions">'.$option4.'</div>
                         <div class="col-sm-6 col-xs-12 medium col-promotions">'.$option5.'</div>';
                echo $html;     
            }   
               
        ?>
    </div>
</div>
<!-- QUỐC TẾ -->
<div class="container destination margintop20">
    <div class="form-title">
        <h2 class="padding40">ĐIỂM ĐẾN QUỐC TẾ</h2><span>&nbsp;</span>
    </div>
    <div class="row">
        <?php 
            $data = array(
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-MY.jpg|Mỹ|17902000|https://timchuyenbay.com/ve-may-bay-di-my/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-ANH.jpg|Anh|33467259|https://timchuyenbay.com/ve-may-bay-di-anh/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-SEL.jpg|Hàn Quốc|9026439|https://timchuyenbay.com/ve-may-bay-di-han-quoc/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-TOKYO.jpg|Nhật Bản|14075000|https://timchuyenbay.com/ve-may-bay-di-nhat/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-BKK.jpg|Thái Lan|2344000|https://timchuyenbay.com/ve-may-bay-di-thai-lan/',
                'https://timchuyenbay.com/assets/uploads/2019/11/VMB-SIN.jpg|Singapore|4514000|https://timchuyenbay.com/ve-may-bay-di-singapore/',
            ); 
            $i = 0;
            $arrData =  array();
            foreach ($data as $key => $value) {
                $expodeValue = explode("|", $value);
                $arrData[$i] = array(
                    'url-OP'.$i.'' => $expodeValue[0], 
                    'nameCity-OP'.$i.'' => $expodeValue[1], 
                    'price-OP'.$i.'' => $expodeValue[2], 
                    'link-OP'.$i.'' => $expodeValue[3]
                );
                $i++;
            }       
            $html = '';
            if(!empty($arrData)) {
                $option0 = showContentOptions($arrData[0]['url-OP0'], $arrData[0]['nameCity-OP0'], $arrData[0]['price-OP0'], $arrData[0]['link-OP0']);
                $option1 = showContentOptions($arrData[1]['url-OP1'], $arrData[1]['nameCity-OP1'], $arrData[1]['price-OP1'], $arrData[1]['link-OP1']);
                $option2 = showContentOptions($arrData[2]['url-OP2'], $arrData[2]['nameCity-OP2'], $arrData[2]['price-OP2'], $arrData[2]['link-OP2']);
                $option3 = showContentOptions($arrData[3]['url-OP3'], $arrData[3]['nameCity-OP3'], $arrData[3]['price-OP3'], $arrData[3]['link-OP3']);
                $option4 = showContentOptions($arrData[4]['url-OP4'], $arrData[4]['nameCity-OP4'], $arrData[4]['price-OP4'], $arrData[4]['link-OP4']);
                $option5 = showContentOptions($arrData[5]['url-OP5'], $arrData[5]['nameCity-OP5'], $arrData[5]['price-OP5'], $arrData[5]['link-OP5']);
                $html.= '<div class="col-sm-6 col-xs-12 medium col-promotions">'.$option0.'</div>  
                         <div class="col-sm-6 col-xs-12 medium col-promotions">'.$option1.'</div>
                         <div class="col-sm-6 col-xs-12 small col-promotions">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 col-promotions">'.$option2.'</div>
                                <div class="col-sm-6 col-xs-12 col-promotions">'.$option3.'</div>
                            </div>
                            '.$option4.'
                         </div>
                         <div class="col-sm-6 col-xs-12 col-promotions">'.$option5.'</div>';
                echo $html;     
            }   
               
        ?>
    </div>
</div>
<!-- news-section
    ================================================== -->
<section class="news-section gray-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 title-section color-bg-white">
                <div class="wrap-content">
                    <div class="content-title-news">
                        <?php $titleNews = 'Tổng đài vé máy bay'; ?>
                        <a href="/ve-may-bay-khuyen-mai/"><?php echo $titleNews; ?></a>
                    </div>
                    <div class="phone-news-box"><?php echo get_option('opt_hotline'); ?></div>
                </div>
            </div>
            <div class="col-md-12 config-margin-top" style="padding: 0 10px;">
                <div class="news-box" style="padding: 0 5px; background-color: #fff;">
                    <div id="owl-news" class="owl-carousel">
                        <?php
                            global $post;
                            $args = array(
                                'numberposts' => get_option('opt_footer_number_posts'),
                                'category' => get_option('opt_home_news_id') // Ban Tin Du Lich
                            );
                            $newPosts = get_posts($args);
                            foreach ($newPosts as $post) :    
                            setup_postdata($post);
                        ?>
                            <div class="item news-post">
                                <a href="<?php the_permalink() ?>" class="item-image">
                                    <img class="lazyloaded" src="<?php echo (_getHinhDaiDien($post->ID) != '' ? _getHinhDaiDien($post->ID) : v5s_catch_that_image()); ?>" alt="">
                                </a>
                                <div class="box-detail">
                                    <h4 class="h4-news">
                                        <a href="<?php the_permalink() ?>">
                                            <?php echo  wp_trim_words(get_the_title(), 9) ?>
                                        </a>
                                    </h4>
                                    <p class="p-description-news"><?php echo wp_trim_words(get_the_content(), 40); ?></p>
                                </div>
                            </div>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End news section -->
</div><!-- End .gray-area -->
<?php get_footer(); ?>