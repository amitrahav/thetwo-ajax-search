<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Thetwo_Ajax_Search
 * @subpackage Thetwo_Ajax_Search/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Thetwo_Ajax_Search
 * @subpackage Thetwo_Ajax_Search/admin
 * @author     Your Name <email@example.com>
 */
class Thetwo_Ajax_Search_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $thetwo_ajax_search    The ID of this plugin.
	 */
	private $thetwo_ajax_search;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $thetwo_ajax_search       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($thetwo_ajax_search, $version)
	{

		$this->thetwo_ajax_search = $thetwo_ajax_search;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Thetwo_Ajax_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Thetwo_Ajax_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->thetwo_ajax_search, plugin_dir_url(__FILE__) . 'css/thetwo-ajax-search-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Thetwo_Ajax_Search_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Thetwo_Ajax_Search_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->thetwo_ajax_search, plugin_dir_url(__FILE__) . 'js/thetwo-ajax-search-admin.js', array('jquery'), $this->version, false);
	}

	public function setting_field()
	{

		//section name, display name, callback to print description of section, page to which section is attached.
		add_settings_section("thetwo_search_section", "TheTwo Search", array(&$this, "display_header_options_content"), "general");

		//setting name, display name, callback to print form element, page in which field is displayed, section to which it belongs.
		//last field section is optional.
		add_settings_field(
			$this->thetwo_ajax_search .  '-remove_input',
			'Only search icon (without field)',
			array($this, 'remove_input_callback_function'),
			'general',
			'thetwo_search_section',
			array('label_for' => $this->thetwo_ajax_search .  '-remove_input')
		);
		add_settings_field(
			$this->thetwo_ajax_search .  '-append_menu',
			'Add Button To Menu',
			array($this, 'append_menu_callback_function'),
			'general',
			'thetwo_search_section',
			array('label_for' => $this->thetwo_ajax_search .  '-append_menu')
		);

		//section name, form element name, callback for sanitization
		register_setting("general", $this->thetwo_ajax_search .  '-settings', array($this, 'sanitization'));
	}

	public function sanitization($input)
	{
		$sanitary_values = array();
		$object = json_decode(json_encode($input), FALSE);
		$input = (object) $input;

		if (isset($object->remove_input) && ($object->remove_input == 1 || $object->remove_input == 0)) {
			$sanitary_values['remove_input'] = $object->remove_input;
		}

		if (isset($object->append_menu) && is_string($object->append_menu)) {
			$sanitary_values['append_menu'] = sanitize_text_field($object->append_menu);
		}

		error_log(print_r($sanitary_values, true));
		return (array) $sanitary_values;
	}

	public function display_header_options_content()
	{
		_e("All Ajax search settings", $this->thetwo_ajax_search);
	}

	public function remove_input_callback_function()
	{
		$name = $this->thetwo_ajax_search . "-settings[remove_input]";
		$selected = (object) get_option($this->thetwo_ajax_search . "-settings");
		echo '<input type="checkbox" name="' . $name . '" id="' . $name . '" value="1" ' . checked(1, $selected->remove_input, false) . ' />';
	}
	public function append_menu_callback_function()
	{
		$name = $this->thetwo_ajax_search . "-settings[append_menu]";
		$selected = (object) get_option($this->thetwo_ajax_search . "-settings");
		$navs = get_terms('nav_menu', array('hide_empty' => true));

		$html = '<select name="' . $name . '" id="' . $name . '">';
		$html .= '<option>'  . __('None (use search only with shortcode)', $this->thetwo_ajax_search) . '</option>';

		foreach ($navs as $nav) {
			$html .= '<option value="' . $nav->slug . '" ' . selected($selected->append_menu, $nav->name, false) . '>' . $nav->name . '</option>';
		}
		$html .= '</select>';
		echo $html;
	}

	public function add_action_links($links)
	{
		$links[] = '<a href="' . admin_url('options-general.php') . '">' . _('Settings', $this->thetwo_ajax_search) . '</a>';

		return $links;
	}
}
