<?php

// =============================================================================
// FUNCTIONS.PHP
// -----------------------------------------------------------------------------
// Overwrite or add your own custom functions to Pro in this file.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Enqueue Parent Stylesheet
//   02. Additional Functions
// =============================================================================

// Enqueue Parent Stylesheet
// =============================================================================

add_filter( 'x_enqueue_parent_stylesheet', '__return_true' );



// Additional Functions
// =============================================================================

function cptui_register_my_cpts() {

	/**
	 * Post Type: Links.
	 */

	$labels = [
		"name" => __( "Links", "custom-post-type-ui" ),
		"singular_name" => __( "Link", "custom-post-type-ui" ),
		"menu_name" => __( "My Linktree", "custom-post-type-ui" ),
		"all_items" => __( "All Links", "custom-post-type-ui" ),
		"add_new" => __( "Add new", "custom-post-type-ui" ),
		"add_new_item" => __( "Add new Link", "custom-post-type-ui" ),
		"edit_item" => __( "Edit Link", "custom-post-type-ui" ),
		"new_item" => __( "New Link", "custom-post-type-ui" ),
		"view_item" => __( "View Link", "custom-post-type-ui" ),
		"view_items" => __( "View Links", "custom-post-type-ui" ),
		"search_items" => __( "Search Links", "custom-post-type-ui" ),
		"not_found" => __( "No Links found", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "No Links found in trash", "custom-post-type-ui" ),
		"parent" => __( "Parent Link:", "custom-post-type-ui" ),
		"featured_image" => __( "Featured image for this Link", "custom-post-type-ui" ),
		"set_featured_image" => __( "Set featured image for this Link", "custom-post-type-ui" ),
		"remove_featured_image" => __( "Remove featured image for this Link", "custom-post-type-ui" ),
		"use_featured_image" => __( "Use as featured image for this Link", "custom-post-type-ui" ),
		"archives" => __( "Link archives", "custom-post-type-ui" ),
		"insert_into_item" => __( "Insert into Link", "custom-post-type-ui" ),
		"uploaded_to_this_item" => __( "Upload to this Link", "custom-post-type-ui" ),
		"filter_items_list" => __( "Filter Links list", "custom-post-type-ui" ),
		"items_list_navigation" => __( "Links list navigation", "custom-post-type-ui" ),
		"items_list" => __( "Links list", "custom-post-type-ui" ),
		"attributes" => __( "Links attributes", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Link", "custom-post-type-ui" ),
		"item_published" => __( "Link published", "custom-post-type-ui" ),
		"item_published_privately" => __( "Link published privately.", "custom-post-type-ui" ),
		"item_reverted_to_draft" => __( "Link reverted to draft.", "custom-post-type-ui" ),
		"item_scheduled" => __( "Link scheduled", "custom-post-type-ui" ),
		"item_updated" => __( "Link updated.", "custom-post-type-ui" ),
		"parent_item_colon" => __( "Parent Link:", "custom-post-type-ui" ),
	];

	$args = [
		"label" => __( "Links", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "links", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 6,
		"menu_icon" => "dashicons-admin-links",
		"supports" => [ "title" ],
		"show_in_graphql" => false,
	];

	register_post_type( "links", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

