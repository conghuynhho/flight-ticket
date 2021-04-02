$(document).ready(function() {
    $(".rdbdirection").click(function() {

        flighttype = $(this).val();
        if (flighttype == 1) {
            $("#arv_date").attr("disabled", "disabled");
        } else {
            $("#arv_date").removeAttr("disabled");
        }
    });
	if ($(".rdbdirection:checked").val() == 1) {
		$("#arv_date").attr("disabled", "disabled");
	}
 	
	
    /*Process Select City*/

    $("#dep_code").click(function() {
        $("#listDep").fadeIn("fast");
        $(this).select();
    })
    $("#arv_code").click(function() {
        $("#listDes").fadeIn("fast");
        $(this).select();
    })

    $("body").click(function(e) {
        if ($.trim($(e.target).closest("#listDep").html()) == '' && !$(e.target).is("#dep_code") && !$(e.target).is(".ui-corner-all")) {
            if ($("#listDep").is(":visible"))
                $("#listDep").hide();
        }
        if ($.trim($(e.target).closest("#listDes").html()) == '' && !$(e.target).is("#arv_code") && !$(e.target).is(".ui-corner-all")) {
            if ($("#listDes").is(":visible"))
                $("#listDes").hide();
        }
    })

    $("#listDep li a").click(function() {
        $("#dep_code").val($(this).text());
        $("#dep").val($(this).attr("data-city"));

        if ($("#dep").val() == $("#des").val()) {
            $("#arv_code").val("");
            $("#des").val("");
        }
        $("#listDes li").show();
        var depcity = $("#dep").val();
        $("#listDes a[data-city=" + depcity + "]").parent().hide();

        $("#listDep").fadeOut("fast");
        $("#listDes").fadeIn("fast");
        $("#arv_code").select();
        return false;
    })

    $("#listDes li a").click(function() {
        arvplace = $(this).attr("data-city");
        if (arvplace == $("#dep").val()) {
			 notie.alert(3, 'Điểm đi và điểm đến không được trùng!!', 2);
        } else {
            $("#arv_code").val($(this).text());
            $("#listDes").find(".err").text("");
            $("#des").val($(this).attr("data-city"));
            $("#listDes").fadeOut("fast");
        }
        return false;
    })


    /*End Process Select City*/
	

	//change CAPTCHA on each click or on refreshing page
    $("#reload").click(function() {
	
        $("img#img").remove();
		var id = Math.random();
        $('<img id="img" src="https://timchuyenbay.com/assets/themes/goibibo/captcha.php?id='+id+'"/>').appendTo("#imgdiv");
		 id ='';
    });

//validation function
    $('#BtnSearch').click(function() {
		date = "05-2013";
		date = date.split("-").reverse().join("");

		$("#customer_date").val(date);

		var dep_date = $("#dep_date").val();
		var dep_date = dep_date.split("-").reverse().join("");
		var arv_date = $("#arv_date").val();
		var arv_date = arv_date.split("-").reverse().join("");
		
		if ($(".rdbdirection:checked").val() != 1) {
			if(dep_date > arv_date){
				 notie.alert(3, 'Vui lòng chọn lại tháng.', 2);
			  return false;
			}
		}
		
		var captcha = $("#captcha1").val();
		if (captcha == '')
        {
             notie.alert(3, 'Vui lòng nhập captcha.', 2);
			 return false;
        }

        else
        {	//validating CAPTCHA with user input text
            var dataString = 'captcha=' + captcha;
			var returnVal = false;
            $.ajax({
				async: false,
                type: "POST",
                url: "https://timchuyenbay.com/assets/themes/goibibo/verify.php",
                data: dataString,
                success: function(html) {
					if (html == '1') {
					  returnVal = true;
					} else {
					   returnVal = false;
					};
                }
            });
			if(returnVal==false){
				notie.alert(3, 'Vui lòng nhập lại captcha.', 2);
				$('#captcha1').focus();
				return false;
			}else{
				return true;
			}
        }
    });
});
  