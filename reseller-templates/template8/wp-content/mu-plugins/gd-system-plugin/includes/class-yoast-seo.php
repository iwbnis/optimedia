<?php

namespace WPaaS;

use WP_REST_Server;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

final class Yoast_SEO {

	public function __construct() {

		add_action( 'admin_init', [ $this, 'suppress_notifications' ], 20 );

		if ( defined( 'GD_ACCOUNT_UID' ) && isset( $_SERVER['HTTP_X_ACCOUNT_UID'] ) && $_SERVER['HTTP_X_ACCOUNT_UID'] === GD_ACCOUNT_UID ) {

			add_action( 'rest_api_init', [ $this, 'register_rest_route' ] );

		}

	}

	/**
	 * Suppress notifications in the notification center.
	 */
	public function suppress_notifications() {

		if ( ! class_exists( 'Yoast_Notification_Center' ) ) {

			return;

		}

		$notification_center = \Yoast_Notification_Center::get();

		// Don't show the Woo Helper upsell if the customer went through our on-boarding.
		if ( Plugin::has_used_wpnux() ) {

			$notification_center->remove_notification_by_id( 'wpseo-suggested-plugin-yoast-woocommerce-seo' );

		}

		// Don't show the blocking robots notice if using a temp domain.
		if ( Plugin::is_temp_domain() ) {

			$notification_center->remove_notification_by_id( 'wpseo-dismiss-blog-public-notice' );

		}

	}

	/**
	 * Register Yoast SEO REST route.
	 */
	public function register_rest_route() {

		register_rest_route( 'wpaas/v1', 'yoast', [
			'methods'  => WP_REST_Server::READABLE,
			'callback' => function () {
				$wpseo = (array) get_option( 'wpseo', [] );
				return [
					'active'                 => defined( 'WPSEO_VERSION' ),
					'environment_type'       => ! empty( $wpseo['environment_type'] ) ? $wpseo['environment_type'] : null,
					'first_activated_on'     => ! empty( $wpseo['first_activated_on'] ) ? $wpseo['first_activated_on'] : null,
					'show_onboarding_notice' => ! empty( $wpseo['show_onboarding_notice'] ),
					'site_type'              => ! empty( $wpseo['site_type'] ) ? $wpseo['site_type'] : null,
					'version'                => ! empty( $wpseo['version'] ) ? $wpseo['version'] : null,
				];
			},
		] );

	}

}
