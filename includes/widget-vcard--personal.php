<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// @TODO: Add image option to vCard
class Personal_Vcard_Widget extends WP_Widget {
  function Personal_Vcard_Widget() {
    $widget_ops = array('classname' => 'widget_personal_vcard', 'description' => __('Use this widget to add a personal vCard', 'bearbones'));
    $this->WP_Widget('widget_personal_vcard', __('vCard: Personal', 'bearbones'), $widget_ops);
    $this->alt_option_name = 'widget_personal_vcard';

    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('widget_personal_vcard', 'widget');

    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = null;
    }

    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    ob_start();
    extract($args, EXTR_SKIP);
	//print_r($instance);

    //$title = apply_filters('widget_title', empty($instance['title']) ? __('vCard', 'roots') : $instance['title'], $instance, $this->id_base);
	//is address set?
	$show_address = true;
	if (!isset($instance['street_address'])) {
		if (!isset($instance['locality'])) { $show_address = false; }
	} elseif($instance['street_address'] == '') {
		$show_address = false;
	}
	//is phone set?
	$show_tel = true;
	if (!isset($instance['tel'])) {
		if (!isset($instance['fax'])) { $show_tel = false; }
	} elseif($instance['tel'] == '') {
		if($instance['fax'] == '') {
			$show_tel = false;
		}
	}
	if (!isset($instance['widget_title'])) { $instance['widget_title'] = ''; }
    if (!isset($instance['first_name'])) { $instance['first_name'] = ''; }
	if (!isset($instance['last_name'])) { $instance['last_name'] = ''; }
	$show_name = isset($instance['show_name']) ? 'true' : '';
	if (!isset($instance['street_address'])) { $instance['street_address'] = ''; }
    if (!isset($instance['locality'])) { $instance['locality'] = ''; }
    if (!isset($instance['region'])) { $instance['region'] = ''; }
    if (!isset($instance['postal_code'])) { $instance['postal_code'] = ''; }
    if (!isset($instance['tel'])) { $instance['tel'] = ''; }
	if (!isset($instance['fax'])) { $instance['fax'] = ''; }
    if (!isset($instance['email'])) { $instance['email'] = ''; }
	if (!isset($instance['tel_label'])) { $instance['tel_label'] = ''; }
	if (!isset($instance['fax_label'])) { $instance['fax_label'] = ''; }
    if (!isset($instance['email_label'])) { $instance['email_label'] = ''; }

    echo $before_widget;
    if (isset($title)) {
      echo $before_title;
      echo $title;
      echo $after_title;
    }
	
  ?>

	<article class="vcard">
		<div class="visuallyhidden">
		<div class="n">
			First Name: <span class="given-name"><?php echo $instance['first_name']; ?></span><br>
			Last Name: <span class="family-name"><?php echo $instance['last_name']; ?></span>
		</div>
		<?php
			if($show_name == 'on') {
		?>
		</div>
		<div class="fn"><?php echo $instance['first_name']; ?> <?php echo $instance['last_name']; ?>
		<?php
			}
		?>
		</div>
		<?php if($show_address) { ?>
		<div class="adr">
			<?php if(isset($instance['street_address'])): ?><div class="street-address"><?php echo $instance['street_address']; ?></div><?php endif; ?>
			<?php if(isset($instance['extended_address'])): ?><div class="extended-address"><?php echo $instance['extended_address']; ?></div><?php endif; ?>
			<?php if(isset($instance['locality'])): ?><div class="locality"><?php echo $instance['locality']; ?></div><?php endif; ?><?php if(isset($instance['region'])): ?><div class="region"><?php echo $instance['region']; ?></div><?php endif; ?><?php if(isset($instance['postal_code'])): ?><div class="postal-code"><?php echo $instance['postal_code']; ?></div><?php endif; ?><?php if(isset($instance['country'])): ?><div class="country-name"><?php echo $instance['country']; ?></div><?php endif; ?>
		</div>
		<?php } ?>		
		<?php if($show_tel) { ?><div class="tel">
			<abbr class="type" title="voice"></abbr>
			<span class="visuallyhidden"><span class="type">Work</span></span><?php echo $instance['tel_label']; ?> <span class="value"><?php echo $instance['tel']; ?></span>
		</div>
		<?php if(($instance['fax'] !='')): ?>
		<div class="tel">
			<span class="visuallyhidden"><span class="tel"><span class="type">Fax</span></span></span><?php echo $instance['fax_label']; ?> <span class="value"><?php echo $instance['fax']; ?></span>
		</div>
		<?php endif; ?>
		<?php } ?>
		
		<?php if(isset($instance['email'])): ?>
		<div class="email">
			<span class="visuallyhidden"><span class="type">Internet</span><span class="type">pref</span></span><?php echo $instance['email_label']; ?>
			<a class="value" href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a>
		</div>
		<?php endif; ?>
	</article>
    
