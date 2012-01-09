<?php
/**
 * K-Jigo functions and definitions
 * @package WordPress
 * @subpackage K-Jigo
 * @since Twenty Eleven 1.0
 */

/* Initialize the Options Framework
* http://wptheming.com/options-framework-theme/
*/
if ( !function_exists( 'optionsframework_init' ) ) {
	define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}

/* 
 * Add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

if (!function_exists('optionsframework_custom_scripts')) {
function optionsframework_custom_scripts() { ?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#use_logo_image').click(function() {
				jQuery('#section-header_logo,#section-logo_width,#section-logo_height').fadeToggle(400);
			});
			
			if (jQuery('#use_logo_image:checked').val() !== undefined) {
				jQuery('#section-header_logo,#section-logo_width,#section-logo_height').show();
			}	
		
			jQuery('#show_image_slider').click(function() {
				jQuery('#section-transition_delay,#section-transition_select,#section-transition_speed,#section-width_squares,#section-height_squares,#section-image_slices,#section-select_categories').fadeToggle(400);
			});	
		
			if (jQuery('#show_image_slider:checked').val() !== undefined) {
				jQuery('#section-transition_delay,#section-transition_select,#section-transition_speed,#section-width_squares,#section-height_squares,#section-image_slices,#section-select_categories').show();
			}	
		});
	</script>
<?php }
}
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

/**
 * Adds Twenty Eleven layout classes to the array of body classes.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_layout_classes( $existing_classes ) {
	$current_layout = of_get_option('page_layout');

	if ( in_array( $current_layout, array( 'left', 'right' ) ) )
		$classes = array( 'two-column' );
	else
		$classes = array( 'one-column' );

	if ( 'right' == $current_layout )
		$classes[] = 'right-sidebar';
	elseif ( 'left' == $current_layout )
		$classes[] = 'left-sidebar';
	else
		$classes[] = $current_layout;

	$classes = apply_filters( 'twentyeleven_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'twentyeleven_layout_classes' );

/**
* Add message to header area
*/
if ( !function_exists( 'twentyeleven_header_extras' ) ) {

function twentyeleven_header_extras() {
	if (of_get_option('header_extra')) {
		$extras  = "<div class=\"header-extra\">";
		$extras .= of_get_option('header_extra');
		$extras .= "</div>";
		echo apply_filters ('child_header_extras',$extras);
	}
}
} // endif

function twentyeleven_footer_extras() {
	if (of_get_option('footer_text')) {
		$extras  = "<div class=\"footer-extra\">";
		$extras .= of_get_option('footer_text');
		$extras .= "</div>";
		echo apply_filters ('child_header_extras',$extras);
	}
}
add_action( 'wp_footer', 'twentyeleven_footer_extras', 1 );


