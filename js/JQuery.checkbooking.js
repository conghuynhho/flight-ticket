$(function() {
	var numberformat = /^[0-9]+$/;
	var emailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	$("#frmrechech-booking").submit(function(){
		if( $("#booking-email").val() == '' && $("#booking-phone").val() == '' ){
			$(".errormsg").show().html("Vui lòng nhập email hoặc số điện thoại.");
			return false;
		}
		if( $("#booking-email").val() != '' && emailformat.test($("#booking-email").val()) == false){
			$(".errormsg").show().html("Email không hợp lệ.");
			return false;
		}
		if(	$("#booking-phone").val() != '' && (numberformat.test($("#booking-phone").val()) == false || $("#booking-phone").val().length < 9 )){
			$(".errormsg").show().html("Số điện thoại không hợp lệ.");
			return false;
		}
		if( $("#booking-code").val() == ''){
			$(".errormsg").show().html("Vui lòng nhập mã đơn hàng.");
			return false;
		}
	});
});