<?php

// Load the PHPUnit Polyfills
require_once dirname(__DIR__) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';
/*
// Load the PHPUnit Polyfills.
if ( file_exists( dirname( __DIR__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __DIR__ ) . '/vendor/autoload.php';
} elseif ( getenv( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' ) ) {
    require_once getenv( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' );
} else {
    echo "PHPUnit Polyfills library not found. Please install it.\n";
    exit( 1 );
}
*/
// Continue with loading the WordPress test environment.
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
    $_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

require_once "{$_tests_dir}/includes/functions.php";
require_once "{$_tests_dir}/includes/bootstrap.php";
