<?php

namespace DMG\ReadMore;

use WP_CLI;

class Cli_DMG_Read_More_Posts
{

    const BLOCK_NAME = 'dmg/read-more-link';
    const DEFAULT_DATE_RANGE = '-30 days'; // date range to use if no dates passed as arguments

    public static function register(): void
    {
        WP_CLI::add_command('dmg-read-more', self::class);
    }

    /**
     * Search for posts containing the 'dmg/read-more-link' block within a given date range, or within the last 30 days if no dates are given.
     *
     * [--date-after=<date>]
     * : Start date (YYYY-MM-DD)
     *
     * [--date-before=<date>]
     * : End date (YYYY-MM-DD)
     *
     * [--double-check=<true|false>]
     * : Whether to confirm block presence using parse_blocks. Default: true.
     *
     * wp dmg-read-more search --date-after=2024-02-01 --date-before=2024-02-08
     * wp dmg-read-more search
     *
     * @param array $args
     * @param array $assoc_args
     */
    public function search(array $args, array $assoc_args): void
    {
        $date_after  = $assoc_args['date-after'] ?? date('Y-m-d', strtotime(self::DEFAULT_DATE_RANGE));
        $date_before = $assoc_args['date-before'] ?? date('Y-m-d');
        $double_check = isset($assoc_args['double-check']) ? filter_var($assoc_args['double-check'], FILTER_VALIDATE_BOOLEAN) : true;

        $posts = self::get_post_ids_with_read_more_block($date_after, $date_before, $double_check);

        if (empty($posts)) {
            WP_CLI::log("No posts found.");
            return;
        }

        foreach ($posts as $post_id) {
            WP_CLI::log($post_id);
        }
    }

    /**
     * Get post IDs with the 'dmg/read-more-link' block within a given date range.
     *
     * @param string $date_after
     * @param string $date_before
     * @param bool $double_check
     * @return array
     */
    public static function get_post_ids_with_read_more_block(string $date_after, string $date_before, bool $double_check = true): array
    {
        global $wpdb;
        $batch_size = 1000;
        $offset = 0;
        $matching_ids = [];

        do {
            $query = $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts}
                 WHERE post_type = 'post'
                 AND post_status = 'publish'
                 AND post_date BETWEEN %s AND %s
                 AND post_content LIKE %s
                 LIMIT %d OFFSET %d",
                $date_after . ' 00:00:00',
                $date_before . ' 23:59:59',
                '%' . $wpdb->esc_like(self::BLOCK_NAME) . '%',
                $batch_size,
                $offset
            );

            $results = $wpdb->get_col($query);

            if (empty($results)) {
                break;
            }

            foreach ($results as $post_id) {
                if ($double_check) {
                    $blocks = parse_blocks(get_post_field('post_content', $post_id));
                    if (!self::contains_block($blocks)) {
                        continue;
                    }
                }
                $matching_ids[] = $post_id;
            }

            $offset += $batch_size;
        } while (count($results) === $batch_size);

        return $matching_ids;
    }

    /**
     * Check if the given blocks contain the block we're looking for
     *
     * @param array $blocks
     * @return bool
     */
    private static function contains_block(array $blocks): bool
    {
        foreach ($blocks as $block) {
            if ($block['blockName'] === self::BLOCK_NAME) {
                return true;
            }
            if (!empty($block['innerBlocks']) && self::contains_block($block['innerBlocks'])) {
                return true;
            }
        }
        return false;
    }
}
