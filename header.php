<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><?php get_template_part( 'head' ); 	?>
<body <?php body_class(); ?>><!-- header.php -->
<!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<?php get_template_part ('tpl', 'skip-link'); ?>
<div class="container-wrapper">
  <div class="container">
	<div id="blk-header" class="block--header masthead" >
				<?php
					if(get_theme_mod( 'topbar_widget' )) {
						get_template_part ('tpl', 'topbar');
					}
				?>
				
				<?php
					if(get_theme_mod( 'second_topbar_widget' )) {
						get_template_part ('tpl', 'second-topbar');
					}
				?>
<?php
	$headerWidgetPlacement ='';
	$headerMenuPlacement = '';
	
	//check for header widget and placement
	$headerWidget = get_theme_mod('header_widget'); 
	if($headerWidget) 	$headerWidgetPlacement = get_theme_mod('header_widget_placement'); 
	/*ea_( "header Widget: $headerWidget<br> 
	header Widget Placement: $headerWidgetPlacement<br>"); */
	
	//check for main menu and placement
	$mainMenu = get_theme_mod('main_menu'); 
	if($mainMenu) {
		$mainMenuPlacement = get_theme_mod('main_menu_placement'); 
	} else {
		$mainMenuPlacement = false;
	}
	/*ea_( "main Menu: $mainMenu<br> 
	main Menu Placement: $mainMenuPlacement<br>");	*/
?>

<?php 
	/****** ABOVE HEADER **********/
	if(($headerWidgetPlacement == 'above_header_before_menu') || ($headerWidgetPlacement =='above_header_after_menu') || ($mainMenuPlacement == 'above_header') ) {
		if($headerWidgetPlacement == 'above_header_before_menu') get_template_part('tpl', 'header-widget');
		if($mainMenuPlacement == 'above_header')  get_template_part('tpl', 'main-menu'); 		
		if($headerWidgetPlacement == 'above_header_after_menu')  get_template_part('tpl', 'header-widget');
	}
	$headerImage = get_theme_mod('header_image_placement');
?>
			<div class="header-wrapper">
				<div class="header-inner">
					<header class="header" role="banner" <?php if ($headerImage == 'as_background') echo 'style="background-image: url(' . get_header_image() . ')"';  ?>>
					<?php if ($headerImage == 'before_logo') { ?>
						<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
					<?php } ?>
					<div class="header__site-info">
					<?php $siteTitle = esc_attr( get_bloginfo( 'name', 'display' ), 'bearbones' ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo $siteTitle; ?>" rel="home" class="header__link" >
						<?php if(get_theme_mod('header_logo_image')) {
							$logo =  get_theme_mod('site_logo'); 
							$logo_alt = get_theme_mod('logo_alt_text'); 
							echo  '<img src="'. $logo .'" alt="' . $logo_alt . ' logo" class="header__logo">';
						} ?>
						<?php if(get_theme_mod('header_site_title')) {
							echo '<p class="header__title">'.$siteTitle.'</p>'; 
						} ?>
						<?php if(get_theme_mod('header_site_tagline')) {
							$description = esc_html_e( get_bloginfo('description'), 'bearbones' );
							echo '<p class="header__tagline">'.$description.'</p>'; 		
						} ?>						
					</a>
					</div>
					
<?php
	/****** RIGHT OF LOGO **********/
	if(($headerWidgetPlacement == 'right_logo_before') || ($headerWidgetPlacement =='right_logo_after') || ($mainMenuPlacement == 'right_logo') ) {
?>
					<div class="header__right-of-logo">
<?php
		if( $headerWidgetPlacement == 'right_logo_before' ) get_template_part('tpl', 'header-widget');
		if($mainMenuPlacement == 'right_logo')  get_template_part('tpl', 'main-menu'); 		
		if($headerWidgetPlacement == 'right_logo_after')  get_template_part('tpl', 'header-widget');
?>
					</div>
<?php
	}
?>					
					<?php if ($headerImage == 'after_logo') { ?>
						<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
					<?php } ?>
					</header><!-- end .header -->
				</div><!-- end .header-inner -->
			</div><!-- end.header-wrapper -->
<?php
	/****** BELOW HEADER **********/
	if(($headerWidgetPlacement == 'below_header_before_menu') || ($headerWidgetPlacement =='below_header_after_menu') || ($mainMenuPlacement == 'below_header') ) {
		if($headerWidgetPlacement == 'below_header_before_menu') get_template_part('tpl', 'header-widget');
		if($mainMenuPlacement == 'below_header')  get_template_part('tpl', 'main-menu'); 		
		if($headerWidgetPlacement == 'below_header_after_menu')  get_template_part('tpl', 'header-widget');
	}
?>				
	</div><!-- end .block--header -->