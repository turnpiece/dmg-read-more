<?php

namespace DMG\ReadMore\Tests;

use WP_UnitTestCase;
use WP_Block_Type_Registry;
use DMG\ReadMore\Cli_DMG_Read_More_Posts;

class ReadMoreTest extends WP_UnitTestCase
{

    public function test_plugin_class_exists()
    {
        $this->assertTrue(class_exists(\DMG\ReadMore\Plugin::class));
    }

    public function test_cli_class_exists()
    {
        $this->assertTrue(class_exists(\DMG\ReadMore\Cli_DMG_Read_More_Posts::class));
    }

    public function test_block_is_registered()
    {
        $this->assertTrue(
            WP_Block_Type_Registry::get_instance()->is_registered('dmg/read-more-link')
        );
    }

    public function test_cli_logic_finds_post_with_block()
    {
        $post_id = $this->factory->post->create([
            'post_date'    => '2024-05-01 12:00:00',
            'post_content' => '<!-- wp:dmg/read-more-link /-->',
            'post_status'  => 'publish',
        ]);

        $found = Cli_DMG_Read_More_Posts::get_post_ids_with_read_more_block(
            '2024-01-01',
            '2025-01-01',
            false
        );

        $this->assertContains($post_id, $found);
    }
}
