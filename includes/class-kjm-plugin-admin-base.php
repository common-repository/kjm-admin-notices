<?php
/**
 * 
 * Kjm Plugin Admin Base Class.
 * 
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.kajoom.ca/
 * @since      1.0
 * @author     Marc-Antoine Minville <support@kajoom.ca>
 * @copyright 2015 Marc-Antoine Minville
 *
 */
if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}

if ( ! class_exists( 'Kjm_Plugin_Admin_Base_1_0' ) ) :

/**
 * The base admin-specific functionality of the plugin.
 * 
 * Define some common admin functions.
 *
 */
abstract class Kjm_Plugin_Admin_Base_1_0 {
	
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;
	
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;
	
	
	/**
	 * Local instance of plugin shared class
	 *
	 * @since    1.0.1
	 * @access   protected
	 * @var      object    $shared    Shared class.
	 */
	protected $shared;
	
	
	/**
	 * Local instance of Tools class
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @see			Kajoom_Tools
	 * @var			object 	$tools 	Tools class.
	 */
	protected $tools;
	
	
	/**
	 * Plugin settings
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$_settings 	Plugin settings.
	 */
	protected $_settings;
	
	
	/**
	 * Plugin admin options page name
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			string 	$_options_pagename 	Name without ".php" extension.
	 */
	protected $_options_pagename;
	
	
	/**
	 * Plugin update name.
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			string 	$update_name 	Unique update name.
	 */
	protected $update_name;
	
	
	/**
	 * Plugin name with underscores
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			string 	$package_slug 	Plugin name but with underscores.
	 */
	public $package_slug;
	
	
	/**
	 * Accepted args for orderby request
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$orderby_args 	Array of accepted args names.
	 */
	protected $orderby_args;
	
	
	/**
	 * Accepted args for order request
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$order_args 	Array of accepted args names.
	 */
	protected $order_args;
	
	
	/**
	 * Accepted args for group request
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$group_args 	Array of accepted args values.
	 */
	protected $group_args;
	
	
	/**
	 * Holds actual request and definitions
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$request 	Array of accepted keys and initial values.
	 */
	protected $request;
	
	
	/**
	 * Holds current messages to be displayed
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$messages 	List of messages strings.
	 */
	public $messages;
	
