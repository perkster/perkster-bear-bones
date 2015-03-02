<div id="blk-content" class="block--content">
	<div class="content-wrapper">
		<div class="content-inner">
			<div class="block--main-content">
	<?php //Check if sidebar should be displayed on the left/before content
		if( bb_sidebar('left', true) ) get_template_part ('sidebar'); 
	?>
			<div class="main-content-wrapper">
			<main role="main" id="main" class="main-content main-content--<?php echo get_post_type( ); ?>">	
				<?php bb_yoast_breadcrumb(); ?>
				<?php bb_display_widget( 'posts-widget-top' ); ?>
				<?php if( isset( $post ) ) bb_display_widget( get_post_meta( $post->ID, 'widget-top', true ) ); ?>