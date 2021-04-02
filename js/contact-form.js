$(document).ready(function(){

 //   alert(window.location);
    $("#contact-submit").click(function(){
 
	

        hasErr=false;

        errct=$("#notice-error");

        name= $.trim($("#contact-name").val());
        errName=$("#notice-name");

        email= $.trim($("#contact-email").val());
        errEmail=$("#notice-email");
        
        phone= $.trim($("#contact-phone").val());
        errPhone=$("#notice-phone");

        content = $.trim($("#contact-content").val());
        errContent = $("#notice-content");
		
		grecaptcharesponse1 = $.trim($("#g-recaptcha-response-1").val());
        errgrecaptcharesponse1= $("#notice-g-recaptcha-response-1");
		

        err="";

		  if(!isNotNull(grecaptcharesponse1)){
            err="Vui lòng điền captcha";
            hasErr=true;
        }else{
             errct.html("&nbsp;");
        }
		
       
         if(!isNotNull(content)){
            err="Vui lòng điền nội dung";
            hasErr=true;
        }else{
             errct.html("&nbsp;");
        }
		if (content.indexOf("http://") >= 0)
			{	 err="Vui lòng điền nội dung";
            hasErr=true;
			}else{
				  errct.html("&nbsp;");
			}
        
        if(!isNotNull(phone)){
            err="Vui lòng điền số điện thoại";
            hasErr=true;
        }else if(isNaN(phone)){
            err="Số điện thoại không đúng định dạng";
            hasErr=true;
        }else{
            errct.html("&nbsp;");
        }
		

        if(!isNotNull(email)){
            err="Vui lòng điền email";
            hasErr=true;
        }else if(!isEmail(email)){
            err="Email không đúng định dạng";
            hasErr=true;
        }else{
            errct.html("&nbsp;");
        }
		if(!isNotNull(name)){
            err="Vui lòng điền tên";
               hasErr=true;
           }else{
            errct.html("&nbsp;");
            errct.show();
           }

       // alert(hasErr);
        if(hasErr === true){
            console.log("Co loi");
            errct.html(err);
           return false;
        }else{
            console.log("Khong co loi");
            errct.html("&nbsp;");
            var succfunc= function(data){
            console.log(data);
        //   alert(data);
            if(data==1){
				 
                /*if success*/
                $("#notice-error").html("&nbsp;");
                    setTimeout(function(){
                        $('#contact-submit').val("&nbsp;");
						$("#frm_contact").html("<p>Cảm ơn quý khách đã liên hệ. Chúng tôi sẽ liên lạc với quý khách trong thời gian sớm nhất!</p>");
                        $('#contact-submit').val("Thông tin đã được gửi!").css('visibility', 'visible');
                }, 1000);
                
            }else{
                /*something wrong*/
                $("#process-form").empty();
                $("#notice-error").html("Có lỗi xảy ra, vui lòng thử lại sau").css('visibility', 'visible');
                $('#contact-submit').val("Gửi");
                $("#contact-submit").removeAttr("disabled");
            }
        };

        var beforefunc=function(){
            $('#contact-submit').val("&nbsp;");
            $('#contact-submit').val("Đang xử lý");
            $("#contact-submit").attr("disabled","disabled");
        };

        $.ajax({
            url: window.location,
            cache:false,
            type: "POST",
            dataType: "html",
            data: $("#frm_contact").serializeArray(),
            success:succfunc,
            beforeSend: beforefunc
        });
        }
		 
		
		
    });
	
	
	if ($('#map-canvas').length) {

    var map,

        service;

    jQuery(function($) {

        $(document).ready(function() {

            var latlng = new google.maps.LatLng(10.800807, 106.718360);

            var myOptions = {

                zoom: 16,

                center: latlng,

                mapTypeId: google.maps.MapTypeId.ROADMAP,

                scrollwheel: false

            };

            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

            var marker = new google.maps.Marker({
                position: latlng,
                map: map
            });
            marker.setMap(map);
            $('a[href="#google-map-tab"]').on('shown.bs.tab', function(e) {
                google.maps.event.trigger(map, 'resize');
                map.setCenter(latlng);

            });

        });

    });

}

});