	/**
	 * Holds current variables to display as debug info
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$debug 	List of variables to debug.
	 */
	protected $debug;
	
	
	/**
	 * Holds admin IPs to whitelist for debug display
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$debug_ips 	List of admin IPs.
	 */
	protected $debug_ips;
	
	
	/**
	 * The Settings menu page of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $menu_page    The current menu page of the plugin.
	 */
	protected $menu_page;
	
	
	/**
	 * Modules.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array		$modules		List of modules definitions.
	 */
	public $modules;
	
	
	/**
	 * Custom Modules list.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array		$custom_modules		List of custom modules.
	 */
	public $custom_modules;
	
	
	/**
	 * List of fields definitions
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 		$fields			List of fields.
	 */
	public $fields;
	
	
	/**
	 * List of fields mappings
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 		$fields_mapping			List of fields mappings.
	 */
	public $fields_mapping;
	
	
	/**
	 * List of fields to show in general views
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 		$show_fields			List of fields.
	 */
	public $show_fields;
	
	
	/**
	 * List of fields to show in list views
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 		$show_fields_list_view			List of fields.
	 */
	public $show_fields_list_view;
	
	
	/**
	 * List of mappings between modules and custom post types
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$modules_cpt_mapping 	Modules keys and post types values.
	 */
	public $modules_cpt_mapping;
	
	
	/**
	 * List of mappings between custom post types and modules 
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$cpt_modules_mapping 	Post types keys and modules values.
	 */
	public $cpt_modules_mapping;
	
	
	/**
	 * List of custom post types
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$custom_post_types 	CPT name are keys and seeds are values.
	 */
	public $custom_post_types;
	
	
	/**
	 * List of custom taxonomies
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$custom_taxonomies 	Tax names are keys and seeds are values.
	 */
	public $custom_taxonomies;
	
	
	/**
	 * List of settings fields definitions
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$settings_fields 	Settings and definitions in an array.
	 */
	public $settings_fields;
	
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * name:			__construct
	 * @since 			1.0.0
	 * 
	 * @param 			string    $plugin_name    The name of main plugin.
	 * @param 			string    $version    		The version of main plugin.
	 * @param 			object    $shared    			Shared class reference.
	 */
	protected function __construct( $plugin_name, $version, $shared = null ) {
		/**
		 * Detect plugin. For use on Front End only.
		 */
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
		/**
		 * Main plugin name.
		 */ 
		$this->plugin_name = $plugin_name;
		
		/**
		 * Main plugin version.
		 */
		$this->version = $version;
		
		/**
		* Shared local instance.
		*/
		$this->shared = $shared;
		
		/**
		* Get / Set settings.
		*/
		$option_name = $this->format_slug($this->_options_pagename, '_');
		$this->_settings = get_option($option_name) ? get_option($option_name) : array();
		
		/**
		* Set settings standard values.
		*/
		$this->_set_standart_values();
	}
	
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {}
	
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	}
	
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	}
	
	
	/*
	 * Register all plugin shortcodes
	 * 
	 * name: 			register_shortcodes
	 * @since     1.0.0
	 * 
	 */
	public function register_shortcodes() {}
	
	
	 /**
	 * 
	 * Check if actual admin page is this plugin page.
	 *
	 * @since     1.0.0
	 *
	 * @return    false    Return early if no settings page is registered.
	 */
	public function is_package_admin_page() {

		if (!is_admin() || !isset($this->_options_pagename)) {
			return false;
		}

		$screen = get_current_screen();
		#var_dump($screen->id);
		#$this->debug($screen->id);
		
		if (isset($_GET['page']) && $_GET['page'] == $this->plugin_name)  {
			
			return true;
			
		} elseif ($screen->id == 'kjm_notice') {
			
			return true;
			
		} elseif ($screen->id == 'settings_page_'.$this->plugin_name.'-settings' 
		|| $screen->id == 'edit-'.$this->plugin_name.'-settings') {
			
			return true;
			
		} elseif (isset($_GET['post_type']) 
		&& ($_GET['post_type'] == $this->plugin_name 
		|| $_GET['post_type'] == 'kjm_notice')) { 
			
			return true;
			
		} else {
			
			return false;
		}
	}
	
	
	/**
	 * Return the plugin Package slug. (deprecated)
	 *
	 * @since    1.0.0
	 *
	 * @return   string			Package slug variable.
	 */
	public function get_package_slug($format=false) {
		
		if ($format == true) 
			return $this->plugin->format_slug($this->package_slug);
		else
			return $this->package_slug;
	}
	
	
	/**
	 * Return the plugin slug. (deprecated)
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug($format=false) {
		
		if ($format == true) 
			return $this->format_slug($this->plugin_slug);
		else
			return $this->plugin_slug;
	}
	
	
	/**
	 * Return the string formatted.
	 *
	 * @since    1.0.3
	 *
	 * @return    String variable formatted.
	 */
	 
	public function format_slug($slug, $separator='_') {
		
		$slug = sanitize_title($slug);
		$replace = array(' ','-','_');
		
		if ($separator == '_')
			return str_replace($replace, '_', $slug);
		else
			return str_replace($replace, '-', $slug);
	}
	
	
	/**
	 * Check plugin version in db.
	 *
	 * @since    1.0.2
	 *
	 * @return    
	 */
	 
	 public function check_version() {
		 
		 $option_name = $this->plugin_name.'-version';
		 $plugin_version = $this->version;
		 $options_version = get_option($option_name);
		 
		 $numeric_version = $this->version_to_numeric($plugin_version);
		 if ($numeric_version < 10000000) {
			 // Do something.
			 //var_dump($numeric_version);
		 }
		 
		 if ($plugin_version !== $options_version) update_option($option_name, $plugin_version);
	 }
	 
	 
	/**
	 * Convert string plugin version to numeric.
	 *
	 * @since    1.0.2
	 *
	 * @return    Converted to numeric.
	 */
	 
	 protected function version_to_numeric($version) {
		 
		 $version_num = 0;
		 $numerics = array_map('intval', explode('.', $version));
		 $numerics = array_reverse($numerics, false);
		 
		 foreach($numerics as $key => $value) {
			 
			 $version_num += $value * pow(10, $key);
		 }
		 
		 return $version_num;
	 }

	
	/*
	 * Set each setting value to standard if empty.
	 * 
	 * name: 			_set_standart_values
	 * @since     1.0.0
	 * 
	 * @return
	 * 
	 */
	public function _set_standart_values() {
		
		$settings_fields = $this->get_settings_fields();
		
		foreach ($settings_fields as $key => $value) {
			
			if (!array_key_exists($key, $this->_settings)) {
				$this->_settings[$key] = '';
			}
		}
		foreach ($this->_settings as $key => $value) {
			
			if ($value == '') {
				$this->_settings[$key] = $this->settings_fields[$key]['default_value'];
			}
		}
	}
	
	
	/*
	 * Save settings to options table // TODO : Rename option.
	 * 
	 * name: 			_save_settings_todb
	 * @since     1.0.0
	 * 
	 * @param 		array $form_settings		Form settings array.
	 * @return
	 * 
	 */
	public function _save_settings_todb($form_settings = '') {
		
			if ( $form_settings <> '' ) {
				
					unset($form_settings['kajoom_framework_settings_saved']);
					$this->_settings = $form_settings;

					#set standart values in case we have empty fields
					$this->_set_standart_values();
			}
			
			update_option('kajoom_framework_settings', $this->_settings);
	}
	
	
	/*
	 * Get all plugin options or an option value if specified
	 * 
	 * name: 			get_option
	 * @since     1.0.0
	 * 
	 * @param 		string $name				Optional. Option name (the key in the option array).
	 * @return		mixed string|array	Setting(s) value(s).
	 * 
	 */
	public function get_option($name = '') {
		
		$settings = $this->get_settings();
		
		if (!empty($name)) {
			
			if (array_key_exists($name, $settings)) { 
				return $settings[$name];
			}
			return null;
		}
		
		return $settings;
	}
	
	
	/*
	 * Get all plugin settings
	 * 
	 * name: get_settings
	 * @since     1.0.0
	 * 
	 * @return		array			Plugin settings (options).
	 * 
	 */
	public function get_settings() {
		
		return $this->_settings;
	}
	
	
	/*
	 * Get plugin settings fields definitions
	 * 
	 * name: 			get_settings_fields
	 * @since     1.0.0
	 * 
	 * @return		array				Settings fields definitions.
	 * 
	 */
	public function get_settings_fields() {
		
		$fields = $this->settings_fields;
		$strings = $this->get_settings_fields_strings();
		//var_dump($this->settings_fields);
		
		foreach ($fields as $field_name => $field_params) {
			
			$title_field = $field_name.'_title';
			$description_field = $field_name.'_description';
			
			$title = !empty($strings[$title_field]) ? $strings[$title_field]: 'title';
			$description = !empty($strings[$description_field]) ? $strings[$description_field]: 'description';
			
			$fields[$field_name]['title'] = $title;
			$fields[$field_name]['description'] = $description;
		}
		
		return $fields;
	}
	
	
	/*
	 * Load local settings from file
	 * 
	 * name: load_local_settings
	 * @since     1.0.0
	 * 
	 */
	public function load_local_settings() {}
	
	
	/*
	 * Get the settings fields strings from file
	 * 
	 * name: get_settings_fields_strings
	 * @since     1.0.0
	 * 
	 */
	public function get_settings_fields_strings() {}
	
	
	/*
	 * Display all plugin settings fields.
	 * 
	 * name: settings_fields_display
	 * @since     1.0.0
	 * 
	 * @return	string	HTML table rows with fields.
	 * 
	 */
	public function settings_fields_display() {
		
		$fields = $this->get_settings_fields();
		$output = '';
		
		$output .= wp_nonce_field($this->_options_pagename, '_wpnonce', true, false);
		
		foreach($fields as $name => $params) {
			
			$output .= $this->setting_field_display($name, $params);
		}
		
		return $output;
	}
	
	
	/*
	 * Display a plugin setting field.
	 * 
	 * name: setting_field_display
	 * @since     1.0.0
	 * @since     1.1.11		Added types "hidden", "password", "heading" and "custom".
	 * 
	 * @param 		string    $name    		Setting name.
	 * @param 		array    	$params    	Optional. Additional params.
	 * @return		string	HTML table row with field.
	 * 
	 */
	public function setting_field_display($name, $params=array()) {
		
		// Initialize variables.
		$output = $field_line = '';
		
		// Extract pparams.
		extract($params);
		
		$parent = empty($parent) ? $name: $parent;
		$is_parent = $parent == $name ? 'parent': 'child';
		
		// Build field line depending on the field type.
		switch ($type) {
			
			case 'checkbox':
			
				$value = ($this->_settings[$name] == 1) ? 'checked="checked"': '';
				$field_line = '
				<label for="'.$name.'">
					<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="1" '.$value.'>  '.$title.'
				</label>
				<span class="description"> '.$description.' </span>';
				
			break;
			
			case 'heading': 
			
				$value = $this->_settings[$name];
				$field_line = '
				<label for="'.$name.'">
					<span class="description'.$type.'" id="'.$name.'">'.$description.'</span>
				</label>
				';
				
			break;
			
			case 'custom': 
				
				$field_line = apply_filters($this->plugin_name.'_setting_field_display_custom_field_line', $field_line, $name, $params);
				
			break;
			
			case 'text':
			case 'hidden':
			case 'password':
			default: 
			
				$value = $this->_settings[$name];
				$field_line = '
				<label for="'.$name.'">
					<input type="'.$type.'" id="'.$name.'" name="'.$name.'" value="'.$value.'">
				</label>
				<span class="description"> '.$description.' </span>';
		}
		
		// Create table row.
		if ('heading' === $type) {
			$output .= '
			<tr valign="top" class="'.$parent.' '.$is_parent.'">
					<th class="heading" scope="row" colspan="2">
							<h4 style="" title="'.strip_tags($description).'">'.$title.'</h4>
					</th>
			</tr>
			';
		} else {
			$output .= '
			<tr valign="top" class="'.$parent.' '.$is_parent.'">
					<th scope="row">
							<h3 style="">'.$title.'</h3>
					</th>
					<td>
						 '.$field_line.'
					</td>
			</tr>
			';
		}
		
		return $output;
	}
	
	
	/*
	 * Control and set the plugin actual request params
	 * 
	 * name: 			request_controller
	 * @since     1.0.0
	 * 
	 */
	public function request_controller() {}
	
	
	/*
	 * Load the content to be displayed.
	 * 
	 * name: 			content_loader
	 * @since     1.0.0
	 * 
	 */
	public function content_loader() {}
	
	
	/*
	 * Get the custom post types list
	 * 
	 * name: 			get_custom_post_types
	 * @since     1.0.0
	 * 
	 * @return		array			Custom post types list.
	 * 
	 */
	public function get_custom_post_types() {
		
		return $this->custom_post_types;
	}
	
	
	/*
	 * Get a custom post type seed name
	 * 
	 * name: get_custom_post_type_seed
	 * @since     1.0.0
	 * 
	 * @param 		string 		$post_type    Post type name.
	 * @return		string									Custom post type seed.
	 * 
	 */
	public function get_custom_post_type_seed($post_type) {
		
		$seed = false;
		$cpts = $this->get_custom_post_types();
		
		if (!empty($cpts[$post_type])) {
			
			$seed = $cpts[$post_type];
		}
		
		return $seed;
	}
	
	
	/**
	 * Get items with all related data
	 * 
	 * name:			get_items
	 * @since     1.1.0
	 * @since 		Last change on version 1.1.1 to detail.
	 * 
	 * @param 		array 		$args			Query args to be passed to get_posts() function.
	 * @param 		string 		$mode			Optional. Query mode. Not used.
	 * @return		array 							List of items data.
	 * 
	 */
