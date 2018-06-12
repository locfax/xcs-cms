<?php

namespace Controller;

class Attach extends Controller {

    function act_upload() {
        $idtype = getgpc('type', '-', 'trim');
        $itemid = getgpc('id', 0, 'intval');
        $digest = getgpc('digest', '', 'strip_tags|trim');
        $path = getgpc('dir', 'image', 'trim');
        $hash = getgpc('hash', '', 'trim');

        $upload = \Model\File\LocFile::getInstance();
        if ($path == 'image') {
            $check = $upload->check('imgFile');
        } else {
            $check = $upload->check('attachFile');
            $check['path'] = 'media';
        }
        if ($check['flag']) {
            $filesite = $check['filesite'];
            $upinfo = $upload->upload($check); //上传文件
            $upflag = $upinfo['flag'];
            $filepath = $upinfo['filepath']; //上传后的储存地址
            if ('loc' == getini("file/{$filesite}/key")) {
                //如果是本地存储
                if ($upflag) {
                    $url = getini("file/{$filesite}/url") . $filepath;
                } else {
                    $url = '';
                }
            } else {
                if ($upflag) {
                    $url = getini("file/{$filesite}/url") . $filepath;
                } else {
                    $url = '';
                }
            }
            $login_user = \Xcs\User::getUser();
            //入库记录
            $data = array(
                'idtype' => $idtype,
                'itemid' => $itemid,
                'digest' => $digest ?: $upinfo['sourcename'],
                'filesite' => $filesite,
                'filepath' => $filepath,
                'isimage' => $check['isimage'],
                'created' => $this->timestamp,
                'hash' => $hash,
                'userid' => $login_user['uid']
            );
            $upflag && \Xcs\DB::create('node_media', $data);
            if ('editor' == $idtype) {
                $array = array(
                    'error' => $upflag ? 0 : 1,
                    'message' => $upflag ? '上传成功' : '上传失败1',
                    'url' => $url
                );
            } else {
                $array = array(
                    'errcode' => $upflag ? 0 : 1,
                    'errmsg' => $upflag ? '上传成功' : '上传失败2',
                    'fs' => $filesite,
                    'path' => $filepath,
                    'url' => $url
                );
            }
            $upload = null;
            \Xcs\Util::rep_send($array);
        } else {
            if ('editor' == $idtype) {
                $array = array(
                    'error' => 1,
                    'message' => '上传失败3'
                );
            } else {
                $array = array(
                    "errcode" => 1,
                    "errmsg" => $check['msg'],
                    'fs' => '',
                    "path" => "",
                    "url" => ""
                );
            }
            $upload = null;
            \Xcs\Util::rep_send($array);
        }
    }

    function act_chunk() {
        \Xcs\Util::output_nocache();
        set_time_limit(5 * 60);

        $targetDir = getini('file/' . getini('settings/filesite') . '/dir') . "dump";
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        if (!is_dir($targetDir)) {
            mkdir($targetDir, DIR_WRITE_MODE);
        }
        if (isset($_POST["name"])) {
            $fileName = md5($_POST["name"]) . '.jpg';
        } elseif (!empty($_FILES)) {
            $fileName = md5($_FILES["file"]["name"]) . '.jpg';
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . '/' . $fileName;

        $chunk = isset($_POST["chunk"]) ? intval($_POST["chunk"]) : 0;
        $chunks = isset($_POST["chunks"]) ? intval($_POST["chunks"]) : 0;

        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                echo '{"error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}';
                return;
            }
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . '/' . $file;
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    file_exists($tmpfilePath) && unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        if (!$out = fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            echo '{"error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
            return;
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                echo '{"error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                return;
            }
            if (!$in = fopen($_FILES["file"]["tmp_name"], "rb")) {
                echo '{"error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                return;
            }
        } else {
            if (!$in = fopen("php://input", "rb")) {
                echo '{"error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                return;
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        $out && fclose($out);
        $in && fclose($in);

        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
        }

        echo '{"error":0, "message" : "ok", "ret" : "' . rand() . '"}';
    }

    function act_plup() {
        \Xcs\Util::output_nocache();
        set_time_limit(5 * 60);

        $targetDir = getini('file/' . getini('settings/filesite') . '/dir') . "dump";
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds

        if (!is_dir($targetDir)) {
            mkdir($targetDir, DIR_WRITE_MODE);
        }
        if (isset($_POST["name"])) {
            $fileName = md5($_POST["name"]) . '.jpg';
        } elseif (!empty($_FILES)) {
            $fileName = md5($_FILES["file"]["name"]) . '.jpg';
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . '/' . $fileName;

        $chunk = isset($_POST["chunk"]) ? intval($_POST["chunk"]) : 0;
        $chunks = isset($_POST["chunks"]) ? intval($_POST["chunks"]) : 0;

        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                echo '{"error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}';
                return;
            }
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . '/' . $file;
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    file_exists($tmpfilePath) && unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }

        if (!$out = fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            echo '{"error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}';
            return;
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                echo '{"error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}';
                return;
            }
            if (!$in = fopen($_FILES["file"]["tmp_name"], "rb")) {
                echo '{"error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                return;
            }
        } else {
            if (!$in = fopen("php://input", "rb")) {
                echo '{"error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}';
                return;
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        $out && fclose($out);
        $in && fclose($in);

        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
        }

        echo '{"error":0, "message" : "ok", "ret" : "' . rand() . '"}';
    }
}
