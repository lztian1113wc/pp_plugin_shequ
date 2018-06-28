<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/21
 * Time: 14:29
 */
class pp_plugin_shequ_class{

    //路由器
    public function UrlRule(){
        global $zbp;
        $isdefaultpage = $zbp->Config('ActivePlugin_pp_plugin_shequ')->isdefaultpage;
        $url_cut_left = substr($zbp->currenturl,0,strpos($zbp->currenturl, '.html'));
        $url_parm_arr = explode("/",str_replace(".html","",$url_cut_left));

        if($url_parm_arr[1]=='shequ'){

            switch ($url_parm_arr[2]){

                case "qqhuidiao":
                    $zbp->pp_plugin_shequ_qqhuidiao();
                    break;
                case "qqlogin":
                    $zbp->pp_plugin_shequ_qqlogin();
                    break;
                case "user":
                    switch($url_parm_arr[3]){
                        case "login":
                            require pp_plugin_shequ_path.'/html/user/login.php';
                            break;
                        case "reg":
                            require pp_plugin_shequ_path.'/html/user/reg.php';
                            break;
                        case "set":
                            require pp_plugin_shequ_path.'/html/user/set.php';
                            break;
                        case "home":
                            require pp_plugin_shequ_path.'/html/user/home.php';
                            break;
                        case "message":
                            require pp_plugin_shequ_path.'/html/user/message.php';
                            break;
                        case "index":
                            require pp_plugin_shequ_path.'/html/user/index.php';
                            break;
                        case "zhanghu":
                            require pp_plugin_shequ_path.'/html/user/zhanghu.php';
                            break;
                        case "shop":
                            require pp_plugin_shequ_path.'/html/user/shop.php';
                            break;
                        default:
                            require pp_plugin_shequ_path.'/html/other/404.php';
                            break;
                    }
                    break;
                case "shop":
                    switch($url_parm_arr[3]){
                        case "index":
                            require pp_plugin_shequ_path.'/html/shop/index.php';
                            break;
                        case "info":
                            require pp_plugin_shequ_path.'/html/shop/info.php';
                            break;
                        default:
                            require pp_plugin_shequ_path.'/html/other/404.php';
                            break;
                    }
                    break;
                case "article":
                    switch ($url_parm_arr[3]) {
                        case "add":
                            require pp_plugin_shequ_path.'/html/jie/add.php';
                            break;
                        case "edit":
                            require pp_plugin_shequ_path.'/html/jie/edit.php';
                            break;
                        case "more":
                        case "yijie":
                        case "zonghe":
                        case "jinghua":
                        case "zuixin":
                        case "reyi":
                            require pp_plugin_shequ_path.'/html/jie/index.php';
                            break;
                        case is_numeric($url_parm_arr[3]):
                            require pp_plugin_shequ_path.'/html/jie/detail.php';
                            break;
                        default:
                            require pp_plugin_shequ_path.'/html/other/404.php';
                            break;
                    }
                    break;
                case "index":
                    require pp_plugin_shequ_path.'/html/index.php';
                    break;
                case "category":
                    require pp_plugin_shequ_path.'/html/jie/index.php';
                    break;
                case "pay":
                    switch($url_parm_arr[3]){
                        case "successd":
                            $zbp->pp_plugin_shequ_paySuccessd();
                            break;
                    }
                    break;
                default:
                    require pp_plugin_shequ_path.'/html/other/404.php';
                    break;
            }

            die();
        }
        if(($isdefaultpage=='on' && ($zbp->currenturl=="" || $zbp->currenturl=="/" || $zbp->currenturl=="/index.php" || $zbp->currenturl=="/index.html"))){
            require pp_plugin_shequ_path.'/html/index.php';
            die();
        }
    }

    public function ArticleNumUpdate(){
        global $zbp;
        $postId = trim(GetVars('id', 'POST'));

        $post = new Post();
        $post->LoadInfoByID($postId);
        if($post->ID >0){
            $post->ViewNums++;
            $post->Save();
        }
    }

