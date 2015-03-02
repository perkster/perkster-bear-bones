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
<div id="blk-content" class="block--content">
	<div class="content-wrapper">
		<div class="content-inner">
			<div class="block--main-content">
	<?php //Check if sidebar should be displayed on the left/before content
		if( bb_sidebar('left', true) ) get_template_part ('sidebar'); 
	?>
			<div class="main-content-wrapper">
			<main role="main" id="main" class="main-content">	
				<?php bb_yoast_breadcrumb(); ?>
				<?php bb_display_widget( 'page-widget-top' ); ?>
				<?php bb_display_widget( get_post_meta( $post->ID, 'widget-top', true ) ); ?>
				<?php get_template_part ( 'tpl', 'content' ); ?>
				<?php bb_display_widget( get_post_meta( $post->ID, 'widget-bottom', true ) ); ?>
				<?php bb_display_widget( 'page-widget-bottom' ); ?>
			</main><!-- end MAIN CONTENT -->
			</div>
		
	<?php //Check if sidebar should be displayed on the right/after content
		if(bb_sidebar( 'right', true ) ) get_template_part( 'sidebar' ); 
	?>
			</div><!-- end .block--main-content -->
		</div><!-- end .content-inner -->
	</div><!-- end .content-wrapper -->
</div>
<?php get_footer('custom'); ?>