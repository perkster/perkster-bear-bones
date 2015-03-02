<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 *  Core functions 
 *
 *
 * @file           	scripts.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @license        	license.txt
 * @copyright      	2013-2014 Perkster Solutions
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.3/includes/scripts.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */

/* Make sure all scripts are in the footer rather than the header */
function ps_footer_enqueue_scripts() {
	$js_in_footer = get_theme_mod('js_footer');
	if($js_in_footer) {
		remove_action('wp_head', 'wp_print_scripts');
		remove_action('wp_head', 'wp_print_head_scripts', 9);
		remove_action('wp_head', 'wp_enqueue_scripts', 1);
	}
}
add_action('wp_enqueue_scripts', 'ps_footer_enqueue_scripts');



function bear_bones_scripts() {

   $bb_template_dir = get_template_directory_uri(); //bear bones theme
   $stylesheet_dir = get_stylesheet_directory_uri(); // child theme if there is one

	if (is_child_theme()) {
	//if override style is not selected, then include bear_bones_parent_style
		if( get_theme_mod( 'include_parent_style' ) ) {
			wp_enqueue_style('bear_bones_parent_style', $bb_template_dir.'/style.css');		
		} 
	} 
	$version = filemtime( bb_main_style( 'returnFile' ) );
	//prar( $version );
	
	wp_enqueue_style('main_style', bb_main_style(), null, $version);
	
	//Include external css files
	$bb_included_css = get_theme_mod( 'included_css' );
	if( isset( $bb_included_css ) ) {
		$styles = explode(";" , $bb_included_css);
		$i = 1;
		foreach( $styles as $style ) {
			$style = trim( $style );
			wp_register_style( 'included_css' . $i, $style, null, null, 'all');
			wp_enqueue_style ( 'included_css' . $i);
			$i++;
		}
	}
	
	//Check to see if jquery is included in theme
	$bb_include_jquery = get_theme_mod( 'bb_include_jquery' );
	
	bear_bones_modernizr( $bb_template_dir );
	
	//Load jquery-ui-tabs include_jquery_ui_tabs, 
	if( get_theme_mod( 'include_jquery_ui_tabs' ) ) {
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		//set jquery to be loaded regardless of theme setting
		$bb_include_jquery = true;
	}
	
	//Load jquery-ui-tabs include_jquery_ui_tabs, 
	if( get_theme_mod( 'include_jquery_ui_accordion' ) ) {
		wp_enqueue_script( 'jquery-ui-core' );
		//wp_enqueue_script( 'jquery-ui-tabs' );
		//set jquery to be loaded regardless of theme setting
		$bb_include_jquery = true;
		wp_enqueue_script('jquery-ui-accordion');
	}
	
	//Load jquery if required. Use enqueue so as not to conflict with other plugins that call it, too
	//Please, please, please don't call jQuery from a CDN or deregister the script and enqueue a different version
	//If you do, you will probably have massive amounts of problems with plugins on your website!
	if(isset($bb_include_jquery)) {
		wp_enqueue_script('jquery');
	}
	
	//Load extra js scripts
	$bb_custom_js_scripts = get_theme_mod( 'included_js_scripts' );
	if( isset( $bb_custom_js_scripts ) && $bb_custom_js_scripts != '' ) {
		$scripts = explode( ";" , $bb_custom_js_scripts );
		$i = 1;
		foreach($scripts as $script) {
			$script = trim($script);
			//check for external script
			if(strpos($script, '//')) {
				wp_register_script( 'included_js' . $i, $script );
				wp_enqueue_script ( 'included_js' . $i, $script, null, null, true );
			//if not external then load relative to the stylesheet directory
			} else {
				$path_parts = pathinfo($script);
				wp_register_script( $path_parts['filename'], $stylesheet_dir . $script );
				wp_enqueue_script ( $path_parts['filename'], $stylesheet_dir . $script, null, null, true );
			}
			$i++;
		}
	}
	
	//Include custom.js if it exists.  First check for minified, then for regular
	/*
	if( file_exists( get_stylesheet_directory()  . '/js/min/custom.min.js' ) ) {
		wp_register_script( 'custom_js',  $stylesheet_dir .'/js/min/custom.min.js' );
		wp_enqueue_script ('custom_js', $stylesheet_dir . '/js/min/custom.min.js', null, null, true );
	} elseif( file_exists( get_stylesheet_directory()  . '/min/custom.min.js' ) ) {
		wp_register_script( 'custom_js', $stylesheet_dir . '/min/custom.min.js' );
		wp_enqueue_script ('custom_js', $stylesheet_dir . '/min/custom..min.js', null, null, true );
	} elseif( file_exists( get_stylesheet_directory()  . '/js/custom.min.js' ) ) {
		wp_register_script( 'custom_js',  $stylesheet_dir .'/js/custom.min.js' );
		wp_enqueue_script ('custom_js', $stylesheet_dir . '/js/custom.min.js', null, null, true );
	} elseif( file_exists( get_stylesheet_directory()  . '/custom.min.js' ) ) {
		wp_register_script( 'custom_js',  $stylesheet_dir .'/custom.min.js' );
		wp_enqueue_script ('custom_js', $stylesheet_dir . '/custom.min.js', null, null, true );
	} elseif( file_exists( get_stylesheet_directory()  . '/js/custom.js' ) ) {
		wp_register_script( 'custom_js', $stylesheet_dir . '/js/custom.js' );
		wp_enqueue_script ('custom_js', $stylesheet_dir . '/js/custom.js', null, null, true );
	} elseif( file_exists( get_stylesheet_directory()  . '/custom.js' ) ) {
		wp_register_script( 'custom_js', $stylesheet_dir . '/custom.js' );
		wp_enqueue_script ('custom_js', $stylesheet_dir . '/custom.js', null, null, true );
	}
	*/
	bb_local_script( 'custom' );

	
	$bb_custom_css = get_theme_mod( 'custom_css' );
	if(isset($bb_custom_css)) {
		wp_add_inline_style( 'custom_css', $bb_custom_css );
	}
	
	if(  get_theme_mod( 'background_image' )  ) {
		
		wp_add_inline_style( 'background_image', bb_custom_background_size() );
	}
	
}

