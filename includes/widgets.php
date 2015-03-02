<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Theme's Widgets, Sidebars and Shortcodes
 *
 *
 * @file           	widgets.php
 * @package        	Bear Bones
 * @url		http://perkstersolutions.com/bear-bones
 * @author         	Wendy Shoef
 * @copyright      	2014 Perkster Solutions
 * @license        	license.txt
 * @version        	Release: 1.0.7
 * @filesource     	wp-content/themes/bear-bones/includes/widgets.php
 
 * @since          	available since Release 1.0.3
 */
 

add_action( 'widgets_init', 'bb_register_sidebars' );
add_filter('dynamic_sidebar_params', 'bb_widget_first_last_classes');
add_action('widgets_init', 'bear_bones_widget_registration');

require_once locate_template('includes/widget-vcard--personal.php');
require_once locate_template('includes/widget-vcard--company.php');

/*
http://wordpress.stackexchange.com/questions/12513/hooking-a-function-onto-the-sidebar
function add_before_my_siderbar( $name ) 
{
    echo "Loaded on top of the {$name}-sidebar";

    // Example that uses the $name of the sidebar as switch/trigger
    'main' === $name AND print "I'm picky and only echo for special sidebars!";
}
add_action( 'get_sidebar', 'add_before_my_siderbar' );
*/

/*****************************	WIDGETS ****************************/
function bb_register_sidebars() {
	//TOPBAR
	//if( get_theme_mod ('topbar_widget') ) {
		register_sidebar(array(
				'id' => 'topbar-widget',
				'name' => 'Topbar Widget',
				'description' => __('This widget appears at the very top of the website.', 'bearbones'),
				'before_widget' => '<section class="topbar-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 id="%1$s" class="%1$s topbar-widget__title">',
				'after_title' => '</h3>',
		));
	//}
	//Second Topbar
	if( get_theme_mod ('second_topbar_widget') ) {
		register_sidebar(array(
				'id' => 'second-topbar-widget',
				'name' => 'Second Topbar Widget',
				'description' => __('This widget appears at the very top of the website (after the topbar).', 'bearbones'),
				'before_widget' => '<section id="%1$s" class="%1$s second-topbar-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="second-topbar-widget__title">',
				'after_title' => '</h3>',
		));
	}
	//Header
	//if(get_theme_mod ('header_widget') ) {
		register_sidebar(array(
				'id' => 'header-widget',
				'name' => 'Header Widget',
				'description' => __('This widget appears in the header section.', 'bearbones'),
				'before_widget' => '<section id="%1$s" class="%1$s header-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="header-widget__title">',
				'after_title' => '</h3>',
		));
	//}
	//Pages/Main
	//if( get_theme_mod ('pages_widget') ) {
		register_sidebar(array(
				'id' => 'pages-widget',
				'name' => 'Pages/Main Sidebar',
				'description' => __('This widget appears in a sidebar on pages.', 'bearbones'),
				'before_widget' => '<section id="%1$s" class="%1$s pages-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="pages-widget__title">',
				'after_title' => '</h3>',
		));
	//}
	//Posts
	//$bb_posts_widget = get_theme_mod ('posts__widget');
	//if($bb_posts_widget == 'custom') {
		register_sidebar(array(
				'id' => 'posts-widget',
				'name' => 'Posts Sidebar',
				'description' => __('This widget appears in a sidebar on posts.', 'bearbones'),
				'before_widget' => '<section class="posts-widget-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="posts-widget__title">',
				'after_title' => '</h3>',
		));
	//}
	if(!get_theme_mod ('do_not_include_footer_widget') ) {
		register_sidebar(array(
				'id' => 'footer-widget',
				'name' => 'Footer Widget',
				'description' => __('This widget appears in the header section.', 'bearbones'),
				'before_widget' => '<section id="%1$s" class="%1$s footer-widget-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="footer-widget__title">',
				'after_title' => '</h3>',
		));
	}
	bb_add_additional_widgets();
	
}
function bb_add_additional_widgets() {
	/* Add addtional widgets */
	
	$bb_addl_widgets = get_theme_mod('addl_widgets');
	if(isset($bb_addl_widgets)) {
		$new_widgets = explode(";" , $bb_addl_widgets);
		//prar($scripts);
		foreach($new_widgets as $new_widget) {
			$new_widget = trim($new_widget);
			$new_widgetID = bb_widget_id($new_widget); //prar($new_widgetID);
			$new_widgetTitle = ucwords(strtolower($new_widget));
			register_sidebar(array(
				'id' => $new_widgetID,
				'name' => $new_widgetTitle,
				'description' => $new_widgetTitle,
				'before_widget' => '<section id="%1$s" class="%1$s ' . $new_widgetID . '-widget">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="widget-' . $new_widgetTitle . '">',
				'after_title' => '</h3>',
			));
		}
	}
}

function bb_widget_id ($text) {
	return str_replace(' ', '-', strtolower($text));
}

