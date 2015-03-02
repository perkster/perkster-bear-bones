<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Core functions 
 *
 *
 * @file           	theme-support.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/theme-support.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */

add_action('init', 'bear_bones_theme_support');
 
function bear_bones_theme_support() {
	//Most filters have a corresponding function.
	
	//Textdomain
	load_theme_textdomain( 'bearbones', get_template_directory() .'/languages' );
	
	//MENU
	register_nav_menus(
		array(
			'main-menu' => __( 'Main Menu', 'bearbones' ),   // main menu
			'menu-social' => __( 'Social Menu', 'bearbones' ) // used for floating social menus
		)
	);
	
	/*/HEADER */
	$args = array(
		'default-image' 			=> get_template_directory_uri() . '/images/header.jpg',
		'default-text-color'     	=> '',
		'flex-height'   			=> true,
		'flex-width'   				=> true,
		'header-text'				=> true,
		//'height'        			=> 190,  /*removed height and width so header is more customizeable */
		//'width'         			=> 728,
		'height'					=> 'auto',
		'width'						=> 'auto',
	);
	add_theme_support( 'custom-header', $args );
	
	// This theme supports a variety of post formats. 
	add_theme_support('post-formats', array( 
		'aside', 'gallery','link','image','quote','status','video','audio','chat' 
	) );
	
	//  allows the use of HTML5 markup
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	
	//@TODO: Add structured theme support
	/*add_theme_support( 'structured-post-formats', array(
		'link', 'video'
	) );
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'quote', 'status'
	) );*/
	
	add_theme_support( 'custom-background' );  
	add_theme_support( 'automatic-feed-links' );
	
	
	// https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	add_theme_support( 'title-tag' );

	
	/************* THUMBNAIL SIZE OPTIONS *************/
	add_theme_support('post-thumbnails');
	// default thumb size
	
	// Thumbnail sizes
	bb_featured_image(); //includes/posts.php	
	
	
	//BASIC THEME SETUP
	
	//Add class="thumbnail" to attachment items
	add_filter('wp_get_attachment_link', 'bb_attachment_link_class', 10, 1);
	//Don't return the default description in the RSS feed if it hasn't been changed
	add_filter('get_bloginfo_rss', 'bb_remove_default_description');
	//Remove unnecessary self-closing tags for valid HTML5
	add_filter('get_avatar',          'bb_remove_self_closing_tags'); // <img />
	add_filter('comment_id_fields',   'bb_remove_self_closing_tags'); // <input />
	add_filter('post_thumbnail_html', 'bb_remove_self_closing_tags'); // <img />
	//Allow more tags in TinyMCE including <iframe> and <script>
	add_filter('tiny_mce_before_init', 'bb_change_mce_options');
	//Cleanup output of stylesheet <link> tags
	add_filter('style_loader_tag', 'bb_clean_style_tag');
	//Wrap embedded media as suggested by Readability
	add_filter('embed_oembed_html', 'bb_embed_wrap', 10, 4);
	add_filter('embed_googlevideo', 'bb_embed_wrap', 10, 2);
	//Add numbers and next/previous links with wp_link_pages()
	add_filter('wp_link_pages_args','bb_add_next_and_number');
	

	//Add editor style - normally would be get_stylesheet_uri() but admin override available so custom function is used.
	add_editor_style( array( bb_main_style() ) );

	add_filter('request', 'bb_request_filter');
	// adding the bear bones search form
    //add_filter( 'get_search_form', 'bb_wpsearch' );
	
	//RELATED POSTS  @TODO: bb_plugin
	
	//EXCERPT
	//add_filter('excerpt_length', 'bb_excerpt_length');
	//add_filter('excerpt_more', 'bb_excerpt_more');
	
	//COMMENT LAYOUT
	
	//AUTHORS POST LINK  @TODO: bb_plugin
	
	//Always declare - doesn't hurt
	add_theme_support( 'woocommerce' );	

 
} /* end theme support */

add_action( 'init', 'bear_bones_add_excerpts_to_pages' );

function bear_bones_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}



