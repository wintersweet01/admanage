<?php

class SrvMaterial
{

    private $mod;

    public function __construct()
    {
        $this->mod = new ModMaterial();
    }

    public function materialData($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate, $psdate, $pedate, $is_excel = 0)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        $sdate || $sdate = $yesterday;
        $edate || $edate = $today;
        $psdate || $psdate = $yesterday;
        $pedate || $pedate = $today;

        $srvPlatform = new SrvPlatform();
        $_games = $srvPlatform->getAllGame();

        $ids = [];
        $info = $this->mod->materialData($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate, $psdate, $pedate, $is_excel);
        foreach ($info['list'] as &$val) {
            $val['cost'] = $val['cost'] / 100;
            $val['money'] = $val['money'] / 100;

            $val['time_zone'] = date('Y/m/d', $val['test_start']) . '—' . date('Y/m/d', $val['test_end']);
            if ($val['display']) {
                $val['click_rate'] = bcdiv($val['click'] * 100, $val['display'], 2) . '%';
            }
            if ($val['click']) {
                $val['reg_rate'] = bcdiv($val['reg'] * 100, $val['click'], 2) . '%';
            }
            if ($val['retain']) {
                $val['retain_cost'] = bcdiv($val['cost'], $val['retain'], 2);
            }
            if ($val['reg']) {
                $val['reg_cost'] = bcdiv($val['cost'], $val['reg'], 2);
                $val['retain_rate'] = bcdiv($val['retain'] * 100, $val['reg'], 2) . '%';
                $val['pay_rate'] = bcdiv($val['count_pay'] * 100, $val['reg'], 2) . '%';
            }
            if ($val['cost']) {
                $val['ROI'] = bcdiv($val['money'] * 100, $val['cost'], 2) . '%';
            }

            $ids[] = $val['material_id'];
        }

        $info['land_list'] = [];
        if (!empty($ids)) {
            $tmp = $this->mod->getMaterialLandList(array('ids' => $ids, 'game_id' => $game_id, 'device_type' => $device_type));
            foreach ($tmp as $row) {
                $info['land_list'][$row['material_id']][] = $row;
            }
        }

