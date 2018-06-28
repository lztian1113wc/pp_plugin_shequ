<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/15
 * Time: 15:53
 */

global $zbp;
$pagetitle='zblog插件库';
require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/header.php';
?>
<link rel="stylesheet" href="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/res/css/shop.css">
<div class="layui-container fly-marginTop">
    <div class="fly-panel">
        <div class="fly-none">
            <?php
            $p = new pp_plugin_shequ_pagebar('{%host%}shequ/shop/index/{%page%}.html', false);
            $p->PageCount = 20;//$zbp->managecount;
            $p->PageNow = count($url_parm_arr)==5?$url_parm_arr[4]:1;
            $p->PageBarCount = $zbp->pagebarcount;

            $sql = $zbp->db->sql->select(
                $zbp->table['pp_plugin_shequ_goods']
                ,'*'
                ,''
                ,'goods_posttime desc'
                ,array(($p->PageNow - 1) * $p->PageCount, $p->PageCount)
                ,array('pagebar' => $p)
            );
            ?>
            <ul class="shequ-shop-index-ul">
                <?php foreach($zbp->pp_plugin_shequ_getgoodslist($sql) as $goods){?>
                <li>
                    <a href="<?php echo $zbp->host.'shequ/shop/info/'.$goods->ID.'.html';?>" title="查看详情">
                        <img src="<?php echo $goods->Metas->goodspic;?>">
                    </a>
                    <p><?php echo $goods->Name;?></p>
                    <div>
                        <span class="yj">原价<?php echo $goods->Metas->goodsprice;?></span>
                        <?php if($goods->Metas->shifoucuxiao=='on'){?>
                        <span class="xj">促销价<?php echo $goods->Metas->goodsprice_cx;?></span>
                        <?php };?>
                        <a href="<?php echo $zbp->host;?>zb_users/plugin/pp_plugin_shequ/html/user/cmd.php?act=buyGoods&goodsid=<?php echo $goods->ID;?>" class="layui-btn layui-btn-xs">立即购买</a>
                    </div>
                </li>
                <?php };?>
            </ul>
            <?php
            echo '<hr/><p class="pagebar">';
            foreach ($p->Buttons as $key => $value) {
                if ($p->PageNow == $key) {
                    echo '<span class="now-page">' . $key . '</span>&nbsp;&nbsp;';
                } else {
                    echo '<a href="' . $value . '">' . $key . '</a>&nbsp;&nbsp;';
                }
            }
            echo '</p>';
            ?>
        </div>
    </div>
</div>

<?php require ZBP_PATH . 'zb_users/plugin/pp_plugin_shequ/html/footer.php';?>