add_action('wp_enqueue_scripts', 'bear_bones_scripts', 100);


function bb_local_script($file = null, $ext = 'js', $return = false ) {
	if ($file) {
		
		$bb_template_dir = get_template_directory_uri(); //bear bones theme
		$stylesheet_dir = get_stylesheet_directory_uri(); // child theme if there is one
		$enq = false;
		
		//Include custom.js if it exists.  First check for minified, then for regular
		//if( file_exists( get_stylesheet_directory()  . '/js/min/custom.min.js' ) ) {
		if( file_exists( get_stylesheet_directory()  . '/' . $ext . '/min/' . $file . '.min.' . $ext . '' ) ) {
			wp_register_script( $file,  $stylesheet_dir .'/' . $ext . '/min/' . $file . '.min.' . $ext . '' );
			wp_enqueue_script ($file, $stylesheet_dir . '/' . $ext . '/min/' . $file . '.min.' . $ext . '', null, null, true );
			$enq = true;
		} elseif( file_exists( get_stylesheet_directory()  . '/min/' . $file . '.min.' . $ext . '' ) ) {
			wp_register_script( $file, $stylesheet_dir . '/min/' . $file . '.min.' . $ext . '' );
			wp_enqueue_script ($file, $stylesheet_dir . '/min/' . $file . '..min.' . $ext . '', null, null, true );
			$enq = true;
		} elseif( file_exists( get_stylesheet_directory()  . '/' . $ext . '/' . $file . '.min.' . $ext . '' ) ) {
			wp_register_script( $file,  $stylesheet_dir .'/' . $ext . '/' . $file . '.min.' . $ext . '' );
			wp_enqueue_script ($file, $stylesheet_dir . '/' . $ext . '/' . $file . '.min.' . $ext . '', null, null, true );
			$enq = true;
		} elseif( file_exists( get_stylesheet_directory()  . '/' . $file . '.min.' . $ext . '' ) ) {
			wp_register_script( $file,  $stylesheet_dir .'/' . $file . '.min.' . $ext . '' );
			wp_enqueue_script ($file, $stylesheet_dir . '/' . $file . '.min.' . $ext . '', null, null, true );
			$enq = true;
		} elseif( file_exists( get_stylesheet_directory()  . '/' . $ext . '/' . $file . '.' . $ext . '' ) ) {
			wp_register_script( $file, $stylesheet_dir . '/' . $ext . '/' . $file . '.' . $ext . '' );
			wp_enqueue_script ($file, $stylesheet_dir . '/' . $ext . '/' . $file . '.' . $ext . '', null, null, true );
			$enq = true;
		} elseif( file_exists( get_stylesheet_directory()  . '/' . $file . '.' . $ext . '' ) ) {
			wp_register_script( $file, $stylesheet_dir . '/' . $file . '.' . $ext . '' );
			wp_enqueue_script ($file, $stylesheet_dir . '/' . $file . '.' . $ext . '', null, null, true );
			$enq = true;
		}
		if($return) return $enq;
	}
}
/*
 * Check to see if style has been overridden 
 */
 
