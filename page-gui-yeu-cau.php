<?php
 if(isset($_POST['g-recaptcha-response'])){
		  $captcha=$_POST['g-recaptcha-response'];
		}
	$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcaSgYTAAAAACQwhrfuogkTTzJJb_3vCi1gW--h&response=" .$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
    
	if ($response . success == false) {
        echo 'Spam';
       // http_response_code(401); // It's SPAM! RETURN SOME KIND OF ERROR
    } else {
       // Everything is ok and you can proceed by executing your login, signup, update etc scripts
	   	if(trim($_POST['sg_name']) != '' && trim($_POST['sg_email']) != '' && trim($_POST['sg_phone']) != '' && trim($_POST['sg_content']) != ''  && strpos($_POST['sg_content'],'http') != true && strpos($_POST['sg_content'],'www') != true){
			require(TEMPLATEPATH.'/flight_config/sugarrest/sugar_rest.php');
			$sugar = new Sugar_REST();
			$error = $sugar->get_error();
			$arr_req = array('contact_name'   => trim($_POST['sg_name']),
							 'email' 		  => trim($_POST['sg_email']),								 
							 'phone'		  => trim($_POST['sg_phone']),
							 'request_detail' => trim($_POST['sg_content']),
							 'request_type'   => 4,
							 'request_status' => 0,					 
							 );
			$req_id = $sugar->set("EC_Request_Flight",$arr_req);
		}
    }
	
	
	
?>