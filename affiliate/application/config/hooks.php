<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH."application/config/database.php";

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

// $hook['pre_system'] = array(
//     'class'    => 'Router_Hook',
//     'function' => 'get_routes',
//     'filename' => 'Router_Hook.php',
//     'filepath' => 'hooks',
//     'params'   => array(
//         $db['default']['hostname'],
//         $db['default']['username'],
//         $db['default']['password'],
//         $db['default']['database'],
//         $db['default']['dbprefix'],
//         )
//     );


$hook['post_controller_constructor'] = array(
    'class'    => 'Affiliate_Hook',
    'function' => 'sync_aff_session',
    'filename' => 'Affiliate_Hook.php',
    'filepath' => 'hooks'
);