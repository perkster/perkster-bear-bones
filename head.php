<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<!-- head.php -->
<head>
	<meta charset="utf-8">
	<title><?php wp_title( ); ?></title>
		
	<!-- Google Chrome Frame for IE -->
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
	<?php
		if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        header('X-UA-Compatible: IE=edge,chrome=1');
	?>

	<!-- mobile meta  -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/ or http://stackoverflow.com/questions/23849377/html-5-favicon-support) -->
	<?php 
		$faviconPath = bb_favicon_path();
	?>
	
	<!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
	<!--[if IE]><link rel="shortcut icon" href="<?php echo $faviconPath; ?>favicon.ico"><![endif]-->

	<!-- IE 10+ "Metro" Tiles - 144x144 pixels in size -->
	<?php
		$faviconColor = get_theme_mod('favicon_color');
	?>
	<meta name="msapplication-TileColor" content="<?php echo $faviconColor; ?>">
	<meta name="msapplication-TileImage" content="<?php echo $faviconPath; ?>tileicon.png">

	<link rel="apple-touch-icon" href="<?php echo $faviconPath; ?>touchicon.png">
	
	<!-- Touch Icons - iOS and Android 2.1+ 152x152 pixels in size. --> 
	<link rel="apple-touch-icon-precomposed" href="<?php echo $faviconPath; ?>precomposed.png">

	<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 96x96 pixels in size. -->
	<link rel="icon" href="<?php echo $faviconPath; ?>favicon.png">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<!-- Do NOT load stylesheet here, it will load up in the scripts folder so that you can overwrite it when logged in as admin -->
	<!--<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">-->

<!-- wordpress head functions -->
<?php wp_head(); ?>
	
<!-- end of wordpress head -->

</head>