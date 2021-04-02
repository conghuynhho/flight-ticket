var ArrayResult=new Array();
ArrayResult["count"]=0;
function getflight_info(vna,vj,js,notice,fromdate,todate){
    $('#loadresultfirst').html(notice);
    if(vna=='1') getresults(myvar.vna,fromdate,todate);
    if(vj=='1') getresults(myvar.vj,fromdate,todate);
    if(js=='1') getresults(myvar.js,fromdate,todate);
}

function getresults(airline,link,fromdate,todate){
    $.ajax({
        url: link,
        cache:false,
        traditional: true,
        type: "POST",
        data:"enCode="+SessionID,
        timeout:25000,
        dataType: "html",
        beforeSend: function () {
        },
        success: function(output){
            processResult(airline,output);
        },
        complete: function(){
            $(".waitflight").hide();
        },
        error: function(){
            CountActive--;
            if(CountActive==0 && ArrayResult.length==0){
                var emptyhtml=emptyflight();
                $("#result").html(emptyhtml);
            }
        }
    });
}
function processResult(data){
    //Xử Lý Add Row và hiện bản kết quả
	try{
		var org=JSON.parse(data);
		for(var data in org[0]){
			var airline="";
			if(org[0][data].airline=="Vietnam Airlines") airline="vna";
			if(org[0][data].airline=="Vietjet") airline="vj";
            if(org[0][data].airline=="Jetstar") airline="js";
            if(org[0][data].airline=="Bamboo Airways") airline="qh";
			
			var newrow=addrow(airline,org[0][data],0);
			$("#result #OutBound>tbody").append(newrow);
			ArrayResult[data]=org[0][data];
			ArrayResult["count"]++;
	
			if (!$("#frmfilterflight li." + airline).is(":visible")) {
                $("#frmfilterflight li." + airline).show();
            }
		}
	
		if(Direction==0){
			for(var data in org[1]){
				var airline="";
				if(org[1][data].airline=="Vietnam Airlines") airline="vna";
				if(org[1][data].airline=="Vietjet") airline="vj";
                if(org[1][data].airline=="Jetstar") airline="js";
                if(org[1][data].airline=="Bamboo Airways") airline="qh";
	
				var newrow=addrow(airline,org[1][data],1);
				$("#result #InBound>tbody").append(newrow);
				ArrayResult[data]=org[1][data];
				ArrayResult["count"]++;
				
				if (!$("#frmfilterflight li." + airline).is(":visible")) {
                    $("#frmfilterflight li." + airline).show();
                }
			}
		}
		
		if (ArrayResult["count"] > 0 && $('#loadresultfirst').is(":visible")) {
            $('#loadresultfirst').hide();
            $(".block #result").attr( "style", "display: block !important;" )
            $("#flightsort").show();
			$("#wgbox").show();
			$("#wgbox").show();
			$(".wg-search").show();
            if (CountActive > 1) {
                if (!$("#filterflight").is(":visible"))
                    $("#filterflight").show();
            }
        }
		
		$("table.flightlist").trigger("update");
		
	} catch(err) {
		
        console.log("Error Log : " + err);
		
    } finally {
		
		CountActive--;
		if(CountActive==0 && ArrayResult["count"]==0){
			var emptyhtml=emptyflight();
            $("#mainDisplay").html(emptyhtml);
            $(".waiting_block").hide();
            $("ul.date-picker").show();
		}else if(CountActive==0 && ArrayResult["count"]>0){
			//$("ul.date-picker").show();
            $(".sinfo .location").removeClass("contload");
            
		}
		
	}
    return false;
}

function getflight_inter(isdebug){

}

function parseDate(str) {
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[1], mdy[0]);
}

function comparewithCurrentDate(str){
    var mdy = str.split('/');
    var x=new Date(mdy[2],mdy[1]-1,mdy[0],23,59,59);
    var today = new Date();
    if (x < today)
        return false;
    else
        return true;
}

function compareFromDatewithToDate(date1,date2){
    var mdydate1 = date1.split('/');
    var fromdate = new Date(mdydate1[2],mdydate1[1]-1,mdydate1[0]);

    var mdydate2 = date2.split('/');
    var todate = new Date(mdydate2[2],mdydate2[1]-1,mdydate2[0]);
    if(fromdate > todate)
        return false;
    else
        return true;
}

