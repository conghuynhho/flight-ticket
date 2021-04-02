<?php
get_header();
?>
<div class="row">
<div class="block">
 <div class="col-md-8 sidebar-separator">
     <div>
    <?php if(have_posts()): ?>
    <div id="mainDisplay" class="single post">
        <h1 class="posttitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            
        <?php while(have_posts()): the_post(); ?>
         <ul class="post-meta hidden-xs">
			<li><i class="fa fa-calendar"></i><a href="#"><?php the_date("d/m/Y h:m") ?></a></li>
			<li><i class="fa fa-folder-open"></i><a href="#"><?php the_category(', ') ?></a></li>
			<?php if (get_the_tags()) : ?>
			<li><i class="fa fa-tags"></i>
				 <?php the_tags('', ', ', ''); ?>
			</li>
			<?php endif; ?>		
		</ul>
		
        <div class="post-editor">
           <?php the_content(); ?>
           
       
        </div><!--.post-editor-->
            
        <?php endwhile; ?>
		
		 
		
		<!--Facebook Google+ Comment-->
		<div class="gap gap-mini"></div>	
		<h4>Thảo luận</h4> 
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
		<!--End comment box-->    
       
       

    </div></div> <!--#mainDisplay-->
    <?php else: ?>
        <div id="nonepost">
            Nội dung đang cập nhật. Vui lòng quay lại sau.
        </div><!--#nonepost-->
    <?php endif; ?>

</div><!--#mainDisplay-->
 <div class="col-md-4"><?php get_sidebar(); ?></div><!--#ctright-->
</div>
</div> <!--end row wrap col_main+sidebar--> 

<?php
get_footer();
?>