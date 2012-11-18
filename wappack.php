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
define( 'WAP_PACK_URL', plugin_dir_url( __FILE__ ));
define( 'WAP_PACK_VERSION', "0.1");

require_once WAP_PACK_DIR . '/debug/admin-screen-information.php';

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
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
        register_uninstall_hook( __FILE__, array( $this, 'uninstall' ) );
		
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

        add_action( 'wp_before_admin_bar_render', array( $this, 'wappack_admin_bar_render' ) );

        add_action( 'admin_menu', array( $this, 'wappack_disable_admin_menu_items' ) );

        add_action( 'admin_bar_menu', array( $this, 'wappack_admin_bar_custom_account_menu' ) );

        add_filter( 'admin_body_class' , array( $this, 'wappack_add_admin_body_class' ) );

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {
        // TODO define activation functionality here
    } // end activate
	
	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here		
	} // end deactivate

    /**
   	 * Fired when the plugin is uninstalled.
   	 *
   	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
   	 */
   	public function uninstall( $network_wide ) {
   		// TODO define uninstall functionality here
   	} // end uninstall

    /**
     * Loads the plugin text domain for translation
     */
    public function textdomain() {

        load_plugin_textdomain( 'wappack', false, WAP_PACK_DIR . '/assets/languages' );

    }

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		wp_enqueue_style( 'wappack-admin-styles', WAP_PACK_URL .  'assets/stylesheets/admin.css' );
	
	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */	
	public function register_admin_scripts() {

		wp_enqueue_script( 'wappack-admin-scripts', WAP_PACK_URL . 'assets/javascripts/admin.js' );
	
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


    /** Removing menu options from the Admin Bar
     * TODO I may want to remove the loading of styles and scipts for admin bar in favor of my own - (see line 36-53 of class-wp-admin-bar.php)
     *
     */
    function wappack_admin_bar_render() {

        global $wp_admin_bar;

//        $wp_admin_bar->remove_menu( 'wp-logo' );
        $wp_admin_bar->remove_menu( 'comments' );
        $wp_admin_bar->remove_menu( 'new-content' );

        /**
         * Remove the sub menu items from the site-name menu
         */
        $wp_admin_bar->remove_menu( 'appearance' );
        $wp_admin_bar->remove_menu( 'dashboard' );
        $wp_admin_bar->remove_menu( 'edit-site' );
//        $wp_admin_bar->remove_menu('view-site');

    } // end wappack_admin_bar_render

    function wappack_disable_admin_menu_items() {

        remove_menu_page( 'separator1' );
        remove_menu_page( 'separator2' );
        remove_menu_page( 'separator-last' );

    } // end wappack_disable_admin_menu_items

    function wappack_add_admin_body_class( $classes ) {

        $classes .= ' wappack-admin';
        return $classes;

   	} // end wappack_add_admin_body_class

    function wappack_admin_bar_custom_account_menu( $wp_admin_bar ) {

        $user_id      = get_current_user_id();
       	$current_user = wp_get_current_user();
       	$profile_url  = get_edit_profile_url( $user_id );

       	if ( ! $user_id )
       		return;

       	$avatar = get_avatar( $user_id, 28 );
       	$user_display_name  = sprintf( __('%1$s'), $current_user->display_name );
       	$class  = empty( $avatar ) ? '' : 'with-avatar';

       	$wp_admin_bar->add_menu( array(
       		'id'        => 'my-account',
       		'parent'    => 'top-secondary',
       		'title'     => $avatar . $user_display_name,
       		'href'      => $profile_url,
       		'meta'      => array(
       			'class'     => $class,
       			'title'     => __('My Account'),
       		),
       	) );

    }

} // end class

$plugin_name = new WordPressAdminPanelPack();