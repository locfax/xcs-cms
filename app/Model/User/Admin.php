<?php

namespace Model\User;

//管理员model
class Admin {

    use \Xcs\Traits\Singleton;

    public function get_by_id($uid) {
        return \Xcs\DB::findOne('acl_user', '*', array('uid' => $uid));
    }

    public function get_by_name($username) {
        return \Xcs\DB::findOne('acl_user', '*', array('username' => $username));
    }

    public function get_by_email($email) {
        return \Xcs\DB::findOne('acl_user', '*', array('email' => $email));
    }

    public function get_stats($uid) {
        $status = \Xcs\DB::findOne('acl_user_stats', '*', array('uid' => $uid));
        if (!$status) {
            $post = array(
                'uid' => $uid,
            );
            \Xcs\DB::create('acl_user_stats', $post);
            $status = \Xcs\DB::findOne('acl_user_stats', '*', array('uid' => $uid));
        }
        return $status;
    }

    public function get_roles($uid, $groupid) {
        if (1 == $uid) {
            return 'root';
        }
        $roles = '';
        if ($groupid > 0) {
            $roles = \Xcs\DB::rowset("SELECT ar.role_name FROM acl_group_role agr LEFT JOIN acl_role ar ON agr.role_id = ar.role_id WHERE agr.group_id = {$groupid}", 'role_name');
            if (!empty($roles)) {
                $roles = implode(',', array_keys($roles));
            }
        }
        return $roles;
    }

    public function check_name_format($username) {
        $guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
        $len = strlen($username);
        if ($len > 15 || $len < 2 || preg_match("/\s+|^c:\\con\\con|[%,\*\"\s\<\>\&]|$guestexp/is", $username)) {
            return false;
        }
        return true;
    }

    public function check_email_format($email) {
        return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }

    public function check_uid_ssl($uid) {
        return \Xcs\DB::count('acl_user_ssl', "uid = {$uid}");
    }

    public function check_name_exist($username) {
        return \Xcs\DB::count('acl_user', "username = '{$username}'");
    }

    public function check_email_exist($email, $username = '') {
        $sqladd = ('' !== $username) ? "AND username <> '$username'" : '';
        return \Xcs\DB::count('acl_user', "email = '{$email}' {$sqladd}");
    }

    public function check_login($username, $password) {
        $user = $this->get_by_name($username);
        if (empty($user['username'])) {
            $status = -1;
        } elseif ($user['password'] != topassword($password, $user['salt'])) {
            $status = -2;
        } elseif (1 != $user['status']) {
            $status = -3;
        } else {
            $status = 1;
        }
        return array('errcode' => $status, 'data' => $user);
    }

    public function record_login($uid, $ip) {
        \Xcs\DB::update('acl_user_stats', "lastip ='" . $ip . "',lastactivity = '" . time() . "',loginnum = loginnum +1", "uid = {$uid}");
    }

    public function add_user($post) {
        if (!isset($post['salt']) || !$post['salt']) {
            $post['salt'] = substr(md5(uniqid(rand())), -6);
        }
        $post['password'] = topassword($post['password'], $post['salt']);
        $uid = \Xcs\DB::create('acl_user', $post, true);
        if ($uid) {
            $post = array(
                'uid' => $uid,
                'regip' => \Xcs\Util::clientip()
            );
            \Xcs\DB::create('acl_user_stats', $post);
        }
        return $uid;
    }

    public function edit_user($uid, $post, $oldpw = '', $ignoreoldpw = true, $questionid = null, $answer = '') {
        $data = $this->get_by_id($uid);
        if (!$ignoreoldpw && $data['password'] != topassword($oldpw, $data['salt'])) {
            return 2;
        }
        if (isset($post['password'])) {
            if ($post['password']) {
                if (!$data['salt']) {
                    $post['salt'] = substr(md5(uniqid(rand())), -6);
                } else {
                    $post['salt'] = $data['salt'];
                }
                $post['password'] = topassword($post['password'], $post['salt']);
            } else {
                unset($post['password']);
            }
        }
        if (!is_null($questionid)) {
            $secques = $questionid > 0 ? $this->quescrypt($questionid, $answer) : '';
            $post['secques'] = $secques;
        }
        return \Xcs\DB::update('acl_user', $post, array('uid' => $uid));
    }

    public function del_user($uid) {
        $ret = \Xcs\DB::remove('acl_user', "uid={$uid}");
        if ($ret) {
            \Xcs\DB::remove('acl_user_stats', "uid={$uid}");
        }
        return $ret;
    }

    public function quescrypt($questionid, $answer) {
        return $questionid > 0 && ('' != $answer) ? substr(md5($answer . md5($questionid)), 16, 8) : '';
    }

    public function get_groups() {
        return \Xcs\DB::findAll('acl_group');
    }

    public function get_group($gid) {
        if (!$gid) {
            return 0;
        }
        $ret = \Xcs\DB::findOne('acl_group', '*', array('group_id' => $gid));
        if ($ret) {
            return $ret['group_name'];
        }
        return 0;
    }

}
