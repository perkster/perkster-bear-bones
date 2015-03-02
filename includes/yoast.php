<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Yoast plugin functions - place to work with the yoast functions that are available
 *
 *
 * @file           	yoast.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/yoast.php
 * @since          	available since Release 1.0.7
 */
 

/************ YOAST SUPPORT ******************/
function bb_yoast_breadcrumb ($display = true) {
	if ( get_theme_mod( 'yoast_breadcrumb' ) &&  function_exists('yoast_breadcrumb') ) {
		if( !is_front_page() ) yoast_breadcrumb('<div class="yoast-breadcrumbs"><p id="breadcrumbs" class="yoast-breadcrumbs__links>','</p></div>', $display);
	} 
}
?>