function CurrentDate(){
    var currentTime = new Date();
    var month = currentTime.getMonth() + 1;
    var day = currentTime.getDate();
    var year = currentTime.getFullYear();
    var strDate = day + "/" + month + "/" + year ;

    return strDate;

}



$( function() {
    $('tr.lineresult-main').on("click",function(){
        $(this).parents('table').find('tr').each( function( index, element ) {
            $(element).removeClass('marked');
        } );
        $(this).addClass('marked');
    });


    /***
     CHANGE DEPART DAY
     ***/
    $(".changedepartflight").click(function(){

        var departchange = $(this).attr('rel');
        var todate = Returndate;

        if(todate == '' || (todate != '' & compareFromDatewithToDate(departchange, todate)) ){
            generateform(departchange,Returndate);
            $("#frmchangedate").submit();
            return;
        }else{
            alert('Ngày khởi hành không được lớn hơn ngày về');
            return false;
        }

    });


    /***
     CHANGE RETURN DAY
     ***/
    $(".changereturnflight").click(function(){
        var fromdate = Departdate;
        var returnchange = $(this).attr('rel');
        if(compareFromDatewithToDate(fromdate,returnchange)){
            generateform(Departdate,returnchange);
            $("#frmchangedate").submit();
        }else{
            alert('Ngày về không được nhỏ hơn ngày khởi hành');
            return false;
        }
    });

    /***
     CHON CHUYEN BAY
     ***/
    $(".selectflight").on("click",function(){
        var direction=$(this).closest(".flightlist").attr("id");
        $("#"+direction+" .dep-active").removeClass("dep-active");
        var key = $(this).val();

        if($("#flightdetail"+key).length){

        }else{
            $("#"+direction+" .flight-detail").remove();
            $(this).closest("tr").after('<tr class="flight-detail" id="flightdetail'+key+'"></tr>');
            showdetail(false,key,direction);
        }
    })

    /***
     XEM CHI TIET
     ***/
	$("table").on("click",".viewdetail",function(){
	//$('tr').has('a.on').addClass("tr_bg");
        $('.viewdetail').each(function(index, obj){
                $(obj).html('<i class="fa fa-plus-circle"></i>');
        });

        var f=$(this).attr("for");
        $( "#"+f ).prop( "checked", true );
        // alert(f);
        var direction=$(this).closest(".flightlist").attr("id");
        $("#"+direction+" .dep-active").removeClass("dep-active");

        var keyactive = $(this).attr('rel');
		
        if($(this).hasClass("on")){
            $(this).html('<i class="fa fa-plus-circle"></i>');
            /*Xoa cai khac di*/
            $("#"+direction+" .flight-detail").remove();
            $(this).removeClass("on");
        }else{
            $(this).html('<i class="fa fa-minus-circle"></i>');
            $("#"+direction+" .flight-detail").remove();
            $("#"+direction+" .live").removeClass("on");
            $(this).addClass("on");
            $(this).closest("tr").after('<tr class="flight-detail" id="flightdetail'+keyactive+'"></tr>');
            showdetail(false,keyactive,direction);
        }
        return false;
    })

    /***
     CHECK SUBMIT
     <div class="noneselect">Bạn chưa chọn chuyến bay lượt đi hoặc lượt về</div>
     ***/
    $("#frmSelectFlight").submit(function(){
        var way_flight = Direction;
        if(way_flight == 1){
            if(!$('input[name="selectflightdep"]:checked').val())
            {
            $(".noneselect").text('Bạn chưa chọn chuyến bay');
            $(".noneselect").show();
            $(".noneselect").fadeOut(2000);
            return false;
            }
        }
        else{
            if(!$('input[name="selectflightdep"]:checked').val() || !$('input[name="selectflightret"]:checked').val())
            {
            $(".noneselect").text('Bạn chưa chọn chuyến bay lượt đi hoặc lượt về');
            $(".noneselect").show();
            $(".noneselect").fadeOut(2000);
            return false;
            }
        }
        for(i=0;i<XhrRequest.length;i++){
            if(XhrRequest[i] && XhrRequest[i].readystate != 4)
                XhrRequest[i].abort();
        }
        $("#result").hide();
        $("#mainDisplay").append('<p style="text-align: center;padding: 5px;">Quý khách vui lòng chờ trong giây lát..</p>')
        return true;
    });
});

