<?php
// Award Winners (Hasselbladspristagare)
function post_award_winners() {
	$labels = array(
		'name'               => _x( 'Award Winners', 'post type general name' ),
		'singular_name'      => _x( 'Award Winner', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'award winner' ),
		'add_new_item'       => __( 'Add New Award Winner' ),
		'edit_item'          => __( 'Edit Award Winner' ),
		'new_item'           => __( 'New Award Winner' ),
		'all_items'          => __( 'All Award Winners' ),
		'view_item'          => __( 'View Award Winner' ),
		'search_items'       => __( 'Search Award Winners' ),
		'not_found'          => __( 'No Award Winner found' ),
		'not_found_in_trash' => __( 'No Award Winner found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Awards'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our award winners specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('award_winner_post', $args );	
}
add_action( 'init', 'post_award_winners' );
function taxonomies_award_winners() {
	$labels = array(
		'name'              => _x( 'Award Winner Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Award Winner Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Award Winner Categories' ),
		'all_items'         => __( 'All Award Winner Categories' ),
		'parent_item'       => __( 'Parent Award Winner Category' ),
		'parent_item_colon' => __( 'Parent Award Winner Category:' ),
		'edit_item'         => __( 'Edit Award Winner Category' ), 
		'update_item'       => __( 'Update Award Winner Category' ),
		'add_new_item'      => __( 'Add New Award Winner Category' ),
		'new_item_name'     => __( 'New Award Winner Category' ),
		'menu_name'         => __( 'Award Winner Categories' )
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'award_winners_category', 'award_winner_post', $args );
}
add_action( 'init', 'taxonomies_award_winners', 0 );

// Stipends (Stipendiater)
function post_stipends() {
	$labels = array(
		'name'               => _x( 'Stipends', 'post type general name' ),
		'singular_name'      => _x( 'Stipend', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'stipend' ),
		'add_new_item'       => __( 'Add New Stipend' ),
		'edit_item'          => __( 'Edit Stipend' ),
		'new_item'           => __( 'New Stipend' ),
		'all_items'          => __( 'All Stipends' ),
		'view_item'          => __( 'View Stipend' ),
		'search_items'       => __( 'Search Stipends' ),
		'not_found'          => __( 'No Stipends found' ),
		'not_found_in_trash' => __( 'No Stipends found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Stipends'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our stipend specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('stipend_post', $args );	
}
add_action( 'init', 'post_stipends' );
function taxonomies_stipends() {
	$labels = array(
		'name'              => _x( 'Stipend Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Stipend Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Stipend Categories' ),
		'all_items'         => __( 'All Stipend Categories' ),
		'parent_item'       => __( 'Parent Stipend Category' ),
		'parent_item_colon' => __( 'Parent Stipend Category:' ),
		'edit_item'         => __( 'Edit Stipend Category' ), 
		'update_item'       => __( 'Update Stipend Category' ),
		'add_new_item'      => __( 'Add New Stipend Category' ),
		'new_item_name'     => __( 'New Stipend Category' ),
		'menu_name'         => __( 'Stipend Categories' )
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'stipend_category', 'stipend_post', $args );
}
add_action( 'init', 'taxonomies_stipends', 0 );

// Boards (Styrelsen)
function post_board_post() {
	$labels = array(
		'name'               => _x( 'Board Post', 'post type general name' ),
		'singular_name'      => _x( 'Board Post', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'board post' ),
		'add_new_item'       => __( 'Add New Board Post' ),
		'edit_item'          => __( 'Edit Board Post' ),
		'new_item'           => __( 'New Board Post' ),
		'all_items'          => __( 'All Board Posts' ),
		'view_item'          => __( 'View Board Post' ),
		'search_items'       => __( 'Search Board Posts' ),
		'not_found'          => __( 'No Board Post found' ),
		'not_found_in_trash' => __( 'No Board Post found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Board Posts'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our board post specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('board_post', $args );	
}
add_action( 'init', 'post_board_post' );
function taxonomies_board_posts() {
	$labels = array(
		'name'              => _x( 'Board Post Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Board Post Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Board Post Categories' ),
		'all_items'         => __( 'All Board Post Categories' ),
		'parent_item'       => __( 'Parent Board Post Category' ),
		'parent_item_colon' => __( 'Parent Board Post Category:' ),
		'edit_item'         => __( 'Edit Board Post Category' ), 
		'update_item'       => __( 'Update Board Post Category' ),
		'add_new_item'      => __( 'Add New Board Post Category' ),
		'new_item_name'     => __( 'New Board Post Category' ),
		'menu_name'         => __( 'Board Post Categories' )
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'board_post_category', 'board_post', $args );
}
add_action( 'init', 'taxonomies_board_posts', 0 );

// appropriation (Anslag)
function post_appropriation() {
	$labels = array(
		'name'               => _x( 'Appropriation', 'post type general name' ),
		'singular_name'      => _x( 'Appropriation', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'appropriation' ),
		'add_new_item'       => __( 'Add New Appropriation' ),
		'edit_item'          => __( 'Edit Appropriation' ),
		'new_item'           => __( 'New Appropriation' ),
		'all_items'          => __( 'All Appropriations' ),
		'view_item'          => __( 'View Appropriations' ),
		'search_items'       => __( 'Search Appropriations' ),
		'not_found'          => __( 'No appropriations found' ),
		'not_found_in_trash' => __( 'No appropriations found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Appropriations'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our appropriation specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('appropriation_post', $args );	
}
add_action( 'init', 'post_appropriation' );
function taxonomies_appropriation_posts() {
	$labels = array(
		'name'              => _x( 'Appropriation Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Appropriation Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Appropriation Categories' ),
		'all_items'         => __( 'All Appropriation Categories' ),
		'parent_item'       => __( 'Parent Appropriation Category' ),
		'parent_item_colon' => __( 'Parent Appropriation Category:' ),
		'edit_item'         => __( 'Edit Appropriation Category' ), 
		'update_item'       => __( 'Update Appropriation Category' ),
		'add_new_item'      => __( 'Add New Appropriation Category' ),
		'new_item_name'     => __( 'New Appropriation Category' ),
		'menu_name'         => __( 'Appropriation Categories' )
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'appropriation_category', 'appropriation_post', $args );
}
add_action( 'init', 'taxonomies_appropriation_posts', 0 );

// Exhibitions (Utställningar)
function post_exhibition() {
	$labels = array(
		'name'               => _x( 'Exhibitions', 'post type general name' ),
		'singular_name'      => _x( 'Exhibition', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'exhibition' ),
		'add_new_item'       => __( 'Add New Exhibition' ),
		'edit_item'          => __( 'Edit Exhibition' ),
		'new_item'           => __( 'New Exhibition' ),
		'all_items'          => __( 'All Exhibitions' ),
		'view_item'          => __( 'View Exhibition' ),
		'search_items'       => __( 'Search Exhibition' ),
		'not_found'          => __( 'No Exhibition found' ),
		'not_found_in_trash' => __( 'No exhibition found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Exhibitions'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our award winners specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('exhibition_post', $args );	
}
add_action( 'init', 'post_exhibition' );
function taxonomies_exhibitions() {
	$labels = array(
		'name'              => _x( 'Exhibition Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Exhibition Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Exhibition Categories' ),
		'all_items'         => __( 'All Exhibition Categories' ),
		'parent_item'       => __( 'Parent Exhibition Category' ),
		'parent_item_colon' => __( 'Parent Exhibition Category:' ),
		'edit_item'         => __( 'Edit Exhibition Category' ), 
		'update_item'       => __( 'Update Exhibition Category' ),
		'add_new_item'      => __( 'Add New Exhibition Category' ),
		'new_item_name'     => __( 'New Exhibition Category' ),
		'menu_name'         => __( 'Exhibition Categories' )
		
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'exhibition_category', 'exhibition_post', $args );
}
add_action( 'init', 'taxonomies_exhibitions', 0 );

// Seminar (Seminarium)
function post_seminar() {
	$labels = array(
		'name'               => _x( 'Seminars', 'post type general name' ),
		'singular_name'      => _x( 'Seminar', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'newsletter' ),
		'add_new_item'       => __( 'Add New Seminar' ),
		'edit_item'          => __( 'Edit Seminar' ),
		'new_item'           => __( 'New Seiminar' ),
		'all_items'          => __( 'All Seminars' ),
		'view_item'          => __( 'View Seminar' ),
		'search_items'       => __( 'Search Seminars' ),
		'not_found'          => __( 'No Seminars found' ),
		'not_found_in_trash' => __( 'No seminars found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Seminars'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our seminar specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('seminar_post', $args );	
}
add_action( 'init', 'post_seminar' );
function taxonomies_seminars() {
	$labels = array(
		'name'              => _x( 'Seminar Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Seminar Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Seminar Categories' ),
		'all_items'         => __( 'All Seminar Categories' ),
		'parent_item'       => __( 'Parent Seminar Category' ),
		'parent_item_colon' => __( 'Parent Seminar Category:' ),
		'edit_item'         => __( 'Edit Seminar Category' ), 
		'update_item'       => __( 'Update Seminar Category' ),
		'add_new_item'      => __( 'Add New Seminar Category' ),
		'new_item_name'     => __( 'New Seminar Category' ),
		'menu_name'         => __( 'Seminar Categories' )
		
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'seminar_category', 'seminar_post', $args );
}
add_action( 'init', 'taxonomies_seminars', 0 );

// Research (forskning)
function post_research() {
	$labels = array(
		'name'               => _x( 'Research', 'post type general name' ),
		'singular_name'      => _x( 'Research', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Research' ),
		'add_new_item'       => __( 'Add New Research' ),
		'edit_item'          => __( 'Edit Research' ),
		'new_item'           => __( 'New Research' ),
		'all_items'          => __( 'All Research' ),
		'view_item'          => __( 'View Research' ),
		'search_items'       => __( 'Search Research' ),
		'not_found'          => __( 'No Research found' ),
		'not_found_in_trash' => __( 'No Research found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Research'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our research specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('research_post', $args );	
}
add_action( 'init', 'post_research' );
function taxonomies_research() {
	$labels = array(
		'name'              => _x( 'Research Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Research Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Research Categories' ),
		'all_items'         => __( 'All Research Categories' ),
		'parent_item'       => __( 'Parent Research Category' ),
		'parent_item_colon' => __( 'Parent Research Category:' ),
		'edit_item'         => __( 'Edit Research Category' ), 
		'update_item'       => __( 'Update Research Category' ),
		'add_new_item'      => __( 'Add New Research Category' ),
		'new_item_name'     => __( 'New Research Category' ),
		'menu_name'         => __( 'Research Categories' )
		
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'research_category', 'research_post', $args );
}
add_action( 'init', 'taxonomies_research', 0 );

//  Press
function post_press() {
	$labels = array(
		'name'               => _x( 'Press', 'post type general name' ),
		'singular_name'      => _x( 'Press', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Press' ),
		'add_new_item'       => __( 'Add New Press' ),
		'edit_item'          => __( 'Edit Press' ),
		'new_item'           => __( 'New Press' ),
		'all_items'          => __( 'All Press' ),
		'view_item'          => __( 'View Press' ),
		'search_items'       => __( 'Search Press' ),
		'not_found'          => __( 'No Press found' ),
		'not_found_in_trash' => __( 'No Press found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Press'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our press specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('press_post', $args );	
}
add_action( 'init', 'post_press' );
function taxonomies_press() {
	$labels = array(
		'name'              => _x( 'Press Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Press Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Press Categories' ),
		'all_items'         => __( 'All Press Categories' ),
		'parent_item'       => __( 'Parent Press Category' ),
		'parent_item_colon' => __( 'Parent Press Category:' ),
		'edit_item'         => __( 'Edit Press Category' ), 
		'update_item'       => __( 'Update Press Category' ),
		'add_new_item'      => __( 'Add New Press Category' ),
		'new_item_name'     => __( 'New Press Category' ),
		'menu_name'         => __( 'Press Categories' )
		
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'press_category', 'press_post', $args );
}
add_action( 'init', 'taxonomies_press', 0 );

// Publications
function post_publication() {
	$labels = array(
		'name'               => _x( 'Publications', 'post type general name' ),
		'singular_name'      => _x( 'Publication', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'Publication' ),
		'add_new_item'       => __( 'Add New Publications' ),
		'edit_item'          => __( 'Edit Publication' ),
		'new_item'           => __( 'New Publication' ),
		'all_items'          => __( 'All Publications' ),
		'view_item'          => __( 'View Publication' ),
		'search_items'       => __( 'Search Publication' ),
		'not_found'          => __( 'No Publication found' ),
		'not_found_in_trash' => __( 'No Publication found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Publications'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our publications specific data',
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true
	);
	register_post_type('publication_post', $args );	
}
add_action( 'init', 'post_publication' );
function taxonomies_publication() {
	$labels = array(
		'name'              => _x( 'Publication Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Publication Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Publication Categories' ),
		'all_items'         => __( 'All Publication Categories' ),
		'parent_item'       => __( 'Parent Publication Category' ),
		'parent_item_colon' => __( 'Parent Publication Category:' ),
		'edit_item'         => __( 'Edit Publication Category' ), 
		'update_item'       => __( 'Update Publication Category' ),
		'add_new_item'      => __( 'Add New Publication Category' ),
		'new_item_name'     => __( 'New Publication Category' ),
		'menu_name'         => __( 'Publication Categories' )
		
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true
	);
	register_taxonomy( 'publication_category', 'publication_post', $args );
}
add_action( 'init', 'taxonomies_publication', 0 );
?>