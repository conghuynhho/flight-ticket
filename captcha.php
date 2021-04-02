<?php
//staring session
session_start();

//Initializing PHP variable with string
$captchanumber = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';

//Getting first 6 word after shuffle
$captchanumber = substr(str_shuffle($captchanumber), 0, 4);

//Initializing session variable with above generated sub-string
$_SESSION["code"] = $captchanumber;

//Generating CAPTCHA
$image = imagecreatefromjpeg("images/bj.jpg");
$foreground = imagecolorallocate($image, 175, 199, 200); //font color
imagestring($image, 5, 25, 8, $captchanumber, $foreground);
header('Content-type: image/png');
imagepng($image);
?>