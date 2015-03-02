<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl-post-links -->
<?php //prar( get_theme_mod('post_links__display') ); 
if( is_single() && get_theme_mod('post_links__display') ) {
	//Get variables set in customizer
	$prevBefore = get_theme_mod('post_links__previous_before_next');
	$prevPrepend = get_theme_mod('post_links__previous_prepend');
	$prevAppend = get_theme_mod('post_links__previous_append');
	$nextPrepend = get_theme_mod('post_links__next_prepend');
	$nextAppend = get_theme_mod('post_links__next_append');
	$postLinksThumbnail = get_theme_mod('post_links__thumbnail'); //Defaults to thumbnail, if custom size then add_image_size
	$prev_post_link = null;
	$next_post_link = null;
	
	if( $prev_post = get_previous_post() ): 
		if( get_theme_mod( 'post_links__title' ) ) {
			$previousPostLink = get_previous_post_link( '%link',"$prevPrepend%title$prevAppend", TRUE ); 
		} else {
			$previousPostLink = get_previous_post_link( '%link',"$prevPrepend$prevAppend", TRUE ); 
		}
		if($previousPostLink) {
			$prev_post_link = '<div class="post-links-previous">';
			if($postLinksThumbnail) $prev_post_link .= get_the_post_thumbnail( $prev_post->ID, 'post-link-thumbnail', array('class' => 'post-links-previous__image')); 
			$prev_post_link .= $previousPostLink . '</div>';
		}
	endif; 
	if( $next_post = get_next_post() ): 
		if( get_theme_mod( 'post_links__title' ) ) {
			$nextPostLink = get_next_post_link( '%link',"$nextPrepend%title$nextAppend", TRUE ); 
		} else {
			$nextPostLink = get_next_post_link( '%link',"$nextPrepend$nextAppend", TRUE ); 
		}
		if($nextPostLink) {
			$next_post_link = '<div class="post-links-next">';
			if($postLinksThumbnail) $next_post_link .= get_the_post_thumbnail( $next_post->ID, 'post-link-thumbnail', array('class' => 'post-links-next__image')); 
			$next_post_link .= $nextPostLink . '</div>';
		}
	endif; 
?>
<div class="post-links">
	<?php 
		if ($prevBefore) {
			echo $prev_post_link;
			echo $next_post_link;
		} else {
			echo $next_post_link;
			echo $prev_post_link;
		}
	?>
</div>

<?php } //#end is_singular ?>