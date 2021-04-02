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

add_action('admin_menu', 'lk_user_theme_page');
function lk_user_theme_page ()
{
if ( count($_POST) > 0 && isset($_POST['theme_settings']) )
{
    $options = array ('logo','phone','phone2','phone3','footeradd','contactemail','facebook','gplus','twiter','app_android_link','app_ios_link','introtitle','introcontent','headtext',
        'keywords','description','analytics','title_cheap_airline','grp_sep','dec_sep','decimals','hotline','hotline2','hotline3','yhsupport1','yhsupport2','yhsale','iscache'
		,'hotline_inter', 'hotline_domes', 'contactemail2','delivery_fee','support1','support2','post_signal','end_post','address_shortcode'
		,'home_news_id','foot_col1_id', 'foot_col2_id', 'foot_col3_id', 'foot_col4_id', 'foot_col5_id', 'foot_col6_id'
        ,'footer_number_posts', 'footer_row_1_1', 'footer_row_1_2', 'footer_row_1_3', 'footer_row_1_4', 'footer_row_2_1', 'footer_row_2_2', 'footer_row_2_3', 'com_name_shortcode'
        ,'accountant_phone', 'primary_address', 'google_tag_manager', 'google_tag_manager_no_script', 'google_map'
    );

    foreach ( $options as $opt )
    {

        if(!empty($_POST[$opt]))
        {
            delete_option ( 'opt_'.$opt, $_POST[$opt] );
            add_option ( 'opt_'.$opt, $_POST[$opt] );
        }
    }

}
add_menu_page(__('Configs Your Site'), __('Theme options'), 'edit_others_posts', 'lak-admin-user-option', 'user_theme_settings');
}
function user_theme_settings()
{?>
  <style type="text/css">
      fieldset{border:1px solid #ddd; padding: 10px 20px;}
      legend{margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;font-weight: bold;}
  </style>
<div class="wrap">
    <h2>Cấu hình thiết lập giao diện</h2>
    <form method="post" action="">
        <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
            <legend><strong>Thiết lập giao diện tổng quan</strong></legend>
            <table class="form-table">
                <!-- General settings -->
                <tr valign="top">
                    <th scope="row"><label for="logo">Change logo</label></th>
                    <td>
                        <input name="logo" type="text" id="logo" value="<?php echo  get_option('opt_logo'); ?>" class="regular-text" /><br />
                        <em>Current logo:</em> <br /> <img src="<?php echo get_option('opt_logo'); ?>" alt="<?php echo get_option('opt_logo'); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label>Header Text</label></th>
                    <td>
                        <input name="headtext" type="text" id="headtext" value="<?php echo get_option('opt_headtext'); ?>" class="regular-text" />
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label>Phone</label></th>
                    <td>
                        <input name="phone" type="text" id="phone" value="<?php echo get_option('opt_phone'); ?>" class="regular-text" />
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label>Phone 2</label></th>
                    <td>
                        <input name="phone2" type="text" id="phone2" value="<?php echo get_option('opt_phone2'); ?>" class="regular-text" />
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label>Phone 3</label></th>
                    <td>
                        <input name="phone3" type="text" id="phone3" value="<?php echo get_option('opt_phone3'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Primary Address</label></th>
                    <td>
                        <input name="primary_address" type="text" id="primary_address" value="<?php echo get_option('opt_primary_address'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Accountant Phone</label></th>
                    <td>
                        <input name="accountant_phone" type="text" id="accountant_phone" value="<?php echo get_option('opt_accountant_phone'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Is Cache</label></th>
                    <td>
                        <input name="iscache" type="text" id="iscache" value="<?php echo get_option('opt_iscache'); ?>" class="regular-text" />
						<br/>
						<span>1 : Cache, 2 : No Cache</span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Hotline 1</label></th>
                    <td>
                        <input name="hotline" type="text" id="hotline" value="<?php echo get_option('opt_hotline'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Hotline 2</label></th>
                    <td>
                        <input name="hotline2" type="text" id="hotline2" value="<?php echo get_option('opt_hotline2'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Hotline 3</label></th>
                    <td>
                        <input name="hotline3" type="text" id="hotline3" value="<?php echo get_option('opt_hotline3'); ?>" class="regular-text" />
                    </td>
                </tr>               
                <tr valign="top">
                    <th scope="row"><label>Hotline International</label></th>
                    <td>
                        <input name="hotline_inter" type="text" id="hotline_inter" value="<?php echo get_option('opt_hotline_inter'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Hotline Domestic</label></th>
                    <td>
                        <input name="hotline_domes" type="text" id="hotline_domes" value="<?php echo get_option('opt_hotline_domes'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Support24/7</label></th>
                    <td>
                        <input name="support1" type="text" id="support1" value="<?php echo get_option('opt_support1'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Support24/7</label></th>
                    <td>
                        <input name="support2" type="text" id="support2" value="<?php echo get_option('opt_support2'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Yahoo Support 1</label></th>
                    <td>
                        <input name="yhsupport1" type="text" id="yhsupport1" value="<?php echo get_option('opt_yhsupport1'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Yahoo Support 2</label></th>
                    <td>
                        <input name="yhsupport2" type="text" id="yhsupport2" value="<?php echo get_option('opt_yhsupport2'); ?>" class="regular-text" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label>Yahoo Sale</label></th>
                    <td>
                        <input name="yhsale" type="text" id="yhsale" value="<?php echo get_option('opt_yhsale'); ?>" class="regular-text" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label>Contact Email 1</label></th>
                    <td>
                        <input name="contactemail" type="text" id="contactemail" value="<?php echo get_option('opt_contactemail'); ?>" class="regular-text" />
                    </td>
                </tr>
                
                <tr valign="top">
                    <th scope="row"><label>Contact Email 2</label></th>
                    <td>
                        <input name="contactemail2" type="text" id="contactemail2" value="<?php echo get_option('opt_contactemail2'); ?>" class="regular-text" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label>Facebook Link</label></th>
                    <td>
                        <input name="facebook" type="text" id="facebook" value="<?php echo get_option('opt_facebook'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Gplus Link</label></th>
                    <td>
                        <input name="gplus" type="text" id="gplus" value="<?php echo get_option('opt_gplus'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Twitter Link</label></th>
                    <td>
                        <input name="twiter" type="text" id="twiter" value="<?php echo get_option('opt_twiter'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>App Android Link</label></th>
                    <td>
                        <input name="app_android_link" type="text" id="app_android_link" value="<?php echo get_option('opt_app_android_link'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>App Ios Link</label></th>
                    <td>
                        <input name="app_ios_link" type="text" id="app_ios_link" value="<?php echo get_option('opt_app_ios_link'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="introcontent">intro Title</label></th>
                    <td>
                        <textarea name="introcontent" id="introcontent" rows="4" cols="140" style="font-size:11px;"><?php echo stripslashes(get_option('opt_introcontent')); ?></textarea><br />
                        <em>You can use HTML for links etc.</em>
                    </td>
                </tr>
                <tr>
                    <th><label for="footeradd">Footer address</label></th>
                    <td>
                        <textarea name="footeradd" id="footeradd" rows="4" cols="140" style="font-size:11px;"><?php echo stripslashes(get_option('opt_footeradd')); ?></textarea><br />
                        <em>You can use HTML for links etc.</em>
                    </td>
                </tr>
				<tr>
					<th><label for="post_signal">Post Signal</label></th>
					<td>
						<textarea name="post_signal" id="post_signal" rows="4" cols="140" style="font-size:11px;"><?php echo stripslashes(get_option('opt_post_signal')); ?></textarea><br />
					</td>
				</tr> 
                <tr>
					<th><label for="end_post">End Post</label></th>
					<td>
						<textarea name="end_post" id="end_post" rows="4" cols="140" style="font-size:11px;"><?php echo stripslashes(get_option('opt_end_post')); ?></textarea><br />
					</td>
				</tr>
				<tr>
                  <th><label for="address_shortcode">Address Shortcode</label></th>
                  <td><textarea name="address_shortcode" id="address_shortcode" rows="4" cols="140" style="font-size:11px;"><?php echo stripslashes(get_option('opt_address_shortcode')); ?></textarea>
                    <br /></td>
                </tr>	
				<tr valign="top">
                    <th scope="row"><label>Company name shortcode</label></th>
                    <td>
                        <input name="com_name_shortcode" type="text" id="com_name_shortcode" value="<?php echo get_option('opt_com_name_shortcode'); ?>" class="regular-text" />
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label>Footer Number Of Posts</label></th>
                    <td>
                        <input name="footer_number_posts" type="text" id="footer_number_posts" value="<?php echo get_option('opt_footer_number_posts'); ?>" class="regular-text" />
                    </td>
                </tr>
				<tr valign="top">
                    <th scope="row"><label>Homepage Load Category ID</label></th>
                    <td>
						Ban Tin Du Lich ID: <input style="width:100px" name="home_news_id" type="text" id="home_news_id" value="<?php echo get_option('opt_home_news_id'); ?>" class="regular-text" />
						<br>
                        Ve May Bay Noi Dia ID: <input style="width:100px" name="foot_col1_id" type="text" id="foot_col1_id" value="<?php echo get_option('opt_foot_col1_id'); ?>" class="regular-text" />
						&nbsp;
						Ve May Bay Quoc Te ID: <input style="width:100px" name="foot_col2_id" type="text" id="foot_col2_id" value="<?php echo get_option('opt_foot_col2_id'); ?>" class="regular-text" />
						<br>
						Ve May Bay Theo Hang ID: <input style="width:100px" name="foot_col3_id" type="text" id="foot_col3_id" value="<?php echo get_option('opt_foot_col3_id'); ?>" class="regular-text" />
						&nbsp;
						Ve May Bay Tet ID: <input style="width:100px" name="foot_col4_id" type="text" id="foot_col4_id" value="<?php echo get_option('opt_foot_col4_id'); ?>" class="regular-text" />
						<br>
						Ho Tro Khach Hang ID: <input style="width:100px" name="foot_col5_id" type="text" id="foot_col5_id" value="<?php echo get_option('opt_foot_col5_id'); ?>" class="regular-text" />
						&nbsp;
						Cac Quy Dinh ID: <input style="width:100px" name="foot_col6_id" type="text" id="foot_col6_id" value="<?php echo get_option('opt_foot_col6_id'); ?>" class="regular-text" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label>Footer Row 1</label></th>
                    <td>
                        <label style="vertical-align: top">Column 1:</label>&nbsp;&nbsp;<textarea name="footer_row_1_1" id="footer_row_1_1" rows="9" cols="120" style="font-size:11px;"><?php echo stripslashes(get_option('opt_footer_row_1_1')); ?></textarea>
                        <br>
                        <label style="vertical-align: top">Column 2:</label>&nbsp;&nbsp;<textarea name="footer_row_1_2" id="footer_row_1_2" rows="9" cols="120" style="font-size:11px;"><?php echo stripslashes(get_option('opt_footer_row_1_2')); ?></textarea>
                        <br>
                        <label style="vertical-align: top">Column 3:</label>&nbsp;&nbsp;<textarea name="footer_row_1_3" id="footer_row_1_3" rows="9" cols="120" style="font-size:11px;"><?php echo stripslashes(get_option('opt_footer_row_1_3')); ?></textarea>
                        <br>
                        <label style="vertical-align: top">Column 4:</label>&nbsp;&nbsp;<textarea name="footer_row_1_4" id="footer_row_1_4" rows="9" cols="120" style="font-size:11px;"><?php echo stripslashes(get_option('opt_footer_row_1_4')); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Footer Row 2</th>
                    <td>
                        <label style="vertical-align: top">Column 1:</label>&nbsp;&nbsp;<textarea name="footer_row_2_1" id="footer_row_2_1" rows="4" cols="120" style="font-size: 11px"><?php echo stripslashes(get_option("opt_footer_row_2_1"));?></textarea>
                        <br>
                        <label style="vertical-align: top">Column 2:</label>&nbsp;&nbsp;<textarea name="footer_row_2_2" id="footer_row_2_2" rows="4" cols="120" style="font-size: 11px"><?php echo stripslashes(get_option("opt_footer_row_2_2"));?></textarea>
                        <br>
                        <label style="vertical-align: top">Column 3:</label>&nbsp;&nbsp;<textarea name="footer_row_2_3" id="footer_row_2_3" rows="4" cols="120" style="font-size: 11px"><?php echo stripslashes(get_option("opt_footer_row_2_3"));?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="google_map">Bản đồ google map</label></th>
                    <td>
                        <textarea name="google_map" id="google_map" rows="4" cols="140" style="font-size:11px;"><?php echo get_option('opt_google_map'); ?></textarea><br />
                        <em>You can for links google map.</em>
                    </td>
                </tr>
            </table>
        </fieldset>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
            <input type="hidden" name="theme_settings" value="save" style="display:none;" />
        </p>
        <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
            <legend style=""><strong>SEO</strong></legend>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label>Tiêu đề mẹo SVMB giá rẻ</label></th>
                    <td>
                        <input name="title_cheap_airline" type="text" id="title_cheap_airline" value="<?php echo get_option('opt_title_cheap_airline'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Dấu phân cách hàng nghìn</label></th>
                    <td>
                        <input name="grp_sep" type="text" id="grp_sep" value="<?php echo get_option('opt_grp_sep'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Dấu phân cách số thập phân</label></th>
                    <td>
                        <input name="dec_sep" type="text" id="dec_sep" value="<?php echo get_option('opt_dec_sep'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label>Số chữ số thập phân</label></th>
                    <td>
                        <input name="decimals" type="text" id="decimals" value="<?php echo get_option('opt_decimals'); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="description">Meta Description</label></th>
                    <td>
                        <textarea name="description" id="description" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('opt_description'); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="keywords">Meta Keywords</label></th>
                    <td>
                        <textarea name="keywords" id="keywords" rows="7" cols="70" style="font-size:11px;"><?php echo get_option('opt_keywords'); ?></textarea><br />
                        <em>Keywords comma separated</em>
                    </td>
                </tr>
                <tr>
                    <th><label for="analytics">Google Analytics code:</label></th>
                    <td>
                        <textarea name="analytics" id="analytics" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('opt_analytics')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="google_tag_manager">Google Tag Manager code:</label></th>
                    <td>
                        <textarea name="google_tag_manager" id="google_tag_manager" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('opt_google_tag_manager')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label for="google_tag_manager_no_script">Google Tag Manager No Script code:</label></th>
                    <td>
                        <textarea name="google_tag_manager_no_script" id="google_tag_manager_no_script" rows="7" cols="70" style="font-size:11px;"><?php echo stripslashes(get_option('opt_google_tag_manager_no_script')); ?></textarea>
                    </td>
                </tr>
            </table>
        </fieldset>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
            <input type="hidden" name="theme_settings" value="save" style="display:none;" />
        </p>
    </form>
</div>
<?php } ?>