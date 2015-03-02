<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl- post-footer --><footer class="entry-footer post-footer">
<?php
	//Check for display categories
	//bb_posts_categories($prepend = null, $append = null, $separator = null, $class = null, $parents = null, $return = false)
	//bb_posts_categories( null, null, null, 'post-footer__catgories');
	bb_posts_meta('bottom');
			
	//Display tags
	//bb_posts_tags($prepend = , $append = '</p>', $separator = ', ', $class = null, $return = false)
	//$prepend = 'default' = '<p class="post-tags">Tags: '
	//$prepend = 'default' = '</p>'
	//bb_posts_tags( 'default', 'default', 'default', 'post-footer__tags');
	
	//Comments
?>
<?php get_template_part ( 'tpl', 'post-links' ); ?>
		<div class="entry-meta post-footer__comments">
<?php
	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'bearbones' ), __( '1 Comment', 'bearbones' ), __( '% Comments', 'bearbones' ) ); ?></span>
<?php
	endif;				
?>
		</div><!-- .entry-meta comments -->
	</footer>