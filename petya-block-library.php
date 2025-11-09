<?php
/**
 * Plugin Name:       Petya Block Library
 * Plugin URI:        https://petyaferreira.com
 * Description:       Petya Block Library is a collection of custom blocks.
 * Version:           1.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Author:            Petya
 * Author URI:        https://petyaferreira.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       petya-block-library
 *
 * @package           petya-block-library
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Define plugin constants.
 */
define( 'PETYA_BLOCK_LIBRARY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PETYA_BLOCK_LIBRARY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Registers multiple block types from metadata loaded from a file.
 */
function petya_block_library_register_blocks() {
	$build_dir = PETYA_BLOCK_LIBRARY_PLUGIN_PATH . '/build/blocks';

	if ( ! file_exists( $build_dir ) ) {
		return;
	}

	$block_json_files = glob( $build_dir . '/*/block.json' );

	foreach ( $block_json_files as $block_json_file ) {
		register_block_type( dirname( $block_json_file ) );
	}
}

add_action( 'init', 'petya_block_library_register_blocks' );

/**
 * Register block category.
 *
 * @param array $categories Existing block categories.
 */
function petya_block_library_register_block_category( array $categories ): array {
	$categories[] = array(
		'slug'  => 'petya-blocks',
		'title' => __( 'Petya Blocks', 'petya-block-library' ),
	);

	return $categories;
}

add_filter( 'block_categories_all', 'petya_block_library_register_block_category' );

/**
 * Fix for Dashicons styles bug
 * See https://github.com/WordPress/gutenberg/issues/53528
 */
function petya_block_library_enqueue_dashicons() {
	if ( is_admin() ) {
		wp_enqueue_style( 'dashicons' );
	}
}

add_action( 'enqueue_block_assets', 'petya_block_library_enqueue_dashicons' );
