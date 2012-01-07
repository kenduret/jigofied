var jQuery = jQuery.noConflict();

jQuery(window).load(function() {

	jQuery('#slider').nivoSlider({
		animSpeed:200,
		pauseTime:6000,
		slices:7
	});
});