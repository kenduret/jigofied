<?php
global $wpdb ;

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

//Mini cart in header
if (of_get_option('show_mini_cart')) {
	
function jigo_mini_cart() {
	$extras  = "<div class=\"header-mini-cart\">";
	$extras .= '<a href="'.jigoshop_cart::get_cart_url().'" class="minicart">';
	$extras .= '<span>';
	$extras .=  jigoshop_cart::$cart_contents_count.' items';
	$extras .= '</span>';
	$extras .=  jigoshop_cart::get_cart_total();
	$extras .= '</a>';
	$extras .= "</div>";
	echo apply_filters ('child_header_extras',$extras);
}
} // endif

// Home Page featured products [featured_products per_page="12" columns="4"]
if (of_get_option('show_featured')) {
	function k_jigo_featured() {
	
	// Create query vars
	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => of_get_option('show_count_featured'),
		'meta_query' => array(
			array(
				'key' => 'visibility',
				'value' => array( 'catalog', 'visible' ),
				'compare' => 'IN'
			),
			array(
				'key' => 'featured',
				'value' => 'yes'
			)
		)
	);
	
	echo '<h3 class="widget-title">Featured Products</h3>';
	
	if ( of_get_option('show_carousel_featured')) { echo '<div id="carousel" class="featured">'; }

	query_posts( $args );

	jigoshop_get_template_part( 'loop', 'shop' );
	
	wp_reset_query();

	if ( of_get_option('show_carousel_featured')) { echo '</div><div style="clear:both;">'; }
		
	}
}


// Home Page recent products [recent_products per_page="12" columns="4"]
if (of_get_option('show_recent')) {
	function k_jigo_recent() {
		echo '<h3 class="widget-title">Recent Products</h3>';
	if ( of_get_option('show_carousel_recent')) { echo '<div id="carousel" class="recent">'; }
		echo do_shortcode('[recent_products per_page="' . of_get_option('show_count_recent') . '" columns="5"]');
	if ( of_get_option('show_carousel_recent')) { echo '</div>'; }
	}
}

if (!function_exists('jigoshop_get_sidebar')) {
	function jigoshop_get_sidebar() {
		get_sidebar('store');
	}
}
?>