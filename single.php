<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * The Template for displaying all single posts.
 *
 */

get_header('custom'); ?>
<!-- single.php -->
<?php bear_bones_main_start( array ('tplVariable' => 'single' ) ); ?>
				<?php get_template_part ( 'tpl', 'content-single' ); ?>
<?php bear_bones_main_end(  array ('tplVariable' => 'single' ) ); ?>
<?php get_footer('custom'); ?>