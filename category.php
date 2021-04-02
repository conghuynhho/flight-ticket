<?php get_header(); ?>
<div class="tcb-this-is-category">
    <div class="block">
        <div class="col-md-8 sidebar-separator">
            <div class="tcb-content-category">
                <div id="cat_description">
                    <?php 
						if(is_category()) {
							$category = get_category(get_query_var('cat'));
							$cat_id = $category->cat_ID;
						}
					?>
                    <h1 class="tcb-h1-category"><?php single_cat_title(''); ?></h1>
                    <p class="tcb-p-category"><?php echo category_description(); ?></p>
                </div>
                <?php if(have_posts()): ?>
					<div id="mainDisplay" class="cat">
						<?php while(have_posts()): the_post(); ?>
						<div class="row post">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="hover-img">
									<img style="width:100%" src="<?php echo (_getHinhDaiDien($post->ID) != '' ? _getHinhDaiDien($post->ID) : v5s_catch_that_image()); ?>" class="img-responsive img-hover" alt="<?php the_title(); ?>" />
							</div>
							<div class="col-xs-12 col-sm-6 col-md-8">
								<h4>
									<a class="cate_title" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h4>
								</p>
								<p> <?php new_excerpt_more(the_excerpt()); ?></p>
								<a class="button pull-right" href="<?php the_permalink() ?>">Xem thêm </a>
							</div>
						</div>
						<hr />
						<?php endwhile; ?>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12">
								<?php emm_paginate(); ?>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php else: ?>
				<div id="nonepost " class="col-md-8><div class=" travelo-box">
					Nội dung đang cập nhật. Vui lòng quay lại sau.
				</div>
			</div>
			<?php endif; ?>
    	</div>
		<div class="col-md-4"><?php get_sidebar(); ?></div>
	</div>
</div>
<?php get_footer(); ?>