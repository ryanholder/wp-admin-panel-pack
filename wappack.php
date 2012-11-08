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

class WordPressAdminPanelPack {
	 
	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	
	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		load_plugin_textdomain( 'wappack', false, WAP_PACK_DIR . '/assets/languages' );
		
		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( $this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
	
		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );

		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		
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

        /*
         * This adds to the admin screen help panel listing all page hooks
         */
        add_action( 'contextual_help', array( $this, 'wptuts_screen_help' ), 10, 3 );

	    add_action( 'admin_head', array( $this, 'wappack_admin_head' ) );

        add_action( 'admin_menu', array( $this, 'wappack_disable_default_dashboard_widgets' ) );

	} // end constructor
	
	/**
	 * Fired when the plugin is activated.
	 *
	 * @params	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog 
	 */
	public function activate( $network_wide ) {

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
	
	/**
 	 * Note:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *		  WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *		  Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 */


    /*
     * This function is in place during development and must be removed
     * TODO Remove Screen Help Function
     */
    function wptuts_screen_help( $contextual_help, $screen_id, $screen ) {
        // The add_help_tab function for screen was introduced in WordPress 3.3.
        if ( ! method_exists( $screen, 'add_help_tab' ) )
            return $contextual_help;
        global $hook_suffix;
        // List screen properties
        $variables = '<ul style="width:50%;float:left;"> <strong>Screen variables </strong>'
            . sprintf( '<li> Screen id : %s</li>', $screen_id )
            . sprintf( '<li> Screen base : %s</li>', $screen->base )
            . sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
            . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
            . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
            . '</ul>';
        // Append global $hook_suffix to the hook stems
        $hooks = array(
            "load-$hook_suffix",
            "admin_print_styles-$hook_suffix",
            "admin_print_scripts-$hook_suffix",
            "admin_head-$hook_suffix",
            "admin_footer-$hook_suffix"
        );
        // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
        if ( did_action( 'add_meta_boxes_' . $screen_id ) )
            $hooks[] = 'add_meta_boxes_' . $screen_id;
        if ( did_action( 'add_meta_boxes' ) )
            $hooks[] = 'add_meta_boxes';
        // Get List HTML for the hooks
        $hooks = '<ul style="width:50%;float:left;"> <strong>Hooks </strong> <li>' . implode( '</li><li>', $hooks ) . '</li></ul>';
        // Combine $variables list with $hooks list.
        $help_content = $variables . $hooks;
        // Add help panel
        $screen->add_help_tab( array(
            'id'      => 'wptuts-screen-help',
            'title'   => 'Screen Information',
            'content' => $help_content,
        ));
        return $contextual_help;
    }

	function wappack_admin_head() {
    	// TODO define your action method here
	} // end action_method_name

    function wappack_disable_default_dashboard_widgets() {
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'core' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'core' );
    }

} // end class

new WordPressAdminPanelPack();