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
}
