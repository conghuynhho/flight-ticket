<?php
    /*
        BUILD TEMPLATE SITE VE-TINH-PAGE-VE-MAY-BAY
    */
    $deptime_tmp = date("d/m/Y", strtotime('+3 days'));
    $departurecity = getCityName($_REQUEST['dep']);
    $arrivalcity = getCityName($_REQUEST['des']);
    

    if ((isset($_REQUEST['dep'])) && (!empty($_REQUEST['dep'])))
    {
        $dep = $_REQUEST['dep'];
    } else {
        $dep = 'SGN';
    }

    if ((isset($_REQUEST['des'])) && (!empty($_REQUEST['des'])))
    {
        $des = $_REQUEST['des'];
    } else {
        $des = 'HAN';
    }

    if ((isset($_REQUEST['depdate'])) && (!empty($_REQUEST['depdate'])))
    {
        $depdate = $_REQUEST['depdate'];
    } else {
        $depdate = $deptime_tmp;
    }

    if ((isset($_REQUEST['retdate'])) && (!empty($_REQUEST['retdate'])))
    {
        $retdate = $_REQUEST['retdate'];
    } else {
        $retdate = 'Ngày về';
    }

    if ((isset($_REQUEST['adult'])) && (!empty($_REQUEST['adult'])))
    {
        $adult = $_REQUEST['adult'];
    } else {
        $adult = '1';
    }

    if ((isset($_REQUEST['child'])) && (!empty($_REQUEST['child'])))
    {
        $child = $_REQUEST['child'];
    } else {
        $child = '0';
    }

    if ((isset($_REQUEST['infant'])) && (!empty($_REQUEST['infant'])))
    {
        $infant = $_REQUEST['infant'];
    } else {
        $infant = '0';
    }
    get_header();
?>
<div class="tpl__ve-may-bay">
	<div class="col-md-12 col-sm-12 col-xs-12 tpl-full-with-12">
        <div class="homeWidgetWrap blueBg searchForm" id="flighttab">
            <h1 class="white-color tcb-h1-title hidden-xs">
                <?php echo get_option('opt_introcontent') ?>
            </h1>
            <form class="search-flight-form" method="post" action="<?php echo _page('flightresult'); ?>" id="frmFlightSearch" name="frmFlightSearch">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <span class="pull-left padR20">
                            <label class="radio tpl-rdio-oneways">
                                <input type="radio" name="direction" id="rdbFlightTypeOneWay" value="1" checked="checked" class="rdbFlightType rdbdirection" <?php echo ($_REQUEST["direction"] == "1") ? "checked='checked'" : ""; ?>>
                                <span class="outer"><span class="inner"></span></span>Một chiều
                            </label>
                        </span>
                        <span class="pull-left">
                            <label class="radio tpl-rdio-roundtrip">
                                <input type="radio" name="direction" id="rdbFlightTypeReturn" value="0" class="rdbFlightType rdbdirection" <?php echo ($_REQUEST["direction"] == "0") ? "checked='checked'" : ""; ?>>
                                <span class="outer"><span class="inner"></span></span>Khứ hồi
                            </label>
                        </span>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>Nơi đi</label>
                        <input name="depinput" type="text" id="tpldepinput" class="form-control depart" placeholder="Nơi đi" value="<?php echo $departurecity; ?>">
                        
                    </div>
                    <!--- DESKTOP -->
                    <div id="tpllistDep" class="listcity list-airports-direction list-direction-animate hidden-xs">
                        <div class="suggestion-container hidden-xs">
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
                        <input name="desinput" type="text" id="tpldesinput" class="form-control arrival desktop-input desktop-input-mobile hidden-xs" placeholder="Nơi đến" value="<?php echo $arrivalcity; ?>">
                        
                    </div>
                    <div id="tpllistDes" class="listcity listcity list-airports-direction list-direction-animate hidden-xs">
                        <div class="suggestion-container hidden-xs">
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
                                                <li class="tcb-hot-city-box-item tcb-hot-city-box-single u-clearfix">
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
                            <div class="datepicker-wrap inner-addon left-addon"> 
                                <i class="icon-calendar1 ico22 widgetCalIcon "></i>
                                <input id="depdate" readonly class="form-control" data-next="#retdate" after_function="change_start_date" minDate="<?php echo $crrttime_tmp ?>" maxdate="<?php echo $maxtime_tmp ?>" default_max_date="<?php echo $maxtime_tmp ?>" name="depdate" type="text" default="<?php echo $outboundDate; ?>" value="<?php echo $depdate ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label>Ngày về</label>
                            <div class="datepicker-wrap inner-addon left-addon"> 
                                <i class="icon-calendar1 ico22 widgetCalIcon"></i>
                                <input id="retdate" readonly class="form-control" after_function="change_return_date" minDate="<?php echo $deptime_tmp ?>" maxdate="<?php echo $maxtime_tmp ?>" name="retdate" type="text" default="<?php echo $retdate; ?>" value="<?php echo $retdate; ?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 pd0 type-passenger">
                    <div class="input-select-passenger">
                        <input type="hidden" name="hidden-adult" id="hidden-adult" class="tpl-hidden-adult" value="<?php echo $adult; ?>">
                        <input type="hidden" name="hidden-child" id="hidden-child" class="tpl-hidden-child" value="<?php echo $child; ?>">
                        <input type="hidden" name="hidden-infant" id="hidden-infant" class="tpl-hidden-infant" value="<?php echo $infant; ?>">
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="form-group selector">
                            <label>Người lớn</label>
                            <select name="adult" id="adult" class="full-width">
                                <?php for ($i = 1; $i <= 30; $i++) : ?>
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
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
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
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
                                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <input type="submit" name="btnsearch" value="Săn vé máy bay giá rẻ" id="BtnSearch" class="button x-large pull-right config-button-search" style="width:100%;margin-top:10px;">
                    <input id="dep" name="dep" type="hidden" value="<?php echo $dep; ?>">            
                    <input id="des" name="des" type="hidden" value="<?php echo $des; ?>">
                    <input type="hidden" name="adult" id="adultNo" value="<?php echo $adult; ?>">
                    <input type="hidden" name="child" id="childNo" value="<?php echo $child; ?>">
                    <input type="hidden" name="infant" id="infantNo" value="<?php echo $infant; ?>">
                </div>
            </form>
        </div>
    </div>
</div>