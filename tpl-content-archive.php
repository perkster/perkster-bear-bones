<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl-content-archive -->
<h1 class="archive-title"><?php single_cat_title( '', true ); ?></h1>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php /*$myCats = array(24, 27); ?>
	<?php if(in_category($myCats)) continue; */?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(array('archive-list__item') ); ?>>
	  <a href="<?php the_permalink(); ?>" rel="bookmark" class="post-list__link">
	<?php  //bb_display_widget(get_post_meta($post->ID, 'widget-top', true)); ?>
		<?php 
					if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
				?>
					<div class="post-list__image archive-list__image">
						<?php the_post_thumbnail( 'post-thumbnail' ); ?>
					</div>
				<?php 
					} 
				?>
		<div class="archive-list__text">
		<header class="entry-header post-header">
	<?php 	the_title( '<p class="entry-title archive-list__title">', '</p>' ); ?>	
		</header><!-- .entry-header --><div class="entry-content archive-list__excerpt">
			<?php bb_excerpt( 30 ); ?>
		</div><!-- .entry-content -->
		</div>
	  </a>
	  <?php //Display edit link
				edit_post_link( __( 'Edit', 'bearbones' ), '<span class="edit-link">', '</span>' ); ?>
	</article>
			
	<?php endwhile; ?>
            
<?php else : ?>
        <h2>Not Found</h2>
<?php endif; ?><!-- end Content -->
<div class="posts_nav_links">
	<?php posts_nav_link(); ?>
</div>
<!-- end .tpl-content-list -->