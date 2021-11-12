<?php

add_action('widgets_init','register_catalogue_widget');
function register_catalogue_widget() { 
  register_widget( 'Wallpaper_Category_Widget' );
}


class Wallpaper_Category_Widget extends WP_Widget {

  public function __construct() {
    parent::__construct(
      'wallpaper_category_widget', // Base ID
      __('Wallpaper Category', WPTHEME_TEXT_DOMAIN), // Name
      array( 'description' => __( 'Display list of Wallpaper Categories', WPTHEME_TEXT_DOMAIN ), ) // Args
    );
  }


  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );

    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];
    
    //----- START the widget content -----//

    $wallpaper_cats = get_terms( 'wallpaper-cat' );
    echo '<ul class="widget-body wallpaper-cat-list">';
    foreach ($wallpaper_cats as $wcat) {
      echo '<li><a href="';
      echo get_term_link($wcat);
      echo '">';
      echo $wcat->name;
      echo '<span class="term-count">' . $wcat->count . '</span></a>';
      echo '</li>';
    }
    echo '</ul>';
    

    //----- END the widget content -----//

    echo $args['after_widget'];
  }


  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'Filter Property', WPTHEME_TEXT_DOMAIN );
    }   

    $taxonomies = isset($instance['taxonomies']) ? $instance['taxonomies'] : '';

    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php 
  }


  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['taxonomies']    = ( ! empty( $new_instance['taxonomies'] ) ) ? strip_tags( $new_instance['taxonomies'] ) : '';

    return $instance;
  }
}