    public function VerifyLogin($throwException = true)
    {
        global $zbp;
        /** @var Member $m */
        $m = null;
        $u = trim(GetVars('username', 'POST'));
        $p = trim(GetVars('password', 'POST'));
        if ($zbp->Verify_MD5(GetVars('username', 'POST'), GetVars('password', 'POST'), $m)) {
            $zbp->user = $m;
            $un = $m->Name;
            $ps = $zbp->VerifyResult($m);
            $sd = (int) GetVars('savedate');

            if ($sd == 0) {
                $sdt = 0;
            } else {
                $sdt = time() + 3600 * 24 * $sd;
            }

            SetLoginCookie($m, $sdt);

            return 'success';
        } else if ($throwException) {
            return 'fail';
        } else {
            return 'fail';
        }
    }

    public function CommentAddSucceed(&$comment){
        global $zbp;

        $matchss =array();
        $pattent = "/@[\w\x{4e00}-\x{9fa5}]{2,10}\s{1}/iu";
        $comment_content = str_replace('&nbsp;',' ',$comment->Content);
        preg_match_all( $pattent, $comment_content, $matchss);
        $w=' 1=2';
        foreach ($matchss[0] as $alias) {
            $alias = trim(str_replace('@','',$alias));
            $w=$w." or mem_Alias='".$alias."'";
        }
        $sql = $zbp->db->sql->Select($zbp->table["Member"], array('*'), $w, null, null, null);
        $memberArr = $zbp->GetListType('Member', $sql);
        $post = new Post();
        $post->LoadInfoByID($comment->LogID);

        $member = new Member();
        $member->LoadInfoByID($zbp->user->ID);
        $comment_count = $zbp->db->query($zbp->db->sql->Select($zbp->table["Comment"], 'count(*)', array(array('=','comm_AuthorID',$zbp->user->ID)), null, null, null));
        $member->Comments=current($comment_count[0]);
        $member->Save();

        $str_message = '<p>
        '.$zbp->user->Alias.'在帖子<a style="color: #009688;" href="'.$zbp->host.'/shequ/article/'.$post->ID.'.html">'.$post->Title.'</a>中提到了你</p>';

        foreach($memberArr as $member){
            $message = new MessageExtend();
            $message->UserId=0;
            $message->ToUserId=$member->ID;
            $message->Content=$str_message;
            $message->PostTime=Time();

            $message->Save();
        }

    }

    public function CommentCaiNa(){
        global $zbp;
        $commId=GetVars('commId', 'POST');

        $commentExtend = new CommentExtend();
        $commentExtend->LoadInfoByField('CommId',$commId);
        $commentExtend->CommId=$commId;
        $commentExtend->IsCaiNa=1;
        $commentExtend->Save();

        $comment = new Comment();
        $comment->LoadInfoByID($commId);

        //拿到飞吻数
        $postExtend = new PostExtend();
        $postExtend->LoadInfoByField('PostId',$comment->LogID);
        $postExtend->PostId = $comment->LogID;
        $postExtend->JieTie=1;
        $postExtend->Save();

        //找到被采纳人,增加飞吻。
        $memberExtend = new MemberExtend();
        $memberExtend->LoadInfoByField('UserId',$comment->AuthorID);
        $memberExtend->UserId=$comment->AuthorID;
        $memberExtend->UserFeiWen=$memberExtend->UserFeiWen+$postExtend->FeiWen;
        $memberExtend->Save();

        return 1;
    }

    public function CommentDel(){
        global $zbp;
        $commId=GetVars('commId', 'POST');
        $comment = new Comment();
        $comment->LoadInfoByID($commId);
        $result = $comment->Del();
        if($result){
            $commentExtend = new CommentExtend();
            $commentExtend->LoadInfoByField('CommId',$commId);
            $commentExtend->Del();
            return 1;
        }else{
            return 2;
        }
    }

    public function CommentZan(){
        global $zbp;
        $commId=GetVars('commId', 'POST');
        $postId=GetVars('postId', 'POST');

        $w[]=array('=','dz_commid',$commId);
        $w[]=array('=','dz_logid',$postId);
        $w[]=array('=','dz_userid',$zbp->user->ID);

        $sql = $zbp->db->sql->Select('pp_plugin_shequ_dianzan', array('*'), $w, null, null, null);
        $array = $zbp->GetListType('DianZanExtend',$sql);
        if(count($array)<1){
            $dianzan = new DianZanExtend();
            $dianzan->CommId=$commId;
            $dianzan->PostId=$postId;
            $dianzan->UserId=$zbp->user->ID;
            $dianzan->Save();

            $comment = new CommentExtend();
            $comment->LoadInfoByField('CommId',$commId);
            $comment->CommId=$commId;
            $comment->DianZans=is_numeric($comment->DianZans)?$comment->DianZans+1:1;
            $comment->Save();

            return 1;
        }else{

            current($array)->Del();

            $comment = new CommentExtend();
            $comment->LoadInfoByField('CommId',$commId);
            $comment->CommId=$commId;
            $comment->DianZans=is_numeric($comment->DianZans)?$comment->DianZans-1:0;
            $comment->Save();

            return 2;
        }
    }

