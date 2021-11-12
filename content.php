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

<div class="col-md-4">
  <div class="thumbnail">
    <a href="<?php the_permalink(); ?>">
      <?php imwp_view_thumbnail('archive-thumb', 'post-image-archive'); ?>
    </a>

    <div class="caption">
      <p class="wallpaper-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
      
      <div class="row wallpaper-meta">
        <div class="col-xs-4"><span class="wallpaper-count"><i class="fa fa-download"></i> <?php echo catpichub_downloaded(); ?></span></div>
        <div class="col-xs-8"><span class="wallpaper-resolution"><i class="fa fa-desktop"></i> <?php echo catpichub_dimension(); ?></span></div>
      </div>
    </div>
  </div>
</div><!-- .col-sm-6 col-md-4 -->
