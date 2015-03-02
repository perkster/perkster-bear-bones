<?php
/*
Template Name: Coded Content

NOTES: Copy this file to your child theme to code content into the file directly. 
Useful for developing instead of cosnstantly saving pages to the database and refreshing.
This is a duplicate of page.php

*/
get_header('custom'); ?>
<!-- page-coded-content.php -->
	<?php bear_bones_main_start(); ?>
	<?php get_template_part ( 'tpl', 'content' ); ?>
	<?php bear_bones_main_end(); ?>
<?php get_footer('custom'); ?>