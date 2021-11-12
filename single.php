<?php 
/*
 * The Template for displaying all single posts
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

    <?php while( have_posts() ): the_post(); do_action('catpichub_single_post_hook'); ?>
    <article itemscope itemtype="http://schema.org/Article">
    <h1 itemprop="name" class="entry-title"><?php the_title(); ?></h1>

    <?php /* <div style="margin:20px 0 0">
      <?php echo get_adsense_code(728,90); ?>
    </div> */ ?>

    <div class="entry-wallpaper">
      <?php echo imwp_view_thumbnail('original', 'post-image-single img-responsive'); ?>
    </div><!--.entry-wallpaper-->

    <div class="entry-content clearfix" itemprop="articleBody">
      <p style="float:left; margin:5px 10px 10px 0;">
        <?php echo get_adsense_code(336,280); ?>
      </p>
      <?php the_content(); ?>
    </div><!--.entry-content-->
    </article>
    
    <div class="entry-meta">
      <?php echo catpichub_post_category(); ?> 
      <?php # echo catpichub_post_tags(); ?> 
    </div>

    <h3 class="title">Share the Love</h3>
    <?php

    $post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
    $image_attributes  = wp_get_attachment_image_src( $post_thumbnail_id, 'full');

    /* =================== GOOGLE+ =================== */
    $gplus_link  = 'https://plus.google.com/share?'; 
    $gplus_link .= 'url=' . urlencode( get_the_permalink() ); 
    $gplus_link .= '&t=' . urlencode( get_the_title() ); ?>
    <a target="_blank" href="<?php echo $gplus_link; ?>">
      <span class="socialicons gpluslight"></span>
    </a>

    <?php 
    /* =================== PINTEREST =================== */
    $pinterest_link  = 'http://www.pinterest.com/pin/create/button/'; 
    $pinterest_link .= '?description=' . urlencode( get_the_title() );
    $pinterest_link .= '&media=' . urlencode( $image_attributes[0] );
    $pinterest_link .= '&url=' . urlencode( get_the_permalink() ); ?>
    <a target="_blank" href="<?php echo $pinterest_link; ?>">
    <span class="socialicons pinterest"></span>
    </a>

    <?php 
    /* =================== FACEBOOK =================== */
    $facebook_link  = 'https://www.facebook.com/sharer/sharer.php?'; 
    $facebook_link .= 'u=' . urlencode( get_the_permalink() ); 
    ?>
    <a target="_blank" href="<?php echo $facebook_link; ?>">
    <span class="socialicons facebook"></span>
    </a>

    <?php 
    /* =================== STUMBLEUPON =================== */
    $stumble_link  = 'http://www.stumbleupon.com/submit?url=';
    $stumble_link .= urlencode( get_the_permalink() ) . '&title=' . urlencode( get_the_title() );
    ?>
    <a target="_blank" href="<?php echo $stumble_link; ?>">
    <span class="socialicons stumbleupon"></span>
    </a>

    <?php 
    /* =================== REDDIT =================== */
    $reddit_link  = 'http://www.reddit.com/submit?'; 
    $reddit_link .= 'url=' . urlencode( get_the_permalink() ); 
    $reddit_link .= '&title=' . urlencode( get_the_title() );
    ?>
    <a target="_blank" href="<?php echo $reddit_link; ?>">
    <span class="socialicons reddit"></span>
    </a>

    <?php 
    /* =================== REDDIT =================== */
    $tumblr_link  = 'http://www.tumblr.com/share?v=3'; 
    $tumblr_link .= '&u=' . urlencode( get_the_permalink() ); 
    $tumblr_link .= '&t=' . urlencode( get_the_title() ); 
    $tumblr_link .= '&s='; 
    ?>
    <a target="_blank" href="<?php echo $tumblr_link; ?>">
    <span class="socialicons tumblr"></span>
    </a>

    <?php 
    /* =================== REDDIT =================== */
    $twitter_link  = 'https://twitter.com/intent/tweet?'; 
    $twitter_link .= 'text=' . urlencode( get_the_title() ); 
    $twitter_link .= '&url=' . urlencode( get_the_permalink() ); 
    $twitter_link .= '&related='; 
    ?>
    <a target="_blank" href="<?php echo $twitter_link; ?>">
    <span class="socialicons twitter"></span>
    </a>

    <?php endwhile; ?>

    <div class="more-wallpapers">
      <h2 class="block-title">Related Cute Cat Breeds from <?php the_title() ?></h2>

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

  </div>
  
  <?php get_sidebar(); ?>

</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
