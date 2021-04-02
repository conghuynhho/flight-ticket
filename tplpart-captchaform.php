<div class="captcha-form">
	<form action="<?php echo _page("checkcaptcha"); ?>" method="post">
           
        <img src="<?php echo $_SESSION['fl_captcha']['image_src']; ?>" style="width:150px !important;" />
        <input type="hidden" id="ssid" name="ssid" value="<?php echo $crssid; ?>" />
        <input type="text" id="captcha_text" class="form-control" name="captcha_text" value="" />
        <input type="submit" id="btn_captcha_submit" class="button" name="btn_captcha_submit" value="Tiếp tục" title="Tiếp tục" />
    </form>
</div>
