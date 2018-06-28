<?php
#注册插件
RegisterPlugin("pp_plugin_shequ","ActivePlugin_pp_plugin_shequ");
define('pp_plugin_shequ_path', dirname(__FILE__));
define('pp_plugin_shequ_incpath', pp_plugin_shequ_path . '/inc/');
$pp_plugin_shequ=null;

function pp_plugin_shequ_init(){
    require pp_plugin_shequ_path . '/inc/pp_plugin_shequ.php';
    global $pp_plugin_shequ;
    $pp_plugin_shequ = new pp_plugin_shequ_class;
}

function ActivePlugin_pp_plugin_shequ() {
    //后台菜单
    Add_Filter_Plugin('Filter_Plugin_Admin_TopMenu', 'pp_plugin_shequ_admin_topmenu');
    //前台首页开始
    Add_Filter_Plugin('Filter_Plugin_Index_Begin', 'pp_plugin_shequ_index_begin');
    //自定义类文件位置
    Add_Filter_Plugin('Filter_Plugin_Autoload', 'pp_plugin_shequ_autoload');
    //zbp挂载自定义函数
    Add_Filter_Plugin('Filter_Plugin_Zbp_Call', 'pp_plugin_shequ_zbp_call',PLUGIN_EXITSIGNAL_RETURN);
    //评论提交成功后
    Add_Filter_Plugin('Filter_Plugin_PostComment_Succeed', 'pp_plugin_shequ_postcomment_succeed');
}

function InstallPlugin_pp_plugin_shequ() {
    pp_plugin_shequ_table_create();
}

function UninstallPlugin_pp_plugin_shequ() {
    pp_plugin_shequ_table_delete();
}

function pp_plugin_shequ_zbp_call($method, $args){
    require 'inc/zbpFunction.php';
    if(class_exists('pp_plugin_shequ_zbpFunction')) {
        $pp_plugin_shequ_zbpFunction = new pp_plugin_shequ_zbpFunction();
        if(method_exists($pp_plugin_shequ_zbpFunction,$method)){

            return $pp_plugin_shequ_zbpFunction->$method($args);
        }else{
            return "函数未定义";
        }
    }
}

function pp_plugin_shequ_admin_topmenu(&$m){
    global $zbp;
    //echo '<li id="topmenu_shequ"><a href="'.$zbp->host.'zb_users/plugin/pp_plugin_shequ/main.php" target="_self" title="社区管理">社区管理</a></li>';
    array_unshift($m, MakeTopMenu("root",'社区管理',$zbp->host . "zb_users/plugin/pp_plugin_shequ/main.php","","topmenu_shequ"));
}

function pp_plugin_shequ_index_begin(){
    pp_plugin_shequ_init();
    global $pp_plugin_shequ;

    $pp_plugin_shequ->UrlRule();
}

function pp_plugin_shequ_postcomment_succeed(&$comment){
    pp_plugin_shequ_init();
    global $pp_plugin_shequ;
    $pp_plugin_shequ->CommentAddSucceed($comment);
}

function pp_plugin_shequ_autoload($className){
    $className = str_replace('__', '/', $className);

    $fileName = ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/inc/' . strtolower($className) . '.php';
    if (is_readable($fileName)) {
        require $fileName;
        return true;
    }
}

function pp_plugin_shequ_table_delete(){
    global $zbp;
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_orders']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_orders']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_collection']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_collection']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_message']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_message']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_user']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_user']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_dianzan']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_dianzan']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_comment']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_comment']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_post']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_post']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_goods']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_goods']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_goods_type']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_goods_type']);
        $zbp->db->QueryMulit($s);
    }
    if($zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_goods_comment']))
    {
        $s = $zbp->db->sql->DelTable($GLOBALS["table"]['pp_plugin_shequ_goods_comment']);
        $zbp->db->QueryMulit($s);
    }
}

function pp_plugin_shequ_table_create(){
    global $zbp;

    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_orders']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_orders'],$GLOBALS["datainfo"]['pp_plugin_shequ_orders']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_collection']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_collection'],$GLOBALS["datainfo"]['pp_plugin_shequ_collection']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_message']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_message'],$GLOBALS["datainfo"]['pp_plugin_shequ_message']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_dianzan']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_dianzan'],$GLOBALS["datainfo"]['pp_plugin_shequ_dianzan']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_comment']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_comment'],$GLOBALS["datainfo"]['pp_plugin_shequ_comment']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_user']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_user'],$GLOBALS["datainfo"]['pp_plugin_shequ_user']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_post']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_post'],$GLOBALS["datainfo"]['pp_plugin_shequ_post']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_goods']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_goods'],$GLOBALS["datainfo"]['pp_plugin_shequ_goods']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_goods_type']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_goods_type'],$GLOBALS["datainfo"]['pp_plugin_shequ_goods_type']);
        $zbp->db->QueryMulit($s);
    }
    if(!$zbp->db->ExistTable($GLOBALS["table"]['pp_plugin_shequ_goods_comment']))
    {
        $s = $zbp->db->sql->CreateTable($GLOBALS["table"]['pp_plugin_shequ_goods_comment'],$GLOBALS["datainfo"]['pp_plugin_shequ_goods_comment']);
        $zbp->db->QueryMulit($s);
    }
}

