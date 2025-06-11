<?php
/**
 * Style the login screen for better branding and security
 *
 * @package _mrw-mu-plugins
 */

namespace _CLIENT\Site;

add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\login_styles' );
/**
 * Style the login screen
 *
 * I'll write a blog post about this one day
 *
 * @return void
 */
function login_styles() {
	?>
	<style type="text/css">
		body.login {
			background-color: ;
		}
		body.login div#login h1 {
			text-align: center;
		}
		body.login div#login h1 a {
			background-image: url(<?php echo esc_url( get_theme_file_uri( 'assets/images/logo.png' ) ); ?>);
			background-size: contain;
			background-position: center;
			width: 600px;
			height: auto;
			aspect-ratio: 3/2;
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
	<?php
}