=== DMG Read More ===
Contributors: Paul Jenkins
Requires at least: 4.5
Tested up to: 6.8.1
Requires PHP: 5.6
Stable tag: 1.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A custom Gutenberg block and WP-CLI command for finding posts that use the block. Built for demonstration and testing.

== Description ==

This plugin includes two main features:

1. A custom Gutenberg block: **Read More Link**
2. A WP-CLI command: `dmg-read-more search` — to find posts using the block in a date range.

== Installation ==

1. Upload the plugin folder to your `/wp-content/plugins/` directory.
2. Run `npm install && npm run build` to compile the block.
3. Activate the plugin through the WordPress admin or WP-CLI.

== Frequently Asked Questions ==

= Do I need to build the block? =

Yes, the plugin uses modern JavaScript tooling. 
Run `npm install && npm run build` from within the read-more-link folder.
This will compile the block assets into `read-more-link/build/`.

= How do I use the CLI command? =

```bash
wp dmg-read-more search --date-after=2024-01-01 --date-before=2024-12-31
```

== Changelog ==

= 1.0.0 =
* Initial release with block and CLI command.

== Upgrade Notice ==

= 1.0.0 =
Initial release.

== License ==

GPL-2.0-or-later. This plugin is free software. You can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation.
