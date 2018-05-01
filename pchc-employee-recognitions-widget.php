<?php
/**
 * Plugin Name:        PCHC Employee Recognitions Widget
 * Plugin URI:         https://www.github.com/pchc/employee-recognitions-widget
 * Description:        WordPress widget to display recent recipients of employee recognitions
 * Version:            0.1.0
 * Author:             Chris Violette
 * Author URI:         https://pixleight.com
 *
 * License:            GNU General Public License, version 2
 * License URI:        http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package    PCHC_Employee_Recognitions
 * @since      0.1
 * @author     Chris Violette
 * @copyright  Copyright (c) 2018, PCHC
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 */

namespace PCHC;

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

class EmployeeRecognitions {
  public function __construct() {
    // Defines constants used by the plugin.

    // Set constant path to the plugin directory.
		define( 'PCHCER_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		// Set the constant path to the plugin directory URI.
		define( 'PCHCER_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

		// Set the constant path to the includes directory.
		define( 'PCHCER_INCLUDES', PCHCER_DIR . trailingslashit( 'includes' ) );

		// Set the constant path to the includes directory.
		define( 'PCHCER_CLASS', PCHCER_DIR . trailingslashit( 'classes' ) );

		// Set the constant path to the assets directory.
		define( 'PCHCER_ASSETS', PCHCER_URI . trailingslashit( 'assets' ) );

		//add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

    // Register widget.
		add_action( 'widgets_init', array( &$this, 'register_widget' ) );

    // Load the functions files.
		add_action( 'init', array( &$this, 'includes' ), 1 );
  }

  /**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since  0.1
	 */
	public function includes() {
		require_once( PCHCER_INCLUDES . 'functions.php' );
	}

  /**
	 * Register the widget.
	 *
	 * @since  0.1
	 */
	public function register_widget() {
		require_once( PCHCER_CLASS . 'widget.php' );
		register_widget( 'pchc_employee_recognitions' );
	}
}

new EmployeeRecognitions;
