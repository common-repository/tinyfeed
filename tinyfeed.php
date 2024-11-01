<?phP
/*
Plugin Name: TinyFeed
Plugin URI: http://jpiche.com/tinyfeed/
Description: TinyFeed is a Wordpress widget which loads a microblog status feed via Ajax.
Version: 2.0.1
Author: Joseph Piché
Author URI: http://jpiche.com/

Copyright 2010 Joseph Piché (email : j@jpiche.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class TinyFeed_Widget extends WP_Widget {

    public static $script_loaded;

    public function TinyFeed_Widget() {
        add_action('wp_footer', array(__CLASS__, 'add_script'));

        $widget_opts = array('description' => __('Loads Microblog entries via Ajax') );
        parent::WP_Widget('tinyfeed', __('TinyFeed'), $widget_opts);
    }

    public static function init() {
        add_action('widgets_init', create_function('','return register_widget(\'TinyFeed_Widget\');'));
        wp_register_style('tinyfeed-style', plugins_url('tinyfeed.css', __FILE__));
        wp_enqueue_style('tinyfeed-style');
    }

    public static function add_script() {
        if ( self::$script_loaded ) {
            return;
        }

        wp_register_script('tinyfeed-script', plugins_url('tinyfeed.js', __FILE__), array('jquery'), false, true);
        wp_print_scripts('tinyfeed-script');

        self::$script_loaded = true;
	}

    public function widget($args, $inst) {
        extract($args);

        if (!empty($inst['error'])
            || empty($inst['user'])
            || !in_array($inst['service'], array('twitter', 'identi.ca'))
        ) {
            return;
        }

        if (empty($inst['title'])) {
            if ($inst['service'] == 'identi.ca') {
                $inst['title'] = 'Identi.ca Feed';
            } elseif ($inst['service']=='twitter') {
                $inst['title'] = 'Twitter Feed';
            }
        } else {
             $inst['title'] = apply_filters('widget_title', $inst['title']);
        }

        if ($inst['service'] == 'identi.ca') {
            $url = 'http://identi.ca/api/statuses/user_timeline.json';
        } else {
            $url = 'http://api.twitter.com/1/statuses/user_timeline.json';
        }

        echo $before_widget;
        echo $before_title . $inst['title'] . $after_title;
        echo '<ul id="tinyfeed-data-' . $this->number . '" class="tinyfeed-data" data-service="' . esc_attr($inst['service']). '" data-url="' . esc_attr($url). '" data-user="' . esc_attr($inst['user']). '" data-count="' . esc_attr($inst['count']). '"></ul>';
        echo '<p id="tinyfeed-credits-' . $this->number . '" class="tinyfeed-credits"><small>I use <a href="http://jpiche.com/tinyfeed/">TinyFeed</a></small></p>';
        echo $after_widget;
    }

    /** @see WP_Widget::update */
    public function update($new_instance, $old_instance) {             
        return $new_instance;
    }

    public function form($inst) {
?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <i>(optional)</i></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($inst['title']); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('user'); ?>"><?php _e('Microblog Username or User ID:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" type="text" value="<?php echo esc_attr($inst['user']); ?>" /></p>

        <p><label for="<?php echo $this->get_field_name('service'); ?>"><?php _e('Microblog service:'); ?></label><br/>
        <input name="<?php echo $this->get_field_name('service'); ?>" type="radio" value="twitter" <?php if($inst['service']!='identi.ca') echo 'checked="checked"';?>/> Twitter<br/>
        <input name="<?php echo $this->get_field_name('service'); ?>" type="radio" value="identi.ca" <?php if($inst['service']=='identi.ca') echo 'checked="checked"';?>/> Identi.ca</p>

        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of entries to show'); ?></label>
        <select id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>">
        <?php
          for($i = 1; $i <= 10; $i++) {
            echo '<option ';
        echo ($inst['count']==$i) ? ' selected="selected"' : '';
        echo '>'.$i.'</option>';
      }
    ?>
    </select></p>
<?php
    }
}
TinyFeed_Widget::init();

