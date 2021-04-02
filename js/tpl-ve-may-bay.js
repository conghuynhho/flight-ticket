
/* CHANGE CODE DEP AND ARV PAGE VE-MAY-BAY */

$(document).ready(function() {
	

    if($("#tpldepinput").val() == "") {
        $("#tpldepinput").val('Hồ Chí Minh (SGN)');
    } 

    if($("#tpldesinput").val() == "") {
        $("#tpldesinput").val('Hà Nội (HAN)');
    }



























    $("#frmFlightSearch").submit(function(e) {
        if ($("#des").val() == "") {
            $("#tpllistDes").fadeIn("fast");
            return false;
        }
        var deptime = $("#depdate").val();
        if (deptime == "") {
            $("#depdate").datepickerlunar("show");
            return false;
        } else {
            if ($(".rdbdirection:checked").val() == 0) {
                arvtime = $("#retdate").val();
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
        var tmpdi=$("#tpldepinput").val();

        $("#dep").val($("#des").val());
        $("#des").val(di);

        $("#tpldepinput").val($("#tpldesinput").val());
        $("#tpldesinput").val(tmpdi);
        return false;
    })


    /*Process Select City*/

    $("#tpldepinput").click(function() {
        $("#tpllistDep").fadeIn("fast");
        $("#tpllistDep .suggestion-container").show();
        $(this).select();
    })
    $("#tpldesinput").click(function() {
        $("#tpllistDes").fadeIn("fast");
        $("#tpllistDes .suggestion-container").show();
        $(this).select();
    })

    $("body").click(function(e) {
        if ($.trim($(e.target).closest("#tpllistDep").html()) == '' && !$(e.target).is("#tpldepinput") && !$(e.target).is(".ui-corner-all")) {
            if ($("#tpllistDep").is(":visible"))
                $("#tpllistDep").hide();
        }
        if ($.trim($(e.target).closest("#tpllistDes").html()) == '' && !$(e.target).is("#tpldesinput") && !$(e.target).is(".ui-corner-all")) {
            if ($("#tpllistDes").is(":visible"))
                $("#tpllistDes").hide();
        }
    })

    $("#tpllistDep li a").click(function() {
        $("#tpldepinput").val($(this).text());
        $("#dep").val($(this).attr("data-city"));

        if ($("#dep").val() == $("#des").val()) {
            $("#tpldesinput").val("");
            $("#des").val("");
        }
        $("#tpllistDes li").show();
        $("#tpllistDep").fadeOut("fast");
        $("#tpllistDes").fadeIn("fast");
        $('#tpllistDes .suggestion-container').show();
        $("#tab1-arv ul li.tcb-hot-city-box-item").removeAttr("style");
        $("#tpldesinput").select();
        return false;
    })

    $("#tpllistDes li a").click(function() {
        arvplace = $(this).attr("data-city");
        if (arvplace == $("#des").val()) {
            alert("Điểm đi và điểm đến không được trùng!!")
        } else {
            $("#tpldesinput").val($(this).text());
            $("#tpllistDes").find(".err").text("");
            $("#des").val($(this).attr("data-city"));
            $("#tpllistDes").fadeOut("fast");
            $("#depdate").datepickerlunar("show");
        }
        return false;
    })
});


/* SELECT CHANGE VALUE SEND INPUT HIDDEN FROM PAGE HOME */
$(document).ready(function() {
    $('#adult').each(function() {
        let adult = $(".tpl-hidden-adult").val();
        $("#adult option:selected").prop("selected",false);
        $("#adult option[value=" + adult + "]").prop("selected",true);
    });

    $('#child').each(function() {
        let child = $(".tpl-hidden-child").val();
        $("#child option:selected").prop("selected",false);
        $("#child option[value=" + child + "]").prop("selected",true);
    });

    $('#infant').each(function() {
        let infant = $(".tpl-hidden-infant").val();
        $("#infant option:selected").prop("selected",false);
        $("#infant option[value=" + infant + "]").prop("selected",true);
    });
});



/* SHOW DIRECTION 0 -1 PAGE VE MAY BAY SEND INPUT HIDDEN PAGE VE MAY BAY */

// $(document).ready(function() {
// 	let direction = $("#hidden-direction").val();
// 	if (direction == 1 || direction == "") {
// 		$(".tpl-rdio-oneways").addClass('checked');
// 		$('#rdbFlightTypeOneWay').attr('checked',true);
// 		$("#rdbFlightTypeReturn").removeAttr('checked');
// 	} else {
// 		$(".tpl-rdio-roundtrip").addClass('checked');
// 		$("#rdbFlightTypeReturn").attr('checked',true);
// 		$('#rdbFlightTypeOneWay').removeAttr('checked');
// 	}
    
// });

// /* SELECT AIRPORT MOBILE */
// $(".tpl__ve-may-bay .sub-departure-mobile div .scroll-touch li a").click(function () {

//     $("#tpldepmobileinput").val($(this).text());
//     $("#dep").val($(this).attr("data-city"));
//     $('.direction-panel-xpanel').fadeOut();
//     $(".go-flight-from").removeClass("open");
//     $('html,body').animate({scrollTop: $('#wrap').offset().top},'fast');
//     $("#main-header").css("display", "block"); 
//     return false;
// });    
// $(".tpl__ve-may-bay .sub-arrival-mobile div .scroll-touch li a").click(function () {

//     $("#tpldesmobileinput").val($(this).text());
//     $("#des").val($(this).attr("data-city"));
//     $('.direction-panel-xpanel').fadeOut();
//     $(".go-flight-from").removeClass("open");
//     $('html,body').animate({scrollTop: $('#wrap').offset().top},'fast');
//     $("#main-header").css("display", "block"); 
//     return false;
// });

/* SEARCH AIRPORT DESKTOP PAGE VE-MAY-BAY */

$(document).ready(function(){
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/flight_config/airport_list.json",
        getValue: function(element) {
            return element.airport_name +' '+'(' + element.airport_code + ')'+' '+'-'+' '+ element.city;
        },
        list: {
            onSelectItemEvent: function() {
                var name = $("#tpldepinput").getSelectedItemData().airport_name;
                var city = $("#tpldepinput").getSelectedItemData().city;
                var code = $("#tpldepinput").getSelectedItemData().airport_code;
                var selectCity = name +' '+'(' + code + ')'+' '+'-'+' '+city;
                $("#tpldepinput").val(selectCity);
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
    $("#tpldepinput").easyAutocomplete(options);
    $('#tpllistDep .suggestion-container').hide(); 
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/flight_config/airport_list.json",
        getValue: function(element) {
            return element.airport_name +' '+'(' + element.airport_code + ')'+' '+'-'+' '+ element.city;
        },
        list: {
            onSelectItemEvent: function() {
                var name = $("#tpldesinput").getSelectedItemData().airport_name;
                var city = $("#tpldesinput").getSelectedItemData().city;
                var code = $("#tpldesinput").getSelectedItemData().airport_code;
                var selectCity = name +' '+'(' + code + ')'+' '+'-'+' '+city;
                $("#tpldesinput").val(selectCity);
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
    $("#tpldesinput").easyAutocomplete(options);
    $('#tpllistDes .suggestion-container').hide();
});


/* SEARCH MOBILE PAGE VE-MAY-BAY */
$(document).ready(function(){
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/inc/jsonAirport.json",
        getValue: "location",
        list: {
            onSelectItemEvent: function() {
                var name = $("#tpl-inter-city-dep-mobile").getSelectedItemData().name;
                var code = $("#tpl-inter-city-dep-mobile").getSelectedItemData().code;
                $('.direction-panel-xpanel').fadeOut();
                $(".go-flight-from").removeClass("open");
                $("#tpldepmobileinput").val(name);
                $("#dep").val(code);
            },
            maxNumberOfElements: 15,
            match: {
                enabled: true
            }
        }
    };
    $("#tpl-inter-city-dep-mobile").easyAutocomplete(options);
    /* Search Nơi Đến */
    var options = {
        url: myvar.tempurl + "/inc/jsonAirport.json",
        getValue: "location",
        list: {
            onSelectItemEvent: function() {
                var name = $("#tpl-inter-city-arv-mobile").getSelectedItemData().name;
                var code = $("#tpl-inter-city-arv-mobile").getSelectedItemData().code;
                $('.direction-panel-xpanel').fadeOut();
                $(".go-flight-from").removeClass("open");
                $("#tpldesmobileinput").val(name);
                $("#des").val(code);
            },
            maxNumberOfElements: 15,
            match: {
                enabled: true
            }
        }
    };
    $("#tpl-inter-city-arv-mobile").easyAutocomplete(options);
});