# DMG Read More Plugin

A custom WordPress plugin with two main features:

1. A custom Gutenberg block called **Read More Link**
2. A WP-CLI command to search for posts using that block

---

## 📦 Installation

1. Clone this repository into your WordPress `wp-content/plugins/` directory:

   ```bash
   cd wp-content/plugins
   git clone https://github.com/turnpiece/dmg-read-more.git
   cd dmg-read-more
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install JavaScript dependencies and build the block assets:

   ```bash
   cd read-more-link
   npm install
   npm run build
   ```

4. Activate the plugin via the WordPress admin or WP-CLI:
   ```bash
   wp plugin activate dmg-read-more
   ```

---

## ✨ Features

### Gutenberg Block

- **Read More Link** — A toggleable block for linking to selected posts.
- Built with `@wordpress/scripts` and located in `/read-more-link`.

### WP-CLI Command

Search for posts using the block within a given date range:

```bash
wp dmg-read-more search --date-after=2024-01-01 --date-before=2024-12-31
```

Optional flags:

- `--double-check=false` — Skips `parse_blocks()` for faster performance on large datasets.

---

## 🧪 Running Tests

This plugin includes a PHPUnit test suite.

To set up the test environment:

```bash
cp .env.example .env
# Edit .env with your DB_HOST, DB_NAME, etc.

./setup-wordpress-tests.sh
vendor/bin/phpunit
```

---

## 🛠️ Requirements

- WordPress 6.x
- PHP 7.4+
- Node 18+
- Composer

---

## 📁 Folder Structure

```
dmg-read-more/              # Plugin root
├── dmg-read-more.php       # Main plugin file
├── readme.txt              # WordPress.org readme
├── composer.json           # PHP dependencies
├── phpunit.xml             # PHPUnit configuration
├── read-more-link/         # Block source and build
│   ├── package.json        # Block dependencies
│   ├── src/                # Block source files
│   └── build/              # Compiled block assets
├── src/                    # Plugin PHP classes
│   ├── Plugin.php
│   └── Cli_DMG_Read_More_Posts.php
├── tests/                  # PHPUnit tests
├── setup-wordpress-tests.sh
├── uninstall.php
└── vendor/                 # Composer packages (gitignored)
```

---

## 📝 License

GPL-2.0-or-later  
See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.
