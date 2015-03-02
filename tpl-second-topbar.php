<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl- Second Topbar --><div class="second-topbar-wrapper">
					<section class="second-topbar">
					<h3 class="assistive-text">Second Topbar Widget</h3>
					<?php if ( has_nav_menu ( 'main-menu' ) ) ?><a href="#main-menu" class="skiplink">Skip to Main Navigation</a><?php ; ?>
					<a href="#main" class="skiplink">Skip to Main Content</a>
					<?php 
						if ( is_active_sidebar( 'second-topbar-widget' ) ) : 
							dynamic_sidebar( 'second-topbar-widget' );
						endif; 
					?></section>
				</div><!-- end Second Topbar -->