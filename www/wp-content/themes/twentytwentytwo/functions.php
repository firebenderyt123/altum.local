<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';





//menu
register_nav_menus(array(
	'top'    => 'Top menu',
	'bottom' => 'Bottom menu'
));


// Speakers
add_action( 'init', 'create_speakers_types' );
function create_speakers_types(){
	register_post_type( 'speakers', array(
		'label'    => null,
		'labels'   => array(
			'name'               => 'All Speakers',
			'singular_name'      => 'Speaker',
			'add_new'            => 'Add Speaker',
			'add_new_item'       => 'Single Speaker',
			'edit_item'          => 'Edit Speaker',
			'new_item'           => 'New Speaker',
			'view_item'          => 'View Speaker',
			'search_items'       => 'Find Speaker',
			'not_found'          => 'Not Found Speaker',
			'not_found_in_trash' => 'Not Found Speaker In Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Speakers',
		),
		'description'         => 'Here you can add speakers',
		'public'              => true,
		'hierarchical'        => false,
		'rewrite'             => array( 'slug' => 'speakers' ),
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'          => array( 'speakers_positions', 'speakers_countries' ),
		'has_archive'         => true,
		'show_in_rest'        => true
	) );
}

add_action( 'init', 'create_speakers_positions', 0 );
function create_speakers_positions() {
	register_taxonomy(
			'speakers_positions',
			['speakers'],
		array(
			'labels' => array(
				'name' => 'Positions',
				'add_new_item' => 'Add New Position',
				'new_item_name' => "New Position"
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'speakers-positions' ),
			'show_in_rest' => true
		)
	);
}

add_action( 'init', 'create_speakers_countries', 0 );
function create_speakers_countries() {
	register_taxonomy(
		'speakers_countries',
		['speakers'],
		array(
			'labels' => array(
				'name' => 'Countries',
				'add_new_item' => 'Add New Country',
				'new_item_name' => "New Country"
			),
			'show_ui' => true,
			'show_tagcloud' => false,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => 'speakers-countries' ),
			'show_in_rest' => true
		)
	);
}


// Sessions
add_action( 'init', 'create_sessions_types' );
function create_sessions_types(){
	register_post_type( 'sessions', array(
		'label'    => null,
		'labels'   => array(
			'name'               => 'All Sessions',
			'singular_name'      => 'Session',
			'add_new'            => 'Add Session',
			'add_new_item'       => 'Single Session',
			'edit_item'          => 'Edit Session',
			'new_item'           => 'New Session',
			'view_item'          => 'View Session',
			'search_items'       => 'Find Session',
			'not_found'          => 'Not Found Session',
			'not_found_in_trash' => 'Not Found Session In Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Sessions',
		),
		'description'         => 'Here you can add sessions',
		'public'              => true,
		'hierarchical'        => false,
		'rewrite'             => array( 'slug' => 'sessions' ),
		'supports'            => array( 'title'),
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	) );
}

// ajax post loader
add_action( 'wp_enqueue_scripts', 'load_more_scripts' );
function load_more_scripts() {
 
	global $wp_query; 
 
	wp_enqueue_script('jquery');
 
	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/assets/js/loadmore.js', array('jquery') );
 

	wp_localize_script( 'my_loadmore', 'loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
		'posts' => json_encode( $wp_query->query_vars ),
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 0,
		'max_page' => $wp_query->max_num_pages
	) );

 	wp_enqueue_script( 'my_loadmore' );
}

add_action('wp_ajax_loadmore', 'loadmore_ajax_handler');
add_action('wp_ajax_nopriv_loadmore', 'loadmore_ajax_handler');
function loadmore_ajax_handler(){
 
	$taxonomies = array();
	foreach ($_POST['filters'] as $taxonomy) {
		//var_dump($_POST['filters']);
		array_push($taxonomies, array(
			'taxonomy' => $taxonomy['taxonomy'],
			'field'    => 'slug',
			'terms'    => $taxonomy['terms'],
			'include_children' => true,
			'operator' => 'IN'
		));
	}

	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'];
	$args['post_status'] = 'publish';
	$args['tax_query'] = $taxonomies;
	$args['orderby'] = $_POST['orderby'];
	$args['order'] = $_POST['order'];

	//var_dump(json_decode( stripslashes( $_POST['query'] ), true ));

	query_posts( $args );

	if( have_posts() ) :
		while( have_posts() ): the_post();

			$thumb = get_the_post_thumbnail();
			$link = get_permalink();

			echo '<div class="card">
				<div class="card-image">
					<a href="' . $link . '">' . $thumb . '</a>
				</div>
				<div class="card-content">
					<div class="card-title">
						<h6><a href="' . $link . '">' . get_the_title() . '</a></h6>
					</div>
					<div class="country">
						<p>' . get_the_terms($post->ID, 'speakers_countries')[0]->name . '</p>
					</div>
				</div>
			</div>';
		endwhile;
	endif;
	die;
}

