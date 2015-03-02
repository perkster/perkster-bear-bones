<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/* 
 * You have the ability to exclude the header-widget on a per post/page basis. 
 * Just add a custom field with the name 'no-header-widget' with a value of 'true'
 */
	
if(isset($post)) $exclude = get_post_meta( $post->ID, 'no-header-widget' ); 
if(isset($exclude) && is_array($exclude) && isset($exclude[0]) && $exclude[0] == 'true') $no_show == true;
if(!isset($no_show)) { 
?><!-- tpl- Header Widget -->
<div class="header-widget-wrapper">
	<div class="header-widget-inner"><?php  bb_display_widget( 'header-widget' )  ; ?></div>
</div>	
<?php } ?><!-- end Header Widget -->