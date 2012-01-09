<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Background Defaults
	
	$body_background_defaults = array(
	'color' => '#fcfcfc',
	'image' => 'wp-content/themes/skeleton/images/border_top.png',
	'repeat' => 'repeat-x',
	'position' => 'top center',
	'attachment'=>'fixed');
	
	
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('template_directory') . '/admin/images/';
		
	$options = array();
						
	$options[] = array( "name" => "Style Options",
						"type" => "heading");
												
	$options[] = array( "name" => "Style Options",
						"desc" => "The following options allow you to apply basic customizations to your theme colors. In some cases however, you will need to edit CSS. <br /> This can be done from <a href=\"theme-editor.php\">stylesheet editor</a> or by navigating to Appearance &rarr; Editor.",
						"type" => "info");
						
	if ( class_exists( 'jigoshop' ) ) {
		$options[] = array( "name" => "Display Cart",
							"desc" => "Jigoshop is installed. Would you like to show a mini cart here instead?",
							"id" => "show_mini_cart",
							"type" => "checkbox");
							
		$options[] = array( "name" => "Home page shout Box",
						"desc" => "HTML or text can be inserted into the Shout Box. You might add twitter icons, badges, or a site announcement here.",
						"id" => "shout_box",
						"std" => "",
						"type" => "textarea");
							
		$options[] = array( "name" => "Featured Products",
							"desc" => "Show featured products on the home page.",
							"id" => "show_featured",
							"type" => "checkbox");
		
		$options[] = array( "name" => "Display in carousel",
							"desc" => "Display featured products in Jcarousel.",
							"id" => "show_carousel_featured",
							"type" => "checkbox");
		
		$options[] = array( "name" => "Featured Products Number",
							"desc" => "Number of featured products to show.",
							"id" => "show_count_featured",
							"std" => "10",
							"class" => "mini",
							"type" => "text");
		
		$options[] = array( "name" => "Recent Products",
							"desc" => "Show recent products on the home page.",
							"id" => "show_recent",
							"type" => "checkbox");
		
		$options[] = array( "name" => "Display recent in carousel",
							"desc" => "Show recent products in Jcarousel.",
							"id" => "show_carousel_recent",
							"type" => "checkbox");
		
		$options[] = array( "name" => "Recent Products Number",
							"desc" => "Number of recent products to show.",
							"id" => "show_count_recent",
							"std" => "10",
							"class" => "mini",
							"type" => "text");
	}					
	$options[] = array( "name" => "Logo Style",
						"desc" => "Display a custom image/logo image in place of title header.",
						"id" => "use_logo_image",
						"type" => "checkbox");


	$options[] = array( "name" => "Header Logo",
						"desc" => "If you prefer to show a graphic logo in place of the header, you can upload or paste the URL here. Set the width and height below. <strong>Your logo should be resized prior to uploading</strong>",
						"id" => "header_logo",
						"class" => "hidden",
						"type" => "upload");
						
	$options[] = array( "name" => "Logo Width",
						"desc" => "Width (in px) of Your logo.",
						"id" => "logo_width",
						"std" => "300",
						"class" => "mini hidden",
						"type" => "text");
						
	$options[] = array( "name" => "Logo Height",
						"desc" => "Height (in px) of Your logo.",
						"id" => "logo_height",
						"std" => "80",
						"class" => "mini hidden",
						"type" => "text");
  	
	/* $options[] = array( "name" =>  "Body Background",
						"desc" => "Change the background CSS.",
						"id" => "body_background",
						"std" => $body_background_defaults, 
						"type" => "background"); */
						
	$options[] = array( "name" => "Sidebar Position",
						"desc" => "Select a sidebar layout position (left or right). You can also select a wide page layout on a per-page basis.",
						"id" => "page_layout",
						"std" => "right",
						"type" => "images",
						"options" => array(
							'left' => $imagepath . '2cl.png',
							'right' => $imagepath . '2cr.png',
							'1col' => $imagepath . '1col.png',)
						);
  
	$options[] = array( "name" => "Header (text) Color",
						"desc" => "Header Colors.",
						"id" => "header_color",
						"std" => "#000000",
						"type" => "color");
  
	$options[] = array( "name" => "Link Color",
						"desc" => "Default hyperlink colors.",
						"id" => "link_color",
						"std" => "#3568A9",
						"type" => "color");

  $options[] = array( "name" => "Main Body Typography",
					"desc" => "Body Typography.",
					"id" => "body_typography",
					"std" => array('size' => '14px','face' => 'helvetica','style' => 'normal','color' => '#444444'),
					"type" => "typography");			

						
	$options[] = array( "name" => "(H1) Heading Typography",
						"desc" => "Heading typography.",
						"id" => "h1_typography",
						"std" => array('size' => '40px','face' => 'helvetica','style' => 'normal','color' => '#181818'),
						"type" => "typography");
  
  $options[] = array( "name" => "(H2) Heading Typography",
					"desc" => "Heading Two typography.",
					"id" => "h2_typography",
					"std" => array('size' => '35px','face' => 'helvetica','style' => 'normal','color' => '#181818'),
					"type" => "typography");			
				  

  $options[] = array( "name" => "(H3) Heading Typography",
					"desc" => "Heading Three typography.",
					"id" => "h3_typography",
					"std" => array('size' => '28px','face' => 'helvetica','style' => 'normal','color' => '#181818'),
					"type" => "typography");
	
	$options[] = array( "name" => "(H4) Heading Typography",
					"desc" => "Heading Four typography.",
					"id" => "h4_typography",
					"std" => array('size' => '21px','face' => 'helvetica','style' => 'bold','color' => '#181818'),
					"type" => "typography");			
	
 $options[] = array( "name" => "(H5) Heading Typography",
 				"desc" => "Heading Five typography.",
 				"id" => "h5_typography",
 				"std" => array('size' => '17px','face' => 'helvetica','style' => 'bold','color' => '#181818'),
 				"type" => "typography");
	

							
	$options[] = array( "name" => "Additional Scripts",
						"type" => "heading");
	
	$options[] = array( "name" => "Add Scripts and Text",
						"desc" => "The following options allow you to apply basic customizations to your theme colors. In some cases however, you will need to edit CSS. <br /> This can be done from <a href=\"theme-editor.php\">stylesheet editor</a> or by navigating to Appearance &rarr; Editor.",
						"type" => "info");
	
	$options[] = array( "name" => "Extra Header Text",
						"desc" => "HTML or text can be inserted into the header. You might add twitter icons, badges, or a site announcement here.",
						"id" => "header_extra",
						"std" => "",
						"type" => "textarea"); 
	
	$options[] = array( "name" => "Footer Fine Print",
						"desc" => "HTML or text to be inserted into the very bottom after the widgets.",
						"id" => "footer_text",
						"std" => "",
						"type" => "textarea"); 
						
	$options[] = array( "name" => "Footer Scripts",
						"desc" => "Add custom footer scripts such as Google Analytics. Do not include the &lt;script&gt; tag. This is already done for you.",
						"id" => "footer_scripts",
						"std" => "",
						"type" => "textarea");
						
	$options[] = array( "name" => "Image Slider",
						"type" => "heading");
						
	$options[] = array( "name" => "Configure Image Slider",
						"desc" => "The following options allow you to apply basic customizations to your theme colors. In some cases however, you will need to edit CSS. <br /> This can be done from <a href=\"theme-editor.php\">stylesheet editor</a> or by navigating to Appearance &rarr; Editor.",
						"type" => "info");
						
	$options[] = array( "name" 	=> "Home Page Image Slider",
						"desc" 	=> "Would you like to show an image slider on the home page?",
						"id" 	=> "show_image_slider",
						"type" 	=> "checkbox");
	
	$options[] = array( "name" 	=> "Delay Between Images",
						"desc" 	=> "How long each slide will show in milliseconds (1000 = 1 second).",
						"id" 	=> "transition_delay",
						"std" 	=> "5000",
						"class" => "mini hidden",
						"type" 	=> "text");
						
	// Slider data
	$slider_array = array(
		"random" 			=> "random",
		"sliceDown" 		=> "sliceDown",
		"sliceDownLeft" 	=> "sliceDownLeft",
		"sliceUp" 			=> "sliceUp",
		"sliceUpLeft" 		=> "sliceUpLeft",
		"sliceUpDown" 		=> "sliceUpDown",
		"sliceUpDownLeft" 	=> "sliceUpDownLeft",
		"fold" 				=> "fold",
		"fade" 				=> "fade",
		"slideInRight" 		=> "slideInRight",
		"slideInLeft" 		=> "slideInLeft",
		"boxRandom" 		=> "boxRandom",
		"boxRain" 			=> "boxRain",
		"boxRainReverse" 	=> "boxRainReverse",
		"boxRainGrow" 		=> "boxRainGrow",
		"boxRainGrowReverse"=> "boxRainGrowReverse",
		);
