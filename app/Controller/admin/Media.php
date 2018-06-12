<?php

namespace Controller;

class Media extends Controller {

    function act_index() {
        return \Xcs\Util::header('http/1.1 404 not found', true, 404);
    }

    function act_list() {
        //$folder = getgpc('folder', 1, 'intval');
        $searchkey = getgpc('kw', '', 'rawurldecode|trim');
        //$orderfield = getgpc('order');
        //$ordersc = getgpc('sc');
        $length = getgpc('perpage', 18, 'intval');
        $where = 'status=1';
        if ($searchkey) {
            $where .= " AND digest LIKE '%{$searchkey}%'";
        }
        $totalnum = \Xcs\DB::count('node_media', $where);
        $pageparm = array(
            'shownum' => true,
            'curpage' => getgpc('g.page', 1, 'intval'),
            'totals' => $totalnum,
            'udi' => 'media/list'
        );
        $data = \Xcs\DB::page('node_media', '*', "{$where} ORDER BY aid DESC", $pageparm, $length);
        $rowset = $data['rowsets'];
        $pagebar = $data['pagebar'];

        include template('media/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $row = array(
            'digest' => '',
            'idtype' => 'user',
            'itemid' => 0,
            'dir' => 'image',
            'hash' => '',
            'status' => 1
        );
        $posturl = url('attach/upload');
        include template('media/add');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $aid = getgpc('g.aid', 0, 'intval');
        $row = \Xcs\DB::findOne('node_media', '*', array('aid' => $aid));
        //dump($row);
        $posturl = '';
        include template('media/edit');
    }

    function act_del() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $aid = getgpc('g.aid', 0, 'intval');
        $data = \Xcs\DB::findOne('node_media', '*', array('aid' => $aid));
        if (!$data) {
            $res = array(
                'errcode' => 1,
                'errmsg' => '无法删除',
                'reload' => 1
            );
            return \Xcs\Util::rep_send($res);
        }
        $ret = \Xcs\DB::remove('node_media', "aid={$aid}");
        if ($ret) {
            if ('loc' == $data['filesite']) {
                $file = file_path($data['filesite'], $data['filepath']);
                file_exists($file) && unlink($file);
            }
        }
        $res = array(
            'errcode' => $ret ? 0 : 1,
            'errmsg' => $ret ? '删除成功' : '无法删除',
            'reload' => 1
        );
        \Xcs\Util::rep_send($res);
    }

}
