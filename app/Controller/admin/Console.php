<?php

namespace Controller;

class Console extends Controller
{

    function act_index()
    {
        $user = \Xcs\User::getUser();

        $sidemenu = array(
            array(
                'menu' => array('iconfont' => '&#xe616;', 'name' => '信息管理'),
                'subs' => array(
                    array('ctl' => 'node', 'act' => 'list', 'name' => '信息列表'),
                    array('ctl' => 'category', 'act' => 'list', 'name' => '信息分类'),
                    array('ctl' => 'media', 'act' => 'list', 'name' => '媒体文件'),
                ),
                'close' => false
            ),
            array(
                'menu' => array('iconfont' => '&#xe60d;', 'name' => '用户管理'),
                'subs' => array(
                    array('ctl' => 'userm', 'act' => 'list', 'name' => '用户列表'),
                    array('ctl' => 'rank', 'act' => 'list', 'name' => '用户等级'),
                ),
                'close' => false
            ),
            array(
                'menu' => array('iconfont' => '&#xe61d;', 'name' => '系统管理'),
                'subs' => array(
                    array('ctl' => 'admin', 'act' => 'list', 'name' => '权限管理'),
                    array('ctl' => 'cache', 'act' => 'set', 'name' => '缓存管理'),
                    array('ctl' => 'page', 'act' => 'list', 'name' => '独立页面'),
                ),
                'close' => true
            ),
        );
        include template('home/index');
    }

    function act_env()
    {
        $user = \Xcs\User::getUser();
        $userstat = \Model\User\Admin::getInstance()->get_stats($user['uid']);
        //dump($userstat);
        $ver_info = gd_info();
        preg_match('/\d/', $ver_info['GD Version'], $match);
        $gdversion = $match[0];
        $server_info = array(
            '操作系统' => PHP_OS,
            '运行环境' => getgpc("s.SERVER_SOFTWARE"),
            '运行方式' => php_sapi_name(),
            'PHP版本' => PHP_VERSION,
            //"MYSQL" => \Xcs\DB::version(),
            '缓存方式' => getini('cache/cacher'),
            'Zlib支持' => function_exists('gzclose') ? '支持' : '禁止',
            '时区' => date_default_timezone_get(),
            'socket' => function_exists('fsockopen') ? '支持' : '禁止',
            '安全模式' => (boolean)ini_get('safe_mode') ? '是' : '否',
            '安全模式GID' => (boolean)ini_get('safe_mode_gid') ? '是' : '否',
            '被禁用函数' => ini_get('disable_functions'),
            '允许上传' => ini_get('file_uploads') ? '支持' : '禁止',
            '上传最大' => ini_get('upload_max_filesize'),
            '同时上传' => ini_get('max_file_uploads') . '个',
            'GD' => 'GD' . $gdversion,
            '执行最大' => ini_get('max_execution_time') . '秒',
            '系统时间' => dgmdate(time(), "H:i:s"),
            '域名/外IP/内IP' => getgpc('s.SERVER_NAME') . ' [ ' . gethostbyname(getgpc('s.SERVER_NAME')) . ' ] [' . getgpc('s.SERVER_ADDR') . ']',
            //'剩余空间' => round((disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '客户端Ip' => \Xcs\Util::clientip(),
            'PID' => getmypid()
        );
        include template('home/env');
    }

}