    public function PostEdit(){
        global $zbp;

        $post = new Post;
        $post->LoadInfoByID(GetVars('postid', 'POST'));
        if($post->AuthorID!=$zbp->user->ID){
            return 2;
        }

        $post->CateID=GetVars('class', 'POST');
        $post->Title=GetVars('title', 'POST');
        $post->Content=GetVars('content', 'POST');
        $result = $post->Save();
        if($result){
            return 1;
        }else{
            return 3;
        }
    }

    public function PostAdd(){
        global $zbp;
        $userExtend = new MemberExtend;
        $userExtend->LoadInfoByField('UserId',$zbp->user->ID);
            if(!is_numeric(GetVars('experience', 'POST'))){
            return 4;
        }
        if($userExtend->UserFeiWen<GetVars('experience', 'POST')){
            return 3;
        }

        $post = new Post;
        $post->CateID=GetVars('class', 'POST');
        $post->Title=GetVars('title', 'POST');
        $post->Content=GetVars('content', 'POST');
        $post->AuthorID=$zbp->user->ID;
        $post->Type=0;
        $post->IsLock=0;//允许评论
        $post->Status=0;//直接发布
        $result = $post->Save();

        if($result) {
            $postExtend = new PostExtend;
            $postExtend->LoadInfoByField('PostId',$post->ID);
            $postExtend->PostId = $post->ID;
            $postExtend->FeiWen = GetVars('experience', 'POST');
            $postExtend->Save();

            $userExtend->UserFeiWen=$userExtend->UserFeiWen-GetVars('experience', 'POST');
            $userExtend->Save();
            return 1;
        }else{
            return 2;
        }

    }

    public function PostTop(){
        global $zbp;
        $postID = GetVars('id', 'POST');
        if(!is_numeric($postID)){
            return 4;
        }

        if (!$zbp->CheckRights('root')) {
            return 3;
        }

        $post = new Post();
        $post->LoadInfoByID($postID);
        $post->IsTop=2;
        $result = $post->Save();
        if ($result) {
            return 1;
        }else{
            return 2;
        }
    }

    public function PostJiaJingqx(){
        global $zbp;
        $postID = GetVars('id', 'POST');
        if(!is_numeric($postID)){
            return 4;
        }

        if (!$zbp->CheckRights('root')) {
            return 3;
        }

        $post = new PostExtend();
        $post->LoadInfoByField('PostId',$postID);
        $post->JiaJing=0;
        $post->PostId=$postID;
        $result = $post->Save();
        if ($result) {
            return 1;
        }else{
            return 2;
        }
    }

    public function PostJiaJing(){
        global $zbp;
        $postID = GetVars('id', 'POST');
        if(!is_numeric($postID)){
            return 4;
        }

        if (!$zbp->CheckRights('root')) {
            return 3;
        }

        $post = new PostExtend();
        $post->LoadInfoByField('PostId',$postID);
        $post->JiaJing=1;
        $post->PostId=$postID;
        $result = $post->Save();
        if ($result) {
            return 1;
        }else{
            return 2;
        }
    }

    public function PostTopqx(){
        global $zbp;
        $postID = GetVars('id', 'POST');
        if(!is_numeric($postID)){
            return 4;
        }

        if (!$zbp->CheckRights('root')) {
            return 3;
        }

        $post = new Post();
        $post->LoadInfoByID($postID);
        $post->IsTop=0;
        $result = $post->Save();
        if ($result) {
            return 1;
        }else{
            return 2;
        }
    }

    public function PostDel(){
        global $zbp;
        $postID = GetVars('id', 'POST');
        if(!is_numeric($postID)){
            return 4;
        }
        $isDel = false;

        if ($zbp->CheckRights('root')) {
            $isDel=true;
        }

        $post = new Post();
        $post->LoadInfoByID($postID);
        $postExtend = new PostExtend();
        $postExtend->LoadInfoByField('PostId',$post->ID);

        if($post->AuthorID==$zbp->user->ID){
            $isDel=true;
        }

        if($isDel){
            $post->Del();
            $postExtend->Del();
            return 1;
        }else{
            return 2;
        }
    }

