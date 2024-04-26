<?php
/**
 * This page is just adds some settings.
 *
 * This code comes directly from the codex: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 */
function repo_demo_settings_init() {
	// Register a new setting for "repo_demo" page.
	register_setting( 'repo_demo', 'repo_demo_options' );

	// Register a new section in the "repo_demo" page.
	add_settings_section(
		'repo_demo_admin',
		__( 'Repo Demo Settings', 'repo_demo' ),
		'repo_demo_section_callback',
		'repo_demo'
	);

	add_settings_field(
		'repo_demo_url', // As of WP 4.6 this value is used only internally.
		// Use $args' label_for to populate the id inside the callback.
		__( 'URL of the Repo', 'repo_demo' ),
		'repo_demo_url_callback',
		'repo_demo',
		'repo_demo_admin',
		array(
			'label_for' => 'repo_demo_url',
			'class'     => 'repo_demo_row',
		)
	);

	add_settings_field(
		'repo_demo_license_key', // As of WP 4.6 this value is used only internally.
		// Use $args' label_for to populate the id inside the callback.
		__( 'License Key', 'repo_demo' ),
		'repo_demo_license_key_callback',
		'repo_demo',
		'repo_demo_admin',
		array(
			'label_for' => 'repo_demo_license_key',
			'class'     => 'repo_demo_row',
		)
	);
}

/**
 * Register our repo_demo_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'repo_demo_settings_init' );


/**
 * URL field
 */

function repo_demo_url_callback( array $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'repo_demo_options', array() );
	?>
    <!--suppress HtmlFormInputWithoutLabel -->
    <input
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="repo_demo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?php echo esc_attr( $options[ $args['label_for'] ] ?? 'http://localhost/wp-json/mindspun/payments/v1/repo/repo-demo' ); ?>"
            size="64"
    />
	<?php
}

/**
 * License Key field
 */

function repo_demo_license_key_callback( array $args ) {
	// Get the value of the setting we've registered with register_setting()
	$options = get_option( 'repo_demo_options', array() );
	?>
    <!--suppress HtmlFormInputWithoutLabel -->
    <input
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="repo_demo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?php echo esc_attr( $options[ $args['label_for'] ] ?? '' ); ?>"
            size="64"
    />
	<?php
}

/**
 * Add the top level menu page.
 */
function repo_demo_options_page() {
	add_menu_page(
		'Repo Demo',
		'Repo Demo',
		'manage_options',
		'repo_demo',
		'repo_demo_options_page_html'
	);
}


/**
 * Register our repo_demo_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'repo_demo_options_page' );


/**
 * Top level menu callback function
 */
function repo_demo_options_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// add error/update messages

	// check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'repo_demo_messages', 'repo_demo_message', __( 'Settings Saved', 'repo_demo' ), 'updated' );
	}

	// show error/update messages
	settings_errors( 'repo_demo_messages' );
	?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
			<?php
			// output security fields for the registered setting "repo_demo"
			settings_fields( 'repo_demo' );
			// output setting sections and their fields
			// (sections are registered for "repo_demo", each field is registered to a specific section)
			do_settings_sections( 'repo_demo' );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
        </form>
    </div>
	<?php
}

function repo_demo_section_callback( $args ) {
}