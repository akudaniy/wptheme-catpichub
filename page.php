<?php 
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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

    <?php while( have_posts() ): the_post(); ?>
    <article itemscope itemtype="http://schema.org/Article">
    <h1 itemprop="name" class="entry-title"><?php the_title(); ?></h1>

    <div class="entry-content" itemprop="articleBody">
      <?php the_content(); ?>
    </div><!--.entry-content-->
    </article>    

    <?php endwhile; ?>

  </div>
  
  <?php get_sidebar(); ?>
  
</div><!--.wrapper-->
</div><!--.col-md-12-->
</div><!--.row-->
</div><!--.container-->

<?php get_footer(); ?>
