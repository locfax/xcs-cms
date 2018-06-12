<?php

$_CFG['cache']['cacher'] = 'file'; //缓存器有：file memcache redis xcache 优先级从前到后
$_CFG['cache']['prefix'] = 'cache_'; //缓存关键字前缀

$_CFG['site']['path'] = SITEPATH;
$_CFG['site']['url'] = 'http://' . SITEHOST . SITEPATH;
$_CFG['site']['charset'] = 'UTF-8'; //页面字符编码
$_CFG['site']['gzip'] = false; //是否启动压缩输出
$_CFG['site']['themes'] = 'default';

$_CFG['site']['defaultController'] = 'main'; //默认控制器
$_CFG['site']['defaultAction'] = 'index';

// 默认存储
$_CFG['file']['site'] = 'loc';

//本地文件存储
$_CFG['file']['loc']['name'] = '本地';
$_CFG['file']['loc']['key'] = 'loc';
$_CFG['file']['loc']['dir'] = realpath('./upload') . '/';
$_CFG['file']['loc']['pfix'] = 'yd';
$_CFG['file']['loc']['ffix'] = '';
$_CFG['file']['loc']['url'] = $_CFG['site']['url'] . 'upload/';

$_CFG['auth']['handle'] = 'COOKIE'; //客户端用户数据保存方式 COOKIE, SESSION
$_CFG['auth']['prefix'] = 'cmw_'; //用户数据前缀
$_CFG['auth']['domain'] = ''; // cookie domain
$_CFG['auth']['path'] = '/'; // cookie 作用路径
$_CFG['auth']['key'] = 'webpcdssdscq7sEOd35N3ad'; // cookie加密关键字

$_CFG['weixin']['id'] = 1;
$_CFG['weixin']['vkey'] = 'qxtvrs';

\Xcs\App::mergeVars('cfg', $_CFG); //加入初始化

header("Content-type: text/html; charset=" . $_CFG['site']['charset']);
$_CFG = null;
