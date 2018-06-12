<?php

namespace Controller;

use \Model\User as mu;

class Admin extends Controller {

    function act_list() {
        $searchtype = getgpc('searchtype', 'username', 'trim');
        $kw = getgpc('kw', '', 'urldecode|trim');
        //$status = getgpc('g.status', 1);
        $where = "1";
        if ($kw) {
            $searchkey = input_char($kw);
            $where .= " AND `{$searchtype}`='{$searchkey}'";
        }
        $kw = output_char($kw);
        $totals = \Xcs\DB::count('acl_user', $where);
        $pageparm = array(
            'shownum' => true,
            'curpage' => getgpc('g.page', 1, 'intval'),
            'totals' => $totals,
            'udi' => 'admin/list'
        );
        $rowset = \Xcs\DB::page('acl_user', '*', "{$where} ORDER BY created DESC", $pageparm, 18);
        $mgroups = new mu\Admin();
        $groups = $mgroups->get_groups();
        include template('admin/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $row = array('username' => '', 'email' => '', 'groupid' => 0, 'memo' => '', 'gender' => '1');
        //所有管理组
        $mgroups = new mu\Admin();
        $groups = $mgroups->get_groups();
        $grouplus = array(
            'group_id' => 0,
            'group_name' => '无',
            'group_text' => '无',
            'depict' => '无'
        );
        array_unshift($groups, $grouplus);

        $tip = '创建管理员';
        $posturl = url('admin/save');
        include template('admin/add');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $uid = getgpc('g.id');
        if (!$uid) {
            return \Xcs\Util::rep_send('参数错误', 'xml');
        }
        $madmin = new mu\Admin();
        $row = $madmin->get_by_id($uid);
        $stats = $madmin->get_stats($uid);
        //所有管理组
        $groups = $madmin->get_groups();
        $grouplus = array(
            'group_id' => 0,
            'group_name' => '无',
            'group_text' => '无',
            'depict' => '无'
        );
        array_unshift($groups, $grouplus);
        $tip = '编辑管理员';
        $posturl = url('admin/update');
        include template('admin/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        $username = getgpc('p.username');
        $password = getgpc('p.password');
        $email = getgpc('p.email');
        $groupid = getgpc('p.groupid');
        $status = getgpc('p.status');
        $memo = getgpc('p.memo', '');

        if (!$password) {
            $res['errmsg'] = '密码不能为空';
            return \Xcs\Util::rep_send($res);
        }

        $madmin = new mu\Admin();
        $chkuser = $madmin->check_name_exist($username);
        if ($chkuser) {
            $res['errmsg'] = '用户名已经存在';
            return \Xcs\Util::rep_send($res);
        }
        $post = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'groupid' => $groupid,
            'status' => $status,
            'memo' => $memo
        );
        $uid = $madmin->add_user($post);
        if (!$uid) {
            $res['errmsg'] = '创建失败';
            return \Xcs\Util::rep_send($res);
        }
        $res['errcode'] = 0;
        $res['errmsg'] = '创建成功';
        $res['reload'] = 1;
        \Xcs\Util::rep_send($res);
    }

    function act_update() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $uid = getgpc('p.uid', 0, 'intval');
        $username = getgpc('p.username');
        $password = getgpc('p.password');
        $email = getgpc('p.email');
        $groupid = getgpc('p.groupid');
        $status = getgpc('p.status');
        $memo = getgpc('p.memo');
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        $madmin = new mu\Admin();
        $chkuser = $madmin->get_by_name($username);
        if ($chkuser && $chkuser['uid'] != $uid) {
            $res['errmsg'] = '用户名已经存在';
            return \Xcs\Util::rep_send($res);
        }
        $isprotected = $madmin->check_uid_ssl($uid);
        $login_user = \Xcs\User::getUser();
        if ($isprotected && $login_user['uid'] != $uid) {
            $res['errmsg'] = '保护帐号,只有本人能操作';
            return \Xcs\Util::rep_send($res);
        }
        $post = array(
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'groupid' => $groupid,
            'status' => $status,
            'memo' => $memo,
            'updated' => time()
        );
        $ret = $madmin->edit_user($uid, $post);
        if (2 === $ret) {
            $errmsg = '旧密码错误';
        } elseif ($ret) {
            $errmsg = '更新成功';
            //$res['reload'] = 1;
        } else {
            $errmsg = '无变动';
        }
        $res['errcode'] = 0;
        $res['errmsg'] = $errmsg;
        return \Xcs\Util::rep_send($res);
    }

    function act_remove() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $uid = getgpc('g.id');
        $madmin = new mu\Admin();
        $isprotected = $madmin->check_uid_ssl($uid);
        if ($isprotected) {
            $res = array(
                'errcode' => 1,
                'errmsg' => '保护帐号,不可删除'
            );
            return \Xcs\Util::rep_send($res);
        }
        $errcode = $madmin->del_user($uid);
        $res = array(
            'errcode' => $errcode,
            'errmsg' => '删除成功',
            'reload' => 1
        );
        \Xcs\Util::rep_send($res);
    }

}
