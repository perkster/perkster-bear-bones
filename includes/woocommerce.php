<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Woocommerce overrides
 *
 *
 * @file           	woocommerce.php
 * @package        	Bear Bones
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2014 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones/includes/woocommerce.php
 
 * @since          	available since Release 1.0.3
 */
 
add_action('init', 'bear_bones_woocommerce_support');


function bear_bones_woocommerce_support() { 

	if( get_theme_mod ( 'woocommerce_include') ) {
		//WOOCOMMERCE
		add_theme_support( 'woocommerce' );			
	}
	if( get_theme_mod ( 'woocommerce_include_overrides') ) {
		//prar('woocommerce theme mods');
		bear_bones_woocommerce_main_content();
		//bear_bones_woocommerce_();
		//bear_bones_woocommerce_();
		//bear_bones_woocommerce_();
		//bear_bones_woocommerce_();
		//bear_bones_woocommerce_();
	}
	if( !get_theme_mod ( 'woocommerce_use_breadcrumbs') ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	} 
	
}

function bear_bones_woocommerce_main_content() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	add_action('woocommerce_before_main_content', 'bear_bones_woocommerce_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'bear_bones_woocommerce_wrapper_end', 10);
}

function bear_bones_woocommerce_wrapper_start() {
	$atts = array( 'extraHTML' => '<div class="woocommerce">');
	bear_bones_main_start($atts);
}


function bear_bones_woocommerce_wrapper_end() {
	$atts = array ( 'extraHTML' => '</div>');
	bear_bones_main_end($atts);
}

function bear_bones_woocommerce_() {

}

/*
add_action('woocommerce_after_order_notes', 'bear_bones_custom_checkout_note');
 
function bear_bones_custom_checkout_note( $checkout ) {
	//echo 'after_order_notes';
	/*$noteLabel = get_theme_mod ( 'woocommerce_custom_note_label');
	$noteMessage = get_theme_mod ( 'woocommerce_custom_note_message');
	if( $noteLabel || $noteMessage) {
		echo '<div id="bb-custom-checkout-note">';
		if( $noteLabel) echo '<h3>'. $noteLabel .'</h3>';
		if( $noteMessage) echo $noteMessage;
		echo '</div>';
	}
} */

?>