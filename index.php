<?php

/**
 * zenrpc服务入口文件
 * @author dogstar
 * @copyright 2012
 */

// 加载框架公共入口类文件
require(dirname(__FILE__).'/ZenWebService.class.php');

//实例化一个Web Server应用实例
ZenWebService::run();
?>
