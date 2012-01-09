<?php

global $wpdb ;

if (of_get_option('show_image_slider')) { // Using Nivo Slider


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
					
					<img src="<?php  slider_image() ; ?>" width="565" height="290" title="<?php the_title(); ?>" />
					
				</a>
				
				<?php endwhile;  wp_reset_postdata(); ?>
	
			</div>
<?php }
 
function slider_options() { ?>
	<script type="text/javascript">jQuery(document).ready(function(){
			
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
		});
			
				
	
		</script>
<?php } 
add_action( 'wp_footer', 'slider_options' );
} // end Nivo Slider

if ( of_get_option('show_carousel_featured') || of_get_option('show_carousel_recent') ) {
	function carousel_options() {
		echo '
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery(".k-jigo-carousel").jcarousel({
					// Configuration goes here
					});
				});
			</script>
		' ;
	}
add_action( 'wp_footer', 'carousel_options' );
function carousel_scripts() {
	echo '<style type="text/css">
.jcarousel {
    position: relative;
    overflow: hidden;
}

.jcarousel ul {
    width: 20000em;
    position: absolute;
    list-style: none;
    margin: 0;
    padding: 0;
}

.jcarousel li {
    float: left;
}

.jcarousel[dir=rtl] li {
    float: right;
} </style>';
}
add_action('wp_head', 'carousel_scripts');
}
?>