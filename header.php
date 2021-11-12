<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( "charset" ); ?>" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  <title><?php wp_title( '|', true, 'right' ); ?></title>

  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( "pingback_url" ); ?>">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" type="text/css" media="all" href="//fonts.googleapis.com/css?family=Slabo+27px|Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&subset=latin%2Clatin-ext&ver=3.8.1" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() ?>/lib/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() ?>/lib/css/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( "stylesheet_url" ); ?>" />

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<!--[if lt IE 7]>
<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->
<header id="header">
  <div class="container">
  <div class="row">
  
  <div class="col-md-12">

  <nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?php 

      $is_header_image = get_header_image() ? 1 : 0;
      $custom_style = ( $is_header_image ) ? ' style="padding:10px;"' : '';
      ?>
      <a class="navbar-brand" href="<?php echo site_url('/'); ?>"<?php echo $custom_style; ?>>
        <?php 
        if( ! $is_header_image ) : 
          bloginfo('name'); 

        else: ?>
        <img class="head-logo" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php echo get_bloginfo('name') ?>" />
        <?php endif; ?>
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <?php

      $topmenu_init = array(
        'theme_location'  => 'top',
        'container'       => 'ul',
        'container_class' => 'nav',
        'menu_class'      => 'nav navbar-nav',
        'echo'            => true,
        'fallback_cb'     => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s clearfix">%3$s</ul>',
        'depth'           => 0,
        'walker'          => new Bootstrap_Walker_Nav_Menu,
      );

      wp_nav_menu( $topmenu_init ); ?>

      <form class="navbar-form navbar-right" role="search" method="get" action="<?php echo site_url('/'); ?>">

        <div class="input-group">
          <input type="text" name="s" class="form-control" placeholder="Search &hellip;">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-default btn-success" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div><!-- /input-group -->

      </form>

    </div><!-- /.navbar-collapse -->
  </nav>

  <?php // get_template_part('flexslider'); ?>

  </div>
  </div>
  </div>
</header>
