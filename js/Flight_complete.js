/**
 *	HOAN TAT DON HANG
 */
$(document).ready(function() {
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
/**
 * Created with JetBrains PhpStorm.
 * User: Lak
 * Date: 8/5/13
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */
 
/**
* LUNAR CALENDER
*/

var searchFormObj;
$(document).ready(function() {
    searchFormObj = $("#frmBooking");
    format_input_date_lunar($("#pickupDate"));
    format_input_date_lunar($("#dropoffDate"));
    //show_lunar_description_text($("#pickupDate").val(), $(".search-start-date-lunar-des"));
    //show_lunar_description_text($("#dropoffDate").val(), $(".search-return-date-lunar-des"));

    
 
    $("#pickupDate").datepickerlunar({
        onSelect: function(selectedDate) {
                $("#dropoffDate").datepickerlunar("option", "minDate", selectedDate);
        },
        onClose: function(selectedDate) {
                $("#dropoffDate").datepickerlunar("show");
			return false;
            //console.log(selectedDate);
        }
    });

    $("#dropoffDate").datepickerlunar({
        beforeShow: function() {
            var deptime = $("#pickupDate").val();
            if (deptime == "") {
                $("#pickupDate").datepickerlunar("show");
                return false;
            } else {
                $("#dropoffDate").datepickerlunar("option", "minDate", $("#pickupDate").val());
            }
        }
    });

 	$('#BtnSearch').click(function(){
	if($("#cusPhone").val() == '')
		{
			$("#cusPhone").addClass("error");
			$("#cusPhone").focus();
			return false;
		}else{
			var number = /^[0-9]+$/;  
			if($("#cusPhone").val().length < 10 || !$("#cusPhone").val().match(number)){
				$("#cusPhone").addClass("error");
				$("#cusPhone").focus();
				return false;
			}else{
				$("#cusPhone").removeClass("error");
				 
			}
		}
		
		if($("#pickupLocation").val() == ''){
			$("#pickupLocation").addClass("error");
			$("#pickupLocation").focus();
			return false;
		}else{
			$("#pickupLocation").removeClass("error");
		}
		 
		if($("#dropoffLocation").val() == ''){
			$("#dropoffLocation").addClass("error");
			$("#dropoffLocation").focus();
			return false;
		}else{
			$("#dropoffLocation").removeClass("error");
		}
		 
		var pickDate = $("#pickupDate").val();
		var dropoffDate = $("#dropoffDate").val();
		var pickTime = $("#pickupTime").val();
		var dropoffTime = $("#dropoffTime").val();
		// alert(pickTime);
		if(pickDate === dropoffDate){
		
			if(pickTime >= dropoffTime){
				alert("Vui lòng chọn lại thời gian");
				return false;
			} 
		}	 
        
        //e.preventDefault();
        var deptime = $("#pickupDate").val();
        if (deptime == "") {
            $("#pickupDate").datepickerlunar("show");
            return false;
        } else {
                 arvtime = $("#dropoffDate").val();
                //alert(arvtime);
                if (arvtime == '--/--/----' || deptime > arvtime) {
                    $("#dropoffDate").datepickerlunar("show");
                    return false;
                }
            //    return true;
        }
		
		$.ajax({
				type: "POST",
				url: $("#frmBooking").attr('action'),
				data:$('#frmBooking').serialize(),
				cache:false,
				beforeSend: function () {
					  $('.notice-success').show('fast');
				} 
			}); 
	    return true;
    })
	$('#frmBooking').submit(function(){
            $(':submit', this).click(function() {
                return false;
            });
        });	
	 
 
});
 
function change_pickup_date() {
    try {
        minDate = $("#pickupDate").val();
        current_return_date = $("#dropoffDate").val();

        if (current_return_date == $("#dropoffDate").attr("default")) {
            $("#dropoffDate").val(current_return_date);
        }

        if ($("#pickupDate").hasClass("date_active") == false) {
            $("#pickupDate").addClass("date_active");
        }

        current_start_date = $("#pickupDate").val();
        if (current_start_date.length == 10 && current_start_date.indexOf("/") > 0) {
            str_day = current_start_date.substring(0, current_start_date.indexOf("/"));
            str_month = current_start_date.substring(current_start_date.indexOf("/") + 1);
            str_month = str_month.substring(0, str_month.indexOf("/"));
            str_year = current_start_date.substring(current_start_date.lastIndexOf("/") + 1);
            var setMinDate2 = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
            $("#dropoffDate").datepickerlunar("option", "minDate", setMinDate2);

        }

        $("#dropoffDate").val(current_return_date);
        //alert($("#dropoffDate").val());
       // show_lunar_description_text($("#pickupDate").val(), $(".search-start-date-lunar-des"));
    } catch (err) {
        //alert(err);
    }
}

function change_dropoff_date() {
    maxDate = $("#dropoffDate").val();
    /*
    if(maxDate!='' && maxDate!=undefined){
    	if( maxDate.length == 10 && maxDate.indexOf("/") > 0 ){
    		str_day = maxDate.substring(0,maxDate.indexOf("/"));
    		str_month = maxDate.substring(maxDate.indexOf("/")+1);
    		str_month = str_month.substring(0,str_month.indexOf("/"));
    		str_year = maxDate.substring(maxDate.lastIndexOf("/")+1);
    		var setMaxdate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
    		$("#pickupDate").datepickerlunar( "option", "maxDate", setMaxdate );
    	}
    }
    */
    if ($("#dropoffDate").hasClass("date_active") == false) {
        $("#dropoffDate").addClass("date_active");
    }

   // show_lunar_description_text($("#dropoffDate").val(), $(".search-return-date-lunar-des"));
}

 
  function toggle_visibility(id) {
       var e = document.getElementById(id);
	   if(e.style.display == 'block')
          e.style.display = 'none';
		else
          e.style.display = 'block';
		
};
$(document).ready(function() {
	$('.nav-toggle').click(function(){
		//get collapse content selector
		var collapse_content_selector = $(this).attr('href');					
		
		//make the collapse content to be shown or hide
		var toggle_switch = $(this);
		$(collapse_content_selector).toggle(function(){
			if($(this).css('display')=='none'){
				toggle_switch.html('Bạn muốn sử dụng dịch vụ <br><b>XE ĐƯA ĐÓN SÂN BAY? <span class="sm_search_flight">ĐĂNG KÝ NGAY</span>');//change the button label to be 'Show'
			}else{
				toggle_switch.html('<b style="margin-top:10px; display:block;">DỊCH VỤ ĐƯA ĐÓN SÂN BAY</b>');//change the button label to be 'Hide'
			}
		});
	});
	
});

 
     
 
