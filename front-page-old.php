<?php
/**
 * The front page file (static front page)
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
?>
<?php get_header('custom'); ?>
<!-- front-page.php -->
<div id="blk-content" class="block--content">
<?php if ( is_active_sidebar( 'home-widget-top' ) ) : ?>
	<div class="home-widget-top-wrapper">
		<div class="home-widget-top-inner">
	<?php bb_display_widget( 'home-widget-top' ); ?>
		</div>
	</div>
<?php endif; ?>
	<div class="home-content-wrapper">
		<div class="home-content-inner">
			<div class="home-content">
			<?php bb_display_widget( get_post_meta( $post->ID, 'widget-top', true ) ); ?>
			  <?php get_template_part( 'tpl', 'content' ); ?>
			<?php bb_display_widget( get_post_meta( $post->ID, 'widget-bottom', true ) ); ?>
			</div>
		</div>
	</div>
<?php if ( is_active_sidebar( 'home-widget-top' ) ) : ?>
	<div class="home-widget-bottom-wrapper">	
		<div class="home-widget-bottom-inner">
	<?php bb_display_widget( 'home-widget-bottom' ); ?>
		</div>
	</div>
<?php endif; ?>
</div>
<?php get_footer('custom'); ?>