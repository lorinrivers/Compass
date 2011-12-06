<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Compass Learning Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/genesis' );

/** Add support for custom background */
add_custom_background();

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 90 ) );

/** Add support for 3-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 3 );

/** Auto-Notify Editors */
add_action( 'ef_init', 'ef_x_init_email_all_admins' );
function ef_x_init_email_all_admins() {
	add_filter( 'ef_notification_recipients', 'ef_x_email_all_admins', 10, 3 );
}

function ef_x_email_all_admins( $recipients, $post, $return_as_string ) {
	$admins = ef_x_get_users_in_role( 'editor' );
	if( ! empty( $admins ) ) {
		foreach( $admins as $admin ) {
			$recipients[] = $admin->user_email;
		}
	}
	return $recipients;
}

function ef_x_get_users_in_role( $role ) {
	$users = array();
	if( function_exists( 'get_users' ) ) {
		$users = get_users( array( 'role' => $role ) ); 
	} elseif( class_exists( 'WP_User_Search' ) ) {
		global $wpdb;
		$wp_user_search = new WP_User_Search( '', '', $role );
		foreach( $wp_user_search->get_results() as $user_id ) {
			$users[] = new WP_User( $user_id );
		}
	}
	return $users;
}
