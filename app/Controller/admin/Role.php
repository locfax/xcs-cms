<?php

namespace Controller;

class Role extends Controller {

    function act_list() {
        $user = \Xcs\User::getUser();
        $rowset = \Xcs\DB::findAll('acl_role', '*', "1 ORDER BY role_id ASC");
        include template('admin/role/list');
    }

    function act_bind() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $rid = getgpc('g.id');
        $currole = \Xcs\DB::findOne('acl_role', '*', array('role_id' => $rid));

        //所有角色列表
        //所有权限列表
        $limitgroup = \Xcs\DB::findAll('acl_auth_group', '*', array('need_login' => 1));
        $limits = array();
        if (!empty($limitgroup)) {
            foreach ($limitgroup as $row) {
                $row['childs'] = \Xcs\DB::findAll('acl_auth', '*', array('auth_group_id' => $row['auth_group_id']));
                $limits[] = $row;
            }
        }

        //所选角色具有的权限
        $curroles = \Xcs\DB::findAll('acl_role_auth', '*', array('role_id' => $rid));

        $title = '角色绑定权限';
        $posturl = url('role/savebind');
        include template('admin/role/bind');
    }

    function act_savebind() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $roleid = getgpc('role_id');
        $limitarr = getgpc('limit');
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (!$roleid) {
            $res['errmsg'] = '参数不存在';
            return \Xcs\Util::rep_send($res);
        }
        \Xcs\DB::remove('acl_role_auth', "`role_id` ={$roleid}"); //删除原来的中间关系
        if (!$limitarr) {
            $res['errcode'] = 0;
            $res['errmsg'] = '绑定成功';
            return \Xcs\Util::rep_send($res);
        }
        foreach ($limitarr as $key => $val) {
            $is_allow = 0;
            if ('on' == $val) {
                $is_allow = 1;
            }
            $post = array(
                'role_id' => $roleid,
                'auth_id' => $key,
                'is_allow' => $is_allow
            );
            \Xcs\DB::create('acl_role_auth', $post);
        }

        $res['errcode'] = 0;
        $res['errmsg'] = '绑定成功';
        return \Xcs\Util::rep_send($res);
    }

    function act_add() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $row = array('role_id' => 0, 'role_text' => '', 'role_name' => '', 'depict' => '', 'available' => 1);
        $tip = '创建角色';
        $posturl = url('role/save');
        include template('admin/role/edit');
    }

    function act_edit() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $id = getgpc('g.id');
        if (!$id) {
            return \Xcs\Util::rep_send('参数错误', 'xml');
        }
        $row = \Xcs\DB::findOne('acl_role', '*', array('role_id' => $id));
        $tip = '编辑角色';
        $posturl = url('role/update');
        include template('admin/role/edit');
    }

    function act_save() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $roletext = getgpc('p.role_text');
        $rolename = getgpc('p.role_name');
        $depict = getgpc('p.depict');
        $available = getgpc('p.available');

        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (empty($rolename)) {
            $res['errmsg'] = '- 角色不能为空';
            return \Xcs\Util::rep_send($res);
        }
        if (empty($depict)) {
            $res['errmsg'] = '- 角色描述不能为空';
            return \Xcs\Util::rep_send($res);
        }

        $post = array(
            'role_text' => $roletext,
            'role_name' => $rolename,
            'depict' => $depict,
            'available' => $available
        );
        $rid = \Xcs\DB::create('acl_role', $post, true);
        if ($rid) {
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

        $roleid = getgpc('role_id', 0, 'intval');
        $roletext = getgpc('p.role_text');
        $rolename = getgpc('p.role_name');
        $depict = getgpc('p.depict');
        $available = getgpc('p.available');

        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (empty($roletext)) {
            $res['errmsg'] = '- 角色不能为空';
            return \Xcs\Util::rep_send($res);
        }
        if (empty($depict)) {
            $res['errmsg'] = '- 角色描述不能为空';
            return \Xcs\Util::rep_send($res);
        }
        $post = array(
            'role_text' => $roletext,
            'role_name' => $rolename,
            'depict' => $depict,
            'available' => $available
        );
        $ret = \Xcs\DB::update('acl_role', $post, array('role_id' => $roleid));
        if ($ret) {
            $res['errcode'] = 0;
            $res['errmsg'] = '修改成功';
        } else {
            $res['errmsg'] = '无变动';
        }
        \Xcs\Util::rep_send($res);
    }

    function act_remove() {
        if (\Xcs\App::isAjax(false)) {
            return \Xcs\Util::header('http/1.1 404 not found', true, 404);
        }
        $roleid = getgpc('g.id');
        $res = array(
            'errcode' => 1,
            'errmsg' => ''
        );
        if (!$roleid) {
            $res['errmsg'] = '参数错误';
            return \Xcs\Util::rep_send($res);
        }
        $ret = \Xcs\DB::remove('acl_role', "role_id={$roleid}");
        if ($ret) {
            \Xcs\DB::remove('acl_role_auth', "role_id={$roleid}");
            $res['errcode'] = 0;
            $res['errmsg'] = '删除成功';
            $res['reload'] = 1;
        } else {
            $res['errmsg'] = '删除失败';
        }
        \Xcs\Util::rep_send($res);
    }

}
