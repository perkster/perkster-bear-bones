<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

add_action ('admin_menu', 'bear_bones_admin_menu_customize');
function bear_bones_admin_menu_customize() {
    // add the Customize link to the admin menu
	global $wp_version;
	if (version_compare($wp_version, '3.6', '<')) {
	// version is 2.7 or higher
		add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
	}
}

add_action('customize_register', 'bear_bones_customize_register');
function bear_bones_customize_register($wp_customize) {

	$wp_customize->remove_section( 'colors');

	/*------------------------------------*\
		STYLE
	\*------------------------------------*/
	
	$wp_customize->add_section( 'bear_bones_style_options', array(
			'title'          => __( 'Style Options', 'bearbones' ),
			'priority'       => 30,
		) );
	$wp_customize->add_setting( 'main_style', array(
        'default'        => 'style',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
    ) );
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'main_style', 
		array(
			'label' => 'Main style',
			'section' => 'bear_bones_style_options',
			'settings' => 'main_style',
			'extra' =>'Change main stylesheet to include',
			'priority'	=> 2,
        ) ) 
    );
		$wp_customize->add_setting( 'use_admin_style', array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'use_admin_style',
			array(
				'type' => 'checkbox',
				'label' => 'Use admin stylesheet ',
				'section' => 'bear_bones_style_options',
				'priority'       => 1,
			)
		);
		$wp_customize->add_setting( 'admin_style', array(
        'default'        => '',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
    ) );
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'admin_style', 
		array(
			'label' => 'Admin style',
			'section' => 'bear_bones_style_options',
			'settings' => 'admin_style',
			'extra' =>'Override default style.css with this file name',
			'priority'	=> 2,
        ) ) 
    );

	 if (is_child_theme()) {
		
		$wp_customize->add_setting( 'include_parent_style', array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'include_parent_style',
			array(
				'type' => 'checkbox',
				'label' => 'Include parent stylesheet',
				'section' => 'bear_bones_style_options',
				'priority'       => 3,
			)
		);
	} else {

	}
	

	$wp_customize->add_setting( 'included_css', array(
		'type'		=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',		
	) );
 
	$wp_customize->add_control(	new Bear_Bones_Customize_Textarea_Control(
			$wp_customize,
			'bb_extra_css',
			array(
				'label' => 'Included extra css',
				'section' => 'bear_bones_style_options',
				'settings' => 'included_css',
				'extra' =>'Separate multiple stylesheets with a semi-colon. For example: http://fonts.com?css1;//cdn.someco.com/style.css',
				'priority'       => 10,
			)
		)
	);
	
	$wp_customize->add_setting( 'custom_css', array(
		'type'		=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_css',
	) );
 
	$wp_customize->add_control(	new Bear_Bones_Customize_Textarea_Control(
			$wp_customize,
			'bb_custom_css',
			array(
				'label' => 'Custom css',
				'section' => 'bear_bones_style_options',
				'settings' => 'custom_css',
				'priority'       => 20,				
			)
		)
	);
	
	

	
	/*------------------------------------*\
		JAVASCRIPT
	\*------------------------------------*/
	
	$wp_customize->add_section( 'bear_bones_js_options', array(
		'title'          => __( 'JS Options', 'bearbones' ),
		'priority'       => 35,
	) );
	
		$wp_customize->add_setting( 'js_footer', array(
			'default'        => 1,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'js_footer',
			array(
				'type' => 'checkbox',
				'label' => 'Put js files in footer',
				'section' => 'bear_bones_js_options',
				'priority'       => 1,				
			)
		);
	
		$wp_customize->add_setting( 'include_jquery', array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'include_jquery',
			array(
				'type' => 'checkbox',
				'label' => 'Include jQuery',
				'section' => 'bear_bones_js_options',
				'priority'       => 2,				
			)
		);
		$wp_customize->add_setting( 'include_modernizr', array(
			'default'        => false,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_key',
		) );
		/*$wp_customize->add_control(	'include_modernizr',
			array(
				'type' => 'checkbox',
				'label' => 'Include Modernizr',
				'section' => 'bear_bones_js_options',
				'priority'       => 5,				
			)
		);*/
	$wp_customize->add_control( 'include_modernizr', array(
		'label'      => 'Include Modernizr',
		'section'    => 'bear_bones_js_options',
		'type'       => 'select',
		//widget placement: 1= above, 2=left, 3 = right, 4 = below
		'choices' => array(
				false 	=> 'Do not include',
				'local' 	=> 'Include local Bear Bones version',
				'cdn' 	=> 'Include from CDN - https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',				
				
			),
		'priority'       => 2,		
	) ); 
	
	$wp_customize->add_setting( 'included_js_scripts', array(
		'type'		=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
	) );
 
	$wp_customize->add_control(	new Bear_Bones_Customize_Textarea_Control(
			$wp_customize,
			'bb_custom_js_scripts',
			array(
				'label' => 'Include Js scripts',
				'section' => 'bear_bones_js_options',
				'settings' => 'included_js_scripts',
				'extra' =>'Separate multiple scripts with a semi-colon.  For example: /js/lytebox/lytebox.js; /js/vendor/modernizr-2.8.3.min.js',
				'priority'       => 10,				
			)
		)
	);	

	$wp_customize->add_setting( 'include_jquery_ui_tabs', array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'include_jquery_ui_tabs',
			array(
				'type' => 'checkbox',
				'label' => 'Include jQuery UI Tabs',
				'section' => 'bear_bones_js_options',
				'priority'       => 20,				
			)
		);
	
	$wp_customize->add_setting( 'include_jquery_ui_accordion', array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'include_jquery_ui_accordion',
			array(
				'type' => 'checkbox',
				'label' => 'Include jQuery UI Accordion',
				'section' => 'bear_bones_js_options',
				'priority'       => 25,				
			)
		);
 
	/*------------------------------------*\
		LOGO
	\*------------------------------------*/
	
    $wp_customize->add_section( 'bear_bones_logo_settings', array(
        'title'          => __( 'Logo options', 'bearbones' ),
        'priority'       => 40,
    ) );
	
	$bb_theme_logo_url = get_stylesheet_directory_uri() . '/images/logo.png';
	$wp_customize->add_setting( 'site_logo', array(
        'default'        => $bb_theme_logo_url,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
    ) );
 
    $wp_customize->add_control( new WP_Customize_Image_Control ( $wp_customize, 'site_logo', array(
        'label'   => 'Logo',
        'section' => 'bear_bones_logo_settings',
        'settings'   => 'site_logo',
		'priority'       => 1,		
    ) ) );
	
	$wp_customize->add_setting( 'logo_alt_text', array(
        'default'        => 'logo',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_text',
    ) );
 
    $wp_customize->add_control( 'logo_alt_text', array(
        'label'   => 'Alt for logo',
        'section' => 'bear_bones_logo_settings',
        'type'    => 'text',
		'priority'       => 5,
    ) );
	
	$wp_customize->add_setting( 'favicon_path', array(
        'default'        => null,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
    ) );
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'favicon_path', 
		array(
			'label' => 'Path to favicons',
			'section' => 'bear_bones_logo_settings',
			'settings' => 'favicon_path',
			'extra' =>'Path is realtive to theme. favicon.png, favicon.ico, touchicon.png, precomposed.png, tileicon.png',			
			'priority'	=> 10,
        ) ) 
    );
	
	$wp_customize->add_setting( 'favicon_color', array(
        'default'        => '#ffffff',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_css_color',
    ) );
 
    $wp_customize->add_control( 'favicon_color', array(
        'label'   => 'Favicon color used for metro tile',
        'section' => 'bear_bones_logo_settings',
        'type'    => 'text',
		'priority'       => 15,
    ) );
	
	
	/*------------------------------------*\
		TOP BAR
	\*------------------------------------*/
	
	$wp_customize->add_section( 'bear_bones_topbar_settings', array(
        'title'          => __( 'Topbar', 'bearbones' ),
        'priority'       => 45,
    ) );
	$wp_customize->add_setting( 'topbar_widget', array(
        'default'        => 0,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
    ) );
	$wp_customize->add_control(	'topbar_widget',
		array(
			'type' => 'checkbox',
			'label' => 'Include Topbar Widget',
			'section' => 'bear_bones_topbar_settings',
			'priority'       => 1,			
		)
	);
	
	$wp_customize->add_setting( 'second_topbar_widget', array(
        'default'        => 0,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
    ) );	
	$wp_customize->add_control(	'second_topbar_widget',
		array(
			'type' => 'checkbox',
			'label' => 'Include Second Topbar Widget',
			'section' => 'bear_bones_topbar_settings',
			'priority'       => 2,			
		)
	);
	
	
	/*------------------------------------*\
		HEADER & MENU
	\*------------------------------------*/
	$wp_customize->add_section( 'bear_bones_header_settings', array(
        'title'          => __( 'Header & Main Menu', 'bearbones' ),
        'priority'       => 50,
    ) );
	$wp_customize->add_setting( 'main_menu', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',			
		)
	);
	$wp_customize->add_control(	'main_menu',
		array(
			'type' => 'checkbox',
			'label' => 'Show Main Menu',
			'section' => 'bear_bones_header_settings',
			'priority'       => 1,			
		)
	);
	
	$wp_customize->add_setting( 'main_menu_placement', array(
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_key',		
    ) );	
	$wp_customize->add_control( 'main_menu_placement', array(
		'label'      => 'Main Menu Placement',
		'section'    => 'bear_bones_header_settings',
		'type'       => 'select',
		//widget placement: 1= above, 2=left, 3 = right, 4 = below
		'choices' => array(
				'above_header' 	=> 'Above header',
				'below_header' 	=> 'Below header',				
				'right_logo' 	=> 'Right of logo',
			),
		'priority'       => 2,		
	) ); 
	
	$wp_customize->add_setting( 'header_widget', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'header_widget',
		array(
			'type' => 'checkbox',
			'label' => 'Use Header Widget',
			'section' => 'bear_bones_header_settings',
			'priority'       => 3,			
		)
	);
	
	$wp_customize->add_setting( 'header_widget_placement', array(
        'default'        => 'right_header_before',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_key',
    ) );	
	$wp_customize->add_control( 'header_widget_placement', array(
		'label'      => 'Header Widget Placement',
		'section'    => 'bear_bones_header_settings',
		'type'       => 'select',
		//widget placement: 1= above, 2=left, 3 = right, 4 = below
		'choices' => array(
				'above_header_before_menu' 	=> 'Above header - before menu',
				'above_header_after_menu' 	=> 'Above header - after menu',
				'below_header_before_menu' 	=> 'Below header - before menu',
				'below_header_after_menu' 	=> 'Below header - after menu',
				'right_logo_before' 		=> 'Right of logo - before menu ',
				'right_logo_after' 			=> 'Right of logo - after menu ',
			),
		'priority'       => 4,		
	) ); 
	
	
	$wp_customize->add_setting( 'header_logo_image', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',	
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'header_logo_image',
		array(
			'type' => 'checkbox',
			'label' => 'Include logo image',
			'section' => 'bear_bones_header_settings',
			'priority'       => 5,			
		)
	);
	$wp_customize->add_setting( 'header_site_title', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'header_site_title',
		array(
			'type' => 'checkbox',
			'label' => 'Include Site Title',
			'section' => 'bear_bones_header_settings',
			'priority'       => 6,			
		)
	);	
	$wp_customize->add_setting( 'header_site_tagline', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',	
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'header_site_tagline',
		array(
			'type' => 'checkbox',
			'label' => 'Include site tagline',
			'section' => 'bear_bones_header_settings',
			'priority'       => 7,			
		)
	);	
	$wp_customize->add_setting( 'header_image_placement', array(
		'default'        => 0,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'esc_html',		
    ) );	
	$wp_customize->add_control( 'header_image_placement', array(
		'label'      => 'Header Image Placement',
		'section'    => 'bear_bones_header_settings',
		'type'       => 'select',
		'choices' => array(
				0 					=> 'Do not use',
				'as_background' 	=> 'As background of header',				
				'before_logo'	 	=> 'Before logo/title/tagline',
				'after_logo'		=> 'After logo/title/tagline'
			),
		'priority'       => 15,		
	) ); 
	
	/*------------------------------------*\
		BACKGROUND IMAGE
	\*------------------------------------*/
	$wp_customize->add_setting( 'background_image_size', array(
		'default'        => 'cover',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_percent',		
    ) );	
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'background_image_size', 
		array(
			'label' => 'background-size',
			'section' => 'background_image',
			'settings' => 'background_image_size',
			'extra' =>'Typical options: cover, 100% 100%, 100% auto, 25%. 
			For more information http://www.w3schools.com/cssref/css3_pr_background-size.asp',
			'priority'	=> 20,
        ) ) 
    );
	
	
	/*------------------------------------*\
		ADDITIONAL SETTINGS
	\*------------------------------------*/
	$wp_customize->add_section( 'bear_bones_addl_settings', array(
        'title'          => __( 'Additional Settings', 'bearbones' ),
        'priority'       => 100,
    ) );
	
	$wp_customize->add_setting( 'addl_widgets', array(
		'type'		=> 'theme_mod',
		'capability'	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
	) );
 
	$wp_customize->add_control(	new Bear_Bones_Customize_Textarea_Control(
			$wp_customize,
			'bb_addl_widgets',
			array(
				'label' => 'Additional widgets',
				'section' => 'bear_bones_addl_settings',
				'settings' => 'addl_widgets',
				'extra' =>'Separate additional widgets with a semi-colon.  To include on a page or post, add custom field "widget-top" or "widget-bottom"',
				'priority'       => 5,				
			)
		)
	);
	$wp_customize->add_setting( 'yoast_breadcrumb', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',	
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'yoast_breadcrumb',
		array(
			'type' => 'checkbox',
			'label' => 'Include Wordpress SEO by Yoast breadcrumb',
			'section' => 'bear_bones_addl_settings',
			'priority'       => 2,			
		)
	);	
	
	$wp_customize->add_setting( 'images__sizes', 
		array(
			'default'        => '',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
	
 	$wp_customize->add_control(	new Bear_Bones_Customize_Textarea_Control(
			$wp_customize,
			'images__sizes',
			array(
				'label' => 'Addtional image sizes to include in theme',
				'section' => 'bear_bones_addl_settings',
				'settings' => 'images__sizes',
				'extra' =>'Usage: blog-thumbnail,225,100,true; sidebar,150,150;  Use a comma to separate values: name,width,height,crop(optional), semi-colon to separate different images. ',
				'priority'       => 10,				
			)
		)
	);

	
	/*------------------------------------*\
		PAGES
	\*------------------------------------*/
	
	//@TODO: Add pages options which sets default layout even though individual pages can use different templates
	
	$wp_customize->add_section( 'bear_bones_pages_options', array(
        'title'          => __( 'Pages', 'bearbones' ),
        'priority'       => 121,
    ) );
	
	$wp_customize->add_setting( 'pages_title', array(
		'default'		=> 0,
		'type'			=> 'theme_mod',
		'capability' 	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
	) );
	$wp_customize->add_control(	'pages_title',
		array(
			'type' => 'checkbox',
			'label' => 'Display title on pages',
			'section' => 'bear_bones_pages_options',
			'priority'       => 1,			
		)
	);
	
	
	$wp_customize->add_setting( 'pages_widget', array(
		'default'		=> 0,
		'type'			=> 'theme_mod',
		'capability' 	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
	) );
	$wp_customize->add_control(	'pages_widget',
		array(
			'type' => 'checkbox',
			'label' => 'Use sidebar on pages',
			'section' => 'bear_bones_pages_options',
			'priority'       => 2,
		)
	);
	$wp_customize->add_setting( 'home_sidebar', array(
		'default'		=> 0,
		'type'			=> 'theme_mod',
		'capability' 	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
	) );
	$wp_customize->add_control(	'home_sidebar',
		array(
			'type' => 'checkbox',
			'label' => 'Use pages/main sidebar on home page',
			'section' => 'bear_bones_pages_options',
			'priority'       => 3,			
		)
	);
	$wp_customize->add_setting( 'pages_widget_right', array(
		'default'		=> 1,
		'type'			=> 'theme_mod',
		'capability' 	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
	) );
	$wp_customize->add_control(	'pages_widget_right',
		array(
			'type' => 'checkbox',
			'label' => 'Sidebar on right (uncheck for left)',
			'section' => 'bear_bones_pages_options',
			'priority'       => 5,			
		)
	);
	
	$wp_customize->add_setting( 'pages__display_featured', 
		array(
			'default'        => false,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_key',			
		)
	);
	$wp_customize->add_control(	'pages__display_featured',
		array(
			'type'       => 'select',
			'choices'    => array(
				'before_title' => 'Before Title',
				'after_title' => 'After Title',
				false => 'No featured image on pages'
			),
			//'type' => 'checkbox',
			'label' => 'Display featured image at top of page',
			'section' => 'bear_bones_pages_options',
			'priority'       => 25,			
		)
	);
	$wp_customize->add_setting( 'pages__featured_size', array(
        'default'        => 'post-featured',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_text',
    ) );
 
    $wp_customize->add_control( 'pages__featured_size', array(
        'label'   => 'Page featured image thumbnail size',
        'section' => 'bear_bones_pages_options',
        'type'    => 'text',
		'priority'       => 30,
    ) );
	
	$wp_customize->add_setting( 'pages__featured_class', array(
        'default'        => 'post-featured-image__image',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_text',
    ) );
 
    $wp_customize->add_control( 'pages__featured_class', array(
        'label'   => 'Page featured image class',
        'section' => 'bear_bones_pages_options',
        'type'    => 'text',
		'priority'       => 30,
    ) );

		
	
	/*------------------------------------*\
		POSTS
	\*------------------------------------*/	

	
	$wp_customize->add_section( 'bear_bones_posts', array(
        'title'          => __( 'Posts', 'bearbones' ),
        'priority'       => 145,
    ) );
	
	$wp_customize->add_setting( 'blog__title', array(
        'default'        => null,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_text',
    ) );
 
    $wp_customize->add_control( 'blog__title', array(
        'label'   => 'Blog Title',
        'section' => 'bear_bones_posts',
        'type'    => 'text',
		'priority'       => 1,
    ) );

	$wp_customize->add_setting( 'posts_widget', 
		array(
			'default'        => 'pages',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( 'posts_widget', array(
		'label'      => 'Use sidebar on posts',
		'section'    => 'bear_bones_posts',
		'type'       => 'select',
		'choices'    => array(
			'pages' => 'Use main sidebar',
			'custom' => 'Use custom posts sidebar',
			false => 'No sidebar on posts'
		),
		'priority'       => 5,		
	) );
	$wp_customize->add_setting( 'posts_widget_right', array(
		'default'		=> false,
		'type'			=> 'theme_mod',
		'capability' 	=> 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_checkbox',
	) );
	$wp_customize->add_control(	'posts_widget_right',
		array(
			'type' => 'checkbox',
			'label' => 'Sidebar on right (uncheck for left)',
			'section' => 'bear_bones_posts',
			'priority'       => 10,			
		)
	);
	$wp_customize->add_setting( 'posts__excerpt_length', array(
        'default'        => 55,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_text',
    ) );
 
    $wp_customize->add_control( 'posts__excerpt_length', array(
        'label'   => 'Post excerpt length',
        'section' => 'bear_bones_posts',
        'type'    => 'text',
		'priority'       => 15,
    ) );

	$wp_customize->add_setting( 'posts__display_featured', 
		array(
			'default'        => false,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_key',			
		)
	);
	$wp_customize->add_control(	'posts__display_featured',
		array(
			'type'       => 'select',
			'choices'    => array(
				'before_title' => 'Before Title',
				'after_title' => 'After Title',
				false => 'No featured image on posts'
			),
			//'type' => 'checkbox',
			'label' => 'Display featured image at top of post',
			'section' => 'bear_bones_posts',
			'priority'       => 22,			
		)
	);
	
	$wp_customize->add_setting( 'posts__featured_class', array(
        'default'        => 'post-featured-image__image',
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_text',
    ) );
 
    $wp_customize->add_control( 'posts__featured_class', array(
        'label'   => 'Post featured image class',
        'section' => 'bear_bones_posts',
        'type'    => 'text',
		'priority'       => 23,
    ) );
	
	$wp_customize->add_setting( 'post__featured_image', 
		array(
			'default'        => null,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	); 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post__featured_image', 
		array(
			'label' => 'Posts featured image size (post-featured)',
			'section' => 'bear_bones_posts',
			'settings' => 'post__featured_image',
			'extra' => 'width-height-crop(optional)',
			'priority'	=> 25,
        ) ) 
    );
	$wp_customize->add_setting( 'post__thumbnail', 
		array(
			'default'        => null,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post__thumbnail', 
		array(
			'label' => 'Posts thumbnail image size (post-thumbnail)',
			'section' => 'bear_bones_posts',
			'settings' => 'post__thumbnail',
			'extra' => 'width-height-crop(optional)',
			'priority'	=> 30,
        ) ) 
    );
	
	
	$wp_customize->add_setting( 'posts__meta_template', 
		array(
			'default'        => 'none',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'posts__meta_template', 
		array(
			'label' => 'Meta tags to include on top of post',
			'section' => 'bear_bones_posts',
			'settings' => 'posts__meta_template',
			'extra' => 'Comma separated list: author, date, updated, category, custom. Use ? for prepended text. Use ! for appended text [] indicates separator (use at end).  Example: updated?Updated on, author?by, category?<span class="post-meta__category">Found in:!</span> [ | ]',
			'priority'	=> 60,
        ) ) 
    );
	
	$wp_customize->add_setting( 'posts__meta_template__bottom', 
		array(
			'default'        => 'none',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'posts__meta_template__bottom', 
		array(
			'label' => 'Meta tags to include on bottom of post',
			'section' => 'bear_bones_posts',
			'settings' => 'posts__meta_template__bottom',
			'extra' => 'Comma separated list: author, date, updated, category, custom. Use ? for prepended text. Use ! for appended text [] indicates separator (use at end).  Example: updated?Updated on, author?by, category?<span class="post-meta__category">Found in:!</span> [ | ]',
			'priority'	=> 70,
        ) ) 
    );
 
	/*
	$wp_customize->add_setting( 'posts__tags', 
		array(
			'default'        => 1,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'posts__tags',
		array(
			'type' => 'checkbox',
			'label' => 'Display tags',
			'section' => 'bear_bones_posts',
			'priority'       => 15,
		)
	);
	$wp_customize->add_setting( 'posts__categories', 
		array(
			'default'        => 1,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',			
		)
	);
	$wp_customize->add_control(	'posts__categories',
		array(
			'type' => 'checkbox',
			'label' => 'Display categories',
			'section' => 'bear_bones_posts',
			'priority'       => 20,			
		)
	);*/
	
	/*------------------------------------*\
		POST LINKS
	\*------------------------------------*/
	
	$wp_customize->add_section( 'bear_bones_post_links', array(
        'title'          => __( 'Post Links', 'bearbones' ),
		'priority'		 => 150,
    ) );
	$wp_customize->add_setting( 'post_links__display', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',			
		)
	);
	$wp_customize->add_control(	'post_links__display',
		array(
			'type' => 'checkbox',
			'label' => 'Display post links',
			'section' => 'bear_bones_post_links',
			'priority'       => 1,			
		)
	);	
	$wp_customize->add_setting( 'post_links__title', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',			
		)
	);
	$wp_customize->add_control(	'post_links__title',
		array(
			'type' => 'checkbox',
			'label' => 'Display post title',
			'section' => 'bear_bones_post_links',
			'priority'       => 2,			
		)
	);	
	$wp_customize->add_setting( 'post_links__previous_before_next', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',			
		)
	);
	$wp_customize->add_control(	'post_links__previous_before_next',
		array(
			'type' => 'checkbox',
			'label' => 'Previous before next',
			'section' => 'bear_bones_post_links',
			'priority'       => 5,			
		)
	);	
	$wp_customize->add_setting( 'post_links__thumbnail', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',			
		)
	);
	$wp_customize->add_control(	'post_links__thumbnail',
		array(
			'type' => 'checkbox',
			'label' => 'Include post thumbnail',
			'section' => 'bear_bones_post_links',
			'priority'       => 8,			
		)
	);	
	$wp_customize->add_setting( 'post_link__thumbnail', 
		array(
			'default'        => '150-100-true',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post_link__thumbnail', 
		array(
			'label' => 'Post link thumbnail size',
			'section' => 'bear_bones_post_links',
			'settings' => 'post_link__thumbnail',
			'extra' => 'width-height-crop(optional)',
			'priority'	=> 10,
        ) ) 
    );
	
	$wp_customize->add_setting( 'post_links__previous_prepend', 
		array(
			'default'        => 'Previous: ',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post_links__previous_prepend', 
		array(
			'label' => 'Text to prepend previous link',
			'section' => 'bear_bones_post_links',
			'settings' => 'post_links__previous_prepend',
			'extra' => 'Text is included in link',
			'priority'	=> 20,
        ) ) 
    );
	$wp_customize->add_setting( 'post_links__previous_append', 
		array(
			'default'        => null,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post_links__previous_append', 
		array(
			'label' => 'Text to append previous link',
			'section' => 'bear_bones_post_links',
			'settings' => 'post_links__previous_append',
			'extra' => 'Text is included in link',
			'priority'	=> 30,
        ) ) 
    );
	$wp_customize->add_setting( 'post_links__next_prepend', 
		array(
			'default'        => 'Next: ',
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post_links__next_prepend', 
		array(
			'label' => 'Text to prepend next link',
			'section' => 'bear_bones_post_links',
			'settings' => 'post_links__next_prepend',
			'extra' => 'Text is included in link',
			'priority'	=> 40,
        ) ) 
    );
	$wp_customize->add_setting( 'post_links__next_append', 
		array(
			'default'        => null,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_html',
		)
	);
 
	$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'post_links__next_append', 
		array(
			'label' => 'Text to append next link',
			'section' => 'bear_bones_post_links',
			'settings' => 'post_links__next_append',
			'extra' => 'Text is included in link',
			'priority'	=> 50,
        ) ) 
    );
	
	/*------------------------------------*\
		FOOTER
	\*------------------------------------*/
	
	$wp_customize->add_section( 'bear_bones_footer_settings', array(
        'title'          => __( 'Footer', 'bearbones' ),
		'priority'		 => 175,
    ) );
	
	$wp_customize->add_setting( 'do_not_include_footer_widget', array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		) );
		$wp_customize->add_control(	'do_not_include_footer_widget',
			array(
				'type' => 'checkbox',
				'label' => 'DO NOT Include Footer widget',
				'section' => 'bear_bones_footer_settings',
				'priority'       => 5,				
			)
		);
	
	$wp_customize->add_setting( 'footer_copyright', 
		array(
			'default'        => 1,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'footer_copyright',
		array(
			'type' => 'checkbox',
			'label' => 'Include copyright in footer',
			'section' => 'bear_bones_footer_settings',
			'priority'       => 10,			
		)
	);
	$wp_customize->add_setting( 'copyright_start', array(
        'default'        =>  null,
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'absint',
    ) );
 
    $wp_customize->add_control( 'copyright_start', array(
        'label'   => 'Copyright start year',
        'section' => 'bear_bones_footer_settings',
        'type'    => 'text',		
		'priority' => 20,
    ) );
	
	
	 $wp_customize->add_setting( 'copyright_text', array(
        'default'        => get_bloginfo('name'),
		'type'			 => 'theme_mod',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'bb_sanitize_html',
    ) );
 
    $wp_customize->add_control( 'copyright_text', array(
        'label'   => 'Copyright text',
        'section' => 'bear_bones_footer_settings',
        'type'    => 'text',		
		'priority' => 25,
    ) );	
	
	
	/*------------------------------------*\
		WOOCOMMERCE
	\*------------------------------------*/
	
	$wp_customize->add_section( 'bear_bones_woocommerce_settings', array(
        'title'          => __( 'WooCommerce', 'bearbones' ),
		'priority'		 => 175,
    ) );
	
	$wp_customize->add_setting( 'woocommerce_include', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'woocommerce_include',
		array(
			'type' => 'checkbox',
			'label' => 'Include woocommerce support',
			'section' => 'bear_bones_woocommerce_settings',
			'priority'       => 1,			
		)
	);
	
	$wp_customize->add_setting( 'woocommerce_include_overrides', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'woocommerce_include_overrides',
		array(
			'type' => 'checkbox',
			'label' => 'Include woocommerce overrides',
			'section' => 'bear_bones_woocommerce_settings',
			'priority'       => 5,			
		)
	);
	
	$wp_customize->add_setting( 'woocommerce_use_breadcrumbs', 
		array(
			'default'        => 0,
			'type'			 => 'theme_mod',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'bb_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(	'woocommerce_use_breadcrumbs',
		array(
			'type' => 'checkbox',
			'label' => 'Use woocommerce breadcrumbs',
			'section' => 'bear_bones_woocommerce_settings',
			'priority'       => 5,			
		)
	);
	//@TODO: Add textarea for checkout note
}


if (class_exists('WP_Customize_Control')) {
	class Bear_Bones_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';
		public $extra = '';
	 
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span><?php echo esc_html( $this->extra ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php
		}
	}
	
	class Bear_Bones_Custom_Text_Control extends WP_Customize_Control {
        public $type = 'customtext';
        public $extra = ''; // we add this for the extra description
        public function render_content() {
        ?>
        <label>            
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<span><?php echo esc_html( $this->extra ); ?></span>
            <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
        </label>
        <?php
        }
    }
    
	/*  Example: 
    $wp_customize->add_setting('', array(
            'default' => '',
            'type' => 'customtext',
            'capability' => 'edit_theme_options',
            'transport' => 'refresh',
        )
    );
$wp_customize->add_control( new Bear_Bones_Custom_Text_Control( 
		$wp_customize, 
		'setting', 
		array(
			'label' => 'Label',
			'section' => 'bear_bones_',
			'settings' => 'setting',
			'extra' =>'description',
			'priority'       => 3,
        ) 
		) 
    );
	*/
}
// use sanitize_text_field instead
function bb_sanitize_text( $input ) {
    return sanitize_text_field( $input );
}

function bb_sanitize_html( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function bb_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

function bb_sanitize_css( $input ) {
	return wp_kses_post( strip_tags( $input ) );
}

function bb_sanitize_css_color ( $input ) {
	if( substr( $input, 1 ) == "#") {
		return absint( substr ( $input, 2) );
	} else {
		return absint(  $input );
	}
}

function bb_sanitize_true_false( $input ) {
    if ( $input == 1 || $input = 0) {
        return $input;
    } else {
        return '';
    }
}

function bb_sanitize_percent( $input ) {
	return wp_kses( strip_tags( $input ), array ('%') );
}
?>