        if ($is_excel > 0) {
            $headerArray = array(
                '测试素材名', '测试游戏', '上传人', '测试时间区间', '测试关联包名/推广活动', '展现', '点击', '点击率', '消耗', '注册数', '注册率', '注册成本', '留存数', '留存率', '留存成本', '付费人数', '付费率', '付费金额', 'ROI'
            );
            $excel_data = array();
            foreach ($info['list'] as $val) {
                $str = '';
                foreach ($info['land_list'][$val['material_id']] as $v) {
                    $str .= "{$v['package_name']} / {$v['monitor_name']}\r\n";
                }

                $excel_data[] = array(
                    ' ' . $val['material_name'],
                    ' ' . $_games[$val['game_id']],
                    $val['upload_user'],
                    ' ' . $val['time_zone'],
                    $str,
                    $val['display'],
                    $val['click'],
                    $val['click_rate'],
                    '￥' . $val['cost'],
                    $val['reg'],
                    $val['reg_rate'],
                    '￥' . $val['reg_cost'],
                    $val['retain'],
                    $val['retain_rate'],
                    '￥' . $val['retain_cost'],
                    $val['count_pay'],
                    $val['pay_rate'],
                    '￥' . $val['money'],
                    $val['ROI'],
                );
            }

            $game_name = '';
            $device_type = '';
            $package_name = '';
            if ($game_id) {
                $game_name = $_games[$game_id];
            }
            if ($device_type) {
                if ($device_type == 1) {
                    $platform = 'IOS';
                } else {
                    $platform = 'Andorid';
                }
            } else {
                $platform = '全平台';
            }

            $filename = $sdate . '—' . $edate . ' ' . $game_name . ' ' . $platform . ' ' . $package_name . ' ' . '素材反馈表  ';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['count'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($psdate);
        LibUtil::clean_xss($pedate);
        LibUtil::clean_xss($upload_user);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        $info['upload_user'] = $upload_user;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['psdate'] = $psdate;
        $info['pedate'] = $pedate;
        return $info;
    }

    public function materialData2($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        $sdate || $sdate = $yesterday;
        $edate || $edate = $today;

        $ids = [];
        $info = $this->mod->materialData2($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate);
        foreach ($info['list'] as &$val) {
            $val['cost'] = $val['cost'] / 100;
            $val['money'] = $val['money'] / 100;

            $val['time_zone'] = date('Y/m/d', $val['test_start']) . '—' . date('Y/m/d', $val['test_end']);
            if ($val['display']) {
                $val['click_rate'] = bcdiv($val['click'] * 100, $val['display'], 2) . '%';
            }
            if ($val['click']) {
                $val['reg_rate'] = bcdiv($val['reg'] * 100, $val['click'], 2) . '%';
            }
            if ($val['retain']) {
                $val['retain_cost'] = bcdiv($val['cost'], $val['retain'], 2);
            }
            if ($val['reg']) {
                $val['reg_cost'] = bcdiv($val['cost'], $val['reg'], 2);
                $val['retain_rate'] = bcdiv($val['retain'] * 100, $val['reg'], 2) . '%';
            }

            $ids[] = $val['material_id'];
        }

        $info['land_list'] = [];
        if (!empty($ids)) {
            $tmp = $this->mod->getMaterialLandList(array('ids' => $ids, 'game_id' => $game_id, 'device_type' => $device_type));
            foreach ($tmp as $row) {
                $info['land_list'][$row['material_id']][] = $row;
            }
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['count'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        LibUtil::clean_xss($upload_user);
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['device_type'] = $device_type;
        $info['upload_user'] = $upload_user;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    public function materialBox($param = [])
    {
        $info = $this->mod->materialBox($param);
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
        $info['game_id'] = $param['game_id'];
        $info['channel_id'] = $param['channel_id'];
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

    public function getMaterialSize()
    {
        return $this->mod->getMaterialSize();
    }

    public function getMaterialTag()
    {
        return $this->mod->getMaterialTag();
    }

    public function uploadAct($ext, $total = 0, $now = 0, $size = 0, $nowSize = 0, $fileMd5 = '', $guid = '', $name = '')
    {
        $root_path = $ext == 'thumb' ? PIC_UPLOAD_DIR : RUNTIME_DIR . '/tmp';
        $extensions = array(
            'material' => array('.gif', '.jpg', '.jpeg', '.bmp', '.png', '.psd', '.ico', '.avi', '.wma', '.rmvb', '.rm', '.flash', '.mp4', '.mid', '.3gp', '.flv', '.mov'),
            'thumb' => array('.gif', '.jpg', '.jpeg', '.bmp', '.png')
        );

        $upload = new SrvUpload();
        $upload->setRootPath($root_path);
        $upload->setExt($extensions[$ext]);
        $data = $upload->upload($fileMd5, $total, $now, $size, $nowSize, $guid, $name);

        if ($ext == 'thumb') {
            $tmp = explode('/', $data['url']);
            $name = substr($tmp[1], 0, strrpos($tmp[1], '.'));
            $width = 200;
            $height = floor($data['height'] * $width / $data['width']);
            $img_url = $tmp[0] . '/' . $name . '_thumb' . $data['ext'];
            $dstimage = $root_path . '/' . $img_url;
            $result = LibImg::imagecut($data['file'], $dstimage, 0, 0, $width, $height, $data['width'], $data['height'], '#ffffff', 75);
            if ($result['state']) {
                unlink($data['file']);
                $data['url'] = $img_url;
                $data['file'] = $dstimage;
            }
        }

        return $data;
    }

    public function bindMaterial($data)
    {
        if (!$data['material_id']) {
            return array('state' => false, 'msg' => '参数错误');
        }
        if (!$data['monitor_id']) {
            return array('state' => false, 'msg' => '推广活动不能为空');
        }

        $ret = $this->mod->delMaterialLand($data['material_id']);
        if ($ret) {
            foreach ($data['monitor_id'] as $key => $val) {
                $arr['material_id'] = $data['material_id'];
                $arr['game_id'] = $data['game_id'][$key];
                $arr['device_type'] = $data['device_type'][$key];
                $arr['package_name'] = $data['package_name'][$key];
                $arr['monitor_id'] = $val;
                $this->mod->insertMaterialLand($arr);
            }
            return array('state' => true, 'msg' => '绑定成功！');
        }
        return array('state' => true, 'msg' => '绑定失败！');
    }

    public function delMaterial($id)
    {
        if (!$id) {
            return array('state' => true, 'msg' => '参数错误');
        }

        $info = $this->mod->getMaterialInfo($id);
        if (empty($info)) {
            return array('state' => true, 'msg' => '记录不存在');
        }

        $this->mod->startWork();

        $ret1 = $this->mod->delMaterial($id);
        $ret2 = $this->mod->delMaterialLand($id);
        if ($ret1 && $ret2) {
            @unlink($info['file']); //删除素材
            @unlink(PIC_UPLOAD_DIR . $info['thumb']); //删除缩略图

            $this->mod->commit();
            return array('state' => true, 'msg' => '删除成功！');
        } else {
            $this->mod->rollBack();
            return array('state' => false, 'msg' => '删除失败！');
        }
    }

    public function changeTime($data)
    {
        if ($data['time'] == '') {
            return array('state' => false, 'msg' => '时间不能为空');
        }

        $res = $this->mod->changeTime($data);
        if ($res) {
            return array('state' => true, 'msg' => '绑定成功！');
        }
    }

    public function getMonitorList($game_id = 0, $device_type = 0)
    {
        return $this->mod->getMonitorList($game_id, $device_type);
    }

    public function uploadMaterial($data)
    {
        if (!$data['material_name']) {
            return array('state' => false, 'msg' => '请填写素材名称');
        }
        if (!$data['make_date']) {
            return array('state' => false, 'msg' => '请填写制作时间');
        }
        if (!$data['channel_id']) {
            return array('state' => false, 'msg' => '请选择渠道');
        }
        if (!$data['game_id']) {
            return array('state' => false, 'msg' => '请选择游戏');
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

    public function materialTotal($parent_id, $game_id, $channel_id, $upload_user, $sdate, $edate)
    {
        if (!$edate) {
            $edate = date('Y-m-d');
        }
        if (!$sdate) {
            $sdate = date('Y-m-d');
        }

        $data = [];
        $info = $this->mod->materialTotal($parent_id, $game_id, $channel_id, $upload_user, $sdate, $edate);
        foreach ($info as &$val) {
            $val['click_rate'] = $val['display'] ? bcdiv($val['click'] * 100, $val['display'], 2) : 0;
            $val['reg_rate'] = $val['click'] ? bcdiv($val['reg'] * 100, $val['click'], 2) : 0;
        }

        $data['list'] = $info;
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['upload_user'] = $upload_user;

        return $data;
    }

    public function materialDay($parent_id, $game_id, $channel_id, $upload_user = '', $sdate, $edate)
    {
        if (!$edate) {
            $edate = date('Y-m-d');
        }
        if (!$sdate) {
            $sdate = date('Y-m-d');
        }

        $data = [];
        $info = $this->mod->materialDay($parent_id, $game_id, $channel_id, $upload_user, $sdate, $edate);
        foreach ($info as &$val) {
            $val['click_rate'] = $val['display'] ? bcdiv($val['click'] * 100, $val['display'], 2) : 0;
            $val['reg_rate'] = $val['click'] ? bcdiv($val['reg'] * 100, $val['click'], 2) : 0;
        }

        $data['list'] = $info;
        $data['parent_id'] = $parent_id;
        $data['game_id'] = $game_id;
        $data['channel_id'] = $channel_id;
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['upload_user'] = $upload_user;

        return $data;
    }

    public function getMonitor($monitor_id)
    {
        return $this->mod->getMonitor($monitor_id);
    }

    public function getMaterialInfo($material_id)
    {
        if (!$material_id) {
            return array('state' => false, 'msg' => '参数错误');
        }
        return $this->mod->getMaterialInfo($material_id);
    }

    public function editMaterial($material_id = 0, $data)
    {
        if (!$material_id) {
            return array('state' => false, 'msg' => '参数错误');
        }
        if (!$data['material_name']) {
            return array('state' => false, 'msg' => '请填写素材名称');
        }
        if (!$data['channel_id']) {
            return array('state' => false, 'msg' => '请选择渠道');
        }
        if (!$data['game_id']) {
            return array('state' => false, 'msg' => '请选择游戏');
        }
        if (!$data['material_type']) {
            return array('state' => false, 'msg' => '请选择素材类型');
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

        $ret = $this->mod->updateMaterial($material_id, $data);
        if ($ret) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    public function getChannelList()
    {
        return $this->mod->getChannelList();
    }

    public function getMaterialLandList($material_id)
    {
        if (!$material_id) {
            return array('state' => false, 'msg' => '参数错误');
        }
        return $this->mod->getMaterialLandList($material_id);
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
}