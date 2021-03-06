<?php
if ( ! class_exists( 'WP_Config_Array' ) ) {
	require_once __DIR__ . '/../docroot/wp-content/mu-plugins/class-wp-config-array.php';
}

return call_user_func(function () {

	$env_array = array();
	$default_config_path = __DIR__ . '/default.env.php';
	if ( file_exists( $default_config_path ) ) {
		$env_array = require( $default_config_path );
	}
	$env = new WP_Config_Array( $env_array );

	$env->extend( array(
		'DOMAIN_CURRENT_SITE' => 'vvv.config-driven-wp.dev',
		'DB_NAME' => 'configdrivenwp_dev',
		'DB_USER' => 'configdrivenwp',
		'DB_PASSWORD' => 'configdrivenwp',
		'WP_CACHE' => false,
		'batcache' => false,
		'WP_DEBUG' => true,
		'SCRIPT_DEBUG' => true,
		'CONCATENATE_SCRIPTS' => false,
		'SAVEQUERIES' => true,
		'DISABLE_WP_CRON' => false, // use traditional wp-cron; we can really slam our system if all sites get pinged every minute
	) );

	/**
	 * We can supply temporary environment config changes by returning an array from vvv-overrides.env.php
	 */
	$overrides_config_path = __DIR__ . '/' . str_replace('.env.php', '-overrides.env.php', basename( __FILE__ ));
	if ( file_exists( $overrides_config_path ) ) {
		$env->extend( require( $overrides_config_path ) );
	}

	return $env;
});
