<?php
/**
 * Plugin Name:       Repo Demo
 * Description:       Demo plugin for Software Licensing with Mindspun Payments
 * Version:           1.0.0
 * Author:            Mindspun
 * Author URI:        https://www.mindspun.com
 * Requires at least: 6.2
 * Requires PHP:      7.4
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

require __DIR__ . '/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * Add a simple settings page.
 * repo_demo_options has two properties:
 *  - repo_demo_url:  The URL of the repo to update from.  You'd likely hard-code this value in your plugin.
 *  - repo_demo_license_key: The user-input license key of this plugin instance.
 */
require __DIR__ . '/admin.php';

const REPO_DEMO_URL = 'http://localhost/wp-json/mindspun/payments/v1/repo/repo-demo';
const REPO_DEMO_SLUG = 'repo-demo';

$repo_demo_options = get_option( 'repo_demo_options', array('repo_demo_url' => REPO_DEMO_URL) );

PucFactory::buildUpdateChecker(
    $repo_demo_options['repo_demo_url'],
    __FILE__,
    REPO_DEMO_SLUG
);

/**
 * Add the license key to the request.  Otherwise the repo show no updates available.
 */
add_filter( 'puc_request_info_options-' . REPO_DEMO_SLUG, function ( array $options ) {
	$repo_demo_options = get_option( 'repo_demo_options', array() );
	$headers                  = $options['headers'] ?? array();
	$headers['X-License-Key'] = $repo_demo_options['repo_demo_license_key'] ?? '';
	$options['headers']       = $headers;
	return $options;
} );