  <?php
    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_personal_vcard', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = $old_instance;
	//print_r($new_instance); //exit();
    $instance['first_name'] = strip_tags($new_instance['first_name']);
	$instance['last_name'] = strip_tags($new_instance['last_name']);
	$instance['show_name'] = strip_tags($new_instance['show_name']);
	$instance['title'] = strip_tags($new_instance['title']);
    $instance['street_address'] = strip_tags($new_instance['street_address']);
	$instance['extended_address'] = strip_tags($new_instance['extended_address']);
    $instance['locality'] = strip_tags($new_instance['locality']);
    $instance['region'] = strip_tags($new_instance['region']);
    $instance['postal_code'] = strip_tags($new_instance['postal_code']);
	$instance['country'] = strip_tags($new_instance['country']);
    $instance['tel'] = strip_tags($new_instance['tel']);
	$instance['tel_label'] = strip_tags($new_instance['tel_label']);
	$instance['fax'] = strip_tags($new_instance['fax']);
	$instance['fax_label'] = strip_tags($new_instance['fax_label']);
    $instance['email'] = strip_tags($new_instance['email']);
	$instance['email_label'] = strip_tags($new_instance['email_label']);
    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');
    if (isset($alloptions['widget_personal_vcard'])) {
      delete_option('widget_personal_vcard');
    }

    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_personal_vcard', 'widget');
  }

  function form($instance) {
	//print_r($instance);
    $first_name = isset($instance['first_name']) ? esc_attr($instance['first_name']) : '';	
	$last_name = isset($instance['last_name']) ? esc_attr($instance['last_name']) : '';	
	//$show_name = $instance('show_name');
	//echo 'Show Name: '.$instance('show_name');
	//$show_name = isset($instance['show_name']) ? esc_attr($instance['show_name']) : '';
	$show_name = isset($instance['show_name']) ? 'checked="checked"' : '';
	$title = isset($instance['title']) ? esc_attr($instance['title']) : '';	
    $street_address = isset($instance['street_address']) ? esc_attr($instance['street_address']) : '';
	$extended_address = isset($instance['extended_address']) ? esc_attr($instance['extended_address']) : '';
    $locality = isset($instance['locality']) ? esc_attr($instance['locality']) : '';
    $region = isset($instance['region']) ? esc_attr($instance['region']) : '';
    $postal_code = isset($instance['postal_code']) ? esc_attr($instance['postal_code']) : '';
	$country = isset($instance['country']) ? esc_attr($instance['country']) : '';
    $tel = isset($instance['tel']) ? esc_attr($instance['tel']) : '';
	$fax = isset($instance['fax']) ? esc_attr($instance['fax']) : '';
    $email = isset($instance['email']) ? esc_attr($instance['email']) : '';
	$tel_label = isset($instance['tel_label']) ? esc_attr($instance['tel_label']) : '';
	$fax_label = isset($instance['fax_label']) ? esc_attr($instance['fax_label']) : '';
    $email_label = isset($instance['email_label']) ? esc_attr($instance['email_label']) : '';
  ?>
	<p>You should enter a name so that if an individual downloads the vcard information it will get stored in their phone or tablet correctly.</p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('first_name')); ?>"><?php _e('First Name :', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('first_name')); ?>" name="<?php echo esc_attr($this->get_field_name('first_name')); ?>" type="text" value="<?php echo esc_attr($first_name); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('last_name')); ?>"><?php _e('Last Name :', 'roots'); ?></label>
	  <input class="widefat" id="<?php echo esc_attr($this->get_field_id('last_name')); ?>" name="<?php echo esc_attr($this->get_field_name('last_name')); ?>" type="text" value="<?php echo esc_attr($last_name); ?>" />
    </p>
	<p>
	  <input class="checkbox" type="checkbox" <?php echo $show_name; ?> id="<?php echo $this->get_field_id('show_name'); ?>" name="<?php echo $this->get_field_name('show_name'); ?>" />
	  <label for="<?php echo $this->get_field_id('show_name'); ?>"><?php _e('Show Name', 'bearbones'); ?></label>
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title :', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
	<hr>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('street_address')); ?>"><?php _e('Street Address:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('street_address')); ?>" name="<?php echo esc_attr($this->get_field_name('street_address')); ?>" type="text" value="<?php echo esc_attr($street_address); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('extended_address')); ?>"><?php _e('Extended Address: ', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extended_address')); ?>" name="<?php echo esc_attr($this->get_field_name('extended_address')); ?>" type="text" value="<?php echo esc_attr($extended_address); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('locality')); ?>"><?php _e('City/Locality:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('locality')); ?>" name="<?php echo esc_attr($this->get_field_name('locality')); ?>" type="text" value="<?php echo esc_attr($locality); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('region')); ?>"><?php _e('State/Region:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('region')); ?>" name="<?php echo esc_attr($this->get_field_name('region')); ?>" type="text" value="<?php echo esc_attr($region); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('postal_code')); ?>"><?php _e('Zipcode/Postal Code:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('postal_code')); ?>" name="<?php echo esc_attr($this->get_field_name('postal_code')); ?>" type="text" value="<?php echo esc_attr($postal_code); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('country')); ?>"><?php _e('Country: ', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('country')); ?>" name="<?php echo esc_attr($this->get_field_name('country')); ?>" type="text" value="<?php echo esc_attr($country); ?>" />
    </p>
	<hr>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('tel')); ?>"><?php _e('Telephone:', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tel')); ?>" name="<?php echo esc_attr($this->get_field_name('tel')); ?>" type="text" value="<?php echo esc_attr($tel); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('tel_label')); ?>"><?php _e('Label for Telephone (ex. "Tel:"):', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('tel_label')); ?>" name="<?php echo esc_attr($this->get_field_name('tel_label')); ?>" type="text" value="<?php echo esc_attr($tel_label); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('fax')); ?>"><?php _e('Fax: ', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('fax')); ?>" name="<?php echo esc_attr($this->get_field_name('fax')); ?>" type="text" value="<?php echo esc_attr($fax); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('fax_label')); ?>"><?php _e('Fax Label: ', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('fax_label')); ?>" name="<?php echo esc_attr($this->get_field_name('fax_label')); ?>" type="text" value="<?php echo esc_attr($fax_label); ?>" />
    </p>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php _e('Email: ', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
    </p>
	<p>
      <label for="<?php echo esc_attr($this->get_field_id('email_label')); ?>"><?php _e('Email label: ', 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email_label')); ?>" name="<?php echo esc_attr($this->get_field_name('email_label')); ?>" type="text" value="<?php echo esc_attr($email_label); ?>" />
    </p>
  <?php
  }
}
?>