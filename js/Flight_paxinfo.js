/**
 * Created with JetBrains PhpStorm.
 * User: Lak
 * Date: 11/2/13
 * Time: 11:46 AM
 * To change this template use File | Settings | File Templates.
 */
$(document).ready(function() {
	
	// set global vars
	var decimals = 0;
	var dec_point =  '.';
	var thousands_sep = ',';
	
    $(".dep_addbaggage").change(function(){
        var priceBaggage = 0; // gia hanh ly luot di
        $(".dep_addbaggage").each(function(){
            priceBaggage += parseInt($(this).val());
        });
		
		$("#dep_pricebaggage").text(formatNumber(priceBaggage, decimals, dec_point, thousands_sep)); // in gia hanh ly luot di

        var deptotalprice = parseInt($("#hddeptotalprice").val()); // tong gia tien luot di
        var deptotalprice_incbag = priceBaggage + deptotalprice; //tong gia tien luot di bao gom tien hanh ly

        // in tong gia tien luot di
        $("#dep_total").text(formatNumber(deptotalprice_incbag, decimals, dec_point, thousands_sep));

        if($("#wayflight").val() == 0){

            var priceBaggage_ret = 0; // gia hanh ly luot ve
            $(".ret_addbaggage").each(function(){
                priceBaggage_ret += parseInt($(this).val());
            });

            var rettotalprice = parseInt($("#hdrettotalprice").val());// tong gia tien luot ve
            var rettotalprice_incbag = priceBaggage_ret + rettotalprice;

            $("#amounttotal").text(formatNumber(deptotalprice_incbag + rettotalprice_incbag, decimals, dec_point, thousands_sep));
        }
        else{
            $("#amounttotal").text(formatNumber(deptotalprice_incbag, decimals, dec_point, thousands_sep));
        }
    });

    $(".ret_addbaggage").change(function(){
        var priceBaggage = 0; // gia hanh ly luot di
        $(".dep_addbaggage").each(function(){
            priceBaggage += parseInt($(this).val());
        });

        var deptotalprice = parseInt($("#hddeptotalprice").val()); // tong gia tien luot di
        var deptotalprice_incbag = priceBaggage + deptotalprice; //tong gia tien luot di bao gom tien hanh ly


        var priceBaggage_ret = 0; // gia hanh ly luot ve
        $(".ret_addbaggage").each(function(){
            priceBaggage_ret += parseInt($(this).val());
        });

        $("#ret_pricebaggage").text(formatNumber(priceBaggage_ret, decimals, dec_point, thousands_sep)); // in gia hanh ly luot ve

        var rettotalprice = parseInt($("#hdrettotalprice").val());// tong gia tien luot ve
        var rettotalprice_incbag = priceBaggage_ret + rettotalprice;

        // in tong gia tien luot ve
        $("#ret_total").text(formatNumber(rettotalprice_incbag, decimals, dec_point, thousands_sep));
        $("#amounttotal").text(formatNumber(deptotalprice_incbag + rettotalprice_incbag, decimals, dec_point, thousands_sep));
    });

    $("#sm_bookingflight").click(function(){
        var error = 0;
        $(".passenger_name").each(function(index) {
            if($(this).val().length == ''){
                $(this).focus();
				$(this).css({"border":"1px solid #F00"});
                
                error++;
                return false;
            }else{
                $(".mini_err").remove();
            }
        });
        if(error > 0){
            return false;
        }
        var regEmail = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var regEmailNew = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var regexGmail = /(\W|^)[\w.+\-]*@gmail\.com(\W|$)/;
        var number = /^[0-9]+$/;
        var regexCheckPhone = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        var checkPhone2019 = /((096|097|098|032|033|034|035|036|037|038|039|090|093|070|071|072|076|078|091|094|083|084|085|087|089|099|092|056|058|095|08)+([0-9]{7})\b)/g;
        var regCheckEmail = /^\w+@[a-zA-Z]{2,}\.com$/i;
        var regCheckDuplicate = /[\\w]([\\.]?[\\w]*[\\w]){1,}@gmail.com\.com/;
        var listEmail = ['testa@gmail.com', 
                         'testaa@gmail.com',
                         'testaaa@gmail.com',
                         'testaaaa@gmail.com',
                         'testaaaaa@gmail.com',
                         'testaaaaaa@gmail.com',
                         'testaaaaaaa@gmail.com',
                         'testaaaaaaaa@gmail.com',
                         'testaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaaaaaaa@gmail.com',
                         'testaaaaaaaaaaaaaaaaa@gmail.com',
                         'testb@gmail.com',
                         'testc@gmail.com',
                         'test@gmail.com',
                         'test1010@gmail.com',
                         'test123@gmail.com',
                         'test123456@gmail.com',
                         'test123456789@gmail.com',
                         'test1234567890@gmail.com',
                         'test0123456789@gmail.com',
                         'test0123@gmail.com',
                         'test01234@gmail.com',
                         'test012@gmail.com',
                         'test013@gmail.com',
                         'test014@gmail.com',
                         'test015@gmail.com',
                         'test016@gmail.com',
                         'test017@gmail.com',
                         'test018@gmail.com',
                         'test019@gmail.com',
                         'test020@gmail.com',
                         'test111@gmail.com',
                         'test1111@gmail.com',
                         'test11111@gmail.com',
                         'test111111@gmail.com',
                         'test1111111@gmail.com',
                         'test11111111@gmail.com',
                         'test111111111@gmail.com',
                         'test1111111111@gmail.com',
                         'test11111111111@gmail.com',
                         'test111111111111@gmail.com',
                         'test1111111111111@gmail.com',
                         'test222@gmail.com',
                         'test2222@gmail.com',
                         'test22222@gmail.com',
                         'test222222@gmail.com',
                         'test2222222@gmail.com',
                         'test22222222@gmail.com',
                         'test222222222@gmail.com',
                         'test2222222222@gmail.com',
                         'test22222222222@gmail.com',
                         'test222222222222@gmail.com',
                         'test2222222222222@gmail.com',
                         
                         'nguyenvana@gmail.com',
                         'nguyenvanb@gmail.com',
                         'nguyenvanc@gmail.com',
                         'nguyenvanti@gmail.com',
                         'levanc@gmail.com',
                         'a@gmail.com',
                         'aa@gmail.com',
                         'aaa@gmail.com',
                         'aaaa@gmail.com',
                         'aaaaa@gmail.com',
                         'aaaaaa@gmail.com',
                         'aaaaaaa@gmail.com',
                         'aaaaaaaa@gmail.com',
                         'aaaaaaaaa@gmail.com',
                         'aaaaaaaaaa@gmail.com',
                         'aaaaaaaaaaa@gmail.com',
                         'aaaaaaaaaaaa@gmail.com',
                         'aaaaaaaaaaaaa@gmail.com',
                         'aaaaaaaaaaaaaa@gmail.com',
                         'aaaaaaaaaaaaaaa@gmail.com',
                         'aaaaaaaaaaaaaaaa@gmail.com',
                         'abc@gmail.com',
                         'abcd@gmail.com',
                         'abcde@gmail.com',
                         'abcdef@gmail.com',
                         'abc123@gmail.com',
                         'abc456@gmail.com',
                         'abc789@gmail.com',
                         'abc123456789@gmail.com',
                         'abc0123456789@gmail.com',
                         'abc1234567890@gmail.com',
                         'abc456789123d@gmail.com',
                         'abc4561230@gmail.com',
                         'cde@gmail.com',
                         'def@gmail.com',

                        ];
        // var i;
        // var text = "";
        // for (i = 0; i < listEmail.length; i++) {
        //     text = listEmail[i];
        //     if($("#contact_email").val() == text) {
        //         $("#contact_email").css({"border":"1px solid #F00"});
        //         $("#contact_email").focus();
        //         $("#err_info").html('Vui lòng nhập Gmail chính xác.');
        //         $("#err_info").fadeIn();
        //         return false;
        //     }
        // }

        if($("#contact_name").val() == ''){
            $("#contact_name").css({"border":"1px solid #F00"});
            $("#contact_name").focus();
            $("#err_info").html('Vui lòng nhập Họ và tên.');
            $("#err_info").fadeIn();
            return false;
        }
        if($("#contact_phone").val() == '') {
            $("#contact_phone").css({"border":"1px solid #F00"});
            $("#contact_phone").focus();
            $("#err_info").html('Vui lòng nhập Số điện thoại');
            $("#err_info").fadeIn();
            return false;
        }
        if($("#contact_phone").val().length < 9 || !$("#contact_phone").val().match(number) || !regexCheckPhone.test($("#contact_phone").val())){
            $("#contact_phone").css({"border":"1px solid #F00"});
            $("#contact_phone").focus();
            $("#err_info").html('Vui lòng nhập Số điện thoại chính xác.');
            $("#err_info").fadeIn();
            return false;
        }
        if($("#contact_email").val() == '') {
            return true;
        }
        if(regEmail.test($("#contact_email").val()) == false || regEmailNew.test($("#contact_email").val() == false)){
            $("#contact_email").css({"border":"1px solid #F00"});
            $("#contact_email").focus();
            $("#err_info").html('Vui lòng nhập Gmail chính xác.');
            $("#err_info").fadeIn();
            return false;
        }
        /*if($("#contact_email").val() == '' || regEmail.test($("#contact_email").val()) == false){
            $("#contact_email").css({"border":"1px solid #F00"});
            $("#contact_email").focus();
            $("#err_info").html('Vui lòng nhập Email chính xác.');
            $("#err_info").fadeIn();
            return false;
        }*/
        /*if($("#contact_city").val() == ''){
            $("#contact_city").css({"border":"1px solid #F00"});
            $("#contact_city").focus();
            $("#err_info").html('Thông tin thành phố không được bỏ trống.');
            $("#err_info").fadeIn();
            return false;
        }
        if($("#contact_address").val() == ''){
            $("#contact_address").css({"border":"1px solid #F00"});
            $("#contact_address").focus();
            $("#err_info").html('Thông tin địa chỉ không được bỏ trống.');
            $("#err_info").fadeIn();
            return false;
        }*/

        
    });
	
	/*************************
		INTER FLIGHT SEARCH
	 *************************/
	if($('.inter-view-outbound-detail').length){
		$('.inter-view-outbound-detail').click(function(e){
			var is_collapse = $(this).hasClass('collapse');
			if(is_collapse){
				$('.inter-outbound').hide();
				$(this).removeClass('collapse');
			} else {
				$('.inter-outbound').show();
                $(this).addClass('collapse');
			}
			e.preventDefault();
		});
	}
	
	if($('.inter-view-inbound-detail').length){
		$('.inter-view-inbound-detail').click(function(e){
			var is_collapse = $(this).hasClass('collapse');
			if(is_collapse){
				$('.inter-inbound').hide();
				$(this).removeClass('collapse');
			} else {
				$('.inter-inbound').show();
				$(this).addClass('collapse');
			}
			e.preventDefault();
		});
	}
	
});

