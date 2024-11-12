<?php
/*
Plugin Name: MRW Functionality Plugin
Description: Standard Tweaks to WP functions for all sites by MRW Web Design
Version: 1.0
Author: Mark Root-Wiley, MRW Web Design
Author URI: https://MRWweb.com
*/

namespace MRW\Admin;

if( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    add_action( 'admin_init', function () {
        define( 'DISALLOW_FILE_EDIT', true );
    } );
}

add_action('init', __NAMESPACE__ . '\cleanup_head');
// Clean up the <head>
function cleanup_head() {
	// No generators and manifests
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	// RSS links in <head>
	add_theme_support( 'automatic-feed-links' );
}

add_action( 'init', __NAMESPACE__ . '\page_post_type_supports' );
function page_post_type_supports() {
	remove_post_type_support( 'page', 'comments' );
    add_post_type_support( 'page', 'excerpt' );
    add_post_type_support( 'page', 'post-thumbnail' );
}

add_action( 'pre_ping', __NAMESPACE__ . '\no_self_ping' );
// It's rude to ping yourself in public.
// c/o: http://wp-snippets.com/disable-self-trackbacks/
function no_self_ping( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, home_url() ) )
            unset($links[$l]);
}

add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\cleanup_admin_bar' );
function cleanup_admin_bar() {
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('customize');
    $wp_admin_bar->remove_menu('search');

    // Plugin-specific
    $wp_admin_bar->remove_menu('edd-store-menu'); // easy digital downloads
    $wp_admin_bar->remove_menu('content_audit'); // content audit plugin
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_styles' );
function admin_styles() { 
	wp_enqueue_style(
		'custom-admin',
		plugins_url( '/custom-admin-styles.css', __FILE__ ),
		array(),
		'1.0.0'
	);
}

add_action( 'admin_menu', __NAMESPACE__ . '\reorder_admin_menu', 9999 );
function reorder_admin_menu() {
    global $menu;

    // add a separator
    $menu["31.56465"] =  array('','read','separator2','','wp-menu-separator');
    $menu["53.98435"] =  array('','read','separator3','','wp-menu-separator');

	// hide the PublishPress "Author Profile" page since you can edit it just as easily from the Authors page
	unset($menu['26.8']);

    // default_position => new_position
    $menu_swap = array(
        // Post Types
		20 => '4.5', // pages
		5 => '4.659', // posts
        10 => '57.65498', // Media Library

        // Plugins
		6 => '9.59864', // The Events Calendar with other Post Types
		30 => '30.26456', // WP Jobs Manager with other Post Types
		26 => '57.98479', // Easy Digital Downloads close to Media Library
        '16.9' => '58.56849', // Gravity Forms Close to Media Library
		'26.7' => '68.686544', // PublishPress Authors close to Users
		'58.95' => '80.1264', // Searchwp close to settings
		3 => '1654987.9867498', // Jetpack
    );

    foreach( $menu_swap as $orig => $new ) {
        if( array_key_exists($orig, $menu) ) {
            $menu[$new] = $menu[$orig];
            unset($menu[$orig]);
        }
    }	

}


add_action( 'admin_menu', __NAMESPACE__ . '\add_template_parts_menu_item', 9999 );
function add_template_parts_menu_item() {
	add_submenu_page(
		'themes.php', 
		'', 
		'Template Parts',
		'manage_options',
		'site-editor.php?postType=wp_template_part',
		'',
		1
	);
}

add_shortcode( 'email', __NAMESPACE__ . '\hide_email');
// Hide Email from Spam Bots using a short code place this in your functions file
// codex.wordpress.org/Function_Reference/antispambot
function hide_email($atts , $content = null ){
	if ( ! is_email ($content) )
		return;

	return '<a href="mailto:'.antispambot($content).'">'.antispambot($content).'</a>';
}

// Style the Login Screen
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\login_styles' );
function login_styles() { ?>
    <style type="text/css">
    	body.login {
    		background-color: ;
    	}
    	body.login div#login h1 {
    		text-align: center;
    	}
        body.login div#login h1 a {
            background-image: url(<?php echo get_theme_file_uri( 'assets/images/logo.png' ); ?>);
            background-size: contain;
            background-position: center;
            width: 600px;
            height: auto;
            aspect-ratio: {logo aspect ratio};
            max-width: 100%;			
        }
		#loginform {
			background-color: ;
			border-color: ;
		}
		#wp-submit {
			background-color: ;
			border-color: ;
		}
		a,
        body.login #nav a,
        body.login #backtoblog a {
        	color: ;
        }
    </style>
<?php }

add_filter( 'login_headerurl', __NAMESPACE__ . '\login_logo_url' );
function login_logo_url() {
	return esc_url( get_bloginfo( 'url' ) );
}

add_filter( 'login_headertext', __NAMESPACE__ . '\login_logo_url_title' );
function login_logo_url_title() {
	return esc_html( get_bloginfo( 'name' ) );
}
