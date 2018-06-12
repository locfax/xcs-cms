<?php

namespace Controller;

use \Model\User as mu;

//标准用户
class Userm extends Controller {

    function act_list() {
        $status = getgpc('g.status', 2);
        if ($status == 2) {
            $where = "(status=1 OR status=0)";
        } else {
            $where = "status={$status}";
        }
        $searchtype = getgpc('searchtype', 'mob', 'trim');
        $searchkey = getgpc('searchkey', '', 'urldecode|trim');

        if (in_array($searchtype, array('email', 'username', 'mob')) && $searchkey) {
            $where .= ' AND `' . $searchtype . "`='{$searchkey}'";
        }
        $totalnum = \Xcs\DB::count('user', $where);
        $pageparm = array(
            'shownum' => true,
            'curpage' => getgpc('g.page', 1, 'intval'),
            'totals' => $totalnum,
            'udi' => 'userm/list',
            'param' => "&searchtype={$searchtype}&searchkey=" . urlencode($searchkey)
        );
        //dump($pageparm);
        $data = \Xcs\DB::page('user', '*', "{$where} ORDER BY created DESC", $pageparm, 18);
        $rowset = $data['rowsets'];
        $pagebar = $data['pagebar'];
        include template('userm/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $row = array(
            'uid' => 0,
            //'nickname' => '',
            'username' => '',
            'gender' => '1',
            'salt' => '',
            'email' => '',
            'groupid' => 0,
            'memo' => '',
            'name' => '',
            'mob' => '',
            'phone' => '',
            'status' => 1,
            'created' => 0,
            'updated' => 0,
            'profile' => array(
                //'mobloc' => '',
                'birthyear' => '',
                'birthmon' => '',
                'birthday' => '',
            )
        );

        $userm = mu\Member::getInstance();
        $groups = $userm->groups();

        $tip = '创建用户';
        $posturl = url('userm/save');
        include template('userm/edit');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $uid = getgpc('g.id', 0, 'intval');
        if (!$uid) {
            return \Xcs\Util::rep_send('参数错误', 'xml');
        }
        $userm = mu\Member::getInstance();
        $row = $userm->get_by_id($uid);
        $row['profile'] = $userm->get_profile($uid);
        //dump($row, 1);
        $groups = $userm->groups();
        $tip = '编辑用户';
        $posturl = url('userm/update');
        include template('userm/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        $post = getgpc('p.data');
        $post['created'] = $this->timestamp;
        $password = getgpc('p.password', '', 'trim');
        $post['password'] = $password;
        $muser = mu\Member::getInstance();
        $chkusername = $muser->check_name_exist($post['username']);
        if ($chkusername) {
            $res['errmsg'] = '用户名已经存在';
            return \Xcs\Util::rep_send($res);
        }
        $profile = getgpc('p.profile');
        $uid = $muser->add_user($post, $profile);
        $res = array(
            'errcode' => $uid,
            'errmsg' => $uid ? '创建成功' : '创建失败',
            'reload' => 1
        );
        \Xcs\Util::rep_send($res);
    }

    function act_update() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        $uid = getgpc('p.id', 0, 'intval');
        $post = getgpc('p.data');
        $post['updated'] = $this->timestamp;
        $post['password'] = getgpc('p.password', '', 'trim');
        $muser = mu\Member::getInstance();
        $chkuser = $muser->get_by_name($post['username']);
        if ($chkuser && $chkuser['uid'] != $uid) {
            $res['errmsg'] = '用户名已经存在';
            return \Xcs\Util::rep_send($res);
        }
        $profile = getgpc('p.profile');
        $ret = $muser->edit_user($uid, $post, $profile);
        $res = array(
            'errcode' => 0,
            'errmsg' => $ret ? '更新成功' : '无变动',
            'reload' => 1
        );
        \Xcs\Util::rep_send($res);
    }

    function act_remove() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $uid = getgpc('g.id', 0, 'intval');
        $muser = mu\Member::getInstance();
        $ret = $muser->del_user($uid);
        $res = array(
            'errcode' => 0,
            'errmsg' => '删除成功',
            'reload' => 1
        );
        \Xcs\Util::rep_send($res);
    }

    function act_checkmob() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $uid = getgpc('g.uid', 0, 'intval');
        $mob = getgpc('g.mob', '', 'urldecode');
        if (!$mob) {
            $res = array(
                'errcode' => 1,
                'errmsg' => '',
                'data' => array('mob' => $mob, 'addr' => '')
            );
            return \Xcs\Util::rep_send($res);
        }
        if ($uid > 0) {
            $count = \Xcs\DB::count('user', "mob='{$mob}' AND uid<>{$uid}");
        } else {
            $count = \Xcs\DB::count('user', "mob='{$mob}'");
        }
        $mobinfo = \Plugin\Api\MobInfo::getInstance()->get($mob);
        if ($mobinfo['errcode']) {
            $addmsg = '，' . $mobinfo['errmsg'];
            $addr = '';
        } else {
            $addmsg = '';
            $addr = $mobinfo['errmsg'];
        }
        $errcode = 0;
        $errmsg = '可用';
        if ($count) {
            $errcode = 1;
            $errmsg = '电话已经存在了';
        }
        $res = array(
            'errcode' => $errcode,
            'errmsg' => $errmsg . $addmsg,
            'data' => array(
                'mob' => $mob,
                'addr' => $addr
            )
        );

        \Xcs\Util::rep_send($res);
    }

}
