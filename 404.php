<?php
header("HTTP/1.1 301 Moved Permanently");
header("Location: ".get_bloginfo('url'));
exit();
?>
<?php
get_header();
?>
<div class="row">
<div class="travelo-box text-center" style="min-height:400px;" >
	<div class="col-md-12">
		<h1>404!!</h1>
		<div >
		
			Trang bạn đang tìm hiện không có hoặc đã chuyển sang liên kết mới, vui lòng sử dụng công cụ tìm kiếm để tới trang bạn muốn!!<br/>
			 <a class="btn-ghost mt30"  href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><i class="fa fa-long-arrow-left"></i> Về trang chủ</a>
		</div>
	</div>
 </div></div> <!--end row wrap col_main+sidebar--> 
</div></div> <!--end row wrap col_main+sidebar--> 

<?php
get_footer();
?>