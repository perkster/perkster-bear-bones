<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 *  Core functions 
 *
 *
 * @file           	posts.php
 * @package        	Bear Bones 1.0.7
 * @url				http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2013 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones-1.0.7/includes/postss.php
 * @link           	http://codex.wordpress.org/Theme_Development#Functions_File
 * @since          	available since Release 1.0
 */
 
 /**
 * bb_posts_tags.
 *
 * Checks to see if option is set in theme to display (default is true), if true
 * then tag list is displayed
 *
 * $prepend - text to prepend the tag list
 * $append - text to append the tag list
 * $separator - text to display between categories
 * $class - class names to add to the tag list container
 * $return - if set to true, will return value
 *
 * @since Bear Bones 1.0.7
 */
 function bb_posts_tags( $prepend = 'default', $append = 'default', $separator = ', ', $class = null, $return = false ) {
	$post_tags = null;
	if( $prepend == 'default') $prepend = '<p class="post-tags">Tags: ';
	if( $append == 'default') $append = '</p>';
	
	if( get_theme_mod ( 'posts__tags') && get_the_tag_list()) {
		
		$classes = 'entry-meta post__tags';
		$classes .= bb_class_as_string($class);
		
		$post_tags = '<div class="'. $classes . '">';
		$post_tags .= get_the_tag_list($prepend, $separator, $append); 
		$post_tags .= '</div><!-- .entry-meta post-tags -->';	
	}
	if( $return ) {
		return $post_tags;
	} else {
		echo $post_tags;
	}
}


 /**
 * bb_posts_categories.
 *
 * Checks to see if option is set in theme to display (default is true), if true
 * then category list is displayed. 
 *
 * $separator - text to display between categories, if null then will return as list
 * $class - class names to add to the category list container
 * $return - if set to true, will return value
 *
 * @since Bear Bones 1.0.7
 */
function bb_posts_categories ( $prepend = null, $append = null, $separator = null, $class = null, $parents = null, $post_id = null, $return = false, $div = true ) {
	$posts_categories = null;
	
	if( get_theme_mod ( 'posts__categories' ) && get_the_category_list() ) {
		$classes = 'entry-meta post__categories';
		$classes .= bb_class_as_string( $class );
		
		if ($div) $posts_categories .= '<div class="' . $classes . '">';
		$posts_categories .= $prepend;
		$posts_categories .= get_the_category_list( $separator, $parents, $post_id );
		$posts_categories .= $append;
		if ($div) $posts_categories .= '</div><!-- .entry-meta post__categories -->';
	} 
	if( $return ) {
		return $posts_categories;
	} else {
		echo $posts_categories;
	}
}


function bb_posts_meta ( $bottom = false, $separator = ' ') {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post">' . __( 'Sticky', 'bearbones' ) . '</span>';
	}
	if( $bottom ) {
		$meta_tags = get_theme_mod( 'posts__meta_template__bottom' ); //prar($meta_tags);
	} else {
		$meta_tags = get_theme_mod( 'posts__meta_template' ); //prar($meta_tags);
	}
	$sepPos = strpos ( $meta_tags, '[' );
	if ($sepPos) {
		$separator = substr( $meta_tags, $sepPos + 1); 
		$sepEnd = strpos ( $separator, ']' );
		$separator = substr ($separator, 0, $sepEnd);
		$replace = '['.$separator.']'; 
		$meta_tags =  substr( $meta_tags, 0, $sepPos ); 
	}
	$metaArray = explode(',', $meta_tags);
	$metaCount = count( $metaArray );
	$i = 0;
	foreach ($metaArray as $meta_tag) {
		$metaTag = null;
		$i++;
		if($meta_tag) {
			$preBegin = strpos( $meta_tag, '?' ); 
			$appendBegin = strpos( $meta_tag, '!' );  
			if( $preBegin ) {
				$prepend = substr( $meta_tag, $preBegin + 1 ) . ' '; 
				$metaTag = substr( $meta_tag, 0, ($preBegin) );
				if($appendBegin > 0) $prepend = substr( $prepend, 0, strpos( $prepend, '!' ) );
			} else {
				$prepend = null;
			}			
			if( $appendBegin ) {
				$append = substr( $meta_tag, $appendBegin + 1 ) . ' '; 
				if(!$metaTag) $metaTag = substr( $meta_tag, 0, ($appendBegin) );
			} else {
				$append = null;
			}
			$metaTag = trim( $metaTag );
			$metaDisplay = null;
			switch ( $metaTag ) {
				case 'author':
					$metaDisplay = $prepend . '<span class="byline"><span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url(  get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . get_the_author() . '</a></span></span>';
					break;
				case 'updated':
					$metaDisplay = $prepend . '<span class="entry-date"><a href="' .  esc_url( get_permalink() ) . '" rel="bookmark">';
					$metaDisplay .= '<time class="entry-date" datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date() ) . '</time>';
					$metaDisplay .= '</a></span>';					
					break;
				case 'date':
					$metaDisplay = $prepend . '<span class="entry-date"><a href="' .  esc_url( get_permalink() ) . '" rel="bookmark">';
					$metaDisplay .= '<time class="entry-date" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
					$metaDisplay .= '</a></span>';					
					break;
				case 'category':
					$metaDisplay .= bb_posts_categories($prepend, $append, $separator, null, null, null, true, false );
					break;
				case 'tags':
				case 'tag':
					$metaDisplay .= bb_posts_tags($prepend, $append, $separator, null, true );
			}
			echo $metaDisplay;
			if ($i < $metaCount) echo $separator;
		}
	}
}

