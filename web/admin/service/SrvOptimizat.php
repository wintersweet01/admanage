<?php


class SrvOptimizat
{
    private $mod;

    public function __construct()
    {
        $this->mod = new ModAdMaterial();
    }

    public function getBusinessTree(array $param, array $header)
    {
        $platform = new SrvJrttAction();
        return $platform->setIsDebug(true)->getBusinessTree($param, $header);
    }

    public function getMediaAcc($channelId, $gameId)
    {
        if(! is_numeric($channelId) || ! is_numeric($gameId))
            return ['state' => false, 'msg' => '获取媒体账号参数错误'];

        return $this->mod->getMediaAcc($channelId, $gameId);
    }

    public function download($ids = '')
    {
        $tmp = [];
        $arr = explode(',', $ids);
        foreach ($arr as $id) {
            $id = (int)trim($id);
            if ($id <= 0) continue;
            $tmp[] = $id;
        }

        if (empty($tmp)) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $data = $this->mod->getDownload($tmp);
        if (empty($data)) {
            return array('state' => false, 'msg' => '记录不存在');
        }

        $file = 'material/' . md5(implode('|', $tmp)) . '.zip';
        $file_zip = DOWNLOAD_DIR . '/' . $file;
        $file_url = DOWNLOAD_URL . '/' . $file;
        if (!is_file($file_zip)) {
            $_data = [];
            foreach ($data as $row) {
                $file_name = $row['material_name'] . '_' . $row['material_id'] . strtolower(strrchr($row['file'], '.'));
                $_data[$file_name] = $row['file'];
            }

            $ret = LibUtil::zip($file_zip, $_data, true);
            if ($ret !== true) {
                return array('state' => false, 'msg' => $ret);
            }
        }

        return array('state' => true, 'msg' => '打包成功，正在下载...', 'url' => $file_url);
    }

    public function delAdMaterial(int $id)
    {
        if (!$id) {
            return array('state' => true, 'msg' => '参数错误');
        }

        $info = $this->mod->getAdmaterialById($id);
        if (empty($info)) {
            return array('state' => true, 'msg' => '记录不存在');
        }

        $ret1 = $this->mod->delAdMaterial($id);
        if ($ret1) {
            @unlink($info['file']); //删除素材
            @unlink(PIC_UPLOAD_DIR . $info['thumb']); //删除缩略图
            return array('state' => true, 'msg' => '删除成功！');
        } else {
            return array('state' => false, 'msg' => '删除失败！');
        }
    }

    public function editAdMaterial(array $param, array $where)
    {
        $param = array_filter($param);
        if(empty($param))
            return ['state' => false, 'msg' => '参数错误'];
        if(empty($where))
            return ['state' => false, 'msg' => '请检查更新条件'];
        $result = $this->mod->editAdMaterial($param, $where);
        return $result ? ['code' => true, 'msg' => '操作成功'] : ['code' => false, 'msg' => '操作失败'];
    }

    /**
     * 通过id获取素材信息
     * @param int $id
     * @return array|bool|resource|string
     */
    public function getAdmaterialById(int $id)
    {
        if($id <= 0)
            return ['code' => false, '参数错误'];
        return $this->mod->getAdmaterialById($id);
    }

    /**
     * 删除文案
     * @param array $where
     * @return array
     */
    public function deleteCopywriting(array $where)
    {
        if(empty($where))
            return ['code' => 0, 'msg' => '操作失败'];
        $mode = new ModCopywriting();
        $res = $mode->deleteCopywriting($where);
        return $res ? ['code' => 1, 'msg' => '操作成功'] : ['code' => 0, 'msg' => '操作失败'];
    }

