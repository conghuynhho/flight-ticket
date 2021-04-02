<?php
get_header();
?>
    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <div class="homeWidgetWrap blueBg searchForm" id="flighttab">
                <h1 class="white-color col-md-12 col-sm-12 col-xs-12"><?php the_title(); ?></h1>
                <form class="search-flight-form" method="post" action="<?php echo _page('flightresult'); ?>" id="frmFlightSearch"
                      name="frmFlightSearch">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
				  <span class="pull-left padR20">
				  <label class="radio">
					<input type="radio" name="direction" id="rdbFlightTypeOneWay" value="1" checked="checked"
                           class="rdbFlightType rdbdirection">
					<span class="outer"><span class="inner"></span></span>Một chiều</label>
				  </span> <span class="pull-left">
				  <label class="radio">
					<input type="radio" name="direction" id="rdbFlightTypeReturn" value="0"
                           class="rdbFlightType rdbdirection">
					<span class="outer"><span class="inner"></span></span>Khứ hồi</label>
				  </span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Nơi đi</label>
                            <input name="depinput" type="text" id="depinput" class="form-control depart"
                                   placeholder="Nơi đi" value="Hồ Chí Minh (SGN)" readonly>
                        </div>
                        <div id="listDep" class="listcity row">
                            <div class="list-head col-xs-12">Chọn điểm đi <a href="#" id="close-dep"
                                                                             class="close">×</a></div>
                            <div class="col-xs-12">
                                <h4>QUỐC TẾ</h4>
                                <ul class="selectcity">
                                    <li>Vui lòng nhập tên thành phố hoặc mã sân bay<br>
                                    </li>
                                    <li>
                                        <input type="text" autocomplete="off" id="inter-city-dep"
                                               class="form-control ac-city" value="">
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <h4>MIỀN BẮC</h4>
                                <ul class="selectcity first">
                                    <li><a href="#" data-city="HAN">Hà Nội (HAN)</a></li>
                                    <li><a href="#" data-city="HPH">Hải Phòng (HPH)</a></li>
                                    <li><a href="#" data-city="VDO">Vân Đồn (VDO)</a></li>
                                    <li><a href="#" data-city="DIN">Điện Biên (DIN)</a></li>
                                </ul>
                                <h4>MIỀN NAM</h4>
                                <ul class="selectcity">
                                    <li><a href="#" data-city="SGN">Hồ Chí Minh (SGN)</a></li>
                                    <li><a href="#" data-city="VCA">Cần Thơ (VCA)</a></li>
                                    <li><a href="#" data-city="VCS">Côn Đảo (VCS)</a></li>
                                    <li><a href="#" data-city="PQC">Phú Quốc (PQC)</a></li>
                                    <li><a href="#" data-city="VKG">Rạch Giá (VKG)</a></li>
                                    <li><a href="#" data-city="CAH">Cà Mau (CAH)</a></li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <h4>MIỀN TRUNG</h4>
                                <ul class="selectcity">
                                    <li><a href="#" data-city="DAD">Đà Nẵng (DAD)</a></li>
                                    <li><a href="#" data-city="THD">Thanh Hóa (THD)</a></li>
                                    <li><a href="#" data-city="VII">Vinh (VII)</a></li>
                                    <li><a href="#" data-city="HUI">Huế (HUI)</a></li>
                                    <li><a href="#" data-city="VDH">Đồng Hới (VDH)</a></li>
                                    <li><a href="#" data-city="VCL">Chu Lai (VCL)</a></li>
                                    <li><a href="#" data-city="UIH">Quy Nhơn (UIH)</a></li>
                                    <li><a href="#" data-city="TBB">Tuy Hòa (TBB)</a></li>
                                    <li><a href="#" data-city="CXR">Nha Trang (CXR)</a></li>
                                    <li><a href="#" data-city="PXU">Pleiku (PXU)</a></li>
                                    <li><a href="#" data-city="BMV">Ban Mê Thuột (BMV)</a></li>
                                    <li><a href="#" data-city="DLI">Đà Lạt (DLI)</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--.listcity-->
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label>Nơi đến</label>
                            <input name="desinput" type="text" id="desinput" class="form-control arrival"
                                   placeholder="Nơi đến" value="Hà Nội (HAN)" readonly>
                        </div>
                        <div id="listDes" class="listcity">
                            <div class="list-head col-xs-12">Chọn điểm đến <a href="#" id="close-arv"
                                                                              class="close">×</a></div>
                            <div class="col-xs-12">
                                <h4>QUỐC TẾ</h4>
                                <ul class="selectcity">
                                    <li>Vui lòng nhập tên thành phố hoặc mã sân bay<br>
                                    </li>
                                    <li>
                                        <input type="text" autocomplete="off" id="inter-city-arv"
                                               class="form-control ac_city" value="">
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <h4>MIỀN BẮC</h4>
                                <ul class="selectcity first">
                                    <li><a href="#" data-city="HAN">Hà Nội (HAN)</a></li>
                                    <li><a href="#" data-city="HPH">Hải Phòng (HPH)</a></li>
                                    <li><a href="#" data-city="VDO">Vân Đồn (VDO)</a></li>
                                    <li><a href="#" data-city="DIN">Điện Biên (DIN)</a></li>
                                </ul>
                                <h4>MIỀN NAM</h4>
                                <ul class="selectcity">
                                    <li><a href="#" data-city="SGN">Hồ Chí Minh (SGN)</a></li>
                                    <li><a href="#" data-city="VCA">Cần Thơ (VCA)</a></li>
                                    <li><a href="#" data-city="VCS">Côn Đảo (VCS)</a></li>
                                    <li><a href="#" data-city="PQC">Phú Quốc (PQC)</a></li>
                                    <li><a href="#" data-city="VKG">Rạch Giá (VKG)</a></li>
                                    <li><a href="#" data-city="CAH">Cà Mau (CAH)</a></li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <h4>MIỀN TRUNG</h4>
                                <ul class="selectcity">
                                    <li><a href="#" data-city="DAD">Đà Nẵng (DAD)</a></li>
                                    <li><a href="#" data-city="THD">Thanh Hóa (THD)</a></li>
                                    <li><a href="#" data-city="VII">Vinh (VII)</a></li>
                                    <li><a href="#" data-city="HUI">Huế (HUI)</a></li>
                                    <li><a href="#" data-city="VDH">Đồng Hới (VDH)</a></li>
                                    <li><a href="#" data-city="VCL">Chu Lai (VCL)</a></li>
                                    <li><a href="#" data-city="UIH">Quy Nhơn (UIH)</a></li>
                                    <li><a href="#" data-city="TBB">Tuy Hòa (TBB)</a></li>
                                    <li><a href="#" data-city="CXR">Nha Trang (CXR)</a></li>
                                    <li><a href="#" data-city="PXU">Pleiku (PXU)</a></li>
                                    <li><a href="#" data-city="BMV">Ban Mê Thuột (BMV)</a></li>
                                    <li><a href="#" data-city="DLI">Đà Lạt (DLI)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--.listcity-->

                    <div class="col-md-12 col-sm-12 col-xs-12 pd0">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>Ngày đi</label>
                                <div class="datepicker-wrap inner-addon left-addon"><i
                                            class="icon-calendar1 ico22 widgetCalIcon "></i>
                                    <input id="depdate" readonly class="form-control" data-next="#retdate"
                                           after_function="change_start_date" minDate="<?= $crrttime_tmp ?>"
                                           maxdate="<?= $maxtime_tmp ?>" default_max_date="<?= $maxtime_tmp ?>"
                                           name="depdate" type="text" default="<?= $deptime_tmp ?>"
                                           value="<?= $deptime_tmp ?>" autocomplete="off">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <label>Ngày về</label>
                                <div class="datepicker-wrap inner-addon left-addon"><span
                                            class="icon-calendar1 ico22 widgetCalIcon"></span>
                                    <input id="retdate" readonly class="form-control"
                                           after_function="change_return_date" minDate="<?= $deptime_tmp ?>"
                                           maxdate="<?= $maxtime_tmp ?>" name="retdate" type="text"
                                           default="--/--/----" value="--/--/----" autocomplete="off">
                                </div>
                            </div>
                            <!-- <div class="row-column-lunar-description-right search-return-date-lunar-des hidden-xs"> <span class="text"></span> </div> -->
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 pd0 type-passenger">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group selector">
                                <label>Người lớn</label>
                                <select name="adult" id="adult" class="full-width">
                                    <?php for ($i = 1; $i <= 30; $i++): ?>
                                        <option value="<?= $i ?>">
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group selector">
                                <label>Trẻ em</label>
                                <select name="child" id="child" class="full-width">
                                    <option selected="selected" value="0">0</option>
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <option value="<?= $i ?>">
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="form-group  selector">
                                <label>Em bé</label>
                                <select name="infant" id="infant" class="full-width">
                                    <option selected="selected" value="0">0</option>
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <option value="<?= $i ?>">
                                            <?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="submit" name="btnsearch<?php echo $_SESSION['fl_btn_search']; ?>"
                               value="Tìm chuyến bay" id="BtnSearch<?php echo $_SESSION['fl_btn_search']; ?>"
                               class="button x-large pull-right" style="width:100%;margin-top:10px;">
                        <input name="dep" type="hidden" id="dep" value="SGN">
                        <input name="des" type="hidden" id="des" value="HAN">
                    </div>

                </form>
            </div>
        </div><!-- End Search Flight Form -->

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
				<img style="width:630px" src="' . imgdir . '/banner-home.jpg" alt="' . get_option('opt_introcontent') . '">
			</div>';
                }
                echo $slider_html;
                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>