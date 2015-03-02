<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Template Name: Blank
 *
 * NOTES: The only thing that happens is the head and footer.
 */
?><?php get_template_part( 'head' ); 	?>
<!-- page-blank.php -->
<body <?php body_class(); ?>>
	
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php the_content(); ?>
	<?php endwhile; ?>
            
<?php else : ?>
        <h2>Not Found</h2>
<?php endif; ?>

	<!-- If theme customization option selected all js scripts are loaded in footer -->
<?php wp_footer(); ?>
</body>
</html> <!-- end page. what a ride! -->
