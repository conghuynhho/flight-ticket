<?php
$captcha_ss = preg_replace('/[^a-zA-Z0-9]/', '', $_SESSION['fl_captcha']['code']);
$captcha_text = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['captcha_text']);
$ssid = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['ssid']);
if($captcha_ss && $captcha_text && $captcha_ss == $captcha_text){
	$_SESSION['fl_captcha_ok'] = true;
	header("Location: "._page("flightresult")."?SessionID=".$ssid);
} else {
	header("Location: "._page("flightresult")."?SessionID=".$ssid);
}
?>