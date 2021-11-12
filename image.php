<?php 
/**
 * The template for displaying image attachments
 *
 * @package Catpichub
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header(); ?>

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="wrapper clearfix">

  <div class="col-sm-12 col-md-12">
    <?php the_breadcrumb(); ?>

    <?php while( have_posts() ): the_post(); ?>
    <?php $parents = get_posts( array('p'=>$post->post_parent) ); ?>
    <?php $imgmeta = wp_get_attachment_metadata( $post->ID ); ?>

    <article itemscope itemtype="http://schema.org/Article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <h1 itemprop="name" class="entry-title"><?php the_title(); ?></h1>

    <div style="margin:20px 0">
      <?php echo get_adsense_code(728,90); ?>
    </div>

    <div class="entry-wallpaper">
      <?php catpichub_the_attached_image(); ?>
    </div><!--.entry-wallpaper-->

    <div class="entry-content clearfix" itemprop="articleBody">
      <p style="float:left; margin:5px 10px 10px 0;">
        <?php echo get_adsense_code(336,280); ?>
      </p>

      <p><strong><?php the_title() ?></strong> is a part of 
      <a href="<?php echo get_permalink( $post->post_parent ); ?>"><?php echo $parents[0]->post_title ?></a> pictures gallery. 
      To download this <em><?php the_title() ?></em> in High Resolution, right click on the image and choose "Save Image As" 
      and then you will get this image about <?php the_title() ?>.</p>

      <p>This digital photography of <?php the_title() ?> has dimension <?php echo $imgmeta['width'] ?> × <?php echo $imgmeta['height'] ?> pixels. 
      You can see another items of this gallery of <?php echo $parents[0]->post_title ?> below. 
      Get interesting article about <strong><?php echo $parents[0]->post_title ?></strong> that may help you.</p>

      <?php the_content(); ?>
    </div><!--.entry-content-->

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

    <div class="entry-wallpaper clearfix">

      <?php

      $args = array(
          'post_parent' => $post->post_parent,
          'post_type'   => 'attachment',
          'numberposts' => -1,
          'exclude'     => $post->ID,
          );
      $atts = get_posts( $args );
      $s = ( count($atts) > 1 ) ? 's' : '';

      if( count($atts) > 0 ) 
        echo '<h2 class="block-title">Don\'t forget to check another '. count($atts) . ' cute cat picture' . $s . ' in this gallery</h2>';

      foreach ($atts as $att) { setup_postdata($att);

        $attachment_url = get_attachment_link($att->ID);
        $attachment_src = wp_get_attachment_image( $att->ID );
        
        // insert the class attribute
        $attachment_src = str_replace('src=', 'class="attachment-100x100 post-image-gallery-thumb attachment-inline-title attachment-box" src=', $attachment_src);

        printf( __('<a rel="attachment" title="%1$s" href="%2$s">%3$s</a>'),
                $att->post_title,
                $attachment_url,
                $attachment_src
                );

      }

      ?>


    </div><!--.entry-wallpaper-->

    </article>

    <?php endwhile; ?>


    <div class="more-wallpapers">
      <h2 class="related-title">More Cat Pictures &#38; Galleries</h2>

      <div class="row">
        <?php 

        $n=0;
        $morewalls = new WP_Query( array('posts_per_page'=>9, 'orderby'=>'rand') );
        if( $morewalls->have_posts() ) :
        while( $morewalls->have_posts() ): $morewalls->the_post(); 
          get_template_part( 'content','blog' );
        $n++; 
        endwhile;
        endif; ?>

      </div><!--.row-->
    </div><!--.more-wallpapers-->

  </div>

</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
