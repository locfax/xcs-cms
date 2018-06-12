<?php

namespace Controller;

use \Model\Clips;

class Cache extends Controller {

    function act_set() {
        include template('base/cache.reset');
    }

    function act_reset() {
        set_time_limit(0);
        $resetall = getgpc('p.resetall');
        $modelcache = Clips\Cache::getInstance();
        if ($resetall) {
            $modelcache->update();
            $info = '缓存数据重新生成完成！';
            return \Xcs\Util::js_alert($info, '', url('cache/set'));
        }
        $resets = getgpc('p.resets');
        if ($resets) {
            foreach ($resets as $line) {
                $modelcache->update($line);
            }
            $info = '所选缓存数据重新生成完成！';
        } else {
            $info = '无任何操作！';
        }
        \Xcs\Util::js_alert($info, '', url('cache/set'));
    }

    function act_clear() {
        $clearall = getgpc('p.clearall');
        $modelcache = Clips\Cache::getInstance();
        if ($clearall) {
            $modelcache->updatetpl();
            $info = '全部清除完成1！';
            return \Xcs\Util::js_alert($info, '', url('cache/set'));
        }
        $clear = getgpc('p.clear');
        if ($clear) {
            foreach ($clear as $line) {
                $modelcache->{$line}();
            }
            $info = '所选清空完成！';
        } else {
            $info = '无任何操作！';
        }
        \Xcs\Util::js_alert($info, '', url('cache/set'));
    }

    function act_runtime() {
        $clear = getgpc('p.clear');
        if ($clear) {
            $dir = DATAPATH . 'preload/';
            $runfile = \Xcs\Helper\File::list_files($dir);
            foreach ($runfile as $file) {
                unlink($dir . $file);
            }
            $info = '所选清空完成！';
        } else {
            $info = '无任何操作！';
        }
        \Xcs\Util::js_alert($info, '', url('cache/set'));
    }

}
