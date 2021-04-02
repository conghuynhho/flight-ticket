<?php get_header(); ?>
<div class="tcb-single-post">
    <div class="block">
        <div class="col-md-8 sidebar-separator">
            <div>
                <?php if(have_posts()): ?>
                <div id="mainDisplay" class="single post">
                    <h1 class="posttitle"><?php the_title(); ?></h1>
                    <?php while(have_posts()): the_post(); ?>
                    <ul class="post-meta hidden-xs">
                        <li><i class="fa fa-folder-open"></i><a href="#"><?php the_category(', ') ?></a></li>
                        <?php if (get_the_tags()) : ?>
                        <li><i class="fa fa-tags"></i>
                            <?php the_tags('', ', ', ''); ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <div class="post-editor">
                        <?php get_the_content() ? the_content() : 'Nội dung đang cập nhật. Vui lòng quay lại sau.' ?>
                    </div>
                    <!--.post-editor-->
                    <?php endwhile; ?>
					<div class="cs-post-social">
						<button class="button-thread-share">
							<i class="jsx-4270165100 fa fa-share"></i>
							<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"
                            target="_blank" rel="external nofollow" class="a-href-facebook"
                            data-url="<?php the_permalink(); ?>">Chia sẻ</a>
						</button>
					</div>		
                    <div class="relate_news">
                        <div class="row news-title">
                            <h4 class="pull-left"><span class="title"></span>Bài viết liên quan</h4>
                        </div>
                        <?php
							$cat = wp_get_post_categories($post->ID);
								$args = array(
									"post_type" => "post",
									"post_status" => "publish",
									"category__in" => $cat,
									"posts_per_page" => 9,
									"caller_get_posts" => 1,
									"post__not_in" => array($post->ID),
								);

							$tags = wp_get_post_tags($post->ID);
							if($tags){
								$first_tag = $tags[0]->term_id;
								$args = array(
									"post_type" => "post",
									"post_status" => "publish",
									"tag__in" => array($first_tag),
									"post__not_in" => array($post->ID),
									"posts_per_page"=> 9,
									"caller_get_posts"=> 1
								);
								// $my_query = new WP_Query($args);
							}
							$incat_post = new WP_Query($args);
							$temp = 1;
                		?>
                        <ul class="ul-related-posts">
                            <?php while($incat_post->have_posts()): $incat_post->the_post();  ?>
                            <li class="li-related-posts">
                                <img src="<?php echo get_bloginfo('template_directory'); ?>/images/listitem_orange.png"/>
                                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                    <?php echo  wp_trim_words(get_the_title(),20); ?>
                                </a>
                            </li>
                            <?php $temp++; endwhile; wp_reset_query(); ?>
							<?php 
								if($temp < 10 && isset($first_tag)) {
									$args=array(
									"post_type"=>"post",
									"post_status"=>"publish",
									"category__in"=>$cat,
									"posts_per_page"=>10-$temp,
									"caller_get_posts"=>1,
									"tag__not_in"=>array($first_tag),
									"post__not_in" => array($post->ID),
									);
									$incat_post=new WP_Query($args);
						 		?>
                            	<?php while($incat_post->have_posts()): $incat_post->the_post();  ?>
								<li>
									<img src="<?php echo get_bloginfo('template_directory'); ?>/images/listitem_orange.png" />
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
										<?php echo  wp_trim_words(get_the_title(),20); ?>
									</a>
								</li>
								<?php endwhile; wp_reset_query(); ?>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!--#mainDisplay-->
            <?php else: ?>
            <div id="nonepost">
                Nội dung đang cập nhật. Vui lòng quay lại sau.
            </div>
            <!--#nonepost-->
            <?php endif; ?>
        </div>
        <!--#mainDisplay-->
        <div class="col-md-4"><?php get_sidebar(); ?></div>
        <!--#ctright-->
    </div>
</div>
<!--end row wrap col_main+sidebar-->
<?php get_footer(); ?>