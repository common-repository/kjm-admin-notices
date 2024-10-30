<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.kajoom.ca/
 * @since      1.0.0
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/admin
 */
if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}

if ( ! class_exists( 'Kjm_Admin_Notices_Admin' ) 
&& class_exists( 'Kjm_Plugin_Admin_Base_1_0' ) ) : 

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/admin
 * @author     Marc-Antoine Minville <support@kajoom.ca>
 */
final class Kjm_Admin_Notices_Admin extends Kjm_Plugin_Admin_Base_1_0  {
	
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
	protected $_options_pagename = 'kjm-admin-notices-settings';
	
	
	/**
	 * Plugin update name.
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			string 	$update_name 	Unique update name.
	 */
	protected $update_name = 'Kjm_Admin_Notices/plugin.php';
	
	/**
	 * Error messages to diplay
	 *
	 * @var array
	 */
	private $_messages = array();
	
	protected $_options = array(
		'kjm-admin-notices-selected-types' => array()      
	);
	
	/**
	 * Holds current variables to display as debug info
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$debug 	List of variables to debug.
	 */
	protected $debug = array();
	
	
	/**
	 * Holds admin IPs to whitelist for debug display
	 *
	 * @since		1.0.0
	 * @access	protected
	 * @var			array 	$debug_ips 	List of admin IPs.
	 */
	protected $debug_ips = array();
	
	/**
	 * The Settings menu page of the plugin.
	 *
	 * @since    1.2.0
	 * @access   protected
	 * @var      string    $version    The current menu page of the plugin.
	 */
	protected $menu_page;
	
	
	public $custom_taxonomies = array(
		'kjm_notice_cat'	=>	'notice_cat',
		'kjm_notice_tag'	=>	'notice_tag',
		#'kjm_notice_color'	=>	'notice_color',
	);
	
