<?php

namespace Controller;

class Rank extends Controller {

    function act_list() {
        $rowset = \Xcs\DB::findAll('user_group');
        include template('rank/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $tip = '创建等级';
        $row = array(
            'groupid' => 0,
            'name' => '',
            'balance' => 0,
            'scores' => 0,
            'status' => 1,
        );
        $posturl = url('rank/save');
        include template('rank/edit');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $id = getgpc('g.id');
        if (!$id) {
            return \Xcs\Util::rep_send('参数错误', 'xml');
        }
        $row = \Xcs\DB::findOne('user_group', '*', array('groupid' => $id));

        $tip = '编辑等级';
        $posturl = url('rank/update');
        include template('rank/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $post = array(
            'name' => getgpc('p.name'),
            'balance' => getgpc('p.balance', 0),
            'scores' => getgpc('p.scores', 0),
            'status' => getgpc('p.status', 0),
        );
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        $rankid = \Xcs\DB::create('user_group', $post, true);
        if ($rankid) {
            $res['errcode'] = 0;
            $res['errmsg'] = '创建成功';
            $res['reload'] = 1;
        } else {
            $res['errmsg'] = '创建失败';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_update() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $groupid = getgpc('p.groupid');
        $post = array(
            'name' => getgpc('p.name'),
            'balance' => getgpc('p.balance', 0),
            'scores' => getgpc('p.scores', 0),
            'status' => getgpc('p.status', 1),
        );
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        $ret = \Xcs\DB::update('user_group', $post, array('groupid' => $groupid));
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '更新成功';
            $res['reload'] = 1;
        } else {
            $res['errmsg'] = '无修改';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_remove() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $id = getgpc('g.id');
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (!$id) {
            $res['errmsg'] = '参数错误';
            return \Xcs\Util::rep_send($res);
        }
        $ret = \Xcs\DB::remove('user_group', "groupid={$id}");
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '删除成功';
            $res['reload'] = 1;
        } else {
            $res['errmsg'] = '删除失败';
        }
        \Xcs\Util::rep_send($res);
    }

}
