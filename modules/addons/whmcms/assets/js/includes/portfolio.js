$(document).ready(function(){
	
	// Toggle Category Status
	$(document).on("click", ".category-actions-togglestatus", function(e){
		
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
            			
            			toggle.prop({title: WHMCMS['portfolio-category-unpublished'], href: whmcmsURL + "&action=enablecategory&categoryid=" + toggle.data('categoryid')}).data('status', 'unpublished');
            			toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            			
            			return false;
            			
            		}
            		
            		toggle.prop({title: WHMCMS['portfolio-category-published'], href: whmcmsURL + "&action=disablecategory&categoryid=" + toggle.data('categoryid')}).data('status', 'published');
            		toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
	
	// Toggle Project Status
	$(document).on("click", ".project-actions-togglestatus", function(e){
		
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
            			
            			toggle.prop({title: WHMCMS['portfolio-project-unpublished'], href: whmcmsURL + "&action=enableproject&projectid=" + toggle.data('projectid')}).data('status', 'unpublished');
            			toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            			
            			return false;
            			
            		}
            		
            		toggle.prop({title: WHMCMS['portfolio-project-published'], href: whmcmsURL + "&action=disableproject&projectid=" + toggle.data('projectid')}).data('status', 'published');
            		toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
	
	// Toggle Project Photo Status
	$(document).on("click", ".photo-actions-togglestatus", function(e){
		
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
            			
            			toggle.prop({title: WHMCMS['portfolio-photo-unpublished'], href: whmcmsURL + "&action=enablephoto&photoid=" + toggle.data('photoid') + "&projectid=" + toggle.data('projectid')}).data('status', 'unpublished');
            			toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            			
            			return false;
            			
            		}
            		
            		toggle.prop({title: WHMCMS['portfolio-project-published'], href: whmcmsURL + "&action=disablephoto&photoid=" + toggle.data('photoid') + "&projectid=" + toggle.data('projectid')}).data('status', 'published');
            		toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
		
});