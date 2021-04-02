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

add_action('admin_menu', 'lk_theme_page');
function lk_theme_page ()
{
if ( count($_POST) > 0 && isset($_POST['fl_settings']) )
{
    $options = array (
        'airfee_adult_vn','airfee_child_vn','airfee_infant_vn',
        'airfee_adult_vj','airfee_child_vj','airfee_infant_vj',
        'airfee_adult_js','airfee_child_js','airfee_infant_js',
        'airfee_adult_qh','airfee_child_qh','airfee_infant_qh',
        'svfee_adult_vn','svfee_child_vn','svfee_infant_vn',
        'svfee_adult_vj','svfee_child_vj','svfee_infant_vj',
        'svfee_adult_js','svfee_child_js','svfee_infant_js',
        'svfee_adult_qh','svfee_child_qh','svfee_infant_qh',
        'adminfee_adult_vn','adminfee_child_vn','adminfee_infant_vn',
        'adminfee_adult_vj','adminfee_child_vj','adminfee_infant_vj',
        'adminfee_adult_js','adminfee_child_js','adminfee_infant_js',
        'adminfee_adult_qh','adminfee_child_qh','adminfee_infant_qh',
        'inter_adt_svfee','inter_chd_svfee','inter_inf_svfee',
        'exchange_rate','delivery_fee','eur_exchange_rate',
        
        /* THIẾT LẬP THUẾ PHÍ QUỐC TẾ */
        'southeast_asia_airport',
        'southeast_asia_adult_svfee',
        'southeast_asia_child_svfee',
        'southeast_asia_infant_svfee',
        'northeast_asia_airport',
        'northeast_asia_adult_svfee',
        'northeast_asia_child_svfee',
        'northeast_asia_infant_svfee',
        'europe_airport',
        'europe_adult_svfee',
        'europe_child_svfee',
        'europe_infant_svfee',
        'americas_airport',
        'americas_adult_svfee',
        'americas_child_svfee',
        'americas_infant_svfee',
        'australia_airport',
        'australia_adult_svfee',
        'australia_child_svfee',
        'australia_infant_svfee',
        'africa_airport',
        'africa_adult_svfee',
        'africa_child_svfee',
        'africa_infant_svfee',
        'inter_adult_svfee',
        'inter_child_svfee',
        'inter_infant_svfee',
        'sabre_agent_id',

        'promo_svfee_1', // base price <= 100k, +55k
        'promo_svfee_2', // base price > 100k and <= 300k, +40k
        'promo_svfee_3', // base price > 300k and <= 500k, +25k
    );


    foreach ( $options as $opt )
    {
        if(isset($_POST[$opt]) && $_POST[$opt]!="")
        {
            delete_option ( 'opt_'.$opt, $_POST[$opt] );
            add_option ( 'opt_'.$opt, $_POST[$opt] );
        }

    }

}
add_menu_page(__('Thiết Lập Thuế Phí'), __('Thuế Phí'), 'remove_users', 'lak-admin-option', 'theme_settings');
}
function theme_settings()
{
    $prefix="opt_"
    ?>
    <style type="text/css">
        fieldset{border:1px solid #ddd; padding: 10px 20px;}
        legend{margin-left:5px; padding:0 5px;color:#2481C6; text-transform:uppercase;font-weight: bold;}
    </style>
<div class="wrap">
    <h2>Thiết Lập Thuế Phí</h2>

    <form method="post" action="">
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

                        <label style="display: inline-block;width: 120px;">Bamboo Airways</label>
                        Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_adult_qh" value="<?php echo get_option($prefix.'airfee_adult_qh'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_child_qh" value="<?php echo get_option($prefix.'airfee_child_qh'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="airfee_infant_qh" value="<?php echo get_option($prefix.'airfee_infant_qh'); ?>" />
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

                        <label style="display: inline-block;width: 120px;">Bamboo Airways</label>
                        Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_adult_qh" value="<?php echo get_option($prefix.'svfee_adult_qh'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_child_qh" value="<?php echo get_option($prefix.'svfee_child_qh'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="svfee_infant_qh" value="<?php echo get_option($prefix.'svfee_infant_qh'); ?>" />

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

                        <label style="display: inline-block;width: 120px;">Bamboo Airways</label>
                        Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_adult_qh" value="<?php echo get_option($prefix.'adminfee_adult_qh'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_child_qh" value="<?php echo get_option($prefix.'adminfee_child_qh'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="adminfee_infant_qh" value="<?php echo get_option($prefix.'adminfee_infant_qh'); ?>" />

                        <br/>
                    </td>
                </tr>
                
                <tr>
                    <th><label for="description">Phí TT Vé Khuyến Mãi</label></th>
                    <td>
                        Nếu giá cơ bản 
                        nhỏ hơn 100k: <input type="text" style="width: 150px;margin-bottom: 5px;" name="promo_svfee_1" value="<?php echo get_option($prefix.'promo_svfee_1'); ?>" /> - 
                        Từ 100-300k: <input type="text" style="width: 150px;margin-bottom: 5px;" name="promo_svfee_2" value="<?php echo get_option($prefix.'promo_svfee_2'); ?>" /> - 
                        Từ 300-500k: <input type="text" style="width: 150px;margin-bottom: 5px;" name="promo_svfee_3" value="<?php echo get_option($prefix.'promo_svfee_3'); ?>" />
                        <br/>
                    </td>
                </tr>

                <tr>
                    <th><label for="description">Thuế phí quốc tế</label></th>
                    <td>
                        <label style="display: inline-block;width: 120px;">Hành khách</label>
                        Người Lớn : <input type="text" style="width: 150px;margin-bottom: 5px;" name="inter_adt_svfee" value="<?php echo get_option($prefix.'inter_adt_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="inter_chd_svfee" value="<?php echo get_option($prefix.'inter_chd_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="inter_inf_svfee" value="<?php echo get_option($prefix.'inter_inf_svfee'); ?>" />

                        <br/>
                    </td>
                </tr>
                
                <tr>
                    <th><label for="description">Ngoại tệ</label></th>
                    <td>
                        <label style="display: inline-block;width: 120px;">Tỷ giá</label>
                        USD : <input type="text" style="width: 150px;margin-bottom: 5px;" name="exchange_rate" value="<?php echo get_option($prefix.'exchange_rate'); ?>" /> / 
                        EUR : <input type="text" style="width: 150px;margin-bottom: 5px;" name="eur_exchange_rate" value="<?php echo get_option($prefix.'eur_exchange_rate'); ?>" />
                        <br/>
                    </td>
                </tr>
                
                <tr>
                    <th><label for="description">Phí giao vé</label></th>
                    <td>
                        <label style="display: inline-block;width: 120px;">Phí giao vé</label>
                        <input type="text" style="width: 150px;margin-bottom: 5px;" name="delivery_fee" value="<?php echo get_option($prefix.'delivery_fee'); ?>" />
                        <br/>
                    </td>
                </tr>

            </table>
        </fieldset>

        <!--config for sabre-->
        <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
            <legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Sabre Config</strong></legend>
            <table class="form-table">
                <tr>
                    <th><label for="sabre_agent_id">Sabre Agent ID</label></th>
                    <td><input type="text" style="width: 150px;margin-bottom: 5px;" name="sabre_agent_id" value="<?php echo get_option($prefix.'sabre_agent_id'); ?>" /></td>
                </tr>
            </table>
        </fieldset>

        <!--config for inter svfee-->
        <fieldset style="border:1px solid #ddd; padding-bottom:20px; margin-top:20px;">
            <legend style="margin-left:5px; padding:0 5px; color:#2481C6;text-transform:uppercase;"><strong>Thuế phí Quốc Tế</strong></legend>
            <table class="form-table">
                <tr>
                    <th><label for="description">Phí dịch vụ</label></th>
                    <td>
                        <label style="display: inline-block;width: 120px; font-weight: bold;">Mặc định</label><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="inter_adult_svfee" value="<?php echo get_option($prefix.'inter_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="inter_child_svfee" value="<?php echo get_option($prefix.'inter_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="inter_infant_svfee" value="<?php echo get_option($prefix.'inter_infant_svfee'); ?>" />
                        <br/>

                        <label style="display: inline-block;width: 120px; font-weight: bold;">Đông Nam Á</label><br>
                        Mã sân bay : <input type="text" style="width: 585px;margin-bottom: 5px;" name="southeast_asia_airport" value="<?php echo get_option($prefix.'southeast_asia_airport'); ?>" /><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="southeast_asia_adult_svfee" value="<?php echo get_option($prefix.'southeast_asia_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="southeast_asia_child_svfee" value="<?php echo get_option($prefix.'southeast_asia_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="southeast_asia_infant_svfee" value="<?php echo get_option($prefix.'southeast_asia_infant_svfee'); ?>" />
                        <br/>

                        <label style="display: inline-block;width: 120px; font-weight: bold;">Đông Bắc Á</label><br>
                        Mã sân bay : <input type="text" style="width: 585px;margin-bottom: 5px;" name="northeast_asia_airport" value="<?php echo get_option($prefix.'northeast_asia_airport'); ?>" /><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="northeast_asia_adult_svfee" value="<?php echo get_option($prefix.'northeast_asia_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="northeast_asia_child_svfee" value="<?php echo get_option($prefix.'northeast_asia_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="northeast_asia_infant_svfee" value="<?php echo get_option($prefix.'northeast_asia_infant_svfee'); ?>" />
                        <br/>

                        <label style="display: inline-block;width: 120px; font-weight: bold;">Châu Âu</label><br>
                        Mã sân bay : <input type="text" style="width: 585px;margin-bottom: 5px;" name="europe_airport" value="<?php echo get_option($prefix.'europe_airport'); ?>" /><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="europe_adult_svfee" value="<?php echo get_option($prefix.'europe_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="europe_child_svfee" value="<?php echo get_option($prefix.'europe_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="europe_infant_svfee" value="<?php echo get_option($prefix.'europe_infant_svfee'); ?>" />
                        <br/>

                        <label style="display: inline-block;width: 120px; font-weight: bold;">Châu Mỹ</label><br>
                        Mã sân bay : <input type="text" style="width: 585px;margin-bottom: 5px;" name="americas_airport" value="<?php echo get_option($prefix.'americas_airport'); ?>" /><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="americas_adult_svfee" value="<?php echo get_option($prefix.'americas_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="americas_child_svfee" value="<?php echo get_option($prefix.'americas_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="americas_infant_svfee" value="<?php echo get_option($prefix.'americas_infant_svfee'); ?>" />
                        <br/>

                        <label style="display: inline-block;width: 120px; font-weight: bold;">Châu Úc</label><br>
                        Mã sân bay : <input type="text" style="width: 585px;margin-bottom: 5px;" name="australia_airport" value="<?php echo get_option($prefix.'australia_airport'); ?>" /><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="australia_adult_svfee" value="<?php echo get_option($prefix.'australia_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="australia_child_svfee" value="<?php echo get_option($prefix.'australia_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="australia_infant_svfee" value="<?php echo get_option($prefix.'australia_infant_svfee'); ?>" />
                        <br/>

                        <label style="display: inline-block;width: 120px; font-weight: bold;">Châu Phi</label><br>
                        Mã sân bay : <input type="text" style="width: 585px;margin-bottom: 5px;" name="africa_airport" value="<?php echo get_option($prefix.'africa_airport'); ?>" /><br>
                        Người Lớn : &nbsp;<input type="text" style="width: 150px;margin-bottom: 5px;" name="africa_adult_svfee" value="<?php echo get_option($prefix.'africa_adult_svfee'); ?>" /> /
                        Trẻ Em : <input type="text" style="width: 150px;margin-bottom: 5px;" name="africa_child_svfee" value="<?php echo get_option($prefix.'africa_child_svfee'); ?>" />
                        / Sơ Sinh: <input type="text" style="width: 150px;margin-bottom: 5px;" name="africa_infant_svfee" value="<?php echo get_option($prefix.'africa_infant_svfee'); ?>" />
                        <br/>
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
<?php } ?>