# DMG Read More Plugin

A custom WordPress plugin with two main features:

1. A custom Gutenberg block called **Read More Link**
2. A WP-CLI command to search for posts using that block

---

## 📦 Installation

1. Clone this repository into your WordPress `wp-content/plugins/` directory:
   ```bash
   git clone https://github.com/your-username/dmg-read-more.git
   cd dmg-read-more
   ```

2. Install PHP and JavaScript dependencies using Composer:
   ```bash
   composer install
   npm install
   ```

3. Build the block assets:
   ```bash
   cd read-more-link
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

To set up the environment:

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
dmg-read-more/
├── read-more-link/       # Block source and build
├── src/                  # Plugin classes
├── tests/                # PHPUnit tests
├── setup-wordpress-tests.sh
├── composer.json
├── package.json
```

---

## 📝 License

GPL-2.0-or-later  
See [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) for details.
