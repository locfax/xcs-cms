<?php


/**
 * @param $pass
 * @param $salt
 * @param bool $md5
 * @return string
 */
function topassword($pass, $salt, $md5 = false) {
    if ($md5) {
        return md5($pass . $salt);
    } else {
        return md5(md5($pass) . $salt);
    }
}

/**
 * @param $month
 * @param $day
 * @return string
 */
function getconstellation($month, $day) {
    if ($month < 1 || $month > 12 || $day < 1 || $day > 31) {
        return '';
    }
    $signs = array(
        array('20' => '宝瓶座'),
        array('19' => '双鱼座'),
        array('21' => '白羊座'),
        array('20' => '金牛座'),
        array('21' => '双子座'),
        array('22' => '巨蟹座'),
        array('23' => '狮子座'),
        array('23' => '处女座'),
        array('23' => '天秤座'),
        array('24' => '天蝎座'),
        array('22' => '射手座'),
        array('22' => '摩羯座')
    );
    list($start, $name) = each($signs[$month - 1]);
    if ($day < $start) {
        list($start, $name) = each($signs[($month - 2 < 0) ? 11 : $month - 2]);
    }
    return $name;
}

/**
 * @param $val
 * @return string
 */
function gender($val) {
    if ($val == 1) {
        return '男';
    } elseif ($val == 2) {
        return '女';
    } else {
        return '保密';
    }
}

/**
 * @param $status
 * @return string
 */
function status2str($status) {
    if ($status == 0) {
        return '无效';
    } elseif ($status == 1) {
        return '有效';
    } else {
        return '其它';
    }
}

/**
 * @param $status
 * @return string
 */
function state2str($status) {
    if ($status == 9) {
        return '待审核';
    } elseif ($status == 1) {
        return '有效';
    } elseif ($status == 0) {
        return '无效';
    } else {
        return '其它';
    }
}

/**
 * @param $genre
 * @return string
 */
function genre2str($genre) {
    if (1 == $genre) {
        return '微信服务号';
    } elseif (2 == $genre) {
        return '微信订阅号';
    } elseif (3 == $genre) {
        return '易信服务号';
    } elseif (4 == $genre) {
        return '易信订阅号';
    } else {
        return '未知';
    }
}

/**
 * @param $type
 * @return string
 */
function media2str($type) {
    if ('image' == $type) {
        return '图片';
    } elseif ('voice' == $type) {
        return '语音';
    } elseif ('video' == $type) {
        return '视频';
    } elseif ('thumb' == $type) {
        return '缩略图';
    }
}

/**
 * @param $filesite
 * @param $filepath
 * @return string
 */
function file_url($filesite, $filepath) {
    return getini('file/' . $filesite . '/url') . $filepath;
}

/**
 * @param $filesite
 * @param $filepath
 * @return string
 */
function file_path($filesite, $filepath) {
    return getini('file/' . $filesite . '/dir') . $filepath;
}

/**
 * @param $filesite
 * @param $filepath
 * @param string $prefix
 * @return string
 */
function image_url($filesite, $filepath, $prefix = 'source') {
    if ('source' == $prefix) {
        return getini('file/' . $filesite . '/url') . $filepath;
    } else {
        return getini('file/' . $filesite . '/url') . $filepath . '.' . $prefix . '.jpg';
    }
}

/**
 * @param $data
 * @return mixed|string
 */
function headimg($data) {//前端头像显示
    if (isset($data['head']) && $data['head']) {
        if (\Xcs\Util::strpos($data['head'], 'http')) {
            return $data['head'];
        } else {
            return 'upload/' . $data['head'];
        }
    } elseif (isset($data['headuser']) && $data['headuser']) {
        return 'upload/' . $data['headuser'];
    } elseif (isset($data['headimg']) && $data['headimg']) {
        return str_replace('/0', '/96', $data['headimg']);
    } else {
        return 'assets/img/headimg.jpg';
    }
}

/**
 * @param $data
 * @return mixed|string
 */
function headimginput($data) { //用于头像再次保存
    if (isset($data['head']) && $data['head']) {
        return $data['head'];
    } elseif (isset($data['headuser']) && $data['headuser']) {
        return $data['headuser'];
    } elseif (isset($data['headimg']) && $data['headimg']) {
        return str_replace('/0', '/96', $data['headimg']);
    } else {
        return 'assets/img/headimg.jpg';
    }
}

/**
 * @param $data
 * @return mixed|string
 */
