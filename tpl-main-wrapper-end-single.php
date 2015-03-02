				<?php if( isset( $post ) ) bb_display_widget( get_post_meta( $post->ID, 'widget-bottom', true ) ); ?>
				<?php bb_display_widget( 'posts-widget-bottom' ); ?>
</main><!-- end MAIN CONTENT -->
			</div>
		
	<?php //Check if sidebar should be displayed on the right/after content
		if(bb_sidebar( 'right', true ) ) get_template_part( 'sidebar' ); 
	?>
			</div><!-- end .block--main-content -->
		</div><!-- end .content-inner -->
	</div><!-- end .content-wrapper -->
</div>