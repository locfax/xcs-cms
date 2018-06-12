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
 * @param $filesite
 * @param $filepath
 * @return string
 */
function file_path($filesite, $filepath) {
    return getini('file/' . $filesite . '/dir') . $filepath;
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
function captcha(){
    $captcha = new \Plugin\Captcha\Captcha();
    $captcha->width = 140;
    $captcha->height = 60;
    $captcha->scale = 4;
    $captcha->blur = true;
    $code = $captcha->getText();
    $captcha -> CreateImage();
    return $code;
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