function headimgadmin($data) { //后台头像显示
    if (isset($data['head']) && $data['head']) {
        if (\Xcs\Util::strpos($data['head'], 'http')) {
            return $data['head'];
        } else {
            return '../upload/' . $data['head'];
        }
    } elseif (isset($data['headuser']) && $data['headuser']) {
        return '../upload/' . $data['headuser'];
    } elseif (isset($data['headimg']) && $data['headimg']) {
        return str_replace('/0', '/96', $data['headimg']);
    } else {
        return 'assets/img/headimg.jpg';
    }
}

/**
 * 头像路径
 * @param $uid
 * @return array
 */
function avatar_path($uid) {
    $uid = sprintf("%09d", abs(intval($uid)));
    $dir1 = substr($uid, 0, 3);
    $dir2 = substr($uid, 3, 2);
    $dir3 = substr($uid, 5, 2);
    return array('path' => $dir1 . '/' . $dir2 . '/' . $dir3, 'fix' => substr($uid, -2));
}

/**
 * 多维
 * 移除val为空的项 是空字符不是null
 * @param $arr
 * @param $delval
 * @return  bool|array
 */
function array_remove_value($arr, $delval = '') {
    if (empty($arr)) {
        return false;
    }
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            $arr[$key] = array_remove_value($value);
        } else {
            if ($delval === $value) {
                unset($arr[$key]);
            } else {
                $arr[$key] = $value;
            }
        }
    }
    return $arr;
}

/**
 * @param $id
 * @param bool $decode
 * @return mixed
 */
function hashids($id, $decode = false) {
    $vhash = new \Plugin\Hashids\Hashids();
    if (!$decode) {
        $ret = $vhash->encode($id);
    } else {
        $rets = $vhash->decode($id);
        $ret = $rets[0];
    }
    return $ret;
}

/**
 * @return mixed
 */
function captcha() {
    $captcha = new \Plugin\Captcha\Captcha();
    $captcha->width = 140;
    $captcha->height = 60;
    $captcha->scale = 4;
    $captcha->blur = true;
    $code = $captcha->getText();
    $captcha->CreateImage();
    return $code;
}

/**
 * DZ在线中文分词
 * @param $title string 进行分词的标题
 * @param $content string 进行分词的内容
 * @param $encode string API返回的数据编码
 * @return  string 得到的关键词
 */
function dz_segment($title = '', $content = '', $encode = 'utf-8') {
    if (empty($title)) {
        return '';
    }
    $title = strip_tags(preg_replace("/\[.+?\]/U", '', $title));
    $content = htmlspecialchars(strip_tags(preg_replace("/\[.+?\]/U", '', $content)), ENT_COMPAT);
    //$content = preg_replace("/\{.+?\}/U", '', $content);
    $content = str_replace('•', '', $content);
    if (mb_strlen($title, $encode) > 60) {
        $title = mb_substr($title, 0, 60, $encode);
    }
    if (mb_strlen($content, $encode) > 500) { //在线分词服务有长度限制
        $content = mb_substr($content, 0, 500, $encode);
    }
    $url = 'http://keyword.discuz.com/related_kw.html?title=' . rawurlencode($title) . '&content=' . rawurlencode($content) . '&ics=' . $encode . '&ocs=' . $encode;
    $data = @implode('', file($url));
    if (!$data) {
        return '';
    }
    $xml_array = simplexml_load_string($data); //将XML中的数据,读取到数组对象中
    if (!$xml_array) {
        return '';
    }
    $result = $xml_array->keyword->result;
    $data = '';
    $comma = '';
    foreach ($result->item as $key => $value) {
        $data .= $comma . (string)$value->kw;
        $comma = ',';
    }
    return $data;
}

/**
 * 解密函数
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_decrypt($txt, $key) {
    $txt = passport_key(base64_decode($txt), $key);
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

/**
 * 加密函数
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_encrypt($txt, $key) {
    srand((double)microtime() * 1000000);
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr] . ($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    return base64_encode(passport_key($tmp, $key));
}

/**
 * 编码函数
 * @param $txt
 * @param $encrypt_key
 * @return string
 */
function passport_key($txt, $encrypt_key) {
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}

/**
 * @param $code
 * @param $data
 */
function dblog($code, $data) {
    $post = array(
        'dateline' => time(),
        'logcode' => $code,
        'logmsg' => var_export($data, true)
    );
    \Xcs\DB::dbm('general')->create('weixin_log', $post);
}