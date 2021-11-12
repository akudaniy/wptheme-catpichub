<?php 
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Catpichub
 */

get_header(); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="wrapper clearfix">

  <div class="col-sm-8 col-md-8 col-md-push-4 col-sm-push-4">

    <h1 itemprop="name" class="entry-title"><?php echo catpichub_url2title() ?></h1>

    <p>
      Browse for free <strong><?php echo catpichub_url2title() ?></strong> cute cat pictures <?php bloginfo('name') ?>. 
      Hundreds of cuddling feline photos including <?php echo catpichub_url2title() ?> are available in <?php bloginfo('name') ?>. 
      If you are convenience with search boxes, tap and type your questions in the search box on the upper-right 
      part of this <?php bloginfo('name') ?> website.
    </p>

    <p>
      <?php bloginfo('name') ?> is dedicated to people like you who love cats, and a full-time feline adorer. 
      If you are looking for <?php echo catpichub_url2title() ?>, <?php bloginfo('name') ?> are here to help you find your lovely cats.
    </p>

    
    <div class="row">
    <?php 

    $randposts = new WP_Query( array('posts_per_page'=>15, 'orderby'=>'rand') );
    while( $randposts->have_posts() ): $randposts->the_post();
      get_template_part( 'content' );
    endwhile; ?>
    </div>


  </div>
  
  <?php get_sidebar(); ?>
  
</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
