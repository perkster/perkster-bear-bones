<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's Functions and Definitions
 *
 *
 * @file           	functions.php
 * @package        	Bear Bones
 * @url		http://perkstersolutions.com/bear-bones/
 * @author         	Wendy Shoef
 * @copyright      	2014 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */
 
 


 require_once locate_template('includes/admin.php');
 require_once locate_template('includes/cleanup.php');
 require_once locate_template('includes/customizer.php');
 require_once locate_template('includes/posts.php');
 require_once locate_template('includes/scripts.php');
 require_once locate_template('includes/theme-support.php');
 require_once locate_template('includes/menu.php');
 require_once locate_template('includes/widgets.php'); 
 require_once locate_template('includes/woocommerce.php');
 require_once locate_template('includes/yoast.php');
 
 
 
 
/* @TODO: Add <?php posts_nav_link(); ?> to archive, category, tag, search, index */

//@TODO: Author plugin - 
//@TODO: clean up echo's for multi-language
//@TODO: Comments


 ?>