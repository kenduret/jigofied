<?php
/**
 Template Name: Home Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php if ( function_exists('ktheme_slider') ) { ktheme_slider(); } ?>
				
				<?php // Set up query for recent products
    	$query_args = array(
    		'showposts'		=> 5,
    		'post_type'		=> 'product',
    		'post_status'	=> 'publish',
    		'orderby'		=> 'date',
    		'order'			=> 'desc',
    		'meta_query'	=> array(
    			array(
    				'key'		=> 'visibility',
    				'value'		=> array('catalog', 'visible'),
    				'compare'	=> 'IN',
    			),
    		)
    	);
		$recent_jigo = new WP_Query($query_args);
		
		// If there are products
		if($recent_jigo->have_posts()) {
			// Open the list
			echo '<ul class="products">';
			
			// Print out each product
			while($recent_jigo->have_posts()) : $recent_jigo->the_post();  
				
				// Get new jigoshop_product instance
				$_product = new jigoshop_product(get_the_ID());
			
				echo '<li>';
					// Print the product image & title with a link to the permalink
					echo '<a href="'.get_permalink().'" title="'.esc_attr(get_the_title()).'">';
					echo (has_post_thumbnail()) ? the_post_thumbnail('thumbnail') : jigoshop_get_image_placeholder('shop_thumbnail');
					echo '<span class="js_widget_product_title">' . get_the_title() . '</span>';
					echo '</a>';
					
					// Print the price with html wrappers
					echo '<span class="js_widget_product_price">' . $_product->get_price_html() . '</span>';
				echo '</li>';
			endwhile;
			
			echo '</ul>'; // Close the list
			
			wp_reset_postdata(); } ?>
			<div style="clear:both;"></div>

				<?php if ( have_posts() ) : ?>

				<?php twentyeleven_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>


			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>