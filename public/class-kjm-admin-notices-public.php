<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.kajoom.ca/
 * @since      1.0.8
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/public
 */
if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}

if ( ! class_exists( 'Kjm_Admin_Notices_Public' ) ) :

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/public
 * @author     Marc-Antoine Minville <support@kajoom.ca>
 */
final class Kjm_Admin_Notices_Public {
	
	
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.8
	 *
	 * @var      object
	 */
	protected static $instance = null;
	

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.8
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.8
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	protected $version;
	
	
	/**
	 * Local instance of plugin shared class
	 *
	 * @since    1.0.8
	 * @access   protected
	 * @var      object    $shared    Shared class.
	 */
	public $shared;
	
	
	/**
	 * Local instance of Tools class
	 *
	 * @since		1.0.8
	 * @access	private
	 * @see			Kajoom_Tools
	 * @var			object 	$tools 	Tools class.
	 */
	protected $tools;
	
	
	/**
	 * Plugin options
	 *
	 * @since		1.0.8
	 * @access	protected
	 * @var			array 	$options 	Plugin options.
	 */
	protected $options;
	

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.8
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $shared ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		#$this->tools = new Kajoom_Tools;
		
		$this->shared = $shared;
		//$this->_settings = $this->shared->_settings;
		$this->options = $this->shared->get_options();
		
		//$this->request_controller();
		
		// Auto-create instance.
		self::$instance = $this;
		
