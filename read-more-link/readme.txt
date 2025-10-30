=== Read More Link ===
Contributors:      Paul Jenkins
Tags:              block
Tested up to:      6.8.1
Stable tag:        1.0.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

A block to create a read more link to another post.

== Description ==

Write a Gutenberg block using native WP React tools (no ACF or other plugin dependencies). This block should allow editors to search for and then choose a published post to insert into the editor as a stylized anchor link.

Editors should be able to search posts in the InspectorControls using a search string. It should paginate results. It should support searching for a specific post ID. Recent posts should be shown to choose from by default.

The anchor text should be the post title and the anchor href should be the post permalink. The anchor should be output within a paragraph element with a CSS class of `dmg-read-more` added to it. The anchor should be prepended with the words `Read More: `.

Choosing a new post should update the anchor link shown in the editor.

