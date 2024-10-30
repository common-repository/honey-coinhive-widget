jQuery(document).ready(function(){	
    if(jQuery('.chw_threads').val() == ''){
			jQuery('.chw_threads').val('2');
			jQuery('.displaythreadsdiv').hide();
			jQuery('.chw_autoThreads').prop( "checked", true );
			jQuery('.chw_displayMineStat').prop( "checked", true );
			jQuery('.chw_displayBootstrapButton').prop( "checked", true );
	};
	if(jQuery('.chw_speed').val() == ''){
			jQuery('.chw_speed').val('90');
	};
	
	jQuery('.graphsets').click(function() {
	    jQuery(".displaygraphdiv").toggle(this.checked);
		jQuery(".displaygraphs").prop( "checked", true );
	});
	
	jQuery('.chw_autoThreads').click(function() {
		if (this.checked == true){
	    	jQuery(".displaythreadsdiv").toggle(false);
		}
		if (this.checked == false){
	    	jQuery(".displaythreadsdiv").toggle(true);
		}
	});

	if(jQuery('#coinhiveWidget_site_key').val()!=""&&jQuery('#coinhiveWidget_secret_key').val()!=""){
		jQuery('.chw_continue_notice').show();
	};
});

jQuery(document).on('widget-updated', function(e, widget){
	if(jQuery('.chw_threads').val() == ''){
			jQuery('.chw_threads').val('2');
			jQuery('.displaythreadsdiv').hide();
			jQuery('.chw_autoThreads').prop( "checked", true );
			jQuery('.chw_displayMineStat').prop( "checked", true );
			jQuery('.chw_displayBootstrapButton').prop( "checked", true );
			jQuery('.chw_speed').val('90');
	}
	jQuery('.graphsets').click(function() {
	    jQuery(".displaygraphdiv").toggle(this.checked);
		jQuery(".displaygraphs").prop( "checked", true );
	});
	jQuery('.displaythreadsdiv').hide();
	jQuery('.chw_autoThreads').click(function() {
		if (this.checked == true){
	    	jQuery(".displaythreadsdiv").toggle(false);
		}
		if (this.checked == false){
	    	jQuery(".displaythreadsdiv").toggle(true);
		}
	});

	if(jQuery('#coinhiveWidget_site_key').val()!=""&&jQuery('#coinhiveWidget_secret_key').val()!=""){
		jQuery('.chw_continue_notice').show();
	};
});

jQuery(document).on('widget-added', function(e, widget){
			jQuery('.chw_threads').val('2');
			jQuery('.displaythreadsdiv').hide();
			jQuery('.chw_autoThreads').prop( "checked", true );
			jQuery('.chw_displayMineStat').prop( "checked", true );
			jQuery('.chw_displayBootstrapButton').prop( "checked", true );
			jQuery('.chw_speed').val('90');

	jQuery('.graphsets').click(function() {
	    jQuery(".displaygraphdiv").toggle(this.checked);
		jQuery(".displaygraphs").prop( "checked", true );
	});
	
	jQuery('.chw_autoThreads').click(function() {
		if (this.checked == true){
	    	jQuery(".displaythreadsdiv").toggle(false);
		}
		if (this.checked == false){
	    	jQuery(".displaythreadsdiv").toggle(true);
		}
	});

	if(jQuery('#coinhiveWidget_site_key').val()!=""&&jQuery('#coinhiveWidget_secret_key').val()!=""){
		jQuery('.chw_continue_notice').show();
	};
});
