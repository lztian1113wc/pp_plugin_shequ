<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/18
 * Time: 11:12
 */
global $zbp;
$pp_plugin_shequ_post_info = $zbp->db->query($zbp->db->sql->Select(
    $zbp->table['Post'] . ' b left JOIN pp_plugin_shequ_post a ON b.log_ID=a.p_postid LEFT JOIN ' . $zbp->table['Member'] . ' c on b.log_AuthorID=c.mem_ID LEFT JOIN pp_plugin_shequ_user d ON c.mem_ID=d.userid LEFT JOIN ' . $zbp->table['Category'] . ' e ON b.log_CateID = e.cate_ID'
    , 'a.*,b.*,c.*,d.*,e.*'
    , 'b.log_ID=' . $url_parm_arr[3]
    , ''
    , ''
    , ''
));
$pagetitle=$pp_plugin_shequ_post_info[0]["log_Title"];
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/toolbar.php';
?>
<link rel="stylesheet" href="<?php echo $zbp->host; ?>zb_users/plugin/pp_plugin_shequ/res/css/reset.css">

<div class="layui-container">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8 content detail">
            <div class="fly-panel detail-box">
                <h1><?php echo $pp_plugin_shequ_post_info[0]["log_Title"]; ?></h1>
                <div class="fly-detail-info">
                    <?php if ($pp_plugin_shequ_post_info[0]["log_Status"] == 2) { ?>
                        <span class="layui-badge">审核中</span>
                    <?php }; ?>
                    <span class="layui-badge layui-bg-green fly-detail-column"><?php echo $pp_plugin_shequ_post_info[0]["cate_Name"]; ?></span>
                    <?php if ($pp_plugin_shequ_post_info[0]["p_jietie"] == 1) { ?>
                        <span class="layui-badge" style="background-color: #5FB878;">已结</span>
                    <?php } else {
                        ; ?>
                        <span class="layui-badge" style="background-color: #999;">未结</span>
                    <?php }; ?>
                    <?php if ($pp_plugin_shequ_post_info[0]["log_IsTop"] == 2) { ?>
                        <span class="layui-badge layui-bg-black">置顶</span>
                    <?php }; ?>
                    <?php if ($pp_plugin_shequ_post_info[0]["p_jiajing"] == 1) { ?>
                        <span class="layui-badge layui-bg-red">精帖</span>
                    <?php }; ?>
                    <div class="fly-admin-box" data-id="123">
                        <?php if ($zbp->CheckRights("root") || $zbp->user->ID == $pp_plugin_shequ_post_info[0]["log_AuthorID"]) { ?>
                            <span id="L_shanchu" class="layui-btn layui-btn-xs jie-admin" type="del">删除</span>
                        <?php }; ?>
                        <?php if ($zbp->CheckRights("root")) { ?>
                            <?php if ($pp_plugin_shequ_post_info[0]["log_IsTop"] == 2) { ?>
                                <span id="L_qxzhiding" class="layui-btn layui-btn-xs jie-admin" type="set" field="stick" rank="0"
                                      style="background-color:#ccc;">取消置顶</span>
                            <?php } else {
                                ; ?>
                                <span id="L_zhiding" class="layui-btn layui-btn-xs jie-admin" type="set" field="stick"
                                      rank="1">置顶</span>
                            <?php }
                        ; ?>
                            <?php if ($pp_plugin_shequ_post_info[0]["p_jiajing"] == 1) { ?>
                                <span id="L_qxjiajing" class="layui-btn layui-btn-xs jie-admin" type="set" field="status" rank="0"
                                      style="background-color:#ccc;">取消加精</span>
                            <?php } else {
                                ; ?>
                                <span id="L_jiajing" class="layui-btn layui-btn-xs jie-admin" type="set" field="status"
                                      rank="1">加精</span>
                            <?php }; ?>
                        <?php }; ?>
                    </div>
                    <span class="fly-list-nums">
            <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i> <?php if (empty($pp_plugin_shequ_post_info[0]["log_CommNums"])) {
                    echo 0;
                } else {
                    echo $pp_plugin_shequ_post_info[0]["log_CommNums"];
                } ?></a>
            <i class="iconfont" title="人气">&#xe60b;</i> <?php if (empty($pp_plugin_shequ_post_info[0]["log_ViewNums"])) {
                            echo 0;
                        } else {
                            echo $pp_plugin_shequ_post_info[0]["log_ViewNums"];
                        } ?>
          </span>
                </div>
                <div class="detail-about">
                    <a class="fly-avatar" href="/shequ/user/home.html">
                        <img src="<?php
                        if (isset($pp_plugin_shequ_post_info[0]["userface"]) && !empty($pp_plugin_shequ_post_info[0]["userface"])) {
                            echo str_replace('{#ZC_BLOG_HOST#}', $zbp->host, $pp_plugin_shequ_post_info[0]["userface"]);
                        } else {
                            echo $zbp->host . 'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                        } ?>" alt="<?php echo $pp_plugin_shequ_post_info[0]["mem_Alias"]; ?>">
                    </a>
                    <div class="fly-detail-user">
                        <a href="/shequ/user/home.html" class="fly-link">
                            <cite><?php echo $pp_plugin_shequ_post_info[0]["mem_Alias"]; ?></cite>
                            <!--                            <i class="iconfont icon-renzheng" title="认证信息：{{ rows.user.approve }}"></i>-->
                            <?php
                            if (!empty($pp_plugin_shequ_post_info[0]["uservip"]) && $pp_plugin_shequ_post_info[0]["uservip"] > 0) {
                                ?>
                                <i class="layui-badge fly-badge-vip">VIP<?php echo $pp_plugin_shequ_post_info[0]["uservip"]; ?></i>
                            <?php } ?>
                        </a>
                        <span><?php echo date("Y-m-d", $pp_plugin_shequ_post_info[0]["log_PostTime"]); ?></span>
                    </div>
                    <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
                        <span style="padding-right: 10px; color: #FF7200">悬赏：<?php if (empty($pp_plugin_shequ_post_info[0]["p_feiwen"])) {
                                echo 0;
                            } else {
                                echo $pp_plugin_shequ_post_info[0]["p_feiwen"];
                            }; ?>飞吻</span>
                        <?php if ($zbp->user->ID == $pp_plugin_shequ_post_info[0]["log_AuthorID"]) { ?>
                            <span class="layui-btn layui-btn-xs jie-admin" type="edit">
                                <a href="<?php echo $zbp->host;?>shequ/article/edit/<?php echo $pp_plugin_shequ_post_info[0]["log_ID"];?>.html">编辑此贴</a></span>
                        <?php
                            }else{
                                $pp_plugin_shequ_postiscollection = $zbp->pp_plugin_shequ_postIsCollection($pp_plugin_shequ_post_info[0]['log_ID']);
                                if($zbp->user->ID>0 && !$pp_plugin_shequ_postiscollection){
                        ?>
                            <span class="layui-btn layui-btn-xs jie-admin">
                                <a href="javascript:void(0)" id="L_shoucang" data_id="<?php echo $pp_plugin_shequ_post_info[0]['log_ID'];?>">收藏该帖</a></span>
                        <?php
                                }
                                if($zbp->user->ID>0 && $pp_plugin_shequ_postiscollection){
                                    ?>
                                    <span class="layui-btn layui-btn-xs jie-admin">
                                <a href="javascript:void(0)" id="L_unshoucang" data_id="<?php echo $pp_plugin_shequ_post_info[0]['log_ID'];?>">取消收藏</a></span>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="detail-body photos markdown">
                    <?php echo str_replace('{#ZC_BLOG_HOST#}', $zbp->host, $pp_plugin_shequ_post_info[0]["log_Content"]); ?>
                </div>
            </div>

            <div class="fly-panel detail-box" id="flyReply">
                <a name="flyReply"></a>
                <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
                    <legend>回帖</legend>
                </fieldset>
                <?php
                $pp_plugin_shequ_detail_page=1;
                $pp_plugin_shequ_detail_pagesize=15;
                if(count($url_parm_arr)>=5){$pp_plugin_shequ_detail_page=$url_parm_arr[4];}
                $pp_plugin_shequ_detail_comment_count = $zbp->db->query($zbp->db->sql->Select($zbp->table['Comment'] . ' a left join ' . $zbp->table['Member'] . ' b on a.comm_AuthorID=b.mem_ID ' . 'left join pp_plugin_shequ_user c on b.mem_ID=c.userid ' . 'left join pp_plugin_shequ_comment d on d.comm_id=a.comm_ID ', 'count(*)', 'a.comm_LogID=' . $url_parm_arr[3], '', '', ''));
                $pp_plugin_shequ_detail_comment_pagecount = ceil(current($pp_plugin_shequ_detail_comment_count[0])/$pp_plugin_shequ_detail_pagesize);

                $pp_plugin_shequ_comment_info = $zbp->db->query($zbp->db->sql->Select(
                    $zbp->table['Comment'] . ' a left join ' . $zbp->table['Member'] . ' b on a.comm_AuthorID=b.mem_ID '
                    . 'left join pp_plugin_shequ_user c on b.mem_ID=c.userid '
                    . 'left join pp_plugin_shequ_comment d on d.comm_id=a.comm_ID '
                    , 'a.*,b.*,c.*,d.*'
                    , 'a.comm_LogID=' . $url_parm_arr[3]
                    , array('d.comm_caina'<='desc')
                    , array(($pp_plugin_shequ_detail_page-1)*$pp_plugin_shequ_detail_pagesize,$pp_plugin_shequ_detail_pagesize)
                    , ''
                ));

                $pp_plugin_shequ_comment_dianzan_arr = $zbp->db->query($zbp->db->sql->Select(
                    $zbp->table['Post'] . ' p'
                    . ' inner join ' . $zbp->table['Comment'] . ' a on p.log_ID = a.comm_LogID'
                    . ' inner join pp_plugin_shequ_dianzan b on a.comm_ID = b.dz_commid'
                    , '*'
                    , 'p.log_ID=' . $url_parm_arr[3] . ' and b.dz_userid=' . $zbp->user->ID
                    , ''
                    , ''
                    , ''
                ));
                ?>
                <ul class="jieda" id="jieda">
                    <?php foreach ($pp_plugin_shequ_comment_info as $value) { ?>
                        <li data-id="111" class="jieda-daan">
                            <a name="item-1111111111"></a>
                            <div class="detail-about detail-about-reply">
                                <a class="fly-avatar"
                                   href="/shequ/user/home/<?php echo $value["comm_AuthorID"]; ?>.html">
                                    <img src="<?php
                                    if (isset($value["userface"]) && !empty($value["userface"])) {
                                        echo str_replace('{#ZC_BLOG_HOST#}', $zbp->host, $value["userface"]);
                                    } else {
                                        echo $zbp->host . 'zb_users/plugin/pp_plugin_shequ/userface.jpg';
                                    } ?>" alt="<?php echo $value["mem_alias"]; ?>">
                                </a>
                                <div class="fly-detail-user">
                                    <a href="/shequ/user/home/<?php echo $value["comm_AuthorID"]; ?>.html"
                                       class="fly-link">
                                        <cite><?php echo $value["mem_Alias"]; ?></cite>
                                        <!--                                        <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>-->
                                        <?php
                                        if (!empty($value["uservip"]) && $value["uservip"] > 0) {
                                            ?>
                                            <i class="layui-badge fly-badge-vip">VIP<?php echo $value["uservip"]; ?></i>
                                        <?php } ?>
                                    </a>
                                    <?php if ($zbp->CheckRights("root")) { ?>
                                        <span style="color:#5FB878">(管理员)</span>
                                    <?php } else if ($zbp->user->ID == $pp_plugin_shequ_post_info[0]["log_AuthorID"]) {
                                        ; ?>
                                        <span>(楼主)</span>
                                    <?php }; ?>
                                    <!--                                    <span style="color:#FF9E3F">（社区之光）</span>-->
                                    <!--                                    <span style="color:#999">（该号已被封）</span>-->

                                </div>

                                <div class="detail-hits">
                                    <span><?php echo date('Y-m-d', $value["comm_PostTime"]); ?></span>
                                </div>
                                <?php if ($value["comm_caina"] == 1) { ?>
                                    <i class="iconfont icon-caina" title="最佳答案"></i>
                                <?php }; ?>
                            </div>
                            <div class="detail-body jieda-body photos">
                                <?php echo $value["comm_Content"]; ?>
                            </div>
                            <div class="jieda-reply">
                                <span name="L_dianzan" post_id="<?php echo $pp_plugin_shequ_post_info[0]["log_ID"];?>" comm_id="<?php echo $value["comm_ID"];?>" class="jieda-zan" type="zan">
                                    <i class="iconfont icon-zan <?php
                                    foreach ($pp_plugin_shequ_comment_dianzan_arr as $value_zan) {
                                        if ($value_zan["dz_commid"] == $value["comm_ID"]) {
                                            echo 'zanok';
                                        }
                                    }
                                    ?>"></i>
                                    <em><?php if (empty($value["comm_dianzans"])) {
                                            echo 0;
                                        } else {
                                            echo $value["comm_dianzans"];
                                        } ?></em>
                                  </span>
                                <span name="L_huifu" post_id="<?php echo $pp_plugin_shequ_post_info[0]["log_ID"];?>" comm_id="<?php echo $value["comm_ID"];?>" mem_id="<?php echo $value["mem_ID"];?>" mem_alias="<?php echo $value["mem_Alias"];?>" type="reply">
                                    <i class="iconfont icon-svgmoban53"></i>回复
                                </span>
                                <div class="jieda-admin">
                                    <?php
                                        if ($zbp->CheckRights("root") || $zbp->user->ID == $pp_plugin_shequ_post_info[0]["log_AuthorID"]) {
                                            if($pp_plugin_shequ_post_info[0]["p_jietie"]!=1){
                                    ?>
                                        <span name="L_shanchu" post_id="<?php echo $pp_plugin_shequ_post_info[0]["log_ID"];?>" comm_id="<?php echo $value["comm_ID"];?>" type="del">删除</span>
                                        <span name="L_caina" post_id="<?php echo $pp_plugin_shequ_post_info[0]["log_ID"];?>" comm_id="<?php echo $value["comm_ID"];?>" class="jieda-accept" type="accept">采纳</span>
                                    <?php
                                        }};
                                    ?>
                                </div>
                            </div>
                        </li>
                    <?php }; ?>
                    <?php if (empty($pp_plugin_shequ_comment_info)) { ?>
                        <li class="fly-none">消灭零回复</li>
                    <?php }; ?>
                </ul>
                <?php if($pp_plugin_shequ_detail_comment_pagecount>1){?>
                <div id="LAY_page" style="text-align: center">

                    <?php if($pp_plugin_shequ_detail_page>1){?>
                        <a href="<?php echo $zbp->host;?>shequ/article/<?php echo $pp_plugin_shequ_post_info[0]["log_ID"].'/'; echo ($pp_plugin_shequ_detail_page-1);?>.html#flyReply">上一页</a>
                    <?php }else{?>
                        <a href="javascript:void(0)">上一页</a>
                    <?php };?>
                    <?php if($pp_plugin_shequ_detail_page<$pp_plugin_shequ_detail_comment_pagecount){?>
                        <a href="<?php echo $zbp->host;?>shequ/article/<?php echo $pp_plugin_shequ_post_info[0]["log_ID"].'/';echo ($pp_plugin_shequ_detail_page+1);?>.html#flyReply">下一页</a>
                    <?php }else{?>
                        <a href="javascript:void(0)">下一页</a>
                    <?php };?>
                    <span>共<?php echo $pp_plugin_shequ_detail_comment_pagecount; ?>页</span>
                    <span>，当前第<?php echo $pp_plugin_shequ_detail_page; ?>页</span>
                    <hr>
                </div>
                <?php };?>
                <div class="layui-form layui-form-pane">
                    <?php if(!empty($zbp->user->ID)){?>
                    <form id="comment_form">
                        <div class="layui-form-item layui-form-text">
                            <a name="comment"></a>
                            <div class="layui-input-block">
                                <textarea id="L_content" name="content"
                                          placeholder="请输入内容" class="layui-textarea fly-editor"
                                          style="height: 150px;"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <input type="hidden" name="jid" value="123">
                            <input type="button" class="layui-btn" id="tijiaohuifu" value="提交回复"></input>
                        </div>
                    </form>
                    <?php }else{?>
                        <hr/>
                        <p style="text-align: center">
                            <a href="<?php echo $zbp->host?>shequ/user/login.html">登陆</a>后回复
                        </p>
                    <?php };?>
                </div>
            </div>
        </div>
        <?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/jie/right.php'; ?>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['layedit', 'form'], function () {
        var layedit = layui.layedit, form = layui.form;
        layedit.set({uploadImage: {url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=upload'}});
        var edit_index = layedit.build('L_content',{
            tool: ['strong','italic','underline','del','|','left','center','right','link','unlink']
        }); //建立编辑器

        $("#L_shoucang").on('click',function(){
            var loadIndex = layer.load();
            var that = this;
            var postid = $(this).attr("data_id");

            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=postshoucang';
            $.post(url,{postid:postid},function(res){
                if(res==1){
                    window.location.reload();
                    layer.closeAll();
                }else{
                    layer.msg('网络错误',function(){});
                    layer.closeAll();
                    return false;
                }
            })
        })
        $("#L_unshoucang").on('click',function(){
            var loadIndex = layer.load();
            var that = this;
            var postid = $(this).attr("data_id");

            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=postunshoucang';
            $.post(url,{postid:postid},function(res){
                if(res==1){
                    window.location.reload();
                    layer.closeAll();
                }else{
                    layer.msg('网络错误',function(){});
                    layer.closeAll();
                    return false;
                }
            })
        })

        $("span[name=L_caina]").on('click',function(){
            var loadIndex = layer.load();
            var that = this;
            var commId = $(this).attr("comm_id");
            var postId = $(this).attr("post_id");
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=comm_caina';
            layer.confirm('确定要采纳这条评论吗，采纳后会结算飞吻并结贴。',function(index){
                $.post(url,{commId:commId},function(res){
                    if(res==1){
                        window.location.reload();
                        layer.closeAll();
                    }else{
                        layer.msg('网络错误',function(){});
                        layer.closeAll();
                        return false;
                    }
                })
                return false;
            },function(index){
                layer.closeAll();
                return false;
            })
        })
        $("span[name=L_shanchu]").on('click',function(){
            var loadIndex = layer.load();
            var that = this;
            var commId = $(this).attr("comm_id");
            var postId = $(this).attr("post_id");
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=comm_shanchu';
            layer.confirm('确定要删除这条评论吗？',function(index){
                $.post(url,{commId:commId},function(res){

                    if(res==1){
                        $(that).parent().parent().parent().remove();
                        layer.closeAll();
                    }else{
                        layer.msg('删除失败',function(){});
                        layer.closeAll();
                        return false;
                    }


                })
                return false;
            },function(index){
                layer.closeAll();
                return false;
            })
        })
        $("span[name=L_dianzan]").on('click',function(){
            var that = this;
            var commId = $(this).attr("comm_id");
            var postId = $(this).attr("post_id");
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=dianzan';
            $.post(url,{commId:commId,postId:postId},function(res){
                var dianzans = $(that).find('em').text()||0;
                if(res==1){
                    $(that).find('i').addClass("zanok");
                    $(that).find('em').text(parseInt(dianzans)+1);
                    return false;
                }else{
                    $(that).find('i').removeClass("zanok");
                    $(that).find('em').text(parseInt(dianzans)-1);
                    return false;
                }
            })
            return false;
        })

        $("#L_shanchu").on('click',function(){
            var article_id=<?php echo $pp_plugin_shequ_post_info[0]["log_ID"]; ?>;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=articleDel';
            layer.confirm('确定要删除吗？',function(index){
                $.post(url,{id:article_id},function(res){
                    if(res==1){
                        layer.alert('删除成功',function(index){
                            layer.close(index);
                            window.location.href='<?php echo $zbp->host;?>shequ/index.html';
                            return false;
                        })
                    }else{
                        layer.msg('删除失败',function(){});
                        return false;
                    }
                })
                return false;
            },function(index){
                layer.close(index);
                return false;
            })

        })
        $("#L_zhiding").on('click',function(){
            var article_id=<?php echo $pp_plugin_shequ_post_info[0]["log_ID"]; ?>;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=articleTop';
            layer.confirm('确定置顶这篇文章吗？',function(index){
                $.post(url,{id:article_id},function(res){
                    if(res==1){
                        layer.alert('操作成功',function(index){
                            layer.close(index);
                            window.location.reload();
                            return false;
                        })
                    }else{
                        layer.msg('网络错误',function(){});
                        return false;
                    }
                })
                return false;
            },function(index){
                layer.close(index);
                return false;
            })

        })
        $("#L_qxzhiding").on('click',function(){
            var article_id=<?php echo $pp_plugin_shequ_post_info[0]["log_ID"]; ?>;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=articleTopqx';
            layer.confirm('确定取消置顶吗？',function(index){
                $.post(url,{id:article_id},function(res){
                    if(res==1){
                        layer.alert('操作成功',function(index){
                            layer.close(index);
                            window.location.reload();
                            return false;
                        })
                    }else{
                        layer.msg('网络错误',function(){});
                        return false;
                    }
                })
                return false;
            },function(index){
                layer.close(index);
                return false;
            })

        })
        $("#L_jiajing").on('click',function(){
            var article_id=<?php echo $pp_plugin_shequ_post_info[0]["log_ID"]; ?>;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=articlejj';
            layer.confirm('确定加精吗？',function(index){
                $.post(url,{id:article_id},function(res){
                    if(res==1){
                        layer.alert('操作成功',function(index){
                            layer.close(index);
                            window.location.reload();
                            return false;
                        })
                    }else{
                        layer.msg('网络错误',function(){});
                        return false;
                    }
                })
                return false;
            },function(index){
                layer.close(index);
                return false;
            })

        })

        $("#L_qxjiajing").on('click',function(){
            var article_id=<?php echo $pp_plugin_shequ_post_info[0]["log_ID"]; ?>;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=articlejjqx';
            layer.confirm('确定取消加精吗？',function(index){
                $.post(url,{id:article_id},function(res){
                    if(res==1){
                        layer.alert('操作成功',function(index){
                            layer.close(index);
                            window.location.reload();
                            return false;
                        })
                    }else{
                        layer.msg('网络错误',function(){});
                        return false;
                    }
                })
                return false;
            },function(index){
                layer.close(index);
                return false;
            })

        })

        $("#tijiaohuifu").on('click', function () {
            var that = this;
            if (layedit.getText(edit_index).length < 2) {
                layer.msg('评论字数太少了', function () {
                });
                return false;
            } else {
                //禁用按钮
                $(that).addClass("layui-btn-disabled");

                var postid =<?php echo $url_parm_arr[3]; ?>;
                var postkey = "<?php echo md5($zbp->guid . $url_parm_arr[3] . date('Ymdh')); ?>";
                var url = "<?php echo $zbp->host;?>/zb_system/cmd.php?act=cmt&postid=" + postid + "&key=" + postkey;
                $.post(url, {
                    content: layedit.getContent(edit_index)
                }, function () {
                    window.location.reload();
                })
            }
        })

        $("span[name=L_huifu]").on("click",function(){
            var that = this;
            var commId = $(this).attr("comm_id")||0;
            var postId = $(this).attr("post_id");
            var memId = $(this).attr("mem_id");
            var memAlias = $(this).attr("mem_Alias");
            location.href='#comment';
            layedit.setContent(edit_index,"@"+memAlias+"&nbsp;",true);

            //禁用按钮
            $(that).addClass("layui-btn-disabled");

            var postid =<?php echo $url_parm_arr[3]; ?>;
            var postkey = "<?php echo md5($zbp->guid . $url_parm_arr[3] . date('Ymdh')); ?>";
            var url = "<?php echo $zbp->host;?>/zb_system/cmd.php?act=cmt&postid=" + postid + "&key=" + postkey;
            $.post(url, {
                content: layedit.getContent(edit_index),
                replyid:commId
            }, function () {
                window.location.reload();
            })

        })

        ArticleViewNumUpdate();
    });

    function ArticleViewNumUpdate(){
        var article_id=<?php echo $pp_plugin_shequ_post_info[0]["log_ID"]; ?>;
        var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=articleNumUpdate';
        $.post(url,{id:article_id},function(res){})
    }
</script>
