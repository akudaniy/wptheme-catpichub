  <footer>
    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="alpha-sitemap">
          Sitemap Index: 
          <?php $alphas = get_terms( 'alphabets', array('hide_empty'=>false) ); ?>
          <?php foreach ($alphas as $alpha) { ?>
            <a href="<?php echo get_term_link($alpha) ?>"><?php echo $alpha->name ?></a> 
          <?php } ?>
        </div>

        <?php

        $botmenu_init = array(
          'theme_location'  => 'footer',
          'container'       => 'div',
          'container_class' => 'bottom-menu',
          'echo'            => true,
          'fallback_cb'     => '',
          'items_wrap'      => '<ul id="%1$s" class="%2$s nomb clearfix">%3$s</ul>',
          'depth'           => 0,
          'walker'          => new Bootstrap_Walker_Nav_Menu,
        );

        wp_nav_menu( $botmenu_init ); ?>
        
        <div class="copyright">Copyright &copy; <?php echo date("Y", time()) ?> <?php bloginfo("name") ?></div>
      </div>

    </div>
    </div>

  </footer>

  <script src="<?php echo get_template_directory_uri() ?>/lib/js/jquery-1.10.1.min.js" type="text/javascript"></script>
  <script src="<?php echo get_template_directory_uri() ?>/lib/js/bootstrap.min.js" type="text/javascript"></script>


  <script type="text/javascript">

    $(document).ready(function(){
      $(".widget-head").next().addClass("widget-body");

      var widgetheads = $(".widget .widget-head");
      var op = 0;
      widgetheads.each(function(){
        $(this).addClass('head-ID-' + op);
        op++;
      });
    });

  </script>
  
  <?php wp_footer(); ?>

  </body>
</html>