// Build the logo
if ( !function_exists( 'twentyeleven_logo' ) ) {
function twentyeleven_logo() {
	// Displays H1 or DIV based on whether we are on the home page or not (SEO)
	$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div';
	if (of_get_option('use_logo_image')) {
		$class="graphic";
	} else {
		$class="text"; 		
	}
	// echo of_get_option('header_logo')
	$twentyeleven_logo  = '<'.$heading_tag.' id="site-title" class="'.$class.'"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo('name','display')).'">'.get_bloginfo('name').'</a></'.$heading_tag.'>'. "\n";
	$twentyeleven_logo .= '<span id="site-description" class=" '.$class.'">'.get_bloginfo('description').'</span>'. "\n";
	echo apply_filters ( 'child_logo' , $twentyeleven_logo);
}
} // endif
// Dumps the css into the header for image replacement of H1 tag
if ( !function_exists( 'logostyle' ) ) {

function logostyle() {
	if (of_get_option('use_logo_image')) {
	echo '<style type="text/css">
	#branding #site-title.graphic a {background-image: url('.of_get_option('header_logo').');width: '.of_get_option('logo_width').'px;height: '.of_get_option('logo_height').'px;}</style>';
	}
}

} //endif
add_action('wp_head', 'logostyle');


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/**
 * Tell WordPress to run twentyeleven_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'twentyeleven_setup' );

if ( ! function_exists( 'twentyeleven_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function twentyeleven_setup() {

// Add some style
function twentyeleven_styles(){
	wp_register_style('k-jigo', get_bloginfo('template_directory') .'/jigoshop.css' . false, '1.0', 'screen' );
	wp_register_style( 'nivo-slider', get_template_directory_uri() . '/inc/slider/nivo-slider.css' . false, '1.0', 'screen' );
	if (of_get_option('show_image_slider')) {
		wp_enqueue_style( 'nivo-slider');
	}
	if ( class_exists( 'jigoshop' ) ) {
		wp_enqueue_style( 'k-jigo');
	}
}
add_action('wp_print_styles', 'twentyeleven_styles');

// Add some javascript
function twentyeleven_scripts(){
	wp_register_script('nivo', get_template_directory_uri() . '/inc/slider/nivo.js',array('jquery'));
	wp_register_script('jcarousel', get_template_directory_uri() . '/js/jcarousel.min.js',array('jquery'));
	wp_register_script('swipe', get_template_directory_uri() . '/js/jcarousel.swipe.min.js',array('jcarousel'));
	wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
	if (of_get_option('show_image_slider')) {
		wp_enqueue_script('nivo');
	}
	if ( of_get_option('show_carousel_featured') || of_get_option('show_carousel_recent')  ) {
		wp_enqueue_script('jcarousel');
		wp_enqueue_script('swipe');
	}
}
add_action('wp_enqueue_scripts', 'twentyeleven_scripts');

function slider_image() { // http://www.noeltock.com/web-design/wordpress/custom-post-types-events-pt1/
$post_image_id = get_post_thumbnail_id(get_the_ID());
    if ($post_image_id) {
    $thumbnail = wp_get_attachment_image_src( $post_image_id, 'slider-image', false);
    if ($thumbnail) (string)$thumbnail = $thumbnail[0];
    echo $thumbnail;
}
}

	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Grab Twenty Eleven's Ephemera widget and slider functions
	require( get_template_directory() . '/inc/widgets.php' ); // Slated for upgrades
	require( get_template_directory() . '/inc/slider_functions.php' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	//This theme uses wp_nav_menus() for the header menu, utility menu and footer menu.
	register_nav_menus( array(
		'utility' 	=> __( 'Utility Menu', 'themename' ),
		'primary' 	=> __( 'Primary Menu', 'themename' ),
		'footer' 	=> __( 'Footer Menu', 'themename' ),
	) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// This theme uses Featured Images
	add_theme_support( 'post-thumbnails' );
	// Generate a slider image on upload
	add_image_size( 'slider-image', 565, 290, true );

}
endif; // twentyeleven_setup

// Enable Shortcodes in excerpts and widgets
add_filter('widget_text', 'do_shortcode');
add_filter( 'the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');

/**
 * Sets the post excerpt length to 40 words.
 */
function twentyeleven_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyeleven_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 */
function twentyeleven_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyeleven_continue_reading_link().
 */
function twentyeleven_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyeleven_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function twentyeleven_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyeleven_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyeleven_custom_excerpt_more' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function twentyeleven_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyeleven_page_menu_args' );

/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_widgets_init() {

	register_widget( 'Twenty_Eleven_Ephemera_Widget' ); // Slated for removal

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Store Sidebar', 'twentyeleven' ),
		'id' => 'sidebar-2',
		'description' => __( 'The sidebar for the Store section of your website', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Below Slider', 'twentyeleven' ),
		'id' => 'sidebar-3',
		'description' => __( 'Widgets here appear below the image slider on the Home page.', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'twentyeleven' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'twentyeleven' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'twentyeleven' ),
		'id' => 'sidebar-6',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentyeleven_widgets_init' );

if ( ! function_exists( 'twentyeleven_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function twentyeleven_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // twentyeleven_content_nav

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function twentyeleven_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-6' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}

if ( ! function_exists( 'twentyeleven_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyeleven_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for twentyeleven_comment()

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentyeleven_body_classes' );

/**
* If enabled, adds theme Jigoshop functions
*/
if ( class_exists( 'jigoshop' ) ) {
	include_once (STYLESHEETPATH . '/inc/jigoshop_functions.php');

}
?>