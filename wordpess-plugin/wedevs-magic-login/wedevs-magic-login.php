<?php
/*
Plugin Name:WeDevs Magic Login
Description: Log in via a magic link.
Version: 1.0
Author: MD. Shibbir Ahmed
Author URI: https://shibbir.me
Text Domain: wedevs-magic-login
*/

use WeDevs\MagicLogin\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Initialize the plugin
 *
 * @return Plugin
 */
function wedevs_magic_login() {
	return Plugin::init();
}

wedevs_magic_login();