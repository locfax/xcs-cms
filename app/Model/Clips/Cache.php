<?php

namespace Model\Clips;

class Cache {

    use \Xcs\Traits\Singleton;

    private $map;

    public function __construct() {
        $this->cache_init();
    }

    private function cache_init() {
        $this->map = array(
            'category' => 'Goodscategory,Nodecategory',
        );
    }

    /*
     * 获取分类节点
     */
    public static function category_node($type, $catid = 0) {
        $category = \Xcs\SysCache::loadcache($type);
        if ($catid && isset($category['tree'][$catid]['children'])) {
            return $category['tree'][$catid]['children'];
        }
        return $category;
    }

    /**
     * @param string $cachefile
     */
    public function update($cachefile = '') {
        if ($cachefile) {
            $cachename = $this->map[$cachefile];
            foreach (explode(',', $cachename) as $line) {
                $cachem = '\\Model\\Cache\\' . $line;
                $data = $cachem::getInstance()->getdata();
                $cachename = 'sys_' . strtolower($line);
                \Xcs\SysCache::save($cachename, $data);
            }
        } else {
            foreach ($this->map as $cachename) {
                foreach (explode(',', $cachename) as $line) {
                    $cachem = '\\Model\\Cache\\' . $line;
                    $data = $cachem::getInstance()->getdata();
                    $cachename = 'sys_' . strtolower($line);
                    \Xcs\SysCache::save($cachename, $data);
                }
            }
        }
        $mcache = null;
    }

    public function updatetpl() {
        $tpls = \Xcs\Helper\File::list_files(getini('data/_view'), true, false);
        foreach ($tpls as $tpl) {
            if (preg_match("/\.php$/", $tpl) && !preg_match("/empty\.php$/", $tpl)) {
                chmod($tpl, FILE_WRITE_MODE);
                unlink($tpl);
            }
        }
    }
}
