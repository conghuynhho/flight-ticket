/**
 * Created with JetBrains PhpStorm.
 * User: Lak
 * Date: 8/5/13
 * Time: 4:02 PM
 * To change this template use File | Settings | File Templates.
 */
   $(document).ready(function() {
	var owl = $("#owl-slide");
	owl.owlCarousel({
	navigation : false, // Show next and prev buttons
	pagination: false,
	slideSpeed : 300,
	paginationSpeed : 400,
	singleItem:true,
	 //Autoplay
    autoPlay : true,
    goToFirst : true,
    goToFirstSpeed : 1000,
	 
	});
	  /* Custom Navigation Events
	$(".next").click(function(){
	owl.trigger('owl.next');
	})
	$(".prev").click(function(){
	owl.trigger('owl.prev');
	})	*/
	
	var owlnews = $("#owl-news");
	owlnews.owlCarousel({
	autoPlay: 10000, //Set AutoPlay to 6 seconds
	pagination:true,
	//navigation : true, 
	items: 3,
	itemsDesktop: [1199, 4],
	itemsDesktopSmall: [1080, 3],
	itemsTablet: [768, 2],
	itemsMobile: [450, 1]
	});
	  // Custom Navigation Events
	$(".next").click(function(){
	//alert('work');
	owlnews.trigger('owl.next');
	})
	$(".prev").click(function(){
	owlnews.trigger('owl.prev');
	})
	//====================================	
	var owlpromotion = $("#owl-promotion");
	owlpromotion.owlCarousel({
	//autoPlay: 10000, //Set AutoPlay to 6 seconds
	pagination:false,
	navigation : false, 
	items: 3,
	itemsDesktop: [1199, 3],
	itemsDesktopSmall: [1080, 3],
	itemsTablet: [768, 2],
	itemsMobile: [450, 1]
	});
	 
	//=========================================
	var owlwhy = $("#why-list");
	owlwhy.owlCarousel({
	autoPlay: false, //Set AutoPlay to 6 seconds
	pagination:true,
	//navigation : true, 
	items: 3,
	itemsDesktop: [1199, 3],
	itemsDesktopSmall: [1080, 3],
	itemsTablet: [768, 2],
	itemsMobile: [450, 1]
	});
	  // Custom Navigation Events
	$("#why-list .next").click(function(){
	//alert('work');
	owlwhy.trigger('owl.next');
	})
	$("#why-list .prev").click(function(){
	owlwhy.trigger('owl.prev');
	})	
	
});
 
   $(document).ready(function() {
	var owlrelate = $("#owl-relate");
	owlrelate.owlCarousel({
	autoPlay: 5000, //Set AutoPlay to 3 seconds
	pagination:false,
	items : 3,
	itemsDesktop : [1199,3],
	itemsDesktopSmall : [979,3],
	});
	  // Custom Navigation Events
	$(".next").click(function(){
	owlrelate.trigger('owl.next');
	})
	$(".prev").click(function(){
	owlrelate.trigger('owl.prev');
	})	
	
	
	
});
 
if($("#topnews").length){
	jQuery('#topnews ul').carouFredSel({
		items : 1,
		direction:"down",
		scroll  : {
			items : 1,
			duration  : 1000,
			timeoutDuration : 2000,
			fx:scroll

		},
		auto:true
	});
}

