<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/14
 * Time: 14:57
 */
require '../../../../zb_system/function/c_system_base.php';
require '../../../../zb_system/function/c_system_admin.php';
require '../inc/main.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('pp_plugin_shequ')) {$zbp->ShowError(48);die();}

$action=GetVars('act', 'GET');

switch ($action){

    case 'saveoptions8':
        pp_plugin_shequ_saveoptions8();
        break;
    case 'saveoptions7':
        pp_plugin_shequ_saveoptions7();
        break;
    case 'saveoptions6':
        pp_plugin_shequ_saveoptions6();
        break;
    case 'saveoptions5':
        pp_plugin_shequ_saveoptions5();
        break;
    case 'saveoptions4':
        pp_plugin_shequ_saveoptions4();
        break;
    case 'saveoptions3':
        pp_plugin_shequ_saveoptions3();
        break;
    case 'saveoptions2':
        pp_plugin_shequ_saveoptions2();
        break;
    case 'saveoptions':
        pp_plugin_shequ_saveoptions();
        break;
}

?>