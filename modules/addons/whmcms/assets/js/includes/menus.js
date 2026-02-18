$(document).ready(function(){
	
	/* Init Sortable Menu */
	var sortableMenu = $('.sortable');
	
	if (sortableMenu.length > 0){
	    sortableMenu.nestedSortable({
	        handle: '.drag-drop-item',
	        items: 'li',
	        toleranceElement: '> div',
	        listType: 'ol',
	        maxLevels: 4,
	        relocate: function(){
	            var ordering = sortableMenu.nestedSortable('toHierarchy');
	            
	            $.ajax({
	                type: "POST",
	                url: "addonmodules.php?module=whmcms&action=menuitemsordering&ajax=1&_=" + $.now(),
	                data: {items:ordering}
	            });
	        }
	    });
	}
	
    // Toggle Menu Item Status
	$(document).on("click", ".menuitem-actions-togglestatus", function(e){
		
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
            			
            			toggle.prop({title: WHMCMS['menuitem-status-unpublished'], href: whmcmsURL + "&action=enablemenu&menuid=" + toggle.data('menuid') + "&categoryid=" + toggle.data('categoryid')}).data('status', 'unpublished');
            			toggle.find('.fa').removeClass('fa-check color-blue fa-spin fa-refresh').addClass('fa-times color-red');
            			
            			return false;
            			
            		}
            		
            		toggle.prop({title: WHMCMS['menuitem-status-published'], href: whmcmsURL + "&action=disablemenu&menuid=" + toggle.data('menuid') + "&categoryid=" + toggle.data('categoryid')}).data('status', 'published');
            		toggle.find('.fa').removeClass('fa-times color-red fa-spin fa-refresh').addClass('fa-check color-blue');
            		
            		return false;
            		
            	}
            	
            }
        });
		
	});
    
});



function setSelectedIcon(icon, prefix){
	
	var iconInput = $('#css_iconclass');
	
	iconInput.val(prefix + icon);
	
	$('#menuIconModal').modal('hide');
	
}