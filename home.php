<?php
/**
 * The blog template file
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header('custom'); 
$postID = $post->ID;?>
<!-- index.php -->
<div id="blk-content" class="block--content">
	<div class="content-wrapper">
		<div class="content-inner">
		<div class="block--main-content">
	<?php //Check if sidebar should be displayed on the left/before content
		if( bb_sidebar('left', true) ) get_template_part ('sidebar'); 
	?>
		  <div class="main-content-wrapper">
			<main role="main" id="main" class="main-content  main-content--blog">		
					<?php bb_yoast_breadcrumb(); ?>
					<?php bb_display_widget( get_post_meta( get_option('page_for_posts'), 'widget-top', true ) ); ?>
					<?php
						$blogTitle = get_theme_mod( 'blog__title' );
						if( $blogTitle ) {
							echo "<h1>$blogTitle</h1>";
						}
					?>
					<?php get_template_part ( 'tpl', 'content-list' ); ?>
					<?php bb_display_widget( get_post_meta( get_option('page_for_posts'), 'widget-bottom', true ) ); ?>
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