$slider_defaults = array("random" => "random");
	$options[] = array( "name" 		=> "Transition Effect",
						"desc" 		=> "Select the transition effect for images.",
						"id" 		=> "transition_select",
						"class" 	=> "mini hidden",
						"std" 		=> "random",
						"type" 		=> "select",
						"options" 	=> $slider_array);
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	$options[] = array( "name" => "Select a Category",
						"desc" => "Passed an array of categories with cat_ID and cat_name",
						"id" => "select_categories",
						"class" 	=> "mini hidden",
						"type" => "select",
						"options" => $options_categories);
						
	$options[] = array( "name" 	=> "Transition Speed",
						"desc" 	=> "Square transition speed in milliseconds (1000 = 1 second).",
						"id" 	=> "transition_speed",
						"std" 	=> "50",
						"class" => "mini hidden",
						"type" 	=> "text");
	
	$options[] = array( "name" 	=> "Squares Per Width",
						"desc" 	=> "Number of image squares per width of slider. Caution: a high number of squares can have adverse effects.",
						"id" 	=> "width_squares",
						"std" 	=> "5",
						"class" => "mini hidden",
						"type" 	=> "text");
	
	$options[] = array( "name" => "Squares Per Height",
						"desc" => "Number of image squares per height of slider. Caution: a high number of squares can have adverse effects.",
						"id" => "height_squares",
						"std" => "7",
						"class" => "mini hidden",
						"type" => "text");
	
	$options[] = array( "name" => "Slices",
						"desc" => "Number of slices image. Caution: a high number of slices can have adverse effects.",
						"id" => "image_slices",
						"std" => "15",
						"class" => "mini hidden",
						"type" => "text");
	return $options;
}