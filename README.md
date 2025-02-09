# DMG Read More

A WordPress plugin with two different features: a Gutenberg block and a WP-CLI command.

## Contents

Includes the following files:

- `.gitignore`. Used to exclude certain files from the repository.
- `README.md`. The file that you’re currently reading.
- A `dmg-read-more` directory that contains the source code - the WordPress plugin.

## Features

### A Gutenberg Block

Write a Gutenberg block using native WP React tools (no ACF or other plugin dependencies). This block should allow editors to search for and then choose a published post to insert into the editor as a stylized anchor link.

Editors should be able to search posts in the InspectorControls using a search string. It should paginate results. It should support searching for a specific post ID. Recent posts should be shown to choose from by default.

The anchor text should be the post title and the anchor href should be the post permalink. The anchor should be output within a paragraph element with a CSS class of `dmg-read-more` added to it. The anchor should be prepended with the words `Read More: `.

Choosing a new post should update the anchor link shown in the editor.

### A WP-CLI Command

Create a custom WP-CLI command named like, `dmg-read-more search` This command will take optional date-range arguments like “date-before” and “date-after” If the dates are omitted, the command will default to the last 30 days.

The command will execute a WP_Query search for Posts within the date range looking for posts containing the aforementioned Gutenberg block. Performance is key, this WP-CLI command will be tested against a database that has tens of millions records in the wp_posts table.

The command will log to STDOUT all Post IDs for the matching results.

If no posts are found, or any other errors encountered, output a log message.
