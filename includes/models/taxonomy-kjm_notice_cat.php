<?php

##################################
### TAXONOMY : KJM NOTICE CAT ###
##################################

// Add new taxonomy : kjm_notice_cat

$labels = array(
	'name'              => __( 'Notice Cats', 'kjm-admin-notices' ),
	'singular_name'     => __( 'Notice Cat', 'kjm-admin-notices' ),
	'search_items'      => __( 'Search Notice Cat', 'kjm-admin-notices' ),
	'all_items'         => __( 'All Notice Cats', 'kjm-admin-notices' ),
	'parent_item'       => __( 'Parent Notice Cat', 'kjm-admin-notices' ),
	'parent_item_colon' => __( 'Parent Notice Cat:', 'kjm-admin-notices' ),
	'edit_item'         => __( 'Edit Notice Cat', 'kjm-admin-notices' ),
	'update_item'       => __( 'Update Notice Cat', 'kjm-admin-notices' ),
	'add_new_item'      => __( 'Add New Notice Cat', 'kjm-admin-notices' ),
	'new_item_name'     => __( 'New Notice Cat', 'kjm-admin-notices' ),
	'menu_name'         => __( 'Notice Cats', 'kjm-admin-notices' ),
);

$args = array(
	'hierarchical'      => true,
	'labels'            => $labels,
	'label' 			=>  __( 'Notice Cats', 'kjm-admin-notices' ),
	'show_ui'           => true,
	'show_admin_column' => true,
	'query_var'         => true,
	'rewrite'           => array('slug' => 'kjm_notice_cat'),
);

$post_types = array('kjm_notice');
