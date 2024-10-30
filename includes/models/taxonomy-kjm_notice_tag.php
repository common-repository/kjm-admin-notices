<?php

##################################
### TAXONOMY : KJM NOTICE TAG ###
##################################

// Add new taxonomy : kjm_notice_tag

$labels = array(
	'name'              => __( 'Notices Tags', 'kjm-admin-notices' ),
	'singular_name'     => __( 'Notice Tag', 'kjm-admin-notices' ),
	'search_items'      => __( 'Search Notice Tags', 'kjm-admin-notices' ),
	'all_items'         => __( 'All Notices Tags', 'kjm-admin-notices' ),
	'parent_item'       => __( 'Parent Notice Tag', 'kjm-admin-notices' ),
	'parent_item_colon' => __( 'Parent Notice Tag:', 'kjm-admin-notices' ),
	'edit_item'         => __( 'Edit Notice Tag', 'kjm-admin-notices' ),
	'update_item'       => __( 'Update Notice Tag', 'kjm-admin-notices' ),
	'add_new_item'      => __( 'Add New Notice Tag', 'kjm-admin-notices' ),
	'new_item_name'     => __( 'New Notice Tag Name', 'kjm-admin-notices' ),
	'menu_name'         => __( 'Notices Tags', 'kjm-admin-notices' ),
);

$args = array(
	'hierarchical'      => false,
	'labels'            => $labels,
	'label' 			=>  __( 'Notices Tags', 'kjm-admin-notices' ),
	'show_ui'           => true,
	'show_admin_column' => true,
	'query_var'         => true,
	'rewrite'           => array('slug' => 'kjm_notice_tag', 'with_front' => false),
);

$post_types = array('kjm_notice');
