<?php

namespace WPaaS;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

final class WooCommerce {

	public function __construct() {

		add_filter( 'woocommerce_show_admin_notice', [ $this, 'suppress_notices' ], 10, 2 );

		add_filter( 'woocommerce_helper_suppress_connect_notice', [ $this, 'suppress_helper_notices' ], PHP_INT_MAX );

	}

	/**
	 * Suppress WooCommerce admin notices.
	 *
	 * @param  bool   $bool   Boolean value to show/suppress the notice.
	 * @param  string $notice The notice name being displayed.
	 *
	 * @since 3.11.0
	 *
	 * @return bool True to show the notice, false to suppress it.
	 */
	public function suppress_notices( $bool, $notice ) {

		// Suppress the SSL notice when using a temp domain.
		if ( 'no_secure_connection' === $notice && Plugin::is_temp_domain() ) {

			return false;

		}

		// Suppress the "Install WooCommerce Admin" notice when the Setup Wizard notice is visible.
		if ( 'wc_admin' === $notice && in_array( 'install', (array) get_option( 'woocommerce_admin_notices', [] ), true ) ) {

			return false;

		}

		return $bool;

	}

	/**
	 * Suppress WooCommerce helper admin notices when on a eCommerce Managed WordPress plan.
	 *
	 * @param  bool $bool Boolean value to show/suppress the notice.
	 *
	 * @return bool True when a eCommerce Managed WordPress plan, else false.
	 */
	public function suppress_helper_notices() {

		return Plugin::has_plan( 'eCommerce Managed WordPress' );

	}

}
