<?php
/** Extend Recent Posts Widget 
 *
 * Adds different formatting to the default WordPress Recent Posts Widget
 * https://gist.github.com/paulruescher/2998060
 */
Class Bear_Bones_Recent_Posts_Widget extends WP_Widget_Recent_Posts {

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_recent_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
		
		$custom_template = ( ! empty( $instance['custom_template'] ) ) ? $instance['custom_template'] : null;
		
		$custom_template = apply_filters( 'widget_title', $custom_template, $instance, $this->id_base );

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
			if( $custom_template && file_exists( get_stylesheet_directory()  . $custom_template ) ) {
				prar($custom_template);
			} elseif( file_exists( get_stylesheet_directory()  . '/recent-posts.php' ) ) {
				prar('recent-posts in child theme');
			} elseif( file_exists( get_template_directory()  . '/recent-posts.php' ) ) {
				prar('recent-posts in parent theme');
				get_template_part('recent-posts');
			} else {
?>
		<?php echo $args['before_widget']; ?>
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
<?php
			}
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_recent_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['custom_template'] = strip_tags($new_instance['custom_template']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_recent_entries']) )
			delete_option('widget_recent_entries');

		return $instance;
	}



	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		$custom_template     = isset( $instance['custom_template'] ) ? esc_attr( $instance['custom_template'] ) : '';
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
		
		<p><label for="<?php echo $this->get_field_id( 'custom_template' ); ?>"><?php _e( 'Custom Template:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'custom_template' ); ?>" name="<?php echo $this->get_field_name( 'custom_template' ); ?>" type="text" value="<?php echo $custom_template; ?>" /></p>
<?php
	}
}
 ?>