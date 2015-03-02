<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl- Content-Single --><?php $postID = get_the_id(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post();?>
	<article id="post-<?php echo $postID; ?>" <?php post_class(); ?>>
		<?php
		$noTitle = get_post_meta( $postID, 'no-title', true) ; //prar("NoTitle: $noTitle");
		$display_featured = get_theme_mod( 'posts__display_featured' ); //prar( $display_featured );
		if( $display_featured ) {
			if ( has_post_thumbnail() ) { // check if the post has a featured image assigned to it.
				$featuredImageClass = get_theme_mod( 'posts__featured_class' );
				$img_attr = array(
					'class'	=> $featuredImageClass,
				);
				$featuredImage = '<div class="post-featured-image">' . get_the_post_thumbnail( get_the_ID(),  'post-featured', $img_attr ) . '</div>';
			} 
		}
		if( $display_featured == 'before_title' && isset( $featuredImage) ) echo $featuredImage;
		if( !$noTitle ) {
			?>		
			<header class="entry-header post-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' );	?>	
			</header><!-- .entry-header --><?php
		}
		if( $display_featured == 'after_title' && isset( $featuredImage) ) echo $featuredImage; 
		
		bb_posts_meta();
		?>
		<div class="entry-content post-content">
			<?php the_content(); ?>
			<?php bb_page_nav_links(); ?>
			<?php //Display edit link
				edit_post_link( __( 'Edit', 'bearbones' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-content -->
		<?php get_template_part ('tpl', 'post-footer'); ?>
			
	</article>
			
	<?php endwhile; ?>
            
<?php else : ?>
        <h2>Not Found</h2>
<?php endif; ?><!-- end Content -->
<!-- end .tpl-content -->