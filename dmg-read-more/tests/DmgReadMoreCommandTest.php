<?php

namespace DMG\Tests;

use WP_CLI;
use WP_UnitTestCase;

// PHPUnit tests
class TesDmgReadMoreCommandTest extends WP_UnitTestCase {

    protected static $post_with_block;
    protected static $post_without_block;

    public static function wpSetUpBeforeClass( $factory ) {
        // Create a post containing the 'dmg/read-more-link' block
        self::$post_with_block = $factory->post->create([
            'post_title' => 'Test Post With Block',
            'post_status' => 'publish',
            'post_content' => '<!-- wp:dmg/read-more-link {"selectedPostId":1} /-->',
            'post_date' => date('Y-m-d H:i:s', strtotime('-10 days'))
        ]);

        // Create a post that does not contain the block
        self::$post_without_block = $factory->post->create([
            'post_title' => 'Test Post Without Block',
            'post_status' => 'publish',
            'post_content' => 'This post has no block.',
            'post_date' => date('Y-m-d H:i:s', strtotime('-10 days'))
        ]);
    }

    public function test_command_runs_without_errors() {
        $result = $this->run_wp_cli( 'dmg-read-more search' );
        $this->assertNotEmpty( $result, 'Command should return output.' );
    }

    public function test_command_finds_posts_with_block() {
        $result = $this->run_wp_cli( 'dmg-read-more search --date-after=2024-01-01 --date-before=2024-12-31' );
        $this->assertStringContainsString( (string) self::$post_with_block, $result, 'Should find the post containing the block.' );
    }

    public function test_command_returns_no_results_for_missing_block() {
        $result = $this->run_wp_cli( 'dmg-read-more search --date-after=2023-01-01 --date-before=2023-12-31' );
        $this->assertStringContainsString( 'No posts found', $result, 'Should return no results if no posts match.' );
    }
}
