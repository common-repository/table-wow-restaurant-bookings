<?php
/*
Plugin Name: Table Wow Restaurant Bookings
Plugin URI:  https://tablewow.com
Description: Adds a button to your website that will open your Table Wow Profile Page where customers can see your Restaurant details and make booking requests.
Version:     1.0
Author:      Table Wow
Author URI:  http://tablewow.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Copyright 2018 Table Wow (support@tablewow.com)

(Table Wow Restaurant Bookings) word press plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
(Table Wow Restaurant Bookings) word press plugin is distributed in the hope that it will be useful when used with a Table Wow account,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with (Table Wow Restaurant Bookings) WordPress plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html).
*/

if (!defined('ABSPATH')) die();

if (!class_exists('TABLEWOW_Table_Wow')) {
	
	class TABLEWOW_Table_Wow {
		
		function __construct() {
			
			$this->constants();
			$this->includes();
			
			add_action('admin_menu',            array($this, 'add_menu'));
			add_filter('admin_init',            array($this, 'add_settings'));
			add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
			add_filter('plugin_action_links',   array($this, 'action_links'), 10, 2);
			add_filter('plugin_row_meta',       array($this, 'plugin_links'), 10, 2);
			add_action('plugins_loaded',        array($this, 'load_i18n'));
			add_action('admin_init',            array($this, 'check_version'));
			add_action('admin_init',            array($this, 'reset_options'));
			add_action('admin_notices',         array($this, 'admin_notices'));
			
		} 
		
		function constants() {
			
			if (!defined('TABLEWOW_VERSION')) define('TABLEWOW_VERSION', '1.0');
			if (!defined('TABLEWOW_REQUIRE')) define('TABLEWOW_REQUIRE', '1.0');
			if (!defined('TABLEWOW_AUTHOR'))  define('TABLEWOW_AUTHOR',  'Table Wow');
			if (!defined('TABLEWOW_NAME'))    define('TABLEWOW_NAME',    __('Table Wow', 'table-wow-restaurant-bookings'));
			if (!defined('TABLEWOW_HOME'))    define('TABLEWOW_HOME',    'https://tablewow.com/table-wow-restaurant-bookings/');
			if (!defined('TABLEWOW_PATH'))    define('TABLEWOW_PATH',    'options-general.php?page=table-wow-restaurant-bookings');
			if (!defined('TABLEWOW_URL'))     define('TABLEWOW_URL',     plugin_dir_url(__FILE__));
			if (!defined('TABLEWOW_DIR'))     define('TABLEWOW_DIR',     plugin_dir_path(__FILE__));
			if (!defined('TABLEWOW_FILE'))    define('TABLEWOW_FILE',    plugin_basename(__FILE__));
			if (!defined('TABLEWOW_SLUG'))    define('TABLEWOW_SLUG',    basename(dirname(__FILE__)));	
		}
		
		function includes() {
			
			require_once TABLEWOW_DIR .'inc/plugin-core.php';
			
		}
		
		function add_menu() {
			
			$title_page = esc_html__('Table Wow Restaurant Bookings', 'table-wow-restaurant-bookings');
			$title_menu = esc_html__('Table Wow',    'table-wow-restaurant-bookings');
			
			add_options_page($title_page, $title_menu, 'manage_options', 'table-wow-restaurant-bookings', array($this, 'display_settings'));
			
		}
		
		function add_settings() {
			register_setting('TABLEWOW_plugin_options', 'TABLEWOW_options', array($this, 'validate_settings'));
			
		}
		
		function admin_scripts($hook) {
			
			if ($hook === 'settings_page_table-wow-restaurant-bookings') {
				
				wp_enqueue_style('table-wow-restaurant-bookings', TABLEWOW_URL .'css/settings.css', array(), TABLEWOW_VERSION);
				wp_enqueue_script('table-wow-restaurant-bookings', TABLEWOW_URL .'js/settings.js', array('jquery'), TABLEWOW_VERSION);
			
				$this->localize_scripts();
				
			}
			
		}
		
		function localize_scripts() {
			
			$script = array(
				'confirm_message' => esc_html__('Are you sure you want to restore all default options?', 'table-wow-restaurant-bookings')
			);
			
			wp_localize_script('table-wow-restaurant-bookings', 'table_wow_restaurant_bookings', $script);
			
		}
		
		function action_links($links, $file) {
			
			if ($file === TABLEWOW_FILE) {
				
				$gap_links = '<a href="'. admin_url(TABLEWOW_PATH) .'">'. esc_html__('Settings', 'table-wow-restaurant-bookings') .'</a>';
				
				array_unshift($links, $gap_links);
				
			}
			
			return $links;
			
		}
		
		function plugin_links($links, $file) {
			
			if ($file === TABLEWOW_FILE) {
				
				$rate_href  = 'https://wordpress.org/support/plugin/'. TABLEWOW_SLUG .'/reviews/?rate=5#new-post';
				$rate_title = esc_attr__('Click here to rate and review this plugin on WordPress.org', 'table-wow-restaurant-bookings');
				$rate_text  = esc_html__('Rate this plugin', 'table-wow-restaurant-bookings') .'&nbsp;&raquo;';
				
				$links[]    = '<a target="_blank" href="'. $rate_href .'" title="'. $rate_title .'">'. $rate_text .'</a>';
				
			}
			
			return $links;
			
		}
		
		function check_version() {
			
			$wp_version = get_bloginfo('version');
			
			if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
				
				if (version_compare($wp_version, TABLEWOW_REQUIRE, '<')) {
					
					if (is_plugin_active(TABLEWOW_FILE)) {
						
						deactivate_plugins(TABLEWOW_FILE);
						
						$msg  = '<strong>'. TABLEWOW_NAME .'</strong> '. esc_html__('requires WordPress ', 'table-wow-restaurant-bookings') . TABLEWOW_REQUIRE;
						$msg .= esc_html__(' or higher, and has been deactivated! ', 'table-wow-restaurant-bookings');
						$msg .= esc_html__('Please return to the', 'table-wow-restaurant-bookings') .' <a href="'. admin_url() .'">';
						$msg .= esc_html__('WP Admin Area', 'table-wow-restaurant-bookings') .'</a> '. esc_html__('to upgrade WordPress and try again.', 'table-wow-restaurant-bookings');
						
						wp_die($msg);
						
					}
					
				}
				
			}
			
		}
		
		function load_i18n() {
			
			$domain = 'table-wow-restaurant-bookings';
			
			$locale = apply_filters('TABLEWOW_locale', get_locale(), $domain);
			
			$dir    = trailingslashit(WP_LANG_DIR);
			
			$file   = $domain .'-'. $locale .'.mo';
			
			$path_1 = $dir . $file;
			
			$path_2 = $dir . $domain .'/'. $file;
			
			$path_3 = $dir .'plugins/'. $file;
			
			$path_4 = $dir .'plugins/'. $domain .'/'. $file;
			
			$paths = array($path_1, $path_2, $path_3, $path_4);
			
			foreach ($paths as $path) {
				
				if ($loaded = load_textdomain($domain, $path)) {
					
					return $loaded;
					
				} else {
					
					return load_plugin_textdomain($domain, false, TABLEWOW_DIR .'languages/');
					
				}
				
			}
			
		}
		
		function admin_notices() {
			
			$screen = get_current_screen();
			
			if (!property_exists($screen, 'id')) return;
			if ($screen->id === 'settings_page_table-wow-restaurant-bookings') {
				
				if (isset($_GET['tw-reset-options'])) {
					
					if ($_GET['tw-reset-options'] === 'true') { ?>
						
						<div class="notice notice-success is-dismissible"><p><strong><?php esc_html_e('Default options restored.', 'table-wow-restaurant-bookings'); ?></strong></p></div>
						
					<?php } else { ?>
						
						<div class="notice notice-info is-dismissible"><p><strong><?php esc_html_e('No changes made to options.', 'table-wow-restaurant-bookings'); ?></strong></p></div>
						
					<?php } ;
					
				}
				
			}
			
		}
		
		function reset_options() {
			
			
			if (isset($_GET['tw-reset-options']) && wp_verify_nonce($_GET['tw-reset-options'], 'TABLEWOW_reset_options')) {
				
				if (!current_user_can('manage_options')) exit;
				
				$update = update_option('TABLEWOW_options', $this->default_options());
				
				$result = $update ? 'true' : 'false';
				
				$location = add_query_arg(array('tw-reset-options' => $result), admin_url(TABLEWOW_PATH));
				
				wp_redirect(esc_url_raw($location));
				
				exit;
				
			}
			
		}

		function __clone() {
			
			_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&rsquo; huh?', 'table-wow-restaurant-bookings'), TABLEWOW_VERSION);
			
		}
		
		function __wakeup() {
			
			_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&rsquo; huh?', 'table-wow-restaurant-bookings'), TABLEWOW_VERSION);
			
		}
		
		function default_options() {
			
			$options = array(
					
				'TABLEWOW_accountname' => '',
				'TABLEWOW_location'    => 'top_right',
				'TABLEWOW_new_window'      => 0,
				'TABLEWOW_default_options' => 0
			);
			
			return apply_filters('TABLEWOW_default_options', $options);
			
		}
		
		function validate_settings($input) {
			$input['TABLEWOW_accountname'] = wp_filter_nohtml_kses($input['TABLEWOW_accountname']);
			
			if (!isset($input['TABLEWOW_location'])) $input['TABLEWOW_location'] = null;
			if (!array_key_exists($input['TABLEWOW_location'], $this->options_locations())) $input['TABLEWOW_location'] = null;
			
			return $input;
			
		}
		
		function options_locations() {
			
			return array(
				
				'top_right' => array(
					'value' => 'top_right',
					'label' => esc_html__('Top Right Hand Side ')
				),
				'top_left' => array(
					'value' => 'top_left',
					'label' => esc_html__('Top Left Hand Side ')
				),
				'bottom_right' => array(
					'value' => 'bottom_right',
					'label' => esc_html__('Bottom Right Hand Side ')
				),
				'bottom_left' => array(
					'value' => 'bottom_left',
					'label' => esc_html__('Bottom Left Hand Side ')
				)
			);
			
		}
			
		function display_settings() {
			
			$TABLEWOW_options = get_option('TABLEWOW_options', $this->default_options());
			
			require_once TABLEWOW_DIR .'inc/settings-display.php';
			
		}
		
		function select_menu($items, $menu,$options) {	
			
			$checked = '';
			
			$output = '';
			
			$class = '';
			$_count=0;
			foreach ($items as $item) {
				
				$key = isset($options[$menu]) ? $options[$menu] : '';
				
				$value = isset($item['value']) ? $item['value'] : '';
				
				$class = ' gap-select-method';
				$checked = ($value == $key) ? ' checked="checked"' : '';
				if (($key=="")&&($_count==0))
				{
					$checked = ' checked="checked"';
				}
				
				$output .= '<div class="gap-radio-inputs'. esc_attr($class) .'">';
				$output .= '<input type="radio" name="TABLEWOW_options['. esc_attr($menu) .']" value="'. esc_attr($item['value']) .'"'. $checked .'> ';
				$output .= '<span>'. $item['label'] .'</span>'; //
				$output .= '</div>';
				$_count++;
			}
			
			return $output;
			
		}
		
		function callback_reset() {
			$nonce = wp_create_nonce('TABLEWOW_reset_options');
			
			$href  = add_query_arg(array('tw-reset-options' => $nonce), admin_url(TABLEWOW_PATH));
			
			$label = esc_html__('Restore default plugin options', 'tw-table-wow');
			
			return '<a class="gap-reset-options" href="'. esc_url($href) .'">'. esc_html($label) .'</a>';
			
		}
		
	}
	
	$TABLEWOW_Table_Wow = new TABLEWOW_Table_Wow(); 
	
	TABLEWOW_table_wow_init($TABLEWOW_Table_Wow);
	
}


?>