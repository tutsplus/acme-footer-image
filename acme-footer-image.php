<?php
/**
 * Acme Footer Image
 *
 * Append a featured image at the bottom of the content of a post or page. Used as a demo
 * for a Tuts+ Code tutorial.
 *
 * @package   Acme_Footer_Image
 * @author    Tom McFarlin <tom@tommcfarlin.com>
 * @license   GPL-2.0+
 * @link      http://tommcfarlin.com
 * @copyright 2014 Tom McFarlin
 *
 * @wordpress-plugin
 * Plugin Name: Acme Footer Image
 * Plugin URI:  https://github.com/tutsplus/acme-footer-image
 * Description: Appends a featured image at the bottom of the content of a post or page.
 * Version:     0.2.0
 * Author:      Tom McFarlin
 * Author URI:  http://tommcfarlin.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Includes the core plugin class for executing the plugin.
 */
require_once( plugin_dir_path( __FILE__ ) . 'admin/class-acme-footer-image.php' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_acme_footer_image() {

	$plugin = new Acme_Footer_Image();
	$plugin->run();

}
run_acme_footer_image();
