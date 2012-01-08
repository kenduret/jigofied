<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

$current_layout = of_get_option('page_layout');

if ( 'content' != $current_layout ) :
if (   ! is_active_sidebar( 'sidebar-3'  ) ) return;
?>
		
			
<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		
		<div id="slider-aside" class="slider widget-area" role="complementary">

				<?php dynamic_sidebar( 'sidebar-3' ); ?>
				
		</div><!-- #secondary .widget-area -->
		
<?php endif; ?>
		
		
<?php endif; ?>