function showdetail(isselect,flightid,direction){

    $("#flightdetail"+flightid).show();
    var rowdetail=addrowdetail("",ArrayResult[flightid]);

    $("#flightdetail"+flightid).html(rowdetail);

}

function addrow(airline,obj,direction){

    var sltname=(direction==0)?"selectflightdep":"selectflightret";
    logo_class="";
    if(airline == 'vna'){
        logo_class = 'bg_vnal';
    }
    else if(airline == 'js'){
        logo_class = 'bg_js';
    }
    else if(airline == 'vj'){
        logo_class = 'bg_vj';
    }
    else if(airline == 'qh'){
        logo_class = 'bg_qh';
    }


    var newrow='<tr class="lineresult-main '+airline+'"> \
                    <td style="vertical-align: middle;" class="f_code '+logo_class+'"><span class="hidden-xs">'+obj.flightno+'</span></td> \
                    <td style="vertical-align: middle;" class="f_time"><strong>'+obj.deptime+'</strong><span class=" hidden-xs">('+obj.depcode+')</span></td> \
                    \
                    <td style="vertical-align: middle;" class="f_time visible-xs"><span class="Stop0"></span></td> \
					<td style="vertical-align: middle;" class="f_time"><strong>'+obj.arvtime+'</strong><span class=" hidden-xs">('+obj.descode+')</span></td> \
                    \
                    <td style="vertical-align: middle;" class="f_select"> \
                        <div style="position:relative;color: #c04413;font-weight: bold;width: auto;"> \
							<span class="outer"><span class="inner"></span></span>'+formatNumber(obj.baseprice)+'<u style="font-size: 0.8em;"></u>\
						</div>\
                    </td>\
                    <td style="vertical-align: middle;" class="f_detail">\
                    <a class="viewdetail hidden-xs" style="vertical-align:middle;cursor: pointer;margin-right:10px;" rel="'+obj.flightid+'"><i class="fa fa-plus-circle"></i></a> \
                    <input type="radio" name="'+sltname+'" class="selectflight" value="'+obj.flightid+'" id="selectflightret'+obj.flightid+'" hidden="true" />\
                    <label for="selectflightret'+obj.flightid+'" onclick="selectFlight('+direction+',\''+obj.flightid+'\');" >Chọn</label> \
                    </td>\
                </tr>';
    return newrow;
}

