<?php

namespace WeDevs\MagicLogin;

use WeDevs\MagicLogin\Admin\Auth\MagicLogin;
use WeDevs\MagicLogin\Admin\Menu\OptionMenu;

final class Plugin {
	private static $instance;

	/**
	 * The server API endpoint.
	 * This should be changed to the actual server API endpoint
	 */
	private const SERVER_API_ENDPOINT = 'http://localhost:8000/api/v1';

	/**
	 * Plugin constructor.
	 */
	private function __construct() {
		$this->define_constants();

		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Define the necessary constants
	 *
	 * @return void
	 */
	private function define_constants() {
		define( 'WEDEVS_SERVER_API_ENDPOINT', self::SERVER_API_ENDPOINT );
	}

	/**
	 * Initialize the plugin
	 *
	 * @return Plugin
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Initialize the plugin features
	 *
	 * @return void
	 */
	public function init_plugin() {
		// Initialize the option menu
		new OptionMenu();
		// Initialize the magic login
		new MagicLogin();
	}
}