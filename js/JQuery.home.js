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
    searchFormObj = $("#frmFlightSearch");
	var flighttab =  document.getElementById('flighttab');
	if (typeof(flighttab) != 'undefined' && flighttab != null)
	{
    format_input_date_lunar($("#depdate"));
    format_input_date_lunar($("#retdate"));
    show_lunar_description_text($("#depdate").val(), $(".search-start-date-lunar-des"));
    show_lunar_description_text($("#retdate").val(), $(".search-return-date-lunar-des"));
	}
    $('#frmFlightSearch input[type!="radio"]').on('change', function() {
        if ($(".rdbdirection:checked").val() == 0) {
            auto_focus(this);
        }
    });

 
    $(".rdbdirection").click(function() {

        flighttype = $(this).val();
        if (flighttype == 1) {
            $("#retdate").attr("disabled", "disabled");
        } else {
            $("#retdate").removeAttr("disabled");
        }
    });

    if ($(".rdbdirection:checked").val() == 1) {
        var default_max_date = $("#depdate").attr("default_max_date");

        str_day = default_max_date.substring(0, default_max_date.indexOf("/"));
        str_month = default_max_date.substring(default_max_date.indexOf("/") + 1);
        str_month = str_month.substring(0, str_month.indexOf("/"));
        str_year = default_max_date.substring(default_max_date.lastIndexOf("/") + 1);
        var setMaxdate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));

        $("#depdate").datepickerlunar("option", "maxDate", setMaxdate);
		$("#retdate").attr("disabled", "disabled");
    } else {
        maxDate = $("#retdate").val();
        $("#depdate").datepickerlunar("option", "maxDate", setMaxdate);
		 $("#retdate").removeAttr("disabled");
    }

    $("#depdate").datepickerlunar({
        onSelect: function(selectedDate) {
            if ($(".rdbdirection:checked").val() == 0)
                $("#retdate").datepickerlunar("option", "minDate", selectedDate);
        },
        onClose: function(selectedDate) {
            if ($(".rdbdirection:checked").val() == 0)
                $("#retdate").datepickerlunar("show");
            return false;
            //console.log(selectedDate);
        }
    });

    $("#retdate").datepickerlunar({
        beforeShow: function() {
            var deptime = $("#depdate").val();
            if (deptime == "") {
                $("#depdate").datepickerlunar("show");
                return false;
            } else {
                $("#retdate").datepickerlunar("option", "minDate", $("#depdate").val());
            }
        }
    });

    //
    $("#tab1-arv ul li.tcb-hot-city-box-item").removeAttr("style");


    $("#frmFlightSearch").submit(function(e) {

        if ($("#des").val() == "") {
            $("#listDes").fadeIn("fast");
            return false;
        }
        //e.preventDefault();
        var deptime = $("#depdate").val();
        if (deptime == "") {
            $("#depdate").datepickerlunar("show");
            return false;
        } else {
            if ($(".rdbdirection:checked").val() == 0) {
                arvtime = $("#retdate").val();
                //alert(arvtime);
                if (arvtime == '--/--/----') {
                    $("#retdate").datepickerlunar("show");

                    return false;
                }
                return true;
            }
        }


        if ($("#dep").val() == $("#des").val()) {
            alert("Nơi đi không được trùng nơi đến")
            return false;
        }

        return true;
    })

	  $("#swap_srp").click(function(){
         var di=$("#dep").val();
        var tmpdi=$("#depinput").val();

        $("#dep").val($("#des").val());
        $("#des").val(di);

        $("#depinput").val($("#desinput").val());
        $("#desinput").val(tmpdi);


        /*$("#dep option[value="+toi+"]").prop("selected", true);
        $("#des option[value="+di+"]").prop("selected", true);*/
        return false;
    })


    /*Process Select City*/

    $("#depinput").click(function() {
        $("#listDep").fadeIn("fast");
        $(this).select();
    })
    $("#desinput").click(function() {
        $("#listDes").fadeIn("fast");
        $(this).select();
    })

    $("body").click(function(e) {
        if ($.trim($(e.target).closest("#listDep").html()) == '' && !$(e.target).is("#depinput") && !$(e.target).is(".ui-corner-all")) {
            if ($("#listDep").is(":visible"))
                $("#listDep").hide();
        }
        if ($.trim($(e.target).closest("#listDes").html()) == '' && !$(e.target).is("#desinput") && !$(e.target).is(".ui-corner-all")) {
            if ($("#listDes").is(":visible"))
                $("#listDes").hide();
        }
    })

    $("#listDep li a").click(function() {
        $("#depinput").val($(this).text());
        $("#dep").val($(this).attr("data-city"));

        if ($("#dep").val() == $("#des").val()) {
            $("#desinput").val("");
            $("#des").val("");
        }
        $("#listDes li").show();
        // var depcity = $("#dep").val();
        // $("#listDes a[data-city=" + depcity + "]").parent().hide();

        $("#listDep").fadeOut("fast");
        $("#listDes").fadeIn("fast");
        $("#tab1-arv ul li.tcb-hot-city-box-item").removeAttr("style");
        $("#desinput").select();
        return false;
    })

    $("#listDes li a").click(function() {
        arvplace = $(this).attr("data-city");
        if (arvplace == $("#dep").val()) {
            alert("Điểm đi và điểm đến không được trùng!!")
        } else {
            $("#desinput").val($(this).text());
            $("#listDes").find(".err").text("");
            $("#des").val($(this).attr("data-city"));
            $("#listDes").fadeOut("fast");
            $("#depdate").datepickerlunar("show");
        }
        return false;
    })


    /*End Process Select City*/
});

