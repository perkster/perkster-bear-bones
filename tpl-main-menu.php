<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- tpl- Main Menu --><?php	if ( has_nav_menu( 'main-menu' ) ) :?>
	<div class="main-menu-wrapper">
		<div class="main-menu-inner" >
		<button id="menuToggle"><i class="fa fa-navicon"></i> Menu</button>
		<nav id="main-menu" class="main-menu" role="navigation">
			<h3 class="assistive-text">Main menu</h3>
			<?php 
				wp_nav_menu(array(
				  'theme_location' => 'main-menu',
				  'menu_class' => 'nav main-menu__list',
				  'container'       => false,
				  'container_class' => false,
				));
			?>
		</nav>
		</div>
	</div>
<?php endif;	?><!-- end Main Menu -->