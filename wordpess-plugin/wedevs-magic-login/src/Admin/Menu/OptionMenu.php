<?php

namespace WeDevs\MagicLogin\Admin\Menu;

class OptionMenu {
	private const MENU_SLUG = 'wedevs_magic_login';
	public const SETTING_OPTIONS = 'wedevs_magic_login_options';
	public const SETTING_OPTION_SECRET_KEY = 'magic_login_secret_key';

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_init', [ $this, 'settings_init' ] );
	}

	/**
	 * Add admin menu
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		add_options_page( 'WeDevs Magic Login', 'WeDevs Magic Login', 'manage_options', self::MENU_SLUG, [
			$this,
			'magic_login_options_page'
		] );
	}

	/**
	 * Form for magic login options
	 *
	 * @return void
	 */
	public function magic_login_options_page() {
		?>
        <form action='options.php' method='post'>
            <h2>WeDevs Magic Login</h2>
			<?php
			settings_fields( 'wedevs_magic_login_settings' );
			do_settings_sections( 'wedevs_magic_login_settings' );
			submit_button();
			?>
        </form>
		<?php
	}

	public function settings_init() {
		register_setting( 'wedevs_magic_login_settings', self::SETTING_OPTIONS );

		add_settings_section(
			'wedevs_magic_login_section',
			__( 'Settings', 'wedevs-magic-login' ),
			[ $this, 'settings_section_callback' ],
			'wedevs_magic_login_settings'
		);

		add_settings_field(
			'magic_login_secret_key',
			__( 'Secret Key', 'wedevs-magic-login' ),
			[ $this, 'magic_login_settings_secret_key_input_render' ],
			'wedevs_magic_login_settings',
			'wedevs_magic_login_section'
		);
	}

	/**
	 * Magic login secret key field render
	 *
	 * @return void
	 */
	public function magic_login_settings_secret_key_input_render() {
		$options = get_option( self::SETTING_OPTIONS );
		?>
        <input type='text'
               class='regular-text'
               name='<?php echo self::SETTING_OPTIONS; ?>[<?php echo self::SETTING_OPTION_SECRET_KEY; ?>]'
               value='<?php echo( $options[ self::SETTING_OPTION_SECRET_KEY ] ?? '' ); ?>'>
		<?php
	}

	/**
	 * Magic login settings section callback
	 *
	 * @return void
	 */
	public function settings_section_callback() {
		echo __( 'Enter your secret key to use for magic login token verification.', 'wedevs-magic-login' );
	}
}