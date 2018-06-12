<?php

//error_reporting(-1);
//ini_set('display_errors', 1);

define('APPKEY', 'web'); //应用关键字 用于识别配置、加载controller 权限验证文件等
define('APPNAME', '社区'); //应用名称

define('PSROOT', __DIR__); //根目录 protected source所在的目录
define('APPDSN', 'portal'); //默认使用的数据库DSN ID
define('DEBUG', true); //debug模式
define('AUTH', false); //是否检验权限 false 不检测权限 / general 普通 有设置权限就检测  没设置就忽略 / strict 严格 必须设置权限
define('ROUTE', true); //是否启动路由功能

require PSROOT . '/vendor/autoload.php';

//预加载自定义函数文件
$preload = array(
    LIBPATH . 'func/web.php', //业务函数
);
\Xcs\App::run($preload);  //启动MVC