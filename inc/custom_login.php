<?php
/**
 * Created by Notepad.
 * User: Lak
 * Date: 10/25/13
 */
function CheckLoginInDB($username, $password){
    global $wpdb;
    $username = strtolower(trim($username));
    $passmd5 = md5($password);
    $sql = "SELECT tv_user_name,
				   tv_user_hash
			FROM lbm_thanhvien
			WHERE tv_user_name = '".$username."'
		 	  AND tv_user_hash = '".$passmd5."'
			  AND tv_deleted = 0
			  AND tv_terminated = 0";
    $res = $wpdb->get_row($sql);
    if($res)
        return true;
    else
        return false;

}

function getUserID($username, $password){
    global $wpdb;
    $username = strtolower(trim($username));
    $passmd5 = md5($password);
    $sql = "SELECT tv_id
			FROM lbm_thanhvien
			WHERE tv_user_name = '".$username."'
		 	  AND tv_user_hash = '".$passmd5."'
			  AND tv_deleted = 0
			  AND tv_terminated = 0";
    $res = $wpdb->get_row($sql);
    return $res->tv_id;
}

function CheckLogin(){
    if(!isset($_SESSION)){ session_start(); }

    $ss_var = getLoginSessionVar();
    $ss_user_name = $ss_var['user_name'];

    if( empty($_SESSION[$ss_user_name]) )
    {
        return false;
    }
    return true;
}

function getLoginSessionVar(){
    $strmd5 = md5('ba47c03a6f72a31343c71ed2fbe005b4');

    $key = array();

    $key['user_name'] = 'usrnm_'.substr($strmd5,5,10);
    $key['user_id'] = 'usrid_'.substr($strmd5,5,10);

    return $key;
}

function Logout(){

    if(!isset($_SESSION)){ session_start(); }

    $ss_var = getLoginSessionVar();
    $ss_user_name = $ss_var['user_name'];
    $_SESSION[$ss_user_name]=NULL;
    unset($_SESSION[$ss_user_name]);

}
?>