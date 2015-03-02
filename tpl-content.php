<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl- Content --><?php $postID = get_the_id(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header post-header">
	<?php
		if ( is_single() ) {
			//this shouldn't be used as tpl-content-single should be called
		} elseif ( is_page() ) {
			//echo 'is page';
			$useTitle = get_post_meta( $postID, 'use-title', true) ; //prar("useTitle: $useTitle");
			$display_featured = get_theme_mod( 'pages__display_featured' ); //prar( $display_featured );
			if( $display_featured ) {
				if ( has_post_thumbnail() ) { // check if the post has a featured image assigned to it.
					$featuredImageClass = get_theme_mod( 'pages__featured_class' );
					$featuredImageSize = get_theme_mod( 'pages__featured_size' );
					$img_attr = array(
						'class'	=> $featuredImageClass,
					);
					$featuredImage = '<div class="post-featured-image">' . get_the_post_thumbnail( get_the_ID(),  $featuredImageSize, $img_attr ) . '</div>';
				} 
			}
			if( $display_featured == 'before_title' && isset( $featuredImage) ) echo $featuredImage;
			if( $useTitle ) {
				?>		
				<header class="entry-header page-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' );	?>	
				</header><!-- .entry-header --><?php
			}
			if( $display_featured == 'after_title' && isset( $featuredImage) ) echo $featuredImage; 

		} else {
			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
		}
				
		
	?>	
		</header><!-- .entry-header -->
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