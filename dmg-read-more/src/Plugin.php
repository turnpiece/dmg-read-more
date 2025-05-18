<?php

namespace DMG\ReadMore;

class Plugin
{
    public static function init()
    {
        add_action('init', [self::class, 'create_block_read_more_link']);

        if (defined('WP_CLI') && WP_CLI) {
            \DMG\ReadMore\Cli_DMG_Read_More_Posts::register();
        }
    }

    /**
     * Registers the block using the metadata loaded from the `block.json` file.
     * Behind the scenes, it registers also all assets so they can be enqueued
     * through the block editor in the corresponding context.
     *
     * @see https://developer.wordpress.org/reference/functions/register_block_type/
     */
    public static function create_block_read_more_link()
    {
        register_block_type(plugin_dir_path(__DIR__) . 'read-more-link/build');
    }
}
