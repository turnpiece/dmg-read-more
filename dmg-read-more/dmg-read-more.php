<?php

/**
 * Plugin Name:     DMG Read More
 * Plugin URI:      https://github.com/turnpiece/dmg-read-more
 * Description:     Exercise for dmg::media
 * Author:          Paul Jenkins
 * Author URI:      https://github.com/turnpiece/
 * Text Domain:     dmg-read-more
 * Domain Path:     /languages
 * Version:         0.1.1
 *
 * @package         Dmg_Read_More
 */

require_once __DIR__ . '/vendor/autoload.php';

use DMG\ReadMore\Plugin;

add_action('init', [Plugin::class, 'init']);
