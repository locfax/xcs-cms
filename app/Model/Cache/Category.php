<?php

namespace Model\Cache;

class Nodecategory {

    use \Xcs\Traits\Singleton;

    public function getdata() {
        $data = \Xcs\DB::dbm('general')->findAll('node_category', '*', "1 ORDER BY sortby,catid ASC");
        if (empty($data)) {
            return '';
        }
        $data = \Xcs\Util::array_index($data, 'catid');
        $data['tree'] = \Xcs\Helper\Arrmap::to_tree($data, 'catid', 'upid', 'catid');
        return $data;
    }
}