function bb_display_widget( $widget, $extra_classes = null ) {
	if($widget) {
		$widgetID = bb_widget_id( $widget ); 
		if ( is_active_sidebar( $widgetID ) ) {
			$classes = $extra_classes ? $widgetID . ' ' . $extra_classes : $widgetID;
			echo '<div class="' . $classes . '">';
			dynamic_sidebar( $widgetID ); 
			echo '</div>';
		}
	}
}

function bb_sidebar($position, $returnWidget = false, $sidebar_wrapper = false) {
	//global $myVariable;
	//prar($myVariable, false);
	//check position first
	$display = false;
	$pages_widget_right = get_theme_mod('pages_widget_right'); //prar ( array ('pages_widget_right', $pages_widget_right ) );
	$posts_widget_right = get_theme_mod('posts_widget_right'); //prar ( array ('posts_widget_right', $pages_widget_right ) );
	
	//if home page
	if( is_front_page() && get_theme_mod('home_sidebar') ) {
		if(	$pages_widget_right && $position == 'right' ) {
			//prar('home left sidebar', false);
			$display = true;
		} elseif ( !$pages_widget_right && $position == 'left' ) {
			//prar('home right sidebar', false);
			$display = true;
		}
	//if blog
	//} elseif ( is_home() ){
		
	//if is_page
	} elseif ( is_page() && get_theme_mod('pages_widget') && !is_front_page() ) {
		if(	$pages_widget_right && $position == 'right' ) {
			//prar('pages sidebar right', false);
			$display = true;
		} elseif ( !$pages_widget_right && $position == 'left' ) {
			//prar('left sidebar pages', false);
			$display = true;
		}
	//if is_post	
	//if custom post type use is_singular( 'custom-post-type' )
	//else
	} elseif ( !is_front_page() && get_theme_mod('posts_widget') ) {
		if(	$posts_widget_right && $position == 'right' ) {
			//prar('left sidebar posts', false);
			$display = true;
		} elseif ( !$posts_widget_right && $position == 'left' ) {
			//prar('right sidebar posts', false);
			$display = true;
		}
		
	}
	
	if($display) {
		$sidebarWidget = bb_get_sidebar_widget();
		
		if($returnWidget) {
			return $sidebarWidget;
		} else {			
			if($sidebar_wrapper) echo '<aside id="sidebar" role="complementary" class="sidebar">';
			bb_display_widget ( $sidebarWidget );
			if($sidebar_wrapper) echo '</aside>';
		}
	}
}

function bb_get_sidebar_widget() {
	global $post;
		//check for post type (page/post/archive)
		//check if using main sidebar
		$post_type = get_post_type( $post );
		//prar ( $post_type );
		$sidebarWidget = 'pages-widget';
		switch ($post_type) {
			case 'post':
				$sidebarToUse = get_theme_mod('posts_widget');
				if($sidebarToUse == 'custom' ) {
					$sidebarWidget = 'posts-widget';
				} elseif ( $sidebarToUse = false ) {
					$sidebarWidget = false;
				}	
				break;
			default:
				
		}
		//check to see if custom override
		if(isset($post) && $post->ID) {
			$customWidget = get_post_meta( $post->ID, 'replace-sidebar', true ); 
			if( $customWidget ) $sidebarWidget = $customWidget ;
		}
		return $sidebarWidget;
}
/**  * Add additional classes onto widgets
 *
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */
function bb_widget_first_last_classes($params) {
  global $my_widget_num;

  $this_id = $params[0]['id'];
  $arr_registered_widgets = wp_get_sidebars_widgets();

  if (!$my_widget_num) {
    $my_widget_num = array();
  }

  if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
    return $params;
  }

  if (isset($my_widget_num[$this_id])) {
    $my_widget_num[$this_id] ++;
  } else {
    $my_widget_num[$this_id] = 1;
  }

  $class = 'class="widget-' . $my_widget_num[$this_id] . ' ';

  if ($my_widget_num[$this_id] == 1) {
    $class .= 'widget-first ';
  } elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
    $class .= 'widget-last ';
  }

  $params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

  return $params;

}
/**	Change output of widgets
 *	http://badfunproductions.com/create-a-custom-walker-class-to-extend-wp_list_pages/
 */
 
//http://wp.tutsplus.com/tutorials/creative-coding/building-custom-wordpress-widgets/


// @TODO: Check wp-includes/default-widgets.php for which to override. Ideally all of them to have correct classes. 
/** REGISTER CUSTOM WIDGETS **/
function bear_bones_widget_registration() {
	register_widget('Company_Vcard_Widget');
	register_widget('Personal_Vcard_Widget');
	register_widget( 'Unfiltered_Text_Widget' );
	//unregister_widget('WP_Widget_Recent_Posts');
	//register_widget('Bear_Bones_Recent_Posts_Widget');
	unregister_widget('WP_Widget_Recent_Comments');
	register_widget('Bear_Bones_Recent_Comments_Widget');
	unregister_widget('WP_Widget_Archives');
	register_widget('Bear_Bones_Archives_Widget');
	unregister_widget('WP_Widget_Meta');
	register_widget('Bear_Bones_Meta_Widget');
}





