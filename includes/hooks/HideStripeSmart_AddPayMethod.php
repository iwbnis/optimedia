<?php

add_hook('ClientAreaFooterOutput', 1, function($vars) {
   
	$file = $vars['breadcrumb'][4]['link'];
	
	if(StripeSmart_contains("account/paymentmethods/add", $file))
	{
		
		$html = "<script>
			$(document).ready(function(){
			
			
			var count = $(\"label[for=\'inputPaymentMethodType\']\").next().find(\"*\").length;
			
			if(count <= 4)
			{
				$(\".fieldgroup-remoteinput\").remove();
				$(\".custom-card-block\").remove();
			
			}
			else
			{
					$( \"label:contains('Credit Card')\" ).remove();
			}
			
			});
		</script>";
		
	}
	return $html;
});



function StripeSmart_contains($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}