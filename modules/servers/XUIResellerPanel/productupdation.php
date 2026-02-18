<?php

use WHMCS\Database\Capsule;
use Carbon\Carbon;

require_once __DIR__ . '/../../../init.php';

$moduledetails = Capsule::table('tbladdonmodules')
                ->where('module', '=', 'XuiResellerDashboard')
                ->get();
              
if($moduledetails){
    
    $tblproducts = Capsule::table('tblproducts')
    ->where("servertype", 'XUIResellerPanel')
    ->select("id")
    ->distinct()
    ->get();
        
    foreach ($tblproducts as $item) {
        $gid = $item->id;
        $existingField = Capsule::table('tblcustomfields')
            ->where('fieldname', 'Select account')
            ->where('relid', $gid)
            ->value('id');
                
            if (!$existingField) {
                $insertQuery = "
                    INSERT INTO `tblcustomfields`
                        (`type`, `relid`, `fieldname`, `fieldtype`, `description`, `fieldoptions`, `regexpr`, `adminonly`, `required`, `showorder`, `showinvoice`, `sortorder`)
                    VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ";
            
                $values = [
                    'product', // type
                    $gid, // relid 
                    'Select account', // fieldname (example value)
                    'dropdown', // fieldtype
                    '', // description
                    'Yes,No', // fieldoptions
                    '', // regexpr
                    '', // adminonly
                    'on', // required
                    'on', // showorder
                    '', // showinvoice
                    '0' // sortorder 
                ];
            
                try {
                    Capsule::insert($insertQuery, $values);
                } catch (Exception $e) {
                    $result[] = 'error';
                }
            }
        
        
    }
}
?>