function bb_author_link ( ) {

}

function bb_author_box ( ) {

}

function bb_page_nav_links () {
		wp_link_pages(array(
			'before' => '<p>' . __('Pages:', 'bearbones'),
			'after' => '</p>',
			'next_or_number' => 'next_and_number',
			'nextpagelink' => __('Next', 'bearbones'),
			'previouspagelink' => __('Previous', 'bearbones'),
			'pagelink' => '%',
			'echo' => 1 )
		);
}
		
//http://www.velvetblues.com/web-development-blog/wordpress-number-next-previous-links-wp_link_pages/
//@TODO: style page nav links
function bb_add_next_and_number($args){
    if($args['next_or_number'] == 'next_and_number'){
        global $page, $numpages, $multipage, $more, $pagenow;
        $args['next_or_number'] = 'number';
        $prev = '';
        $next = '';
        if ( $multipage ) {
            if ( $more ) {
                $i = $page - 1;
                if ( $i && $more ) {
                    $prev .= _wp_link_page($i);
                    $prev .= $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
                    $next .= _wp_link_page($i);
                    $next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a>';
                }
            }
        }
        $args['before'] = $args['before'].$prev;
        $args['after'] = $next.$args['after'];    
    }
    return $args;
}
 /**
 * bb_class_as_string.
 *
 * Checks to see if class variable is array, if so parse
 * If text pass through
 *
 * $class - text
 *
 * @since Bear Bones 1.0.7
 */
function bb_class_as_string ( $class = null ) {
	$classes = null;
	if( is_array( $class ) ) {
		foreach ( $class as $class_name ) {
			$classes .= ' ' . $class_name;
		}
	} elseif ( $class ) {
		if( substr ( $class, 1, 1 ) != ' ' ) $class = ' '. $class;
		$classes .= $class;
	}
	return $classes;
}

function bb_excerpt($excerpt_length = 55, $id = false, $echo = true, $excerpt_more = '...') {
         
    $text = '';
   
    if($id) {
		$post = get_post($id);
		
	} else {
		global $post;
		//$text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
    }
	$title = get_the_title($post->ID);  //prar($title);
	$text = ($post->post_excerpt) ? $post->post_excerpt : $post->post_content;
	if($title == $text) $text = get_the_content('');
         
	//$text = strip_shortcodes( $text );
	$text = strip_tags(strip_shortcodes($text)); //Strips tags, images and other shortcodes
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
       
    //$excerpt_more = ' ' . '[...]';
	//$excerpt_more = null;
	//$excerpt_more = '...';
	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
		array_pop($words);
		$text = implode(' ', $words);
		$text = $text . $excerpt_more;
	} else {
		$text = implode(' ', $words);
	}
	
	if($echo) {
		echo apply_filters('the_content', $text);
	} else {
		return $text;
	}
}
 
function get_bb_excerpt($excerpt_length = 55, $id = false, $echo = false) {
 return bb_excerpt($excerpt_length, $id, $echo);
}
?>