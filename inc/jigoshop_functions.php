<?php
/* Stylesheet */
function add_jigo_styles() {
    wp_enqueue_style('jigoshop', get_bloginfo('template_directory').'/jigoshop.css' . false, '1.0' );
}
add_action('wp_head', 'add_jigo_styles');
/* Content Wrappers */

function k_jigo_open_jigoshop_content_wrappers()
{
    echo '<div id="primary"><div id="content" role="main">';
}

function k_jigo_close_jigoshop_content_wrappers()
{
    echo '</div></div>';
}

function k_jigo_prepare_jigoshop_wrappers()
{
    remove_action( 'jigoshop_before_main_content', 'jigoshop_output_content_wrapper', 10 );
    remove_action( 'jigoshop_after_main_content', 'jigoshop_output_content_wrapper_end', 10);
    
    add_action( 'jigoshop_before_main_content', 'k_jigo_open_jigoshop_content_wrappers', 10 );
    add_action( 'jigoshop_after_main_content', 'k_jigo_close_jigoshop_content_wrappers', 10 );
}
add_action( 'wp_head', 'k_jigo_prepare_jigoshop_wrappers' );

// Uses thumbnail setting in admin Settings >> Media >> Image Sizes
if (!function_exists('jigoshop_get_product_thumbnail')) {
	function jigoshop_get_product_thumbnail( $size = 'thumbnail' ) {

		global $post;

		if ( has_post_thumbnail() )
			return get_the_post_thumbnail($post->ID, $size);
		else
			return jigoshop_get_image_placeholder( $size );
	}
}

// Home Page reecent products
function k_jigo_recent() { 
	echo '<div id="recent-products-home">';
			echo	'<h2>Recently Added Products</h2>';
		 // Set up query for recent products
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
					do_action('jigoshop_after_shop_loop_item', $post, $_product);
				echo '</li>';
			endwhile;
			
			echo '</ul>'; // Close the list
			
			wp_reset_postdata(); } 
			
			echo '</div><!-- recent products home --><div style="clear:both;"></div>';
}

if (!function_exists('jigoshop_get_sidebar')) {
	function jigoshop_get_sidebar() {
		get_sidebar('store');
	}
}
?>