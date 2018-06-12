<?php

$_CFG = array();
$_CFG['data']['_cache'] = DATAPATH . 'cache/';
$_CFG['data']['_view'] = DATAPATH . 'tplcache/';
$_CFG['data']['_acl'] = DATAPATH . 'acl/';
$_CFG['data']['lang'] = LIBPATH . 'lang/';
$_CFG['data']['tpldir'] = PSROOT . '/themes/' . APPKEY . '/'; //模板路径
$_CFG['data']['tplrefresh'] = 1; //刷新模板 1 自动刷新 其它不更新

$_CFG['cache']['memcache']['ready'] = 0; //是否启动 memcache
$_CFG['cache']['xcache']['ready'] = 0; //是否启动 xcache
$_CFG['cache']['redis']['ready'] = 0; //是否启动 redis

$_CFG['settings']['imgext'] = 'bmp,png,jpeg,jpg,gif';
$_CFG['settings']['imgmax'] = 4096;
$_CFG['settings']['fileext'] = 'amr,mp3,mp4';
$_CFG['settings']['filemax'] = 10240;
$_CFG['settings']['siteicp'] = '备0001';
$_CFG['settings']['dateformat'] = 'Y-m-d';
$_CFG['settings']['timeformat'] = 'H:i:s';
$_CFG['settings']['timezone'] = 8;