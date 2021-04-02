<?php
/**
 * Created by Notepad.
 * User: Lak
 * Date: 12/10/13
 */
?>

<?php 
	if($_SESSION['search']['isinter']){
		$condition = $_SESSION['search'];
		$source_ia = getCityName($condition['source']);
    	$destination_ia = getCityName($condition['destination']);
	}
?>

<div class="empty_flight">
    <h3>Chuyến bay bạn yêu cầu hiện tại đã hết !</h3>
    <p><strong>Thông báo:</strong> chuyến bay khởi hành từ <strong><?php echo ($condition["isinter"] ? $source_ia : $GLOBALS['CODECITY'][$condition['source']].' ('.$condition['source'].')'); ?></strong> đi <strong><?php echo ($condition["isinter"] ? $destination_ia : $GLOBALS['CODECITY'][$condition['destination']].' ('.$condition['destination'].')'); ?></strong> trong ngày <strong><?php echo  $condition['depart']?></strong> của các hãng hàng không trên hệ thông đặt vé online đã hết.</p>
    <p>Bạn có thể thay đổi <strong>ngày đi</strong>, hoặc <strong>ngày về</strong> để tìm chuyến bay khác.</p>
    <p>Nếu bạn muốn <strong>đặt vé máy bay theo yêu cầu</strong> trên, bạn có thể gửi yêu cầu theo <strong>biểu mẫu bên dưới</strong> hoặc gọi tới số điện thoại <strong style="font-size:16px;color:#E00;"><?php echo  get_option('opt_phone'); ?></strong>. Nhân viên của chúng tôi sẽ <strong>tìm vé máy bay theo yêu cầu</strong> của bạn </p>
    <div class="request_block">
        <form method="post" action="<?php echo _page(flightresult)?>" id="frm_requestflight">
            <table>
                <caption>Đặt vé theo yêu cầu</caption>
                <tr>
                    <td><label for="fullname">Họ tên:</label></td><td><input type="text" name="fullname" id="fullname" /></td>
                </tr>
                <tr>
                    <td><label for="phone">Điện thoại:</label></td><td><input type="text" name="phone" id="phone" /></td>
                </tr>
                <tr>
                    <td><label for="content_request">Nội dung:</label></td>
                    <td><textarea name="content_request" id="content_request" style="height:80px;">Tôi muốn tìm vé cho chuyến bay từ <?php echo ($condition["isinter"] ? $source_ia : $GLOBALS['CODECITY'][$condition['source']].' ('.$condition['source'].')'); ?> đi <?php echo ($condition["isinter"] ? $destination_ia : $GLOBALS['CODECITY'][$condition['destination']].' ('.$condition['destination'].')'); ?> vào ngày <?php echo $condition['depart']?> cho <?php echo $condition['adult']?> người lớn<?php echo $qty_children.$qty_infants ?> </textarea></td>
                </tr>
				<tr>
					<td>Xác nhận</td>
					<td> <div id="contact" style="transform:scale(0.9);transform-origin:0 0"></div>	
					</td>
					</tr>
                <tr>
                <tr>
                    <td></td><td><input type="submit" name="sm_request" id="sm_request" value="Gửi yêu cầu" class="btn_send button"/></td>
                </tr>
            </table>
        </form><!--End frm_requestflight-->
    </div><!--End request_block-->
</div><!--End empty_flight-->
 
<script type="text/javascript">
    $(function(){
        $('#frm_requestflight').submit(function(){
            $(':submit', this).click(function() {
                return false;
            });
        });
        $('#sm_request').click(function(){
			 if($('#fullname').val() == ''){
                $('#fullname').focus();
                return false;
            }else if($('#phone').val() == ''){
                $('#phone').focus();
                return false;
			}else if($('#g-recaptcha-response-1').val() == ''){
                $('#g-recaptcha-response-1').focus();
                return false;
            }else{
                return true;
            }
		});
    });
</script>