<?php
/*
Template Name: FAQ
*/
?>

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
         
		         <?php //start by fetching the terms for the nhom-du-an taxonomy
				$terms = get_terms( 'faq_tax', array(
					'orderby'    => 'date',
					'hide_empty' => 0
				) );
 				?>

                <?php
				// now run a query for each animal family
				foreach( $terms as $term ) {
			 
				// Define the query
				$args = array(
					'post_type' => 'faq',
					'faq_tax' => $term->slug,
					'posts_per_page' => 30
 				);
				$query = new WP_Query( $args );
	 			$countPost = 1;
				  // Start the Loop
		        while ( $query->have_posts() ) : $query->the_post(); ?>
					 <p class="question">
        	            <span class="number"><?php echo $countPost?></span>
        	    	                <a href='' class="q<?php echo $countPost?>" id="q<?php echo $countPost?>"> <?php echo the_title(); ?> </a>
        	    	        </p>
        	    	        <div class="answer" style='display:none'>
                            <?php the_content(); ?>
							</div>
                     
 				<?php $countPost++; 
					endwhile; 
					wp_reset_postdata(); 
				}?>

		<div class="post-social">
								<!-- share facebook -->
				<div class="par hidden-xs">
					<a class="facebook"  href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" target="_blank" rel="external nofollow">
						<i class="fa fa-facebook"></i> Facebook
					</a>
				</div>
								<!-- share twitter -->
				<div class="par hidden-xs">
					<a class="twitter" href="http://twitter.com/share?text=&url='.get_the_permalink() .'"  title="Share on Twitter" target="_blank" rel="external nofollow"> 
						<i class="fa fa-twitter"></i> Twitter
					</a>
				</div>
				

								<!-- share google + -->
				<div class="par hidden-xs">
					<a class="google" href="https://plus.google.com/share?url=<?php the_permalink();?>" target="_blank" rel="external nofollow">
						<i class="fa fa-google-plus"></i> Google
					</a>
				</div>
				
		<!-- Place this tag where you want the +1 button to render. -->
		</div>    
		
		<!--Facebook Google+ Comment-->
		<div class="gap gap-mini"></div>	
		<h4>Thảo luận</h4> 
			<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10" data-colorscheme="light"></div>
		<!--End comment box-->    
       
       

    </div></div> <!--#mainDisplay-->
    <?php else: ?>
        <div id="nonepost">
            Trang bạn đang truy cập hiện không có, vui lòng quay lại sau
        </div><!--#nonepost-->
    <?php endif; ?>

</div><!--#mainDisplay-->
 <div class="col-md-4"><?php get_sidebar(); ?></div><!--#ctright-->
</div>
</div> <!--end row wrap col_main+sidebar--> 

<script type="text/javascript">
      
    </script>


<?php
get_footer();
?>