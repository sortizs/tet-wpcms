<?php

class WP_Auth0_Admin_Appearance extends WP_Auth0_Admin_Generic {

	/**
	 * @deprecated - 3.6.0, use $this->_description instead
	 */
	const APPEARANCE_DESCRIPTION = '';

	protected $_description;

	protected $actions_middlewares = array(
		'basic_validation',
	);

	/**
	 * WP_Auth0_Admin_Appearance constructor.
	 *
	 * @param WP_Auth0_Options $options
	 */
	public function __construct( WP_Auth0_Options $options ) {
		parent::__construct( $options );
		$this->_description =
			__( 'Change the how the embedded Auth0 login form is displayed. ', 'wp-auth0' ) .
			__( 'The settings below will not be applied to the Universal Login Page.', 'wp-auth0' );
	}

	/**
	 * All settings in the Appearance tab
	 *
	 * @see \WP_Auth0_Admin::init_admin
	 * @see \WP_Auth0_Admin_Generic::init_option_section
	 */
	public function init() {
		$options = array(
			array(
				'name'     => __( 'Passwordless Login', 'wp-auth0' ),
				'opt'      => 'passwordless_enabled',
				'id'       => 'wpa0_passwordless_enabled',
				'function' => 'render_passwordless_enabled',
			),
			array(
				'name'     => __( 'Icon URL', 'wp-auth0' ),
				'opt'      => 'icon_url',
				'id'       => 'wpa0_icon_url',
				'function' => 'render_icon_url',
			),
			array(
				'name'     => __( 'Form Title', 'wp-auth0' ),
				'opt'      => 'form_title',
				'id'       => 'wpa0_form_title',
				'function' => 'render_form_title',
			),
			array(
				'name'     => __( 'Enable Gravatar Integration', 'wp-auth0' ),
				'opt'      => 'gravatar',
				'id'       => 'wpa0_gravatar',
				'function' => 'render_gravatar',
			),
			array(
				'name'     => __( 'Login Form CSS', 'wp-auth0' ),
				'opt'      => 'custom_css',
				'id'       => 'wpa0_custom_css',
				'function' => 'render_custom_css',
			),
			array(
				'name'     => __( 'Login Form JS', 'wp-auth0' ),
				'opt'      => 'custom_js',
				'id'       => 'wpa0_custom_js',
				'function' => 'render_custom_js',
			),
			array(
				'name'     => __( 'Login Name Style', 'wp-auth0' ),
				'opt'      => 'username_style',
				'id'       => 'wpa0_username_style',
				'function' => 'render_username_style',
			),
			array(
				'name'     => __( 'Primary Color', 'wp-auth0' ),
				'opt'      => 'primary_color',
				'id'       => 'wpa0_primary_color',
				'function' => 'render_primary_color',
			),
			array(
				'name'     => __( 'Language', 'wp-auth0' ),
				'opt'      => 'language',
				'id'       => 'wpa0_language',
				'function' => 'render_language',
			),
		);

		// TODO: Remove this once feature has been removed
		if ( $this->options->get( 'language_dictionary' ) ) {
			$options[] = array(
				'name'     => __( 'Language Dictionary', 'wp-auth0' ),
				'opt'      => 'language_dictionary',
				'id'       => 'wpa0_language_dictionary',
				'function' => 'render_language_dictionary',
			);
		}

		$options = $options + array(
			( count( $options ) ) => array(
				'name'     => __( 'Custom Signup Fields', 'wp-auth0' ),
				'opt'      => 'custom_signup_fields',
				'id'       => 'wpa0_custom_signup_fields',
				'function' => 'render_custom_signup_fields',
			),
			array(
				'name'     => __( 'Extra Settings', 'wp-auth0' ),
				'opt'      => 'extra_conf',
				'id'       => 'wpa0_extra_conf',
				'function' => 'render_extra_conf',
			),
			array(
				'name'     => __( 'Use Custom Lock JS URL', 'wp-auth0' ),
				'opt'      => 'custom_cdn_url',
				'id'       => 'wpa0_custom_cdn_url',
				'function' => 'render_custom_cdn_url',
			),
			array(
				'name'     => __( 'Custom Lock JS URL', 'wp-auth0' ),
				'opt'      => 'cdn_url',
				'id'       => 'wpa0_cdn_url',
				'function' => 'render_cdn_url',
			),
			array(
				'name'     => __( 'Connections to Show', 'wp-auth0' ),
				'opt'      => 'lock_connections',
				'id'       => 'wpa0_connections',
				'function' => 'render_connections',
			),
		);
		$this->init_option_section( '', 'appearance', $options );
	}

