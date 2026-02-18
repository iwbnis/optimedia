$.ajaxSetup({
	beforeSend: function(){
    	$("body").addClass('whmcms-ajax-loading');
    },
    complete: function(){
    	$("body").removeClass('whmcms-ajax-loading');
    }
});

$(document).ready(function(){
    $(".tabbox").css("display","none");
        var selectedTab;
        $(".tab").click(function(){
            var elid = $(this).attr("id");
            $(".tab").removeClass("tabselected");
            $("#"+elid).addClass("tabselected");
            $(".tabbox").slideUp();
            if (elid != selectedTab) {
                selectedTab = elid;
                $("#"+elid+"box").slideDown();
            } else {
                selectedTab = null;
                $(".tab").removeClass("tabselected");
            }
            $("#tab").val(elid.substr(3));
        });
});


$(function() {
    $(".validform").validationEngine();
    // ToolTips
    //$('#whmcms a[title!=""]').tooltip();
    //$('[data-toggle="tooltip"]').tooltip();
    // Tabs
    $('#tabOptions a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    // Accordion
    $('#translation').collapse({
        toggle: false
    });
});


/*
*  Confirmation Functions
*/
$(function(){
    $("#type").change(function(){
        if($(this).val()=="page"){
            $("#url, #internal, #support").hide();
            $("#pagelist").show();
        }
        else if($(this).val()=="url"){
            $("#pagelist, #internal, #support").hide();
            $("#url").show();
        }
        else if($(this).val()=="support"){
            $("#pagelist, #internal, #url").hide();
            $("#support").show();
        }
        else if($(this).val()=="internal"){
            $("#pagelist, #url, #support").hide();
            $("#internal").show();
        }
    });
});


/*
* Multi-Checkbox Actions
*/
$(function(){
    $('#bulkcheckbox').change(function(){
        if($(this).is(':checked')){
            $('.bulkcheckbox').attr('checked','checked');
        }
        else{
            $('.bulkcheckbox').removeAttr('checked');
        }
    });
    $('.bulkform').on("submit", function(){
        var $fields = $('.bulkform').find('input[class="bulkcheckbox"]:checked');
        if(!$fields.length){
            alert('You must at least check one box to continue.');
            return false;
        }
    });
});

/*
* Alias Ajax
*/
var generateAlias = debounce(function(source){
	

	var relType = source.data('reltype');
	var relId = source.data('relid');
    var aliasInput = $('#seo-url-input_' + relId);
    
	if (aliasInput.hasClass("manual")){
		return;
	}
    
    if (source.val().length > 2) {
        
    	var ajaxSignature = $.now();
    	
        $.ajax({
            type: "POST",
        	url: "addonmodules.php?module=whmcms&action=generatealias&ajax=1&_=" + $.now(),
            data: {string: source.val(), reltype: relType, relid: relId},
            success: function(response){
            	
            	if (typeof response.alias === "string" && aliasInput.hasClass("manual") === false && aliasInput.data('ajaxsignature') === ajaxSignature){
            		
            		aliasInput.val(response.alias);
            		
            	}
            	
            },
            beforeSend: function(){
            	aliasInput.data('ajaxsignature', ajaxSignature);
            	$("#seo-url-actions-lock_" + relId).addClass('hidden');
                $("#seo-url-actions-loading_" + relId).removeClass('hidden');
            },
            complete: function(){
            	if (aliasInput.data('ajaxsignature') === ajaxSignature){
	            	$("#seo-url-actions-loading_" + relId).addClass('hidden');
	            	
	            	if (aliasInput.hasClass('locked') === true){
	            		$("#seo-url-actions-lock_" + relId).removeClass('hidden');
	            	}
            	}
            }
        });
        
    }
    
}, 250);

var validateAlias = debounce(function(source){
    
	var relType = source.data('reltype');
	var relId = source.data('relid');
    var aliasInput = $('#seo-url-input_' + relId);
	
    if (aliasInput.val().length > 2) {
        
    	var ajaxSignature = $.now();
    	
        $.ajax({
            type: "POST",
        	url: "addonmodules.php?module=whmcms&action=generatealias&ajax=1&_=" + $.now(),
            data: {string: aliasInput.val(), reltype: relType, relid: relId},
            success: function(response){
                
            	if (typeof response.alias === "string" && aliasInput.data('ajaxsignature') === ajaxSignature){
            		
            		aliasInput.val(response.alias);
            		
            	}
            	
            },
            beforeSend: function(){
            	aliasInput.data('ajaxsignature', ajaxSignature);
                $("#seo-url-actions-loading_" + relId).removeClass('hidden');
            },
            complete: function(){
            	if (aliasInput.data('ajaxsignature') === ajaxSignature){
            		$("#seo-url-actions-loading_" + relId).addClass('hidden');
            	}
            }
        });
        
    }
    
}, 1000);


$(document).ready(function(){    
    
	//$(document).on("input", ".generateAlias", generateAlias);
	//$(document).bindWithDelay("input", ".generateAlias", generateAlias, 200, true);
    
    $(document).on("click", ".seo-url-actions-lock", function(e){
    	e.preventDefault();
    	
    	$(this).addClass('hidden');
    	
    	$('#seo-url-input_' + $(this).data('relid')).prop({readonly: false}).focus().addClass("manual").removeClass("locked");
    	
    	$('#seo-url-prefix_' + $(this).data('relid')).addClass('bg-white');
    });

    $(document).on("input", ".generateAlias", function(){
    	generateAlias($(this));
    });
    $(document).on("input", ".seo-url-input", function(){
    	validateAlias($(this));
    });
    
});

/*
$(function(){
    $(".generateAlias").keyup(function () {
        var titlevalue = $(this).val();
        var titlelength = $(this).val().length;
        var aliasInput = $(this).attr('data-alias');
        if (titlelength>2) {
            $("#aliasLoading").show('fade');
            $.post("../modules/addons/whmcms/assets/ajax/pagealias.php", { value: titlevalue },
                function(data){
                    if (aliasInput=='' || aliasInput===false){aliasInput = '#alias';}
                    $(aliasInput).val(data);
                    $("#aliasLoading").hide('fade');
                }
            );
        }
    });
});
*/



/*
* Menu Options
*/
$(function(){
    $('.changemenutype').change(function(){
        $("#aliasLoading").show('fade');
        var selectedType = $(this).val();
        $('.menuTypeShow').slideUp();
        $('.menuTypeShow').addClass('menuTypeHide');
        $('.menuTypeShow').removeClass('menuTypeShow');
        $('#type_' + selectedType).slideDown();
        $('#type_' + selectedType).addClass('menuTypeShow');
        $("#aliasLoading").hide('fade');
    });
});

/*
* Settings Section
*/
$(function(){
    $('.radioImg').click(function(){
        $('.radioImg').removeClass('active');
        $(this).addClass('active');
    });
});

/*
* Date & Time Picker
*/
$(function(){$('.datepicker').datepicker({dateFormat:'yy-mm-dd'});});

// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}



function generateAliasDelay(input, callback, delay) {
    var timer = null;
    input.onkeypress = function() {
        if (timer) {
            window.clearTimeout(timer);
        }
        timer = window.setTimeout( function() {
            timer = null;
            callback();
        }, delay );
    };
    input = null;
}

var generateAliasInputs = document.getElementsByClassName("generateAlias");

//generateAliasDelay( generateAliasInputs[0], generateAlias, 1000 );
//generateAliasDelay( document.getElementById("seo-url-input"), validateAlias, 1000 );

