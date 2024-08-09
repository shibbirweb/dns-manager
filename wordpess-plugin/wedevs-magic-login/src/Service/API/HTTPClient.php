<?php

namespace WeDevs\MagicLogin\Service\API;

use WP_Error;

abstract class HTTPClient {

	/**
	 * Call the API
	 *
	 * @param string $url
	 * @param string $method
	 * @param array $data
	 *
	 * @return mixed|WP_Error
	 */
	public function call( $url, $method = 'GET', $data = [] ) {
		$response = wp_remote_request( $url, [
			'method'  => $method,
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body'    => json_encode( $data ),
		] );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$body = wp_remote_retrieve_body( $response );

		return json_decode( $body );
	}
}