/************* ADD EXCERPT WORD COUNT *************/
//http://bonybits.com/better-excerpts-wordpress-functions/
function gv_excerpt_word_count_js() {
      echo '
     <script>jQuery(document).ready(function(){
jQuery("#postexcerpt #excerpt").after("Word Count: <strong><span id=\'excerpt-word-count\'></span></strong>");
     jQuery("#excerpt-word-count").html(jQuery("#excerpt").val().split(/\S+\b[\s,\.\'-:;]*/).length - 1);
     jQuery("#excerpt").keyup( function() {
     jQuery("#excerpt-word-count").html(jQuery("#excerpt").val().split(/\S+\b[\s,\.\'-:;]*/).length - 1);
   });
});</script>
    ';
}
add_action( 'admin_head-post.php', 'gv_excerpt_word_count_js');
add_action( 'admin_head-post-new.php', 'gv_excerpt_word_count_js');

/************************** BASIC THEME SETUP ***************************/

/** * Add class="thumbnail" to attachment items
 */
function bb_attachment_link_class($html) {
  $postid = get_the_ID();
  $html = str_replace('<a', '<a class="thumbnail"', $html);
  return $html;
}

/** * Don't return the default description in the RSS feed if it hasn't been changed
 */
function bb_remove_default_description($bloginfo) {
  $default_tagline = 'Just another WordPress site';

  return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}

/** * Remove unnecessary self-closing tags
 */
function bb_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}

/** * Allow more tags in TinyMCE including <iframe> and <script>
 */
function bb_change_mce_options($options) {
  $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

  if (isset($initArray['extended_valid_elements'])) {
    $options['extended_valid_elements'] .= ',' . $ext;
  } else {
    $options['extended_valid_elements'] = $ext;
  }

  return $options;
}

//@TODO: bb_plugin_search - Add search, empty search request filter to 
/** * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function bb_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = ' ';
  }

  return $query_vars;
}

/** * Cleanup output of stylesheet <link> tags
 */
function bb_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  // Only display media if it's print
  $media = $matches[3][0] === 'print' ? ' media="print"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

/** * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function bb_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
  return '<div class="entry-content-asset">' . $cache . '</div>';
}



/************* COMMENT LAYOUT *********************/
// @TODO: Update comment layout and styling
add_filter('get_avatar','change_avatar_css');

function change_avatar_css($class) {
	$class = str_replace("class='avatar", "class='author_gravatar media__img avatar__img ", $class) ;
	return $class;
}

add_filter('comment_reply_link','change_comment_reply_link_css');

function change_comment_reply_link_css($class) {
	$class = str_replace("class='comment-reply-link", "class='comment-reply-link ", $class) ;
	return $class;
}
// Comment Layout
function bear_bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
		require_once locate_template('library/includes/Mobile_Detect.php' ); 
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');					
	?>
	<li <?php comment_class('comment'); ?>>
		<div class="comment__avatar">
		<?php 
			if($deviceType == 'computer') {
				$size = '64';
				//$default=get_template_directory_uri().'/library/images/default_avatar.jpg';
				echo get_avatar($comment,$size); 
						
			} else {
				/*
			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );
			    */ 
			    // create variable
			    $bgauthemail = get_comment_author_email();
			?>
			<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo media__img avatar__img" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nada.jpg" />
			<!-- end custom gravatar call -->
		<?php } ?>
		</div>
		<article id="comment-<?php comment_ID(); ?>" class="comment__body">
			<header class="comment__header">
				<?php printf(__('<cite class="fn comment__cite">%s</cite>', 'bear_bones'), get_comment_author_link()) ?> on <time datetime="<?php echo comment_time('Y-m-j'); ?>" class="comment__time"><?php comment_time(__('F jS, Y', 'bear_bones')); ?> </time> said:
			</header>	
			
			<section class="comment__content ">					
			
				<?php if ($comment->comment_approved == '0') : ?>
					<div class="alert info">
						<p><?php _e('Your comment is awaiting moderation.', 'bear_bones') ?></p>
					</div>
				<?php endif; ?>
			
				<?php comment_text() ?>
				<?php if ( is_user_logged_in() ) {  ?><span class="comment__link--edit"><?php edit_comment_link(__('(Edit)', 'bear_bones'),'  ','') ?></span> <?php } ?>
				<span class="comment__link--reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
				<?php //delete_comment_link(get_comment_ID()); ?>
			</section>
		</article>
    <!-- </li> is added by WordPress automatically -->
<?php
}
/* More comment features
 * http://www.problogdesign.com/wordpress/advanced-wordpress-comment-styles-and-tricks/
 */ 

/*function delete_comment_link($id) {
  if (current_user_can('edit_post')) {
    echo '<a href="'.admin_url("comment.php?action=cdc&c=$id").'">del</a> ';
    echo '<a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">spam</a>';
  }
}*/

function check_referrer() {
    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == "") {
        wp_die( __('Please enable referrers in your browser, or, if you\'re a spammer, get out of here!') );
    }
}
add_action('check_comment_flood', 'check_referrer');


/*** TAKEN FROM TWENTYTHIRTEEN **********/

if ( ! function_exists( 'bear_bones_entry_meta' ) ) {
	/**
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own bear_bones_entry_meta() to override in a child theme.
	 *
	 * @return void
	 */
	function bear_bones_entry_meta() {
		if ( is_sticky() && is_home() && ! is_paged() )
			echo '<span class="featured-post">' . __( 'Sticky', 'bear_bones' ) . '</span>';

		if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
			bear_bones_entry_date();

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'bear_bones' ) );
		if ( $categories_list ) {
			echo '<span class="categories-links">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'bear_bones' ) );
		if ( $tag_list ) {
			echo '<span class="tags-links">' . $tag_list . '</span>';
		}

		// Post author
		if ( 'post' == get_post_type() ) {
			printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'bear_bones' ), get_the_author() ) ),
				get_the_author()
			);
		}
	}
}

