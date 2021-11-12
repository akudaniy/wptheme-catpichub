<?php 
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Catpichub
 */

get_header(); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="wrapper clearfix">

  <div class="col-sm-8 col-md-8 col-md-push-4 col-sm-push-4">
  <?php the_breadcrumb(); ?>

  <div class="wrapper-title">
    <h1 class="page-title">
      <?php printf( __( 'Category Archives: %s', WPTHEME_TEXT_DOMAIN ), single_cat_title( '', false ) ); ?>
    </h1>
  </div><!--.wrapper-title-->

  <?php
    // Show an optional term description.
    $term_description = term_description();
    if ( ! empty( $term_description ) ) :
      printf( '<div class="wrapper block taxonomy-description">%s</div>', $term_description );
    endif;
  ?>
  
  <div style="margin:0 0 20px">
    <?php echo get_adsense_code(728,90); ?>
  </div>

  <div class="row">

    <?php if ( have_posts() ): 
      $n=0; 
      echo '<table class="table table-striped"><tbody>';
      while( have_posts() ): the_post(); 
        get_template_part( 'content', 'blog' );
      $n++; 
      endwhile;
      echo '</tbody></table>';
     
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