$(document).ready(function(){
	// checkbox
    $(".checkbox input[type='checkbox'], .radio input[type='radio']").each(function() {
        if ($(this).is(":checked")) {
            $(this).closest(".checkbox").addClass("checked");
            $(this).closest(".radio").addClass("checked");
        }
    });
	
    $(".checkbox input[type='checkbox']").bind("change", function() {
        if ($(this).is(":checked")) {
            $(this).closest(".checkbox").addClass("checked");
        } else {
            $(this).closest(".checkbox").removeClass("checked");
        }
    });
    //radio
    $(".radio input[type='radio']").bind("change", function(event, ui) {
        if ($(this).is(":checked")) {
            var name = $(this).prop("name");
            if (typeof name != "undefined") {
                $(".radio input[name='" + name + "']").closest('.radio').removeClass("checked");
            }
            $(this).closest(".radio").addClass("checked");
        }
    });
  
 	
	$(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
   
    $('#from,#to,#frm-float-support,.sub-menu').click(function(event){
        event.stopPropagation();
    });
	
    $('#toTop').click(function() {
        $('body,html').animate({scrollTop:0},800);
    }); 
	    $( "#dialog" ).dialog({
        autoOpen: false,
        minWidth:650,
        minHeight:359,
        modal: true
     });
      
	  
// accordion & toggles
    $(".toggle-container .panel-collapse").each(function() {
        if (!$(this).hasClass("in")) {
            $(this).closest(".panel").find("[data-toggle=collapse]").addClass("collapsed");
        }
    });		  
	if (typeof enableChaser == "undefined") {
    enableChaser = 1 // Enable Chaser menu (open on scroll) ?   1 - Yes / 0 - No
}

   
    // Mobile menu
    $(".mobile-menu ul.menu > li.menu-item-has-children").each(function(index) {
        var menuItemId = "mobile-menu-submenu-item-" + index;
        $('<button class="dropdown-toggle collapsed" data-toggle="collapse" data-target="#' + menuItemId + '"></button>').insertAfter($(this).children("a"));
        /*$(this).children(".dropdown-toggle").click(function(e) {
            if ($(this).hasClass("collapsed")) {
                $(this).parent().addClass("open");
            } else {
                $(this).parent().removeClass("open");
            }
        });*/
        $(this).children("ul").prop("id", menuItemId);
        $(this).children("ul").addClass("collapse");

        $("#" + menuItemId).on("show.bs.collapse", function() {
            $(this).parent().addClass("open");
        });
        $("#" + menuItemId).on("hidden.bs.collapse", function() {
            $(this).parent().removeClass("open");
        });
    });

   
    // third level menu position to left
    function fixPositionSubmenu() {
        $("#main-menu .menu li.menu-item-has-children > ul, .ribbon ul.menu.mini").each(function(e) {
            if ($(this).closest(".megamenu").length > 0) {
                return;
            }
            var leftPos = $(this).parent().offset().left + $(this).parent().width();
            if (leftPos + $(this).width() > $("body").width()) {
                $(this).addClass("left");
            } else {
                $(this).removeClass("left");
            }
        });
    }
    fixPositionSubmenu();
    
    // chaser
    if (enableChaser == 1 && $('#content').length > 0 && $('#main-menu ul.menu').length > 0) {
        var forchBottom;
        var chaser = $('#main-menu ul.menu').clone().hide().appendTo(document.body).wrap("<div class='chaser hidden-mobile'><div class='container'></div></div>");
        $('<h1 class="logo navbar-brand"><a title="VMB Nam Phương" href="https://timchuyenbay.com"><img src="https://timchuyenbay.com/assets/themes/goibibo/images/logo.png"></a></h1>').insertBefore('.chaser .menu');
        var forch = $('#content').first();
        forchBottom = forch.offset().top + 2;
        $(window).on('scroll', function () {
            var top = $(document).scrollTop();
            if ($(".chaser").is(":hidden") && top > forchBottom) {
                $(".chaser").slideDown(300);
                //chaser.fadeIn(300, shown);
            } else if ($(".chaser").is(":visible") && top < forchBottom) {
                $(".chaser").slideUp(200);
                //chaser.fadeOut(200, hidden);
            }
        });
        $(window).on('resize', function () {
            var top = $(document).scrollTop();
            if ($(".chaser").is(":hidden") && top > forchBottom) {
                $(".chaser").slideDown(300);
            } else if ($(".chaser").is(":visible") && top < forchBottom) {
                $(".chaser").slideUp(200);
            }
        });
        
        $(".chaser").css("visibility", "hidden");
        chaser.show();
        fixPositionMegaMenu(".chaser");
        $(".chaser .megamenu-menu").removeClass("light");
        //chaser.hide();
        $(".chaser").hide();
        $(".chaser").css("visibility", "visible");
    }
    
    // accordion & toggles
    $(".toggle-container .panel-collapse").each(function() {
        if (!$(this).hasClass("in")) {
            $(this).closest(".panel").find("[data-toggle=collapse]").addClass("collapsed");
        }
    });
    

	
});

// mega menu
var megamenu_items_per_column = 6;
function fixPositionMegaMenu(parentObj) {
    if (typeof parentObj == "undefined") {
        parentObj = "";
    } else {
        parentObj += " ";
    }
    $(parentObj + ".megamenu-menu").each(function() {
        var paddingLeftStr = $(this).closest(".container").css("padding-left");
        var paddingLeft = parseInt(paddingLeftStr, 10);
        var offsetX = $(this).offset().left - $(this).closest(".container").offset().left - paddingLeft;
        if (offsetX == 0) { return; }
        $(this).children(".megamenu-wrapper").css("left", "-" + offsetX + "px");
        $(this).children(".megamenu-wrapper").css("width", $(this).closest(".container").width() + "px");
        if (typeof $(this).children(".megamenu-wrapper").data("items-per-column") != "undefined") {
            megamenu_items_per_column = parseInt($(this).children(".megamenu-wrapper").data("items-per-column"), 10);
        }
        //$(this).children(".megamenu-wrapper").show();
        var columns_arr = new Array();
        var sum_columns = 0;
        $(this).find(".megamenu > li").each(function() {
            var each_columns = Math.ceil($(this).find("li > a").length / megamenu_items_per_column);
            if (each_columns == 0) {
                each_columns = 1;
            }
            columns_arr.push(each_columns);
            sum_columns += each_columns;
        });
        $(this).find(".megamenu > li").each(function(index) {
            $(this).css("width", (columns_arr[index] / sum_columns * 100) + "%");
            $(this).addClass("megamenu-columns-" + columns_arr[index]);
        });

        $(this).find(".megamenu > li.menu-item-has-children").each(function(index) {
            if ($(this).children(".sub-menu").length < 1) {
                $(this).append("<ul class='sub-menu'></ul>");
                for (var j = 0; j < columns_arr[index]; j++) {
                    $(this).children(".sub-menu").append("<li><ul></ul></li>")
                }
                var lastIndex = $(this).children("ul").eq(0).children("li").length - 1;
                $(this).children("ul").eq(0).children("li").each(function(i) {
                    var parentIndex = Math.floor(i / megamenu_items_per_column);
                    $(this).closest("li.menu-item-has-children").children(".sub-menu").children("li").eq(parentIndex).children("ul").append($(this).clone());
                    if (i == lastIndex) {
                        $(this).closest(".menu-item-has-children").children("ul").eq(0).remove();
                    }
                });
            }
        });
        $(this).children(".megamenu-wrapper").show();
    });
}
fixPositionMegaMenu();

// menu position to top
$("#footer #main-menu .menu >  li.menu-item-has-children").each(function(e) {
    var height = $(this).children("ul, .megamenu-wrapper").height();
    $(this).children("ul, .megamenu-wrapper").css("top", "-" + height + "px");
});
 
  /*** SUPPORT NHANH PHIA DUOI ***/
$(function(){
  
	var showsupport=function(){
		$("#float-bar").hide();
		$("#wrap-support-ct").fadeIn("fast");
		return false;
	};
	$("#a-float-bar").click(showsupport)
	$("#cloud-bg").click(showsupport);
	$("#a-float-bar-min").click(function(){
		$("#wrap-support-ct").hide();
		$("#float-bar").fadeIn("fast");
		return false;
	})

});


/*** KIEM TRA CAC TRUONG DU LIEU TRUOC KHI GUI ***/
$(function() {

	var sg_name    =  $( "#sg_name" ),
		sg_email   =  $( "#sg_email" ),
		sg_phone   =  $( "#sg_phone" ),
		sg_content =  $( "#sg_content" ),
		allFields  =  $( [] ).add( sg_name ).add( sg_email ).add( sg_phone ).add( sg_content ),
		tips = $( ".validateTips" );

	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

		function checkLength( o, min ) {

		if ( o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Vui lòng điền chính xác thông tin" );
			return false;
		} else {
			return true;
		}
	}
	function checkMaxLength( o, max ) {
		if ( o.val().length > max ) {
			o.addClass( "ui-state-error" );
			updateTips( "Vui lòng điền chính xác thông tin" );
			return false;
		} else {
			return true;
		}
	}
	function checkComment(o){
		var str =o.val();
		if (str.indexOf("http://") >= 0)
			{	o.addClass( "ui-state-error" );
				 return false;
			}else{
				return true;
			}
    }
	
	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
 
	
	$( "#submit_float" ).click(function(){	
	//alert($("#g-recaptcha-response" ).val());
	  var bValid = true;
		  allFields.removeClass( "ui-state-error" );
		  bValid = bValid && checkLength( sg_name,  3 );
		  bValid = bValid && checkLength( sg_phone, 9 );
		  bValid = bValid && checkLength( sg_email, 5 );				
		  bValid = bValid && checkLength( sg_content, 10 );
		  bValid = bValid && checkMaxLength( sg_content, 150 );
		  bValid = bValid &&checkComment(sg_content);		  
		  bValid = bValid && checkRegexp( sg_phone, /^[0-9]+$/i, "Số điện thoại không hợp lệ" );
		  bValid = bValid && checkRegexp( sg_email, /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/i, "Email không hợp lệ" );

		  if ( bValid ) {
			if ($("#g-recaptcha-response").val()){
			  /*** AJAX ***/
			  $.ajax({
				  url: $("#frm-float-support").attr('action'),
				  cache:false,
				  traditional: true,
				  type: "POST",
				  dataType: "html",
				  data: 'sg_name='+sg_name.val()+'&sg_phone='+sg_phone.val()+'&sg_email='+sg_email.val()+'&sg_content='+sg_content.val(),
				  beforeSend: function () {
					  $('.notice-success').show('fast');
				  },
				  success: function(){
					  $("#float-bar").fadeIn("fast");
					  $("#wrap-support-ct").fadeOut( "fast" );
					  $('.notice-success').hide('fast');
					  $('#frm-float-support input:text, #frm-float-support textarea').val('').text('');
				  },
			  });
	
			}else{$(".recaptcha-checkbox").addClass( "ui-state-error" );}
		  }
	
 	
	
	});
});


/*
 convert a string to number
 */
function unformatNumber(str){
    var grp_sep = ",";
    var dec_sep = ".";
    str = String(str);
    str = str.replace(grp_sep, '');
    str = str.replace(grp_sep, '');
    str = str.replace(grp_sep, '');
    str = str.replace(grp_sep, '');
    str = str.replace(dec_sep, '.');
    num = Number(str);
    return num;
}



/*
 convert number to a string
 */
function formatNumber(number){
    var decimals = 0;
    var dec_point = ".";
    var thousands_sep = ",";
    // http://kevin.vanzonneveld.net
    // + original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // + improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + bugfix by: Michael White (http://crestidg.com)
    // + bugfix by: Benjamin Lupton
    // + bugfix by: Allan Jensen (http://www.winternet.no)
    // + revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // * example 1: number_format(1234.5678, 2, '.', '');
    // * returns 1: 1234.57
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "," : dec_point;
    var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 100) {
        $('#bottom-contact').fadeIn();
    } else {
        $('#bottom-contact').fadeOut();
    }

});

  $(document).ready(function () {
            $('.question').toggle(
                function () {
                    $(this).find('a').css({ 'font-weight': 'bold' });
                    $(this).find('span').addClass('viewing');
                    $(this).next().show();
                },
                function () {
                    $(this).find('a').css({ 'font-weight': 'normal' });
                    $(this).find('span').removeClass('viewing');
                    $(this).next().hide();
                }
            );
                var qParam = 'q';
            if (qParam != 'q') {
                $('.' + qParam).click();
                spoil('q');
            }
		if($("#hotline").length){
			jQuery('#hotline ul').carouFredSel({
				items : 1,
				direction:"down",
				scroll  : {
					items : 1,
					duration  : 1000,
					timeoutDuration : 2000,
					fx:scroll

				},
				auto:true
			});
		}

    });
	function spoil(id) {
		var divid = document.getElementById(id);
		divid.style.display = 'block';
		divid.scrollIntoView(true);
		return false;
	}
	function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
	function OpenPopup(Url,WindowName,width,height,extras,scrollbars) {
		var wide = width;
		var high = height;
		var additional= extras;
		var top = (screen.height-high)/2;
		var leftside = (screen.width-wide)/2; newWindow=window.open(''+ Url + 
		'',''+ WindowName + '','width=' + wide + ',height=' + high + ',top=' + 
		top + ',left=' + leftside + ',features=' + additional + '' + 
		',scrollbars=1');
		newWindow.focus();
    }
    
/**
 * Get search flight token
 */
$(function(){
	$(document).ready(function(){
        var frmSearch = $('form.search-flight-form');
		if(frmSearch.length){
			$.ajax({
				type : 'get',
				dataType : 'json',
				url : myvar.siteurl + '/wp-admin/admin-ajax.php',
				data : {
					action: 'get_sf_token'
				},
				context: this,
				success: function(response){
					if(response.success) {
                        frmSearch.each(function(index){
                            var divCount = $(this).find('div').length;
                            var randPos = Math.floor(Math.random() * (divCount - 1)); // Random from 0 to max number of div
                            if(divCount) {
                                $(this).find('div').eq(randPos).append(response.data);
                            } else {
                                $(this).append(response.data);
                            }
                        });
					} else {
						console.log('Error when get token');
					}
				},
				error: function( jqXHR, textStatus, errorThrown ){
					console.log('Error when get token');
				}
			});
		}
	});
});