$(document).ready(function() { 
    $("#sm_bookingflight").click(function() { 
        var error = 0;
        /* CHECK QUÝ DANH */

        $(".passenger_title").each(function(index) {
            if($(this).val().length == ''){
                $(this).focus();
				$(this).css({"border":"1px solid #F00"});
                error++;
                return false;
            }else{
                $(".mini_err").remove();
            }
        });

        /* CHECK HAPPY BIRTHDAY */

        $(".birthday").each(function(index) {
            if($(this).val().length == ''){
                $(this).focus();
				$(this).css({"border":"1px solid #F00"});
                error++;
                return false;
            }else{
                $(".mini_err").remove();
            }
        });

        $(".birthmonth").each(function(index) {
            if($(this).val().length == ''){
                $(this).focus();
				$(this).css({"border":"1px solid #F00"});
                error++;
                return false;
            }else{
                $(".mini_err").remove();
            }
        });

        $(".birthyear").each(function(index) {
            if($(this).val().length == ''){
                $(this).focus();
				$(this).css({"border":"1px solid #F00"});
                error++;
                return false;
            }else{
                $(".mini_err").remove();
            }
        });


        if(error > 0){
            return false;
        }

        if($("input[name='passenger_name[]']").val() == '') {
            $("#passenger_name").css({"border":"1px solid #F00"});
            $("#passenger_name").focus();
            $("#err_info").html('Vui lòng nhập họ tên');
            $("#err_info").fadeIn();
            return false;
        }

        if($("#contact_title").val() == ''){
            $("#contact_title").css({"border":"1px solid #F00"});
            $("#contact_title").focus();
            $("#err_info").html('Vui lòng chọn giới tính hoặc quý danh');
            $("#err_info").fadeIn();
            return false;
        }
    }); 
}); 




