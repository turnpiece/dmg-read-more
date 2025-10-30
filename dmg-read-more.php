<?php

/**
 * Plugin Name:     DMG Read More
 * Plugin URI:      https://github.com/turnpiece/dmg-read-more
 * Description:     Exercise for dmg::media
 * Author:          Paul Jenkins
 * Author URI:      https://github.com/turnpiece/
 * Text Domain:     dmg-read-more
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Dmg_Read_More
 */

require_once __DIR__ . '/vendor/autoload.php';

use DMG\ReadMore\Plugin;

// initialise plugin with CLI commands
add_action('init', [Plugin::class, 'init']);

// Register the block
add_action('init', [Plugin::class, 'create_block_read_more_link']);
