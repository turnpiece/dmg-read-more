<?php

namespace DMG\ReadMore;

use WP_CLI;

class Cli_DMG_Read_More_Posts
{
    const DEFAULT_DATE_RANGE = '-30 days'; // date range to use if no dates passed as arguments

    const DEBUGGING = false; // turn on/off debugging

    const BLOCK_NAME = 'dmg/read-more-link'; // the name of the block we're looking for

    const DOUBLE_CHECK = true; // double checks the found block name actually is a block - adds load so may need to be set to false for large datasets, though passing --double-check=false to the cli command would do this as well

    // Register the CLI command
    public static function register()
    {
        \WP_CLI::add_command('dmg-read-more', self::class);
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
    public function search(array $args, array $assoc_args)
    {
        global $wpdb;

        // get the date range
        list($date_after, $date_before) = $this->get_date_range($assoc_args);

        // set double checking parameter
        $double_check = isset($assoc_args['double-check']) ? filter_var($assoc_args['double-check'], FILTER_VALIDATE_BOOLEAN) : self::DOUBLE_CHECK;

        if (self::DEBUGGING) {
            // write to log
            WP_CLI::log("Searching for posts with '" . self::BLOCK_NAME . "' block between {$date_after} and {$date_before}...");
        }

        // process query in batches
        $batch_size = 1000;
        $offset = 0;
        $total_found = 0;

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

            // get the posts with the block we're looking for
            $results = $wpdb->get_col($query);

            if (empty($results)) {
                break;
            }

            // loop through found posts
            foreach ($results as $post_id) {
                if ($double_check) {
                    // double check that the post actually contains the block we're looking for
                    // and not just text that matches the name of the block
                    $content = get_post_field('post_content', $post_id);
                    $blocks = parse_blocks($content);
                    if (empty($blocks) || !self::contains_block($blocks)) {
                        if (self::DEBUGGING) {
                            WP_CLI::log("Skipping post {$post_id} as it does not contain the block we're looking for.");
                        }
                        continue;
                    }
                }

                WP_CLI::log((string) $post_id);
                $total_found++;
            }

            $offset += $batch_size;
        } while (count($results) === $batch_size);

        if (self::DEBUGGING) {
            // write to log
            WP_CLI::log("Done. Found {$total_found} posts.");
        }
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

            // also check inner blocks
            if (! empty($block['innerBlocks']) && self::contains_block($block['innerBlocks'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the date range from the command line arguments or use the default date range.
     *
     * @param array $assoc_args
     * @return array
     */
    private function get_date_range(array $assoc_args): array
    {
        $date_after = isset($assoc_args['date-after']) ? $assoc_args['date-after'] : date('Y-m-d', strtotime(self::DEFAULT_DATE_RANGE));
        $date_before = isset($assoc_args['date-before']) ? $assoc_args['date-before'] : date('Y-m-d');

        // Sanitize and validate dates
        if (!strtotime($date_after) || !strtotime($date_before)) {
            WP_CLI::warning("Invalid date format so using default");
        }

        return array($date_after, $date_before);
    }
}
