var ArrayResult = new Array();
ArrayResult["count"] = 0;
/* APPDEND DATA TBODY */
function processResultInter(data) {
    try {
        $('#tblInterFlightList>tbody').append(data);
        ArrayResult['count']++;
        if (ArrayResult['count'] > 0) {
            $('#loadresultfirst').remove();
            $('#result').show();
            $("#wgbox").show();
            $(".wg-search").show();
        }
        $('#tblInterFlightList').trigger('update');
    } catch (err) {
        console.log('Error Log : ' + err);
    } finally {
        CountActive--;
        if (CountActive == 0 && ArrayResult['count'] == 0) {
            var emptyhtml = emptyflight();
            $("#tblInterFlightList>tbody").html(emptyhtml);
        } else if (CountActive == 0 && ArrayResult['count'] > 0) {
            $('#loadresultfirst').remove();
            $('.sinfo .location').removeClass('contload');
        }
    }
    return false;
}

/* CLICK HIỆN CHI TIẾT CHUYẾN BAY */
$('#tblInterFlightList tr.select-flight').each(function() {
    var $showDrop = $(this);
    $("a.viewflightinfo", $showDrop).on("click",function(event) {
        event.preventDefault();
        $classDetail = $(".flight-detail-content-inline", $showDrop).addClass('show-box-flight-detail').show();
        $('.show-box-flight-detail').css("display", "block");
        $classDetail.toggle();
        $(".flight-detail-content-inline").not($classDetail).removeClass('show-box-flight-detail').hide();
        $('.show-box-flight-detail').css("display", "none");
        $classDetail.toggle();
        return false;
    });
});

$('html').on("click", function(e) {
    $('.flight-detail-content-inline').removeClass('show-box-flight-detail').hide();
    $('.flight-detail-content-inline').hide();
});

/* INTER FLIGHT FILTER */
$(document).ready(function(){
    /* FILTER HÃNG HÀNG KHÔNG */
    $('#wgbox').on('change','input:radio[name="rblAirline"]',function(){
        var airline = $(this).val();
        checkAirlines = $('input:radio[name="rblAirline"]:checked').val();
        if(checkAirlines == 'all'){
            $('.interFlightList .select-flight').show();
        } 
        if(checkAirlines != ''){
            $('.interFlightList .select-flight').hide();
            $('.interFlightList .select-flight[data-airline=' + airline + ']').show();   
        } else {    
            $('.interFlightList .select-flight').show();
        }
    });

    /* FILTER ĐIỂM DỪNG */
    $('#wgbox').on('change','input:radio[name="rblTypeFlight"]',function(){
        var typeTransit = [];
        $(".interFlightList .select-flight").hide();
        $("input[name=rblTypeFlight]").each(function() {
            if ($(this).is(':checked')) {
                typeTransit.push($(this).val());
            }
        });
        $.each(typeTransit, function(key, value) {
            $('.interFlightList .select-flight[data-stopno=\"' + value + '\"]').show(); 
        });
        if ($(this).val() == 'all') {
            $(".interFlightList .select-flight").show();
        }
    });
    /* FILTER GIÁ */
    $('#wgbox').on('change','input:radio[name="rblDisplayMode"]',function(){
        var sortValuePrice = $(this).val();
        if(sortValuePrice == 'price') {
            sortListing = [[1,0]];
            
        }
        if(sortValuePrice == "airlines") {
            sortListing = [[0,0]];
        }
        $('#tblInterFlightList').trigger("sorton", [sortListing]);
            $('#tblInterFlightList').tablesorter({
                sortList: sortListing,
             });
        $("#tblInterFlightList tr.select-flight").show();
    });
    

    /* FILTER THỜI GIAN KHỞI HÀNH */
    function showTimeDepartureTicket(minTime, maxTime) {
        minTime = minTime * 100;
        maxTime = maxTime * 100;  
        
        $(".interFlightList .select-flight").hide().filter(function() {    
            var time = $(this).find(".flight-time .time").text();
            var time = time.substring(0,5);
            var time = time.replace(':', '');   
    
            return time >= minTime && time <= maxTime;
        }).show();
    }
          
    function showTimeArrivalTicket(minTime, maxTime) {
        minTime = minTime * 100;
        maxTime = maxTime * 100;

        $(".interFlightList .select-flight").hide().filter(function() {
            var time = $(this).find(".flight-time .time").text();
            var time = time.substring(8,13);
            var time = time.replace(':', ''); 
            
            return time >= minTime && time <= maxTime;
        }).show();

    }
    
    $(function() {
        var options = {
            range: true,
            min: 0,
            max: 24,
            values: [0, 24],
            slide: function(event, ui) {
                var min = ui.values[0],
                    max = ui.values[1];
                $("#time-departure").val(min + "h - " +  max + "h");
                showTimeDepartureTicket(min, max);
            }
        }, min, max;
        
        $("#slider-rangeld").slider(options);
        
        min = $("#slider-rangeld").slider("values", 0);
        max = $("#slider-rangeld").slider("values", 1);
        $("#time-departure").val(min + "h - " +  max + "h");
        showTimeDepartureTicket(min, max);    
                
        var options = {
            range: true,
            min: 0,
            max: 24,
            values: [0, 24],
            slide: function(event, ui) {
                var min1 = ui.values[0],
                    max1 = ui.values[1]; 
                $("#time-arrival").val(min1 + "h - " +  max1 + "h");
                showTimeArrivalTicket(min1, max1); 
            }
        }, min1, max1;   
        
        $("#slider-rangelv").slider(options);
        
        min1 = $("#slider-rangelv").slider("values", 0);
        max1 = $("#slider-rangelv").slider("values", 1); 
        
        $("#time-arrival").val(min1 + "h - " +  max1 + "h");   
        
            showTimeArrivalTicket(min1, max1);
    });

    /* SCROLL TOP CLICK */
    function scrollTopAuto() {
        $('html, body').animate({scrollTop: '0px'}, 3000);
    }

    /* CHANGE CHUYẾN BAY PAGE TIMCHUYENBAY */
    $(".change-search").click(function () {
        $(".container-mobile-inter").toggle("blind");
    });
    
});

function errorHTML() {
    var html = '<div id="sentRequest" class="no-search-filter">\<h2 class="rqtitle">Rất tiếc: Không có kết quả tìm kiếm!</h2>\<p></p></div>';
    return html;
}

/* CLICK CHỌN PAGE CHON-HANH-TRINH */
function selectFlightInter(Direction,value){
    $( "#sm_fselect"+value ).prop( "checked", true );
    if(!document.getElementById("tblInterFlightDep") || (!document.getElementById("tblInterFlightRet"))){
        var dep = checkInterInputValue('selectflightdep');  
        if(dep) {
            document.getElementById("frmSelectFlight").submit();
        }   
    }
}

function checkInterInputValue(className) {
    var radioCheckValue = "";
    for(i = 0; i < document.getElementsByName(className).length; i++) {
      if (document.getElementsByName(className)[i].checked) {
          radioCheckValue = document.getElementsByName(className)[i].value;
      }
    }
    if(radioCheckValue === "") {
        return false;
    }else{
        return true;
    }
}

