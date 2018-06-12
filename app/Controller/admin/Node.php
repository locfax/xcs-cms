<?php

namespace Controller;

class Node extends Controller {

    function act_list() {
        $folder = getgpc('folder', 0, 'intval');
        $searchkey = getgpc('kw', '', 'rawurldecode|trim');
        $fid = getgpc('fid', 0, 'intval');
        $orderfield = getgpc('order', 'created');
        $sc = getgpc('sc', 'DESC');
        $length = getgpc('perpage', 18, 'intval');
        switch ($folder) {
            case 1:
                $where = "status = 1";
                break;
            case 2:
                $where = "status = 2";
                break;
            case 3:
                $where = "status = 0";
                break;
            default:
                $where = " status=0 OR status=1";
        }

        if ($searchkey) {
            $where .= " AND subject LIKE '%{$searchkey}%'";
        }
        if ($fid) {
            $where .= " AND fid={$fid}";
        }

        $orderby = "{$orderfield} {$sc}";

        $totalnum = \Xcs\DB::count('node', $where);
        $pageparm = array(
            'shownum' => true,
            'curpage' => getgpc('g.page', 1, 'intval'),
            'totals' => $totalnum,
            'udi' => 'node/list'
        );
        $data = \Xcs\DB::page('node', '*', "{$where} ORDER BY {$orderby}", $pageparm, $length);
        $rowset = $data['rowsets'];
        $pagebar = $data['pagebar'];
        $classes = \Model\Clips\Cache::category_node('category', 0);
        //dump($classes, 1);
        include template('node/list');
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            \Xcs\Util::header('http/1.1 404 not found', true, 404);
            return;
        }
        $fid = getgpc('g.catid', 0);
        $cats = \Model\Clips\Cache::category_node('category', 1);
        $category = \Model\Clips\Category::getInstance();
        //$hash = md5($this->login_uid . $this->login_name . APPKEY . $this->timestamp);
        //索引信息
        $login_user = \Xcs\User::getUser();
        $row = array(
            'tid' => 0,
            'fid' => $fid,
            'subject' => '',
            'dateline' => $this->timestamp,
            'content' => '',
            'commend' => 0,
            'origin' => getini('settings/sitename'),
            'author' => $login_user['name'],
            'status' => 1,
        );

        //保存提交地址
        $tip = '发布信息';
        $posturl = url('node/save');
        include template('node/edit');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
           return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $tid = getgpc('g.tid', 0, 'intval');
        if (!$tid) {
            return \Xcs\Util::js_alert('参数错误', '', url('node/list'));
        }
        //基本信息 来自索引表
        $row = \Xcs\DB::findOne('node', '*', array('tid' => $tid));
        if (!$row) {
            return \Xcs\Util::js_alert('参数错误', '*', url('node/list'));
        }
        //$row['hash'] = $row['hash'] ? $row['hash'] : md5($this->login_uid . $this->login_name . APPKEY . $this->timestamp);
        //分类信息
        $cats = \Model\Clips\Cache::category_node('category', 1);
        $category = \Model\Clips\Category::getInstance();
        //dump($cats, 1);
        //获取附件
        ///$attachs = \Xcs\DB::findAll('node_media', '*', ['tid'=>$tid]);
        $tip = '查看/编辑 信息';
        $posturl = url('node/update');
        include template('node/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            \Xcs\Util::header('http/1.1 404 not found', true, 404);
            return;
        }
        //索引基本信息
        $catid = getgpc('p.fid', 0);
        $subject = mb_substr(getgpc('p.subject'), 0, 200, 'utf-8');
        $status = getgpc('p.status');
        //$origin = getgpc('p.origin');
        //$picid = getgpc('p.picid');
        $message = getgpc('p.content');
        //$tags = getgpc('p.tags');
        //$hash = getgpc('p.hash');
        //$commend = getgpc('p.commend');
        //$attach = \Xcs\DB::findOne('node_media', '*', ['aid'=>$picid]);
        //处理索引信息
        $login_user = \Xcs\User::getUser();
        $post = array(
            'fid' => $catid,
            'userid' => $login_user['uid'],
            'author' => $login_user['name'],
            'subject' => $subject,
            'content' => $message,
            //'tags' => $tags,
            //'thumb' => $attach['filepath'],
            //'hash' => $hash,
            'created' => $this->timestamp,
            //'commend' => $commend,
            // 'origin' => $origin,
            'status' => $status
        );

        $ret = \Xcs\DB::create('node', $post);
        $res = array();
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '创建成功';
            $res['reload'] = 1;
        } else {
            $res['errcode'] = 1;
            $res['errmsg'] = '创建失败';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_update() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        //索引基本信息
        $tid = getgpc('p.tid');
        if (!$tid) {
            return \Xcs\Util::js_alert('参数错误', '', url('node/list'));
        }
        $catid = getgpc('p.fid');
        $subject = mb_substr(getgpc('p.subject'), 0, 200, 'utf-8');
        //$created = getgpc('p.created', time(), 'strtotime');
        $status = getgpc('p.status');
        // $tags = getgpc('p.tags');
        //$oldtags = getgpc('p.oldtags');
        //$picid = getgpc('p.picid');
        //$origin = getgpc('p.origin');
        $message = getgpc('p.content');
        //$commend = getgpc('p.commend');
        //$hash = getgpc('p.hash');
        //$attach = \Xcs\DB::findOne('node_media','*', ['aid'=>$picid]);
        //处理索引数据
        $post = array(
            'fid' => $catid,
            'subject' => $subject,
            //'tags' => $tags,
            'content' => $message,
            //'thumb' => $attach['filepath'],
            //'hash' => $hash,
            //'dateline' => $created,
            //'origin' => $origin,
            // 'commend' => $commend,
            'updated' => $this->timestamp,
            'status' => $status
        );

        $ret = \Xcs\DB::update('node', $post, array('tid' => $tid));
        //附件修改
        //\Xcs\DB::update('node_media', ['tid'=>$tid,'hash'=>''], ['hash'=>$hash]);
        $res = array();
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '更新成功';
        } else {
            $res['errcode'] = 1;
            $res['errmsg'] = '更新失败';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_tovoid() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $tids = getgpc('tid');
        if (!$tids) {
            return \Xcs\Util::js_alert('参数错误', 'history.back(-1)');
        }
        $tids = \Xcs\Util::implode($tids);
        $ret = \Xcs\DB::update('node', array('status' => 0), "`tid` IN({$tids})");
        $res = array();
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '更新成功';
        } else {
            $res['errcode'] = 1;
            $res['errmsg'] = '更新失败';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_backshow() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $tids = getgpc('tid');
        if (!$tids) {
            return \Xcs\Util::js_alert('参数错误', 'history.back(-1)');
        }
        $tids = \Xcs\Util::implode($tids);
        $ret = \Xcs\DB::update('node', array('status' => 1), "`tid` IN({$tids})");
        $res = array();
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '更新成功';
        } else {
            $res['errcode'] = 1;
            $res['errmsg'] = '更新失败';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_del() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $tid = getgpc('tid');
        if (!$tid) {
            return \Xcs\Util::js_alert('参数错误', 'history.back(-1)');
        }
        $tids = \Xcs\Util::implode($tid);
        $ret = \Xcs\DB::remove('node', "`tid` IN( $tids )");
        if ($ret) {
            $errcode = 0;
            $errmsg = '删除成功';
        } else {
            $errcode = 1;
            $errmsg = '删除失败';
        }
        $res = array(
            'errcode' => $errcode,
            'errmsg' => $errmsg,
            'reload' => 1
        );
        \Xcs\Util::rep_send($res);
    }

}
