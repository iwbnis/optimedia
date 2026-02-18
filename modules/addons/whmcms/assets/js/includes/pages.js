$(document).ready(function(){
	
	// Toggle Page Status
	$(document).on("click", ".pages-actions-togglestatus", function(e){
		
		e.preventDefault();
		
		var toggle = $(this); 
		
		toggle.find('.fa').removeClass('fa-check color-blue fa-times color-red').addClass('fa-spin fa-refresh');
		
		$.ajax({
            type: "POST",
        	url: toggle.prop('href') + "&ajax=1&_=" + $.now(),
            data: {},
            success: function(response){
            	
            	if (typeof response.result === "string" && response.result === "success"){
            		
            		if (toggle.data('status') === "published"){
            			
            			toggle.prop({title: WHMCMS['pages-status-unpublished'], href: whmcmsURL + "&action=enablepage&pageid=" + toggle.data('pageid')}).data('status', 'unpublished');
            			toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            			
            			return false;
            			
            		}
            		
            		toggle.prop({title: WHMCMS['pages-status-published'], href: whmcmsURL + "&action=disablepage&pageid=" + toggle.data('pageid')}).data('status', 'published');
            		toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
	
	// Toggle Page Accessibility
	$(document).on("click", ".pages-actions-toggleaccess", function(e){
		
		e.preventDefault();
		
		var toggle = $(this); 
		
		toggle.find('.fa').removeClass('fa-check color-blue fa-times color-red').addClass('fa-spin fa-refresh');
		
		$.ajax({
            type: "POST",
        	url: toggle.prop('href') + "&ajax=1&_=" + $.now(),
            data: {},
            success: function(response){
            	
            	if (typeof response.result === "string" && response.result === "success"){
            		
            		if (toggle.data('status') === "public"){
            			
            			toggle.prop({title: WHMCMS['pages-access-makepublic'], href: whmcmsURL + "&action=privatepage&e=f&status=0&pageid=" + toggle.data('pageid')});
            			toggle.data('status', "private");
            			toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            			
            			return false;
            			
            		}
            			
            		toggle.prop({title: WHMCMS['pages-access-makeprivate'], href: whmcmsURL + "&action=privatepage&e=f&status=1&pageid=" + toggle.data('pageid')});
            		toggle.data('status', "public");
            		toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
	
});