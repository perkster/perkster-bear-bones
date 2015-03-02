<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl-Topbar -->
<?php if ( is_active_sidebar( 'topbar-widget' ) ) : ?>
	<div class="topbar-wrapper">
		<section class="topbar">
			<h3 class="assistive-text">Top Bar Widget</h3>
			<?php if ( has_nav_menu ( 'main-menu' ) ) ?><a href="#main-menu" class="skiplink">Skip to Main Navigation</a><?php ; ?>
			<a href="#main" class="skiplink">Skip to Main Content</a>
			<?php 	dynamic_sidebar( 'topbar-widget' ); ?>
		</section>
	</div><!-- end Topbar -->
<?php 	endif; ?>