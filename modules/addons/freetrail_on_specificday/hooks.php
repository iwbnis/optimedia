<?php

use Illuminate\Database\Capsule\Manager as Capsule;

add_hook('ClientAreaPageCart', 0, function ($vars) {
    if ($vars['templatefile'] == 'products') {
        $savedDataForSpecificTime = array();
        $savedProductsIds = array();
        $SavedData = Capsule::table('table_weakDays')->get();
        foreach ($SavedData as $value) {
            $savedDataForSpecificTime[$value->pid] = unserialize($value->time_data);
            $savedProductsIds[] = $value->pid;
        }
        $date = date('Y-m-d');
        $unixTimestamp = strtotime($date);
        $dayOfWeek = date("l", $unixTimestamp);
        $Weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        $allproducts = array();
        $FinalproductsToShow = array();
        foreach ($vars['products'] as $value) {
            if (isset($value['pid']) && !empty($value['pid'])) {
                $allproducts[] = $value['pid'];
            }
        }
        $comparisonArrayIndexes = array();
        $ProductsForSpecificTime = array_intersect($savedProductsIds, $allproducts);
        $DiffProducts = array_diff($allproducts, $savedProductsIds);
        if (!empty($DiffProducts)) {
            foreach ($DiffProducts as $val) {
                $FinalproductsToShow[] = $val;
            }
        }
        foreach ($ProductsForSpecificTime as $productId) {
            foreach ($Weekdays as $index => $day) {
                if ($day == $savedDataForSpecificTime[$productId]['starting_date']) {
                    $comparisonArrayIndexes[$productId]['startover'] = $index;
                }
                if ($day == $savedDataForSpecificTime[$productId]['closing_date']) {
                    $comparisonArrayIndexes[$productId]['endover'] = $index;
                }
            }
        }
        $finalArrayToshowProducts = array();
        foreach ($comparisonArrayIndexes as $productId => $value) {
            if ($value['startover'] == $value['endover']) {
                $finalArrayToshowProducts[$productId][] = $Weekdays[$value['startover']];
            } else {
                if ($value['startover'] < $value['endover']) {
                    for ($x = $value['startover']; $x <= $value['endover']; $x++) {
                        $finalArrayToshowProducts[$productId][] = $Weekdays[$x];
                    }
                } else {
                    foreach ($Weekdays as $key => $val) {
                        if ($value['startover'] <= $key) {
                            $finalArrayToshowProducts[$productId][] = $val;
                        }
                    }
                    foreach ($Weekdays as $key => $val) {
                        if ($key <= $value['endover']) {
                            $finalArrayToshowProducts[$productId][] = $val;
                        }
                    }
                }
            }
        }
        $FinalDaysToShowProducts = array();
        if (!empty($finalArrayToshowProducts)) {
            foreach ($finalArrayToshowProducts as $productId => $values) {
                $FinalDaysToShowProducts[$productId] = array_unique($values);
            }
        }
//
//        print_R($FinalDaysToShowProducts);
//        exit;

        $now_time = date("H:i");
        foreach ($FinalDaysToShowProducts as $productId => $value) {
            if (current($value) == end($value)) {
                if (in_array("$dayOfWeek", $value)) {
                    if ($savedDataForSpecificTime[$productId]['starting_time'] <= $now_time && $savedDataForSpecificTime[$productId]['closing_time'] >= $now_time) {
                        $FinalproductsToShow[] = $productId;
                    }
                }
            } else {
                if ($value[0] == $dayOfWeek) {
                    //starting time condition
                    if ($savedDataForSpecificTime[$productId]['starting_time'] <= $now_time) {
                        $FinalproductsToShow[] = $productId;
                    }
                } else if (end($value) == $dayOfWeek) {
                    //closing time condition
                    if ($savedDataForSpecificTime[$productId]['closing_time'] >= $now_time) {
                        $FinalproductsToShow[] = $productId;
                    }
                } else {
                    if (in_array("$dayOfWeek", $value)) {
                        $FinalproductsToShow[] = $productId;
                    }
                }
            }
        }

        $result = array_diff($allproducts, $FinalproductsToShow);
        foreach ($result as $key => $product_id) {
            unset($vars['products'][$key]);
        }
        return $vars;
    }
});
