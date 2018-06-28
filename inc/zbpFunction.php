<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/30
 * Time: 10:26
 */


class pp_plugin_shequ_zbpFunction{

    //创建码支付订单
    function pp_plugin_shequ_createOrder($args){
        global $zbp;

        $codepay_id=$zbp->Config('pp_plugin_shequ')->mzfid;//这里改成码支付ID
        $codepay_key=$zbp->Config('pp_plugin_shequ')->mzfmy; //这是您的通讯密钥

        $data = array(
            "id"=>$codepay_id,//你的码支付ID
            "pay_id" => $zbp->user->ID, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "type" => 1,//1支付宝支付 3微信支付 2QQ钱包
            "price" => $args[0],//金额
            "param" => $args[1],//商品ID
            "notify_url"=>$zbp->host."shequ/pay/successd.html",//付款后POST通知通知地址
            "return_url"=>$zbp->host.$args[2]//付款后用户跳转页面
        ); //构造需要传递的参数

        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素

        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == ''||$key == 'sign') continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign .$codepay_key); //创建订单所需的参数
        $url = "http://api2.fateqq.com:52888/creat_order/?{$query}"; //支付页面

        header("Location:{$url}"); //跳转到支付页面
    }

    //订单支付成功后回调
    function pp_plugin_shequ_paySuccessd(){
        global $zbp;

        ksort($_POST); //排序post参数
        reset($_POST); //内部指针指向数组中的第一个元素
        $codepay_key=$zbp->Config('pp_plugin_shequ')->mzfmy; //这是您的密钥
        $sign = '';//初始化
        foreach ($_POST AS $key => $val) { //遍历POST参数
            if ($val == '' || $key == 'sign') continue; //跳过这些不签名
            if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        if (!$_POST['pay_no'] || md5($sign . $codepay_key) != $_POST['sign']) { //不合法的数据
            exit('fail');  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $pay_id = $_POST['pay_id']; //需要充值的ID 或订单号 或用户名
            $money = (float)$_POST['money']; //实际付款金额
            $price = (float)$_POST['price']; //订单的原价
            $param = $_POST['param']; //自定义参数
            $pay_no = $_POST['pay_no']; //流水号


            $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
            $pp_plugin_shequ_goods->LoadInfoByID($param);
            $pp_plugin_shequ_goods_ID = $param;
            $pp_plugin_shequ_goods_Name = '';

            if($pp_plugin_shequ_goods->ID>0){
                $pp_plugin_shequ_goods_ID = $pp_plugin_shequ_goods->ID;
                $pp_plugin_shequ_goods_Name = $pp_plugin_shequ_goods->Name;
                if($pp_plugin_shequ_goods->Metas->shifoucuxiao=='on'){
                    if($pp_plugin_shequ_goods->Metas->cuxiaofenlei==1){
                        //时间
                    }else{
                        //数量
                        $pp_plugin_shequ_goods->Metas->cuxiaoshuliang=$pp_plugin_shequ_goods->Metas->cuxiaoshuliang-1;
                        if($pp_plugin_shequ_goods->Metas->cuxiaoshuliang==0){
                            $pp_plugin_shequ_goods->Metas->shifoucuxiao='off';
                        }
                        $pp_plugin_shequ_goods->Save();
                    }
                }
            }

            $pp_plugin_shequ_orders = new pp_plugin_shequ_orders();
            $pp_plugin_shequ_orders->UserId=$pay_id;
            $pp_plugin_shequ_orders->GoodsID=$pp_plugin_shequ_goods_ID;
            $pp_plugin_shequ_orders->Name=$pp_plugin_shequ_goods_Name;
            $pp_plugin_shequ_orders->Price=$price;
            $pp_plugin_shequ_orders->Money=$money;
            $pp_plugin_shequ_orders->OrderNumber=$pay_no;
            $pp_plugin_shequ_orders->PostTime=time();
            $pp_plugin_shequ_orders->Save();

            exit('success'); //返回成功 不要删除哦
        }
    }

    function pp_plugin_shequ_qqlogin(){
        require_once(ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/app/qq/oauth/api/qqConnectAPI.php');
        $qc = new QC();
        $qc->qq_login();
    }

    //QQ登录回调
    function pp_plugin_shequ_qqhuidiao(){
        global $zbp;
        require_once(ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/app/qq/oauth/api/qqConnectAPI.php');

		$qc = new QC();  
		$acs = $qc->qq_callback();//callback主要是验证 code和state,返回token信息，并写入到文件中存储，方便get_openid从文件中度  
		$openid = $qc->get_openid();//根据callback获取到的token信息得到openid,所以callback必须在openid前调用  
		$qc = new QC($acs,$openid);  

        $arr = $qc->get_user_info();


        $memberExtend=new MemberExtend();
        $memberExtend->LoadInfoByField('UserOpenId',$openid);

        $mem = new Member();
        if($memberExtend->ID>0){
            $mem->LoadInfoByID($memberExtend->UserId);
        }else{
            $zbp->guid = GetGuid();
            $guid = GetGuid();
            $mem->Guid = $guid;
            $mem->Level = 3;//1管理员 2网站编辑3作者4协作者5评论者6游客
            $mem->Name =time();
            $mem->Password = Member::GetPassWordByGuid($openid, $guid);
            $mem->Alias = $arr["nickname"];
            $mem->IP = GetGuestIP();
            $mem->PostTime = time();
            
            $mem->Save();

            $memberExtend->UserId=$mem->ID;
	    $memberExtend->UserFeiWen=200; //注册用户默认200飞吻
            $memberExtend->UserFace=$arr['figureurl_2'];
            $memberExtend->UserOpenId=$openid;
            $memberExtend->Save();
        }

        $m = null;
        if ($zbp->Verify_MD5($mem->Name, md5($openid), $m)) {

            $zbp->user = $m;
            $un = $m->Name;
            $ps = $zbp->VerifyResult($m);
            $sdt = time() + 3600 * 24 * 1;
            SetLoginCookie($m, $sdt);
            //header("Location:".$zbp->host."shequ/user/home.html");
            $returnurl = empty($_COOKIE["cookie_zbp_host"])?$zbp->host.'shequ/index.html':$_COOKIE["cookie_zbp_host"];
            header('location:'.$returnurl);
        }
    }

    //商品列表
    function pp_plugin_shequ_getgoodslist($sql){
        global $zbp;
        //$sql = $zbp->db->sql->select($zbp->table['pp_plugin_shequ_goods'],'*','','goods_posttime desc','20','');
        $result = $zbp->GetListType('pp_plugin_shequ_goods',$sql[0]);
        return $result;
    }

    //商品详情
    function pp_plugin_shequ_getgoodsinfo($arr){
        global $zbp;

        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
        $pp_plugin_shequ_goods->LoadInfoByID($arr[0]);
        return $pp_plugin_shequ_goods;
    }

    //判断文章是否被收藏了
    function pp_plugin_shequ_postIsCollection($arr){
        global $zbp;
        $where = array(array('=','coll_PostId',$arr[0]),array('=','coll_UserId',$zbp->user->ID));
        $sql = $zbp->db->sql->Count($zbp->table['pp_plugin_shequ_collection']
            ,array(array('*','count'))
            ,$where,'');
        $objarr = $zbp->db->Query($sql);

        if(current($objarr)["count"]>0){
            return true;
        }else{
            return false;
        }
    }

    function pp_plugin_shequ_shop_getOrdersList($sql){
        global $zbp;
        if(is_array($sql)){
            $sql=$sql[0];
        }
        $result = $zbp->GetListType('pp_plugin_shequ_orders',$sql);
        return $result;
    }

    function pp_plugin_shequ_shop_getGoodsTypeList(){
        global $zbp;
        $sql = $zbp->db->sql->select($zbp->table['pp_plugin_shequ_goods_type'],'*','','type_ID desc','20','');
        $result = $zbp->GetListType('pp_plugin_shequ_goods_type',$sql);
        return $result;
    }

//    function pp_plugin_shequ_shop_checkGoodsState(){
//        global $zbp;
//        $sql = $zbp->db->sql->select($zbp->table['$pp_plugin_shequ_goods']
//            ,'*'
//            ,array('=',));
//        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
//
//    }
}
?>