<?php
/**
 * The sidebar containing the left sidebar widget area.
 *
 * @package Kickoff
 */

if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area-left" role="complementary">
	<?php dynamic_sidebar( 'sidebar-left' ); ?>

</div><!-- #secondary -->

