<?php 
/**
 * The template for displaying Search Results pages
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
    <h1 class="page-title">Search results for: <?php echo get_search_query() ?></h1>
  </div><!--.wrapper-title-->

  <div class="row">

    <?php if ( have_posts() ): 

    $n=0; 
    while( have_posts() ): the_post(); 
      get_template_part( 'content' );
    $n++; 
    endwhile; 

    else: ?>

    <p>Sorry, no posts matched your search. Try again?</p>
    <?php endif; ?>

    <div class="col-md-12">
    <?php catpichub_pagenavi(); ?>
    </div><!--.col-md-12-->
    
  </div><!--.row-->
  </div><!--.col-sm-8 col-md-8-->
  
  <?php get_sidebar(); ?>
  
</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
