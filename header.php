<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="SHORTCUT ICON" href="<?php echo get_bloginfo("template_directory")?>/favicon_1.png" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="1 day" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="fb:admins" content="1450452807" />
    <meta property="fb:app_id" content="1725237907748916">
    <?php echo stripslashes(get_option("opt_google_tag_manager")); ?>
    <?php header('Content-Type: text/html; charset=utf-8'); ?>
    <?php wp_head(); ?>
    <style type="text/css">
      .relate_news ul li a{color:#143a83;text-decoration:none}
      .relate_news ul li{padding-top:5px}
      .relate_news{clear:both;padding:0}
      .relate_news .title{background:url(<?php echo get_bloginfo('template_directory');?>/images/tintuc.png) no-repeat center left;padding-left:35px;font-size:20px;text-transform:uppercase;color:#143a83;font-weight:normal;line-height:30px}
      .lineresult-main .f_detail label{display:inline-block;color:#fff;text-decoration:none;-moz-border-radius:1px;-webkit-border-radius:1px;-moz-box-shadow:0 1px 3px rgba(0,0,0,0.6);-webkit-box-shadow:0 1px 3px rgba(0,0,0,0.6);text-shadow:0 -1px 1px rgba(0,0,0,0.25);border-bottom:1px solid rgba(0,0,0,0.25);position:relative;cursor:pointer;font-weight:bold;line-height:1;text-shadow:0 -1px 1px rgba(0,0,0,0.25);font-size:14px;padding:6px 14px 7px;background-color:#f26722}
      @media(min-width:769px){.lineresult-main .f_select{text-align:center!important;font-size:1.1em!important}}
      @media(max-width:768px){.news-title{margin-left:0}.payments-mobile{clear:both}#date-dep{float:none!important}#date-ret{float:none!important}.f_select{text-align:right!important}}
      .mobile-app__links a{border-radius:10px;display:inline-block;height:54px;width:170px;box-shadow:0 3px #1A891D}
      .f_time span.Stop0{background:url('<?php echo get_bloginfo('template_directory');?>/images/plane.png') no-repeat center;background-size:75%;display:inline-block;width:20px;height:14px;vertical-align:middle}
      @media(max-width:376px){.lineresult-main .f_select{font-size:0.9em!important}.lineresult-main .f_time{font-size:0.83em!important}.f_time span.Stop0{width:18px}.table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th{padding:8px 5px!important}.lineresult-main .f_detail label{padding:4px 12px 5px}}
    </style>
</head>
<body <?php body_class(); ?>>
    <?php echo stripslashes(get_option("opt_google_tag_manager_no_script")); ?>
    <div id="wrap">
        <!--HEADER-->
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="brand pull-left"> 
                          <a class="tcb-logo-new" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
                              <img src="<?php echo get_template_directory_uri(); ?>/images/logo-tcb-2020.png" />
                          </a>
                        </div>
                        <nav class="navbar navbar-inverse">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                                    <span class="sr-only">Toggle navigation</span> 
                                    <i class="mobMenu fl icon-menu1 blue-color ico20"></i>
                                </button>
                                <a class="navbar-brand" class="tcb-logo-new" href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo-tcb-2020.png" />
                                </a>
                            </div>
                            <div class="collapse navbar-collapse">
                                <?php wp_nav_menu(array("menu"=>"Main Menu","container"=>"","menu_class"=>"nav navbar-nav" )) ?>
                            </div>
                        </nav>
                        <div id="hotline-new" class="mobile-hotline-new">
                            <?php echo get_option('opt_hotline'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--END HEADER-->

        <!--START MAIN CONTAINER-->
        <?php if(! is_home()) { ?>
        <div>
            <div class="page-title-container hidden-xs">
                <div class="container">
                    <div class="page-title pull-left">
                        <?php	yoast_breadcrumb('<div id="breadcrumbs"><div class="breadcrumbs">','</div></div>'); ?>
                    </div>
                </div>
            </div>
            <div id="content" class="container">
        <?php } ?>