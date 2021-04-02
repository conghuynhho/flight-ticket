/**
 * User: Lak
 * Date: 7/8/13
 * Time: 3:42 PM
 */
jQuery(document).ready(function($){
//    ajaxurl : since 2.8 is always defined in the admin header and points to admin-ajax.php
    $("#c_arvcode").autocomplete({
        source: ajaxurl+"?action=lk-ajax-call",
        minLength: 2,
        select: function( event, ui ) {
            $("#arvcode").val(ui.item.code)
            $("#c_arvcode").val(ui.item.label)
            $("#c_arvcode").val(ui.item.label)
            $("#lbl-cr-choise").html(ui.item.label)

        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });

})