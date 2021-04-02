<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Lak
 * Date: 7/6/13
 * Time: 9:46 PM
 * To change this template use File | Settings | File Templates.
 */
/*******************************
THEME OPTIONS PAGE
********************************/

add_action('admin_menu', 'lk_slider_theme_page');
function lk_slider_theme_page ()
{
if ( count($_POST) > 0 && isset($_POST['theme_settings']) )
{

    if($_POST['slider_img']){
        $img_src=$_POST['slider_img'];
        $link=$_POST['slider_link'];
		$title=$_POST['slider_title'];
        $arr_slider=array();
        for($i=0;$i<count($img_src);$i++){
            if($img_src[$i]!=""){
                $arr_slider[$i]['img']=$img_src[$i];
                $arr_slider[$i]['link']=$link[$i];
				$arr_slider[$i]['title']=$title[$i];
            }
        }
        delete_option("theme_slider");
        add_option('theme_slider',$arr_slider);
    }

    if($_POST['slider_img_logo']){
        $img_src=$_POST['slider_img_logo'];
        $link=$_POST['slider_link_logo'];
        $arr_slider=array();
        for($i=0;$i<count($img_src);$i++){
            if($img_src[$i]!=""){
                $arr_slider[$i]['img']=$img_src[$i];
                $arr_slider[$i]['link']=$link[$i];
            }
        }
        delete_option("slider_logo_inter");
        add_option('slider_logo_inter',$arr_slider);
    }

    if($_POST['slider_img_home_left']){
        $img_src=$_POST['slider_img_home_left'];
        $link=$_POST['slider_link_home_left'];
        $arr_slider=array();
        for($i=0;$i<count($img_src);$i++){
            if($img_src[$i]!=""){
                $arr_slider[$i]['img']=$img_src[$i];
                $arr_slider[$i]['link']=$link[$i];
            }
        }
        delete_option("slider_home_left");
        add_option('slider_home_left',$arr_slider);
    }

    if($_POST['slider_img_home_right']){
        $img_src=$_POST['slider_img_home_right'];
        $link=$_POST['slider_link_home_right'];
        $arr_slider=array();
        for($i=0;$i<count($img_src);$i++){
            if($img_src[$i]!=""){
                $arr_slider[$i]['img']=$img_src[$i];
                $arr_slider[$i]['link']=$link[$i];
            }
        }
        delete_option("slider_home_right");
        add_option('slider_home_right',$arr_slider);
    }


    $options = array ('img_kmquocte_1','img_kmquocte_2','img_kmquocte_3','link_kmquocte_3','link_kmquocte_2','link_kmquocte_1',
    'img_khtu_hcm','img_khtu_dn','img_khtu_hn','link_khtu_hcm','link_khtu_hn','link_khtu_dn','img_mid_banner','link_mid_banner'
    );

    foreach ( $options as $opt )
    {
        if(!empty($_POST[$opt]))
        {
            delete_option ( $opt, $_POST[$opt] );
            add_option ( $opt, $_POST[$opt] );
        }
    }

}
add_submenu_page('lak-admin-user-option', __('Config Slider'), __('Config Slider'), 'edit_others_posts', 'lak-admin-user-config-slider', 'user_slider_settings');
}
function user_slider_settings()
{
    ?>
<style type="text/css">
    .fieldset{border:1px solid #ddd; padding-bottom:20px; margin-top:20px;}
    .legend{margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;font-weight: bold;}
    td label{display: inline-block;width:85px;}
    td.td-img img{max-width: 400px;}
</style>
<?php
    global $prefix;
    wp_enqueue_media();

    $idname="";
    $theme_slider=get_option("theme_slider");
    if(empty($theme_slider))
        $count_slider=0;
    else
        $count_slider=count($theme_slider);

    ?>

<div class="wrap">
    <h2>Configs Slider</h2>

    <form method="post" action="">


        <!--Config for slider setting-->
        <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;" id="user_setting_theme">
            <legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;">
                <strong>Slider Chính</strong>
            </legend>
            <table class="lak-upload-table form-table stag-metabox-table">
                <!-- General settings -->
                <tr valign="top">
                    <td colspan="3" align="left">
                        <input type="button" class="button add_more_slider" id="add_more_slider_main" value="( + ) Add">
                        <br/><em>Kích thước hình : 650 x 450 (px)</em>
                        <input type="hidden" name="stt_slider" class="stt_slider" value="<?php echo $count_slider?>" />
                        <input type="hidden" name="idname" class="idname" value="<?php echo $idname?>" />
                    </td>
                </tr>
                <?php
                $stt=0;
                if($theme_slider):
                    foreach($theme_slider as $slider){
                        $stt++;
                        ?>
                        <tr valign="top" class="tr-data">
                            <th scope="row"><label for="logo_img">Slide <?php echo $stt?></label></th>
                            <td class="input_field"  width="500">
                                <label>Image src </label><input type="text" name="slider_img[]" id="_slide_<?php echo $stt?>" class="regular-text" value="<?php echo $slider["img"]?>" />
                                <input type="button"  class="lak_uploadbutton button" name="_slide_<?php echo $stt?>_button" id="_slide_<?php echo $stt?>_button" value="Insert" /><br/>
                                <label>Link</label><input placeholder="<?php bloginfo('url'); ?>" type="text" name="slider_link[]" id="slide_link_<?php echo $stt?>" class="regular-text" value="<?php echo $slider["link"]?>" />
                                <label>Title</label><input type="text" name="slider_title[]" id="slider_title<?php echo $stt?>" class="regular-text" value="<?php echo $slider["title"]?>" />
                                <p><input type="button"  class="button btn_remove_slide" value="( - ) Remove"></p>
                            </td>
                            <td class="td-img">
                                <img id="thumb_slide_<?php echo $stt?>" src="<?php echo $slider["img"]?>" alt="" height="100">
                            </td>
                        </tr>

                        <?php
                    }
                endif;
                ?>
            </table>
        </fieldset>

        <p class="submit">
            <input type="submit" name="theme_settings" class="button-primary" value="Save Changes" />
            <input type="hidden" name="ink_user_settings" value="save" style="display:none;" />
        </p>

<?php } ?>