		// Run `kjm_admin_notices_public_loaded` actions.
		do_action( 'kjm_admin_notices_public_loaded' );
	}
	
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.8
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		#if ( null == self::$instance ) {
		#	self::$instance = new self;
		#}

		return self::$instance;
	}
	

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.8
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
		if (empty($this->options['kjm-admin-notices_allow_frontend'])) return;
		
		wp_enqueue_style( $this->plugin_name.'-css', plugin_dir_url( __FILE__ ) . 'css/kjm-admin-notices-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.8
	 */
	public function enqueue_scripts() {

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
    
    if (empty($this->options['kjm-admin-notices_allow_frontend'])) return;
    
    wp_enqueue_script( $this->plugin_name.'-cookie-js', plugin_dir_url( __FILE__ ) . 'js/jquery.cookie.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-js', plugin_dir_url( __FILE__ ) . 'js/kjm-admin-notices-public.js', array( 'jquery' ), $this->version, false );

	}
	
	
	public function show_notices() {
		
		if (empty($this->options['kjm-admin-notices_allow_frontend'])) return;
		
		global $post, $current_user, $wp_query;
		
		// Hide or Show on Pages.
		$show_pages = $this->shared->get_comma_separated_values($this->options['kjm-admin-notices_show_pages']);
		$hide_pages = $this->shared->get_comma_separated_values($this->options['kjm-admin-notices_hide_pages']);
		$current_page = isset($wp_query->post->ID) ? $wp_query->post->ID: get_queried_object_id();
		
		if (!empty($show_pages) && !in_array($current_page, $show_pages)) return;
		if (!empty($hide_pages) && in_array($current_page, $hide_pages)) return;
		
		// Allow to modify behavior with a filter.
		if ( ! apply_filters('kjm_admin_notices_frontend_notice_show', true, $current_page, $show_pages, $hide_pages) ) return;
		
		$frontend_layout = $this->options['kjm-admin-notices_frontend_layout'];
		$layout = !empty($frontend_layout) ? $frontend_layout: 'default'; // default = compact, post = post style
		$frontend_absolute = $this->options['kjm-admin-notices_frontend_absolute'];
		$position = !empty($frontend_absolute) ? 'absolute': 'relative'; // relative or absolute
		$args = array(
			'post_type'        => 'kjm_notice',
			'post_status' => array('publish'), 
			'posts_per_page'   => -1,
		);
		$kjmquery = new WP_Query( $args );
		
		?>
		<style>
			<!--
			-->
		</style>
		<?php
		
		echo '<div class="kjm-notice position-'.$position.'">';
			
			while ( $kjmquery->have_posts() ) : $kjmquery->the_post();
			
				$notice_catid = get_the_terms(  $kjmquery->ID, 'kjm_notice_cat' );
				$show_frontend = get_post_meta($post->ID, "kjm_admin_notices_show_frontend", true);
				$hide_dismiss_link = get_post_meta($post->ID,'kjm_admin_notices_hide_dismiss_link',true);
				$hide_dismiss_button = get_post_meta($post->ID,'kjm_admin_notices_hide_dismiss_button',true);
				$hide_title = get_post_meta($post->ID,'kjm_admin_notices_hide_title',true);
				$hide_metas = get_post_meta($post->ID,'kjm_admin_notices_hide_metas',true);
				$has_title_class = empty($hide_title) ? 'has-title': 'no-title';
				$has_metas_class = empty($hide_metas) ? 'has-metas': 'no-metas';
				$custom_color_bg = get_post_meta($post->ID,'kjm_admin_notices_custom_color_bg',true);
				$custom_color_txt = get_post_meta($post->ID,'kjm_admin_notices_custom_color_txt',true);

				$kjm_cookie = isset($_COOKIE['kjmnotice']) ? $_COOKIE['kjmnotice'] : '';
				$kjm_cookies = explode(',', $kjm_cookie);
				
				$notice_cat = !empty($notice_catid[0]->slug) ? $notice_catid[0]->slug: 'success';
				
				$kjm_custom_styles='style="';
				if (in_array(''.$post->ID, $kjm_cookies)) $kjm_custom_styles .= 'display:none;';
				if ($custom_color_bg) $kjm_custom_styles.='background:#'.$custom_color_bg.' !important;';
				if ($custom_color_txt) $kjm_custom_styles.='color:#'.$custom_color_txt.' !important;';
				$kjm_custom_styles.='"';
				$kjm_custom_styles = apply_filters('kjm_admin_notices_frontend_notice_styles', $kjm_custom_styles, $post->ID);
				
				$dismiss_class = $hide_dismiss_button && $hide_dismiss_link ? 'not-dismissible': 'is-dismissible';
				$dismiss_class .= $hide_dismiss_button ? ' hide-dismiss-button': '';
				
				$css_classes = 'kjm-notice-'.$notice_cat.' '.$dismiss_class.'';
				$css_classes .= ' kjm-content kjm-'.$notice_cat.' layout-'.$layout.' '.$has_title_class.' '.$has_metas_class;
				$css_classes = apply_filters('kjm_admin_notices_frontend_notice_classes', $css_classes, $post->ID);
				
				if (!empty($show_frontend)) : 
				
				$this->shared->update_views_count($post->ID, array('type' => 'public'));
				
				/*<div class="notice notice-'.$notice_cat.' '.$dismiss_class.' kjm-admin-notice" '.$kjm_custom_css.' id="kjm-admin-notices-message-'.$notice_id.'" data-notice-id="'.$notice_id.'">*/
				
				echo '<div '.$kjm_custom_styles.' class="'.$css_classes.'" id="kjm-notice-'.$post->ID.'" data-id="'.$post->ID.'">';
					
					$notice_content = $this->shared->format_notice_content($post->ID, array('post'=>$post), $current_user, $layout);
					
					// Allow to customize notice content via filters.
					echo apply_filters('kjm_admin_notices_frontend_notice_content', $notice_content, array('ID'=>$post->ID, 'post'=>$post, 'current_user'=>$current_user, 'layout'=>$layout));
					
					if (empty($hide_dismiss_link)) echo '<a class="notice-dismiss kjm-notice-dismiss remove-notice" href="#" rel="'.$post->ID.'">'.__('Thanks, Got it.', 'kjm-admin-notices').'</a>';
				
				echo '</div>';
				
				endif;
				
			endwhile;
			
		echo '</div>';
			
		wp_reset_postdata();
	}

} // End of Class

endif; // Endif class exists.
