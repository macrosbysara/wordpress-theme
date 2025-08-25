<?php
/**
 * CPT Handler
 *
 * Register All Custom Post Types and Taxonomies as needed
 *
 * @package MacrosBySara
 */

namespace MacrosBySara;

/**
 * Class: CPT Handler
 */
class CPT_Handler {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_my_cpts' ) );
	}

	/**
	 * Register Linktree CPT
	 */
	public function register_my_cpts() {

		register_post_type(
			'links',
			array(
				'label'                 => 'Links',
				'labels'                => array(
					'name'                     => 'Links',
					'singular_name'            => 'Link',
					'menu_name'                => 'My Linktree',
					'all_items'                => 'All Links',
					'add_new'                  => 'Add new',
					'add_new_item'             => 'Add new Link',
					'edit_item'                => 'Edit Link',
					'new_item'                 => 'New Link',
					'view_item'                => 'View Link',
					'view_items'               => 'View Links',
					'search_items'             => 'Search Links',
					'not_found'                => 'No Links found',
					'not_found_in_trash'       => 'No Links found in trash',
					'parent'                   => 'Parent Link:',
					'featured_image'           => 'Featured image for this Link',
					'set_featured_image'       => 'Set featured image for this Link',
					'remove_featured_image'    => 'Remove featured image for this Link',
					'use_featured_image'       => 'Use as featured image for this Link ',
					'archives'                 => 'Link archives',
					'insert_into_item'         => 'Insert into Link',
					'uploaded_to_this_item'    => 'Upload to this Link',
					'filter_items_list'        => 'Filter Links list',
					'items_list_navigation'    => 'Links list navigation',
					'items_list'               => 'Links list',
					'attributes'               => 'Links attributes',
					'name_admin_bar'           => 'Link',
					'item_published'           => 'Link published',
					'item_published_privately' => 'Link published privately.',
					'item_reverted_to_draft'   => 'Link reverted to draft.',
					'item_scheduled'           => 'Link scheduled',
					'item_updated'             => 'Link updated.',
					'parent_item_colon'        => 'Parent Link:',
				),
				'description'           => '',
				'public'                => true,
				'publicly_queryable'    => true,
				'show_ui'               => true,
				'show_in_rest'          => true,
				'rest_base'             => '',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'has_archive'           => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => true,
				'delete_with_user'      => false,
				'exclude_from_search'   => false,
				'capability_type'       => 'post',
				'map_meta_cap'          => true,
				'hierarchical'          => false,
				'rewrite'               => array(
					'slug'       => 'links',
					'with_front' => true,
				),
				'query_var'             => true,
				'menu_position'         => 6,
				'menu_icon'             => 'dashicons-admin-links',
				'supports'              => array( 'title' ),
			)
		);
	}
}
