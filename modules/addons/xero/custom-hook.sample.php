<?php

namespace EdgeHosting;

use WHMCS\Database\Capsule;
/**
 * Hook point triggered before bulk data is sent to Xero
 *
 * @param string $type The pluralised entity type being sent to Xero (i.e. contacts, invoices, payments)
 * @param array $data An array of entities being sent to Xero
 * @return array You must return the original data array with any modifications
 */
function preXeroSync($type, array $data)
{
    //    # This example shows pulling a customer Xero Network Key from a custom field and adding it to the API data
    //
    //    if ($type == 'contacts') {
    //        foreach ($data as &$contact) {
    //            // Strip the contact number prefix to get the WHMCS contact ID
    //            $contactId = str_replace('WHMCS', '', $contact['ContactNumber']);
    //
    //            // Load the same contact from the WHMCS database and get the custom field value for the field called "Xero Network Key"
    //            $networkKey = Capsule::table('tblclients')
    //                ->leftJoin('tblcustomfieldsvalues', 'tblcustomfieldsvalues.relid', '=', 'tblclients.id')
    //                ->leftJoin('tblcustomfields', 'tblcustomfields.id', '=', 'tblcustomfieldsvalues.fieldid')
    //                ->where('tblclients.id', $contactId)
    //                ->where('tblcustomfields.fieldname', 'Xero Network Key')
    //                ->value('tblcustomfieldsvalues.value');
    //
    //            $contact['XeroNetworkKey'] = $networkKey;
    //        }
    //    }
    //
    return $data;
}
