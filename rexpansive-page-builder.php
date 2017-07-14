<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://rexpansive.neweb.info/
 * @since             1.0.0
 * @package           Rexpansive_Builder_Test
 *
 * @wordpress-plugin
 * Plugin Name:       Rexpansive Builder Test
 * Plugin URI:        http://rexpansive.neweb.info/
 * Description:       The new and awesome plugin to build a page in 1 minute! Expand your mind! This is a test version!
 * Version:           1.0.10
 * Author:            NEWEB di Simone Forgiarini
 * Author URI:        http://www.neweb.info/
 * Text Domain:       rexpansive-builder-test
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rexpansive-builder-test-activator.php
 */
function activate_rexpansive_builder_test() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rexpansive-builder-test-activator.php';
	Rexpansive_Builder_Test_Activator::activate( 'rexpansive-builder-test' );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rexpansive-builder-test-deactivator.php
 */
function deactivate_rexpansive_builder_test() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rexpansive-builder-test-deactivator.php';
	Rexpansive_Builder_Test_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rexpansive_builder_test' );
register_deactivation_hook( __FILE__, 'deactivate_rexpansive_builder_test' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rexpansive-builder-test.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_rexpansive_builder_test() {

	$plugin = new Rexpansive_Builder_Test();
	$plugin->run();

}
run_rexpansive_builder_test();
