<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.neweb.info/
 * @since      1.0.0
 *
 * @package    Rexpansive_Builder_Test
 * @subpackage Rexpansive_Builder_Test/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Rexpansive_Builder_Test
 * @subpackage Rexpansive_Builder_Test/includes
 * @author     http://rexpansive.neweb.info/ <info@neweb.info>
 */
class Rexpansive_Builder_Test_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rexpansive-builder-test',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
