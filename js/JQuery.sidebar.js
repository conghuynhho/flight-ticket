/**
 * Created with JetBrains PhpStorm.
 * User: Lak
 * Date: 8/5/13
 * Time: 3:45 PM
 * To change this template use File | Settings | File Templates.
 */

var wgsearchFormObj;

$(document).ready(function(){
	wgsearchFormObj = $("#wgsform");
	
	var wgflighttab =  document.getElementById('wgflighttab');
	if (typeof(wgflighttab) != 'undefined' && wgflighttab != null)
	{
    format_input_date_lunar($("#wgdepdate"));
    format_input_date_lunar($("#wgretdate"));
	show_lunar_description_text( $("#wgdepdate").val(), $(".search-start-date-lunar-des") );
    show_lunar_description_text( $("#wgretdate").val(), $(".search-return-date-lunar-des") );
	}
	
	$('#wgsform input[type!="radio"]').on('change',function(){
	 if($(".wgdirection:checked").val()==0){
	auto_focus(this);}
	});
	 if($(".wgdirection:checked").val()==1)
        $("#wgretdate").attr("disabled","disabled");
    else
        $("#wgretdate").removeAttr("disabled");

 
    $(".wgdirection").click(function(){
        flighttype=$(this).val();
        if(flighttype==1){
            $("#wgretdate").attr("disabled","disabled");
        }else{
            $("#wgretdate").removeAttr("disabled");
        }
    });
	
 

 	if($(".wgdirection:checked").val()==1){
		var default_max_date = $("#wgdepdate").attr("default_max_date");
		 
		 str_day = default_max_date.substring(0,default_max_date.indexOf("/"));
			str_month = default_max_date.substring(default_max_date.indexOf("/")+1);
			str_month = str_month.substring(0,str_month.indexOf("/"));
			str_year = default_max_date.substring(default_max_date.lastIndexOf("/")+1);
			var setMaxdate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
		
		$("#wgdepdate").datepickerlunar( "option", "maxDate", setMaxdate );
	}
    else{
  		maxDate = $("#wgretdate").val();
		$("#wgdepdate").datepickerlunar( "option", "maxDate", setMaxdate );
	}	
	
	    $("#wgdepdate").datepickerlunar({
		onSelect: function( selectedDate) {
            if($(".wgdirection:checked").val()==0)
                $( "#wgretdate" ).datepickerlunar( "option", "minDate", selectedDate );
        }, 
        onClose: function( selectedDate) {
            if($(".wgdirection:checked").val()==0)
				$( "#wgretdate" ).datepickerlunar("show");
            return false;
            //console.log(selectedDate);
        }
    });
	 $("#wgretdate").datepickerlunar({
        beforeShow:function(){
            var deptime = $( "#wgdepdate" ).val();
			if(deptime==""){
                $("#wgdepdate").datepickerlunar("show");
                return false;
            }else{
                $("#wgretdate").datepickerlunar("option", "minDate",$("#wgdepdate").val() );
            }
        }
    });
	
	
	$("#wgsform form").submit(function(e){
	
        
        //e.preventDefault();
        var deptime = $("#wgdepdate" ).val();
        if(deptime==""){
            $("#wgdepdate").datepickerlunar("show");
            return false;
        }
        else{
            if($(".wgdirection:checked").val()== 0){
                arvtime= $("#wgretdate").val();
				//alert(arvtime);
                if(arvtime=='--/--/----'){
                    $("#wgretdate").datepickerlunar("show");
                    return false;
                }
				 
            }
        }
		

        if($("#wgdep").val() == $("#wgdes").val()){
            alert("Nơi đi không được trùng nơi đến")
            return false;
        }

        return true;
    });

		
});

function auto_focus(elm){
	var next = $(elm).data('next') || false;
	if(next){
		setTimeout(function(){
			$(next).focus();
		},500);
	}				
} 
 
 
function format_input_date_lunar(obj){
    try{
        var yearRange = obj.attr("yearRange");
        var maxDate = obj.attr("maxDate");
        var minDate = obj.attr("minDate");
        var after_function = obj.attr("after_function");
        
        var option = {
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            numberOfMonths: 1
        };
        
        if(yearRange!='' && yearRange!=undefined){
            option["yearRange"] = yearRange;
        }
		if(minDate!='' && minDate!=undefined){
			if( minDate.length == 10 && minDate.indexOf("/") > 0 ){
				str_day = minDate.substring(0,minDate.indexOf("/"));
				str_month = minDate.substring(minDate.indexOf("/")+1);
				str_month = str_month.substring(0,str_month.indexOf("/"));
				str_year = minDate.substring(minDate.lastIndexOf("/")+1);
				var setMinDate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
				option["minDate"] = setMinDate;
			}
        }
		
        if(after_function!='' && after_function!=undefined){
            option["onSelect"] = function( selectedDate ) {
                var fn = window[after_function];
                fn(obj);
            };
			option["onClose"]= function(dateText, inst) {
				  $(this).trigger('change');
				
			}; 
			 
			
        }
		
        obj.datepickerlunar(option);
        obj.attr("formated_datepicker","true");
		
		return false;
    }
    catch(err){
        //alert(err);
    }
	
}

