<?php

$_CFG['cache']['cacher'] = 'file'; //缓存器有：file memcache redis xcache 优先级从前到后
$_CFG['cache']['prefix'] = 'cache_'; //缓存关键字前缀

$_CFG['site']['path'] = substr(SITEPATH, 0, strrpos(SITEPATH, 'admincp'));
$_CFG['site']['url'] = 'http://' . SITEHOST . $_CFG['site']['path'];
$_CFG['site']['charset'] = 'UTF-8'; //页面字符编码
$_CFG['site']['gzip'] = false; //是否启动压缩输出
$_CFG['site']['themes'] = 'default'; //默认皮肤key

$_CFG['site']['defaultController'] = 'login'; //默认控制器
$_CFG['site']['defaultAction'] = 'index'; //默认控制器方法

// 默认存储
$_CFG['file']['site'] = 'loc';

//本地文件存储
$_CFG['file']['loc']['name'] = '本地';
$_CFG['file']['loc']['key'] = 'loc';
$_CFG['file']['loc']['dir'] = realpath('../public/upload') . '/';
$_CFG['file']['loc']['pfix'] = 'yd';
$_CFG['file']['loc']['ffix'] = '';
$_CFG['file']['loc']['url'] = $_CFG['site']['url'] . 'public/upload/';

$_CFG['auth']['handle'] = 'SESSION'; //客户端用户数据保存方式 COOKIE, SESSION
$_CFG['auth']['prefix'] = 'dca_'; //用户数据前缀
$_CFG['auth']['domain'] = ''; // cookie domain
$_CFG['auth']['path'] = '/'; // cookie 作用路径
$_CFG['auth']['key'] = 'dscq7sddEOd35N3ad'; // 加密关键字

$_CFG['weixin']['id'] = 1;
$_CFG['weixin']['vkey'] = 'qxtvrs';

\Xcs\App::mergeVars('cfg', $_CFG); //加入初始化

header("Content-type: text/html; charset=" . $_CFG['site']['charset']);
$_CFG = null;
