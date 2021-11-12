<?php
/**
 * @package Catpichub
 */

function catpichub_update_options() {

  if( isset($_POST['save_options']) ) {

    $default_options = catpichub_options_items();
    $updated_options = array_merge($default_options, $_REQUEST['opts']);

    // sanitize input by trimming spaces both on left and right
    foreach( $updated_options as $n => $upopt ): 
      $updated_options[$n] = trim( $upopt );
    endforeach;
    //print_r($updated_options);die();
    update_option('catpichub_options', $updated_options);

  }

}
add_action('admin_init', 'catpichub_update_options');


/**
 * HTML display of Catpichub options
 * @global object $wpdb
 */
function catpichub_options_fn() {
  global $wpdb, $updirs, $theme_opts; 

  ?>
  <style type="text/css">
    .section-title {border-bottom:1px solid #CCC; padding-bottom:20px;}
  </style>

  <div class="wrap">
    <h2><?php _e('Catpichub Theme Options', WPTHEME_TEXT_DOMAIN) ?></h2>

    <?php if( isset($_REQUEST['save_options']) ): ?>
    <div class="updated fade"> 
    <p><strong>Settings saved.</strong></p></div>
    <?php endif; ?>
    
    <form action="" method="post">
      
<div id="tabs">
  <ul>
    <li><a href="#tabs-1"><?php _e('Layout', WPTHEME_TEXT_DOMAIN) ?></a></li>
  </ul>


  <div id="tabs-1">
    <h3 class="section-title"><?php _e('Basic Layouts', WPTHEME_TEXT_DOMAIN) ?></h3>
    
    <table class="form-table">
    <tbody>

    <tr valign="top">
    <th scope="row"><?php _e('Custom Favicon', WPTHEME_TEXT_DOMAIN) ?></th>
    <td>
      <fieldset><legend class="screen-reader-text"><span><?php _e('Custom Favicon', WPTHEME_TEXT_DOMAIN) ?></span></legend>
      <input id="custom_favicon" type="text" name="opts[custom_favicon]" class="regular-text" value="<?php echo stripslashes($theme_opts['custom_favicon']) ?>" />
      <p class="description"><label for="custom_favicon"><?php printf(__('Paste your PNG or ICO favicon URL here or <input type="button" id="upload_image_button" class="button button-primary" value="Upload" /> a new one', WPTHEME_TEXT_DOMAIN)); ?></label></p>
      </fieldset>
    </td>
    </tr>

    <tr valign="top">
    <th scope="row"><?php _e('AdSense 728x90', WPTHEME_TEXT_DOMAIN) ?></th>
    <td>
      <fieldset><legend class="screen-reader-text"><span><?php _e('AdSense 728x90', WPTHEME_TEXT_DOMAIN) ?></span></legend>
      <textarea name="opts[adsense_728x90]" rows="5" cols="50" id="adsense_728x90" class="large-text code"><?php echo stripslashes($theme_opts['adsense_728x90']) ?></textarea>
      <p class="description"><label for="adsense_728x90"><?php printf(__('Paste your AdSense 728x90 code', WPTHEME_TEXT_DOMAIN)); ?></label></p>
      </fieldset>
    </td>
    </tr>

    <tr valign="top">
    <th scope="row"><?php _e('AdSense 336x280', WPTHEME_TEXT_DOMAIN) ?></th>
    <td>
      <fieldset><legend class="screen-reader-text"><span><?php _e('AdSense 336x280', WPTHEME_TEXT_DOMAIN) ?></span></legend>
      <textarea name="opts[adsense_336x280]" rows="5" cols="50" id="adsense_336x280" class="large-text code"><?php echo stripslashes($theme_opts['adsense_336x280']) ?></textarea>
      <p class="description"><label for="adsense_336x280"><?php printf(__('Paste your AdSense 336x280 code', WPTHEME_TEXT_DOMAIN)); ?></label></p>
      </fieldset>
    </td>
    </tr>

    <tr valign="top">
    <th scope="row"><?php _e('AdSense 300x600', WPTHEME_TEXT_DOMAIN) ?></th>
    <td>
      <fieldset><legend class="screen-reader-text"><span><?php _e('AdSense 300x600', WPTHEME_TEXT_DOMAIN) ?></span></legend>
      <textarea name="opts[adsense_300x600]" rows="5" cols="50" id="adsense_300x600" class="large-text code"><?php echo stripslashes($theme_opts['adsense_300x600']) ?></textarea>
      <p class="description"><label for="adsense_300x600"><?php printf(__('Paste your AdSense 300x600 code', WPTHEME_TEXT_DOMAIN)); ?></label></p>
      </fieldset>
    </td>
    </tr>

    <tr valign="top">
    <th scope="row"><?php _e('AdSense 300x250', WPTHEME_TEXT_DOMAIN) ?></th>
    <td>
      <fieldset><legend class="screen-reader-text"><span><?php _e('AdSense 300x250', WPTHEME_TEXT_DOMAIN) ?></span></legend>
      <textarea name="opts[adsense_300x250]" rows="5" cols="50" id="adsense_300x250" class="large-text code"><?php echo stripslashes($theme_opts['adsense_300x250']) ?></textarea>
      <p class="description"><label for="adsense_300x250"><?php printf(__('Paste your AdSense 300x250 code', WPTHEME_TEXT_DOMAIN)); ?></label></p>
      </fieldset>
    </td>
    </tr>
    
    </tbody>
    </table>

  </div><!--#tabs-1-->
  
</div><!--#tabs-->

    <p class="submit"><input type="submit" value="<?php esc_attr_e( 'Save Changes', WPTHEME_TEXT_DOMAIN ) ?>" class="button button-primary" id="submit" name="save_options"></p>
    </form>
    
  </div><!--.wrap-->

  <?php

}


function catpichub_do_checkbox($key) {
  global $theme_opts;

  if( isset($theme_opts[$key]) ) {
    if( $theme_opts[$key] == 'on' ) {
      echo 'checked="checked" value="on"';
    }
  }
}



/**
 * Load styles and javascripts
 */
function catpichub_admin_scripts() {
  wp_register_style( 'catpichub_ui_css', get_template_directory_uri() . '/lib/css/catpichub_ui.css', false, '1.0.0' );
  wp_enqueue_style( 'catpichub_ui_css' );
  wp_enqueue_style( 'thickbox' );
  wp_enqueue_script( 'jquery-ui-tabs' );
  wp_enqueue_script( 'media-upload' );
  wp_enqueue_script( 'thickbox' );
  
  if ( is_admin() ) {
    wp_enqueue_script( 'catpichub_script',
          get_template_directory_uri() . '/lib/js/tabs.js',
          array('jquery'));
    wp_enqueue_media();
    wp_register_script('catpichub-upload', get_template_directory_uri() .'/lib/js/favicon-upload-3.5.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('catpichub-upload');
  
  }

}
add_action('admin_enqueue_scripts', 'catpichub_admin_scripts');


/**
 * Display admin notifications
 */
function catpichub_notices() {
  
  $notice = '';
  $message = '';
   
  if( strlen($notice) > 1 )
    printf('<div class="error fade"><p>%s</p></div>', $notice);
    
  if( strlen($message) > 1 )
    printf(__('<div class="updated fade"><p>%sGo to <a href="%s">Options</a> to resolve this matter.</p></div>', WPTHEME_TEXT_DOMAIN), $message, admin_url('admin.php?page=catpichub-options#resolve-warning'));
  
}
add_action('admin_notices', 'catpichub_notices');


/**
 * Register theme custom menu in WordPress Administration screen
 *
 * @uses admin_menu hook
 */
function theme_menu () {

  // Add a submenu to the custom top-level menu:
  add_theme_page('Appearance', __('Catpichub Options', WPTHEME_TEXT_DOMAIN), 'edit_posts', 'catpichub-options', 'catpichub_options_fn');

}
add_action( 'admin_menu' ,'theme_menu' );