	/**
	 * Render form field and description for the `custom_cdn_url` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_custom_cdn_url( $args = array() ) {
		$this->render_switch( $args['label_for'], $args['opt_name'], 'wpa0_cdn_url' );
		$this->render_field_description( __( 'Use a custom Lock CDN URL instead of the default. ', 'wp-auth0' ) );

		if ( ! $this->options->get( $args['opt_name'] ) ) {
			$this->render_field_description(
				__( 'Currently using:', 'wp-auth0' ) .
				' <code>' . WPA0_LOCK_CDN_URL . '</code>'
			);
		}
	}

	/**
	 * Render form field and description for the `cdn_url` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_cdn_url( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'This should point to the latest Lock JS available in the CDN and rarely needs to change', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `passwordless_enabled` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_passwordless_enabled( $args = array() ) {
		$this->render_switch( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Turn on Passwordless login (email or SMS) in the Auth0 form. ', 'wp-auth0' ) .
			__( 'Passwordless connections are managed in the ', 'wp-auth0' ) .
			$this->get_dashboard_link( 'connections/passwordless' ) .
			__( ' and at least one must be active and enabled on this Application for this to work. ', 'wp-auth0' ) .
			__( 'Username/password login is not enabled when Passwordless is on', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `lock_connections` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_connections( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'], 'text', 'eg: "sms, google-oauth2, github"' );
		$this->render_field_description(
			__( 'Specify which Social, Database, or Passwordless connections to display in the Auth0 form. ', 'wp-auth0' ) .
			__( 'If this is empty, all enabled connections for this Application will be shown. ', 'wp-auth0' ) .
			__( 'Separate multiple connection names with a comma. ', 'wp-auth0' ) .
			sprintf(
				// translators: HTML link to the Auth0 dashboard.
				__( 'Connections listed here must already be active in your %s', 'wp-auth0' ),
				$this->get_dashboard_link( 'connections/social' )
			) .
			__( ' and enabled for this Application. ', 'wp-auth0' ) .
			__( 'Click on a Connection and use the "Name" value in this field', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `icon_url` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_icon_url( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'] );
		printf( ' <a id="wpa0_choose_icon" class="button-secondary">%s</a>', __( 'Choose Icon', 'wp-auth0' ) );
		$this->render_field_description(
			__( 'Icon above the title on the Auth0 login form. ', 'wp-auth0' ) .
			__( 'This image works best as a PNG with a transparent background less than 120px tall', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `form_title` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_form_title( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description( __( 'Title used on the Auth0 login form', 'wp-auth0' ) );
	}

	/**
	 * Render form field and description for the `social_big_buttons` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @deprecated - 3.11.0, no longer used and no replacement provided.
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_social_big_buttons( $args = array() ) {
		$this->render_switch( $args['label_for'], $args['opt_name'] );
		$this->render_field_description( __( 'Use large social login buttons on the Auth0 login form', 'wp-auth0' ) );
	}

	/**
	 * Render form field and description for the `gravatar` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_gravatar( $args = array() ) {
		$this->render_switch( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Automatically display an avatar (from Gravatar) on the Auth0 login form', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `custom_css` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @deprecated - 3.10.0, CSS must be added as an external file starting in the next major release.
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_custom_css( $args = array() ) {
		if ( $this->options->get( 'custom_css' ) ) {
			$this->render_textarea_field( $args['label_for'], $args['opt_name'] );
			$this->render_field_description(
				__( 'NOTE: This field is deprecated and will be removed in the next major release. ', 'wp-auth0' ) .
				__( 'Valid CSS to customize the Auth0 login form', 'wp-auth0' )
			);
		} else {
			$this->render_field_description(
				__( 'Custom styles should be loaded in an external file using the instructions ', 'wp-auth0' ) .
				$this->get_docs_link( 'cms/wordpress/troubleshoot#how-can-i-modify-the-embedded-auth0-login-form-' )
			);
		}

	}

	/**
	 * Render form field and description for the `custom_js` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @deprecated - 3.10.0, JS must be added as an external file starting in the next major release.
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_custom_js( $args = array() ) {
		if ( $this->options->get( 'custom_js' ) ) {
			$this->render_textarea_field( $args['label_for'], $args['opt_name'] );
			$this->render_field_description(
				__( 'NOTE: This field is deprecated and will be removed in the next major release. ', 'wp-auth0' ) .
				__( 'Valid JS to customize the Auth0 login form', 'wp-auth0' )
			);
		} else {
			$this->render_field_description(
				__( 'Custom JavaScript should be loaded in an external file using the instructions ', 'wp-auth0' ) .
				$this->get_docs_link( 'cms/wordpress/troubleshoot#how-can-i-modify-the-embedded-auth0-login-form-' )
			);
		}
	}

	/**
	 * Render form field and description for the `username_style` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_username_style( $args = array() ) {
		$this->render_radio_buttons(
			array(
				array(
					'label' => 'Auto',
					'value' => '',
				),
				'email',
				'username',
			),
			$args['label_for'],
			$args['opt_name'],
			$this->options->get( $args['opt_name'], '' )
		);
		$this->render_field_description(
			__( 'To allow the user to use either email or username to login, leave this as "Auto." ', 'wp-auth0' ) .
			__( 'Only database connections that require a username will allow username logins', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `primary_color` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_primary_color( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Primary color for the Auth0 login form in hex format. ', 'wp-auth0' ) .
			$this->get_docs_link(
				'libraries/lock/v11/configuration#primarycolor-string-',
				__( 'More information on this settings', 'wp-auth0' )
			)
		);
	}

	/**
	 * Render form field and description for the `language` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_language( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'The language parameter for the Auth0 login form. ', 'wp-auth0' ) .
			sprintf(
				'<a href="https://github.com/auth0/lock/tree/master/src/i18n" target="_blank">%s</a>',
				__( 'Available languages list', 'wp-auth0' )
			)
		);
	}

	/**
	 * Render form field and description for the `language_dictionary` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @deprecated - 3.10.0, will be combined with the Extra Settings field below in the next major.
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 *
	 * @codeCoverageIgnores - Deprecated.
	 */
	public function render_language_dictionary( $args = array() ) {
		$this->render_textarea_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'The languageDictionary parameter for the Auth0 login form. ', 'wp-auth0' ) .
			sprintf(
				'<a href="https://github.com/auth0/lock/blob/master/src/i18n/en.js" target="_blank">%s</a>',
				__( 'List of all modifiable options', 'wp-auth0' )
			)
		);
		$this->render_field_description(
			__( 'NOTE: This field is deprecated and will be removed in the next major release. ', 'wp-auth0' ) .
			__( 'Use a languageDictionary property the Extra Settings field below to change text.', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `extra_conf` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_extra_conf( $args = array() ) {
		$this->render_textarea_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Valid JSON for Lock options configuration; will override all options set elsewhere. ', 'wp-auth0' ) .
			$this->get_docs_link( 'libraries/lock/customization', 'See options and examples' )
		);
	}

	/**
	 * Render form field and description for the `custom_signup_fields` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_custom_signup_fields( $args = array() ) {
		$this->render_textarea_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Valid array of JSON objects for additional signup fields in the Auth0 signup form. ', 'wp-auth0' ) .
			$this->get_docs_link(
				'libraries/lock/v11/configuration#additionalsignupfields-array-',
				__( 'More information and examples', 'wp-auth0' )
			)
		);
	}

	public function basic_validation( $old_options, $input ) {
		$input['form_title']    = empty( $input['form_title'] ) ? '' : sanitize_text_field( $input['form_title'] );
		$input['icon_url']      = empty( $input['icon_url'] ) ? '' : esc_url( $input['icon_url'], array( 'http', 'https' ) );
		$input['gravatar']      = empty( $input['gravatar'] ) ? 0 : 1;
		$input['language']      = empty( $input['language'] ) ? '' : sanitize_text_field( $input['language'] );
		$input['primary_color'] = empty( $input['primary_color'] ) ? '' : sanitize_text_field( $input['primary_color'] );

		$input['language_dictionary'] = isset( $input['language_dictionary'] ) ? trim( $input['language_dictionary'] ) : '';
		if ( ! empty( $input['language_dictionary'] ) ) {
			if ( json_decode( $input['language_dictionary'] ) === null ) {
				$error = __( 'The language dictionary parameter should be a valid JSON object.', 'wp-auth0' );
				$this->add_validation_error( $error );
				$input['language_dictionary'] = isset( $old_options['language_dictionary'] ) ? $old_options['language_dictionary'] : '';
			}
		}

		$input['custom_cdn_url'] = empty( $input['custom_cdn_url'] ) ? 0 : 1;

		$input['cdn_url'] = empty( $input['cdn_url'] ) ? WPA0_LOCK_CDN_URL : sanitize_text_field( $input['cdn_url'] );

		// If an invalid URL is used, default to previously saved (if there is one) or default URL.
		if ( ! filter_var( $input['cdn_url'], FILTER_VALIDATE_URL ) ) {
			$input['cdn_url'] = isset( $old_options['cdn_url'] ) ? $old_options['cdn_url'] : WPA0_LOCK_CDN_URL;
			self::add_validation_error( __( 'The Lock JS CDN URL used is not a valid URL.', 'wp-auth0' ) );
		}

		return $input;
	}

	/**
	 * @deprecated - 3.6.0, handled by WP_Auth0_Admin_Generic::render_description()
	 *
	 * @codeCoverageIgnore - Deprecated
	 */
	public function render_appearance_description() {
		// phpcs:ignore
		@trigger_error( sprintf( __( 'Method %s is deprecated.', 'wp-auth0' ), __METHOD__ ), E_USER_DEPRECATED );
		printf( '<p class="a0-step-text">%s</p>', $this->_description );
	}
}
