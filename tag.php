<?php 
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
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

  <div class="wrapper-title nomb">
    <h1 class="page-title nomt">
      <?php printf( __( 'Collection of %s', WPTHEME_TEXT_DOMAIN ), ucwords(single_tag_title( '', false )) ); ?>
    </h1>
  </div><!--.wrapper-title-->
  <?php /*
  <div style="margin:20px 0 0;">
    <?php echo get_adsense_code(728,90); ?>
  </div> */ ?>

  <div class="row">

    <?php if ( have_posts() ): 
      $n=0; 
      while( have_posts() ): the_post(); 
        get_template_part( 'content', 'blog' ); 
      $n++; 
      endwhile;
     
    else: 
      get_template_part( 'content', 'none' );
      
    endif; ?>

    <div class="col-md-12">
    <?php catpichub_pagenavi(); ?>
    

    <div class="more-wallpapers">
      <h2 class="block-title">Related Wedding Styles Inspirations from <?php the_title() ?></h2>

      <div class="row">
        <?php 

        $n=0;
        $morewalls = new WP_Query( array('posts_per_page'=>9, 'orderby'=>'rand') );
        if( $morewalls->have_posts() ) :
        while( $morewalls->have_posts() ): $morewalls->the_post(); 
          get_template_part( 'content', 'blog' );
        $n++; 
        endwhile;
        endif; ?>

      </div><!--.row-->
    </div><!--.more-wallpapers-->

    </div><!--.col-md-12-->
    
  </div><!--.row-->
  </div>
  
  <?php get_sidebar(); ?>
  
</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
