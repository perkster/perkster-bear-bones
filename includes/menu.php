<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Core functions 
 *
 *
 * @file           	menu.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013-2014 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/menu.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0.3
 */

 
 /***************************** MENU ***************************/
/** * Replace various active menu class names with "active"
 */
 add_filter('wp_nav_menu', 'bb_wp_nav_menu_current_active');
function bb_wp_nav_menu_current_active($text) {
  $replace = array(
    'current_page_item'     => 'active',
    'current_page_parent'   => 'active-parent',
    'current_page_ancestor' => 'active-ancestor',
  );

  $text = str_replace(array_keys($replace), $replace, $text);
  return $text;
}


/***************************** MENU ***************************/

add_filter( 'nav_menu_link_attributes', 'bb_nav_menu_link_class', 10, 3 );
function bb_nav_menu_link_class( $atts, $item, $args ) {
	if ( is_array ( $args->container_class ) ) {
		$class = $args->container_class[0];
	} elseif (  $args->container_class ) {
		$class = $args->container_class;
	} elseif ( $args->theme_location ) {
		$class = $args->theme_location;
	} else {
		$class = $args->menu->slug;
	}
	$classes = $class . '__link ';
	if($item->menu_item_parent > 0 ) {
		$classes .=  ' sub-menu__link ';
		$classes .= $class . '__sub-menu-link ';
	}
	$atts["class"] = $classes;
    return $atts;
}

add_filter( 'wp_nav_menu_objects', 'bb_nav_menu_item_class', 10, 2 );
function bb_nav_menu_item_class( $objects, $args ) {
	if ( is_array ( $args->container_class ) ) {
		$class = $args->container_class[0];
	} elseif (  $args->container_class ) {
		$class = $args->container_class;
	} elseif ( $args->theme_location ) {
		$class = $args->theme_location;
	} else {
		$class = $args->menu->slug;
	}
	foreach($objects as $object) {
		array_push($object->classes, $class . '__item');
		if($object->menu_item_parent > 0 ) {
			array_push($object->classes, 'sub-menu__item');
			array_push($object->classes, $class . '__sub-menu-item');
		}
	}

	// Return the menu objects
    return $objects;
}
add_filter('wp_nav_menu_args', 'bb_nav_menu_args');	


function bb_nav_menu_args($args = '') {
//prar($args);
  $bb_nav_menu_args['container']  = false;

  if (!$args['items_wrap']) {
    $bb_nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
  }
  if( isset(  $args['menu']->slug ) ) $bb_nav_menu_args['menu_class'] = 'menu-' . $args['menu']->slug;


  return array_merge($args, $bb_nav_menu_args);
}


function bear_bones_add_span_social_menu( $args )
{
	if ( isset( $args['menu']->name )  && $args['menu']->name != '' ) {
		if( strpos ( $args['menu_class'], 'social' )  > 0 ) {
			$args['link_before'] = '<span>';
			$args['link_after'] = '</span>';
		}
	}
	return $args;
}

add_filter( 'wp_nav_menu_args', 'bear_bones_add_span_social_menu' );


?>