function addrowdetail(airline,obj){
    var rowdetail=' <td colspan="5" class="flight-detail-content" cellpadding="10"> \
        <table class="flight_info"> \
        <tr style="font-weight:bold;" class="thead"> \
            <td style="font-weight:bold;">Khởi hành</td> \
            <td style="">Điểm đến</td> \
        </tr> \
		<tr> \
        <td>Từ <strong style="color: #e8382a;">'+obj.depcity+'</strong></td> \
        <td>Đến <strong style="color: #e8382a;">'+obj.descity+'</strong></td> \
        </tr>\
        <tr>\
            <td>Sân bay: <strong>'+obj.depairport+'</strong></td>\
            <td>Sân bay: <strong>'+obj.desairport+'</strong></td>\
        </tr>\
        <tr>\
            <td>Thời gian: <strong style="color: #e8382a;">'+obj.deptime+'</strong>, '+obj.depdate+'</td>\
            <td>Thời gian: <strong style="color: #e8382a;">'+obj.arvtime+'</strong>, '+obj.arvdate+'</td>\
        </tr>\
		<tr> \
			<td>Chuyến bay <strong style="color: #e8382a;">'+obj.airline+'</strong> <strong>('+obj.flightno+')</strong></td> \
			<td> Loại vé: <strong>'+obj.faretype+'</strong></td>\
		</tr> \
    </table>';
    //if(stop != 0 ) rowdetail+='<div class="note">'+obj.note+'</div>';

    rowdetail+='<table class="flight_info tblprice"  >\
            <tr style="border-bottom:1px #dbdbdb solid;">\
                <td class="visible-lg">Hành khách</td>\
                <td><span class="hidden-xs">Số lượng vé</span><span class="visible-xs" style="width:50px;">SL vé<span></td>\
                <td>Giá vé</td>\
                <td>Thuế & Phí</td>\
                <td>Tổng giá</td>\
            </tr>\
            <tr>\
                <td class="visible-lg">Người lớn</td>\
                <td><b>'+Adult+'</b></td>\
                <td><b>'+formatNumber(obj.baseprice)+'</b></td>\
                <td><b>'+formatNumber(obj.adult.taxfee)+'</b></td>\
                <td><b>'+formatNumber(obj.adult.total)+'</b></td>\
            </tr>';
        if(Child != 0){
            rowdetail+='<tr>\
                <td class="visible-lg">Trẻ em</td>\
                <td><b>'+Child+'</b></td>\
                <td><b>'+formatNumber(obj.child.baseprice)+'</b></td>\
                <td><b>'+formatNumber(obj.child.taxfee)+'</b></td>\
                <td><b>'+formatNumber(obj.child.total)+'</b></td>\
            </tr>';
        }
        if(Infant != 0){
            rowdetail+='<tr>\
                <td class="visible-lg">Trẻ sơ sinh</td>\
                <td><b>'+Infant+'</b></td>\
                <td><b>'+formatNumber(obj.infant.baseprice)+'</b></td>\
                <td><b>'+formatNumber(obj.infant.taxfee)+'</b></td>\
                <td><b>'+formatNumber(obj.infant.total)+'</b></td>\
            </tr>';
        }
            rowdetail+='<tr  style="border-top:1px #dbdbdb solid;">\
                <td colspan="5" style="text-align: right; padding-right:10px;font-weight: bold; font-size:18px;"><b>Tổng cộng: <b/><span style="color:#27AE60;">'+formatNumber(obj.subtotal)+' đ</span></td>\
                </tr>\
            </table>\
        </td> ';

    return rowdetail;
}

function emptyflight(){
    var html='<div class="empty_flight">\
        <h3>Chuyến bay bạn yêu cầu hiện tại đã hết !</h3>\
        <p><strong>Thông báo:</strong> chuyến bay khởi hành từ <strong>'+SourceCity+'</strong> đi <strong>'+DesCity+'</strong> trong ngày <strong>'+Departdate+'</strong> của các hãng hàng không trên hệ thông đặt vé online đã hết.</p>\
        <p>Bạn có thể thay đổi <strong>ngày đi</strong>, hoặc <strong>ngày về</strong> để tìm chuyến bay khác.</p>\
        <p>Nếu bạn muốn <strong>đặt vé máy bay theo yêu cầu</strong> trên, bạn có thể gửi yêu cầu theo <strong>biểu mẫu bên dưới</strong> hoặc gọi tới số điện thoại <strong style="font-size:16px;color:#E00;">'+Hotline+'</strong>. Nhân viên của chúng tôi sẽ <strong>tìm vé máy bay theo yêu cầu</strong> của bạn </p>\
        <div class="request_block">\
            <form method="post" action="" id="frm_requestflight">\
                <table>\
                    <caption>Đặt vé theo yêu cầu</caption>\
                    <tr>\
                        <td><label for="fullname">Họ tên:</label></td><td><input type="text" name="fullname" id="fullname" /></td>\
                    </tr>\
                    <tr>\
                        <td><label for="phone">Điện thoại:</label></td><td><input type="text" name="phone" id="phone" /></td>\
                    </tr>\
                    <tr>\
                        <td><label for="content_request">Nội dung:</label></td>\
                        <td><textarea name="content_request" id="content_request" style="height:80px;">Tôi muốn tìm vé cho chuyến bay từ '+SourceCity+' đi '+DesCity+' vào ngày '+Departdate+' cho '+PassengerText+' </textarea></td>\
                    </tr>\
                    <tr>\
                        <td></td><td><input type="submit" name="sm_request" id="sm_request" value="Gửi" class="btn_send btn-flat-red"/></td>\
                    </tr>\
                </table>\
            </form>\
        </div>\
    </div>';
    return html;
}

 

