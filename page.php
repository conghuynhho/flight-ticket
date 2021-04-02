<?php get_header(); ?>
<div class="tcb-page">
    <div class="block">
        <div class="col-md-8">
            <?php if(have_posts()): ?>
            <div id="mainDisplay" class="single post">
                <h1 class="posttitle"><?php the_title(); ?></h1>
                <?php while(have_posts()): the_post(); ?>
                <div class="post-editor">
                    <?php get_the_content() ? the_content() : 'Nội dung đang cập nhật. Vui lòng quay lại sau.' ?>
                </div>
                <!--.post-editor-->
                <?php endwhile; ?>   
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
        <div class="col-md-4 col-right-sidebar-page"><?php get_sidebar(); ?></div>
        <!--#ctright-->
    </div>
</div>
<!--end row wrap col_main+sidebar--> 
<?php get_footer(); ?>