if ( ! function_exists( 'bear_bones_entry_date' ) ) {
	/**
	 * Prints HTML with date information for current post.
	 *
	 * Create your own bear_bones_entry_date() to override in a child theme.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @param boolean $echo Whether to echo the date. Default true.
	 * @return string The HTML-formatted post date.
	 */
	function bear_bones_entry_date( $echo = true ) {
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'bear_bones' );
		else
			$format_prefix = '%2$s';

		$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
			esc_url( get_permalink() ),
			esc_attr( sprintf( __( 'Permalink to %s', 'bear_bones' ), the_title_attribute( 'echo=0' ) ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ( $echo )
			echo $date;

		return $date;
	}
}

if ( ! function_exists( 'bear_bones_the_attached_image' ) ) {
	/**
	 * Prints the attached image with a link to the next attached image.
	 *
	 * @since Twenty Thirteen 1.0
	 *
	 * @return void
	 */
	function bear_bones_the_attached_image() {
		$post                = get_post();
		$attachment_size     = apply_filters( 'bear_bones_attachment_size', array( 724, 724 ) );
		$next_attachment_url = wp_get_attachment_url();

		/**
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts( array(
			'post_parent'    => $post->post_parent,
			'fields'         => 'ids',
			'numberposts'    => -1,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => 'ASC',
			'orderby'        => 'menu_order ID'
		) );

		// If there is more than 1 attachment in a gallery...
		if ( count( $attachment_ids ) > 1 ) {
			foreach ( $attachment_ids as $attachment_id ) {
				if ( $attachment_id == $post->ID ) {
					$next_id = current( $attachment_ids );
					break;
				}
			}

			// get the URL of the next image attachment...
			if ( $next_id )
				$next_attachment_url = get_attachment_link( $next_id );

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}

		printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
			esc_url( $next_attachment_url ),
			the_title_attribute( array( 'echo' => false ) ),
			wp_get_attachment_image( $post->ID, $attachment_size )
		);
	}
}


/* Example for custom meta fields
$prefix = 'bear_boness_';
$custom_meta_fields = array(
	array(
		'label'=> 'Text Input',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'text',
		'type'	=> 'text'
	),
	array(
		'label'=> 'Textarea',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'textarea',
		'type'	=> 'textarea'
	),
	array(
		'label'=> 'Checkbox Input',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'checkbox',
		'type'	=> 'checkbox'
	),
	array(
		'label'=> 'Select Box',
		'desc'	=> 'A description for the field.',
		'id'	=> $prefix.'select',
		'type'	=> 'select',
		'options' => array (
			'one' => array (
				'label' => 'Option One',
				'value'	=> 'one'
			),
			'two' => array (
				'label' => 'Option Two',
				'value'	=> 'two'
			),
			'three' => array (
				'label' => 'Option Three',
				'value'	=> 'three'
			)
		)
	)
); */

// The Callback
function bear_bones_show_custom_meta_box($custom_meta_fields = null) {
//global $custom_meta_fields;
global $post;
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea  
					case 'textarea':  
						echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea> 
							<br /><span class="description">'.$field['desc'].'</span>';  
					break;
					// checkbox  
					case 'checkbox':  
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/> 
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';  
					break;
					// select  
					case 'select':  
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';  
						foreach ($field['options'] as $option) {  
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';  
						}  
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';  
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}


function bb_copyright_year($start = null, $sep = '-'){ 
	if($start) {
		$thisYear = date('Y');
		if($start == $thisYear) {
			$year = $start;
		} else {
			$year = "$start$sep$thisYear"; 
		}
	} else {
		$year = date('Y'); 
	}
	return $year;
}

//echo admin
function ea_($content) {
	
	if (is_super_admin() ) echo $content;
}

	/*------------------------------------*\
		FAVICON
	\*------------------------------------*/

//@TODO: Put default favicon logos in bear bones/images/favicon/ folder

function bb_favicon_path() {
	//Retrieve path from theme mods
	$faviconPath = get_theme_mod('favicon_path');
	
	//Check to make sure that first character is /
	$first= substr($faviconPath, 1);
	if($first != '/') $faviconPath = '/' . $faviconPath;
	
	//Check to make sure that last character is /
	$last= substr($faviconPath, -1);
	if($last != '/') $faviconPath .= '/';
	
	//set default path just in case
	$favicon_default = '/images/favicon/';
	
	//check if directory exists of given path
	if ( file_exists ( get_stylesheet_directory() . $faviconPath ) ) {
		$faviconPath = get_stylesheet_directory_uri() . $faviconPath;
		
	//check if directory exists of default path within theme
	} elseif ( file_exists ( get_stylesheet_directory() . $favicon_default ) ) {
		$faviconPath =  get_stylesheet_directory_uri() . $favicon_default;
	
	//set directory to default Bear Bones directory so default logos can be served
	} else {
		$faviconPath = get_template_directory_uri() . $favicon_default;
	}
	
	return $faviconPath;
}




	/*------------------------------------*\
		CUSTOM IMAGE SIZES
	\*------------------------------------*/
	
	
add_action( 'after_setup_theme', 'bb_addtional_theme_image_sizes' );

function bb_addtional_theme_image_sizes () {
	bb_featured_image();
	bb_post_links_thumbnail();
	bb_add_image();
	$addtionalImageText = get_theme_mod( 'images__sizes' );
	if($addtionalImageText) {
		$imgSizes = explode(';', $addtionalImageText); 
		foreach( $imgSizes as $imgSize ) {
			if( $imgSize ) {
				$imgParts = explode(',', $imgSize);
				//check to make sure numbers are being passed
				if( is_array( $imgParts ) ) {
					$name = trim( $imgParts[0] );
					$width = ( trim( is_numeric( $imgParts[1] ) ? $imgParts[1] : false) ) ; 
					$height = ( trim( is_numeric( $imgParts[2] ) ? $imgParts[2] : false) ); 
					$crop = ( isset( $imgParts[3] ) ? true : false); 
					if( $width && $height ) {
						add_image_size( $name, $width, $height, $crop );
					}				
				}
			}
		}
	}
	add_filter( 'image_size_names_choose', 'bb_insert_custom_image_sizes' );
}

function bb_add_image ($theme_mod = 'post__thumbnail', $default = '150-15-crop') {
	$postFeaturedText = get_theme_mod( $theme_mod ); //prar($postFeaturedText);
	if($postFeaturedText) {
		$imgParts = explode('-', $postFeaturedText);
		//check to make sure numbers are being passed
		if( is_array( $imgParts ) ) {
			$width = ( is_numeric( $imgParts[0] ) ? $imgParts[0] : false); 
			$height = ( is_numeric( $imgParts[1] ) ? $imgParts[1] : false); 
			$crop = ( isset( $imgParts[2] ) ? true : false);
			$imageName = $theme_mod;
			//$imageName = ( $theme_mod == 'post__thumbnail' ? 'post-thumbnail' : $theme_mod );
			$imageName = str_replace ( '__', '-', $imageName );
			$imageName = str_replace ( '_', '-', $imageName );
			if($width && $height) add_image_size( $imageName, $width, $height, $crop );
		}
	}
}

function bb_featured_image () {
	$postFeaturedText = get_theme_mod( 'post__featured_image' ); 
	if($postFeaturedText) {
		$imgParts = explode('-', $postFeaturedText);
		//check to make sure numbers are being passed
		if( is_array( $imgParts ) ) {
			$width = ( is_numeric( $imgParts[0] ) ? $imgParts[0] : false); 
			$height = ( is_numeric( $imgParts[1] ) ? $imgParts[1] : false); 
			$crop = ( isset( $imgParts[2] ) ? true : false); 
			if($width && $height) add_image_size( 'post-featured', $width, $height, $crop );
		}
	}
}

function bb_post_links_thumbnail () {
	$postLinkThumbText = get_theme_mod( 'post_link__thumbnail' ); 
	$postLinkThumbText = ( $postLinkThumbText  ? $postLinkThumbText : '150-100-true' );
	$imgParts = explode('-', $postLinkThumbText);
	//check to make sure numbers are being passed
	if( is_array( $imgParts ) ) {
		$width = ( is_numeric( $imgParts[0] ) ? $imgParts[0] : false); 
		$height = ( is_numeric( $imgParts[1] ) ? $imgParts[1] : false); 
		$crop = ( isset( $imgParts[2] ) ? true : false); 
		if($width && $height) add_image_size( 'post-link-thumbnail', $width, $height, $crop );
	}	
}

// Add new image sizes
function bb_insert_custom_image_sizes( $image_sizes ) {
  // get the custom image sizes
  global $_wp_additional_image_sizes;
  // if there are none, just return the built-in sizes
  if ( empty( $_wp_additional_image_sizes ) )
    return $image_sizes;
 
  // add all the custom sizes to the built-in sizes
  foreach ( $_wp_additional_image_sizes as $id => $data ) {
    // take the size ID (e.g., 'my-name'), replace hyphens with spaces,
    // and capitalise the first letter of each word
    if ( !isset($image_sizes[$id]) )
      $image_sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }
 
  return $image_sizes;
}

function bear_bones_main_start($atts = null) {
	//prar('bear_bones_main_start'); prar($atts);
	$extraHTML = isset( $atts['extraHTML'] ) ? $atts['extraHTML'] : null;
	$tplVariable = isset ( $atts['tplVariable'] ) ? $atts['tplVariable'] : null;
	if( $tplVariable && substr( $tplVariable, 1 ) != '-' ) $tplVariable = '-' . $tplVariable;
	
	get_template_part ('tpl-main-wrapper' . $tplVariable);
	if( $extraHTML ) echo $extraHTML;
}

function bear_bones_main_end( $atts = null ) {
	//prar('bear_bones_main_end'); prar($atts);
	if ( isset( $atts['extraHTML'] ) ) echo $atts['extraHTML']; 
	$tplVariable = isset ( $atts['tplVariable'] ) ? $atts['tplVariable'] : null; //prar($tplVariable);
	if( $tplVariable && substr( $tplVariable, 1 ) != '-' ) $tplVariable = '-' . $tplVariable;
	get_template_part ('tpl-main-wrapper-end' . $tplVariable);
	
}

?>