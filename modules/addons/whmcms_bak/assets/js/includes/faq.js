$(document).ready(function(){
	
	// Toggle FAQ Item Status
	$(document).on("click", ".faq-actions-togglestatus", function(e){
		
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
            			
            			toggle.prop({title: WHMCMS['faq-status-unpublished'], href: whmcmsURL + "&action=enablefaq&faqid=" + toggle.data('faqid')}).data('status', 'unpublished');
            			toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            			
            			return false;
            			
            		}
            		
            		toggle.prop({title: WHMCMS['faq-status-published'], href: whmcmsURL + "&action=disablefaq&faqid=" + toggle.data('faqid')}).data('status', 'published');
            		toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
		
});