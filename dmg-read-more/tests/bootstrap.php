<?php

// Load the PHPUnit Polyfills
require_once dirname(__DIR__) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

// Continue with loading the WordPress test environment.
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
    $_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

require_once "{$_tests_dir}/includes/functions.php";
require_once "{$_tests_dir}/includes/bootstrap.php";
