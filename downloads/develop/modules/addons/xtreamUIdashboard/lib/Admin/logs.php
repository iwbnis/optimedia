<?php
/**
*
* @ This file is created by http://DeZender.Net
* @ deZender (PHP7 Decoder for ionCube Encoder)
*
* @ Version			:	4.0.10.0
* @ Author			:	DeZender
* @ Release on		:	09.04.2020
* @ Official site	:	http://DeZender.Net
*
*/

function xtreamdashboard_getModulelogs($module)
{
	$limitnum = 10;

	if (isset($_REQUEST['pageno'])) {
		$nextPage = $_REQUEST['pageno'] + 1;
		$currentPage = $_REQUEST['pageno'];
		$previousPage = $_REQUEST['pageno'] - 1;

		if ($_REQUEST['pageno'] != 1) {
			$limitstart = ($_REQUEST['pageno'] * $limitnum) - $limitnum;
		}
		else {
			$limitstart = 0;
		}
	}
	else {
		$currentPage = 1;
		$nextPage = 2;
		$limitstart = 0;
	}

	$gettotal_record_query = select_query('tblmodulelog', '', ['module' => (string) $module]);
	$totalRecords = mysql_num_rows($gettotal_record_query);
	$totalPage = ceil($totalRecords / $limitnum);
	$limits = $limitstart . ',' . $limitnum;
	$getModulelogsDetails_query = select_query('tblmodulelog', '', ['module' => (string) $module], 'id', 'DESC', $limits);

	if (mysql_num_rows($getModulelogsDetails_query) != 0) {
		echo '<div>' . $totalRecords . ' Records Found, Page ' . $currentPage . ' of ' . $totalPage . ' ' . "\n" . '<form method=\'POST\' style=\'float: right;margin-left: 50px;margin-top: -4px;\'><input type=\'submit\' class=\'btn btn-primary\' name=\'clear_logs\' value=\'Clear Logs\'></form></div>';
		echo '<div id="tab0box" class="tabbox"> ' . "\n" . '        <div id="tab_content" style="text-align:left;border-top: 0px;">' . "\n" . '            <div class="tablebg"><table id="sortabletbl1" class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">' . "\n" . '<tbody><tr><th width="150">Date</th><th width="320">Action</th><th>Request</th><th>Response (Notification)</th></tr>';

		while ($getModulelogsDetails = mysql_fetch_assoc($getModulelogsDetails_query)) {
			echo "\n" . '<tr><td>' . $getModulelogsDetails['date'] . '</td><td>' . ucfirst($getModulelogsDetails['action']) . '</td><td><textarea rows="5" style="width:100%;">' . $getModulelogsDetails['request'] . "\n" . '</textarea></td><td><textarea rows="5" style="width:100%;">' . $getModulelogsDetails['response'] . '</textarea></td></tr>' . "\n";
		}

		echo '</tbody></table></div></div></div>';
		echo "\n" . '                <p align="center">' . "\n" . '                    ';
		if (isset($previousPage) && !empty($previousPage) && ($previousPage != 0)) {
			echo '                        <a href="addonmodules.php?module=xtreamdashboard&action=logs&pageno=';
			echo $previousPage;
			echo '">&#171; Previous Page </a>&nbsp; ' . "\n" . '                        ';
		}
		else {
			echo '&#171; Previous Page &nbsp;';
		}

		echo '                    ';
		if (isset($nextPage) && !empty($nextPage) && !($totalPage < $nextPage)) {
			echo '                        <a href="addonmodules.php?module=xtreamdashboard&action=logs&pageno=';
			echo $nextPage;
			echo '">Next Page &#187; </a>&nbsp; ' . "\n" . '                        ';
		}
		else {
			echo 'Next Page &#187;';
		}

		echo '                </p>' . "\n" . '                ';
	}
	else {
		echo '<div id="tab0box" class="tabbox"> ' . "\n" . '                    <div id="tab_content" style="text-align:left;border-top: 0px;">' . "\n" . '                        <div class="tablebg">' . "\n" . '                            <table id="sortabletbl2" class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">' . "\n" . '                                <tbody><tr><th width="150">Date</th><th width="320">Action</th><th>Request</th><th>Response</th></tr>' . "\n" . '                                    <tr><td colspan="5" style="text-align: center;">No Record Found</td></tr>' . "\n" . '                                </tbody></table></div></div></div>' . "\n" . '                ';
	}
}

function WSResellerPanel_clearlogs($module)
{
	if (mysql_query('DELETE FROM  `tblmodulelog` WHERE  `module` =  \'' . $module . '\'')) {
		$result['class'] = 'successbox';
		$result['message'] = 'Logs Clear successfully!';
	}
	else {
		$result['class'] = 'errorbox';
		$result['message'] = 'Error in Clear Logs data';
	}

	return $result;
}

if (isset($_POST['clear_logs'])) {
	$response = WSResellerPanel_clearlogs('WSResellerPanel');
	echo '  <div class="';
	echo $response['class'];
	echo '" style="padding: 14px 5px 6px 60px;  min-height: 50px;">';
	echo $response['message'];
	echo '</div>' . "\n" . '   ';
}

echo ' ' . "\n" . '<div class="tab-content admin-tabs" style="margin-top: -22px;">' . "\n" . '    <div class="tab-pane active" id="tab1">' . "\n" . '        ';
xtreamdashboard_getModulelogs('WSResellerPanel');
echo '</div></div>' . "\n";

?>