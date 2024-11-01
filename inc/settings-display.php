<?php // Table Wow - Settings Display

if (!function_exists('add_action')) die(); ?>

<div class="wrap">
	
	<h1><?php echo TABLEWOW_NAME; ?> <small><?php echo 'v'. TABLEWOW_VERSION; ?></small></h1>
	
	<div class="gap-toggle-all"><a href="<?php echo admin_url(TABLEWOW_PATH); ?>"><?php esc_html_e('Toggle all panels', 'table-wow-restaurant-bookings'); ?></a></div>
	
	<form method="post" action="options.php">
		
		<?php settings_fields('TABLEWOW_plugin_options'); ?>
		
		<div class="metabox-holder">
			
			<div class="meta-box-sortables ui-sortable">
				
				<div id="gap-panel-overview" class="postbox">
					
					<h2><?php esc_html_e('Overview', 'table-wow-restaurant-bookings'); ?></h2>
					
					<div class="toggle<?php if (isset($_GET['settings-updated'])) echo ' default-hidden'; ?>">
						
						<div class="gap-panel-overview">
							
							<p><?php esc_html_e('This plugin adds in a button to your website that opens your Table Wow Profile Page. This allows customers to make booking requests.', 'table-wow-restaurant-bookings'); ?></p>
							
							<ul>
								<li><a class="gap-toggle" data-target="usage" href="#gap-panel-usage"><?php esc_html_e('How to Use', 'table-wow-restaurant-bookings'); ?></a></li>
								<li><a class="gap-toggle" data-target="settings" href="#gap-panel-settings"><?php esc_html_e('Plugin Settings', 'table-wow-restaurant-bookings'); ?></a></li>
								<li><a target="_blank" href="https://wordpress.org/support/plugin/table-wow-restaurant-bookings"><?php esc_html_e('Plugin Homepage', 'table-wow-restaurant-bookings'); ?></a></li>
							</ul>
							
							<p>
								<?php esc_html_e('If you like this plugin, please', 'table-wow-restaurant-bookings'); ?> 
								<a target="_blank" href="https://wordpress.org/support/plugin/table-wow-restaurant-bookings/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'table-wow-restaurant-bookings'); ?>">
									<?php esc_html_e('give it a 5-star rating', 'table-wow-restaurant-bookings'); ?>&nbsp;&raquo;
								</a>
							</p>
							
						</div>
						
					</div>
					
				</div>
				
				<div id="gap-panel-usage" class="postbox">
					
					<h2><?php esc_html_e('How to use this plugin', 'table-wow-restaurant-bookings'); ?></h2>
					
					<div class="toggle">
						
						<div class="gap-panel-usage">
							
							<ol>
								<li><?php esc_html_e('Visit the "Plugin Settings" panel below', 'table-wow-restaurant-bookings'); ?></li>
								<li><?php esc_html_e('Enter your Table Wow Account ID. If you don\'t have one you can request a 30 day trial at ', 'table-wow-restaurant-bookings'); ?><a href="https://tablewow.com?from=wpplugin">https://tablewow.com</a></li>
								<li>
									<?php esc_html_e('Choose to have your Table Wow Profile Page open in a new window (the default is the same window)', 'table-wow-restaurant-bookings'); ?>  
								</li>
								<li><?php esc_html_e('Configure where you want the button to appear', 'table-wow-restaurant-bookings'); ?></li>
							</ol>
						
							<div class="gap-caption">
						Don't forget to promote your online booking request facility to your customer base via social media. 
						You can also add a "Book Now" button to Facebook and link to your profile on Twitter and Instagram. 
							</div>
							
						</div>
						
					</div>
					
				</div>
				
				<div id="gap-panel-settings" class="postbox">
					
					<h2><?php esc_html_e('Plugin Settings', 'table-wow-restaurant-bookings'); ?></h2>
					
					<div class="toggle">
						
						<div class="gap-panel-settings">
							
							<table class="widefat">
								<tr>
									<th><label for="TABLEWOW_options[TABLEWOW_accountname]"><?php esc_html_e('Account Name', 'table-wow-restaurant-bookings') ?></label></th>
									<td><input id="TABLEWOW_options[TABLEWOW_accountname]" name="TABLEWOW_options[TABLEWOW_accountname]" type="text" size="50" maxlength="100" value="<?php if (isset($TABLEWOW_options['TABLEWOW_accountname'])) echo esc_attr($TABLEWOW_options['TABLEWOW_accountname']); ?>"></td>
								</tr>
							</table>
							
							<div class="gap-info-universal">
								
								<table class="widefat">
									<tr>
										<th><label for="TABLEWOW_options[TABLEWOW_new_window]">
										<?php esc_html_e('New window', 'table-wow-restaurant-bookings') ?></label></th>
										<td>
											<input id="TABLEWOW_options[TABLEWOW_new_window]" name="TABLEWOW_options[TABLEWOW_new_window]" type="checkbox" value="1" <?php if (isset($TABLEWOW_options['TABLEWOW_new_window'])) checked('1', $TABLEWOW_options['TABLEWOW_new_window']); ?>> 
											<?php esc_html_e('Opens your Table wow Profile page in a new window', 'table-wow-restaurant-bookings'); ?> 
										</td>
									</tr>
								</table>
								
							</div>
							
							<table class="widefat">
								<tr>
									<th><label for="TABLEWOW_options[TABLEWOW_location]"><?php esc_html_e('Button Location', 'table-wow-restaurant-bookings'); ?></label></th>
									<td>
										<?php echo $this->select_menu($this->options_locations(), 'TABLEWOW_location',$TABLEWOW_options); ?>
										<div class="gap-caption">
											<?php esc_html_e('Tip: Test out which location works best on your website.', 'table-wow-restaurant-bookings'); ?> 
										</div>
									</td>
								</tr>
							</table>
							
						</div>
						
						<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'table-wow-restaurant-bookings'); ?>" />
						
					</div>
					
				</div>
				
				<div id="gap-panel-restore" class="postbox">
					
					<h2><?php esc_html_e('Restore Defaults', 'table-wow-restaurant-bookings'); ?></h2>
					
					<div class="toggle default-hidden">
						
						<p><?php esc_html_e('Click the link to restore the default plugin options.', 'table-wow-restaurant-bookings'); ?></p>
						
						<p><?php echo $this->callback_reset(); ?></p>
						
					</div>
					
				</div>
							
			</div>
			
		</div>
		
		<div class="gap-credit-info">
			
			<a target="_blank" href="<?php echo esc_url(TABLEWOW_HOME); ?>" title="<?php esc_attr_e('Plugin Homepage', 'table-wow-restaurant-bookings'); ?>"><?php echo TABLEWOW_NAME; ?> WordPress Plugin</a> 
			<?php esc_attr_e('by', 'table-wow-restaurant-bookings'); ?> <?php echo TABLEWOW_NAME; ?>
			
		</div>
		
	</form>
	
</div>