function generateform(depdate,retdate){
    var htmlform='<input name="direction" value="'+Direction+'">\
                    <input name="dep" value="'+Source+'">\
                    <input name="des" value="'+Destination+'">\
                    <input name="depdate" value="'+depdate+'">\
                    <input name="retdate" value="'+retdate+'">\
                    <input name="adult" value="'+Adult+'">\
                    <input name="child" value="'+Child+'">\
                    <input name="infant" value="'+Infant+'">';
	//htmlform+='<input type="hidden" name="btnchangedate" value="">';
    //$("#frmchangedate").html(htmlform);
    $("#frmchangedate").append(htmlform);
}
$(document).ready(function () {
		$(window).scroll(function () {
			var heightScroll = $(document).height() - $(window).height() - 400;
			var scrollTop = jQuery(window).scrollTop();
			if (scrollTop >= heightScroll) {
				$('#flightselectbt').removeClass('scrollDown');
				$('.moreScroll').text('');
			}
			else {
				$('#flightselectbt').addClass('scrollDown');
				$('.moreScroll').text('Kéo xuống để xem thêm kết quả');
			}
		});

 
 

});

$(document).ready(function(){

 	 $('body').on('click','.fl-view-detail',function(e){
	  var is_collapse = $(this).hasClass('collapse');
	  var tbl = $(this).parent().parent().parent().parent().parent() ;
	  if(is_collapse){
	  	  $(this).removeClass('collapse');
		  
		  tbl.find('.fl-route-detail:first').hide();
	  } else {
	    $(this).addClass('collapse');
		 tbl.find('.fl-route-detail:first').show();
	  }

	  
	 
	  e.preventDefault();	 
   });
 });
 
