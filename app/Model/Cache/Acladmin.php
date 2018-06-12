<?php

namespace Model\Cache;

class Acladmin {

    use \Xcs\Traits\Singleton;

    function getdata() {
        $perGroups = \Xcs\DB::findAll('acl_auth_group');

        foreach ($perGroups as $key => $val) {
            $limits = \Xcs\DB::findAll('acl_auth', '*', array('auth_group_id' => $val['auth_group_id']));
            $_limits = array();
            foreach ($limits as $limit) {
                $rows = \Xcs\DB::rowset("SELECT r.role_name FROM acl_role_auth rl LEFT JOIN acl_role r ON rl.role_id = r.role_id WHERE rl.auth_id={$limit['auth_id']}");
                if (!empty($rows)) {
                    $limit['roles'] = $rows;
                } else {
                    $limit['roles'] = null;
                }
                $_limits[] = $limit;
            }
            $perGroups[$key]['limits'] = $_limits;
        }

        // 整理成ACL表的格式
        $ACL = array();
        foreach ($perGroups as $oneGroup) {
            $controllername = strtoupper(str_replace('controller_', '', $oneGroup['auth_group_name']));
            $ACL[$controllername] = array();
            // 不需要验证的控制器
            if (!$oneGroup['need_login']) {
                $ACL[$controllername]['allow'] = 'ACL_EVERYONE';
                continue;
            }
            // 如果need_login字段为1，也就是需要验证
            $ACL[$controllername]['allow'] = 'ACL_HAS_ROLE';
            $ACL[$controllername]['deny'] = 'ACL_NULL';
            foreach ($oneGroup['limits'] as $onePer) {
                $actionname = strtoupper(str_replace($oneGroup['auth_group_name'] . '_', '', $onePer['auth_name']));
                $allow = 'ROOT,' . strtoupper(str_replace('controller_', '', $onePer['auth_name']));
                $deny = 'deny_' . strtoupper(str_replace('controller_', '', $onePer['auth_name']));
                if (isset($onePer['roles']) && is_array($onePer['roles'])) {
                    foreach ($onePer['roles'] as $oneRole) {
                        $allow .= ',' . strtoupper($oneRole['role_name']);
                        $deny .= ',deny_' . strtoupper($oneRole['role_name']);
                    }
                }
                $ACL[$controllername]['actions'][$actionname] = array('allow' => $allow, 'deny' => $deny);
            }
        }
        //dump($AC);
        $data = array();
        foreach ($ACL as $key => $val) {
            $data[$key] = $this->_prepareACL($val);
        }

        return $data;
    }

    /**
     * @param array $rawACL
     *
     * @return array
     */
    private function _prepareACL($rawACL) {
        //init controller
        $ret = $this->_initACL($rawACL);
        //init actions
        $ret['actions'] = array();
        if (isset($rawACL['actions']) && is_array($rawACL['actions']) && !empty($rawACL['actions'])) {
            foreach ($rawACL['actions'] as $rawActionName => $rawActionACL) {
                $ret['actions'][$rawActionName] = $this->_initACL($rawActionACL);
            }
        }
        if (empty($ret['actions'])) {
            unset($ret['actions']);
        }
        return $ret;
    }

    /**
     * @param $ACL
     * @return array
     */
    private function _initACL($ACL) {
        $ret = array();
        $arr = array('allow', 'deny');
        foreach ($arr as $key) {
            do {
                if (!isset($ACL[$key])) {
                    $value = 'ACL_NULL';
                    break;
                }
                if ('ACL_EVERYONE' == $ACL[$key] || 'ACL_HAS_ROLE' == $ACL[$key] || 'ACL_NO_ROLE' == $ACL[$key] || 'ACL_NULL' == $ACL[$key]) {
                    $value = $ACL[$key];
                    break;
                }
                $value = array_map('trim', explode(',', $ACL[$key]));
                if (empty($value)) {
                    $value = 'ACL_NULL';
                }
            } while (false);
            $ret[$key] = $value;
        }
        return $ret;
    }
}