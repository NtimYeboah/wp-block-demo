<?php
/**
 * Plugin Name:       Demo Blocks
 * Author URI:		  ntim.dev
 * Description:       Example block for learning Block Plugins.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            ntim.dev
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       demo-blocks
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function demo_blocks_demo_blocks_block_init() {
	register_block_type( __DIR__ . '/build' );

	add_action('admin_enqueue_scripts', 'demo_blocks_scripts');
}
add_action( 'init', 'demo_blocks_demo_blocks_block_init' );

function demo_blocks_scripts() {
	$handle = 'create-block-demo-blocks-editor-script';

	$data = get_transient('demo-blocks');

	if (! $data) {
		$response = wp_remote_get('https://jsonplaceholder.typicode.com/users');
		$data = wp_remote_retrieve_body($response);
		$data = json_decode($data);

		set_transient('demo-blocks', $data, 7 * DAY_IN_SECONDS);
	}
	
	wp_localize_script($handle, 'demoBlocksData', $data);
}