$(function(){
  var $table = $('table'),
    $pager = $('.pager');

  $.tablesorter.customPagerControls({
    table          : $table,                   // point at correct table (string or jQuery object)
    pager          : $pager,                   // pager wrapper (string or jQuery object)
    pageSize       : '.left a',                // container for page sizes
    currentPage    : '.right a',               // container for page selectors
    ends           : 2,                        // number of pages to show of either end
    aroundCurrent  : 1,                        // number of pages surrounding the current page
    link           : '<a href="#">{page}</a>', // page element; use {page} to include the page number
    currentClass   : 'current',                // current page class name
    adjacentSpacer : ' | ',                    // spacer for page numbers next to each other
    distanceSpacer : ' \u2026 ',               // spacer for page numbers away from each other (ellipsis &hellip;)
    addKeyboard    : true                      // add left/right keyboard arrows to change current page
  });

  // initialize tablesorter & pager
  $table
    .tablesorter({
	sortInitialOrder: 'desc',
	sortList: [[4,0]],
	headers:{
	4:{sorter:'thousands'}
	},
	 theme: 'blue',
      widgets: ['zebra', 'columns', 'filter']
    })
    // .tablesorterPager({
     // target the pager markup - see the HTML block below
      // container: $pager,
      // size: 500,
      // output: 'showing: {startRow} to {endRow} ({filteredRows})'
    // });

});
$(document).ready(function(){

    $.tablesorter.addParser({
        id: 'thousands',
        is: function(s) {
            return false;
        },
        format: function(s) {
            // alert(s.replace('đ','').replace(/,/g,''));
            return s.replace('đ','').replace(/,/g,'');
        },
        type: 'numeric'
    });
    $("table.flightlist").tablesorter({
        headers:{
            4:{sorter:'thousands'},
        }
    });
	    $(".rdsort").on("click",function(){
        $("#frmsoftflight li label").removeAttr("style");
        $(this).parent().find("label").attr("style","font-weight:bold;")
        sort_val=$(this).val();
        if(sort_val=="price")
            sorting = [[4,0]];
        if(sort_val=="airline")
            sorting = [[0,0]];
        if(sort_val=="time")
            sorting = [[1,0]];
        //alert(sort_val);
        $("table.flightlist").trigger("sorton",[sorting]);
    })
    $(document).on("click",".flightfilter",function(){
        $(".flight-detail").remove();
        cr_val=$(this).val();
		
        if(cr_val=="all"){
		    if($(this).prop("checked")){
                $(".flightfilter").each(function(index){
                    $(this).prop("checked",true);
					$(this).closest(".checkbox").addClass("checked");
                    $("table.flightlist .lineresult-main").show();

                })
            }else{
                $(".flightfilter").each(function(index){
                    $(this).removeAttr("checked");
					 $(this).closest(".checkbox").removeClass("checked");
                    $("table.flightlist .lineresult-main").hide();
                })
            }
        }else{
		
            if($(".flightfilter:checked").length==4){
                $("#filterall").prop("checked",true);
				
				$(this).closest(".checkbox").addClass("checked");
                $("table.flightlist .lineresult-main").show();
            }else{
                $("#filterall").removeAttr("checked");
				$("#filterall").closest(".checkbox").removeClass("checked");

                if($(this).prop("checked")){ 
					$(this).closest(".checkbox").addClass("checked");
                    $("tr.lineresult-main."+cr_val).show();
                }else{
				//alert("tr.lineresult-main."+cr_val);
                    $(".lineresult-main."+cr_val).hide();
                }
            }
        }
    })
   


});
$(document).ajaxComplete(function() {
		$(".flightlist").tablesorter({ 
			sortInitialOrder: 'desc',
			sortList: [[4,0]],
			headers:{
			4:{sorter:'thousands'}
			}

		});
});
$(document).ready(function () {
		$(window).scroll(function () {
			var heightScroll = $(document).height() - $(window).height() - 400;
			var scrollTop = jQuery(window).scrollTop();
			if (scrollTop >= heightScroll) {
				$('#flightselectbt').removeClass('scrollDown');
				$('.moreScroll').text('');
			}
			else {
				$('#flightselectbt').addClass('scrollDown');
				$('.moreScroll').text('Kéo xuống để xem thêm kết quả');
			}
		});

});
 
 
// INTER FLIGHT SEARCH FILTER
$(document).ready(function(){
  // change price tax
  $('#wgbox').on('change','input:radio[name="rblDisplayMode"]',function(){
	  if($('input:radio[name="rblDisplayMode"]:checked').val() == 'full'){
		  $('span.incl-tax').show();
		  $('span.no-tax').hide();
	  } else {
		  $('span.incl-tax').hide();
		  $('span.no-tax').show();
		  $('.inter-fl-price .incl-tax').show();
	  } 
	 $('input:radio[name="rblCurrency"]').change();
  });
  // change currency
  $('#wgbox').on('change','input:radio[name="rblCurrency"]',function(){
	  var currency = $('input:radio[name="rblCurrency"]:checked').val().toLowerCase();
	  var display_mode = $('input:radio[name="rblDisplayMode"]:checked').val();
	  var span_class = (display_mode == 'full' ? 'span.incl-tax' : 'span.no-tax');
	  $(span_class).each(function(index,element){
		  var data = $(this).attr(currency).split('|');
		  $(this).find('.amount').html(data[0]); // amount
		  $(this).find('.currency sup').html(data[1]); // currency
	  });
	//  $('input:radio[name="rblDisplayMode"]').change();
  });
  
  // filter by airline code
  $('#wgbox').on('change','input:radio[name="rblAirline"]',function(){
    if($('input:radio[name="rblAirline"]:checked').val() != ''){
		  $('section.inter-fl-block').hide();
		  $('span.airline-name.' + $('input:radio[name="rblAirline"]:checked').val()).parent().parent().parent().parent().parent().parent().show();
	  } else {
		  $('section.inter-fl-block').show();
	  }
  });
  // filter by stop
  $('#wgbox').on('change','input:radio[name="rblTypeFlight"]',function(){
	  var type_flight = $('input:radio[name="rblTypeFlight"]:checked').val().toLowerCase();
	  if(Direction == 0){
		  type_flight += '|' + type_flight;
	  }
	  if(type_flight != '|' && type_flight != ''){
	  	$('section.inter-fl-block').hide();
	  	$('section.inter-fl-block[stop="'+ type_flight +'"').show();
	  } else {
	   $('section.inter-fl-block').show();
	  }
  });
});
 