function auto_focus(elm) {
    var next = $(elm).data('next') || false;
    if (next) {
        setTimeout(function() {
            $(next).focus();
        }, 500);
    }
}


function format_input_date_lunar(obj) {
    try {
        var yearRange = obj.attr("yearRange");
        var maxDate = obj.attr("maxDate");
        var minDate = obj.attr("minDate");
        var after_function = obj.attr("after_function");
        var month=2;
        if($(window).width()<768){
            month=1;
        }
        var option = {
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            numberOfMonths: month
        };

        if (yearRange != '' && yearRange != undefined) {
            option["yearRange"] = yearRange;
        }
        if (minDate != '' && minDate != undefined) {
            if (minDate.length == 10 && minDate.indexOf("/") > 0) {
                str_day = minDate.substring(0, minDate.indexOf("/"));
                str_month = minDate.substring(minDate.indexOf("/") + 1);
                str_month = str_month.substring(0, str_month.indexOf("/"));
                str_year = minDate.substring(minDate.lastIndexOf("/") + 1);
                var setMinDate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
                option["minDate"] = setMinDate;
            }
        }

        if (after_function != '' && after_function != undefined) {
            option["onSelect"] = function(selectedDate) {
                var fn = window[after_function];
                fn(obj);
            };
            option["onClose"] = function(dateText, inst) {
                $(this).trigger('change');

            };


        }

        obj.datepickerlunar(option);
        obj.attr("formated_datepicker", "true");

        return false;
    } catch (err) {
        //alert(err);
    }
}

change_start_date();

