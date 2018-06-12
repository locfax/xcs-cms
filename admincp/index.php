<?php

//error_reporting(-1);
//ini_set('display_errors', 1);

define('APPKEY', 'admin'); //应用关键字 用于识别配置、加载controller 权限验证文件等
define('APPNAME', '管理平台'); //应用名称

define('PSROOT', dirname(__DIR__)); //根目录 protected source所在的目录
define('APPDSN', 'general'); //重要!!默认使用的数据库DSNID
define('DEBUG', true); // debug模式 true显示完整信息 false隐藏部分显示
define('AUTH', 'general'); //是否检验权限 false 不检测权限 / general 普通 有设置权限就检测  没设置就忽略 通常用于后台 / strict 严格 必须设置权限 用于后台  默认不检查
define('ROUTE', false); //是否启动路由功能

require PSROOT . '/vendor/autoload.php'; //框架

//预加载自定义函数文件
$preload = array(
    LIBPATH . 'func/function.php', //业务函数
);
\Xcs\App::run($preload); //启动MVC