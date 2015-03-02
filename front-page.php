<?php
/**
 * The front page file (static front page)
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php get_header('front-page'); ?>
<!-- front-page.php -->
<?php bear_bones_main_start( array ('tplVariable' => 'front-page') ); ?>
<?php get_template_part( 'tpl', 'content' ); ?>
<?php bear_bones_main_end( array ('tplVariable' => 'front-page') ); ?>
<?php get_footer('front-page'); ?>