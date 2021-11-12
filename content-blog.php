<?php 
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package Catpichub
 */

global $n;

?>

<div class="col-xs-4">
  <h2 class="entry-title">
    <?php the_title(); ?><a href="<?php the_permalink(); ?>">&#160;</a>
  </h2>

  <p><a href="<?php the_permalink(); ?>"><?php imwp_view_thumbnail('original', 'img-responsive slide-image large-atttachment' /*, array('script_file'=>site_url('/vd.php'), 'params'=>'&w=730&h=400&a=c') */ ); ?></a></p>

  <?php the_excerpt(); ?>

  <div class="entry-content clearfix">
    <?php /* imwp_view_gallery(
      array(
        'image_class'       => 'post-image-footer',
        'randomize_order'   => TRUE,
        'max_result_count'  => 7,
        )
    ); */ ?> 
  </div>

  <div class="entry-meta">
    <?php # echo catpichub_post_category(); ?> 
    <?php # echo catpichub_post_tags(); ?> 
  </div>

</div><!-- .col-sm-6 col-md-4 -->
