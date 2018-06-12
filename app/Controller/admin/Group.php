<?php

namespace Controller;

class Group extends Controller {

    function act_list() {
        $rowset = \Xcs\DB::findAll('acl_group', '*', "1 ORDER BY group_id DESC");
        include template('admin/group/list');
    }

    function act_bind() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $gid = getgpc('g.id');
        $curgroup = \Xcs\DB::findOne('acl_group', '*', array('group_id' => $gid));

        //所有角色列表
        $roles = \Xcs\DB::findAll('acl_role');

        //所选用户组具有的权限
        $curroles = \Xcs\DB::findAll('acl_group_role', '*', array('group_id' => $gid));

        $posturl = url('group/savebind');
        include template('admin/group/bind');
    }

    function act_savebind() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $groupid = getgpc('p.group_id');
        $rolearr = getgpc('p.role');
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (!$groupid) {
            $res['errmsg'] = '参数不存在';
            return \Xcs\Util::rep_send($res);
        }
        \Xcs\DB::remove('acl_group_role', "group_id ={$groupid}"); //删除原来的中间关系
        if ($rolearr) {
            foreach ($rolearr as $key => $val) {
                $is_allow = 0;
                if ('on' == $val) {
                    $is_allow = 1;
                }
                $post = array(
                    'group_id' => $groupid,
                    'role_id' => $key,
                    'is_allow' => $is_allow
                );
                \Xcs\DB::create('acl_group_role', $post);
            }
        }
        $res['errcode'] = 0;
        $res['errmsg'] = '绑定成功';
        return \Xcs\Util::rep_send($res);
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $row = array('group_id' => 0, 'group_text' => '', 'group_name' => '', 'depict' => '', 'available' => 1);
        $tip = '创建管理组';
        $posturl = url('group/save');
        include template('admin/group/edit');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $id = getgpc('g.id');
        if (!$id) {
            return \Xcs\Util::rep_send('参数错误', 'xml');
        }
        $row = \Xcs\DB::findOne('acl_group', '*', array('group_id' => $id));
        $tip = '编辑管理组';
        $posturl = url('group/update');
        include template('admin/group/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $grouptext = getgpc('p.group_text');
        $groupname = getgpc('p.group_name');
        $depict = getgpc('p.depict');
        $available = getgpc('p.available', 1);

        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (empty($groupname)) {
            $res['errmsg'] = '- 组名不能为空';
            return \Xcs\Util::rep_send($res);
        }
        if (empty($depict)) {
            $res['errmsg'] = '- 组描述不能为空';
            return \Xcs\Util::rep_send($res);
        }

        $post = array(
            'group_text' => $grouptext,
            'group_name' => $groupname,
            'depict' => $depict,
            'available' => $available,
        );
        $gid = \Xcs\DB::create('acl_group', $post, true);
        if ($gid) {
            $res['errcode'] = 0;
            $res['reload'] = 1;
            $retmsg = '创建成功';
        } else {
            $retmsg = '创建失败';
        }
        $res['errmsg'] = $retmsg;
        \Xcs\Util::rep_send($res);
    }

    function act_update() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }

        $groupid = getgpc('group_id', 0, 'intval');
        $grouptext = getgpc('p.group_text');
        $groupname = getgpc('p.group_name');
        $depict = getgpc('p.depict');
        $available = getgpc('p.available', 1);

        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (empty($groupname)) {
            $res['errmsg'] = '- 组名不能为空';
            return \Xcs\Util::rep_send($res);
        }
        if (empty($depict)) {
            $res['errmsg'] = '- 组描述不能为空';
            return \Xcs\Util::rep_send($res);
        }

        $post = array(
            'group_text' => $grouptext,
            'group_name' => $groupname,
            'depict' => $depict,
            'available' => $available,
        );
        $ret = \Xcs\DB::update('acl_group', $post, array('group_id' => $groupid));
        if ($ret) {
            $res['errcode'] = 0;
            $retmsg = '修改成功';
        } else {
            $retmsg = '无变动';
        }
        $res['errmsg'] = $retmsg;
        \Xcs\Util::rep_send($res);
    }

    function act_remove() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $groupid = getgpc('g.id');

        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (!$groupid) {
            $res['errmsg'] = '参数错误';
            return \Xcs\Util::rep_send($res);
        }
        $ret = \Xcs\DB::remove('acl_group', "group_id={$groupid}");
        if ($ret) {
            \Xcs\DB::remove('acl_group_role', "group_id={$groupid}");
            $res['errcode'] = 0;
            $retmsg = '删除成功';
        } else {
            $retmsg = '删除失败';
        }
        $res['errmsg'] = $retmsg;
        $res['reload'] = 1;
        \Xcs\Util::rep_send($res);
    }

}
