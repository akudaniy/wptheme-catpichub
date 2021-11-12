<?php 
/**
 * The main template file.
 *
 * Most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @package Catpichub
 */

get_header(); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="wrapper clearfix">

  <div class="col-sm-8 col-md-8 col-md-push-4 col-sm-push-4">

  <h1 class="site-title">
    <?php bloginfo('name'); ?> <span class="site-description"><?php bloginfo('description') ?></span>
  </h1>

  <div class="row">
    <?php 

    $n=0; 
    while( have_posts() ): the_post(); 
      get_template_part( 'content', 'blog' );
    $n++; 
    endwhile; ?>

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
