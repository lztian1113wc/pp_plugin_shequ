<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/23
 * Time: 14:40
 */

class CommentExtend extends Base
{
    /**
     * 构造函数，默认用户设为anonymous
     */
    public function __construct()
    {
        global $zbp;
        parent::__construct($GLOBALS["table"]['pp_plugin_shequ_comment'], $GLOBALS['datainfo']['pp_plugin_shequ_comment'], __CLASS__);

    }
}
?>