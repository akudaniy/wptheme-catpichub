<div class="col-sm-4 col-md-4 col-md-pull-8 col-sm-pull-8">
  
  <?php if ( is_single() || is_category() || is_tax('wallpaper-size') || is_tag() ) : ?>
  <div class="widget" id="wallpaper_sizes_sponslink-2">
    <div class="widget-head head-ID-5">Sponsored Links</div>
    <div class="widget-body clearfix">
      <?php echo get_adsense_code(300,600); ?>
    </div>
  </div>
  <?php endif; ?>

  <?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
    <?php dynamic_sidebar( 'sidebar-right' ); ?>
  <?php endif; ?>

  <div class="widget" id="wallpaper_upirising_widget-2">
    <h4 class="widget-head head-ID-4">Latest Viewed</h4>
    <div class="widget-body wallpaper-uprising-list clearfix">
      <?php 

      $randwalls = new WP_Query( array('posts_per_page'=>9, 'orderby'=>'rand') ); 
      while( $randwalls->have_posts() ): $randwalls->the_post(); ?>
      <a href="<?php the_permalink(); ?>"><?php imwp_view_thumbnail('thumbnail', 'post-image-footer'); ?></a>
      <?php endwhile; ?>   
    </div>
  </div>
   
</div>