<?php
/**
 * The Template for displaying all single posts.
 *
 */

get_header(); ?>
<!-- single.php -->
<div class="bb_grid">
<?php 
	$use_sidebar = get_theme_mod('use_sidebar');
	
	if($use_sidebar) {
		$sidebar_left = get_theme_mod('sidebar_left');
		$sidebar_class = get_theme_mod('sidebar_layout');
		$main_content_class = 'bb_grid__item '.bear_bones_layout_class($sidebar_class);
		if($sidebar_left) {
			get_sidebar(); 
		}
	} else {
		$main_content_class = null;
	}
?>	
<!--single.php-->
	<div class="bb_grid__item block--content">
		<section id="content" role="main" class="page_content page_content--single" >
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
		</section><!-- #content -->
	</div>
<?php
	if($use_sidebar && !$sidebar_left) {
		get_sidebar(); 
	}
?>
</div>
<?php get_footer(); ?>