<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://lucianotonet.com
 * @since             1.0.0
 * @package           Wp_Anuncios
 *
 * @wordpress-plugin
 * Plugin Name:       WP Anúncios
 * Plugin URI:        https://github.com/tonetlds/wp-anuncios
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Luciano T.
 * Author URI:        http://lucianotonet.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-anuncios
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/tonetlds/wp-anuncios
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-anuncios-activator.php
 */
function activate_wp_anuncios() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-anuncios-activator.php';
	Wp_Anuncios_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-anuncios-deactivator.php
 */
function deactivate_wp_anuncios() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-anuncios-deactivator.php';
	Wp_Anuncios_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_anuncios' );
register_deactivation_hook( __FILE__, 'deactivate_wp_anuncios' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-anuncios.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_anuncios() {

	$plugin = new Wp_Anuncios();
	$plugin->run();

}
run_wp_anuncios();