function bb_main_style ( $returnFile = false) {
	$main_style = get_theme_mod ( 'main_style' );
	if( $main_style != 'style' ) {
		if( substr( $main_style, 1 , 1 ) != '/' ) $main_style = '/' . $main_style;
		if( substr( $main_style, -4, 4 ) != '.css' ) $main_style .= '.css';
		$main_style =  $main_style;
	}

	if( file_exists ( get_stylesheet_directory() . $main_style ) ) {
		if( $returnFile ) {
			$main_style = get_stylesheet_directory() . $main_style;
		} else {
			$main_style = get_stylesheet_directory_uri() . $main_style;
		}
		
	} else {
		if( $returnFile ) {
			$main_style = get_stylesheet_directory() . '/style.css';
		} else {
			$main_style = get_stylesheet_uri();
		}
		
	}		
	
	//check to see if user is admin
	$current_user = wp_get_current_user();
	if (user_can( $current_user, 'administrator' )) {
	// user is an admin
		//check if override
		if( get_theme_mod( 'use_admin_style' )) {
			$admin_style = get_theme_mod('admin_style');
			//check if file exists 
			if( file_exists ( $admin_style ) ) $main_style = $admin_style;
			if( file_exists ( get_stylesheet_directory() . '/' . $admin_style ) ) {
				if( $returnFile ) {
					$main_style = get_stylesheet_directory() . '/' . $admin_style;
				} else {
					$main_style = get_stylesheet_directory_uri() . '/' . $admin_style;
				}
			}
		}
	}
	//prar($main_style);
	return $main_style;
}

function bb_custom_background_size () {
	$background_size = get_theme_mod( 'background_image_size' );
	$custom_background_size = 
		"body.custom-background {
			background-size: $background_size;
		}";
	return $custom_background_size;
}


function bear_bones_modernizr( $bb_template_dir = null ) {
	//Load modernizr include_modernizr, 
	$modernizr = get_theme_mod( 'include_modernizr' );
	if( $modernizr ) {
		$modernizrLocation = $bb_template_dir .'/js/modernizr.custom.82446.js';
		if(	$modernizr == 'cdn' ) {
			$modernizrCDNUrl = 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js';
			if ( checkCDN( $modernizrCDNUrl ) ) $modernizrLocation = $modernizrCDNUrl;				
		}
		wp_register_script( 'modernizr',  $modernizrLocation );
		wp_enqueue_script ('modernizr', $modernizrLocation, null, null, true );
		
	}
}

//Function came from http://wordpress.stackexchange.com/questions/147238/wp-enqueue-script-using-scripts-from-cdn-with-a-safety-callback
function checkCDN ( $the_cdn_url = false ) {

	if($the_cdn_url) {

		$cdnIsUp = get_transient( 'cnd_is_up' ); //prar($cdnIsUp);

		if ( $cdnIsUp ) {

			$load_source = true;

		} else {

			$cdn_response = wp_remote_get( $the_cdn_url ); //prar($cdn_response);

			if( is_wp_error( $cdn_response ) || wp_remote_retrieve_response_code($cdn_response) != '200' ) {

				$load_source = false;

			}
			else {

				$cdnIsUp = set_transient( 'cnd_is_up', true, MINUTE_IN_SECONDS * 20 );
				$load_source = true;
			}
		 }
	}
	return $load_source;

}
?>