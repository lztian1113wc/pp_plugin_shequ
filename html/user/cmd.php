<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/21
 * Time: 15:42
 */

require '../../../../../zb_system/function/c_system_base.php';
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/inc/pp_plugin_shequ.php';

$zbp->Load();
$action = GetVars('act', 'GET');
$pp_plugin_shequ = new pp_plugin_shequ_class;

switch ($action) {
    case 'login':
        echo $pp_plugin_shequ->VerifyLogin();
        break;
    case 'reg':
        echo $pp_plugin_shequ->MemberInsert();
        break;
    case 'set':
        echo $pp_plugin_shequ->MemberUpdate();
        break;
    case 'upload':
        $result = $pp_plugin_shequ->PostUpload();
        echo $result;
        break;
    case 'uploadUserFace':
        $result = $pp_plugin_shequ->UploadUserFace();
        echo $result;
        break;
    case 'uploadlogo':
        $result = $pp_plugin_shequ->uploadlogo();
        echo $result;
        break;
    case 'passalter':
        $result = $pp_plugin_shequ->PasswordAlter();
        echo $result;
        break;
    case 'messageDel':
        $result = $pp_plugin_shequ->MessageDel();
        echo $result;
        break;
    case 'messageDelAll':
        $result = $pp_plugin_shequ->MessageDelAll();
        echo $result;
        break;
    case 'fatie':
        $result = $pp_plugin_shequ->PostAdd();
        echo $result;
        break;
    case 'xiugaitiezi':
        $result = $pp_plugin_shequ->PostEdit();
        echo $result;
        break;
    case 'articleDel':
        $result = $pp_plugin_shequ->PostDel();
        echo $result;
        break;
    case 'articleTop':
        $result = $pp_plugin_shequ->PostTop();
        echo $result;
        break;
    case 'articleTopqx':
        $result = $pp_plugin_shequ->PostTopqx();
        echo $result;
        break;
    case 'articlejj':
        $result = $pp_plugin_shequ->PostJiaJing();
        echo $result;
        break;
    case 'articlejjqx':
        $result = $pp_plugin_shequ->PostJiaJingqx();
        echo $result;
        break;
    case 'dianzan':
        $result = $pp_plugin_shequ->CommentZan();
        echo $result;
        break;
    case 'comm_shanchu':
        echo $pp_plugin_shequ->CommentDel();
        break;
    case 'comm_caina':
        echo $pp_plugin_shequ->CommentCaiNa();
        break;
    case 'articleNumUpdate':
        echo $pp_plugin_shequ->ArticleNumUpdate();
        break;
    case 'createOrder':
        $price = is_numeric(trim(GetVars('price', 'GET')))?trim(GetVars('price', 'GET')):0;
        $zbp->pp_plugin_shequ_createOrder($price);
        break;
    case 'postshoucang':
        echo $pp_plugin_shequ->PostShouCang();
        break;
    case 'postunshoucang':
        echo $pp_plugin_shequ->PostUnShouCang();
        break;
    case 'goodsAdd':
        echo $pp_plugin_shequ->GoodsAdd();
        break;
    case 'goodsCommentAdd':
        echo $pp_plugin_shequ->GoodsCommentAdd();
        break;
    case 'goodsedit':
        echo $pp_plugin_shequ->GoodsEdit();
        break;
    case 'goodsDel':
        echo $pp_plugin_shequ->GoodsDel();
        break;
    case 'goodsTypeAdd':
        echo $pp_plugin_shequ->GoodsTypeAdd();
        break;
    case 'goodsTypeEdit':
        echo $pp_plugin_shequ->GoodsTypeEdit();
        break;
    case 'goodsTypeDel':
        echo $pp_plugin_shequ->GoodsTypeDel();
        break;
    case 'buyGoods':
        if($zbp->user->ID==0){
            header('location:/shequ/user/login.html');
            die;
        }
        $goodsid = is_numeric(trim(GetVars('goodsid', 'GET')))?trim(GetVars('goodsid', 'GET')):0;
        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
        $pp_plugin_shequ_goods->LoadInfoByID($goodsid);
        if($pp_plugin_shequ_goods->ID>0) {
            if($pp_plugin_shequ_goods->Metas->shifoucuxiao=='on'){
                $zbp->pp_plugin_shequ_createOrder($pp_plugin_shequ_goods->Metas->goodsprice_cx,$goodsid,'shequ/user/zhanghu.html');
            }else{
                $zbp->pp_plugin_shequ_createOrder($pp_plugin_shequ_goods->Metas->goodsprice,$goodsid,'shequ/user/zhanghu.html');
            }
        }else{
            echo 'error';
        }
        break;
    default:
        //code ...
        break;
}
?>