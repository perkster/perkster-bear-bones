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
<!-- index.php -->
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
					<?php if($post) bb_display_widget( get_post_meta( $post->ID, 'widget-top', true ) ); ?>
					<?php
						if ( is_404() ) {
							get_template_part ( 'tpl', 'error' );
						} else {
							get_template_part ( 'tpl', 'content' );
						}
					?>
					<?php  ?>
					<?php if($post) bb_display_widget( get_post_meta( $post->ID, 'widget-bottom', true ) ); ?>
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