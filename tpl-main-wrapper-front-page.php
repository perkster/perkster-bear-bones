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
			<?php if( isset( $post ) ) bb_display_widget( get_post_meta( $post->ID, 'widget-top', true ) ); ?>