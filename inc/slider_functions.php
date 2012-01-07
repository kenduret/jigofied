<?php
if (of_get_option('show_image_slider')) {

function ktheme_slider_styles() {
  echo '<link media="all" type="text/css" href="' . get_bloginfo('template_url') . '/inc/slider/nivo-slider.css" rel="stylesheet" />';
}
function ktheme_slider_scripts() {
	wp_enqueue_script('nivo',get_bloginfo('template_url') . '/inc/slider/nivo.js',array('jquery'), '1.0');
	//wp_enqueue_script('slider',get_bloginfo('template_url') . '/js/slider.js');
	 
	
}
add_action('wp_head', 'ktheme_slider_styles');
//add_action('wp_head', 'ktheme_slider_scripts');

function ktheme_slider () { 

		$cats = of_get_option('select_categories');
		$args = array(
			'category__in' => array($cats),
			'showposts' => 3,
			'ignore_sticky_posts' => 1
		);
		$myPosts = new WP_Query();
	
		$myPosts->query($args); ?>

			<div id="slider" class="nivoSlider">
			
				<?php while ($myPosts->have_posts()) : $myPosts->the_post(); ?>
				
				<a href="<?php the_permalink() ?>">
					<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slider-image', false, '' ); ?>
					<img src="<?php  echo $src[0]; ?>" width="565" height="290" title="<?php the_title(); ?>" />
					
				</a>
				
				<?php endwhile;  wp_reset_postdata(); ?>
	
			</div>
		
		
			<script type="text/javascript">jQuery(document).ready(function($){
			
			 jQuery('#slider').nivoSlider({
			 
				effect: '<?php echo of_get_option('transition_select');?>', // Specify sets like: 'fold,fade,sliceDown'
				slices: <?php echo of_get_option('image_slices'); ?>, // For slice animations
				boxCols: <?php echo of_get_option('width_squares'); ?>, // For box animations
				boxRows: <?php echo of_get_option('height_squares'); ?>, // For box animations
				animSpeed: <?php echo of_get_option('transition_speed'); ?>, // Slide transition speed
				pauseTime: <?php echo of_get_option('transition_delay'); ?>,  // delay between images in ms
				directionNav: true, // Next & Prev navigation
				directionNavHide: true, // Only show on hover
				controlNav: true, // 1,2,3... navigation
			 
			 });
			
       // your $ code here
	   //jQuery("#slider").coinslider({
		//	width: 			565, // width of slider panel
		//	height: 		290, // height of slider panel
		//	spw: 			<?php echo of_get_option('width_squares');?>, // squares per width
		//	sph: 			<?php echo of_get_option('height_squares');?>, // squares per height
		//	delay: 			<?php echo of_get_option('transition_delay');?>, // delay between images in ms
		//	sDelay: 		<?php echo of_get_option('transition_speed');?>, // delay beetwen squares in ms
		//	opacity: 		0.7, // opacity of title and navigation
		//	titleSpeed: 	2000, // speed of title appereance in ms
		//	effect: 		'<?php echo of_get_option('transition_select');?>', // random, swirl, rain, straight
		//	navigation: 	true, // prev next and buttons
		//	links : 		true, // show images as links
		//	hoverPause: 	true // pause on hover
		//		});
});
			
				
	
		</script>
<?php

	}
} ?>