    /**
     * 获取文案列表
     * @param array $param
     * @param int $pageSize
     * @return array
     */
    public function adCopywriting(array $param = [], int $pageSize = DEFAULT_ADMIN_PAGE_NUM)
    {
        $param = array_filter($param);
        $mod = new ModCopywriting();
        $list = $mod->adCopywriting($param, $pageSize);
        $list['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $list['total']['c'], $param['page'], DEFAULT_ADMIN_PAGE_NUM);
        $list['page_num'] = $pageSize ? $pageSize : DEFAULT_ADMIN_PAGE_NUM ;
        foreach ($param as $key => $val)
            $list[$key] = $val;
        return $list;
    }

    /**
     * 更新文案
     * @param array $param
     * @param array $where
     * @return array|resource|string
     */
    public function updateCopywriting(array $param, array $where)
    {
        if(empty($where) || empty($param))
            return ['code' => false, 'msg' => '参数错误'];
        $mod = new ModCopywriting();
        $res = $mod->updateCopywriting($param, $where);
        return $res ? ['code' => true, 'msg' => '操作成功'] : ['code' => false, 'msg' => '操作失败'];
    }

    /**
     * 根据Id获取文案信息
     * @param int $id
     * @return mixed
     */
    public function getCopywritingById(int $id)
    {
        $mod = new ModCopywriting();
        return $mod->getCopywritingById($id);
    }

    /**
     * 添加文案
     * @param array $param
     * @return array
     */
    public function addCopywriting(array $param)
    {
        $param['create_time'] = $param['update_time'] = date('Y-m-d H:i:s');
        $mod = new ModCopywriting();
        $res = $mod->addCopywriting($param);
        return $res ? ['code' => true, 'msg' => '操作成功'] : ['code' => false, 'msg' => '操作失败'];
    }

    public function getMaterialSize()
    {
        return $this->mod->getMaterialSize();
    }

    public function adMaterial($param, $pageSize = 0){
        $info = $this->mod->adMaterial($param, $pageSize);
        if ($info['total']) {
            foreach ($info['list'] as &$val) {
                $val['thumb'] = $val['thumb'] ? 'uploads/' . $val['thumb'] : '';
                $tag = explode(' ', $val['material_tag']);
                $tmp = [];
                $label = array('default', 'primary', 'success', 'info', 'warning', 'danger');
                $c = 0;
                foreach ($tag as $v) {
                    if (!$v) continue;
                    $lab = $label[array_rand($label)];
                    $str = '<span class="label label-' . $lab . '">' . $v . '</span>';
                    $c++;
                    if ($c % 2 == 0) {
                        $str .= "<br>";
                    }
                    $tmp[] = $str;
                }
                $val['material_tag'] = $tmp;
                if ($val['test_start']) {
                    $val['test_start'] = date('Y-m-d', $val['test_start']);
                }
                if ($val['test_end']) {
                    $val['test_end'] = date('Y-m-d', $val['test_end']);
                }

                //$filename = substr(strrchr($val['file'], '/'), 1);
                $val['material_url'] = MATERIAL_UPLOAD_URL . str_replace(MATERIAL_UPLOAD_DIR, '', $val['file']);
            }
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $param['page'], DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['parent_id'] = $param['parent_id'];
        $info['sdate'] = $param['sdate'];
        $info['edate'] = $param['edate'];
        $info['upload_user'] = $param['upload_user'];
        $info['material_type'] = $param['material_type'];
        $info['material_source'] = $param['material_source'];
        $info['material_wh'] = $param['material_wh'];
        $info['material_name'] = $param['material_id'] ? $info['list'][0]['material_name'] : $param['material_name'];
        $info['material_tag'] = $param['material_tag'];

        return $info;
    }

    public function uploadMaterial($data)
    {
        if (!$data['material_name']) {
            return array('state' => false, 'msg' => '请填写素材名称');
        }
        if (!$data['make_date']) {
            return array('state' => false, 'msg' => '请填写制作时间');
        }
        if (!$data['material_type']) {
            return array('state' => false, 'msg' => '请选择素材类型');
        }
        if (!$data['upload_file']) {
            return array('state' => false, 'msg' => '请上传素材文件');
        }
        if (!$data['thumb']) {
            return array('state' => false, 'msg' => '请上传缩略图');
        }
        $material_dir = MATERIAL_UPLOAD_DIR . '/' . date('Ym');
        if (!is_dir($material_dir)) {
            mkdir($material_dir, 0755, true);
        }
        $tmp_file = RUNTIME_DIR . '/tmp/' . $data['upload_file'];
        $new_file = MATERIAL_UPLOAD_DIR . '/' . $data['upload_file'];
        if (!is_dir(dirname($new_file))) {
            mkdir(dirname($new_file), 0755, true);
        }
        $data['material_size'] = LibUtil::formatBytes(filesize($tmp_file));
        $result = rename($tmp_file, $new_file);
        if (!$result) {
            return array('state' => false, 'msg' => '素材保存失败');
        }

       if ($data['material_tag']) {
            $tmp = [];
            $arr = explode(' ', $data['material_tag']);
            foreach ($arr as $val) {
                $tag = trim($val);
                if (!$tag) continue;
                $tmp[] = $tag;
                $this->mod->insertTag(array('uid' => $_SESSION['userid'], 'tag_name' => $tag));
            }
            $data['material_tag'] = implode(' ', $tmp);
       }

        $data['file'] = $new_file;
        $data['material_wh'] = "{$data['material_x']}*{$data['material_y']}";
        $data['upload_user'] = $_SESSION['username'];
        $data['create_time'] = time();

        unset($data['upload_file'], $data['material_x'], $data['material_y']);

        $ret = $this->mod->insertMaterial($data);
        if ($ret) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }
}