<?php
/**
 * Created by PhpStorm.
 * User: wangchuan
 * Date: 2018/5/24
 * Time: 12:59
 */

class MessageExtend extends Base
{
    /**
     * 构造函数，默认用户设为anonymous
     */
    public function __construct()
    {
        global $zbp;
        parent::__construct($GLOBALS["table"]['pp_plugin_shequ_message'], $GLOBALS['datainfo']['pp_plugin_shequ_message'], __CLASS__);

    }
}
?>