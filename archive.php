<?php 
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package Catpichub
 */

get_header(); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="wrapper clearfix">

  <div class="col-sm-8 col-md-8 col-md-push-4 col-sm-push-4">

  <div class="wrapper-title">
    <h1 class="page-title">
      <?php
        if ( is_day() ) :
          printf( __( 'Daily Archives: %s', WPTHEME_TEXT_DOMAIN ), get_the_date() );

        elseif ( is_month() ) :
          printf( __( 'Monthly Archives: %s', WPTHEME_TEXT_DOMAIN ), get_the_date( _x( 'F Y', 'monthly archives date format', WPTHEME_TEXT_DOMAIN ) ) );

        elseif ( is_year() ) :
          printf( __( 'Yearly Archives: %s', WPTHEME_TEXT_DOMAIN ), get_the_date( _x( 'Y', 'yearly archives date format', WPTHEME_TEXT_DOMAIN ) ) );

        else :
          _e( 'Archives', WPTHEME_TEXT_DOMAIN );

        endif;
      ?>
    </h1>
  </div><!--.wrapper-title-->

  <div class="row">

    <?php if ( have_posts() ): 
      $n=0; 
      while( have_posts() ): the_post(); 
        get_template_part( 'content' );
      $n++; 
      endwhile;
     
    else: 
      get_template_part( 'content', 'none' );
      
    endif; ?>

    <div class="col-md-12">
    <?php catpichub_pagenavi(); ?>
    </div><!--.col-md-12-->
    
  </div><!--.row-->
  </div>
  
  <?php get_sidebar(); ?>
  
</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
