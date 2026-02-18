<?php

use WHMCS\Database\Capsule;
use Carbon\Carbon;

require_once __DIR__ . '/../../../init.php';

$existingField = Capsule::table('tblhosting')
    ->whereNotNull('dedicatedip')
    ->where('domainstatus', 'Active')
    ->get();

$dedicatedIPs = $existingField->pluck('dedicatedip')->filter()->toArray();

foreach ($dedicatedIPs as $dedicatedIP) { 
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_line&id=' . $dedicatedIP);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    if ($result === false) {
        echo 'cURL request failed';
    } else {
        $dataArray = json_decode($result, true);

        if ($dataArray['status'] === 'STATUS_SUCCESS') {
            $expiredDate = $dataArray['data']['expired_date'];
            $username = $dataArray['data']['username'];

            $date = new DateTime($expiredDate);
            
            $formattedDate = $date->format('Y/m/d');

            $now = Carbon::now()->format('Y-m-d H:i:s');

            $existingField = Capsule::table('tblhosting')
                ->where('dedicatedip', $dedicatedIP)
                ->where('username', $username)
                ->first();

            if ($existingField) {
                $packageId = $existingField->packageid;
                $userId = $existingField->id;

                $fieldsIds = Capsule::table('tblcustomfields')
                    ->where('relid', $packageId)
                    ->where('fieldname', 'XUI Next Due Date')
                    ->pluck('id');

                $fieldsId = $fieldsIds->toArray();

                $updatedata = Capsule::table('tblcustomfieldsvalues')
                    ->where('relid', $userId)
                    ->where('fieldid', $fieldsId[0])
                    ->count();

                if ($updatedata > 0) {
                    Capsule::table('tblcustomfieldsvalues')
                        ->where('relid', $userId)
                        ->where('fieldid', $fieldsId[0])
                        ->update([
                            'value' => $formattedDate,
                            'updated_at' => $now,
                        ]);
                } else {
                    Capsule::table('tblcustomfieldsvalues')->insert([
                        'relid' => $userId,
                        'fieldid' => $fieldsId[0],
                        'value' => $formattedDate,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    curl_close($ch);
}
