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

if (!function_exists('jigoshop_get_sidebar')) {
	function jigoshop_get_sidebar() {
		get_sidebar('store');
	}
}
?>