function change_start_date(){
	try{
		minDate = $("#wgdepdate").val();
		current_return_date = $("#wgretdate").val();
		
		if(current_return_date==$("#wgretdate").attr("default")){
			$("#wgretdate").val(current_return_date);
		}
		
		if($("#wgdepdate").hasClass("date_active")==false){
			$("#wgdepdate").addClass("date_active");
		}
		
		current_start_date = $("#wgdepdate").val();
		if( current_start_date.length == 10 && current_start_date.indexOf("/") > 0 ){
			str_day = current_start_date.substring(0,current_start_date.indexOf("/"));
			str_month = current_start_date.substring(current_start_date.indexOf("/")+1);
			str_month = str_month.substring(0,str_month.indexOf("/"));
			str_year = current_start_date.substring(current_start_date.lastIndexOf("/")+1);
			var setMinDate2 = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
			$("#wgretdate").datepickerlunar( "option", "minDate", setMinDate2 );
			
		}
		
		$("#wgretdate").val(current_return_date);
		//alert($("#wgretdate").val());
	 
		show_lunar_description_text( $("#wgdepdate").val(), $(".search-start-date-lunar-des") );
	}
	catch(err){
		//alert(err);
	}
}
function change_return_date(){
    maxDate = $("#wgretdate").val();
	/*
	if(maxDate!='' && maxDate!=undefined){
		if( maxDate.length == 10 && maxDate.indexOf("/") > 0 ){
			str_day = maxDate.substring(0,maxDate.indexOf("/"));
			str_month = maxDate.substring(maxDate.indexOf("/")+1);
			str_month = str_month.substring(0,str_month.indexOf("/"));
			str_year = maxDate.substring(maxDate.lastIndexOf("/")+1);
			var setMaxdate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
			$("#start_date").datepickerlunar( "option", "maxDate", setMaxdate );
		}
	}
	*/
	if($("#wgretdate").hasClass("date_active")==false){
        $("#wgretdate").addClass("date_active");
    }
	
		 
	show_lunar_description_text( $("#wgretdate").val(), $(".search-return-date-lunar-des") );
}

function show_lunar_description_text(input_date,target_obj){
    if( input_date.length != 10 || input_date == undefined || input_date == '--/--/----' ){
        target_obj.hide();
		target_obj.find(".text").html("");
    }
	else{
		target_obj.show();
		var departureDate = GetDateString(parseInt( input_date.split('/')[0] ), parseInt( input_date.split('/')[1] ), parseInt( input_date.split('/')[2] ));
		target_obj.find(".text").html(departureDate);
	}
}

  


/*Hotel*/
$(document).ready(function(){
 
	
	var wghoteltab =  document.getElementById('wghoteltab');
	if (typeof(wghoteltab) != 'undefined' && wghoteltab != null)
	{
		format_input_date_lunar($("#start"));
		format_input_date_lunar($("#end"));
		show_lunar_description_text($("#start").val(), $(".checkin-date-lunar-des"));
		show_lunar_description_text($("#end").val(), $(".checkout-date-lunar-des"));
	}
	
	$("#wghoteltab form").submit(function(e) {
		var hotel_destination =$("#hotel_destination").val();
		if (hotel_destination == "") {
            $("#hotel_destination").css({"border":"1px solid #F00"});
            $("#hotel_destination").focus();
            return false;
		}
 
        var deptime = $("#start").val();
		var arvtime = $("#end").val();
			
	    if (deptime == "") {
            $("#start").datepickerlunar("show");
			return false;
        } else {
			if (arvtime == '--/--/----' || deptime > arvtime) {
				$("#end").datepickerlunar("show");
				return false;
			}
            return true;
        }
		 
         return true;
    })
	
});	

function change_checkin_date() {
    try {
        minDate = $("#start").val();
        current_return_date = $("#end").val();

        if (current_return_date == $("#end").attr("default")) {
            $("#end").val(current_return_date);
        }

        if ($("#start").hasClass("date_active") == false) {
            $("#start").addClass("date_active");
        }

        current_start_date = $("#start").val();
        if (current_start_date.length == 10 && current_start_date.indexOf("/") > 0) {
            str_day = current_start_date.substring(0, current_start_date.indexOf("/"));
            str_month = current_start_date.substring(current_start_date.indexOf("/") + 1);
            str_month = str_month.substring(0, str_month.indexOf("/"));
            str_year = current_start_date.substring(current_start_date.lastIndexOf("/") + 1);
            var setMinDate2 = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
            $("#end").datepickerlunar("option", "minDate", setMinDate2);

        }

        $("#end").val(current_return_date);
        //alert($("#retdate").val());
        show_lunar_description_text($("#start").val(), $(".checkin-date-lunar-des"));
    } catch (err) {
        //alert(err);
    }
}

function change_checkout_date() {
    maxDate = $("#end").val();
     if ($("#end").hasClass("date_active") == false) {
        $("#end").addClass("date_active");
    }
   show_lunar_description_text($("#end").val(), $(".checkout-date-lunar-des"));
}
 
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.fa")
        .toggleClass('fa-sort-desc fa-sort-up');
}
$('#accordion').on('hidden.bs.collapse', toggleChevron);
$('#accordion').on('shown.bs.collapse', toggleChevron);

/* CHỌN NƠI ĐI NƠI ĐẾN */
$(document).ready(function(){ 
	
	$("#wgdep").on("change", function() {
	    $("#wgdepcode").val($("#wgdep").val());
	}).trigger("change");

	$("#wgdes").on("change", function() {
	    $("#wgarvcode").val($("#wgdes").val());
	}).trigger("change");
	
});