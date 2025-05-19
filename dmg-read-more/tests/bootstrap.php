<?php

define('WP_RUNNING_UNIT_TESTS', true);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('WP_DISABLE_FATAL_ERROR_HANDLER', true);

$_tests_dir = getenv('WP_TESTS_DIR');

if (! $_tests_dir) {
	echo "Error: WP_TESTS_DIR is not set.\n";
	exit(1);
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin()
{
	require dirname(__DIR__) . '/vendor/autoload.php';
	\DMG\ReadMore\Plugin::init();
}
tests_add_filter('muplugins_loaded', '_manually_load_plugin');

require $_tests_dir . '/includes/bootstrap.php';
