<?php

namespace Controller;

class Limit extends Controller {

    function act_list() {
        $limitgroup = \Xcs\DB::findAll('acl_auth_group');
        $newgroups = array();
        if (!empty($limitgroup)) {
            foreach ($limitgroup as $row) {
                $row['childs'] = \Xcs\DB::findAll('acl_auth', '*', array('auth_group_id' => $row['auth_group_id']));
                $newgroups[] = $row;
            }
        }
        include template('admin/limit/list');
    }

    function act_allctl() {
        //获取所有控制器及方法
        $files = \Xcs\Helper\File::list_files(APPPATH . 'Controller/' . APPKEY . '/', false, false);
        $allctls = array();
        $allacts = array();
        $ctlacts = array();
        foreach ($files as $file) {
            $classname = trim(str_replace('.php', '', $file));
            if ('Limit.php' == $file) {
                $class = 'Controller\\' . $classname;
            } else {
                include APPPATH . 'Controller/' . APPKEY . '/' . $file;
                $class = 'Controller\\' . $classname;
                $class = new $class(null, null);
            }
            $methods = get_class_methods($class);
            $classname = 'controller_' . strtolower($classname);

            $_methods = array();
            foreach ($methods as $method) {
                if ('act_' == substr($method, 0, 4)) {
                    $allacts[] = str_replace('act_', $classname . '_', $method);
                    $_methods[] = str_replace('act_', $classname . '_', $method);
                }
            }
            $class = null;
            $allctls[] = $classname; //保存控制器
            $ctlacts[$classname] = $_methods; //保存原有结构
        }

        //dump($ctlacts);
        //dump($allacts,1);

        //清理不存在的控制器
        $ctls = \Xcs\DB::findAll('acl_auth_group', 'auth_group_id,auth_group_name');
        $ctls = \Xcs\Util::array_index($ctls, 'auth_group_name');
        foreach ($ctls as $gkey => $gctl) {
            if (!in_array($gkey, $allctls)) { //如果在控制器中不存在gkey
                \Xcs\DB::remove('acl_auth_group', array('auth_group_id' => $gctl['auth_group_id']));
            }
        }

        //清理不存在的控制器方法
        $acts = \Xcs\DB::findAll('acl_auth', 'auth_id,auth_name');
        $acts = \Xcs\Util::array_index($acts, 'auth_name');
        foreach ($acts as $akey => $aact) {
            if (!in_array($akey, $allacts)) { //如果在方法中不存在akey
                \Xcs\DB::remove('acl_auth', array('auth_id' => $aact['auth_id']));
            }
        }

        //dump($allacts, 1);

        //开始入库
        foreach ($ctlacts as $controller => $actions) {
            $exists = \Xcs\DB::findOne('acl_auth_group', 'auth_group_id', array('auth_group_name' => $controller));
            if (!$exists) {
                $data = array(
                    'auth_group_name' => trim($controller),
                    'aliasname' => '',
                    'need_login' => 1
                );
                $groupid = \Xcs\DB::create('acl_auth_group', $data, true);
                foreach ($actions as $action) {
                    $data = array(
                        'auth_group_id' => $groupid,
                        'auth_name' => trim($action),
                        'aliasname' => ''
                    );
                    \Xcs\DB::create('acl_auth', $data);
                }
            } else {
                $datas = \Xcs\DB::findAll('acl_auth', 'auth_name', array('auth_group_id' => $exists['auth_group_id']));
                $datas = \Xcs\Util::array_index($datas, 'auth_name');
                foreach ($actions as $action) {
                    $action = trim($action);
                    if (empty($datas) || !isset($datas[$action])) {
                        $data = array(
                            'auth_group_id' => $exists['auth_group_id'],
                            'auth_name' => $action,
                            'aliasname' => ''
                        );
                        \Xcs\DB::create('acl_auth', $data);
                    }
                }
            }
        }
        echo '所有控制器矫正完成！';
    }

    function act_ctlaliasupdate() {
        $limit_group_id = getgpc('p.limit_group_id');
        $aliasname = getgpc('p.aliasname');
        $needlogin = getgpc('p.need_login');
        if ($needlogin >= 0) {
            $sql = "UPDATE acl_auth_group SET aliasname='{$aliasname}',need_login = {$needlogin} WHERE auth_group_id={$limit_group_id}";
        } else {
            $sql = "DELETE FROM acl_auth_group WHERE auth_group_id={$limit_group_id}";
            \Xcs\DB::remove('acl_auth', "auth_group_id={$limit_group_id}");
        }
        \Xcs\DB::exec($sql);
        \Xcs\Util::redirect(url('limit/list'));
    }

    function act_actaliasupdate() {
        $limit_id = getgpc('p.limit_id');
        $aliasname = getgpc('p.aliasname');
        $delthis = getgpc('p.delthis');
        if (-1 != $delthis) {
            $sql = "UPDATE acl_auth SET aliasname='{$aliasname}' WHERE auth_id={$limit_id}";
        } else {
            $sql = "DELETE FROM acl_auth WHERE auth_id={$limit_id}";
        }
        \Xcs\DB::exec($sql);
        \Xcs\Util::redirect(url('limit/list'));
    }

    function act_addctl() {
        $row = array(
            'id' => 0,
            'controller' => '',
            'action' => '无',
            'aliasname' => '',
            'disable' => 'action'
        );
        $tip = '创建控制器';
        $posturl = url('limit/createlg');
        include template('admin/limit/edit');
    }

    function act_createlg() {
        $controller = getgpc('p.controller');
        $aliasname = getgpc('p.aliasname');
        $post = array(
            'auth_group_name' => $controller,
            'aliasname' => $aliasname,
            'need_login' => 1,
        );
        \Xcs\DB::create('acl_auth_group', $post);
        $res = array(
            'errcode' => 0,
            'errmsg' => '创建成功'
        );
        \Xcs\Util::rep_send($res);
    }

    function act_addact() {
        $cid = getgpc('g.cid');
        $controller = \Xcs\DB::findOne('acl_auth_group', 'auth_group_name,aliasname', array('auth_group_id' => $cid));
        $row = array(
            'id' => $cid,
            'controller' => $controller['auth_group_name'],
            'action' => $controller['auth_group_name'] . '_',
            'aliasname' => '',
            'disable' => 'controller'
        );
        $tip = '创建控制器动作';
        $posturl = url('limit/createl');
        include template('admin/limit/edit');
    }

    function act_createl() {
        $id = getgpc('p.id');
        $action = getgpc('p.action');
        $aliasname = getgpc('p.aliasname');
        $post = array(
            'auth_group_id' => $id,
            'auth_name' => $action,
            'aliasname' => $aliasname
        );
        \Xcs\DB::create('acl_auth', $post);
        $res = array(
            'errcode' => 0,
            'errmsg' => '创建成功'
        );
        \Xcs\Util::rep_send($res);
    }

}