function change_start_date() {
    try {
        minDate = $("#depdate").val();
        $("#datefrom").val(minDate);
        current_return_date = $("#retdate").val();

        if (current_return_date == $("#retdate").attr("default")) {
            $("#retdate").val(current_return_date);
        }

        if ($("#depdate").hasClass("date_active") == false) {
            $("#depdate").addClass("date_active");
        }

        current_start_date = $("#depdate").val();
        if (current_start_date.length == 10 && current_start_date.indexOf("/") > 0) {
            str_day = current_start_date.substring(0, current_start_date.indexOf("/"));
            str_month = current_start_date.substring(current_start_date.indexOf("/") + 1);
            str_month = str_month.substring(0, str_month.indexOf("/"));
            str_year = current_start_date.substring(current_start_date.lastIndexOf("/") + 1);
            var setMinDate2 = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
            $("#retdate").datepickerlunar("option", "minDate", setMinDate2);

        }

        $("#retdate").val(current_return_date);
        //alert($("#retdate").val());
        show_lunar_description_text($("#depdate").val(), $(".search-start-date-lunar-des"));
    } catch (err) {
        //alert(err);
    }
}

change_return_date();

function change_return_date() {
    maxDate = $("#retdate").val();
    $("#dateto").val(maxDate);
    /*
    if(maxDate!='' && maxDate!=undefined){
    	if( maxDate.length == 10 && maxDate.indexOf("/") > 0 ){
    		str_day = maxDate.substring(0,maxDate.indexOf("/"));
    		str_month = maxDate.substring(maxDate.indexOf("/")+1);
    		str_month = str_month.substring(0,str_month.indexOf("/"));
    		str_year = maxDate.substring(maxDate.lastIndexOf("/")+1);
    		var setMaxdate = new Date(parseInt(str_year), parseInt(str_month) - 1, parseInt(str_day));
    		$("#depdate").datepickerlunar( "option", "maxDate", setMaxdate );
    	}
    }
    */
    if ($("#retdate").hasClass("date_active") == false) {
        $("#retdate").addClass("date_active");
    }

    show_lunar_description_text($("#retdate").val(), $(".search-return-date-lunar-des"));
}

function show_lunar_description_text(input_date, target_obj) {
    if (input_date.length != 10 || input_date == undefined || input_date == '--/--/----') {
        target_obj.hide();
        target_obj.find(".text").html("");
    } else {
        target_obj.show();
        var departureDate = GetDateString(parseInt(input_date.split('/')[0]), parseInt(input_date.split('/')[1]), parseInt(input_date.split('/')[2]));
        target_obj.find(".text").html(departureDate);
    }
}
  
$(document).ready(function(){
  
	/**
	 * INTER FLIGHT SEARCH AUTOCOMPLETE
	 */
	if($("#inter-city-dep").length){
	
		$("#inter-city-dep").autocomplete({
			source: myvar.siteurl+"/get-airportcode",
			minLength: 3,
			response: function(event, ui) {
				if (ui.content.length === 0) {
				}
			},
			select: function( event, ui ) {
				$("#depinput").val(ui.item.label);
				$("#dep").val(ui.item.code);
				$("#listDep").fadeOut("fast");
				setTimeout(function(){$("#listDes").fadeIn("fast");$("#inter-city-arv").select();},100)
			}
		}).autocomplete('widget').removeClass('ui-corner-all');
	}
	
	if($("#inter-city-arv").length){
	
		$("#inter-city-arv").autocomplete({
			source: myvar.siteurl+"/get-airportcode",
			minLength: 3,
			response: function(event, ui) {
				if (ui.content.length === 0) {
				}
			},
			select: function( event, ui ) {
				if(ui.item.code==$("#dep").val()){
					alert("Điểm đi và điểm đến không được trùng!!")
				}else{
					$("#desinput").val(ui.item.label);
					$("#des").val(ui.item.code);
					$("#listDes").fadeOut("fast");
					setTimeout(function(){$( "#depdate" ).datepicker("show");},100)
				}
			}
		}).autocomplete('widget').removeClass('ui-corner-all');
	}
    /*End Process Select City*/
 
	/*** By: LuongQC - date: 20140615 ***/
	// $('#source, #destination').change(function(){
	// 	$('#frmFlightSearch input:hidden[id="dep"]').val($('#source :selected').val());
	// 	$('#frmFlightSearch input:hidden[id="des"]').val($('#destination :selected').val());
	// });
    /*End Process Select City*/
  //new WOW().init();
});

 


