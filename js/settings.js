/* Table wow based on GA Google Analytics wordpress plugin */

jQuery(document).ready(function($) {
		
	$('h2').click(function() { $(this).next().slideToggle(300); });
	
	$('.gap-toggle-all a').click(function(e) { e.preventDefault(); $('.toggle').slideToggle(300); });
	
	$('.gap-toggle').click(function(e) { e.preventDefault(); $('.toggle').slideUp(300); $('#gap-panel-'+ $(this).data('target') +' .toggle').slideDown(300); });
	
	$('.gap-reset-options').click(function() { return confirm(table_wow_restaurant_bookings.confirm_message); });
	
	
});