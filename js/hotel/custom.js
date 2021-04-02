
$('.form-group').each(function() {
    var self = $(this),
        input = self.find('input');

    input.focus(function() {
        self.addClass('form-group-focus');
    })

    input.blur(function() {
        if (input.val()) {
            self.addClass('form-group-filled');
        } else {
            self.removeClass('form-group-filled');
        }
        self.removeClass('form-group-focus');
    });
});

 

var areas = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('area_name_vi', 'area_name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,

  prefetch: 'https://timchuyenbay.com/assets/themes/goibibo/inc/area_info.json'
});
var locals = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('local_name_vi', 'local_name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,

  prefetch: 'https://timchuyenbay.com/assets/themes/goibibo/inc/local_info.json'
});
var hotels = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('str_search'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 'https://timchuyenbay.com/assets/themes/goibibo/inc/hotel_info.json'
});

 
 
$('.typeahead').typeahead({
  hint: true,
  },
    { name: 'locals',
    display: 'local_name_vi',
    source: locals,
    templates: {
      suggestion: function(data) { // data is an object as returned by suggestion engine
          return '<div class="tt-suggest-page">' + data.local_name_vi + ' ('+ data.total + ')' + '</div>';
     }
    }
  },
  { name: 'areas',
    display: 'area_name_vi',
    source: areas,
    templates: {
      suggestion: function(data) { // data is an object as returned by suggestion engine
          return '<div class="tt-suggest-page">' + data.area_name_vi + ' ('+ data.total + ')' + '</div>';
      }
  }
},
   { name: 'hotels',
    display: 'str_search',
    source: hotels,
    templates: {
      suggestion: function(data) { // data is an object as returned by suggestion engine
          return '<div class="tt-suggest-page">' + data.str_search + '</div>';
     }
    }
  }
);
$('.nav-drop').dropit();
$(document).ready(function () {
    var $range = $("#range"),
        $result = $("#result");
    var track = function () {
        var $this = $(this),
            value = $this.prop("value");

        $result.html("Value: " + value);
    };

    $range.ionRangeSlider({
        type: "single",
        min: 100000,
        max: 20000000,
        step: 100000,
        from: 20000000,
        prettify_enabled: true,
        onFinish: function (data) {
            $('#filter').submit();
        }
    });
    $range.on("change", track);
});

$('.i-check, .i-radio').iCheck({
    checkboxClass: 'i-check',
    radioClass: 'i-radio'
});

 
 
 

 


$('.booking-item-review-expand').click(function(event) {
    console.log('baz');
    var parent = $(this).parent('.booking-item-review-content');
    if (parent.hasClass('expanded')) {
        parent.removeClass('expanded');
    } else {
        parent.addClass('expanded');
    }
});


$('.stats-list-select > li > .booking-item-rating-stars > li').each(function() {
    var list = $(this).parent(),
        listItems = list.children(),
        itemIndex = $(this).index();

    $(this).hover(function() {
        for (var i = 0; i < listItems.length; i++) {
            if (i <= itemIndex) {
                $(listItems[i]).addClass('hovered');
            } else {
                break;
            }
        };
        $(this).click(function() {
            for (var i = 0; i < listItems.length; i++) {
                if (i <= itemIndex) {
                    $(listItems[i]).addClass('selected');
                } else {
                    $(listItems[i]).removeClass('selected');
                }
            };
        });
    }, function() {
        listItems.removeClass('hovered');
    });
});



$('.booking-bl-item-container').children('.booking-bl-item').click(function(event) {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).parent().removeClass('active');
    } else {
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $(this).delay(1500).queue(function() {
            $(this).addClass('viewed')
        });
    }
});

$('.booking-vj-item-container').children('.booking-vj-item').click(function(event) {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        $(this).parent().removeClass('active');
    } else {
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $(this).delay(1500).queue(function() {
            $(this).addClass('viewed')
        });
    }
});


 

 
 
 


$('.form-group-select-plus').each(function() {
    var self = $(this),
        btnGroup = self.find('.btn-group').first(),
        select = self.find('select');
    btnGroup.children('label').last().click(function() {
        btnGroup.addClass('hidden');
        select.removeClass('hidden');
    });
});
 

 
 
// filter hotels
$('input').on('ifChanged', function(event){
$('#filter').submit();
});

 
function cartAction(action,product_code) {
var queryString = "";
    if(action != "") {
        switch(action) {
            case "add":
                queryString = 'action='+action+'&code='+ product_code+'&check_out='+$("#check_out_"+product_code).val()+
                '&check_in='+$("#check_in_"+product_code).val()+
                '&hotel_star='+$("#hotel_star_"+product_code).val()+
                '&hotel_add='+$("#hotel_add_"+product_code).val()+
                '&hotel_name='+$("#hotel_name_"+product_code).val()+
                '&room_days='+$("#room_days_"+product_code).val()+
                '&room_max='+$("#room_max_"+product_code).val()+
                '&room_img='+$("#room_img_"+product_code).val()+
                '&room_price='+$("#room_price_"+product_code).val()+
                '&room_available='+$("#room_available_"+product_code).val()+
                '&service_fee='+$("#service_fee_"+product_code).val()+
                '&delivery_fee='+$("#delivery_fee_"+product_code).val()+
                '&discount_amount='+$("#discount_amount_"+product_code).val()+
                '&hotel_id='+$("#hotel_id_"+product_code).val()+
                '&total_guest='+$("#total_guest_"+product_code).val()+
                '&provider='+$("#provider_"+product_code).val()+
                '&name='+$("#room_name_"+product_code).val();
            break;
            case "remove":
                queryString = 'action='+action+'&code='+ product_code;
            break;
            case "empty":
                queryString = 'action='+action;
            break;
        }    
    }
        $.ajax({
            url: "https://timchuyenbay.com/assets/themes/namphuong2016/core/add-rooms.php",
            data: queryString,
            type: "POST",
        success:function(data){
            $("#cart-item").html(data);
            if(action != "") {
                switch(action) {
                    case "add":
                        $("#add_"+product_code).hide();
                        $("#added_"+product_code).show();
                            
                    break;
                    case "remove":
                        $("#add_"+product_code).show();
                        $("#added_"+product_code).hide();
                          
                    break;
                    case "empty":
                        $(".btnAddAction").show();
                        $(".btnAdded").hide();
                    break;
                }    
            }
    },
    error:function (){}
    }); 
}
 