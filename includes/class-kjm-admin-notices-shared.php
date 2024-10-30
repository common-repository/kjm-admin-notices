<?php
/**
 * Class Kjm_Admin_Notices_Shared
 * 
 * The Shared functionality of the plugin.
 *
 * @link       https://www.kajoom.ca
 * @since      1.0.8
 *
 * @package    Kjm_Admin_Notices
 * @subpackage Kjm_Admin_Notices/includes
 * @author     Marc-Antoine Minville <support@kajoom.ca>
 */
if ( ! defined( 'WPINC' ) ) {
	die;	// If this file is called directly, abort.
}

if ( ! class_exists( 'Kjm_Admin_Notices_Shared' ) ) :

class Kjm_Admin_Notices_Shared {
	
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.8
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	
	
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.8
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	
	/**
	 * Local instance of Tools class
	 *
	 * @since		1.0.8
	 * @access	private
	 * @see			Kajoom_Tools
	 * @var			object 	$tools 	Tools class.
	 */
	private $tools;
	
	
	/**
	 * Plugin options
	 *
	 * @since		1.0.8
	 * @access	protected
	 * @var			array 	$options 	Plugin options.
	 */
	protected $options;
	
	
	public $custom_post_types = array(
		'kjm_notice'	=>	'notice',
	);
	
	
	/**
	 * List of shortcodes
	 *
	 * @since		1.0.0
	 * @access	public
	 * @var			array 	$shortcodes
	 */
	public	$shortcodes = array(
		'website_domain',
		#'display_name',
		'admin_login',
	);
	
	
	/**
	 * Required capability to send notices.
	 *
	 * @since		1.0.8
	 * @access	protected
	 * @var			string 	$capability 	Capability or Role.
	 */
	protected $capability = 'administrator';
	
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.8
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		#$this->tools = new Kajoom_Tools;
		$this->options = get_option('kjm_admin_notices_settings') ? get_option('kjm_admin_notices_settings') : array();
		
