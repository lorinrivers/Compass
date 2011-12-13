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

/** Global removal of Genesis features **/
remove_action('genesis_before_post_content', 'genesis_post_info');
remove_action('genesis_after_post_content', 'genesis_post_meta');
remove_action('genesis_after_endwhile', 'genesis_posts_nav');

/** Auto-Notify Editors via EditFLow */
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

/** 
Title
Link
Description
Author/photo/graphic (optional)
**/

// Create applications metaboxes
$prefix = '_lr_';
add_filter( 'cmb_meta_boxes', 'lr_create_metaboxes' );
function lr_create_metaboxes( $meta_boxes ) {
	global $prefix;
  $meta_boxes[] = array(
    'id' => 'related',
    'title' => 'Related Content',
    'pages' => array(     //post type
      'post',
      'page'
    ), 
    'context' => 'normal',
    'priority' => 'high',
    'show_names' => true, //Show field names left of input
    'fields' => array(
      array(
        'name' => 'Title',
        'desc' => 'Title of Related Content',
        'id' => $prefix.'related_title',
        'type' => 'text'
      ),
      array(
        'name' => 'Link',
        'desc' => 'URL of Related Content',
        'id' => $prefix.'related_link',
        'type' => 'text'
      ),
      array(
        'name' => 'Description',
        'desc' => 'General description (like a post’s content)',
        'id' => $prefix.'related_description',
        'type' => 'wysiwyg',
				'options' => array(
					'textarea_rows' => 5,
				)      
			),
      array(
        'name' => 'Related Image',
        'desc' => 'Upload an image or enter an URL.',
        'id' => $prefix.'related_image',
        'type' => 'file'
      ),
    ),
  );

  return $meta_boxes;

}


// Initialize the metabox class
add_action( 'init', 'lr_initialize_cmb_meta_boxes', 9999 );
function lr_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( CHILD_DIR . '/lib/metabox/init.php' );
	}
}