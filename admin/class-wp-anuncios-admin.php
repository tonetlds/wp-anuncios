<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://lucianotonet.com
 * @since      1.0.0
 *
 * @package    Wp_Anuncios
 * @subpackage Wp_Anuncios/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Anuncios
 * @subpackage Wp_Anuncios/admin
 * @author     Luciano <tonetlds@gmail.com>
 */
class Wp_Anuncios_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Wp_Anuncios_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Anuncios_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-anuncios-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Anuncios_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Anuncios_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-anuncios-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function register_cpt()
	{
		/**
		 * POST TYPE SERVIÇO
		 */
		$labels = array(
			'name'                  => _x( 'Anúncios', 'Post Type General Name', 'wp_anuncios' ),
			'singular_name'         => _x( 'Anúncio', 'Post Type Singular Name', 'wp_anuncios' ),
			'menu_name'             => __( 'Anúncios', 'wp_anuncios' ),
			'name_admin_bar'        => __( 'Anúncios', 'wp_anuncios' ),
			'archives'              => __( 'Arquivo', 'wp_anuncios' ),
			'parent_item_colon'     => __( 'Anúncio pai:', 'wp_anuncios' ),
			'all_items'             => __( 'Todos itens', 'wp_anuncios' ),
			'add_new_item'          => __( 'Adicionar novo anúncio', 'wp_anuncios' ),
			'add_new'               => __( 'Adicionar novo', 'wp_anuncios' ),
			'new_item'              => __( 'Novo anúncio', 'wp_anuncios' ),
			'edit_item'             => __( 'Editar anúncio', 'wp_anuncios' ),
			'update_item'           => __( 'Atualizar anúncio', 'wp_anuncios' ),
			'view_item'             => __( 'Ver item', 'wp_anuncios' ),
			'search_items'          => __( 'Procurar item', 'wp_anuncios' ),
			'not_found'             => __( 'Nada encontrado', 'wp_anuncios' ),
			'not_found_in_trash'    => __( 'Nada econtrado na lixeira', 'wp_anuncios' ),
			'featured_image'        => __( 'Imagem em destaque', 'wp_anuncios' ),
			'set_featured_image'    => __( 'Selecione a imagem em destaque', 'wp_anuncios' ),
			'remove_featured_image' => __( 'Remover imagem em destaque', 'wp_anuncios' ),
			'use_featured_image'    => __( 'Usar como imagem em destaque', 'wp_anuncios' ),
			'insert_into_item'      => __( 'Inserir no anúncio', 'wp_anuncios' ),
			'uploaded_to_this_item' => __( 'Enviado para este item', 'wp_anuncios' ),
			'items_list'            => __( 'Lista de anúncios', 'wp_anuncios' ),
			'items_list_navigation' => __( 'Lista de anúncios', 'wp_anuncios' ),
			'filter_items_list'     => __( 'Filtrar lista de anúncios', 'wp_anuncios' ),
		);
		$rewrite = array(
			'slug'                  => 'anuncios',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Anúncio', 'wp_anuncios' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'revisions' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',

	        'show_in_rest'          => true,
	        'rest_base'             => 'advertising',
	        'rest_controller_class' => 'WP_REST_Posts_Controller',
		);
		register_post_type( 'advertising', $args );		
	}

		
	public function anuncios_meta_boxes( $meta_boxes ) {
		    
		    $prefix = 'anuncio_';

		    $section = 'image_';

		    $meta_boxes[] = array(
				'title'  => __( 'Link' ),
				'post_types' => 'advertising',						
				'fields' => array(
					array(
						'name' => __( 'URL', 'wp-anuncios' ),
						'id'   => $prefix.'url',
						'type' => 'text',
					)					
				)				
			);    		    

		    $meta_boxes[] = array(
		        'title'      => __( 'Imagens', 'wp-anuncios' ),
		        'post_types' => 'advertising',		        
		        'fields'     => 
		        array(        		                
	                array(
	                    'id'               => $prefix.$section.'desktop',
	                    'name'             => __( 'Desktop', 'wp-anuncios' ),
	                    'type'             => 'image_advanced',
	                    // Delete image from Media Library when remove it from post meta?
	                    // Note: it might affect other posts if you use same image for multiple posts
	                    'force_delete'     => false,
	                    // Maximum image uploads
	                    'max_file_uploads' => 1,
	                ),
	                array(
	                    'id'               => $prefix.$section.'tablet',
	                    'name'             => __( 'Tablet', 'wp-anuncios' ),
	                    'type'             => 'image_advanced',
	                    // Delete image from Media Library when remove it from post meta?
	                    // Note: it might affect other posts if you use same image for multiple posts
	                    'force_delete'     => false,
	                    // Maximum image uploads
	                    'max_file_uploads' => 1,
	                ),
	                array(
	                    'id'               => $prefix.$section.'mobile',
	                    'name'             => __( 'Celular', 'wp-anuncios' ),
	                    'type'             => 'image_advanced',
	                    // Delete image from Media Library when remove it from post meta?
	                    // Note: it might affect other posts if you use same image for multiple posts
	                    'force_delete'     => false,
	                    // Maximum image uploads
	                    'max_file_uploads' => 1,
	                ),
	            ),
		    );  

		    return $meta_boxes;		

	}


	public function anuncios_widget(){
	
		register_widget( 'Anuncio_Widget' );

	} 

}
