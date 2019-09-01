<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Thetwo_Ajax_Search
 * @subpackage Thetwo_Ajax_Search/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Thetwo_Ajax_Search
 * @subpackage Thetwo_Ajax_Search/public
 * @author     Your Name <email@example.com>
 */
class Thetwo_Ajax_Search_Public
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
	 * @param      string    $thetwo_ajax_search       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($thetwo_ajax_search, $version)
	{

		$this->thetwo_ajax_search = $thetwo_ajax_search;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->thetwo_ajax_search, plugin_dir_url(__FILE__) . 'css/thetwo-ajax-search-public.css', array(), $this->version, 'all');
		wp_enqueue_style('prefix-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css', array(), '4.0.3');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->thetwo_ajax_search, plugin_dir_url(__FILE__) . 'js/thetwo-ajax-search-public.js', array('jquery'), $this->version, false);
	}

	public function search_localize()
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
		$months = (array) array();
		for ($m = 1; $m <= 12; $m++) {
			$month = date_i18n('F', mktime(0, 0, 0, $m, 1, date('Y')));
			$months[] = $month;
		}
		wp_localize_script($this->thetwo_ajax_search, 'search_results', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'security'  => wp_create_nonce('thetwo_ajax_search-nonce'),
			'no_res_translate' => __('We couldnt find any results', $this->thetwo_ajax_search),
			'try_again_translate' => __('You can try again', $this->thetwo_ajax_search),
			'search_results_title_translate'	=> __('The Search Results', $this->thetwo_ajax_search),
			'at_translate' => __('at', $this->thetwo_ajax_search),
			'months' => $months
		), $this->version);
	}

	public function go_search_results()
	{

		if (!check_ajax_referer('thetwo_ajax_search-nonce', 'security')) {
			wp_send_json_error(__('Invalid security token sent.', $this->thetwo_ajax_search));
			wp_die();
		}

		$post['term'] = sanitize_text_field($_POST['term']);
		$post['post_type'] = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : '';


		$term = $post['term'];
		$type = empty($post['post_type']) ? 'any' : $post['post_type'];

		include('partials/thetwo-ajax-search-public-results.php');
		die();
	}

	public function main_search_html($args)
	{
		$wrapper_class = isset($args['wrapper_class']) ? esc_attr($args['wrapper_class']) : 'serach-wrapper';
		$form_class = isset($args['form_class']) ? esc_attr($args['form_class']) : 'searchform';
		$placeholder = isset($args['placeholder']) ?  sanitize_text_field($args['placeholder']) : 'search';
		$only_button = array_key_exists('only_button', $args) ?  1 : 0;


		if ($only_button) {
			$html = '<div class="' . $wrapper_class . '" id="open-search">
					<i class="fa fa-search" aria-hidden="true"></i>
				</div>';
		} else {
			$html = '<div class="' . $wrapper_class . '">
				<form role="search" method="get" id="searchform" class="' . $form_class . '" action="' . home_url() . '">
					<input id="like-search" placeholder="' . $placeholder . '" type="text" value="" autofocus>
					<i class="fa fa-search" aria-hidden="true"></i>
				</form>
			</div>';
		}
		echo $html;
	}

	public function search_popup_include()
	{
		include('partials/thetwo-ajax-search-public-display.php');
	}

	public function add_search_button($items, $args)
	{
		$settings = (object) get_option($this->thetwo_ajax_search . "-settings");
		if ($args->menu->name == $settings->append_menu) {
			if ($settings->remove_input == 1) {
				$items .= '<li>' . do_shortcode('[thetwo-ajax-search only_button=1]') . '</li>';
			} else {
				$items .= '<li>' . do_shortcode('[thetwo-ajax-search]') . '</li>';
			}
		}
		return $items;
	}
}
