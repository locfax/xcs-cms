<?php

namespace Controller;

class Login extends Controller
{

    function act_index()
    {
        include template('home/login');
    }

    function act_logining()
    {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }

        $errcode = 1;
        do {
            $username = getgpc('p.login', '', 'trim|addslashes');
            $password = getgpc('p.pass', '', 'trim|addslashes');

            if (empty($username) || empty($password)) {
                $info = '登录失败 - 用户名或密码非法';
                break;
            }
            $madmin = \Model\User\Admin::getInstance();
            //用户信息
            $checklogin = $madmin->check_login($username, $password);
            //dump($checklogin, 1);
            if (-1 === $checklogin['errcode']) {
                $info = "登录失败 - 用户名不存在！";
                break;
            } elseif (-2 === $checklogin['errcode']) {
                $info = "登录失败 - 密码错误！";
                break;
            } elseif (-3 === $checklogin['errcode']) {
                $info = "登录失败 - 账号被锁！";
                break;
            }
            $login = $checklogin['data'];
            $user = array(
                'uid' => $login['uid'],
                'name' => $login['username'],
                'gid' => $login['groupid']
            );
            $roles = $madmin->get_roles($login['uid'], $login['groupid']);
            if (!$roles) {
                $info = '登录失败 - 无权限!';
                break;
            }
            //dump($roles);
            //用户登录数据
            if (!\Xcs\User::setUser('', $user, $roles)) { //7 * 24 * 3600
                $info = '登录失败 - 未知错误!';
                break;
            }
            //用户验证成功，写入当前登录数据
            $madmin->record_login($user['uid'], \Xcs\Util::clientip());
            $errcode = 0;
            $info = '登录中，稍等...';
        } while (false);
        $ret = array('errcode' => $errcode, 'errmsg' => $info);
        \Xcs\Util::rep_send($ret);
    }

    function act_logout()
    {
        \Xcs\User::clearUser();
        \Xcs\Util::redirect(SITEPATH);
    }

    function act_signup()
    {
        include template('login_signup');
    }

    function act_forgot()
    {
        include template('login_forgot');
    }

    function act_captcha()
    {
        captcha();
    }
}
