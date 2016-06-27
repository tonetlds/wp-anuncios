<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://lucianotonet.com
 * @since      1.0.0
 *
 * @package    Wp_Anuncios
 * @subpackage Wp_Anuncios/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Anuncios
 * @subpackage Wp_Anuncios/includes
 * @author     Luciano <tonetlds@gmail.com>
 */
class Wp_Anuncios {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Anuncios_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-anuncios';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		// Remove issues with prefetching adding extra views
		remove_action( 'wp_head', [$this, 'adjacent_posts_rel_link_wp_head'], 10, 0);
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Anuncios_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Anuncios_i18n. Defines internationalization functionality.
	 * - Wp_Anuncios_Admin. Defines all hooks for the admin area.
	 * - Wp_Anuncios_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-anuncios-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-anuncios-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-anuncios-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-anuncios-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-anuncios-widget.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-anuncios-statistics-field.php';

		$this->loader = new Wp_Anuncios_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Anuncios_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Anuncios_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Anuncios_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt' );
		$this->loader->add_action( 'init', $this, 'anuncio_session_start' );

		$this->loader->add_filter( 'rwmb_meta_boxes', $plugin_admin, 'anuncios_meta_boxes' );
		$this->loader->add_filter( 'widgets_init', $plugin_admin, 'anuncios_widget' );		

		add_action( 'widgets_init', function(){
		    register_widget( 'Anuncio_Widget' );     	    
		});	


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Anuncios_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Anuncios_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function getAnuncioViews($postID){
	    return get_post_meta($postID, 'anuncio_views', true) ? get_post_meta($postID, 'anuncio_views', true) : 0;	    
	}
	
	public function setAnuncioViews($postID) {	    
	    $count = get_post_meta($postID, 'anuncio_views', true) ? get_post_meta($postID, 'anuncio_views', true) : 0;
	    $count = $count + 1;	    
	    update_post_meta($postID, 'anuncio_views', $count);	    
	}

	public function setAnuncioSessions($postID) {	 
	    
	    $sessionID 	 = session_id();	    

	    if( !isset($_SESSION[ $sessionID ]) ) {
	    	$_SESSION[ $sessionID ] = Array();
	    }
		    
	    if( !isset($_SESSION[ $sessionID ][ $postID ] )  ){
	    	$_SESSION[ $sessionID ][ $postID ] = 0;

		    $count = get_post_meta($postID, 'anuncio_sessions', true) ? get_post_meta($postID, 'anuncio_sessions', true) : 0;
		    $count = $count + 1;
		    update_post_meta($postID, 'anuncio_sessions', $count);

	    }else{
	    	$_SESSION[ $sessionID ][ $postID ] = $_SESSION[ $sessionID ][ $postID ] + 1;    			    
	    }	   

	}

	public function getAnuncioSessions($postID){
	    return get_post_meta($postID, 'anuncio_sessions', true) ? get_post_meta($postID, 'anuncio_sessions', true) : 0;	    
	}
	

	public function getAnuncioClicks($postID){
	    $count_key = 'anuncio_clicks';
	    return get_post_meta($postID, $count_key, true) ? get_post_meta($postID, $count_key, true) : 0;
	}
	
	public function setAnuncioClicks($postID) {
	    $count_key = 'anuncio_clicks';
	    $count = get_post_meta($postID, $count_key, true) ? get_post_meta($postID, $count_key, true) : 0;
	    if($count==''){	        
	        delete_post_meta($postID, $count_key);
	        add_post_meta($postID, $count_key, 0);
	    }else{
	        $count++;
	        update_post_meta($postID, $count_key, $count);
	    }
	}

	public function anuncio_session_start() {	
	    if(!session_id()) {
	        session_start();
	    }			  
	}

}
