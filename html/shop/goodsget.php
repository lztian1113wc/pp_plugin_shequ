<?php
require '../../../../../zb_system/function/c_system_base.php';
require '../../../../../zb_system/function/c_system_admin.php';
$zbp->Load();

if (!$zbp->CheckPlugin('pp_plugin_shequ')) {
    $zbp->ShowError(48);
    die();
}

$goodsid = GetVars('goodsid', 'GET');

$pp_plugin_shequ_orders_isbuy_sql=$zbp->db->sql->select(
    $zbp->table['pp_plugin_shequ_orders'].' a inner join '.$zbp->table['pp_plugin_shequ_goods'].' b on b.goods_ID=a.order_GoodsId'
    ,'*'
    ,array(array('=','a.order_GoodsId',$goodsid),array('=','a.order_UserId',$zbp->user->ID))
    ,''
    ,''
    ,''
);
$pp_plugin_shequ_orders_isbuy_arr = $zbp->db->query($pp_plugin_shequ_orders_isbuy_sql);
if(count($pp_plugin_shequ_orders_isbuy_arr)==0){
    die;
}

$pp_plugin_shequ_goodsinfo = $zbp->pp_plugin_shequ_getgoodsinfo($goodsid);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/layui/css/layui.css">
    <script src="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/layui/layui.js"></script>
    <script src="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/jquery-1.8.3.min.js"></script>
    <title></title>
</head>
<body>
<div class="layui-form">
    <div class="layui-form-item">
        <label class="layui-form-label">提取地址</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" value="<?php echo $pp_plugin_shequ_goodsinfo->Url;?>">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">提取地址</label>
        <div class="layui-input-inline">
            <input type="text" class="layui-input" value="<?php echo $pp_plugin_shequ_goodsinfo->Tiquma;?>">
        </div>
    </div>
</div>
</body>
</html>