<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/22
 * Time: 16:02
 */
class MemberExtend extends Base
{
    /**
     * 构造函数，默认用户设为anonymous
     */
    public function __construct()
    {
        global $zbp;
        parent::__construct($GLOBALS["table"]['pp_plugin_shequ_user'], $GLOBALS['datainfo']['pp_plugin_shequ_user'], __CLASS__);

    }
}
?>