// add_shortcode('filters', 'get_filters');
// function get_filters($atts) {

// 	$default = array(
// 		'taxonomy' => 'category',
// 	);
// 	$args = shortcode_atts($default, $atts);

// 	$out = '<div class="taxonomy-list custom-select ' . $args['taxonomy'] . '"><select>';

// 	$terms = get_terms([
// 		'taxonomy' => $args['taxonomy'],
// 		'hide_empty' => false
// 	]);

// 	$tax_obj = get_taxonomy($args['taxonomy']);

// 	$out .= '<option name="' . $args['taxonomy'] . '" value="' . $args['taxonomy'] . '"> -- ' . $tax_obj->labels->name . ' -- </option>';
// 	foreach ($terms as $term) {
// 		$out .= '<option name="' . $term->slug . '" value="' . $term->slug . '">' . $term->name . '</option>';
// 	}

// 	$out .= '</select></div>';

// 	return $out;
// }

add_shortcode('filters', 'get_filters');
function get_filters($atts) {

	$default = array(
		'taxonomy' => 'category',
	);
	$args = shortcode_atts($default, $atts);

	$terms = get_terms([
		'taxonomy' => $args['taxonomy'],
		'hide_empty' => false
	]);

	$tax_obj = get_taxonomy($args['taxonomy']);

	$out = '<div class="taxonomy-list custom-select ' . $args['taxonomy'] . '"><div class="select-styled"> -- ' . $tax_obj->labels->name . ' -- </div>
	<div class="select-options">';

	$out .= '<div class="item" rel="' . $args['taxonomy'] . '"> All ' . $tax_obj->labels->name . '</div>';
	foreach ($terms as $term) {
		$out .= '<div class="item" rel="' . $term->slug . '">' . $term->name . '</div>';
	}

	$out .= '</div></div>';

	return $out;
}



//custom blocks
require get_template_directory() . '/blocks/acf-sessions-block/block.php';



// edit srcset for images
add_filter( 'wp_calculate_image_srcset', 'change_srcset', 10, 1 ); // work not with all images
function change_srcset( $sources ) {
	
	foreach ($sources as $key => $source) {
		$src = $source['url'];
		break;
	}

	preg_match('/.*(?=\.)/isu', $src, $part_of_name);
	preg_match('/\..{3,4}$/isu', $src, $format);

	$mobile_src = $part_of_name[0] . '-mobile' . $format[0];

	if ( check_url($mobile_src) ) {

		foreach ($sources as $key => $source) {
			if ( $key <= 480 )
				unset($sources[$key]);
		}

		$sources[480] = array(
			'url' => $mobile_src,
			'descriptor' => 'w',
			'value' => 480
		);
	}

	return $sources;
}

add_filter('wp_get_attachment_image_attributes', 'update_image_attr', 10, 3);
function update_image_attr($attr, $post, $size='full') { // here I can add setsec where it's missing

	$arr = change_srcset( array(
		array(
			'url' => $attr['src'],
			'descriptor' => 'w',
			'value' => 1500
		)
	) );

	foreach ($arr as $key => $value) {
		if ( isset($out) )
			$out .= ', ';
		$out .= $value['url'] . ' ' . $value['value'] . $value['descriptor'];
	}

	$attr['srcset'] = $attr['src'] . ' 1500w, ' . $out;
	return $attr;
}

function check_url( $url ) {
	global $wpdb;
	$image = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url));

	if( !empty($image) )
		return true;
	else
		return false;
}


add_filter( 'post_thumbnail_html', 'set_default_post_thumb' );
function set_default_post_thumb( $html ) {
    // If there is no post thumbnail,
    // Return a default image
    if ( '' == $html ) {
        return '<img width="250" height="300" src="/wp-content/uploads/2022/07/Micro.png" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="" loading="lazy">';
    }
    // Else, return the post thumbnail
    return $html;
}


// others
add_action( 'wp_enqueue_scripts', 'connect_scripts_styles' );
function connect_scripts_styles() {
	wp_enqueue_script( 'custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), false );
}
