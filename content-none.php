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

<div class="col-xs-12">

<h2>Sorry, no posts available under this archive</h2>

<p>However, you can scroll through the below list, and maybe find anything you've looked for.</p>

<table class="table table-striped">
<?php 

$randposts = new WP_Query( array('posts_per_page'=>15, 'post_type'=>'post', 'orderby'=>'rand') );
while( $randposts->have_posts() ): $randposts->the_post(); ?>
<tr>
<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
</tr>
<?php endwhile; ?>

</table>

</div>
