<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?>
	<div id="blk-footer" class="block--footer">
	  <div class="footer-widget-wrapper">
	   <div class="footer-widget-inner">		
			<?php bb_display_widget('footer-widget'); ?>
			<?php bb_display_widget('footer-widget-2');  ?>
	   </div>
	  </div>
	  	<?php if (get_theme_mod('footer_copyright')) : ?>
		  <div class="footer-wrapper">
			<footer role="contentinfo" class="footer">
				<div id="copyright-text" class="copyright source-org copyright-text">
				<?php $start = get_theme_mod('copyright_start'); 
					if($start):
						 echo '<p>&copy;' . bb_copyright_year(get_theme_mod('copyright_start')) . ' ' . get_theme_mod('copyright_text') . '</p>';
					else:
						echo get_theme_mod('copyright_text') ;
					endif;
				?>
				</div>
			</footer>
		  </div>
	<?php endif; ?>
	</div><!-- end .block--footer -->
  </div><!-- end .container -->
</div><!-- end .container-wrapper -->

<!-- If theme customization option selected all js scripts are loaded in footer -->
<?php wp_footer(); ?>
</body>
</html> <!-- end page. what a ride! -->
