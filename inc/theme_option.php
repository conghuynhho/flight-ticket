<?php
/*******************************
THEME OPTIONS PAGE
 ********************************/

add_action('admin_menu', 'fl_theme_page');
$prefix="fl_";
function fl_theme_page ()
{
    if ( count($_POST) > 0 && isset($_POST['fl_settings']) )
    {
        $options = array ('logo_img' ,'logo_alt','textlink','keywords','description','analytics','facebook','gplus','gpluspage','twitter','copyright', 'footer_actions','contact_email','slider','verify_google','verify_bing','txt_footer','hotline',
        'airfee_adult_vn','airfee_child_vn','airfee_infant_vn','airfee_adult_vj','airfee_child_vj','airfee_infant_vj',
        'airfee_adult_js','airfee_child_js','airfee_infant_js','svfee_adult_vn','svfee_child_vn','svfee_infant_vn',
        'svfee_adult_vj','svfee_child_vj','svfee_infant_vj','svfee_adult_js','svfee_child_js','svfee_infant_js',
        'adminfee_adult_vn','adminfee_child_vn','adminfee_infant_vn','adminfee_adult_vj','adminfee_child_vj','adminfee_infant_vj',
        'adminfee_adult_js','adminfee_child_js','adminfee_infant_js','support2471','support2472',
        'bnright_img','bnright_link'
        );
        foreach ( $options as $opt )
        {
            if(isset($_POST[$opt])){
                delete_option ( 'fl_'.$opt, $_POST[$opt] );
                add_option ( 'fl_'.$opt, $_POST[$opt] );
            }
        }

    }
    add_menu_page(__('Flight Theme Config'), __('Flight Theme'), 'edit_themes', basename(__FILE__), 'fl_settings');
    add_submenu_page(__('Flight Options'), __('Flight Options'), 'edit_themes', basename(__FILE__), 'fl_settings');
}

