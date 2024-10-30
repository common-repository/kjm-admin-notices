<?php

##########################
### NOTICE ###
##########################

/* Custom Post Type : kjm_notice */

$labels = array(
	'name'               => __('Notices', 'kjm-admin-notices'),
	'singular_name'      => __('Notice', 'kjm-admin-notices'),
	'add_new'            => __('Add Notice', 'kjm-admin-notices'),
	'add_new_item'       => __('Add Notice', 'kjm-admin-notices'),
	'edit_item'          => __('Edit Notice', 'kjm-admin-notices'),
	'new_item'           => __('New Notice', 'kjm-admin-notices'),
	'all_items'          => __('All Notices', 'kjm-admin-notices'),
	'view_item'          => __('View Notice', 'kjm-admin-notices'),
	'search_items'       => __('Search Notices', 'kjm-admin-notices'),
	'not_found'          => __('No Notice found', 'kjm-admin-notices'),
	'not_found_in_trash' => __('No Notice found in trash', 'kjm-admin-notices'), 
	'parent_item_colon'  => '',
	'menu_name'          => __('Notices', 'kjm-admin-notices')
);

$args = array(
	'labels'        => $labels,
	'description'   => __('Contains all Notices and their related data.', 'kjm-admin-notices'),
	'public'        => false,
	'publicly_queryable' => false,
	'show_ui' => true, 
	'show_in_menu' => true,
	'query_var' => false,
	'rewrite' => array('slug' => 'kjm_notice'),
	'capability_type' => 'post',
	'capabilities'        => array(
	'publish_posts'       => 'update_core',
	'edit_others_posts'   => 'update_core',
	'delete_posts'        => 'update_core',
	'delete_others_posts' => 'update_core',
	'read_private_posts'  => 'update_core',
	'edit_post'           => 'update_core',
	'delete_post'         => 'update_core',
	'read_post'           => 'edit_posts',
	),
	'menu_position' => 40,
	'supports' => array('title','editor', 'author', /* 'comments' ,'thumbnail', 'excerpt', 'post-formats'*/),
	'hierarchical' => false,
	'has_archive'   => false,
	'taxonomies' => array( 'kjm_notice_tag', 'kjm_notice_cat' ), // Add tags support.
);

