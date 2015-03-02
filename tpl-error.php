<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl- Error -->
	<article id="post-error" class="error">
		<header class="entry-header post-header">
					<h1 class="entry-title"><?php _e( 'Don&rsquo;t worry. We&rsquo;ll get through this.', 'bear-bones' ); ?></h1>
				</header>

				<div class="entry-content post-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentytwelve' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
				<?php bb_display_widget( 'error' ); ?>
	</article><!-- end Content -->
<!-- end .tpl-content -->