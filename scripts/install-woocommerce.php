<?php
/**
 * Installs and activates the pinned official WooCommerce release in the
 * WordPress container. Run with: docker compose exec wordpress php /tmp/install-woocommerce.php
 */

require_once '/var/www/html/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$plugin_file = 'woocommerce/woocommerce.php';

if ( ! is_plugin_active( $plugin_file ) ) {
	if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
		$archive = download_url( 'https://downloads.wordpress.org/plugin/woocommerce.11.2.1.zip', 180 );
		if ( is_wp_error( $archive ) ) {
			fwrite( STDERR, 'WooCommerce download failed: ' . $archive->get_error_message() . PHP_EOL );
			exit( 1 );
		}

		$zip    = new ZipArchive();
		$result = $zip->open( $archive );
		unlink( $archive );
		if ( true !== $result ) {
			fwrite( STDERR, "WooCommerce archive could not be opened.\n" );
			exit( 1 );
		}

		$extracted = $zip->extractTo( WP_PLUGIN_DIR );
		$zip->close();
		if ( ! $extracted ) {
			fwrite( STDERR, "WooCommerce extraction failed; check the WordPress plugins directory permissions.\n" );
			exit( 1 );
		}
	}

	if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
		fwrite( STDERR, "WooCommerce plugin file was not found after extraction.\n" );
		exit( 1 );
	}

	$activation = activate_plugin( $plugin_file );
	if ( is_wp_error( $activation ) ) {
		fwrite( STDERR, 'WooCommerce activation failed: ' . $activation->get_error_message() . PHP_EOL );
		exit( 1 );
	}

	echo "WooCommerce 11.2.1 installed and activated.\n";
} else {
	echo "WooCommerce is already active.\n";
}

function install_woocommerce_vietnamese_translation() {
	$translation_dir  = WP_LANG_DIR . '/plugins';
	$translation_file = $translation_dir . '/woocommerce-vi.mo';

	if ( file_exists( $translation_file ) && filesize( $translation_file ) > 0 ) {
		echo "WooCommerce Vietnamese translations are already installed.\n";
		return;
	}

	if ( ! wp_mkdir_p( $translation_dir ) || ! is_writable( $translation_dir ) ) {
		fwrite( STDERR, "WooCommerce translations could not be installed; the WordPress language directory is not writable.\n" );
		exit( 1 );
	}

	$archive = download_url( 'https://downloads.wordpress.org/translation/plugin/woocommerce/11.2.1/vi.zip', 180 );
	if ( is_wp_error( $archive ) ) {
		fwrite( STDERR, 'WooCommerce Vietnamese translation download failed: ' . $archive->get_error_message() . PHP_EOL );
		exit( 1 );
	}

	$zip    = new ZipArchive();
	$result = $zip->open( $archive );
	if ( true !== $result ) {
		unlink( $archive );
		fwrite( STDERR, "WooCommerce Vietnamese translation archive could not be opened.\n" );
		exit( 1 );
	}

	$translation_installed = false;
	for ( $index = 0; $index < $zip->numFiles; $index++ ) {
		$filename = $zip->getNameIndex( $index );
		if ( ! preg_match( '/^woocommerce-vi(?:-[a-f0-9]+)?\.(?:mo|po|json)$/i', $filename ) ) {
			continue;
		}

		$contents = $zip->getFromIndex( $index );
		if ( false === $contents || false === file_put_contents( $translation_dir . '/' . $filename, $contents ) ) {
			$zip->close();
			unlink( $archive );
			fwrite( STDERR, 'Could not install WooCommerce translation file: ' . $filename . PHP_EOL );
			exit( 1 );
		}

		if ( 'woocommerce-vi.mo' === $filename ) {
			$translation_installed = true;
		}
	}

	$zip->close();
	unlink( $archive );
	if ( ! $translation_installed ) {
		fwrite( STDERR, "WooCommerce Vietnamese translation package did not contain its compiled .mo file.\n" );
		exit( 1 );
	}

	echo "WooCommerce Vietnamese translations installed.\n";
}

install_woocommerce_vietnamese_translation();