		do_action( 'kjm_admin_notices_shared_loaded' );
	}
	
	
	/**
	 * Start session.
	 */
	public function session_start() {
		if(!session_id()) {
				session_start();
				session_write_close();
		}
	}
	
	
	/**
	 * End session.
	 */
	public function session_destroy() {
		session_destroy();
	}
	
	
	/**
	 * Retrieve the options of the plugin.
	 *
	 * @since     1.0.9
	 * @return    array    The options of the plugin.
	 */
	public function get_options() {
		return $this->options;
	}
	
	
	/**
	 * Set capabilities.
	 */
	public function set_capability($capability) {
		
		$this->capability = empty($capability) ? $this->capability: $capability;
	}
	
	
	/**
	 * Get capabilities.
	 */
	public function get_capability() {
		
		return $this->capability;
	}
	
	
	/**
	 * Shortcodes.
	 */
	public function register_shortcodes() {
		
		// Generate Shortcodes.
		foreach ($this->shortcodes as $shortcode) {
			
			$function_name = $shortcode.'_shortcode';
			
			if (method_exists($this, $function_name)) {
				add_shortcode('kjm_'.$shortcode, array($this, $function_name));
			}
		}
	}
	
	
	/**
	 * trigger_on_publish_post.
	 */
	public function trigger_on_publish_post( $post_id, $post ) {
		
		if (array_key_exists($post->post_type, $this->get_custom_post_types())) {
			
			if ($this->options[$this->plugin_name.'_send_email_active'] == 1) {
				$this->send_email_notice($post_id);
			}
		}
		
	}
	
	public function get_custom_post_types() {
		
		return $this->custom_post_types;
	}
	
	
	/* Shortcodes */
	
	/**
	 * website_domain.
	 */
	public function get_website_domain() {
		
		return preg_replace('/^www\./','',$_SERVER['SERVER_NAME']);
	}
	
	
	/**
	 * [kjm_website_domain]
	 */
	public function website_domain_shortcode($atts, $content='', $tag='name') {
		
    // $atts - array of attributes passed from shortcode
    // $content - content between shortcodes that have enclosing tags eg: [tag]content[/tag]
    // $tag - shortcode name
    
		extract(shortcode_atts(array(
			'demo' => 0,
		), $atts));
			
		return $this->get_website_domain();
	}
	
	
	/**
	 * [kjm_display_name]
	 */
	public function display_name_placeholder($content, $replace) {
			
		return str_replace('[kjm_display_name]', $replace, $content);
	}
	
	
	/**
	 * [kjm_admin_login]
	 */
	public function admin_login_shortcode($atts, $content='', $tag='name') {
		
    // $atts - array of attributes passed from shortcode
    // $content - content between shortcodes that have enclosing tags eg: [tag]content[/tag]
    // $tag - shortcode name
    
		extract(shortcode_atts(array(
			'demo' => 0,
		), $atts));
			
		return wp_login_url();
	}
	
	
	/**
	 * format_notice_content.
	 */
	public function format_notice_content($notice_id, $notice, $current_user, $layout='default') {
		
		$hide_title = get_post_meta($notice_id,'kjm_admin_notices_hide_title',true);
		$hide_metas = get_post_meta($notice_id,'kjm_admin_notices_hide_metas',true);
		$hide_dismiss_button = get_post_meta($notice_id,'kjm_admin_notices_hide_dismiss_button',true);
		$custom_color_txt = get_post_meta($notice_id,'kjm_admin_notices_custom_color_txt',true);
		
		$output = $date_alone = '';
		$date_alone = empty($hide_title) ? '': 'alone';
		
		$kjm_custom_styles='style="';
		#if ($custom_color_bg) $kjm_custom_styles.='background:#'.$custom_color_bg.' !important;';
		if ($custom_color_txt) $kjm_custom_styles.='color:#'.$custom_color_txt.' !important;';
		$kjm_custom_styles.='"';
		
		// Dissmiss button
		if (is_admin()) $output .= (current_user_can( $this->capability )) ? '<a class="edit-link" href="'.admin_url('post.php?post='.$notice_id.'&action=edit').'">'.__('Edit Notice', 'kjm-admin-notices').'</a>': '';
		if (!is_admin() && empty($hide_dismiss_button)) $output .= '<a class="kjm-button-round remove-notice" href="#" rel="'.$notice_id.'">x</a>';
		
		// Layout
		if ('default' === $layout) {
			
			if (empty($hide_title)) $output .= '<b class="notice-title" '.$kjm_custom_styles.'>'.do_shortcode($notice['post']->post_title).'</b> ';
			if (empty($hide_metas)) $output .= '<i class="date small '.$date_alone.'">'.sprintf( _x( '%s ago', '%s = human-readable time difference', 'kjm-admin-notices' ), human_time_diff( get_the_time( 'U', $notice_id ), current_time( 'timestamp' ) ) ).' '.sprintf( _x( 'by %s', '%s = author display name', 'kjm-admin-notices' ), get_the_author_meta('display_name', $notice['post']->post_author) ).'</i>';
			if (empty($hide_title) || empty($hide_metas)) $output .= '<br>';
			$output .= nl2br(do_shortcode($notice['post']->post_content));
			$output = $this->display_name_placeholder($output, $current_user->display_name);
			
		} else {
			
			if (empty($hide_title)) $output .= '<h3 '.$kjm_custom_styles.'>'.get_the_title().'</h3>';
			$output .= get_the_content();
			
		}
		
		return $output;
	}
	
	
	/**
	 * Send Email Notice.
	 */
	public function send_email_notice($notice_id) {
		
		$sent = get_post_meta($notice_id, "kjm-admin-notice-sent", true);
		if (!empty($sent)) return false;
		
		$send_email_option = $this->options["kjm-admin-notices_send_email_active"];
		if (empty($send_email_option)) return false;
		
		$send_email = get_post_meta($notice_id, "kjm_admin_notices_send_email", true);
		if (empty($send_email)) return false;
		
		$filters_params = array(
			'ID' => $notice_id,
			'post_title' => $notice->post_title,
			'post_content' => $notice->post_content,
			'login_text' => $login_text,
			'website_domain' => $this->get_website_domain(),
		);
		
		$from_email = $this->options["kjm-admin-notices_from_email_active"];
		$from_email = apply_filters('kjm_admin_notices_email_from_email', $from_email, $filters_params);
		$from_email = empty($from_email) || (filter_var($from_email, FILTER_VALIDATE_EMAIL) === false) ? 'wordpress@'.$this->get_website_domain(): $from_email;
		
		$from_name = $this->options["kjm-admin-notices_from_name_active"];
		$from_name = apply_filters('kjm_admin_notices_email_from_name', $from_name, $filters_params);
		$from_name = empty($from_name) ? __('WordPress', 'kjm-admin-notices') : $from_name;
		$from_name = str_ireplace(array("\r", "\n", '%0A', '%0D'), '', $from_name);
		
		$send_to_roles = get_post_meta($notice_id, "kjm_admin_notices_show_notice_to", true);
		$send_to_roles = is_array($send_to_roles) ? $send_to_roles: array($send_to_roles);
		$send_to_roles = apply_filters('kjm_admin_notices_email_send_to_roles', $send_to_roles, $filters_params);
		
		$notice = get_post($notice_id);
		if (empty($notice)) return false;
		if ("publish" !== $notice->post_status && "private" !== $notice->post_status) return false;
		
		// Allow to stop all email sending process with a filter.
		if ( ! apply_filters('kjm_admin_notices_email_send_email', true, $filters_params) ) return;
		
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: '.$from_name.' <'.$from_email.'>',
		);
		$send_copy_admin = get_post_meta($notice_id, "kjm_admin_notices_send_copy_admin", true);
		if (!empty($send_copy_admin)) $headers[] = 'Bcc: '.get_option('admin_email');
		$login_text = '<br><br><i class="small">'.__('This notification has been sent by [kjm_website_domain]. ', 'kjm-admin-notices');
		$login_text .= __('Address to connect to your site:', 'kjm-admin-notices').' <a href="[kjm_admin_login]" title="'.__('Login', 'kjm-admin-notices').'" target="_new">[kjm_admin_login]</a></i>';
		$body = nl2br(do_shortcode($notice->post_content.$login_text));
		$args = in_array('all', $send_to_roles) ? array(): array('role__in' => $send_to_roles);
		$users = get_users($args);
		$sent_to = array();
		
		// No users to send to.
		if (empty($users)) return false;
		
		// Send each email.
		foreach ($users as $user) {
			
			$filters_params = array_merge($filters_params, array(
				'user_display_name' => $user->data->display_name,
				'user_email' => $user->data->user_email,
			));
			
			// Allow to stop email sending process for a particular user with a filter.
			if ( ! apply_filters('kjm_admin_notices_email_send_user_email', true, $filters_params) ) continue;
			
			// Reset variables.
			$to = $subject = '';
			$subject = do_shortcode($notice->post_title);
			$subject = $this->display_name_placeholder($subject, $user->data->display_name);
			$subject = apply_filters('kjm_admin_notices_email_subject', $subject, $filters_params);
			
			$body_processed = $this->display_name_placeholder($body, $user->data->display_name);
			$body_processed = apply_filters('kjm_admin_notices_email_body', $body_processed, $filters_params);
			
			$headers = apply_filters('kjm_admin_notices_email_headers', $headers, $filters_params);
			
			$to = $user->data->display_name.' <'.$user->data->user_email.'>';
			$to = $sent_to[] = apply_filters('kjm_admin_notices_email_to', $to, $filters_params);
			
			// Send Email Action.
			do_action('kjm_admin_notices_send_email', array('to'=>$to, 'subject'=>$subject, 'body'=>$body_processed, 'headers'=>$headers), $filters_params);
		}
		
		// Write info about this sent notice.
		update_post_meta($notice_id, "kjm-admin-notice-sent", 1);
		update_post_meta($notice_id, "kjm-admin-notice-sent-to", $sent_to);
		update_post_meta($notice_id, "kjm-admin-notice-sent-to-roles", $send_to_roles);
		update_post_meta($notice_id, "kjm-admin-notice-sent-time", current_time('mysql'));
	}
	
	
	/**
	 * Send Email.
	 */
	public function send_email($email_params, $filters_params) {
		
		extract($email_params);
		
		if (isset($to) && isset($subject) && isset($body) && isset($headers)) {
		
			wp_mail( $to, $subject, $body, $headers );
		}
	}
	
	
	/**
	 * get_comma_separated_values.
	 */
	public function get_comma_separated_values($string) {
		
		return array_filter(array_map('intval', array_map('trim', explode(',', $string))));
	}
	
	
	/**
	 * Update views count for a notice (kjm custom table method).
	 */
	public function update_views_count($notice_id, $params=array()) {
		
		global $current_user;
		
		$user_id = isset($current_user->ID) ? $current_user->ID: 0;
		
		// Stop if stats not enabled.
		if (empty($this->options['kjm-admin-notices_enable_stats'])) return;
		
		// Stop if superadmin excluded.
		if (!empty($user_id) && !empty($this->options['kjm-admin-notices_stats_exclude_superadmin'])) {
			if (is_super_admin($user_id)) return;
		}
		
		// Stop if author excluded.
		if (!empty($user_id) && !empty($this->options['kjm-admin-notices_stats_exclude_author'])) {
			$post_author_id = (int) get_post_field( 'post_author', $notice_id );
			if ($user_id === $post_author_id) return;
		}
		
		/* User notice views count value. */
		if (!empty($user_id)) {
			/*$meta_key = 'kjm_'.(int) $notice_id.'_notice_views';
			$value = (int) get_user_meta($user_id, $meta_key, true);
			$value++;
			update_user_meta($user_id, $meta_key, $value);*/
		}
		
		// Update total views count.
		/*$meta_key = 'kjm-admin-notice-views-count';
		$value = (int) get_post_meta($notice_id, $meta_key, true);
		$value++;
		update_post_meta($notice_id, $meta_key, $value);*/
		
		$type = isset($params['type']) ? $params['type']: 'default';
		$reference = isset($params['reference']) ? $params['reference']: '';
		$hash = !empty($user_id) ? $user_id : session_id();
		$hash = md5($hash);
		
		// Use New table.
		$data = array_merge($this->get_notice_view_model(), array(
			'post_id' => $notice_id,
			'user_id' => $user_id,
			'type' => $type,
			'time' => current_time( 'timestamp' ),
			'hash' => $hash,
			'reference' => $reference,
		));
		$this->add_notice_view($data);
	}
	
	
	/**
	 * Get notice view model.
	 */
	public function get_notice_view_model() {
		
		return array(
			'id' => '',
			'post_id' => 0,
			'user_id' => 0,
			'type' => 'default',
			'time' => 0,
			'hash' => '',
			'reference' => '',
		);
	}
	
	
	/**
	 * Get notices views.
	 */
	public function get_notice_views($notice_id) {
		
		global $wpdb;
		
		$query = $wpdb->prepare( "SELECT * FROM $wpdb->kjm_notices_views WHERE post_id = %d", (int) $notice_id );
		$results = $wpdb->get_results($query);
		
		return $results;
	}
	
	
	/**
	 * Get notice views count.
	 */
	public function get_notice_views_count($notice_id) {
		
		global $wpdb;
		
		$query = $wpdb->prepare( "SELECT COUNT(id) as count FROM $wpdb->kjm_notices_views WHERE post_id = %d", (int) $notice_id );
		$count = (int) $wpdb->get_var($query);
		
		return $count;
	}
	
	
	/**
	 * Get notice views count for a user.
	 */
	public function get_user_views_count($notice_id, $user_id) {
		
		global $wpdb;
		
		$query = $wpdb->prepare( "SELECT COUNT(id) as count FROM $wpdb->kjm_notices_views WHERE post_id = %d AND user_id = %d", (int) $notice_id, (int) $user_id );
		$count = (int) $wpdb->get_var($query);
		
		return $count;
	}
	
	
	/**
	 * Get notice users count.
	 */
	public function get_notice_users_count($notice_id) {
		
		global $wpdb;
		
		$query = $wpdb->prepare( "SELECT COUNT(DISTINCT hash) as count FROM $wpdb->kjm_notices_views WHERE post_id = %d", (int) $notice_id );
		$count = (int) $wpdb->get_var($query);
		
		return $count;
	}
	
	
	/**
	 * Add a notice view.
	 */
	public function add_notice_view($data) {
		
		global $wpdb;
		
		$data = array_merge($this->get_notice_view_model(), $data);
		
		$results = $wpdb->insert( $wpdb->kjm_notices_views, $data );
		
		return $results;
	}

} // End of Class

endif; // Endif class exists.
