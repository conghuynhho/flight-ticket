<?php
//CAPTCHA Matching code
session_start();
if ($_SESSION["code"] == $_POST["captcha"]) {
    echo "1";
} else {
    die("0");
}
?>
