<?php
/**
 * Plugin Name:     DMG Read More
 * Plugin URI:      https://github.com/turnpiece/dmg-read-more
 * Description:     Exercise for dmg::media
 * Author:          Paul Jenkins
 * Author URI:      https://github.com/turnpiece/
 * Text Domain:     dmg-read-more
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Dmg_Read_More
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Version of plugin
define( 'DMG_READ_MORE_VERSION', '0.1.0' );

// Load Gutenberg block
require_once 'read-more-link/read-more-link.php';

// Load CLI command
require_once 'includes/cli-dmg-read-more-posts.php';
