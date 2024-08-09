<?php

namespace WeDevs\MagicLogin\Service\API;

use WP_Error;

class ServerAPI extends HTTPClient {

	private $base_url = WEDEVS_SERVER_API_ENDPOINT;

	/**
	 * Call the verify magic token API
	 *
	 * @param string $token
	 *
	 * @return mixed|WP_Error
	 */
	public function verify_magic_token( $token ) {
		return $this->call( $this->base_url . '/magic-token/verify', 'POST', [
			'token' => $token,
		] );
	}
}