    public function PostShouCang(){
        global $zbp;
        $postID = GetVars('postid', 'POST');

        if($zbp->pp_plugin_shequ_postIsCollection($postID)){
            return 1;
        }else{
            $pp_plugin_shequ_collection = new pp_plugin_shequ_collection();
            $pp_plugin_shequ_collection->PostId = $postID;
            $pp_plugin_shequ_collection->UserId = $zbp->user->ID;
            $pp_plugin_shequ_collection->PostTime = time();
            $result = $pp_plugin_shequ_collection->Save();
            if($result){
                return 1;
            }else{
                return 2;
            }
        }
    }

    public function PostUnShouCang(){
    global $zbp;
    $postID = GetVars('postid', 'POST');

    if($zbp->pp_plugin_shequ_postIsCollection($postID)){
        $where = array(array('=','coll_PostId',$postID),array('=','coll_UserId',$zbp->user->ID));
        $sql = $zbp->db->sql->Delete($zbp->table['pp_plugin_shequ_collection'],$where,'');
        $result= $zbp->db->Delete($sql);
        if($result){
            return 1;
        }else{
            return 2;
        }
    }else{
        return 1;
    }
}

    public function MessageDelAll(){
        global $zbp;

        $sql=$zbp->db->sql->Delete('pp_plugin_shequ_message', array(array('=','mess_ToUserId',$zbp->user->ID)), null);
        $result = $zbp->db->delete($sql);
        if ($result) {
            return 1;
        }else{
            return 2;
        }
    }

    public function MessageDel(){
        $message = new MessageExtend();
        $message->LoadInfoByID(GetVars('mid', 'POST'));
        if($message->Del()){
            return 1;
        }else{
            return 2;
        }
    }

    public function MemberInsert(){
        global $zbp;

        $zbp->guid = GetGuid();
        $mem = new Member();
        $mem->LoadInfoByField('Name',GetVars('username', 'POST'));
        if($mem->ID>0){
            return 3;
        }

        $guid = GetGuid();
        $mem->Guid = $guid;
        $mem->Level = 3;//1管理员 2网站编辑3作者4协作者5评论者6游客
        $mem->Name = GetVars('username', 'POST');
        $mem->Password = Member::GetPassWordByGuid(GetVars('password', 'POST'), $guid);
        $mem->Alias = GetVars('alias', 'POST');
        $mem->Email=$mem->Name;
        $mem->IP = GetGuestIP();
        $mem->PostTime = time();
        FilterMember($mem);
        $result = $mem->Save();
        if($result || $result==1){
            $memberExtend = new MemberExtend();
            $memberExtend->LoadInfoByField('UserId',$mem->ID);
            $memberExtend->UserId=$mem->ID;
            $memberExtend->UserFeiWen=200; //注册用户默认200飞吻
            $memberExtend->Save();
            return 1;
        }else{
            return 2;
        }
    }

    public function MemberUpdate(){
        global $zbp;
        $mem = new Member();
        $mem->LoadInfoByID($zbp->user->ID);
        $mem->Email = GetVars('email','POST');
        $mem->Alias = GetVars('alias', 'POST');
        $mem->Intro = GetVars('intro', 'POST');

        FilterMember($mem);
        return $mem->Save();
    }

    public function PasswordAlter(){
        global  $zbp;

        $passwordByMd5=Member::GetPassWordByGuid(GetVars('nowpass', 'POST'), $zbp->user->Guid);
        if($zbp->user->Password != $passwordByMd5){
            return 2;
        }
        $mem = new Member();
        $mem->LoadInfoByID($zbp->user->ID);
        $mem->Password = Member::GetPassWordByGuid(GetVars('pass', 'POST'), $zbp->user->Guid);
        return $mem->Save();
    }