/*
 * 
 * name: get_items
 * @param
 * @return
 * 
 */
	public function get_items($args, $mode='all') {
		
		// Initialize local variables.
		$html = '';
		$items = array();
		
		// General args for request.
		$posts_per_page = !empty($args['posts_per_page']) ? (int) $args['posts_per_page']: 500;
		$offset = !empty($args['offset']) ? $args['offset']: 0;
		//$category = !empty($args['category']) ? $args['category']: '';
		//$category_name = !empty($args['category_name']) ? $args['category_name']: '';
		$orderby = !empty($args['orderby']) ? $args['orderby']: 'title';
		$order = !empty($args['order']) ? $args['order']: 'ASC';
		$include = !empty($args['include']) ? $args['include']: '';
		$exclude = !empty($args['exclude']) ? $args['exclude']: '';
		$meta_key = !empty($args['meta_key']) ? $args['meta_key']: '';
		$meta_value = !empty($args['meta_value']) ? $args['meta_value']: '';
		$post_type = !empty($args['post_type']) ? $args['post_type']: 'post';
		$post_mime_type = !empty($args['post_mime_type']) ? $args['post_mime_type']: '';
		$post_parent = !empty($args['post_parent']) ? $args['post_parent']: '';
		$author = !empty($args['author']) ? $args['author']: '';
		$post_status = !empty($args['post_status']) ? $args['post_status']: 'publish';
		$suppress_filters = !empty($args['suppress_filters']) ? $args['suppress_filters']: false;
		
		// Extra args for request.
		$taxonomy = !empty($args['taxonomy']) ? $args['taxonomy']: '';
		$meta_query = !empty($args['meta_query']) ? $args['meta_query']: null;

		// Default request parameters
		$opt = array(
			
			'posts_per_page'   => $posts_per_page,
			'offset'           => $offset,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => $orderby,
			'order'            => $order,
			'include'          => $include,
			'exclude'          => $exclude,
			'meta_key'         => $meta_key,
			'meta_value'       => $meta_value,
			'post_type'        => $post_type,
			'post_mime_type'   => $post_mime_type,
			'post_parent'      => $post_parent,
			'author'		   => $author,
			'post_status'      => $post_status,
			'suppress_filters' => $suppress_filters,
		);
		
		// Meta Query.
		if (!empty($meta_query) && is_array($meta_query)) {
			$opt['meta_query'] = $meta_query;
			unset($opt['meta_key']);
			unset($opt['meta_value']);
		}
		
		// ID.
		if (!empty($args['ID'])) $opt['ID'] = $args['ID'];
		
		// Taxonomies.
		if (!empty($category)) {
			$cats = array(
				'tax_query' => array(
					array(
						'taxonomy' => !empty($taxonomy) ? $taxonomy: 'category',
						'field' => 'slug',
						'terms' => $category
					)
				)
			);
			$opt = array_merge($opt, $cats);
		}
		
		// Filter to allow request external modifications.
		$opt = apply_filters('kjm_plugin_admin_base_get_items', $opt);
		
		// Debug before calling the posts.
		#$this->debug($opt);

		// Get the posts
		$posts_array = get_posts( $opt );

		$items = array();
		foreach ($posts_array as $post) {
			
			$items[$post->ID]['post'] = $post;
			
			if (class_exists('acf')) {
					$items[$post->ID]['custom_fields'] = maybe_unserialize(get_fields($post->ID));
			} else {
					$items[$post->ID]['custom_fields'] = maybe_unserialize(get_post_custom($post->ID));
			}
			 
			 // Taxonomies : cat.
			$cats = array();
			$cats_obj = get_the_terms( $post->ID, $taxonomy);

			foreach($cats_obj as $cat_obj) { 
			if (!empty($cats_obj) && !empty($cats_obj[0]->name)) { 
					$cats[] = $cat_obj->name; 
				}
			}
			
			// Taxonomies : tags.
			#$tags = array();
			#$tags_obj = get_the_terms( $post->ID, $this->package_slug.'_tags');
			#if (!empty($tags_obj)) foreach($tags_obj as $tag_obj) { $tags[] = $tag_obj->term_id; }
			$items[$post->ID]['taxonomies'] = array(
				$taxonomy => $cats,
				#$this->package_slug.'_tags' => $tags,
			);	
		} 
		wp_reset_postdata();

		return $items;
	}
	
	
	/**
	 * get_item
	 *
	 * @since     1.0.4
	 */
	public function get_item($args) {
	
		// get results
		$the_query = new WP_Query($args);
		$posts = $the_query->posts;
		wp_reset_query();
		
		if (isset($posts[0])) {
			$unique_post = $posts[0];
			$fields = get_fields($unique_post->ID, false);
		} else {
			$unique_post = $fields = array();
		}
		return array('posts' => $unique_post, 'custom_fields' => $fields);
	}
	
	
	/**
	 * get_categories
	 * 
	 * New arg $package_slug added to method to manage packages taxonomies.
	 *
	 * @since     1.0.4
	 */
	public function get_categories($package_slug, $mode='all') {
		
		$html = '';
		$array = array();
		$args = array(
		  'taxonomy' => $package_slug.'_cat'
		);
		
		$categories = get_categories( $args );
		#var_dump($categories);

		if ($categories && false) {
			foreach ($categories as $cat ) {
				
				$term_id = $cat->term_id;

				//Get Taxonomy Metas
				$select_package_type = get_tax_meta($term_id, $package_slug.'_select_package_type');
				$image_package_preview = get_tax_meta($term_id, $package_slug.'_image_package_preview');
				$image_package_details = get_tax_meta($term_id, $package_slug.'_image_package_details');
				
				if (($mode == 'all') || ($mode != 'all' && $select_package_type == $mode)) {
					
					// Create new object
					$array[$term_id] = new stdClass();
					$array[$term_id] = $cat;
					
					$array[$term_id]->select_package_type = $select_package_type;
					$array[$term_id]->image_package_preview = $image_package_preview;
					$array[$term_id]->image_package_details = $image_package_details;
				
				}
			}
		}
		
		return $categories;
	}
	
	
	/**
	 * Get fields definitions
	 * 
	 * name:			get_fields
	 * @since     1.0.0
	 * 
	 * @param 		mixed string|bool 	$module			Optional. Module name.
	 * @return		array 													Fields definitions.
	 * 
	 */
	public function get_fields($module=false) {
		
		// Set only the specified module fields.
		if (!empty($module) && array_key_exists($module, $this->modules)) {
			
			return $this->fields[$module];
			
		} else {
			
			// Return all modules fields.
			return $this->fields;
		}
	}
	
	
	/**
	 * Get field definition
	 * 
	 * name: get_field
	 * @since     1.0.0
	 * 
	 * @param 		string 	$module	Module name.
	 * @param 		string 	$field Field name.
	 * @param 		string 	$mode Optional. Return field name. Default to "false".
	 * @return		mixed array|string|bool Field definition.
	 * 
	 */
	public function get_field($module, $field, $return_name=false) {
		
		// Set only the specified module fields.
		if (!empty($module) && array_key_exists($module, $this->modules)) {
			
			if (!empty($field) && array_key_exists($field, $this->fields[$module])) {
				
				if ($return_name) return $field;
				return $this->fields[$module][$field];
			}
		}
		
		return false;
	}
	
	
	/**
	 * Get fields mappings
	 * 
	 * name: get_fields_mapping
	 * @since 1.0.0
	 * 
	 * @param string 	$module Optional. Module name.
	 * @return array Fields mappings.
	 * 
	 */
	public function get_fields_mapping($module=false) {
		
		// Set only the specified module fields mapping.
		if (!empty($module) && array_key_exists($module, $this->modules)) {
			
			return $this->fields_mapping[$module];
			
		} else {
			
			// Return all modules fields mapping.
			return $this->fields_mapping;
		}
	}
	
	
	/**
	 * Get show fields in general
	 * 
	 * name: get_show_fields
	 * @since 1.0.0
	 * 
	 * @param string $module Optional. Module name.
	 * @return array Show fields.
	 * 
	 */
	public function get_show_fields($module=false) {
		
		// Set only the specified module show fields.
		if (!empty($module) && array_key_exists($module, $this->modules)) {
			
			return $this->show_fields[$module];
			
		} else {
			
			// Return all show fields.
			return $this->show_fields;
		}
	}
	
	
	/**
	 * Get show fields for list views
	 * 
	 * name:			get_show_fields_list_view
	 * @since     1.0.0
	 * 
	 * @param 		string 	$module					Optional. Module name.
	 * @return		array										Show fields for lists views.
	 * 
	 */
	public function get_show_fields_list_view($module=false) {
		
		// Set only the specified module show fields.
		if (!empty($module) && array_key_exists($module, $this->modules)) {
			
			return $this->show_fields_list_view[$module];
			
		} else {
			
			// Return all show fields.
			return $this->show_fields_list_view;
		}
	}
	
	
	/**
	 * Get actual request params
	 * 
	 * name:			get_request
	 * @since     1.0.0
	 * 
	 * @param 		string 	$param					Optional. Param name.
	 * @return		mixed string|array			Request array or param.
	 * 
	 */
	public function get_request($param = '') {
		
		$return = null;
		
		if (!empty($param) && array_key_exists($param, $this->request)) {
			
			$return = $this->request[$param];
			
		} else {
			
			$return = $this->request;
		}
		
		return $return;
	}
	
	
	/**
	 * Get actual request params URL
	 * 
	 * name:			get_request_url
	 * @since     1.0.0
	 * 
	 * @param 		string 	$part					Optional. Part name.
	 * @return		string								Request url or url part.
	 * 
	 */
	public function get_request_url($part = '') {
		
		$module_part = $module_part = $action_part = $item_part = $order_part = $group_part = '';
		
		// Get component request parameters.
		if (empty($part) || (!empty($part) && 'component' == $part)) {
			$module_part = !empty($this->request['module']) ? '&module='.$this->request['module']: '';
			$action_part = !empty($this->request['action']) ? '&action='.$this->request['action']: '';
			$item_part = !empty($this->request['item']) ? '&item='.$this->request['item']: '';
		}
		
		// Get sorting request parameters.
		if (empty($part) || (!empty($part) && 'component' == $part)) {
			$group_part = $this->request['group'] == 1 ? '&group='.$this->request['group']: '';
			$orderby_part = !empty($this->request['orderby']) && in_array($this->request['orderby'], $this->orderby_args) ? '&orderby='.$this->request['orderby']: '';
			$order_part = !empty($this->request['order']) && in_array($this->request['order'], $this->order_args) ? '&order='.$this->request['order']: '';
		}
		
		// Build URL.
		$url = '';
		$url .= 'admin.php?page='.$this->plugin_name;
		$url .= $module_part.$action_part.$item_part;
		$url .= $order_part.$group_part;
		
		if (empty($part)) {
			$url = admin_url($url);
		}
		
		return $url;
	}
	
	
	/**
	 * Get the terms list for a given taxonomy
	 * 
	 * name:			get_the_terms_list
	 * @since     1.0.0
	 * 
	 * @param 		string 	$post_id			Post ID.
	 * @param 		string 	$taxonomy			Taxonomy name.
	 * @param 		string 	$field				Optional. Return part. Default "name".
	 * @return		string								Request url or url part.
	 * 
	 */
	public function get_the_terms_list($post_id, $taxonomy, $field='name') {
		
		$terms_list = array();
		$terms_list_obj = get_the_terms($post_id, $taxonomy);
		
		foreach ($terms_list_obj as $term) {
			
			switch ($field) {
				
				case 'term_id':
					$terms_list[] = $term->term_id;
				break;
				case 'slug':
					$terms_list[] = $term->slug;
				break;
				case 'term_group':
					$terms_list[] = $term->term_group;
				break;
				case 'term_order':
					$terms_list[] = $term->term_order;
				break;
				case 'term_taxonomy_id':
					$terms_list[] = $term->term_taxonomy_id;
				break;
				case 'taxonomy':
					$terms_list[] = $term->taxonomy;
				break;
				case 'description':
					$terms_list[] = $term->description;
				break;
				//case 'parent':
				//	$terms_list[] = $term->parent;
				//break;
				case 'count':
					$terms_list[] = $term->count;
				break;
				case 'object_id':
					$terms_list[] = $term->object_id;
				break;
				default:
					$terms_list[] = $term->name;
			}
			
		}
		
		return $terms_list;
	}
	
	
	/**
	 * Get the terms list for a given taxonomy
	 * 
	 * name:			get_terms
	 * @since     1.0.0
	 * 
	 * @param 		array 	$taxonomies		Taxonomies array list.
	 * @param 		array 	$args					Optional. Args list.
	 * @return		array									List of terms.
	 * 
	 */
	public function get_terms($taxonomies, $args=array()) {

		$default_args = array(
				// WP args.
				'orderby'           => 'name', 
				'order'             => 'ASC',
				'hide_empty'        => true, 
				'exclude'           => array(), 
				'exclude_tree'      => array(), 
				'include'           => array(),
				'number'            => '', 
				'fields'            => 'all', 
				'slug'              => '',
				'parent'            => '',
				'hierarchical'      => true, 
				'child_of'          => 0,
				'childless'         => false,
				'get'               => '', 
				'name__like'        => '',
				'description__like' => '',
				'pad_counts'        => false, 
				'offset'            => '', 
				'search'            => '', 
				'cache_domain'      => 'core',
				// Special kjm args.
				'group_metas'      => true,
		);
		
		$args = array_merge($default_args, $args);

		$terms = get_terms($taxonomies, $args);
		
		foreach ($terms as $key => $term) {
			
			$fields = get_tax_meta_all($term->term_id);
			
			if (empty($fields)) continue;
			
			if ($args['group_metas']) $terms[$key]->metas = array();
			
			foreach ($fields as $field => $value) {
				
				if ($args['group_metas']) $terms[$key]->metas[$field] = $value;
				else $terms[$key]->$field = $value;
			}
		}
				
		return $terms;
	}
	
	
	/*
	 * Get posts IDs by meta key and value
	 * 
	 * name: 			get_posts_by_meta
	 * @since     1.0.0
	 * 
	 * @param 		string 	$meta_key			Post metas meta key name.
	 * @param 		mixed 	$meta_value		Post metas meta key value.
	 * @param 		string 	$post_type		Optional. Post type. Default "all".
	 * @return 		array									Posts IDs list.
	 * 
	 */
	public function get_posts_by_meta($meta_key, $meta_value, $post_type='all') {	
		
		global $wpdb;
		
		// Get post_id of client with contact_id number.
		$query = $wpdb->prepare(
			"
				SELECT post_id 
				FROM $wpdb->postmeta a 
				JOIN $wpdb->posts b ON a.post_id = b.ID 
				AND b.post_type = %s 
				WHERE a.meta_key = %s 
				AND  a.meta_value = %s 
				GROUP BY a.post_id 
			", 
			$post_type, 
			$meta_key,
			$meta_value
		);
		$post_ids = $wpdb->get_results($query);
		//var_dump($query, $post_id);
		return $post_ids;
	}
	
	
	/*
	 * Get Kjm post ID by module ID.
	 * 
	 * name: 			get_kjm_post_id_by_module_id
	 * @since     1.0.0
	 * 
	 */
	public function get_kjm_post_id_by_module_id($module_name, $item_id, $field_name='') {}
	
	
	/*
	 * Insert a custom post item object
	 * 
	 * name: 			insert_post
	 * @since     1.0.0
	 * 
	 * @param 		mixed 	$post_object		Prepared post item object.
	 * @return 		int											New post ID.
	 * 
	 */
	public function insert_post($post_object) {
		
		$post_id = !empty($post_object->ID) ? $post_object->ID: '';
		$post_type = $post_object->post_type;
		$post_title = wp_strip_all_tags($post_object->post_title);
		$post_content = $post_object->post_content;
		$post_status = !empty($post_object->post_status) ? $post_object->post_status: 'publish';
		$post_author = !empty($post_object->post_author) ? $post_object->post_author: 1;
		$post_metas =  !empty($post_object->post_metas) ? $post_object->post_metas: array();
		//$options = !empty($post_object->options) ? $post_object->options: array();
		$taxonomies = !empty($post_object->taxonomies) ? $post_object->taxonomies: array();
		
		// Create post object
		$new_post = array(
			'ID'    => $post_id,
			'post_title'    => $post_title,
			'post_content'  => $post_content,
			'post_status'   => $post_status,
			'post_author'   => $post_author,
			'post_type'	  => $post_type,
		);

		// Insert the post into the database
		$new_post_id = wp_insert_post( $new_post );
		
		// Add other infos to post.
		if ($new_post_id > 0) {
			
			// Add metas infos.
			if (!empty($post_metas)) {
				
				foreach($post_metas as $meta_name => $meta_value) {
					add_post_meta( $new_post_id, $meta_name, $meta_value );
				}
			}
			
			// Add taxonomies.
			if (!empty($taxonomies)) {
				
				foreach($taxonomies as $taxonomy) {
					
					$add_terms = $this->item_import_process_categories($taxonomy->terms);
					$imported = $this->item_import_save_categories($new_post_id, $add_terms, $taxonomy->name);
				}
			}
		}
		
		return $new_post_id;
	}
	
	
	/*
	 * Insert a list of terms to a post
	 * 
	 * name: 			item_import_save_categories
	 * @since     1.0.0
	 * 
	 * @param 		string 	$post_id			Post ID.
	 * @param 		array 	$cat_ids			Categories IDs.
	 * @param 		string 	$taxonomy			Taxonomy name.
	 * @return 		mixed 	bool|array		True on success, taxonomies IDs on failure.
	 * 
	 */
	public function item_import_save_categories($post_id, $cat_ids, $taxonomy) {
		
		// Add categories if no exists.
		
		if (!empty($cat_ids)) {
			
			foreach ($cat_ids as $cat) {
				
				$term = term_exists($cat, $taxonomy);
				
				if (empty($term) && taxonomy_exists($taxonomy)) {
					
					wp_insert_term($cat, $taxonomy);
					
					#$this->debug('STATUS : wp_insert_term done ');
				}
			}
		}
		
		// Add these categories, note the last argument is true.
		$term_taxonomy_ids = wp_set_object_terms( $post_id, $cat_ids, $taxonomy, true );
		
		#$this->debug($term_taxonomy_ids);

		if ( is_wp_error( $term_taxonomy_ids ) ) {
			// There was an error somewhere and the terms couldn't be set.
			return $term_taxonomy_ids;
		} else {
			// Success! These categories were added to the post.
			return true;
		}
	}
	
	
	/*
	 * Load Custom Post Types.
	 * 
	 * name: 			custom_post_types_init
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function custom_post_types_init() {}
	
	
	/*
	 * Load Taxonomies.
	 * 
	 * name: 			custom_taxonomies_init
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function custom_taxonomies_init() {}
	
	
	/*
	 * Add post type column to bulk edit
	 * 
	 * name: 			add_to_bulk_quick_edit_custom_box
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function add_to_bulk_quick_edit_custom_box( $column_name, $post_type ) {}
	
	
	/*
	 * Get column content automatically
	 * 
	 * name: 			get_item_custom_field
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function get_item_custom_field($post_id, $field='') {
		
		if (!empty($field)) {
			
			$custom_fields = get_post_meta($post_id, $field, true);
			$field_value = $custom_fields;
		} else {
			
			$custom_fields = get_post_custom($post_id);
			$field_value = $custom_fields[$field_name][0];
		}
		
		return $field_value;
	}
	
	
	/*
	 * Add new columns heads automatically
	 * 
	 * name: 			columns_head
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function columns_head($defaults) {
		
		// Check the post type.
		if (isset($_GET['post_type'])) {
			
			$post_type = $_GET['post_type'];
			$post_types = $this->get_custom_post_types();
			
			if (array_key_exists($post_type, $post_types)) {
				
				// Get module and list view fields.
				$module = $this->get_module_by_post_type($post_type);
				$show_fields_list_view = $this->get_show_fields_list_view($module);
				
				// Add only the those with good field name.
				if (!empty($show_fields_list_view)) {
					
					$add = array();
					foreach ($show_fields_list_view as $field) {
						$name = $this->get_kjm_meta_field_name($field, $module); // TODO : Remove.
						$add[$name] = $field;
					}
					$defaults = array_merge($defaults, $add);
				}
			}
		}
		
		return $defaults;
	}
	
	
	/*
	 * Render column content automatically
	 * 
	 * name: 			columns_content
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function columns_content($column_name, $post_id) {
		
		// Automatically display custom fields
		$this->custom_field_content($post_id, $column_name);
	}
	
	
	/*
	 * Render custom field column content
	 * 
	 * name: 			custom_field_content
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function custom_field_content($post_id, $column_name) {
		
		// Automatically display custom fields
		$field_value = '';
		
		// Check the post type.
		if (!isset($_GET['post_type'])) return null;
			
		$post_type = $_GET['post_type'];
		$post_types = $this->get_custom_post_types();
		
		if (array_key_exists($post_type, $post_types)) {
			
			// Get module, field name and list view fields.
			$module = $this->get_module_by_post_type($post_type);
			$show_fields_list_view = $this->get_show_fields_list_view($module);
			$meta_key = $this->get_kjm_meta_field_name($column_name, $module);
			
			// Add only the those with good field name.
			if (in_array($meta_key, $show_fields_list_view)) {
				
				$field_value = esc_html($this->get_item_custom_field($post_id, $column_name));
				$field_content = '<span id="'.$post_type.'-'.$post_id.'" class="field_value '.$column_name.' '.$meta_key.'">' . $field_value . '</span>';
				echo apply_filters($this->plugin_name.'_custom_field_content', $field_content, $module, $column_name, $post_id); 
			}
		}
	}
	
	
	/* METABOXES */
	
	
	/*
	 * Automatically create meta boxes to be displayed on the post editor screen.
	 * 
	 * name: 			metaboxes_add
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function metaboxes_add() {}
	
	
	/*
	 * Automatically display the post meta box with custom fields.
	 * 
	 * name: 			metaboxes_display
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function metaboxes_display( $object, $box, $return = false ) {}
	
	
	/*
	 * Automatically save metaboxes content
	 * 
	 * name: 			save_metaboxes
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function save_metaboxes($post_id, $post, $update) {}
	
	
	/*
	 * Automatically bulk edit content
	 * 
	 * name: 			save_bulk_edit
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function save_bulk_edit() {}
	
	
	/*
	 * Automatically display metabox field
	 * 
	 * name: 			metabox_field_display
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function metabox_field_display($object, $box, $meta_name, $meta_value) {}
	
	
	/*
	 * Get a field input
	 * 
	 * name: 			get_field_input
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function get_field_input($field_name, $meta_name, $field_value, $module_name) {
		
		$output = '';
		$fields = $this->get_fields($module_name);
		$params = array('show_headers'	=>	'true');
		
		if (array_key_exists($field_name, $fields)) {
			
			$field_format = $fields[$field_name];
			
			switch($field_format) {
				
				case 'json':
					$output .= $field_value;
				break;
				
				case '%s':
				case '%d':
				default :
				
					$output .= '<input type="text" id="'.$meta_name.'" name="'.$meta_name.'" value="'.$field_value.'" />';
				
			}
		}
		
		return $output;
	}
	
	
	##############################
	### SORTING AND PAGINATION ###
	##############################
	
	
	/*
	 * Get current count
	 * 
	 * name: 			get_current_count
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function get_current_count() {}
	
	
	/*
	 * Get max logs per page
	 * 
	 * name: 			get_max_logs_per_page
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function get_max_logs_per_page() {}
	
	
	/*
	 * Has more page
	 * 
	 * name: 			has_more_page
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function has_more_page() {}
	
	
	/*
	 * Get the pager
	 * 
	 * name: 			pager
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function pager($current_page, $max_page, $amount_per_page = 20, $item_count) {}
	
	
	/*
	 * Sort links
	 * 
	 * name: 			sort_links
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function sort_links() {}
	
	
	/*
	 * Group by link
	 * 
	 * name: 			group_by_link
	 * @since     1.0.0
	 * 
	 * @param
	 * @return
	 * 
	 */
	public function group_by_link() {}
	
	
	#############
	### DEBUG ###
	#############
	
	
	/*
	 * Add variable(s) to debug
	 * 
	 * Add to debug array to further process.
	 * Process and add content to error_log.
	 * 
	 * name: 			debug
	 * @since			1.0.0
	 * 
	 * @param			mixed			Multiple args supported.
	 * @return
	 * 
	 */
	public function debug() {
		
		//error_log($output);
		// call_user_func_array(array($object, 'method_name'), $array);
		//$num_args = func_num_args();
		
		$args = func_get_args();
		foreach($args as $arg) {
			$this->debug[] = $arg;
		}
	}
	
	
	/*
	 * Display debug messages
	 * 
	 * Prints formatted HTML debug messages.
	 * 
	 * name: 			get_debug
	 * @since			1.0.0	
	 * 
	 */
	public function get_debug() {
		
		$ip_whitelist = apply_filters('kjm_debug_ip_whitelist', array(), '');
		$user_ip = $_SERVER['REMOTE_ADDR'];
		
		if (WP_DEBUG === true && in_array($user_ip, $ip_whitelist)) {
			
			foreach($this->debug as $message) {
				echo '<pre>';
				if (is_array($message) || is_object($message)) print_r($message);
				else var_dump($message);
				echo '</pre>';
			}
		}
	}
	
	
	/*
	 * Display debug messages
	 * 
	 * name: 			debug_ip_whitelist
	 * @since			1.0.0
	 * 
	 * @param			array		$ip_addresses			Multiple args supported.
	 * @param			string	$add_address			Multiple args supported.
	 * @return		array											List of whitelisted IP addresses.
	 * 
	 */
	public function debug_ip_whitelist($ip_addresses=array(), $add_address='') {
		
		if (defined('KAJOOM_DEBUG_IP') 
		&& !in_array(KAJOOM_DEBUG_IP, $ip_addresses)) {
			
			$ip_addresses[] = KAJOOM_DEBUG_IP;
		}
		
		if (!empty($add_address) && !in_array($add_address, $ip_addresses)) {
			$ip_addresses = array_merge($ip_addresses, array($add_address));
		}
		
		return $ip_addresses;
	}
	
} // End of Class

endif; // Endif class exists.
