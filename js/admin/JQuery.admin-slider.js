/**
 * User: Lak
 * Date: 7/8/13
 * Time: 3:42 PM
 */
siteurl=myvar.siteurl;
jQuery(document).ready(function($){
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;


    $('.lak_uploadbutton').live('click',function(e) {

        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        var slider=button.closest(".lak-upload-table").find(".idname").val();
        var id = button.attr('id').replace('_button', '');
        _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment){
            if ( _custom_media ) {
                $("#"+id).val(attachment.url);
                $("#thumb"+id).attr("src",attachment.url);

            } else {
                return _orig_send_attachment.apply( this, [props, attachment] );
            };
        }

        wp.media.editor.open(button);
        return false;
    });

    $('.add_media').on('click', function(){
        _custom_media = false;
    });



    /*For slider box*/

    $(".add_more_slider").click(function(){
        table=$(this).closest(".lak-upload-table");
        var stt=parseInt(table.find(".stt_slider").val())+1;
        var slider=table.find(".idname").val();
        table.find(".stt_slider").val(stt);

        html_field='<tr class="tr-data"> ';
        html_field+='<th scope="row"><label for="logo_img">Slide '+stt+'</label></th> ';
        html_field+='<td class="input_field" width="500"> <label>Image src </label><input type="text" name="slider_img'+slider+'[]" id="_slide'+slider+stt+'" class="regular-text" />';
        html_field+='<input type="button" class="lak_uploadbutton button" name="_slide_'+stt+'_button" id="_slide'+slider+stt+'_button" value="Insert" /><br/>';
		html_field+='<label>Link</label><input type="text" name="slider_link'+slider+'[]" id="slide_link_'+stt+'" class="regular-text" />';
        html_field+='<label>Title</label><input type="text" name="slider_title'+slider+'[]" id="slide_title_'+stt+'" class="regular-text" /><p><input type="button" class="button btn_remove_slide" value="( - ) Remove"></p></td><td class="td-img"><img src=""  id="thumb_slide'+slider+stt+'" alt="" height="100"></td></tr> ';


        if(table.find("tr.tr-data").val() == undefined){
            table.find("tr").after(html_field);
        }else{
            table.find("tr.tr-data:last-child").after(html_field);
        }
    })

    $(".btn_remove_slide").live('click',function(){
        $(this).closest('tr').remove();
    })

});