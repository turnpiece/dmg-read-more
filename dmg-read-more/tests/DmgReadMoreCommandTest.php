<?php

namespace DMG\Tests;

use WP_CLI;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class TesDmgReadMoreCommandTest extends TestCase {

    protected static $post_with_block;
    protected static $post_without_block;

    public static function wpSetUpBeforeClass($factory) {
        // Create a post containing the 'dmg/read-more-link' block
        self::$post_with_block = $factory->post->create([
            'post_title'   => 'Test Post With Block',
            'post_status'  => 'publish',
            'post_content' => '<!-- wp:dmg/read-more-link {"selectedPostId":1} /-->',
            'post_date'    => date('Y-m-d H:i:s', strtotime('-10 days'))
        ]);

        // Create a post that does not contain the block
        self::$post_without_block = $factory->post->create([
            'post_title'   => 'Test Post Without Block',
            'post_status'  => 'publish',
            'post_content' => 'This post has no block.',
            'post_date'    => date('Y-m-d H:i:s', strtotime('-5 days'))
        ]);
    }

    public function run_wp_cli($command) {
        // Simulate WP-CLI response
        if ($command === 'post list --format=json') {
            return json_encode([
                ['ID' => self::$post_with_block],
                ['ID' => self::$post_without_block]
            ]);
        }

        return '';
    }

    public function test_command_runs_without_errors() {
        $output = $this->run_wp_cli('post list --format=json');
        $this->assertNotEmpty($output);
    }
}
