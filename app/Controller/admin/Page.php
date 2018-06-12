<?php

namespace Controller;

class Page extends Controller {

    function act_list() {

        $length = 15;
        $totalnum = \Xcs\DB::count('common_page', '1');
        $pageparm = array(
            'shownum' => true,
            'curpage' => getgpc('g.page', 1, 'intval'),
            'totals' => $totalnum,
            'udi' => 'page/list'
        );
        $data = \Xcs\DB::page('common_page', '*', "1 ORDER BY id DESC", $pageparm, $length);
        $rowset = $data['rowsets'];
        $pagebar = $data['pagebar'];

        include template('page/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $row = [
            'id' => 0,
            'title' => '',
            'content' => ''
        ];
        $tip = '新建独立页面';
        $posturl = url('page/save');
        include template('page/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $post = [
            'title' => getgpc('p.title'),
            'content' => getgpc('p.content'),
            'created' => time()
        ];
        $ret = \Xcs\DB::dbm('portal')->create('common_page', $post);
        $res = [
            'errcode' => $ret ? 0 : 1,
            'errmsg' => $ret ? '保存成功' : '保存失败',
            'reload' => 1
        ];
        \Xcs\Util::rep_send($res);
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $id = getgpc('id', 0, 'intval');
        if (!$id) {
            $res = [
                'errcode' => 1,
                'errmsg' => '参数错误'
            ];
            return \Xcs\Util::rep_send($res);
        }
        $row = \Xcs\DB::dbm('portal')->findOne('common_page', '*', ['id' => $id]);
        $tip = '查看/修改 固定页面';
        $posturl = url('page/update');
        include template('page/edit');
    }

    function act_update() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $infoid = getgpc('p.id');
        $post = [
            'title' => getgpc('p.title'),
            'content' => getgpc('p.content'),
            'updated' => time()
        ];
        $ret = \Xcs\DB::dbm('portal')->update('common_page', $post, ['id' => $infoid]);
        $res = [
            'errcode' => $ret ? 0 : 1,
            'errmsg' => $ret ? '更新成功' : '更新失败',
            'reload' => 1
        ];
        \Xcs\Util::rep_send($res);
    }

    function act_remove() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $id = getgpc('g.id');
        if (!$id) {
            $res = [
                'errcode' => 1,
                'errmsg' => '参数错误'
            ];
            return \Xcs\Util::rep_send($res);
        }
        $ret = \Xcs\DB::dbm('portal')->remove('common_page', "id={$id}");
        $res = [
            'errcode' => $ret ? 0 : 1,
            'errmsg' => $ret ? '删除成功' : '删除失败',
            'reload' => 1
        ];
        \Xcs\Util::rep_send($res);
    }

}
