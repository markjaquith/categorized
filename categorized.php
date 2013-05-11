<?php
/*
Plugin Name: Categorized
Description: Unchecks the default post category when you select a non-default category
Version: 1.0
License: GPL
Plugin URI: http://wordpress.org/extend/plugins/uncategorized/
Author: Mark Jaquith
Author URI: http://coveredwebservices.com/
Text Domain: uncategorized

==========================================================================

Copyright 2013  Mark Jaquith

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class CWS_Categorized_Plugin {
	public static $instance;

	public function __construct() {
		self::$instance = $this;
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	public function plugins_loaded() {
		if ( is_admin() )
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function enqueue_scripts() {
		if ( get_current_screen() && in_array( get_current_screen()->id, array( 'post', 'edit-post' ) ) ) {
			add_action( 'admin_head', array( $this, 'admin_head' ) );
			wp_enqueue_script( 'cws-categorized', plugins_url( "js/categorized.js", __FILE__ ), array( 'jquery' ), '20130511', true );
		}
	}

	public function admin_head() {
		?><script>var cwsCategorizedDefault = '<?php echo absint( get_option( 'default_category' ) ); ?>';</script><?php
	}
}

new CWS_Categorized_Plugin;
