var sidebar_filters_opened = false;
var is_mobile = false;

jQuery(function($) {

	$(window).resize(function() {
		swap_elements();
	});
	$(document).ready(function() {
		copy_elems_to_m_menu();
		swap_elements();
	});


	//mobile menu
	function copy_elems_to_m_menu() {
		$("header .wp-block-site-logo").clone().prependTo("header nav .wp-block-navigation__responsive-dialog");
		$(".header > div:not(:first-child)").each(function(index) {
			$(this).clone().appendTo("header nav .wp-block-navigation__responsive-container-content");
		});
	}

	//speacker personal page
	function swap_elements() {
		let elem = $('.speakers-total-info > figure');
		if ($(window).width() < 768) {
			elem.prependTo(".speakers-total-info");
		} else {
			elem.appendTo(".speakers-total-info");
		}
	}

});