<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The Template for displaying all pages.
 *
 */
get_header('custom'); ?>
<!-- page.php -->
	<?php bear_bones_main_start(); ?>
	<?php get_template_part ( 'tpl', 'content' ); ?>
	<?php bear_bones_main_end(); ?>
<?php get_footer('custom'); ?>