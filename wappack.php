<?php
/*

Plugin Name: WordPress Admin Panel Pack
Plugin URI: http://github.com/...
Description: Admin panel pack for WordPress
Author: Ryan Holder
Version: 0.1
Author URI: http://ryanholder.com/

License: GPLv2 ->

  Copyright 2012 Ryan Holder (ryan@ryanholder.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

define( 'WAP_PACK_DIR', dirname( __FILE__ ) );
define( 'WAP_PACK_URL', plugin_dir_url( __FILE__ ) );
define( 'WAP_PACK_VERSION', "0.1" );

//require_once WAP_PACK_DIR . '/debug/admin-screen-information.php';

class WordPressAdminPanelPack {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		// load plugin text domain
		add_action( 'init', array( $this, 'textdomain' ) );

		// Deregister admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'deregister_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'deregister_admin_scripts' ) );

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, 'WordPressAdminPanelPack::uninstall' );

		/*
		 * Define the custom functionality for your plugin. The first parameter of the
		 * add_action/add_filter calls are the hooks into which your code should fire.
		 *
		 * The second parameter is the function name located within this class. See the stubs
		 * later in the file.
		 *
		 * For more information:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */

		add_action( 'admin_head', array( $this, 'wappack_admin_head' ) );

		add_action( 'admin_menu', array( $this, 'wappack_disable_admin_menu_items' ) );

		add_action( 'admin_bar_menu', array( $this, 'wappack_admin_bar_custom_account_menu' ) );

		add_filter( 'admin_body_class', array( $this, 'wappack_add_admin_body_class' ) );

		add_filter( 'wp_admin_bar_class', array( $this, 'wappack_custom_admin_bar_class' ) );

	} // end constructor

	/**
	 * Fired when the plugin is activated.
	 *
	 * @params    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @params    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here		
	} // end deactivate

	/**
	 * Fired when the plugin is uninstalled.
	 *
	 * @params    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public static function uninstall( $network_wide ) {
		// TODO define uninstall functionality here
	} // end uninstall

	/**
	 * Loads the plugin text domain for translation
	 */
	public function textdomain() {

		load_plugin_textdomain( 'wappack', false, WAP_PACK_DIR . '/assets/languages' );

	}

	/**
	 * deregisters admin-specific styles.
	 */
	public function deregister_admin_styles() {
		wp_deregister_style( 'admin-bar' );
		wp_deregister_style( 'wp-admin' );
		wp_deregister_style( 'colors' );
		// TODO Use wp_admin_css_color to add my own color schemes @http://codex.wordpress.org/Function_Reference/wp_admin_css_color

	} // end deregister_admin_styles

	/**
	 * Deregisters admin-specific JavaScript.
	 */
	public function deregister_admin_scripts() {

		wp_deregister_script( 'admin-bar' );

	} // end deregister_admin_scripts

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

//		wp_enqueue_style( 'wappack-bootstrap', WAP_PACK_URL . 'vendor/bootstrap/css/bootstrap.css' );
//		wp_enqueue_style( 'wappack-wpadminbar', WAP_PACK_URL . 'assets/stylesheets/wappack-wpadminbar.css' );
//		wp_enqueue_style( 'wappack-wpadminbar-old', WAP_PACK_URL . 'assets/stylesheets/wappack-wpadminbar-old.css' );
//		wp_enqueue_style( 'wappack-admin', WAP_PACK_URL . 'assets/stylesheets/wappack-admin.css' );
//		wp_enqueue_style( 'wappack-admin-colors', WAP_PACK_URL . 'assets/stylesheets/wappack-admin-colors.css' );
//		wp_enqueue_style( 'wappack-adminmenu', WAP_PACK_URL . 'assets/stylesheets/wappack-adminmenu.css' );
		wp_enqueue_style( 'wappack', WAP_PACK_URL . 'assets/stylesheets/wappack.css' );


	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		wp_enqueue_script( 'wappack-bootstrap-scripts', WAP_PACK_URL . 'vendor/bootstrap/js/bootstrap.js', array( 'jquery' ) );
		wp_enqueue_script( 'wappack-custom-scripts', WAP_PACK_URL . 'assets/javascripts/wappack-admin.js', array( 'wappack-bootstrap-scripts' ) );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues plugin-specific styles.
	 */
	public function register_plugin_styles() {

		//wp_enqueue_style( 'wappack-plugin-styles', WAP_PACK_URL .  'assets/stylesheets/display.css' );

	} // end register_plugin_styles

	/**
	 * Registers and enqueues plugin-specific scripts.
	 */
	public function register_plugin_scripts() {

		//wp_enqueue_script( 'wappack-plugin-scripts', WAP_PACK_URL . 'assets/javascripts/display.js' );

	} // end register_plugin_scripts

	/*--------------------------------------------*
	 * Core Functions
	 *---------------------------------------------*/


	function wappack_admin_head() {

		// TODO define your action method here

	} // end wappack_admin_head

	function wappack_disable_admin_menu_items() {

		remove_menu_page( 'separator1' );
		remove_menu_page( 'separator2' );
		remove_menu_page( 'separator-last' );

	} // end wappack_disable_admin_menu_items

	function wappack_add_admin_body_class( $classes ) {

		$classes .= ' wappack-admin';
		return $classes;

	} // end wappack_add_admin_body_class

	function wappack_admin_bar_custom_account_menu() {

		global $wp_admin_bar;

		$user_id = get_current_user_id();
		$current_user = wp_get_current_user();
		$profile_url = get_edit_profile_url( $user_id );

		if ( !$user_id )
			return;

		$avatar = get_avatar( $user_id, 28 );
		$user_display_name = sprintf( __( '%1$s' ), $current_user->display_name );
		$class = empty( $avatar ) ? '' : 'with-avatar';

		$wp_admin_bar->add_menu( array(
			'id' => 'my-account',
			'parent' => 'top-secondary',
			'title' => $avatar . $user_display_name,
			'href' => $profile_url,
			'meta' => array(
				'class' => $class,
				'title' => __( 'My Account' ),
			),
		) );

	}

	function wappack_custom_admin_bar_class() {

		require_once WAP_PACK_DIR . '/wappack-class-wp-admin-bar.php';

		$admin_bar_class = 'WAPPACK_Admin_Bar';
		return $admin_bar_class;

	}

} // end class

$plugin_name = new WordPressAdminPanelPack();