/**
 * Simplified variant of the native text widget class.
 *
 * @author Thomas Scholz aka toscho http://toscho.de
 * @version 1.0
 */
class Unfiltered_Text_Widget extends WP_Widget
{
    /**
     * @uses apply_filters( 'magic_widgets_name' )
     */
    public function __construct()
    {
        // You may change the name per filter.
        // Use add_filter( 'magic_widgets_name', 'your custom_filter', 10, 1 );
        $widgetname = apply_filters( 'magic_widgets_name', 'Unfiltered Text' );
        parent::__construct(
            'unfiltered_text'
        ,   $widgetname
        ,   array( 'description' => 'Pure Markup' )
        ,   array( 'width' => 300, 'height' => 150 )
        );
    }

    /**
     * Output.
     *
     * @param  array $args
     * @param  array $instance
     * @return void
     */
    public function widget( $args, $instance )
    {
        echo $instance['text'];
    }

    /**
     * Prepares the content. Not.
     *
     * @param  array $new_instance New content
     * @param  array $old_instance Old content
     * @return array New content
     */
    public function update( $new_instance, $old_instance )
    {
        return $new_instance;
    }

    /**
     * Backend form.
     *
     * @param array $instance
     * @return void
     */
    public function form( $instance )
    {
        $instance = wp_parse_args( (array) $instance, array( 'text' => '' ) );
        $text     = format_to_edit($instance['text']);
?>
        <textarea class="widefat" rows="7" cols="20" id="<?php
            echo $this->get_field_id( 'text' );
        ?>" name="<?php
            echo $this->get_field_name( 'text' );
        ?>"><?php
            echo $text;
        ?></textarea>
        <?php
        /* To enable the preview uncomment the following lines.
         * Be aware: Invalid HTML may break the rest of the site and it
         * may disable the option to repair the input text.

        ! empty ( $text )
            and print '<h3>Preview</h3><div style="border:3px solid #369;padding:10px">'
                . $instance['text'] . '</div>';
        /**/
    }
}


Class Bear_Bones_Recent_Comments_Widget extends WP_Widget_Recent_Comments {
 
	function widget( $args, $instance ) {
		global $comments, $comment;

		$cache = wp_cache_get('widget_recent_comments', 'widget');

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

 		extract($args, EXTR_SKIP);
 		$output = '';
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Comments', 'bearbones' ) : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 5;

		$comments = get_comments( apply_filters( 'widget_comments_args', array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish' ) ) );
		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul class="'.$id.'-widget__list widget__list">';
		if ( $comments ) {
			// Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
			$post_ids = array_unique( wp_list_pluck( $comments, 'comment_post_ID' ) );
			_prime_post_caches( $post_ids, strpos( get_theme_mod( 'permalink_structure' ), '%category%' ), false );

			foreach ( (array) $comments as $comment) {
				$output .=  '<li class="recentcomments '.$id.'-widget__item widget__item">' . /* translators: comments widget: 1: comment author, 2: post link */ sprintf(_x('%1$s on %2$s', 'widgets', 'bearbones'), get_comment_author_link(), '<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '" class="widget__link">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
			}
 		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo $output;
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_comments', $cache, 'widget');
	}
}

Class Bear_Bones_Archives_Widget extends WP_Widget_Archives {
	function widget( $args, $instance ) {
		extract($args);
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Archives', 'bearbones') : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		if ( $d ) {
?>
		<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> <option value=""><?php echo esc_attr(__('Select Month', 'bearbones')); ?></option> <?php wp_get_archives(apply_filters('widget_archives_dropdown_args', array('type' => 'monthly', 'format' => 'option', 'show_post_count' => $c))); ?> </select>
<?php
		} else {
?>
		<ul class="<?php echo $id; ?>-widget__list widget__list">
		<?php wp_get_archives(apply_filters('widget_archives_args', array('type' => 'monthly', 'show_post_count' => $c))); ?>
		</ul>
<?php
		}

		echo $after_widget;
	}
}

Class Bear_Bones_Meta_Widget extends WP_Widget_Meta {
	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Meta', 'bearbones') : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
?>
			<ul class="<?php echo $id; ?>-widget__list widget__list">
			<?php wp_register(); ?>
			<li class="<?php echo $id; ?>-widget__item widget__item"><?php wp_loginout(); ?></li>
			<li class="<?php echo $id; ?>-widget__item widget__item"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0', 'bearbones')); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li class="<?php echo $id; ?>-widget__item widget__item"><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS', 'bearbones')); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
			<li class="<?php echo $id; ?>-widget__item widget__item"><a href="<?php esc_attr_e( 'http://wordpress.org/', 'bearbones' ); ?>" title="<?php echo esc_attr(__('Powered by WordPress, state-of-the-art semantic personal publishing platform.', 'bearbones')); ?>"><?php
			/* translators: meta widget link text */
			_e( 'WordPress.org', 'bearbones' );
			?></a></li>
			<?php wp_meta(); ?>
			</ul>
<?php
		echo $after_widget;
	}
}

?>