<?php

namespace WPaaS\Admin;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

use \WPaaS\Plugin;

final class Block_Editor {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		if ( ! Plugin::use_simple_ux() ) {

			return;

		}

		add_action( 'enqueue_block_editor_assets', [ $this, 'block_editor_overrides' ] );

	}

	/**
	 * Override block editor defaults.
	 *
	 * @action enqueue_block_editor_assets
	 */
	public function block_editor_overrides() {

		$suffix = SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'wpaas-block-editor-defaults', Plugin::assets_url( "js/wpaas-block-editor-defaults{$suffix}.js" ), [ 'wp-blocks' ], Plugin::version(), true );

		$referer = wp_get_referer();

		wp_localize_script(
			'wpaas-block-editor-defaults',
			'wpaasBlockEditorDefaults',
			[
				'isWP54'  => version_compare( get_bloginfo( 'version' ), '5.4.0', '>=' ),
				'referer' => ( false !== $referer ) ? esc_url( wp_get_referer() ) : false,
				'userId'  => absint( get_current_user_id() ),
			]
		);

	}

}
