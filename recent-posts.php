<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?><!-- recent-posts.php-->
<?php
	global $r;
	global $args;
	echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		
		<ul class="<?php echo $args['id']; ?>-widget__list recent_posts_widget__list">
					<?php while( $r->have_posts() ) : $r->the_post(); ?>
					<?php //@TODO: set up different options for the recent posts widget to display (default, no date, excerpt) ?>
					<li class="<?php echo $args['id']; ?>-widget__item recent_posts_widget__item"><?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(  get_option('date_format') ); ?> - </span>
			<?php endif; ?> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></li>
					<?php endwhile; ?>
				</ul>
		<?php echo $args['after_widget']; ?>