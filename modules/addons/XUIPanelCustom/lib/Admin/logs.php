<?php

use WHMCS\Database\Capsule;

if (isset($_REQUEST['clear_logs'])) {
    $delete =  Capsule::table('xui_logs')->delete();
}
?>
<form action="" method="POST">
    <button type="submit" name="clear_logs" style="float: right;margin-bottom: 10px;" class="btn btn-primary">
        Clear Logs
    </button>
</form>
<table id="sortabletbl2" class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tbody>
        <tr>
            <th width="150">Date</th>
            <th width="320">Action</th>
            <th>Request</th>
            <th>Response</th>
        </tr>
        <?php
        $count =  Capsule::table('xui_logs')->count();
        if ($count > 0) {
            $results_per_page = 10;
            $number_of_result = $count;
            $number_of_page = ceil($number_of_result / $results_per_page);
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $page_first_result = ($page - 1) * $results_per_page;
            $xui_logs =  Capsule::table('xui_logs')->offset($page_first_result)->limit($results_per_page)->orderByDesc('id')->get();
        ?>
            <div class="tablebg">
                <?php
                foreach ($xui_logs as $val) {
                ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $val->date ?></td>
                        <td style="text-align: center;"><?php echo $val->action ?></td>
                        <td style="text-align: center;"><?php echo $val->request ?></td>
                        <td style="text-align: center;"><textarea style="width: 377px; height: 124px;"><?php print_r((array)json_decode($val->response)); ?></textarea></td>
                    </tr>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
        ?>
            <tr>
                <td style="text-align: center;" colspan="4">No logs found!</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>


<div align="center">
    <ul class="pagination">
        <li><a href="addonmodules.php?module=XUIPanelCustom&action=logs&page=1">First</a></li>
        <li class="<?php
                    if ($page <= 1) {
                        echo 'disabled';
                    }
                    ?>">
            <a href="<?php
                        if ($page <= 1) {
                            echo '#';
                        } else {
                            echo 'addonmodules.php?module=XUIPanelCustom&action=logs';
                            echo "&page=" . ($page - 1);
                        }
                        ?>"><i class="fas fa-chevron-double-left"></i> Previous Page</a>
        </li>
        <li class="<?php
                    if ($page >= $number_of_page) {
                        echo 'disabled';
                    }
                    ?>">
            <a href="<?php
                        if ($page >= $number_of_page) {
                            echo '#';
                        } else {
                            echo 'addonmodules.php?module=XUIPanelCustom&action=logs';
                            echo "&page=" . ($page + 1);
                        }
                        ?>">Next Page <i class="fas fa-chevron-double-right"></i></a>
        </li>
        <li><a href="addonmodules.php?module=XUIPanelCustom&action=logs&page=<?php echo $number_of_page; ?>">Last</a></li>
    </ul>
</div>