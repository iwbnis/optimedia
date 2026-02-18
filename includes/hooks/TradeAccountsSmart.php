<?php
use WHMCS\Database\Capsule;

add_hook('AdminAreaFooterOutput', 1, function($vars) {
    
     $filename = $vars['filename'];
    
     $invoiceId = $_GET['id'];
    
    if ($filename == 'invoices' && isset($invoiceId)) {

    
       $record = Capsule::table('gateway_TradeAccountsSmart')
        ->where('invoiceid', $invoiceId)
        ->where('refund_status', "PENDING")
        ->first();

        if($record)
        {
            $echo = '<div class="alert alert-warning" role="alert">A refund request for this invoice is already in queue. You cannot make another refund request unless its completed</div>';
            
            $js = '$("#tab5").remove();';
            $js = '$("#tabLink5").remove();';
            
            $css = '#tab5{ display:none; }';
            
        }
        
    }
        
            return <<<HTML
<script type="text/javascript">
        $(document).ready(function(){ 
        
        $("#contentarea div:first").prepend('$echo');
        $js
        
        }); 
</script>
<style>

$css
</style>
HTML;
        


});