/*Hotel*/
$(document).ready(function(){
	var hoteltab =  document.getElementById('hoteltab');
	if (typeof(hoteltab) != 'undefined' && hoteltab != null)
	{
	format_input_date_lunar($("#start"));
    format_input_date_lunar($("#end"));
    show_lunar_description_text($("#start").val(), $(".checkin-date-lunar-des"));
    show_lunar_description_text($("#end").val(), $(".checkout-date-lunar-des"));
	}
	 
	$("#hoteltab form").submit(function(e) {
		var hotel_destination =$("#hotel_destination").val();
		if (hotel_destination == "") {
            $("#hotel_destination").css({"border":"1px solid #F00"});
            $("#hotel_destination").focus();
            return false;
		}
 
        var deptime = $("#start").val();
        if (deptime == "") {
            $("#start").datepickerlunar("show");
            return false;
        } else {
			arvtime = $("#end").val();
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

/*Rent Car*/
$(document).ready(function() {
	var cartab =  document.getElementById('cartab');
	if (typeof(cartab) != 'undefined' && cartab != null)
	{
    format_input_date_lunar($("#pickupDate"));
    format_input_date_lunar($("#dropoffDate"));
	}
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

 	$('#BtnBookCar').click(function(){
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
   
    if ($("#dropoffDate").hasClass("date_active") == false) {
        $("#dropoffDate").addClass("date_active");
    }

   // show_lunar_description_text($("#dropoffDate").val(), $(".search-return-date-lunar-des"));
}

 

	  // Owl Carousel

        var owlCarousel = $('#owl-carousel'),

            owlItems = owlCarousel.attr('data-items'),

            owlCarouselSlider = $('#owl-carousel-slider'),
			
            owlNav = owlCarouselSlider.attr('data-nav');
		
        // owlSliderPagination = owlCarouselSlider.attr('data-pagination');
	
        owlCarousel.owlCarousel({

            items: owlItems,

            navigation: true,

            navigationText: ['', '']

        });
        owlCarouselSlider.owlCarousel({

            slideSpeed: 300,

            paginationSpeed: 400,

            // pagination: owlSliderPagination,

            singleItem: true,

            navigation: true,

            navigationText: ['', ''],

            transitionStyle: 'fade',

            autoPlay: 8500,

        });

/** By Ancao **/

/* Click Selected City Mobile */

$(".button-click").click(function(){
    if (($(".go-flight-from").hasClass('open'))) {
        $(".go-flight-from").removeClass('open');
        
}
$(this).parent().addClass('open');
    if ($(window).width() < 768) {
        $("#main-header").css("display", "none"); // hidden menu
    }
});
$(".xheading .xclose").click(function () {
    
    $(".go-flight-from").removeClass("open");
    $("#main-header").css("display", "block"); // open menu
});

$(".sub-departure-mobile div .scroll-touch li a").click(function () {

    $("#depmobileinput").val($(this).text());
    $("#dep").val($(this).attr("data-city"));
    $('.direction-panel-xpanel').fadeOut();
    $(".go-flight-from").removeClass("open");
    $('html,body').animate({scrollTop: $('#wrap').offset().top},'fast');
    $("#main-header").css("display", "block"); 
    return false;
});    
$(".sub-arrival-mobile div .scroll-touch li a").click(function () {

    $("#desmobileinput").val($(this).text());
    $("#des").val($(this).attr("data-city"));
    $('.direction-panel-xpanel').fadeOut();
    $(".go-flight-from").removeClass("open");
    $('html,body').animate({scrollTop: $('#wrap').offset().top},'fast');
    $("#main-header").css("display", "block"); 
    return false;
});

/*
* Click Mobile Hidden Input Select City
*/
// if($(window).width() < 700 || $(window).width() < 352) { 
//     $("input.desktop-input[type=text]").remove();
//     $("input.desktop-input-mobile").show();
//     $(".list-airports-direction").remove();
// }
// if($(window).width() <= 1170) {
//     $("input.desktop-input[type=text]").show();
//     $("input.desktop-input-mobile").remove();
//     $(".list-airports-direction").show();
// }
// if($(window).width() <= 980) {
//     $("input.desktop-input[type=text]").remove();
//     $("input.desktop-input-mobile").show();
// }
// $(document).ready(function() {
//     $('.abc').slideDown();
//     $('.config-name-country h5').click(function(event) {
//         $(this).next().toggle();
//     });
// })

// $(window).ready(function() {
//     var wi = $(window).width();  
//     //$("p.testp").text('Initial screen width is currently: ' + wi + 'px.');
 
//     $(window).resize(function() {
//         var wi = $(window).width();
        
//         if (wi < 700 || wi < 352) {
//             $("input.desktop-input[type=text]").remove();
//             $("input.desktop-input-mobile").show();
//             $(".list-airports-direction").remove();
//         }

//         else if (wi <= 480){
//             //$("p.testp").text('Screen width is less than or equal to 480px. Width is currently: ' + wi + 'px.');
//         }
//         else if (wi <= 767){
//             //$("p.testp").text('Screen width is between 481px and 767px. Width is currently: ' + wi + 'px.');
//         }
//         else if (wi <= 980){
//             //$("p.testp").text('Screen width is between 768px and 980px. Width is currently: ' + wi + 'px.');
//             $("input.desktop-input[type=text]").remove();
//             $("input.desktop-input-mobile").show();
//         }
//         else if (wi <= 1170) {
//             $("input.desktop-input[type=text]").show();
//             $("input.desktop-input-mobile").remove();
//             $(".list-airports-direction").show();
//         }
//         else if (wi <= 1200){
//             //$("p.testp").text('Screen width is between 981px and 1199px. Width is currently: ' + wi + 'px.');
//         }
//         else {
//             //$("p.testp").text('Screen width is greater than 1200px. Width is currently: ' + wi + 'px.');
//         }
//     });            
// });

/* Search Mobile */
$(document).ready(function(){
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/inc/jsonAirport.json",
        getValue: "location",
        list: {
            onSelectItemEvent: function() {
                var name = $("#inter-city-dep-mobile").getSelectedItemData().name;
                var code = $("#inter-city-dep-mobile").getSelectedItemData().code;
                $('.direction-panel-xpanel').fadeOut();
                $(".go-flight-from").removeClass("open");
                $("#depmobileinput").val(name);
                $("#dep").val(code);
            },
            maxNumberOfElements: 15,
            match: {
                enabled: true
            }
        }
    };
    $("#inter-city-dep-mobile").easyAutocomplete(options);
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/inc/jsonAirport.json",
        getValue: "location",
        list: {
            onSelectItemEvent: function() {
                var name = $("#inter-city-arv-mobile").getSelectedItemData().name;
                var code = $("#inter-city-arv-mobile").getSelectedItemData().code;
                $('.direction-panel-xpanel').fadeOut();
                $(".go-flight-from").removeClass("open");
                $("#desmobileinput").val(name);
                $("#des").val(code);
            },
            maxNumberOfElements: 15,
            match: {
                enabled: true
            }
        }
    };
    $("#inter-city-arv-mobile").easyAutocomplete(options);
});


function mobileClickDropDown() {
    $(this).parent().next().toggleClass('active');
}

/* DESKTOP */

/* UPDATE LAYOUT */
$(document).ready(function() {
    $('.tcb-hot-city-box-close').click(function() {
        $("#listDep").hide();
        $("#listDes").hide();
    });
});

/* SEARCH AUTOCOMPLETE */
$(document).ready(function(){
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/flight_config/airport_list.json",
        getValue: function(element) {
            return element.airport_name +' '+'(' + element.airport_code + ')';
        },
        list: {
            onSelectItemEvent: function() {
                var name = $("#depinput").getSelectedItemData().airport_name;
                var code = $("#depinput").getSelectedItemData().airport_code;
                var selectCity = name +' '+'(' + code + ')';
                $("#depinput").val(selectCity);
                $("#dep").val(code);
            },
            maxNumberOfElements: 100,
            match: {
                enabled: true
            },
            sort: {
                enabled: true
            },
            highlightPhrase: true,
        }
    };
    $("#depinput").easyAutocomplete(options);
    $('#listDep .suggestion-container').hide(); 
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/flight_config/airport_list.json",
        getValue: function(element) {
            return element.airport_name +' '+'(' + element.airport_code + ')';
        },
        list: {
            onSelectItemEvent: function() {
                var name = $("#desinput").getSelectedItemData().airport_name;
                var code = $("#desinput").getSelectedItemData().airport_code;
                var selectCity = name +' '+'(' + code + ')';
                $("#desinput").val(selectCity);
                $("#des").val(code);
            },
            maxNumberOfElements: 100,
            match: {
                enabled: true
            },
            sort: {
                enabled: true
            },
            highlightPhrase: true,
        }
    };
    $("#desinput").easyAutocomplete(options);
    $('#listDes .suggestion-container').hide();
});

/* CLEAR TEXT SHOW HIDDEN BOX AIRPORTS */

$(document).ready(function(){
    $('#depinput').keyup(function(){
      var text = $(this).val();
      $('#listDep .suggestion-container').hide();
      $('#listDep .suggestion-container:contains("'+text+'")').show();
    });

    $('#desinput').keyup(function(){
      var text = $(this).val();
      $('#listDes .suggestion-container').hide();
      $('#listDes .suggestion-container:contains("'+text+'")').show();
    });
    $('.desktop-input').click(function() {
        $('#listDep .suggestion-container').show();
        $('#listDes .suggestion-container').show();
    });
    
});


/* TAB ACTIVE */
$(document).ready(function() {
    $('#city-tabs-dep, #city-tabs-arv').each(function() {
        var $active, $content, $links = $(this).find('a');
        $active = $($links[0]);
        $active.addClass('active');
        $content = $($active[0].hash);
        $links.not($active).each(function() {
            $(this.hash).hide();
        });
        $(this).on('click', 'a', function(e) {
            $active.removeClass('active');
            $content.hide();
            $active = $(this);
            $content = $(this.hash);
            $active.addClass('active');
            $content.show();
            e.preventDefault();
        });
    });
});

/* SELECT PASSENGERR ADULT - CHILD - INFANT PAGE HOME CHANGE VALUE INPUT HIDDEN */
$(document).ready(function() {
    $('#adult').on('change', function () {
        var selectVal = $("#adult option:selected").val();
        $("#adultNo").val(selectVal);
    });

    $('#child').on('change', function () {
        var selectVal = $("#child option:selected").val();
        $("#childNo").val(selectVal);
    });

    $('#infant').on('change', function () {
        var selectVal = $("#infant option:selected").val();
        $("#infantNo").val(selectVal);
    });
});

/* CLICK ONE WAYS - ROUNDTRIP CHANGE VALUE INPUT HIDDEN PAGE HOME*/
$(document).ready(function() {
    let radioButtonOneWays = '#rdbFlightTypeOneWay';
    let radioButtonRoundTrip = '#rdbFlightTypeReturn';
    $(radioButtonOneWays).click(function() {
        if($(this).is(":checked")) {
            let oneway = $('#rdbFlightTypeOneWay').val();
            $('#direction').val(oneway);
        } 
    });
    
    $(radioButtonRoundTrip).click(function() {
        let roundtrip = $('#rdbFlightTypeReturn').val();
        $('#direction').val(roundtrip);
    });
});

