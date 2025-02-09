<?php

// check for the WP_CLI class
if ( !class_exists( 'WP_CLI' ) ) {
    return;
}

class DMG_Read_More_Command {

    const DEFAULT_DATE_RANGE = '-30 days'; // date range to use if no dates passed as arguments

    const DEBUGGING = true; // turn on/off debugging

    /**
     * Search for posts containing the 'dmg/read-more-link' block within a given date range, or within the last 30 days if no dates are given.
     *
     * [--date-after=<date>]
     * : Start date (YYYY-MM-DD)
     *
     * [--date-before=<date>]
     * : End date (YYYY-MM-DD)
     *
     *
     * wp dmg-read-more search --date-after=2024-02-01 --date-before=2024-02-08
     * wp dmg-read-more search
     *
     * @param array $args
     * @param array $assoc_args
     */
    public function search( $args, $assoc_args ) {
        global $wpdb;

        // get the date range
        list($date_after, $date_before) = $this->getDateRange($assoc_args);

        // write to log
        WP_CLI::log( "Searching for posts with 'dmg/read-more-link' block between {$date_after} and {$date_before}..." );

        // get any posts with the read more link within the given date range from the database
        $query = $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} 
             WHERE post_type = 'post' 
             AND post_status = 'publish' 
             AND post_date BETWEEN %s AND %s 
             AND post_content LIKE %s",
            $date_after . ' 00:00:00',
            $date_before . ' 23:59:59',
            '%dmg/read-more-link%'
        );

        $results = $wpdb->get_col( $query );

        // check for results
        if ( empty( $results ) ) {
            WP_CLI::log( 'No posts found' . ( self::DEBUGGING ? ' with query = "' . $query .'"' : '' ) );
        } else {
            // loop through found posts
            foreach ( $results as $post_id ) {
                WP_CLI::log( $post_id ); // log each post ID
            }
        }
    }

    /**
     * Get the date range from the command line arguments or use the default date range.
     *
     * @param array $assoc_args
     * @return array
     */
    private function getDateRange($assoc_args) {
        $date_after = isset( $assoc_args['date-after'] ) ? $assoc_args['date-after'] : date('Y-m-d', strtotime( self::DEFAULT_DATE_RANGE ));     
        $date_before = isset( $assoc_args['date-before'] ) ? $assoc_args['date-before'] : date( 'Y-m-d' );

        // Sanitize and validate dates
        if (!strtotime($date_after) || !strtotime($date_before)) {
            WP_CLI::warning( "Invalid date format so using default" );
        }

        return array($date_after, $date_before);
    }
}

WP_CLI::add_command( 'dmg-read-more', 'DMG_Read_More_Command' );
