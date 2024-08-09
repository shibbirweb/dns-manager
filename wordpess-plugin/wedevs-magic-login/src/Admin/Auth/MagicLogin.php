<?php

namespace WeDevs\MagicLogin\Admin\Auth;

use WeDevs\MagicLogin\Admin\Menu\OptionMenu;
use WeDevs\MagicLogin\Service\API\ServerAPI;

class MagicLogin {
	public function __construct() {
		add_action( 'init', [ $this, 'hangle_magic_login' ] );
	}

	/**
	 * Handle the magic login
	 *
	 * @return void
	 */
	public function hangle_magic_login() {
		// Check if the magic_login_token is set
		if ( ! isset( $_GET['magic_login_token'] ) ) {
			return;
		}

		// Get the token, email and hash from the magic_login_token
		[ $token, $email, $hash ] = $this->get_params_from_magic_login_token( $_GET['magic_login_token'] );

		// Get the secret key from the plugin settings
		$secretKey = $this->get_secret_key();

		// Recreate the hash and compare
		$expectedHash = $this->generate_hash( $token, $email, $secretKey );

		if ( ! hash_equals( $expectedHash, $hash ) ) {
			wp_die( 'Invalid hash' );
		}

		// Verify the token
		if ( ! $this->is_verified_token( $token ) ) {
			wp_die( 'Invalid token' );
		}

		$user = get_user_by( 'email', $email );

		if ( ! $user ) {
			wp_die( 'User not found' );
		}

		// if already logged in, then logout current user
		if ( is_user_logged_in() ) {
			wp_logout();
		}

		wp_set_auth_cookie( $user->ID );
		wp_redirect( home_url( '/dashboard' ) );
		exit;
	}

	/**
	 * Get the params from magic login token
	 *
	 * @param string $magic_login_token
	 *
	 * @return array
	 */
	private function get_params_from_magic_login_token( mixed $magic_login_token ) {
		$query = base64_decode( $magic_login_token );
		parse_str( $query, $params );

		return [
			sanitize_text_field( $params['token'] ),
			sanitize_email( $params['email'] ),
			sanitize_text_field( $params['hash'] ),
		];
	}

	/**
	 * Get the secret key
	 *
	 * @return string
	 */
	private function get_secret_key() {
		$options = get_option( OptionMenu::SETTING_OPTIONS );

		return $options[ OptionMenu::SETTING_OPTION_SECRET_KEY ];
	}

	/**
	 * Generate hash
	 *
	 * @param string $token
	 * @param string $email
	 * @param string $secretKey
	 *
	 * @return string
	 */
	private function generate_hash( $token, $email, $secretKey ) {
		return hash_hmac( 'sha256', $token . $email, $secretKey );
	}

	/**
	 * Verify the token
	 *
	 * @param string $token
	 *
	 * @return bool
	 */
	private function is_verified_token( $token ) {
		// Verify the token from the server
		$serverApi = new ServerAPI();

		$body = $serverApi->verify_magic_token( $token );

		if ( is_wp_error( $body ) ) {
			return false;
		}

		return $body?->data?->is_valid ?? false;
	}
}