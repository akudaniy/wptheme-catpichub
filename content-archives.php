<?php 
/**
 * The default template for displaying archives, categories, etc
 *
 * Used for both single and index/archive/search.
 *
 * @package Catpichub
 */

global $n;

?>

<tr>
  <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
</tr>
