#!/bin/bash

# Load environment variables from .env if available
if [ -f .env ]; then
  echo "Loading .env..."
  source .env
fi

# Configuration with environment variable fallbacks
DB_NAME="${DB_NAME:-local}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-root}"
DB_HOST="${DB_HOST:-localhost}"
WP_TESTS_DIR="/tmp/wordpress-tests-lib"
WP_CORE_DIR="/tmp/wordpress"
WP_VERSION="latest"

set -e

# Download WordPress core
if [ ! -f "$WP_CORE_DIR/wp-settings.php" ]; then
  echo "Downloading WordPress core..."
  mkdir -p "$WP_CORE_DIR"
  curl -sL https://wordpress.org/latest.tar.gz -o /tmp/latest.tar.gz
  tar -xzf /tmp/latest.tar.gz -C "$WP_CORE_DIR" --strip-components=1
  rm /tmp/latest.tar.gz
fi

# Download WordPress test suite
if [ ! -d "$WP_TESTS_DIR" ]; then
  echo "Downloading WordPress test suite..."
  svn export --quiet https://develop.svn.wordpress.org/trunk/tests/phpunit "$WP_TESTS_DIR"
fi

# Create wp-tests-config.php
if [ ! -f "$WP_TESTS_DIR/wp-tests-config.php" ]; then
  echo "Creating wp-tests-config.php..."
  curl -sL https://develop.svn.wordpress.org/trunk/wp-tests-config-sample.php -o "$WP_TESTS_DIR/wp-tests-config.php"
  sed -i '' "s/youremptytestdbnamehere/$DB_NAME/" "$WP_TESTS_DIR/wp-tests-config.php"
  sed -i '' "s/yourusernamehere/$DB_USER/" "$WP_TESTS_DIR/wp-tests-config.php"
  sed -i '' "s/yourpasswordhere/$DB_PASS/" "$WP_TESTS_DIR/wp-tests-config.php"
  sed -i '' "s|localhost|$DB_HOST|" "$WP_TESTS_DIR/wp-tests-config.php"
  sed -i '' "s:dirname( __FILE__ ) . '/src/':'$WP_CORE_DIR/':" "$WP_TESTS_DIR/wp-tests-config.php"
fi

# Set permissions
chmod -R 755 "$WP_TESTS_DIR"
chmod -R 755 "$WP_CORE_DIR"

# Export WP_TESTS_DIR for PHPUnit
export WP_TESTS_DIR="$WP_TESTS_DIR"
echo "WP_TESTS_DIR set to $WP_TESTS_DIR"

# Strip positional args (assume DB credentials passed above)
shift 6

# Run PHPUnit
echo "Running PHPUnit..."
vendor/bin/phpunit "$@"
