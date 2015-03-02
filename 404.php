<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php get_header('custom'); ?>
<!-- 404.php Edit this-->
	<?php bear_bones_main_start(); ?>
	<?php get_template_part ( 'tpl', 'error' ); ?>
	<?php bear_bones_main_end(); ?>
<?php get_footer('custom'); ?>