	/**
	 * List of settings fields definitions
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$settings_fields 	Settings and definitions in an array.
	 */
	public $settings_fields = array(
		
		// Admin Notices
		'kjm-admin-notices_active'	=>	array(
			'parent'	=>	'',
			'type'	=>	'checkbox',
			'default_value'	=>	1,
		),
		'kjm-admin-notices_kjm_notice_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_active',
			'type'	=>	'checkbox',
			'default_value'	=>	1,
		),
		'kjm-admin-notices_comments_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_active',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_allow_role'	=>	array(
			'parent'	=>	'kjm-admin-notices_active',
			'type'	=>	'text',
			'default_value'	=>	"", // Default : "administrator"
		),
		
		// Frontend
		'kjm-admin-notices_allow_frontend'	=>	array(
			'parent'	=>	'',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_frontend_absolute'	=>	array(
			'parent'	=>	'kjm-admin-notices_allow_frontend',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_frontend_layout'	=>	array(
			'parent'	=>	'kjm-admin-notices_allow_frontend',
			'type'	=>	'text',
			'default_value'	=>	"",
		),
		'kjm-admin-notices_show_pages'	=>	array(
			'parent'	=>	'kjm-admin-notices_allow_frontend',
			'type'	=>	'text',
			'default_value'	=>	"",
		),
		'kjm-admin-notices_hide_pages'	=>	array(
			'parent'	=>	'kjm-admin-notices_allow_frontend',
			'type'	=>	'text',
			'default_value'	=>	"",
		),
		
		// Emails
		'kjm-admin-notices_send_email_active'	=>	array(
			'parent'	=>	'',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_from_email_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_send_email_active',
			'type'	=>	'text',
			'default_value'	=>	"",
		),
		'kjm-admin-notices_from_name_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_send_email_active',
			'type'	=>	'text',
			'default_value'	=>	"",
		),
		
		// Stats
		'kjm-admin-notices_enable_stats'	=>	array(
			'parent'	=>	'',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_stats_exclude_superadmin'	=>	array(
			'parent'	=>	'kjm-admin-notices_enable_stats',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_stats_exclude_author'	=>	array(
			'parent'	=>	'kjm-admin-notices_enable_stats',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		
		// Compatibility
		'kjm-admin-notices_advanced'	=>	array(
			'parent'	=>	'',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
		'kjm-admin-notices_plugins_compat'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'heading',
			'default_value'	=>	1,
		),
		'kjm-admin-notices_is_plugin_kjm-search-log_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'custom',
			'default_value'	=>	0,
			'value_callback'	=>	array('Kjm_Admin_Notices_Admin', 'is_plugin_active', array('kjm-search-log/kjm-search-log.php')),
		),
		'kjm-admin-notices_is_plugin_kjm-avia-form-cpt_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'custom',
			'default_value'	=>	0,
			'value_callback'	=>	array('Kjm_Admin_Notices_Admin', 'is_plugin_active', array('kjm-avia-form-cpt/kjm-avia-form-cpt.php')),
		),
		'kjm-admin-notices_is_plugin_kajoom-framework_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'custom',
			'default_value'	=>	0,
			'value_callback'	=>	array('Kjm_Admin_Notices_Admin', 'is_plugin_active', array('kajoom-framework/kajoom-framework.php')),
		),
		'kjm-admin-notices_is_plugin_archived-post-status_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'custom',
			'default_value'	=>	0,
			'value_callback'	=>	array('Kjm_Admin_Notices_Admin', 'is_plugin_active', array('archived-post-status/archived-post-status.php')),
		),
		'kjm-admin-notices_updater'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'heading',
			'default_value'	=>	1,
		),
		'kjm-admin-notices_use_kjm_updater_active'	=>	array(
			'parent'	=>	'kjm-admin-notices_advanced',
			'type'	=>	'checkbox',
			'default_value'	=>	0,
		),
	);
	
	
	/**
	 * List of custom fields definitions
	 *
	 * @since		1.0.2
	 * @access	public
	 * @var			array 	$custom_fields 	Custom fields definitions in an array.
	 */
	public $custom_fields = array(
		'kjm_notice'	=>	array(
			'kjm_admin_notices_show_notice_to',
			'kjm_admin_notices_show_frontend',
			'kjm_admin_notices_send_email',
			'kjm_admin_notices_send_copy_admin',
			'kjm_admin_notices_hide_title',
			'kjm_admin_notices_hide_metas',
			'kjm_admin_notices_hide_dismiss_link',
			'kjm_admin_notices_hide_dismiss_button',
			'kjm_admin_notices_global_params',
			'kjm_admin_notices_custom_color_bg',
			'kjm_admin_notices_custom_color_txt',
		),
	);
	
	
	/**
	 * List of custom fields default values
	 *
	 * @since		1.0.7
	 * @access	public
	 * @var			array 	$custom_fields_defaults 	Custom fields default values in an array.
	 */
	public $custom_fields_defaults = array(
		'kjm_notice'	=>	array(
			'kjm_admin_notices_show_notice_to'	=>	'',
			'kjm_admin_notices_show_frontend'	=>	0,
			'kjm_admin_notices_send_email'	=>	0,
			'kjm_admin_notices_send_copy_admin'	=>	0,
			'kjm_admin_notices_hide_title'	=>	0,
			'kjm_admin_notices_hide_metas'	=>	0,
			'kjm_admin_notices_hide_dismiss_link'	=>	0,
			'kjm_admin_notices_hide_dismiss_button'	=>	0,
			'kjm_admin_notices_global_params'	=>	'',
			'kjm_admin_notices_custom_color_bg'	=>	'',
			'kjm_admin_notices_custom_color_txt'	=>	'',
		),
	);
	
	
	/**
	 * List of messages statuses definitions
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$messages_statuses 	Colors are keys and statuses are values.
	 */
	public	$messages_statuses = array(
		'gray' => 'default',
		'blue' => 'info',
		'green' => 'success',
		'orange' => 'warning',
		'red' => 'error',
	);
	
	
	/**
	 * Required capability to send notices.
	 *
	 * @since		1.0.6
	 * @access	protected
	 * @var			string 	$capability 	Capability or Role.
	 */
	protected $capability = 'administrator';
	

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $shared = null ) {
		
		//$this->seed = 'notices';
		
		// Initialize parent Base Class.
		parent::__construct( $plugin_name, $version, $shared );
		
		$this->_settings_url = 'options-general.php?page=' . $this->plugin_name.'-settings';
		
		// Load default capability.
		$capability = $this->get_option('kjm-admin-notices_allow_role');
		$this->capability = empty($capability) ? $this->capability: $capability;
		$this->shared->set_capability($this->capability);
		
		// Auto-create instance.
		self::$instance = $this;
		
		// Run `kjm_admin_notices_admin_loaded` actions.
		do_action( 'kjm_admin_notices_admin_loaded' );
	}
	
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		
		// Super admin only.
		if( ! is_super_admin() ) {
			return;
		}

		// If the single instance hasn't been set, set it now.
		//if ( null == self::$instance ) {
		//	self::$instance = new self;
		//}

		return self::$instance;
	}
	
	
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
		 * defined in Kjm_Admin_Notices_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kjm_Admin_Notices_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kjm-admin-notices-admin.css', array(), $this->version, 'all' );

		// Colorpicker Styles
		wp_enqueue_style( 'wp-color-picker' );
		
	}
        
    /**
	 * Add inline JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_inline_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Kjm_Admin_Notices_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kjm_Admin_Notices_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */		
		
                global $post;
                if($post){
                    if($post->post_type=='kjm_notice'){
                    ?>                    
                        <script type="text/javascript">                                               
                            jQuery('#publish').click(function () {                                
                                var kjm_atLeastOneIsChecked = false;
                                jQuery('#taxonomy-kjm_notice_cat input:checkbox').each(function () {
                                  if (jQuery(this).is(':checked')) {
                                    kjm_atLeastOneIsChecked = true;
                                    // Stop .each from processing any more items   
                                    return false;
                                  }
                                });                                
                                if(!kjm_atLeastOneIsChecked){
                                    alert('Please check atleast one "Notice Cat"');
                                    return false;
                                }
                            });
                        </script>
                    <?php
                    }   
                }
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
		 * defined in Kjm_Admin_Notices_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kjm_Admin_Notices_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		//wp_enqueue_script('jquery-ui-core');
		//wp_enqueue_script('jquery-ui-sortable');
		$params  = array();
		
		$plugin = 'archived-post-status/archived-post-status.php';
		
		if ( ! $this->is_plugin_active($plugin) ) {
				
			// Archived status.
			$params  = array(
				'archive'       => __( 'Archive', 'kjm-admin-notices' ),
				'saveArchive' => __( 'Save and keep Archived', 'kjm-admin-notices' ),
			);
			
			__( 'Archived Post Status', 'kjm-admin-notices' );
			__( 'Allows posts and pages to be archived so you can unpublish content without having to trash it.', 'kjm-admin-notices' );
			
			#$this->debug($hook);

			if ($this->is_package_admin_page()) {
				
				if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
					global $post;

					$params['screen']     = 'single';
					$params['postStatus'] = $post->post_status;
				}

				if ( 'edit.php' === $hook ) {
					$params['screen'] = 'list';
				}
			}
		}
		
		// Get sent var.
		if ($this->is_package_admin_page() && 'post.php' === $hook) {
			$params['sent'] = get_post_meta($post->ID, 'kjm-admin-notice-sent', true);
		}
		
		$params['ajax_nonce'] = wp_create_nonce('kjm_admin_notices_ajax');
		
		wp_enqueue_script( $this->plugin_name.'-admin-scripts', plugin_dir_url( __FILE__ ) . 'js/kjm-admin-notices-admin.js', array( 'jquery','wp-color-picker' ), $this->version, false );
		wp_localize_script( $this->plugin_name.'-admin-scripts', 'kjm_admin_notices_admin', $params );
		
		#wp_enqueue_script( $this->plugin_name.'-scripts-jscolor', '//cdnjs.cloudflare.com/ajax/libs/jscolor/2.0.4/jscolor.js', array( 'jquery' ), $this->version, false );
		
		// Colorpicker Scripts
		wp_enqueue_script( 'wp-color-picker' );

	}
	
	
	public function set_settings_fields() {
		
		$this->settings_fields = apply_filters($this->plugin_name.'_set_settings_fields', $this->settings_fields);
	}
	
	
	public function request_controller() {
		
		//$allowed_options =$this->options;
		//$allowed_values = get_post_types(array(), "names");
		
		/*
		if(array_key_exists('option_name', $_GET) && array_key_exists('option_value', $_GET)
		&& array_key_exists($_GET['option_name'], $allowed_options)) {
			
			update_option($_GET['option_name'], $_GET['option_value']);
			
			header("Location: " . $this->_settings_url);
			die();	
		
		}
		*/
		
		// REQUEST.
		if (isset($_REQUEST['saved'])) {
			
			if ($_REQUEST['saved'] == '1') {
				
				$this->message = '<div id="message" class="updated fade"><p><strong>'.__("KJM Admin Notices settings saved.", "kjm-admin-notices").'</strong></p></div>';
			} else {
				
				$this->message = '<div id="message" class="updated fade"><p><strong>'.__("KJM Admin Notices settings saving failed!.", "kjm-admin-notices").'</strong></p></div>';
			}
		}
		
		// POST REQUEST.
		if (isset($_POST['kjm_admin_notices_settings_saved'])) {
			
			$this->_save_settings_todb($_POST);
			wp_redirect( admin_url('options-general.php?page=kjm-admin-notices-settings&saved=1') ); exit;
		}
		
	}
	
	
	/*
	 * Save settings to options table
	 * 
	 * name: 			_save_settings_todb
	 * @since     1.0.0
	 * 
	 * @param 		array $form_settings		Form settings array.
	 * @return
	 * 
	 */
	public function _save_settings_todb($form_settings = '') {
	
		if (!wp_verify_nonce($_REQUEST['_wpnonce'], $this->_options_pagename)) 
				wp_die(	__('Failed security check on KJM Admin Notices Settings save action.', 'kjm-admin-notices'), 
								__('Failed security check!', 'kjm-admin-notices'), 
								'back_link=true');
	
		if ( $form_settings <> '' ) {
			
				unset($form_settings['kjm_admin_notices_settings_saved']);
				$this->_settings = $form_settings;

				#set standart values in case we have empty fields
				$this->_set_standart_values();
		}
		
		update_option('kjm_admin_notices_settings', $this->_settings);
	}
	
	
	/**
	 * Add plugin admin settings page link
	 *
	 * @since    1.0.0
	 * 
	 */
	public function add_settings_link($links) {
		
		$settings = '<a href="'.admin_url('options-general.php?page='.$this->plugin_name.'-settings').'">' . __('Settings', 'kjm-admin-notices') . '</a>';
		array_unshift( $links, $settings );
		return $links;
	}
	
	
	/**
	 * Add links on installed plugin list
	 */
	public function add_plugin_links($links, $file) {
		
		return $links;
	}
	
	
	/**
	 * Add menu entry 
	 */
	public function add_menu_page() {
		
		// add option in admin menu, for setting options
		$page_name = __('KJM Admin Notices', 'kjm-admin-notices');
		$this->menu_page = add_options_page($page_name, $page_name, 'update_core', $this->plugin_name.'-settings', array($this, 'page_admin_settings'));
		add_submenu_page('edit.php?post_type=kjm_notice', 'KJM Admin Notices Settings', __('Global Settings', 'kjm-admin-notices'), 'update_core', 'options-general.php?page='.$this->plugin_name.'-settings' );
	}
	
	
	/**
	 * Include the plugin admin settings template page file
	 *
	 * @since    1.0.0
	 * 
	 */
	public function page_admin_settings() {
			
			require KJM_ADMIN_NOTICES_PLUGIN_PATH . 'admin/partials/kjm-admin-notices-admin-settings-display.php';
	}
	
	
	/**
	 * Include and get plugin settings strings file
	 *
	 * @since    1.0.0
	 * 
	 */
	public function get_settings_fields_strings() {
		
		$strings = null;
		$path = KJM_ADMIN_NOTICES_PLUGIN_PATH . 'includes/models/strings-settings.php';
		require($path);

		return $strings;
	}
	
	
	public function get_custom_post_types() {
		
		return $this->shared->get_custom_post_types();
	}
	
	
	public function remove_menu_items() {
		
		foreach($this->get_custom_post_types() as $post_type => $seed) {
			if( !current_user_can( $this->capability ) ):
					remove_menu_page( 'edit.php?post_type='.$post_type );
			endif;
		}
	}
	
	
	/* Load Custom Post Types. */

	public function custom_post_types_init() {
		
		// Return early if plugin is not activated.
		if ($this->_settings[$this->plugin_name.'_active'] != 1) return;
		
		foreach($this->get_custom_post_types() as $post_type => $seed) {
			
			// Skip if CPT is not activated.
			if ($this->_settings[$this->plugin_name.'_'.$post_type.'_active'] != 1) continue;
			
			$args = array(); // Should be redefined in the model file.
			$path = KJM_ADMIN_NOTICES_PLUGIN_PATH . 'includes/models/post-type-'.$post_type.'.php';
			if (file_exists($path)) {
				
				require($path);
				$args = apply_filters('kjm_admin_notices_post_type_init', $args, $post_type);
				register_post_type($post_type, $args);
			}
		}
	}
	
	
	public function custom_post_type_init_filter($args, $post_type) {
		
		if ('kjm_notice' === $post_type) {
			if (1 == $this->get_option('kjm-admin-notices_comments_active')) {
				array_push($args['supports'], 'comments');
				$args['supports'] = array_unique($args['supports']);
			}
			$args['capabilities'] = array(
				'publish_posts'       => $this->capability,
				'edit_others_posts'   => $this->capability,
				'delete_posts'        => $this->capability,
				'delete_others_posts' => $this->capability,
				'read_private_posts'  => $this->capability,
				'edit_post'           => $this->capability,
				'delete_post'         => $this->capability,
				'read_post'           => $this->capability,
			);
		}
		
		return $args;
	}
	
	
	/* Load Taxonomies. */
	public function custom_taxonomies_init() {

		// Return early if plugin is not activated.
		if ($this->_settings[$this->plugin_name.'_active'] != 1) return;
		
		foreach($this->custom_taxonomies as $taxonomy => $seed) {
			
			$args = array(); // Should be redefined in the model file.
			$path = KJM_ADMIN_NOTICES_PLUGIN_PATH . 'includes/models/taxonomy-'.$taxonomy.'.php';
			
			if (file_exists($path)) {
				require($path);
				register_taxonomy($taxonomy, $post_types, $args);
			}
		}
	}
	
	// See : http://www.geekpress.fr/recuperer-liste-roles-wordpress/
	public function get_roles($translated=true) {

			$wp_roles = new WP_Roles(); 
			$roles = $wp_roles->get_names();
			if (true === $translated) $roles = array_map( 'translate_user_role', $roles );

			return $roles;
	}
	
	
	// See : https://daveismyname.com/comparing-multiple-values-against-in-array-bp
	public function array_val_in_array($needle, $haystack) 
	{
			
			foreach ($needle as $stack) {
					if (in_array($stack, $haystack)) {
						return true;
					}
			}
			return false;
	}
	
	
	/* Admin notices */
	public function show_admin_notice(){
		
		global $current_user;
		
		$user_id = $current_user->ID;
		
		if (!current_user_can( 'read' )) return false;
		
		/* Dismiss notice for current user. */
		#if(isset($_REQUEST['kjm_normal_notice_ignore']) == '1'){
			#$this->kjm_dismiss_notice('normal');
		#}
		
		$args = array(
			'post_type' => 'kjm_notice', 
			'post_status' => array('publish', 'private'), 
			'taxonomy' => 'kjm_notice_cat',
		);
		$notices = $this->get_items($args, 'all');
		
		foreach ($notices as $notice_id => $notice) {
			
			$show_to_roles = get_post_meta($notice_id, "kjm_admin_notices_show_notice_to", true);
			$hide_dismiss_link = get_post_meta($notice_id,'kjm_admin_notices_hide_dismiss_link',true);
			$hide_dismiss_button = get_post_meta($notice_id,'kjm_admin_notices_hide_dismiss_button',true);
			$custom_color_bg = get_post_meta($notice_id,'kjm_admin_notices_custom_color_bg',true);
			$custom_color_txt = get_post_meta($notice_id,'kjm_admin_notices_custom_color_txt',true);

			$notice_catid = get_the_terms( $notice_id, 'kjm_notice_cat' );
			$custom_cat_color_border = get_term_meta($notice_catid[0]->term_id,'kjm_notice_cat_color',true);
			
			$dismiss_class = $hide_dismiss_button && $hide_dismiss_link ? 'not-dismissible': 'is-dismissible';
			$dismiss_class .= $hide_dismiss_button ? ' hide-dismiss-button': '';
			
			$kjm_custom_css='style="';
			if ($custom_color_bg) $kjm_custom_css.='background:#'.$custom_color_bg.' !important;';
			if ($custom_color_txt) $kjm_custom_css.='color:#'.$custom_color_txt.' !important; border-left:4px solid #'.$custom_cat_color_border.'';
			$kjm_custom_css.='"';
                        
			$show_to_roles = is_array($show_to_roles) ? $show_to_roles: array($show_to_roles);
			
			$filters_params = array(
				'ID' => $notice_id,
				'user_id' => $user_id,
				'user_roles' => $current_user->roles,
				'show_to_roles' => $show_to_roles,
			);
			
			/* Check that the user hasn't already clicked to ignore the message */
			if ( ! get_user_meta($user_id, 'kjm_'.$notice_id.'_notice_ignore') 
			/* Check that the user role is in roles targeted. */
			&& ($this->array_val_in_array($current_user->roles, $show_to_roles) 
			/* If show to "all" roles, display it. */
			|| in_array('all', $show_to_roles))) {
				
				// Allow to modify behavior with a filter.
				if ( ! apply_filters('kjm_admin_notices_admin_notice_show', true, $filters_params) ) return;
				
				// Update views count.
				$this->shared->update_views_count($notice_id, array('type' => 'admin'));
				
				$output = $this->shared->format_notice_content($notice_id, $notice, $current_user);
				
				// Allow to customize notice content via filters.
				$output = apply_filters('kjm_admin_notices_admin_notice_content', $output, array('ID'=>$notice_id, 'post'=>$notice, 'current_user'=>$current_user));
				
				$notice_cat = !empty($notice['taxonomies']['kjm_notice_cat'][0]) ? $notice['taxonomies']['kjm_notice_cat'][0]: 'success';
				
				echo '<div class="notice notice-'.$notice_cat.' '.$dismiss_class.' kjm-admin-notice" '.$kjm_custom_css.' id="kjm-admin-notices-message-'.$notice_id.'" data-notice-id="'.$notice_id.'"><p>';
				printf(__('%1$s'), $output);
				
				echo '</p>';
				if (empty($hide_dismiss_link)) echo '<button type="button" class="notice-dismiss kjm-notice-dismiss">'.__('Thanks, Got it.', 'kjm-admin-notices').'</button>';
				echo '</div>';
			}
			
		}
		
	}
	

	/* Accepted notices values. */
	public function kjm_notices_accept_values() {
		
		return array("default", "success", "info", "warning", "error");
	}
	

	/* Accepted notices values. */
	public function kjm_get_notice_dismiss_string($notice_id) {
		
		return 'kjm_'.(int) $notice_id.'_notice_ignore';
	}


	/* Create default categories */
	public function create_default_categories() {
		
		if (!current_user_can( $this->capability )) return false;
		
		foreach ($this->kjm_notices_accept_values() as $term) {
			
			$term_exists = term_exists($term, 'kjm_notice_cat');
			
			if (empty($term_exists)) wp_insert_term($term, 'kjm_notice_cat');
		}
	}


	/**
	 * Dismiss an admin notice through ajax.
	 */
	public function kjm_dismiss_notice_ajax(){
			
			if(!isset($_REQUEST['notice']))
					die('Notice ID expected as "notice" parameter.');
			
			check_ajax_referer('kjm_admin_notices_ajax', '_wpnonce');
			
			$this->kjm_dismiss_notice($_REQUEST['notice']);
	}

	/**
	 * Dismiss an admin notice.
	 */
	protected function kjm_dismiss_notice($notice) {
		
		if (!current_user_can( 'read' )) return;
		
		global $current_user;
		
		$user_id = $current_user->ID;
		//if (!in_array($notice, $this->kjm_notices_accept_values())) return false;
		$meta_key = $this->kjm_get_notice_dismiss_string($notice);
		update_user_meta($user_id, $meta_key, 'on');
	}
	
	
	public function trigger_on_update_post( $post_id, $post ) {
		
		if (array_key_exists($post->post_type, $this->get_custom_post_types())
		&& current_user_can( $this->capability )) {
			$return = $this->kjm_dismiss_notice_reset($post_id);
			
			if ($this->_settings[$this->plugin_name.'_send_email_active'] == 1) {
				$this->shared->send_email_notice($post_id);
			}
		}
		
	}


	/**
	 * Dismissed admin notices reset.
	 */
	public function kjm_dismiss_notice_reset($notice) {
		
		global $wpdb;
		
		/* Minimal security check... */
		//if (!in_array($notice, $this->kjm_notices_accept_values())) return false;
		if (!current_user_can( $this->capability )) return false;
		
		$meta_key = $this->kjm_get_notice_dismiss_string((int) $notice);
		
		$wpdb->query( 
				$wpdb->prepare( 
						"
						DELETE FROM $wpdb->usermeta
						WHERE meta_key = %s
						",
						$meta_key
						)
		);
		
		return true;
	}
	
	
		#####################
		#### ADMIN VIEWS ####
		#####################


		// Add new column
		public function columns_head($defaults) {
			
			$custom_fields = array(
				'kjm-admin-notice-sent' => __('Stats', 'kjm-admin-notices'),
				#'kjm-admin-notice-sent-to' => __('Sent To', 'kjm-admin-notices'),
				#'kjm-admin-notice-sent-time' => __('Sent Time', 'kjm-admin-notices'),
			);
			$defaults = array_merge($defaults, $custom_fields);
			#$defaults = $this->custom_columns_remove($defaults);
			
			return $defaults;
		}
		
		
		// Render column content
		public function columns_content($column_name, $post_ID) {
			
			//global $wpdb;
			
			if ($column_name == 'kjm-admin-notice-sent') {
				
				$this->columns_content_sent($post_ID);
				$this->columns_content_stats($post_ID);
			}
			if ($column_name == 'kjm-admin-notice-sent-email') { // fake placeholder name.
				
				$this->columns_content_sent($post_ID);
			}
			if ($column_name == 'kjm-admin-notice-stats') {
				
				$this->columns_content_stats($post_ID);
			}
		}
		
		// Render column content : sent
		public function columns_content_sent($post_ID) {
		
			$sent = get_post_meta($post_ID, 'kjm-admin-notice-sent');
			$sent = empty($sent[0]) ? 'no': 'yes';
			$status = $sent === 'no' ? 'closed': 'open';
			
			// Sent tag.
			if ($sent === 'yes') {
				$sent_time = get_post_meta($post_ID, 'kjm-admin-notice-sent-time');
				$sent_time = empty($sent_time[0]) ? '': $sent_time[0];
								
				$sent_to = get_post_meta($post_ID, 'kjm-admin-notice-sent-to');
				$sent_to_count = count((array) $sent_to[0]);
				$sent_to = empty($sent_to[0]) ? ' - ': implode(', ', $sent_to[0]);
				
				echo '<span class="status_tag '.$status.'" title="'.esc_attr($sent_time . ' : ' . $sent_to).'">'.__('Sent to', 'kjm-admin-notices').' '.$sent_to_count.' '.__('adresse(s).', 'kjm-admin-notices').' </span>';
				#echo '<span class="'.$sent_time.'">' . $sent_time . '</span>';
			} else {
				
				echo '<span class="">' . __('Not sent', 'kjm-admin-notices') . '</span>';
			}
		}
		
		// Render column content : stats
		public function columns_content_stats($post_ID) {
			
			// Stats.
			$dissmissed_count = $this->dissmissed_count($post_ID);
			
			// Total views count.
			#$meta_key = 'kjm-admin-notice-views-count';
			#$total_views_count = (int) get_post_meta($post_ID, $meta_key, true);
			$total_views_count = $this->shared->get_notice_views_count($post_ID);
			
			// Total users count.
			#$users_count = $this->users_count($post_ID);
			$users_count = $this->shared->get_notice_users_count($post_ID);
			
			if (!empty($dissmissed_count) || !empty($total_views_count) || !empty($users_count)) {
			
				$html = '<br><span class="dissmissed-count">' . $dissmissed_count . ' ' .__('dissmissed', 'kjm-admin-notices') . '</span>';
				$html .= '<span class="total-views-count"> (' . $total_views_count . ' ' .__('total views', 'kjm-admin-notices') . ' ' . __('from', 'kjm-admin-notices') . ' ' . $users_count . ' users)</span>';
				
				echo '<br><span class="notice-stats" title="'.strip_tags($html).'">'
				.$total_views_count . ' ' .__('views', 'kjm-admin-notices').
				'</span>';
			}
		}
		
		/**
		 * Dismissed admin notices count.
		 */
		public function dissmissed_count($notice_ID) {
			
			$dissmissed_count = 0;
			global $wpdb;
			
			/* Minimal security check... */
			//if (!in_array($notice, $this->kjm_notices_accept_values())) return false;
			#if (!current_user_can( $this->capability )) return false;
			
			$meta_key = $this->kjm_get_notice_dismiss_string((int) $notice_ID);
			$request = "
			SELECT meta_value, user_id FROM $wpdb->usermeta
			WHERE meta_key = %s
			";
			
			$result = $wpdb->query( 
					$wpdb->prepare( 
							$request,
							$meta_key
							)
			);
			$dissmissed_count = $wpdb->get_var('SELECT FOUND_ROWS()');
			#$dissmissed_count = empty($result) ? 0 : count($result);
			
			return $dissmissed_count;
		}
		
		/**
		 * Distinct users count.
		 */
		public function users_count($notice_ID) {
			
			$users_count = 0;
			global $wpdb;
			
			/* Minimal security check... */
			//if (!in_array($notice, $this->kjm_notices_accept_values())) return false;
			#if (!current_user_can( $this->capability )) return false;
			
			$meta_key = 'kjm_'.(int) $notice_ID.'_notice_views';
			
			$request = "
			SELECT DISTINCT(user_id) FROM $wpdb->usermeta
			WHERE meta_key = %s
			";
			
			$result = $wpdb->query( 
					$wpdb->prepare( 
							$request,
							$meta_key
							)
			);
			$users_count = $wpdb->get_var('SELECT FOUND_ROWS()');
			
			return $users_count;
		}
		
		// resize columns in post listing screen
		public function columns_resize() {
			
			if (true) {
			?>
			<style>
				.edit-php .fixed .column-taxonomy-kjm_notice_cat,
				.edit-php .fixed .column-taxonomy-kjm_notice_tag,
				.edit-php .fixed .column-date {
					width: 15%;
				}
				.edit-php .fixed .column-kjm-admin-notice-sent {
					width: 10%;
				}
			</style>
			<?php 
			}
		}
		
		
		
		/* METABOXES */


		/* Meta box setup function. */
		public function metaboxes_setup() {

			/* Add meta boxes on the 'add_meta_boxes' hook. */
			add_action( 'add_meta_boxes', array($this, 'metaboxes_add'));
		}
		
		
		/* Create one or more meta boxes to be displayed on the post editor screen. */
		public function metaboxes_add() {
			if (is_admin()) {
				
					add_meta_box(
						'kjm_admin_notices_show_notice_to',      // Unique ID
						esc_html__( 'Show Notice To Roles', 'kjm-admin-notices' ),    // Title
						array($this, 'metaboxes_display'),   // Callback function
						'kjm_notice',         // Admin page (or post type)
						'normal',         // Context : side or normal
						'default'         // Priority
					);
				
				if ($this->get_option('kjm-admin-notices_send_email_active') != 0) {
					add_meta_box(
						'kjm_admin_notices_send_email',      // Unique ID
						esc_html__( 'Send Email', 'kjm-admin-notices' ),    // Title
						array($this, 'metaboxes_display'),   // Callback function
						'kjm_notice',         // Admin page (or post type)
						'normal',         // Context
						'default'         // Priority
					);
				}
				
					add_meta_box(
						'kjm_admin_notices_display',      // Unique ID
						esc_html__( 'Notice Display', 'kjm-admin-notices' ),    // Title
						array($this, 'metaboxes_display'),   // Callback function
						'kjm_notice',         // Admin page (or post type)
						'normal',         // Context
						'default'         // Priority
					);
				
					add_meta_box(
						'kjm_admin_notices_global_params',      // Unique ID
						esc_html__( 'Global Params', 'kjm-admin-notices' ),    // Title
						array($this, 'metaboxes_display'),   // Callback function
						'kjm_notice',         // Admin page (or post type)
						'normal',         // Context : side or normal
						'default'         // Priority
					);
					/*
          add_meta_box(
						'kjm_admin_notices_custom_color_bg',      // Unique ID
						esc_html__( 'Custom Css', 'kjm-admin-notices' ),    // Title
						array($this, 'metaboxes_display'),   // Callback function
						'kjm_notice',         // Admin page (or post type)
						'normal',         // Context : side or normal
						'default'         // Priority
					); */
				if (defined('KJM_ADMIN_NOTICES_DEBUG') && true === KJM_ADMIN_NOTICES_DEBUG) {
					
					add_meta_box(
						'kjm_admin_notices_debug',      // Unique ID
						esc_html__( 'Debug', 'kjm-admin-notices' ),    // Title
						array($this, 'metaboxes_display'),   // Callback function
						'kjm_notice',         // Admin page (or post type)
						'normal',         // Context : side or normal
						'default'         // Priority
					);
				}
			}
		}
		
		
		public function kjm_table_array_display($object, $field, $params=array()) {
			
				$output = '';
				
				$post_meta = get_post_meta($object->ID, $field, true);
				
				$translate_titles = isset($params['translate_titles']) ? $params['translate_titles']: false;
				
				if (is_array($post_meta)) {
					
					$output .= '<table style="width: 100%;">';
					foreach($post_meta as $name => $data) {
						$data = is_array($data) ? implode(', ', $data): $data;
						$name_i18n = $translate_titles ? __($name, 'kjm-admin-notices'): $name;
						$output .= '<tr><th style="width: 20%; text-align: left;">'.$name_i18n.'</th><td>'.strip_tags(urldecode($data)).'</td></tr>';
					}
					$output .= '</table>';
				}
				echo $output;
		}
		
		
		/* Display the post meta box. */
		public function metaboxes_display( $object, $box, $return = false ) { 
			
			//wp_nonce_field( basename( __FILE__ ), 'kjm_admin_notices_nonce' ); 
			
			if ($box['id'] == 'kjm_admin_notices_show_notice_to') {
				
				$available_roles = array_merge(array('all' => __('All', 'kjm-admin-notices')), $this->get_roles());
				$show_to_roles = get_post_meta($object->ID,'kjm_admin_notices_show_notice_to',true);
				$count_users = count_users();
				$sent = get_post_meta($object->ID,'kjm-admin-notice-sent',true);
				$disabled = empty($sent) ? '': ' disabled=""';
				
				if (!empty($show_to_roles)) { 
					$show_to_roles = !is_array($show_to_roles) ? array($show_to_roles): $show_to_roles;
					$all_roles = array_unique(array_merge(array_keys($available_roles), array_values($show_to_roles)));
				} else {
					$show_to_roles = array();
					$all_roles = array_keys($available_roles);
				}
				
				echo '<ul>';
				foreach($all_roles as $role) {
					$count = isset($count_users['avail_roles'][$role]) ? $count_users['avail_roles'][$role]: 0;
					$count = 'all' === $role ? $count_users['total_users']: $count;
					$name = isset($available_roles[$role]) ? $available_roles[$role]: ucfirst($role);
					$class = 'all' === $role ? 'id="kjm_admin_notices_show_notice_to_all"': 'class="others"';
					echo '<li><label class="selectit">';
					echo '<input '.$class.' name="kjm_admin_notices_show_notice_to[]"'.$disabled.' type="checkbox" ' . checked( $role, in_array($role, $show_to_roles) ? $role:'', false ) . ' value="'.$role.'" /> '.$name.' ('.$count.')';
					echo '</label></li>';
				}
				echo '</ul>';
				
			} elseif ($box['id'] == 'kjm_admin_notices_send_email') {
				
				$sent = get_post_meta($object->ID,'kjm-admin-notice-sent',true);
				$send_email = get_post_meta($object->ID,'kjm_admin_notices_send_email',true);
				$send_copy_admin = get_post_meta($object->ID,'kjm_admin_notices_send_copy_admin',true);
				$disabled = empty($sent) ? '': ' disabled=""';
				
				echo '<ul>';
				
				echo '<li><label class="selectit">';
				echo '<input name="kjm_admin_notices_send_email"'.$disabled.' type="checkbox" value="1" '.checked($send_email, 1, false).' />';
				echo __('Send Email', 'kjm-admin-notices').'</label></li>';
				
				echo '<li><label class="selectit">';
				echo '<input name="kjm_admin_notices_send_copy_admin"'.$disabled.' type="checkbox" value="1" '.checked($send_copy_admin, 1, false).' />';
				echo __('Send a copy to Admin', 'kjm-admin-notices').'</label></li>';
				
				echo '</ul>';
				
				// Emails stats.
				if (!empty($sent)) echo '<b>'.__('Sent:', 'kjm-admin-notices').'</b> <br>'; $this->columns_content('kjm-admin-notice-sent-email', $object->ID);
				
			} elseif ($box['id'] == 'kjm_admin_notices_display') {
				
				$hide_title = get_post_meta($object->ID,'kjm_admin_notices_hide_title',true);
				$hide_metas = get_post_meta($object->ID,'kjm_admin_notices_hide_metas',true);
				$hide_dismiss_link = get_post_meta($object->ID,'kjm_admin_notices_hide_dismiss_link',true);
				$hide_dismiss_button = get_post_meta($object->ID,'kjm_admin_notices_hide_dismiss_button',true);
				$show_frontend = get_post_meta($object->ID,'kjm_admin_notices_show_frontend',true);
				$custom_color_bg = sanitize_hex_color_no_hash(get_post_meta($object->ID,'kjm_admin_notices_custom_color_bg',true));
				$custom_color_bg = empty($custom_color_bg) ? '': '#'.$custom_color_bg;
				$custom_color_txt = sanitize_hex_color_no_hash(get_post_meta($object->ID,'kjm_admin_notices_custom_color_txt',true));
				$custom_color_txt = empty($custom_color_txt) ? '': '#'.$custom_color_txt;
				
				echo '<ul>';
				
				echo '<li><label class="selectit">';
				echo '<input name="kjm_admin_notices_hide_title" type="checkbox" value="1" '.checked($hide_title, 1, false).' />';
				echo __('Hide Title', 'kjm-admin-notices').'</label></li>';
				
				echo '<li><label class="selectit">';
				echo '<input name="kjm_admin_notices_hide_metas" type="checkbox" value="1" '.checked($hide_metas, 1, false).' />';
				echo __('Hide Metas (author and date)', 'kjm-admin-notices').'</label></li>';
				
				echo '<li><label class="selectit">';
				echo '<input name="kjm_admin_notices_hide_dismiss_link" type="checkbox" value="1" '.checked($hide_dismiss_link, 1, false).' />';
				echo __('Hide Dismiss Link', 'kjm-admin-notices').'</label></li>';
				
				echo '<li><label class="selectit">';
				echo '<input name="kjm_admin_notices_hide_dismiss_button" type="checkbox" value="1" '.checked($hide_dismiss_button, 1, false).' />';
				echo __('Hide Dismiss Button', 'kjm-admin-notices').'</label></li>';
				
				echo '<li><label class="selectit">';
				echo __('Custom Background Color', 'kjm-admin-notices').' : '.$custom_color_bg;
				echo '</label>';
				echo ' <input name="kjm_admin_notices_custom_color_bg" type="text" class="colorpicker" value="'.$custom_color_bg.'" />';
				echo '</li>';
				
				echo '<li><label class="selectit">';
				echo __('Custom Text Color', 'kjm-admin-notices').' : '.$custom_color_txt;
				echo '</label>';
				echo ' <input name="kjm_admin_notices_custom_color_txt" type="text" class="colorpicker" value="'.$custom_color_txt.'" />';
				echo '</li>';
				
				echo '</ul>';
					
				if ($this->get_option('kjm-admin-notices_allow_frontend') != 0) {
					
					echo '<ul>';
					echo '<li><label class="selectit">';
					echo '<input name="kjm_admin_notices_show_frontend" type="checkbox" value="1" '.checked($show_frontend, 1, false).' />';
					echo __('Show Notice to Frontend', 'kjm-admin-notices').'</label></li>';
					echo '</ul>';
				}
				
				// Views Stats.
				if ($object->post_status === 'publish') echo '<b>'.__('Stats:', 'kjm-admin-notices').'</b> '; $this->columns_content('kjm-admin-notice-stats', $object->ID);
					
			} elseif ($box['id'] == 'kjm_admin_notices_debug') {
				
				$this->get_debug();
				
			} else {
				$this->kjm_table_array_display($object, $box['id'], array('translate_titles' => true));
			}
		}
		
		
		public function active_plugins($show_version=false) {
			
			$plugins = get_option('active_plugins');
			$active_plugins = array();
			
			foreach($plugins as $path) {
				$plugin_version = '';
				
				if ($show_version) {
					$plugin_data = get_plugin_data( WP_PLUGIN_DIR.'/'.$path);
					$plugin_version = ' ('.$plugin_data['Version'].')';
				}
				$plugin_parts = explode('/', $path);
				$active_plugins[] = $plugin_parts[0].$plugin_version;
			}
			
			return $active_plugins;
		}
		
		
		public function save_metaboxes($post_id, $post, $update) {
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
			
			// verify quick edit nonce
			if ( isset( $_POST[ '_inline_edit' ] ) && ! wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) )return;
			
			// Only fire on the right CPT.
			if (!isset($post->post_type) || "kjm_notice" !== $post->post_type) return;
			
			/* Get the post type object. */
			$post_type_object = get_post_type_object( $post->post_type );
			
			// Check if the current user has permission to edit the notice.
			if ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) return;
			
			// Save global params once if not exists.
			if ( ! get_post_meta( $post_id, 'kjm_admin_notices_global_params', true ) ) {
				
				$template = get_option('template');
				$stylesheet = get_option('stylesheet');
				$theme = wp_get_theme($template);
				$child_theme = wp_get_theme($stylesheet);
				
				$params = array(
					'wordpress_version' => get_bloginfo('version'),
					'active_plugins' => $this->active_plugins(true),
					'theme' => $template.' ('.$theme->get('Version').')',
					'child_theme' => $template !== $stylesheet ? $stylesheet.' ('.$child_theme->get('Version').')': __('no'),
				);
				update_post_meta($post_id, "kjm_admin_notices_global_params", $params);
			}
			
			// Check if the POST array exists at all, else return here.
			if ( ! isset($_POST) || empty($_POST)) return;
			
			$skip_list = array('kjm_admin_notices_global_params');
			
			foreach($this->custom_fields['kjm_notice'] as $custom_field) {
				
				// Exclude these custom fields.
				if (in_array($custom_field, $skip_list)) continue;
				
				$meta_name = 'kjm_admin_notices_custom_color_bg';
				if (isset($_POST[$meta_name])) $_POST[$meta_name] = sanitize_hex_color_no_hash( $_POST[$meta_name] );
				$meta_name = 'kjm_admin_notices_custom_color_txt';
				if (isset($_POST[$meta_name])) $_POST[$meta_name] = sanitize_hex_color_no_hash( $_POST[$meta_name] );
					
				if (!isset($_POST[$custom_field])) :
				
					if ( ! isset( $_POST[ '_inline_edit' ] )) : 
						$default_value = isset($this->custom_fields_defaults['kjm_notice'][$custom_field]) ? $this->custom_fields_defaults['kjm_notice'][$custom_field]: '';
						update_post_meta($post_id, $custom_field, $default_value);
					endif;
					
				else :
					update_post_meta($post_id, $custom_field, $_POST[$custom_field]);
				endif;
			}
			
		}
		
		
		/**
		 * Include plugin local settings file
		 *
		 * @since    1.0.0
		 * 
		 */
		public function load_local_settings() {
			
			$path = KJM_ADMIN_NOTICES_PLUGIN_PATH . 'includes/local-settings.php';
			$path_theme = get_stylesheet_directory() . '/plugins/'.$this->plugin_name.'/local-settings.php';
			
			if (file_exists($path_theme)) include_once($path_theme); 
			elseif (file_exists($path)) include_once($path);
		}
		
		
		/**
		 * Force type private.
		 *
		 * @since    1.0.0
		 * 
		 */
		// See : http://wordpress.stackexchange.com/a/118976
		// See : http://wpsnipp.com/index.php/functions-php/force-custom-post-type-to-be-private/
		public function force_type_private( $new_status, $old_status, $post ) {
			$allow_frontend = $this->get_option('kjm-admin-notices_allow_frontend');
			$show_frontend = get_post_meta($post->ID,'kjm_admin_notices_show_frontend',true);
			if ( empty( $allow_frontend ) && empty( $show_frontend ) ) {
				if ( $post->post_type == 'kjm_notice' && $new_status == 'publish' && $old_status  != $new_status ) {
						$post->post_status = 'private';
						wp_update_post( $post );
				}
			}
		}
		
		
		/**
		 * Description.
		 *
		 * @since    1.1.10
		 * 
		 */
		public function colorpicker_field_add_new_kjm_notice_cat( $taxonomy ) {
			
			$meta_name = 'kjm_notice_cat_color';
		?>
			<div class="form-field term-colorpicker-wrap">
				<label for="term-colorpicker"><?php _e('Notice Category Color', 'kjm-admin-notices'); ?> <?php _e('(Beta Feature)', 'kjm-admin-notices'); ?></label>
				<input type="text" name="<?php echo $meta_name; ?>" value="#ffffff" class="colorpicker" id="term-colorpicker" />
				<p><?php _e('Select primary color for Notice category.', 'kjm-admin-notices'); ?></p>
			</div>
		<?php
		}
		
		
		/**
		 * Description.
		 *
		 * @since    1.1.10
		 * 
		 */
		public function colorpicker_field_edit_kjm_notice_cat( $term ) {
			
			$meta_name = 'kjm_notice_cat_color';
			$color = get_term_meta( $term->term_id, $meta_name, true );
			$color = ( !empty( $color ) ) ? "#{$color}" : '#ffffff';
		?>
			<tr class="form-field term-colorpicker-wrap">
				<th scope="row"><label for="term-colorpicker"><?php _e('Notice Category Color', 'kjm-admin-notices'); ?> <?php _e('(Beta Feature)', 'kjm-admin-notices'); ?></label></th>
				<td>
					<input type="text" name="<?php echo $meta_name; ?>" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" />
					<p class="description"><?php _e('Edit primary color for Notice category.', 'kjm-admin-notices'); ?></p>
				</td>
			</tr>
		<?php
		}
		
		
		/**
		 * Save termm meta.
		 *
		 * @since    1.1.10
		 * 
		 */
		public function save_termmeta( $term_id ) {
			
			// Save term color if possible
			$meta_name = 'kjm_notice_cat_color';
			if( isset( $_POST[$meta_name] ) && !empty( $_POST[$meta_name] ) ) {
				update_term_meta( $term_id, $meta_name, sanitize_hex_color_no_hash( $_POST[$meta_name] ) );
			} else {
				delete_term_meta( $term_id, $meta_name );
			}
		}
	
	
	/**
	 * Add post statuses.
	 */
	public function register_post_statuses() {
		
		// Check for archived-post-status.
		$plugin = 'archived-post-status/archived-post-status.php';
		#$this->debug('aps_current_user_can_view', aps_current_user_can_view());
		// Register a custom post status for Archived.
		if ( ! $this->is_plugin_active($plugin) && ! $this->is_currently_activating_plugin($plugin) ) {
			
			$args = array(
				'label'                     => __( 'Archived', 'kjm-admin-notices' ),
				'public'                    => (bool) apply_filters( 'aps_status_arg_public', aps_current_user_can_view() ),
				'private'                   => (bool) apply_filters( 'aps_status_arg_private', true ),
				#'protected'                 => true,
				'internal'                  => false,
				'exclude_from_search'       => (bool) apply_filters( 'aps_status_arg_exclude_from_search', ! aps_current_user_can_view() ),
				'show_in_admin_all_list'    => (bool) apply_filters( 'aps_status_arg_show_in_admin_all_list', aps_current_user_can_view() ),
				'show_in_admin_status_list' => (bool) apply_filters( 'aps_status_arg_show_in_admin_status_list', aps_current_user_can_view() ),
				'label_count'               => _n_noop( 'Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>', 'kjm-admin-notices' ), 
				// Translators: $1$s is the number of posts
			);

			register_post_status( 'archive', $args );
		}
	}
	
	
	/**
	 * Display post states.
	 */
	public function display_post_states( $states ) {
		global $post;
		
		$plugin = 'archived-post-status/archived-post-status.php';
		if ( $this->is_plugin_active($plugin) ) return $states;

		$arg = get_query_var( 'post_status' );

		if ( 'archive' !== $arg ) {

			if ( 'archive' === $post->post_status ) {

				return array( __( 'Archived', 'kjm-admin-notices' ) );
			}
		}

		return $states;
	}
	
	
	/**
	 * Is plugin Installed and Active.
	 */
	public function is_plugin_active($plugin) {
		
		$return = false;
		/**
		 * Detect plugin. For use in Admin area only.
		 */

		if ( is_plugin_active( $plugin ) ) {
			// Plugin is activated.
			$return = true;
		}
		
		// Archived Post Status
		if ('archived-post-status/archived-post-status.php' === $plugin) {
			
			if ( class_exists( 'Other_Plugins_Class' ) ) {
				// do stuff, the other plugin is installed and activated
			}

			if ( function_exists('a_function_in_the_other_plugin' ) ) {
				// do stuff, the other plugin is installed and activated
			}

			if ( defined( 'A_CONSTANT_IN_THE_OTHER_PLUGIN' ) ) {
				// do stuff, the other plugin is installed and activated
			}
		}
		
		return $return;
	}
	
	
	/**
	 * Check if compatible plugins are active, else load local functions.
	 */
	public function check_plugins_compat() {
		
		// Check for archived-post-status.
		$plugin = 'archived-post-status/archived-post-status.php';
		
		// Prevent loading if activation occurs.
		if ($this->is_currently_activating_plugin($plugin)) return;
		
		// Load functions if not active.
		if (!$this->is_plugin_active($plugin)) {
			
			require_once KJM_ADMIN_NOTICES_PLUGIN_PATH . 'includes/wp-archived-post-status-functions.php';
			
			#$this->debug('aps_current_user_can_view', aps_current_user_can_view());
		}
		
	}
	
	
	
	/**
	 * Check if currently activatin plugin.
	 */
	public function is_currently_activating_plugin($plugin) {
		
		if (isset($_GET['action']) && 'activate' === $_GET['action'] && isset($_GET['plugin'])) {
			if ($plugin === $_GET['plugin']) return true;
		}
		if (isset($_POST['action']) && 'activate-selected' === $_POST['action']) {
			
			return true;
		}
		if (isset($_POST['action2']) && 'activate-selected' === $_POST['action2']) {
			
			return true;
		}
		
		return false;
	}
	
	
	/**
	 * setting_field_display_custom_field_line
	 */
	public function setting_field_display_custom_field_line($field_line, $name, $params) {
		
		// Initialize variables.
		$output = $field_line = '';
		
		// Extract pparams.
		extract($params);
		
		$parent = empty($parent) ? $name: $parent;
		$is_parent = $parent == $name ? 'parent': 'child';
		
		$accepted_names = array(
			$this->plugin_name.'_is_plugin_kjm-search-log_active',
			$this->plugin_name.'_is_plugin_kjm-avia-form-cpt_active',
			$this->plugin_name.'_is_plugin_kajoom-framework_active',
			$this->plugin_name.'_is_plugin_archived-post-status_active',
		);
		
		// Build field line depending on the field type.
		switch (true) {
			
			case in_array($name, $accepted_names): 
			
				$value = $this->_settings[$name];
				
				if (isset($value_callback) 
				&& isset($value_callback[0]) && class_exists($value_callback[0]) 
				&& isset($value_callback[1]) && method_exists($value_callback[0], $value_callback[1]) 
				) {
					
					$instance = method_exists($value_callback[0], 'get_instance') ? $value_callback[0]::get_instance(): $value_callback[0];
					$args = isset($value_callback[2]) ? (array) $value_callback[2]: array();
					#$instance = call_user_func_array(array($value_callback[0], 'get_instance'));
					$value = call_user_func_array(array($instance, $value_callback[1]), $args);
					
					#$this->debug($args, $value);
				}
				
				$value = empty($value) ? 0: 1;
				$checked = ($value == 1) ? 'checked="checked"': '';
				
				$square_value = empty($value) ? __('no', 'kjm-admin-notices'): __('yes', 'kjm-admin-notices');
				$square_color = empty($value) ? 'color:gray;': 'color:green;';
				$square_title = '<span class="'.$name.'-square" style="'.$square_color.'">'.$square_value.'</span>';
				
				$field_line = '
				<label for="'.$name.'">
					<input type="checkbox" disabled id="'.$name.'" name="'.$name.'" value="1" '.$checked.'>'.$square_title.'
					
				</label>
				<span class="description"> '.$description.' </span>';
				
			break;
			
		}
		
		return $field_line;
		
	}

} // End of Class

endif; // Endif class exists.