    public function PostUpload()
    {
        global $zbp;

        foreach ($_FILES as $key => $value) {
            if ($_FILES[$key]['error'] == 0) {
                if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
                    $upload = new Upload;
                    $upload->Name = $_FILES[$key]['name'];
                    //if (GetVars('auto_rename', 'POST') == 'on' || GetVars('auto_rename', 'POST') == true) {
                        $temp_arr = explode(".", $upload->Name);
                        $file_ext = strtolower(trim(array_pop($temp_arr)));
                        $upload->Name = date("YmdHis") . time() . rand(10000, 99999) . '.' . $file_ext;
                    //}
                    $upload->SourceName = $_FILES[$key]['name'];
                    $upload->MimeType = $_FILES[$key]['type'];
                    $upload->Size = $_FILES[$key]['size'];
                    $upload->AuthorID = $zbp->user->ID;

                    //检查同月重名
                    $d1 = date('Y-m-01', time());
                    $d2 = date('Y-m-d', strtotime(date('Y-m-01', time()) . ' +1 month -1 day'));
                    $d1 = strtotime($d1);
                    $d2 = strtotime($d2);
                    $w = array();
                    $w[] = array('=', 'ul_Name', $upload->Name);
                    $w[] = array('>=', 'ul_PostTime', $d1);
                    $w[] = array('<=', 'ul_PostTime', $d2);
                    $uploads = $zbp->GetUploadList('*', $w);
                    if (count($uploads) > 0) {
                        $zbp->ShowError(28, __FILE__, __LINE__);
                    }

                    if (!$upload->CheckExtName()) {
                        $zbp->ShowError(26, __FILE__, __LINE__);
                    }

                    if (!$upload->CheckSize()) {
                        $zbp->ShowError(27, __FILE__, __LINE__);
                    }

                    $upload->SaveFile($_FILES[$key]['tmp_name']);
                    $upload->Save();

                    return '{"code":"0","msg":"","data":{"src":"'.$upload->Url.'"}}';
                }
            }
        }
    }

    public function uploadlogo()
    {
        global $zbp;

        foreach ($_FILES as $key => $value) {
            if ($_FILES[$key]['error'] == 0) {
                if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
                    $upload = new Upload;
                    $upload->Name = $_FILES[$key]['name'];
                    //if (GetVars('auto_rename', 'POST') == 'on' || GetVars('auto_rename', 'POST') == true) {
                    $temp_arr = explode(".", $upload->Name);
                    $file_ext = strtolower(trim(array_pop($temp_arr)));
                    $upload->Name = date("YmdHis") . time() . rand(10000, 99999) . '.' . $file_ext;
                    //}
                    $upload->SourceName = $_FILES[$key]['name'];
                    $upload->MimeType = $_FILES[$key]['type'];
                    $upload->Size = $_FILES[$key]['size'];
                    $upload->AuthorID = $zbp->user->ID;

                    //检查同月重名
                    $d1 = date('Y-m-01', time());
                    $d2 = date('Y-m-d', strtotime(date('Y-m-01', time()) . ' +1 month -1 day'));
                    $d1 = strtotime($d1);
                    $d2 = strtotime($d2);
                    $w = array();
                    $w[] = array('=', 'ul_Name', $upload->Name);
                    $w[] = array('>=', 'ul_PostTime', $d1);
                    $w[] = array('<=', 'ul_PostTime', $d2);
                    $uploads = $zbp->GetUploadList('*', $w);
                    if (count($uploads) > 0) {
                        $zbp->ShowError(28, __FILE__, __LINE__);
                    }

                    if (!$upload->CheckExtName()) {
                        $zbp->ShowError(26, __FILE__, __LINE__);
                    }

                    if (!$upload->CheckSize()) {
                        $zbp->ShowError(27, __FILE__, __LINE__);
                    }

                    $upload->SaveFile($_FILES[$key]['tmp_name']);
                    $upload->Save();

                    $zbp->Config('pp_plugin_shequ')->logo = $upload->Url;
                    $zbp->SaveConfig('pp_plugin_shequ');
                    return '{"code":"0","msg":"","data":{"src":"'.$upload->Url.'"}}';
                }
            }
        }
    }

    public function UploadUserFace(){
        global $zbp;

        foreach ($_FILES as $key => $value) {
            if ($_FILES[$key]['error'] == 0) {
                if (is_uploaded_file($_FILES[$key]['tmp_name'])) {
                    $upload = new Upload;
                    $upload->Name = $_FILES[$key]['name'];
                    //if (GetVars('auto_rename', 'POST') == 'on' || GetVars('auto_rename', 'POST') == true) {
                    $temp_arr = explode(".", $upload->Name);
                    $file_ext = strtolower(trim(array_pop($temp_arr)));
                    $upload->Name = date("YmdHis") . time() . rand(10000, 99999) . '.' . $file_ext;
                    //}
                    $upload->SourceName = $_FILES[$key]['name'];
                    $upload->MimeType = $_FILES[$key]['type'];
                    $upload->Size = $_FILES[$key]['size'];
                    $upload->AuthorID = $zbp->user->ID;

                    //检查同月重名
                    $d1 = date('Y-m-01', time());
                    $d2 = date('Y-m-d', strtotime(date('Y-m-01', time()) . ' +1 month -1 day'));
                    $d1 = strtotime($d1);
                    $d2 = strtotime($d2);
                    $w = array();
                    $w[] = array('=', 'ul_Name', $upload->Name);
                    $w[] = array('>=', 'ul_PostTime', $d1);
                    $w[] = array('<=', 'ul_PostTime', $d2);
                    $uploads = $zbp->GetUploadList('*', $w);
                    if (count($uploads) > 0) {
                        $zbp->ShowError(28, __FILE__, __LINE__);
                    }

                    if (!$upload->CheckExtName()) {
                        $zbp->ShowError(26, __FILE__, __LINE__);
                    }

                    if (!$upload->CheckSize()) {
                        $zbp->ShowError(27, __FILE__, __LINE__);
                    }

                    $upload->SaveFile($_FILES[$key]['tmp_name']);
                    $upload->Save();

                    $memberExtend = new MemberExtend;
                    $memberExtend->LoadInfoByField('UserId',$zbp->user->ID);
                    $memberExtend->UserId=$zbp->user->ID;
                    $memberExtend->UserFace=$upload->Url;
                    $memberExtend->Save();

                    return '{"code":"0","msg":"","data":{"src":"'.$upload->Url.'"}}';
                }
            }
        }
    }

    public function GoodsAdd(){
        global $zbp;

        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
        $pp_plugin_shequ_goods->Name=GetVars('goodsname', 'POST');
        $pp_plugin_shequ_goods->TypeId=GetVars('goodsType', 'POST');
        $pp_plugin_shequ_goods->Desc=GetVars('desc', 'POST');
        $pp_plugin_shequ_goods->Content=GetVars('content', 'POST');
        $pp_plugin_shequ_goods->PostTime=time();
        $pp_plugin_shequ_goods->Url=GetVars('tiqudizhi', 'POST');
        $pp_plugin_shequ_goods->Tiquma=GetVars('tiquma', 'POST');
        $pp_plugin_shequ_goods->Metas->goodsprice=GetVars('goodsprice', 'POST');
        $pp_plugin_shequ_goods->Metas->goodsprice_cx=GetVars('goodsprice_cx', 'POST');
        $pp_plugin_shequ_goods->Metas->shifoucuxiao=GetVars('shifoucuxiao', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaofenlei=GetVars('cuxiaofenlei', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaoshijian_ks=GetVars('cuxiaoshijian_ks', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaoshijian_js=GetVars('cuxiaoshijian_js', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaoshuliang=GetVars('cuxiaoshuliang', 'POST');
        $pp_plugin_shequ_goods->Metas->goodspic=GetVars('goodspic', 'POST');

        $result = $pp_plugin_shequ_goods->Save();
        if($result){
            return 1;
        }else{
            return 2;
        }
    }

    public function GoodsEdit(){
        global $zbp;

        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
        $pp_plugin_shequ_goods->LoadInfoByID(GetVars('id', 'POST'));

        $pp_plugin_shequ_goods->Name=GetVars('goodsname', 'POST');
        $pp_plugin_shequ_goods->TypeId=GetVars('goodsType', 'POST');
        $pp_plugin_shequ_goods->Desc=GetVars('desc', 'POST');
        $pp_plugin_shequ_goods->Content=GetVars('content', 'POST');
        //$pp_plugin_shequ_goods->PostTime=time();
        $pp_plugin_shequ_goods->Url=GetVars('tiqudizhi', 'POST');
        $pp_plugin_shequ_goods->Tiquma=GetVars('tiquma', 'POST');
        $pp_plugin_shequ_goods->Metas->goodsprice=GetVars('goodsprice', 'POST');
        $pp_plugin_shequ_goods->Metas->goodsprice_cx=GetVars('goodsprice_cx', 'POST');
        $pp_plugin_shequ_goods->Metas->shifoucuxiao=GetVars('shifoucuxiao', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaofenlei=GetVars('cuxiaofenlei', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaoshijian_ks=GetVars('cuxiaoshijian_ks', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaoshijian_js=GetVars('cuxiaoshijian_js', 'POST');
        $pp_plugin_shequ_goods->Metas->cuxiaoshuliang=GetVars('cuxiaoshuliang', 'POST');
        $pp_plugin_shequ_goods->Metas->goodspic=GetVars('goodspic', 'POST');

        $result = $pp_plugin_shequ_goods->Save();
        if($result){
            return 1;
        }else{
            return 2;
        }
    }

    public function GoodsDel(){
        global $zbp;

        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
        $pp_plugin_shequ_goods->LoadInfoByID(GetVars('goodsid', 'POST'));

        $result = $pp_plugin_shequ_goods->Del();
        if($result){
            return 1;
        }else{
            return 2;
        }
    }

    public function GoodsCommentAdd(){
        global $zbp;
        if($zbp->user->ID==0){
            header('location:/shequ/user/login.html');
            die;
        }
        $pp_plugin_shequ_goods_comment = new pp_plugin_shequ_goods_comment();
        $pp_plugin_shequ_goods_comment->Pid=GetVars('pid', 'POST');
        $pp_plugin_shequ_goods_comment->GoodsId=GetVars('goodsid', 'POST');
        $pp_plugin_shequ_goods_comment->Content=GetVars('content', 'POST');
        $pp_plugin_shequ_goods_comment->PostTime=time();
        $pp_plugin_shequ_goods_comment->UserId=$zbp->user->ID;
        $result =$pp_plugin_shequ_goods_comment->Save();

        if($result){
            $this->SendMessage($pp_plugin_shequ_goods_comment);
            return 1;
        }else{
            return 2;
        }
    }

    public function SendMessage($comment){
        global $zbp;

        $matchss =array();
        $pattent = "/@[\w\x{4e00}-\x{9fa5}]{2,10}\s{1}/iu";
        $comment_content = str_replace('&nbsp;',' ',$comment->Content);
        preg_match_all( $pattent, $comment_content, $matchss);
        $w=' 1=2';
        foreach ($matchss[0] as $alias) {
            $alias = trim(str_replace('@','',$alias));
            $w=$w." or mem_Alias='".$alias."'";
        }
        $sql = $zbp->db->sql->Select($zbp->table["Member"], array('*'), $w, null, null, null);
        $memberArr = $zbp->GetListType('Member', $sql);
        $pp_plugin_shequ_goods = new pp_plugin_shequ_goods();
        $pp_plugin_shequ_goods->LoadInfoByID($comment->GoodsId);

        $str_message = '<p>'.$zbp->user->Alias.'在商品<a style="color: #009688;" href="'.$zbp->host.'/shequ/shop/info/'.$pp_plugin_shequ_goods->ID.'.html">'.$pp_plugin_shequ_goods->Name.'</a>中提到了你</p>';

        foreach($memberArr as $member){
            $message = new MessageExtend();
            $message->UserId=0;
            $message->ToUserId=$member->ID;
            $message->Content=$str_message;
            $message->PostTime=Time();

            $message->Save();
        }
    }

    public function GoodsTypeAdd(){
        global $zbp;
        $pp_plugin_shequ_goods_type = new pp_plugin_shequ_goods_type();
        $pp_plugin_shequ_goods_type->Name=GetVars('mingcheng', 'POST');
        $result = $pp_plugin_shequ_goods_type->Save();
        if($result){
            return 1;
        }else{
            return 2;
        }
    }
    public function GoodsTypeEdit(){
        global $zbp;
        $pp_plugin_shequ_goods_type = new pp_plugin_shequ_goods_type();
        $pp_plugin_shequ_goods_type->LoadInfoByID(GetVars('id', 'POST'));
        if($pp_plugin_shequ_goods_type->ID>0) {
            $pp_plugin_shequ_goods_type->Name = GetVars('mingcheng', 'POST');
            $result = $pp_plugin_shequ_goods_type->Save();

            if($result){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 3;
        }

    }

    public function GoodsTypeDel()
    {
        global $zbp;
        $pp_plugin_shequ_goods_type = new pp_plugin_shequ_goods_type();
        $pp_plugin_shequ_goods_type->LoadInfoByID(GetVars('id', 'POST'));
        if($pp_plugin_shequ_goods_type->ID>0) {

            $result = $pp_plugin_shequ_goods_type->Del();

            if($result){
                return 1;
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }
}
?>