##########################自定义表结构######################################
$table['pp_plugin_shequ_user'] = 'pp_plugin_shequ_user';
$table['pp_plugin_shequ_post'] = 'pp_plugin_shequ_post';
$table['pp_plugin_shequ_comment'] = 'pp_plugin_shequ_comment';
$table['pp_plugin_shequ_dianzan'] = 'pp_plugin_shequ_dianzan';
$table['pp_plugin_shequ_message'] = 'pp_plugin_shequ_message';
$table['pp_plugin_shequ_collection'] = 'pp_plugin_shequ_collection';
$table['pp_plugin_shequ_goods'] = 'pp_plugin_shequ_goods';
$table['pp_plugin_shequ_goods_type'] = 'pp_plugin_shequ_goods_type';
$table['pp_plugin_shequ_orders'] = 'pp_plugin_shequ_orders';
$table['pp_plugin_shequ_goods_comment'] = 'pp_plugin_shequ_goods_comment';

$datainfo['pp_plugin_shequ_goods_comment'] = array(
    'ID' => array('comm_ID','integer','',0),
    'Pid' => array('comm_Pid','integer','',0),
    'UserId' => array('comm_UserId','integer','',0),
    'GoodsId' => array('comm_GoodsId','integer','',0),
    'Content' => array('comm_Content','string','',''),
    'PostTime' => array('comm_Time','integer','',0),
    'Meta' => array('comm_Meta', 'string', '', ''),
);
$datainfo['pp_plugin_shequ_goods_type'] = array(
    'ID' => array('type_ID','integer','',0),
    'Name' => array('type_Name','string','',0),
    'Meta' => array('type_Meta', 'string', '', ''),
);
$datainfo['pp_plugin_shequ_orders'] = array(
    'ID' => array('order_ID','integer','',0),
    'OrderNumber' => array('order_Number','string',200,''),
    'GoodsID' => array('order_GoodsId','integer','',0),
    'UserId' => array('order_UserId','integer','',0),
    'Name' => array('order_Name','string',500,''),
    'Price' => array('order_Price','string',100,''),
    'Money' => array('order_Money','string',100,''),
    'PostTime' => array('order_posttime','integer','',0),
    'Meta' => array('order_Meta', 'string', '', ''),
);
$datainfo['pp_plugin_shequ_goods'] = array(
    'ID' => array('goods_ID','integer','',0),
    'TypeId' => array('goods_TypeId','integer','',0),
    'Name' => array('goods_name','string',500,''),
    'Desc' => array('goods_desc','string',1000,''),
    'Url' => array('goods_url','string',1000,''),
    'Tiquma' => array('goods_Tiquma','string',1000,''),
    'Content' => array('goods_content','string','',''),
    'PostTime' => array('goods_posttime','integer','',0),
    'Meta' => array('goods_Meta', 'string', '', ''),
);
$datainfo['pp_plugin_shequ_collection'] = array(
    'ID' => array('coll_ID','integer','',0),
    'PostId' => array('coll_PostId','integer','',0),
    'UserId' => array('coll_UserId','integer','',0),
    'PostTime' => array('coll_PostTime','integer','',0)
);
$datainfo['pp_plugin_shequ_message'] = array(
    'ID' => array('mess_ID','integer','',0),
    'UserId' => array('mess_UserId','integer','',0),
    'ToUserId' => array('mess_ToUserId','integer','',0),
    'Content' => array('mess_Content','string',1000,""),
    'PostTime' => array('mess_PostTime','integer','',0)
);
$datainfo['pp_plugin_shequ_user'] = array(
    'ID' => array('id','integer','',0),
    'UserId' => array('userid','integer','',0),
    'UserFace' => array('userface','string',500,""),
    'UserVip' => array('uservip','integer','',0),
    'UserOpenId' => array('useropenid','string',100,""),
    'UserFeiWen' => array('userfeiwen','integer','',0)
);
$datainfo['pp_plugin_shequ_post'] = array(
    'ID' => array('p_id','integer','',0),
    'PostId' => array('p_postid','integer','',0),
    'JiaJing' => array('p_jiajing','integer','',0),
    'FeiWen' => array('p_feiwen','integer','',0),
    'JieTie' => array('p_jietie','integer','',0)
);
$datainfo['pp_plugin_shequ_comment'] = array(
    'ID' => array('c_id','integer','',0),
    'CommId' => array('comm_id','integer','',0),
    'IsCaiNa' => array('comm_caina','integer','',0),
    'DianZans' => array('comm_dianzans','integer','',0)
);
$datainfo['pp_plugin_shequ_dianzan'] = array(
    'ID' => array('dz_id','integer','',0),
    'CommId' => array('dz_commid','integer','',0),
    'PostId' => array('dz_logid','integer','',0),
    'UserId' => array('dz_userid','integer','',0),
    'AddTime' => array('dz_adddate','integer','',0)
);
############################################################################

