<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/24
 * Time: 16:43
 */
global $zbp;
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
?>

<div class="layui-container fly-marginTop">
    <div class="fly-panel" pad20 style="padding-top: 5px;">
        <!--<div class="fly-none">没有权限</div>-->
        <div class="layui-form layui-form-pane">
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title">
                    <li class="layui-this">发表新帖<!-- 编辑帖子 --></li>
                </ul>
                <?php
                $pp_plugin_shequ_category_arr = $zbp->GetListType('Category',$zbp->db->sql->Select(
                    $zbp->table['Category'], '*', null, null, null, null
                ));
                ?>
                <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <form action="" method="post">
                            <div class="layui-row layui-col-space15 layui-form-item">
                                <div class="layui-col-md3">
                                    <label class="layui-form-label">所在专栏</label>
                                    <div class="layui-input-block">
                                        <select lay-verify="required" name="class" lay-filter="column">
                                            <option></option>

                                            <?php foreach ($pp_plugin_shequ_category_arr as $category) {?>
                                            <option value="<?php echo $category->ID;?>"><?php echo $category->Name;?></option>
                                            <?php };?>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-col-md9">
                                    <label for="L_title" class="layui-form-label">标题</label>
                                    <div class="layui-input-block">
                                        <input type="text" id="L_title" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                                        <!-- <input type="hidden" name="id" value="{{d.edit.id}}"> -->
                                    </div>
                                </div>
                            </div>

                            <div class="layui-form-item layui-form-text">
                                <div class="layui-input-block">
                                    <textarea id="L_content" name="content" placeholder="详细描述" class="layui-textarea fly-editor" style="height: 260px;"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-inline">
                                    <label class="layui-form-label">悬赏飞吻</label>
                                    <div class="layui-input-inline" style="width: 190px;">
                                        <select name="experience">
                                            <option value="5">5</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            <option value="60">100</option>
                                            <option value="80">200</option>
                                        </select>
                                    </div>
                                    <div class="layui-form-mid layui-word-aux">发表后无法更改飞吻</div>
                                </div>
                            </div>
<!--                            <div class="layui-form-item">-->
<!--                                <label for="L_vercode" class="layui-form-label">人类验证</label>-->
<!--                                <div class="layui-input-inline">-->
<!--                                    <input type="text" id="L_vercode" name="vercode" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">-->
<!--                                </div>-->
<!--                                <div class="layui-form-mid">-->
<!--                                    <span style="color: #c00;">1+1=?</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="layui-form-item">
                                <button class="layui-btn" lay-filter="fatie" lay-submit>立即发布</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php'; ?>
<script>
    layui.use(['form','layedit'],function(){
        var form=layui.form,layedit = layui.layedit;
        layedit.set({uploadImage: {url: '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=upload'}});
        var editIndex=layedit.build('L_content'); //建立编辑器
        form.on('submit(fatie)',function(data){
            var content = layedit.getContent(editIndex);
            if (content.length<5){
                layer.msg('帖子内容不能少于5个字符',function(){});
                return false;
            }
            data.field.content = content;
            var url = '<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=fatie';
            $.post(url,data.field,function(res){
                if(res==1){
                    layer.alert('发布成功',function(){
                        window.location.href='<?php echo $zbp->host;?>shequ/index.html'
                    });
                }else if(res==3){
                    layer.msg('飞吻不足，无法发帖。',function(){});
                    return false;
                }
                else{
                    layer.msg('网络错误',function(){});
                    return false;
                }
            })
            return false;
        })
    })
</script>
