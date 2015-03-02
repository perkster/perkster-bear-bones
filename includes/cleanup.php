<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


/**
 *  Cleanup functions 
 *
 *
 * @file           	cleanup.php
 * @package        	Bear Bones 
 * @url		http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.1
 * @filesource     	wp-content/themes/bear-bones/includes/functions.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 
 
 @description	Wordpress head is a real mess plus there's a bunch of other little things that are quite annoying.
 */

add_action('init', 'bear_bones_cleanup');
 
function bear_bones_cleanup() {
	// @link  http://wpengineer.com/1438/wordpress-header/
	// post and comment feeds
	remove_action('wp_head', 'feed_links', 2);
	//category feeds
	remove_action('wp_head', 'feed_links_extra', 3);
	//EditURI link
	remove_action('wp_head', 'rsd_link');
	//windows live writer
	remove_action('wp_head', 'wlwmanifest_link');
	//WP version
	remove_action('wp_head', 'wp_generator');
	//remove links
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	//links for adjacent posts
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	
	add_action('widgets_init', 'bb_remove_recent_comments_style');
	
	 // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'bb_remove_wp_widget_recent_comments_style', 1 );

	
	// remove WP version from css
	add_filter( 'style_loader_src', 'bb_remove_wp_cssjs_ver', 9999 );
	
	// remove Wp version from scripts
	add_filter( 'script_loader_src', 'bb_remove_wp_cssjs_ver', 9999 );
	
	// remove WP version from RSS
    add_filter('the_generator', 'bb_rss_version');
	
	// clean up gallery output in wp
    add_filter('gallery_style', 'bb_gallery_style');
 
} /* end bb_head_cleanup */

 
 // Remove the annoying:
// <style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style> added in the header
// @link https://snipt.net/c10b10/remove-recent-comment-style-added-in-the-wp_head/
function bb_remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}


// remove injected CSS for recent comments widget
function bb_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

//Remove wp version in css and js files
// @link http://wordpress.org/support/topic/get-rid-of-ver-on-the-end-of-cssjs-files
function bb_remove_wp_cssjs_ver( $src ) {
	if( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

// remove WP version from RSS
function bb_rss_version() { return ''; }

// remove injected CSS from gallery
function bb_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


function remove_recent_comments_style() {
    global $wp_widget_factory;
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'remove_recent_comments_style');



?>