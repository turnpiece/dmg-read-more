=== DMG Read More ===
Contributors: Paul Jenkins
Requires at least: 4.5
Tested up to: 6.7.1
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin with two different features: a Gutenberg block and a WP-CLI command.

== Description ==

= A Gutenberg Block =

Write a Gutenberg block using native WP React tools (no ACF or other plugin dependencies). This block should allow editors to search for and then choose a published post to insert into the editor as a stylized anchor link.

Editors should be able to search posts in the InspectorControls using a search string. It should paginate results. It should support searching for a specific post ID. Recent posts should be shown to choose from by default.

The anchor text should be the post title and the anchor href should be the post permalink. The anchor should be output within a paragraph element with a CSS class of `dmg-read-more` added to it. The anchor should be prepended with the words `Read More: `.

Choosing a new post should update the anchor link shown in the editor.

= A WP-CLI Command =

Create a custom WP-CLI command named like, `dmg-read-more search` This command will take optional date-range arguments like “date-before” and “date-after” If the dates are omitted, the command will default to the last 30 days.

The command will execute a WP_Query search for Posts within the date range looking for posts containing the aforementioned Gutenberg block. Performance is key, this WP-CLI command will be tested against a database that has tens of millions records in the wp_posts table.

The command will log to STDOUT all Post IDs for the matching results.

If no posts are found, or any other errors encountered, output a log message.