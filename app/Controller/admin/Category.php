<?php

namespace Controller;

class Category extends Controller {

    function act_list() {
        $rowset = \Xcs\DB::findAll('node_category', '*', "1 ORDER BY sortby ASC");
        $rowset['tree'] = \Xcs\Helper\Arrmap::to_tree($rowset, 'catid', 'upid', 'catid');
        $category = \Model\Clips\Category::getInstance();
        $tip = '分类管理';
        include template('category/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            \Xcs\Util::header('http/1.1 404 not found', true, 404);
            return;
        }
        $upid = getgpc('g.id', 0, 'intval');
        $row = array(
            'catid' => 0,
            'upid' => $upid,
            'name' => '',
            'sortby' => 0,
            //'closed' => 1,
            'channel' => 0
        );
        if ($upid) {
            $_row = \Xcs\DB::findOne('node_category', '*', array('catid' => $upid));
            $row = array(
                'catid' => 0,
                'upid' => $upid,
                'name' => '',
                'sortby' => $_row['sortby'],
                //'closed' => $_row['closed'],
                'channel' => 0
            );
        }
        $tip = '增加分类';
        $this->_editClass($row, $tip);
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $catid = getgpc('g.id');
        if (!$catid) {
            return \Xcs\Util::rep_send('参数错误', 'xml');
        }
        $row = \Xcs\DB::findOne('node_category', '*', array('catid' => $catid));
        if (!$row) {
            return \Xcs\Util::rep_send('节点没找到', 'xml');
        }
        $tip = '编辑分类';
        $this->_editClass($row, $tip);
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        //dump($_POST, 1);
        $catid = getgpc('p.catid');
        $name = getgpc('p.name');
        $upid = getgpc('p.upid');
        //$oldupid = getgpc('p.oldupid');
        //$mid = getgpc('p.mid', 1);
        $sort = getgpc('p.sortby', 0, 'intval', true);
        //$closed = getgpc('p.closed');
        $channel = getgpc('p.channel', 0);
        if (!$upid) {
            $upid = 0;
        }
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if ($name == '') {
            $res['errmsg'] = '分类名称不能为空';
            return \Xcs\Util::rep_send($res);
        }
        if (!$catid) {
            $post = array(
                'upid' => $upid,
                // 'mid' => $mid,
                'name' => $name,
                'sortby' => $sort,
                //'closed' => $closed,
                'channel' => $channel
            );
            $ret = \Xcs\DB::create('node_category', $post, true);
            if ($ret) {
                $res['errcode'] = 0;
                $res['errmsg'] = '创建成功';
                $res['reload'] = 1;
            } else {
                $res['errmsg'] = '创建失败';
            }
        } else {
            if ($catid == $upid) {
                $res['errmsg'] = '上级不能是自己';
                return \Xcs\Util::rep_send($res);
            }
            $post = array(
                'upid' => $upid,
                //'mid' => $mid,
                'name' => $name,
                'sortby' => $sort,
                //'closed' => $closed,
                'channel' => $channel
            );
            $ret = \Xcs\DB::update('node_category', $post, array('catid' => $catid));
            if ($ret) {
                $res['errcode'] = 0;
                $res['errmsg'] = '更新成功';
                $res['reload'] = 1;
            } else {
                $res['errmsg'] = '更新失败';
            }
        }
        \Xcs\Util::rep_send($res);
    }

    function act_del() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $catid = getgpc('g.id');
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (empty($catid)) {
            $res['errmsg'] = '参数错误';
            return \Xcs\Util::rep_send($res);
        }
        $subnum = \Xcs\DB::count('node_category', "`upid`={$catid}");
        if ($subnum > 0) {
            $res['errmsg'] = '该目录下有 [ ' . $subnum . ' ] 个子目录，请先转移或删除其子目录';
            return \Xcs\Util::rep_send($res);
        }
        $ret = \Xcs\DB::remove('node_category', 'catid=' . $catid);
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '删除成功';
            $res['reload'] = 1;
        } else {
            $res['errmsg'] = '删除失败';
        }
        \Xcs\Util::rep_send($res);
    }

    function _editClass($row, $tip) {
        $upid = $row['upid'];
        if ($upid > 0) {
            $parent = \Xcs\DB::findOne('node_category', '*', array('catid' => $upid));
            if (!$parent) {
                return \Xcs\Util::rep_send('节点没找到', 'xml');
            }
        } else {
            $parent = array(
                'catid' => 0,
                'name' => '增加一级分类',
            );
        }
        $rowset = \Xcs\DB::findAll('node_category', '*', "1 ORDER BY sortby ASC");
        $rowset['tree'] = \Xcs\Helper\Arrmap::to_tree($rowset, 'catid', 'upid');
        $category = \Model\Clips\Category::getInstance();
        $posturl = url('category/save');
        include template('category/edit');
    }

}