function fl_settings()
{ global $prefix; ?>
<div class="wrap">
<h2>Flight Theme Config</h2>

<form method="post" action="">

<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
    <legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>General Settings</strong></legend>
    <table class="form-table">
        <!-- General settings -->
        <tr valign="top">
            <th scope="row"><label for="logo_img">Change logo</label></th>
            <td>
                <input name="logo_img" type="text" id="logo_img" value="<?php echo get_option('fl_logo_img'); ?>" class="regular-text" /><br />
                    <em>Current logo:</em> <br /> <img src="<?php echo get_option('fl_logo_img'); ?>" alt="<?php echo get_option('fl_logo_alt'); ?>" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="logo_alt">Logo ALT Text</label></th>
            <td>
                <input name="logo_alt" type="text" id="logo_alt" value="<?php echo get_option('fl_logo_alt'); ?>" class="regular-text" />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="logo_alt">Hotline</label></th>
            <td>
                <input name="hotline" type="text" id="hotline" value="<?php echo get_option('fl_hotline'); ?>" class="regular-text" />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="logo_alt">Support 24/7</label></th>
            <td>
                <input name="support2471" type="text" id="support2471" value="<?php echo get_option('fl_support2471'); ?>" class="regular-text" />
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="logo_alt">Support 24/7</label></th>
            <td>
                <input name="support2472" type="text" id="support2472" value="<?php echo get_option('fl_support2472'); ?>" class="regular-text" />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="logo_alt">Banner right (width: 170px)</label></th>
            <td>
                <label style="display: inline-block;width: 120px;">Images</label><input name="bnright_img" type="text" id="bnright_img" value="<?php echo stripslashes(get_option('fl_bnright_img')); ?>" class="regular-text" /><br/>
                <label style="display: inline-block;width: 120px;">Link</label><input name="bnright_link" type="text" id="bnright_link" value="<?php echo stripslashes(get_option('fl_bnright_link')); ?>" class="regular-text" /><br/>
            </td>
        </tr>

    </table>
</fieldset>

<p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    <input type="hidden" name="fl_settings" value="save" style="display:none;" />
</p>

<?php if(current_user_can("manage_options")): ?>
<!--config for fee-->
<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
    <legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Thuế Và Phí</strong></legend>
    <table class="form-table">

        <tr>
            <th><label for="description">Phí sân bay</label></th>
            <td>
                <label style="display: inline-block;width: 120px;">Vietnam Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_adult_vn" value="<?php echo get_option($prefix.'airfee_adult_vn'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_child_vn" value="<?php echo get_option($prefix.'airfee_child_vn'); ?>" />
                 / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_infant_vn" value="<?php echo get_option($prefix.'airfee_infant_vn'); ?>" />

                <br/>
                <label style="display: inline-block;width: 120px;">Vietjet Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_adult_vj" value="<?php echo get_option($prefix.'airfee_adult_vj'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_child_vj" value="<?php echo get_option($prefix.'airfee_child_vj'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_infant_vj" value="<?php echo get_option($prefix.'airfee_infant_vj'); ?>" />
                <br/>
                <label style="display: inline-block;width: 120px;">Jetstar Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_adult_js" value="<?php echo get_option($prefix.'airfee_adult_js'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_child_js" value="<?php echo get_option($prefix.'airfee_child_js'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_infant_js" value="<?php echo get_option($prefix.'airfee_infant_js'); ?>" />
                <br/>
            </td>
        </tr>
        <tr>
            <th><label for="description">Phí Dịch vụ</label></th>
            <td>
                <label style="display: inline-block;width: 120px;">Vietnam Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_adult_vn" value="<?php echo get_option($prefix.'svfee_adult_vn'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_child_vn" value="<?php echo get_option($prefix.'svfee_child_vn'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_infant_vn" value="<?php echo get_option($prefix.'svfee_infant_vn'); ?>" />

                <br/>
                <label style="display: inline-block;width: 120px;">Vietjet Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_adult_vj" value="<?php echo get_option($prefix.'svfee_adult_vj'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_child_vj" value="<?php echo get_option($prefix.'svfee_child_vj'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_infant_vj" value="<?php echo get_option($prefix.'svfee_infant_vj'); ?>" />
                <br/>
                <label style="display: inline-block;width: 120px;">Jetstar Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_adult_js" value="<?php echo get_option($prefix.'svfee_adult_js'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_child_js" value="<?php echo get_option($prefix.'svfee_child_js'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_infant_js" value="<?php echo get_option($prefix.'svfee_infant_js'); ?>" />
                <br/>
            </td>
        </tr>
        <tr>
            <th><label for="description">Phí Admin</label></th>
            <td>
                <label style="display: inline-block;width: 120px;">Vietnam Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_adult_vn" value="<?php echo get_option($prefix.'adminfee_adult_vn'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_child_vn" value="<?php echo get_option($prefix.'adminfee_child_vn'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_infant_vn" value="<?php echo get_option($prefix.'adminfee_infant_vn'); ?>" />

                <br/>
                <label style="display: inline-block;width: 120px;">Vietjet Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_adult_vj" value="<?php echo get_option($prefix.'adminfee_adult_vj'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_child_vj" value="<?php echo get_option($prefix.'adminfee_child_vj'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_infant_vj" value="<?php echo get_option($prefix.'adminfee_infant_vj'); ?>" />
                <br/>
                <label style="display: inline-block;width: 120px;">Jetstar Airline</label>
                Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_adult_js" value="<?php echo get_option($prefix.'adminfee_adult_js'); ?>" /> /
                Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_child_js" value="<?php echo get_option($prefix.'adminfee_child_js'); ?>" />
                / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_infant_js" value="<?php echo get_option($prefix.'adminfee_infant_js'); ?>" />
                <br/>
            </td>
        </tr>

    </table>
</fieldset>
<p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    <input type="hidden" name="fl_settings" value="save" style="display:none;" />
</p>
<?php endif; ?>

<!--config for seo-->
    <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
        <legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>SEO</strong></legend>
        <table class="form-table">

            <tr>
                <th><label for="description">Meta Description</label></th>
                <td>
                    <textarea name="description" id="description" rows="5" cols="70" style="font-size:11px;"><?php echo get_option('fl_description'); ?></textarea>
                </td>
            </tr>
            <tr>
                <th><label for="keywords">Meta Keywords</label></th>
                <td>
                    <textarea name="keywords" id="keywords" rows="5" cols="70" style="font-size:11px;"><?php echo get_option('fl_keywords'); ?></textarea><br />
                    <em>Keywords comma separated</em>
                </td>
            </tr>

            <tr>
                <th><label for="analytics">Google Analytics code:</label></th>
                <td>
                    <textarea name="analytics" id="analytics" rows="5" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('fl_analytics')); ?></textarea>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><label for="verify_google">Verify Google WebMaster</label></th>
                <td>
                    <input name="verify_google" type="text" id="verify_google" size="70" value="<?php echo stripslashes(get_option('fl_verify_google')); ?>" class="regular-text" />
                </td>
            </tr>

            <tr valign="top">
                <th scope="row"><label for="verify_bing">Verify Bing WebMaster</label></th>
                <td>
                    <input name="verify_bing" type="text" id="verify_bing" size="70" value="<?php echo stripslashes(get_option('fl_verify_bing')); ?>" class="regular-text" />
                </td>
            </tr>

        </table>
    </fieldset>
    <p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
        <input type="hidden" name="fl_settings" value="save" style="display:none;" />
    </p>

<!--config for social net work-->
    <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
        <legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>Social Settings</strong></legend>
        <table class="form-table">

            <tr valign="top">
                <th scope="row"><label for="facebook">Facebook Page</label></th>
                <td>
                    <input name="facebook" type="text" id="facebook" size="30" value="<?php echo get_option('fl_facebook'); ?>" class="regular-text" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="gpluspage">Gplus Page</label></th>
                <td>
                    <input name="gpluspage" type="text" id="gpluspage" size="30"  value="<?php echo get_option('fl_gpluspage'); ?>" class="regular-text" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="gplus">Gplus Personal Page</label></th>
                <td>
                    <input name="gplus" type="text" id="gplus" size="30"  value="<?php echo get_option('fl_gplus'); ?>" class="regular-text" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="twitter">Twitter Page</label></th>
                <td>
                    <input name="twitter" type="text" id="twitter" size="30"  value="<?php echo get_option('fl_twitter'); ?>" class="regular-text" />
                </td>
            </tr>
        </table>
    </fieldset>
    <p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
        <input type="hidden" name="fl_settings" value="save" style="display:none;" />
    </p>


<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
    <legend style="margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;"><strong>Homepage Settings</strong></legend>
    <table class="form-table">
        <!-- Homepage Boxes 1 -->
        <tr>
            <th colspan="2"><strong>Homepage Slider </strong></th>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="slider">Homepage Slider Images Page</label></th>
            <td>
                <?php wp_dropdown_pages("name=slider&show_option_none=".__('- Select -')."&selected=" .get_option('fl_slider')); ?>
            </td>
        </tr>

    </table>
</fieldset>
<p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    <input type="hidden" name="fl_settings" value="save" style="display:none;" />
</p>

<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
    <legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Contact Page Settings</strong></legend>
    <table class="form-table">
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="contact_text">Contact Page Text</label></th>
            <td>
                <textarea name="contact_text" id="contact_text" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('fl_contact_text')); ?></textarea>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="contact_email">Email Address for Contact Form</label></th>
            <td>
                <input name="contact_email" type="text" id="contact_email" value="<?php echo get_option('fl_contact_email'); ?>" class="regular-text" />
            </td>
        </tr>

    </table>
</fieldset>

<p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    <input type="hidden" name="fl_settings" value="save" style="display:none;" />
</p>


<fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
    <legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Footer</strong></legend>
    <table class="form-table">
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <th><label for="keywords">Text Link (footer)</label></th>
            <td>
                <textarea name="textlink" id="textlink" rows="3" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('fl_textlink')); ?></textarea><br />
                <em>Text link in footer</em>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="txt_footer">Contact Page Text</label></th>
            <td>
                <textarea name="txt_footer" id="txt_footer" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('fl_txt_footer')); ?></textarea>
            </td>
        </tr>
    </table>
</fieldset>

<p class="submit">
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    <input type="hidden" name="fl_settings" value="save" style="display:none;" />
</p>


</form>
</div>
<?php }
?>