<?php
// Register Custom Post Type
function inscricoes() {

	$labels = array(
		'name'                  => _x( 'Inscrições', 'Post Type General Name', 'bza_inscricoes' ),
		'singular_name'         => _x( 'Projeto', 'Post Type Singular Name', 'bza_inscricoes' ),
		'menu_name'             => __( 'Projetos', 'bza_inscricoes' ),
		'name_admin_bar'        => __( 'Projeto', 'bza_inscricoes' ),
		'archives'              => __( 'Item Archives', 'bza_inscricoes' ),
		'attributes'            => __( 'Item Attributes', 'bza_inscricoes' ),
		'parent_item_colon'     => __( 'Parent Item:', 'bza_inscricoes' ),
		'all_items'             => __( 'All Items', 'bza_inscricoes' ),
		'add_new_item'          => __( 'Add New Item', 'bza_inscricoes' ),
		'add_new'               => __( 'Add new', 'bza_inscricoes' ),
		'new_item'              => __( 'New Item', 'bza_inscricoes' ),
		'edit_item'             => __( 'Edit Item', 'bza_inscricoes' ),
		'update_item'           => __( 'Update Item', 'bza_inscricoes' ),
		'view_item'             => __( 'View Item', 'bza_inscricoes' ),
		'view_items'            => __( 'View Items', 'bza_inscricoes' ),
		'search_items'          => __( 'Search Item', 'bza_inscricoes' ),
		'not_found'             => __( 'Not found', 'bza_inscricoes' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'bza_inscricoes' ),
		'featured_image'        => __( 'Featured Image', 'bza_inscricoes' ),
		'set_featured_image'    => __( 'Set featured image', 'bza_inscricoes' ),
		'remove_featured_image' => __( 'Remove featured image', 'bza_inscricoes' ),
		'use_featured_image'    => __( 'Use as featured image', 'bza_inscricoes' ),
		'insert_into_item'      => __( 'Insert into item', 'bza_inscricoes' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'bza_inscricoes' ),
		'items_list'            => __( 'Items list', 'bza_inscricoes' ),
		'items_list_navigation' => __( 'Items list navigation', 'bza_inscricoes' ),
		'filter_items_list'     => __( 'Filter items list', 'bza_inscricoes' ),

	);
	$args = array(
		'rewrite' => array('slug' => 'inscricoes'),
		'label'                 => __( 'Projeto', 'bza_inscricoes' ),
		'description'           => __( 'Projetos de candidatos', 'bza_inscricoes' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'projetos',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'bza_inscricoes', $args );

}
add_action( 'init', 'inscricoes', 0 );
