<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Admin functions 
 *
 *
 * @file           	admin.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/admin.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */

 /* 
	Login Logo
	- Option to use different logo for login
	- uplaod login logo from theme customizer 
	- save location
 */
 
 /* 
	Display login logo
	- Retrieve logo if uses different logo then main
	- display css information
 *
function bear_bones_login_logo() { 
	/*global $bb_admin_login_logo_url;
	list($width, $height, $type, $attr) = getimagesize($bb_admin_login_logo_url);
?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo $bb_admin_login_logo_url; ?>);
			background-size: <?php echo $width; ?>px <?php echo $height; ?>px;
            padding-bottom: 30px;
			height: <?php echo $height; ?>px;
			width: <?php echo $width; ?>px;
        }
    </style>
<?php *
}
add_action( 'login_enqueue_scripts', 'bear_bones_login_logo' );

function bear_bones_login_url() {
   // return $bb_admin_login_url;
}
add_filter( 'login_headerurl', 'bear_bones_login_url' );

function bear_bones_login_text() {
   // return $bb_admin_login_text;
}
add_filter( 'login_headertitle', 'bear_bones_login_text' );
*/

function prar($array = null, $debug = false, $noAdmin = false) {
	if ( ( is_user_logged_in() && current_user_can( 'manage_options' ) ) || $noAdmin ) {
		echo '<pre>';
		if( $debug ) debug_print_backtrace();
		if( is_object( $array ) ) {
			print_r ($array);
		} elseif( is_array( $array ) ) {
			print_r( $array );	
		} elseif( !is_null( $array ) ) {
			$string = esc_html( $array );
			echo "<p> $string</p>";
		}
		echo '</pre>';
	}
}

function bear_bones_title(  ) {
	if( get_bloginfo ( 'name' ) == 'LOCALHOST' ) {
		$title =  wp_get_theme();
		global $post; 
		if($post) $title .= ' - ' . $post->post_title;
		return $title;
	} 	
}
add_filter( 'wp_title', 'bear_bones_title', 10, 2 );

function bear_bones_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'bear_bones_login_logo_url' );

function bear_bones_login_logo() {
	$logo =  get_theme_mod('site_logo');
	 if( $logo ) {		
		//prar($logo, false, true);
		list($width, $height, $type, $attr) = getimagesize( $logo );
		//prar( $attr, false, true );
		$widthHeight = $width . 'px ' . $height . 'px';
	 ?>
		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo $logo; ?>);
				padding-bottom: 30px;
				-webkit-background-size: <?php echo $widthHeight; ?>;
				background-size: <?php echo $widthHeight; ?>;
				width: <?php echo $width; ?>px;
				height: <?php echo $height; ?>px;
			}
		</style>
	<?php 
	}
}
add_action( 'login_enqueue_scripts', 'bear_bones_login_logo' );
?>