function convertVietnameseUnmark(str) {
    var str;
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g);
    return str;
}
function removeAccents(str) {
  var AccentsMap = [
    "aàảãáạăằẳẵắặâầẩẫấậ",
    "AÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬ",
    "dđ", "DĐ",
    "eèẻẽéẹêềểễếệ",
    "EÈẺẼÉẸÊỀỂỄẾỆ",
    "iìỉĩíị",
    "IÌỈĨÍỊ",
    "oòỏõóọôồổỗốộơờởỡớợ",
    "OÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢ",
    "uùủũúụưừửữứự",
    "UÙỦŨÚỤƯỪỬỮỨỰ",
    "yỳỷỹýỵ",
    "YỲỶỸÝỴ"    
  ];
  for (var i=0; i<AccentsMap.length; i++) {
    var re = new RegExp('[' + AccentsMap[i].substr(1) + ']', 'g');
    var char = AccentsMap[i][0];
    str = str.replace(re, char);
  }
  return str;
}
function removeAccentsVN(str) {
  return str.normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd').replace(/Đ/g, 'D');
}
function validateCheckPassengerName() {
	// $('#passenger_name').val("");
    var contactName = document.getElementById("passenger_name").value;

    var changeTextUnicode = removeAccentsVN(contactName);
    document.getElementById("passenger_name").value = changeTextUnicode;
}
function validateCheckContactName() {
	// $('#contact_name').val("");
    var contactName = document.getElementById("contact_name").value;
    var changeTextUnicode = removeAccentsVN(contactName);
    document.getElementById("contact_name").value = changeTextUnicode;
}
