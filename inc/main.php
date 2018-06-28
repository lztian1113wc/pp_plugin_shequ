<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/21
 * Time: 15:34
 */

function pp_plugin_shequ_saveoptions8()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->shop_show_inmenu = GetVars('is_show_in_menu', 'POST');//是否加入导航
    $zbp->Config('pp_plugin_shequ')->shop_menu_name = GetVars('daohangming', 'POST');//导航中的名字
    $zbp->SaveConfig('pp_plugin_shequ');

    if (GetVars('is_show_in_menu', 'POST') == "off") {
        $zbp->DelItemToNavbar('shequ_shop', 'shop_index');
    }
    if (GetVars('is_show_in_menu', 'POST') == "on") {
        if(GetVars('daohangming', 'POST') == ''){
            $zbp->Config('pp_plugin_shequ')->shop_menu_name = '商城';
            $zbp->AddItemToNavbar('shequ_shop', 'shop_index', '商城', $zbp->host . 'shequ/shop/index.html');
        }else{
            $zbp->AddItemToNavbar('shequ_shop', 'shop_index', GetVars('daohangming', 'POST'), $zbp->host . 'shequ/shop/index.html');
        }
    }
}
function pp_plugin_shequ_saveoptions7()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->mzfczje = GetVars('mzfczje', 'POST');//充值金额
    $zbp->SaveConfig('pp_plugin_shequ');
}
function pp_plugin_shequ_saveoptions6()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->mzfid = GetVars('mzfid', 'POST');//码支付ID
    $zbp->Config('pp_plugin_shequ')->mzfmy = GetVars('mzfmy', 'POST');//码支付秘钥
    $zbp->SaveConfig('pp_plugin_shequ');
}
function pp_plugin_shequ_saveoptions5()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->qqlogin = GetVars('qqlogin', 'POST');//qq登录

    $zbp->SaveConfig('pp_plugin_shequ');
}
function pp_plugin_shequ_saveoptions4()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->guanggaowei_2 = GetVars('guanggaowei2', 'POST');//广告位

    $zbp->SaveConfig('pp_plugin_shequ');
}
function pp_plugin_shequ_saveoptions3()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->guanggaowei_1 = GetVars('guanggaowei1', 'POST');//广告位

    $zbp->SaveConfig('pp_plugin_shequ');
}

function pp_plugin_shequ_saveoptions2()
{
    global $zbp;

    $zbp->Config('pp_plugin_shequ')->wxtd_mingcheng = GetVars('mingcheng', 'POST');//文新通道-名称
    $zbp->Config('pp_plugin_shequ')->wxtd_neirong = GetVars('neirong', 'POST');//文新通道-内容

    $zbp->SaveConfig('pp_plugin_shequ');
}

function pp_plugin_shequ_saveoptions()
{
    global $zbp;
    $zbp->Config('pp_plugin_shequ')->is_show_in_menu = GetVars('is_show_in_menu', 'POST');//是否显示在导航
    $zbp->Config('pp_plugin_shequ')->isdefaultpage = GetVars('isdefaultpage', 'POST');//是否显示在导航
    $zbp->Config('pp_plugin_shequ')->keywords = GetVars('keywords', 'POST');//关键词
    $zbp->Config('pp_plugin_shequ')->title = GetVars('title', 'POST');//标题
    $zbp->Config('pp_plugin_shequ')->description = GetVars('description', 'POST');//简介
    $zbp->Config('pp_plugin_shequ')->footermessage = GetVars('footermessage', 'POST');//底部信息
    $zbp->SaveConfig('pp_plugin_shequ');

    if (GetVars('is_show_in_menu', 'POST') == "off") {
        $zbp->DelItemToNavbar('shequ', 'index');
    }
    if (GetVars('is_show_in_menu', 'POST') == "on") {
        $zbp->AddItemToNavbar('shequ', 'index', '社区', $zbp->host . 'shequ/index.html');
    }
}

?>