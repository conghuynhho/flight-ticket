<?php
	if(isset($_POST["contact-name"])){
		include(TEMPLATEPATH.'/flight_config/sugarrest/sugar_rest.php');
		$err="";
		$sugar = new Sugar_REST();
		$error = $sugar->get_error();
		if($error){
			echo "loi khi ket noi den server";
			exit();
		}
		$name       = trim($_POST["contact-name"]);
		$email      = trim($_POST["contact-email"]);
		$content    = $_POST["contact-content"];
		$phone      = $_POST["contact-phone"];

		$args_request = array(
			'contact_name' => $name,
			'request_status' => 0,
			'phone' => $phone,
			'request_type' => 1,
			'email' => $email,
			'request_detail' => $content,
		);
		$request_id = $sugar->set("EC_Request_Flight",$args_request);

		if($request_id)
			echo 1;
		else
			echo 0;
		exit();
	}
	get_header();
?>
<div class="tcb-page-contact">
	<div class="block">
		<div class="col-md-12 tcb-padding-0">
			<iframe src="<?php echo get_option('opt_google_map'); ?>" width="100%" height="400px" frameborder="0" style="border:0" allowfullscreen></iframe>
			<?php if(have_posts()):the_post(); ?>
				<div class="row mt20">
					<div class="col-md-6">
						<form method="post" action="#" name="frm_contact" id="frm_contact">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input class="form-control" type="text" id="contact-name" name="contact-name" value="" placeholder="Họ và tên">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input class="form-control" type="text" id="contact-email" name="contact-email" value="" placeholder="Email">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input class="form-control" type="text" id="contact-title" name="contact-title" value="" placeholder="Tiêu đề">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input class="form-control" type="text" id="contact-phone" name="contact-phone" value="" placeholder="Điện thoại">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<textarea class="form-control" placeholder="Nội dung" name="contact-content" id="contact-content" rows="3"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10">
									<span class="x-large pull-right" id="notice-error" style="color: #f26722; ">
										Support 24/7: <?php echo get_option('opt_support2'); ?>
									</span>
								</div>
								<div class="col-md-2">
									<button type="button" class="button pull-right" id="contact-submit" name="contact-submit">
										<span class="pull-left">Gửi mail</span>
									</button>
								</div>
							</div>
							<!--    <div id="process-form"></div>-->


						</form>
					</div>
					<div class="col-md-6 visible-lg">
						<aside class="sidebar-right">
							<?php echo stripslashes(get_option("opt_footeradd")); ?>
						</aside>
					</div>
				</div>
			<?php else: ?>
				<div id="nonepost">
					Trang bạn đang truy cập hiện không có, vui lòng quay lại sau
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>