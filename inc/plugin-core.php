<?php 

if (!function_exists('add_action')) die();

function TABLEWOW_table_wow_init($TABLEWOW_Table_Wow) {
	
	$options = get_option('TABLEWOW_options', $TABLEWOW_Table_Wow->default_options());
	
	$location = isset($options['TABLEWOW_location']) ? $options['TABLEWOW_location'] : 'top_right';
	
	$admin = isset($options['admin_area']) ? $options['admin_area'] : 0;
	
	$function = 'TABLEWOW_table_wow_account_name';
	
	add_action('wp_footer', $function);
	
}

function TABLEWOW_table_wow_account_name() {
	
	extract(TABLEWOW_table_wow_options());
	
	if (empty($accountname)) return;
	
	if (empty($location)) return;
		
	TABLEWOW_table_wow_script($options);
		
}

function TABLEWOW_table_wow_script() {
	
	extract(TABLEWOW_table_wow_options());
	
	?>
<style>
.buttonbase
{
	line-height: 12px;
    position:fixed;
	z-index:99999;
	box-shadow: 4px 8px 12px 0px rgba(0,0,0,0.18);
}
.top_right
{
     top:20px;
     right:20px;
}
.top_left
{
     top:20px;
     left:20px;
}
.bottom_right
{
     bottom:20px;;
     right:20px;;
}
.bottom_left
{
     bottom:20px;
     left:20px;
}
</style>
<script type="text/javascript"
 src="https://apps.tablewow.com/booking/clientjs/table_wow_widget1.js"
 id="bookingwidget" 
 btn-class="buttonbase <?php echo $options['TABLEWOW_location']?>"
 new-window="<?php if (isset($options['TABLEWOW_new_window'])&& $options['TABLEWOW_new_window']=="1"){echo 'true';} else {echo 'false';}; ?>" 
 account="<?php echo $options['TABLEWOW_accountname'] ?>">
</script>
	<?php
}

function TABLEWOW_table_wow_options() {
	
	global $TABLEWOW_Table_Wow;
	
	$options = get_option('TABLEWOW_options', $TABLEWOW_Table_Wow->default_options());
	
	$accountname = (isset($options['TABLEWOW_accountname']) && !empty($options['TABLEWOW_accountname'])) ? $options['TABLEWOW_accountname'] : '';
	
	$location        = isset($options['TABLEWOW_location'])    ? $options['TABLEWOW_location']    : 'top_right';
		
	$new_window     = isset($options['TABLEWOW_new_window']) ? $options['TABLEWOW_new_window'] : 0;
		
	return array(
		'options'         => $options,
		'accountname'     => $accountname,
		'location'        => $location,
		'new_window' => $new_window
	);
	
}
