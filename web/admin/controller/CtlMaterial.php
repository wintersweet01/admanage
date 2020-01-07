<?php

class CtlMaterial extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvMaterial();
    }

    public function materialData()
    {
        SrvAuth::checkOpen('material', 'materialData');

        $page = $this->R('page', 'int', 0);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $upload_user = $this->R('upload_user');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');

        $srvAdmin = new SrvAdmin();
        $srvPlatform = new SrvPlatform();

        $data = $this->srv->materialData($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate, $psdate, $pedate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->outType = 'smarty';
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['_games'] = $data['list'];
        $this->out['__on_menu__'] = 'material';
        $this->out['__on_sub_menu__'] = 'materialData';
        $this->out['__title__'] = '素材反馈表';
        $this->tpl = 'material/materialData.tpl';
    }

    public function materialData2()
    {
        SrvAuth::checkOpen('material', 'materialData2');

        $page = $this->R('page', 'int', 0);
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $upload_user = $this->R('upload_user');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvAdmin = new SrvAdmin();
        $srvPlatform = new SrvPlatform();

        $data = $this->srv->materialData2($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->outType = 'smarty';
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['_games'] = $data['list'];
        $this->out['__on_menu__'] = 'material';
        $this->out['__on_sub_menu__'] = 'materialData2';
        $this->out['__title__'] = '素材反馈表2';
        $this->tpl = 'material/materialData2.tpl';
    }

    public function materialDataExcel()
    {
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $upload_user = $this->R('upload_user');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $psdate = $this->R('psdate');
        $pedate = $this->R('pedate');
        $this->out['data'] = $this->srv->materialData('', $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate, $psdate, $pedate, 1);
        SrvPHPExcel::downloadExcel($this->out['data']['filename'], $this->out['data']['headerArray'], $this->out['data']['data']);
    }

    public function materialBox()
    {
        SrvAuth::checkOpen('material', 'materialBox');

        $this->outType = 'smarty';

        $srvPlatform = new SrvPlatform();
        $srvAdmin = new SrvAdmin();

        $param = array(
            'material_id' => $this->R('material_id', 'int', 0),
            'page' => $this->R('page', 'int', 0),
            'parent_id' => $this->R('parent_id', 'int', 0),
            'game_id' => $this->R('game_id', 'int', 0),
            'channel_id' => $this->R('channel_id', 'int', 0),
            'sdate' => $this->R('sdate'),
            'edate' => $this->R('edate'),
            'upload_user' => $this->R('upload_user'),
            'material_type' => $this->R('material_type'),
            'material_source' => $this->R('material_source'),
            'material_wh' => $this->R('material_wh'),
            'material_name' => $this->R('material_name'),
            'material_tag' => $this->R('material_tag')
        );

        $channel_list = [];
        $channels = $this->srv->getChannelList();
        foreach ($channels as $row) {
            $channel_list[$row['channel_id']] = $row['channel_name'];
        }

        $data = $this->srv->materialBox($param);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'type' => 'game',
                'data' => $games,
                'id' => 'parent_id',
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_tag'] = $this->srv->getMaterialTag();
        $this->out['_size'] = $this->srv->getMaterialSize();
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $channels;
        $this->out['_channel_list'] = $channel_list;
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['_types'] = LibUtil::config('ConfMaterial');

        $this->out['__on_menu__'] = 'material';
        $this->out['__on_sub_menu__'] = 'materialBox';
        $this->out['__title__'] = '素材库';
        $this->tpl = 'material/materialBox.tpl';
    }

    public function uploadMaterial()
    {
        SrvAuth::checkOpen('material', 'materialBox');

        if ($_POST) {
            $this->outType = 'json';
            $data = array(
                'material_name' => $this->post('material_name'),
                'make_date' => $this->post('make_date'),
                'game_id' => $this->post('game_id', 'int', 0),
                'channel_id' => $this->post('channel_id', 'int', 0),
                'material_type' => $this->post('material_type', 'int', 0),
                'material_x' => $this->post('material_x', 'int', 0),
                'material_y' => $this->post('material_y', 'int', 0),
                'material_source' => $this->post('material_source'),
                'material_tag' => $this->post('material_tag'),
                'upload_file' => $this->post('upload_file'),
                'thumb' => $this->post('upload_thumb')
            );
            $this->out = $this->srv->uploadMaterial($data);
        } else {
            $this->outType = 'smarty';
            $srvAd = new SrvAd();
            $srvPlatform = new SrvPlatform();
            $srvAdmin = new SrvAdmin();

            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => 0,
                    'default_text' => '选择游戏',
                    'disabled' => false,
                    'parent' => false,
                    'attr' => 'style="width: 150px;"'
                ),
            );

            $this->out['widgets'] = $widgets;
            $this->out['_url'] = APP_ALL_URL . '/uploads/';
            $this->out['make_date'] = date('Y-m-d');
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['_types'] = LibUtil::config('ConfMaterial');
            $this->out['__on_menu__'] = 'material';
            $this->out['__on_sub_menu__'] = 'materialBox';
            $this->out['__title__'] = '上传素材';
            $this->tpl = 'material/uploadMaterial.tpl';
        }
    }

    /**
     * 素材上传
     */
    public function uploadAct()
    {
        SrvAuth::checkOpen('material', 'materialBox');
        $this->outType = 'json';

        $ext = $this->R('ext');

        $total = $this->post('chunks', 'int', 0); //WebUploader，分割上传文件总数，0不分割
        $now = $this->post('chunk', 'int', 0); //WebUploader，当前上传分割数
        $nowSize = $this->post('chunkSize'); //WebUploader，当前分片大小，单位：字节
        $size = $this->post('size', 'int', 0); //WebUploader，上传文件总大小，单位：字节
        $guid = $this->post('guid'); //WebUploader，页面唯一GUID
        $name = $this->post('name'); //WebUploader，文件名
        $fileMd5 = $this->post('fileMd5'); //WebUploader，上传文件MD5

        $this->out = $this->srv->uploadAct($ext, $total, $now, $size, $nowSize, $fileMd5, $guid, $name);
    }

    /**
     * 绑定推广链接
     */
    public function bindMaterial()
    {
        SrvAuth::checkOpen('material', 'materialBox');

        if ($_POST) {
            $this->outType = 'json';
            $data = array(
                'material_id' => $this->post('material_id', 'int', 0),
                'game_id' => $this->post('game_id'),
                'device_type' => $this->post('device_type'),
                'monitor_id' => $this->post('monitor_id'),
                'package_name' => $this->post('package_name')
            );
            $this->out = $this->srv->bindMaterial($data);
        } else {
            $this->outType = 'smarty';
            $material_id = $this->R('material_id', 'int', 0);

            $SrvPlatform = new SrvPlatform();
            $this->out['material_id'] = $material_id;
            $this->out['_games'] = $SrvPlatform->getAllGame();
            $this->out['_bindList'] = $this->srv->getMaterialLandList($material_id);
            $this->out['__on_menu__'] = 'material';
            $this->out['__on_sub_menu__'] = 'materialBox';
            $this->out['__title__'] = '素材关联操作';
            $this->tpl = 'material/bindMaterial.tpl';
        }
    }

    public function delMaterial()
    {
        SrvAuth::checkOpen('material', 'materialBox');
        SrvAuth::checkPublicAuth('del');

        $this->outType = 'json';
        $id = $this->post('id');
        $this->out = $this->srv->delMaterial($id);
    }

    public function changeTime()
    {
        SrvAuth::checkOpen('material', 'materialBox');
        $this->outType = 'json';
        $data = array(
            'material_id' => $_GET['material_id'],
            'type' => $_GET['type'],
            'time' => $_GET['time'],
        );
        $this->out = $this->srv->changeTime($data);
    }

    /**
     * 素材综合统计报表
     */
    public function materialTotal()
    {
        SrvAuth::checkOpen('material', 'materialBox');

        $this->outType = 'smarty';

        $srvAd = new SrvAd();
        $srvPlatform = new SrvPlatform();
        $srvAdmin = new SrvAdmin();
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $upload_user = $this->R('upload_user');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->materialTotal($parent_id, $game_id, $channel_id, $upload_user, $sdate, $edate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $srvAdmin->getAllAdmin();
        $this->out['_types'] = LibUtil::config('ConfMaterial');
        $this->out['__on_menu__'] = 'material';
        $this->out['__on_sub_menu__'] = 'materialTotal';
        $this->out['__title__'] = '素材综合统计';
        $this->tpl = 'material/materialTotal.tpl';
    }

    /**
     * 个人分日统计
     */
    public function materialDay()
    {
        SrvAuth::checkOpen('material', 'materialBox');

        $this->outType = 'smarty';

        $srvAd = new SrvAd();
        $srvPlatform = new SrvPlatform();
        $srvAdmin = new SrvAdmin();
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $channel_id = $this->R('channel_id', 'int', 0);
        $upload_user = $this->R('upload_user');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $userlist = $srvAdmin->getAllAdmin();
        if (!$upload_user) {
            $upload_user = key($userlist);
        }

        $data = $this->srv->materialDay($parent_id, $game_id, $channel_id, $upload_user, $sdate, $edate);
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => (int)$data['parent_id'],
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => (int)$data['game_id'],
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 100px;"'
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['_channels'] = $srvAd->getAllChannel();
        $this->out['_admins'] = $userlist;
        $this->out['_types'] = LibUtil::config('ConfMaterial');
        $this->out['__on_menu__'] = 'material';
        $this->out['__on_sub_menu__'] = 'materialDay';
        $this->out['__title__'] = '素材综合统计';
        $this->tpl = 'material/materialDay.tpl';
    }

    /**
     * 编辑素材
     */
    public function editMaterial()
    {
        SrvAuth::checkOpen('material', 'materialBox');
        SrvAuth::checkPublicAuth('edit');

        $material_id = $this->R('material_id', 'int', 0);
        if ($_POST) {
            $this->outType = 'json';
            $data = array(
                'material_name' => $this->post('material_name'),
                'game_id' => $this->post('game_id', 'int', 0),
                'channel_id' => $this->post('channel_id', 'int', 0),
                'material_type' => $this->post('material_type', 'int', 0),
                'material_source' => $this->post('material_source'),
                'material_tag' => $this->post('material_tag')
            );
            $this->out = $this->srv->editMaterial($material_id, $data);
        } else {
            $this->outType = 'smarty';

            $srvAd = new SrvAd();
            $srvPlatform = new SrvPlatform();
            $srvAdmin = new SrvAdmin();

            $this->out['material_id'] = $material_id;
            $this->out['data'] = $this->srv->getMaterialInfo($material_id);
            $this->out['_games'] = $srvPlatform->getAllGame();
            $this->out['_channels'] = $srvAd->getAllChannel();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['_types'] = LibUtil::config('ConfMaterial');
            $this->out['__on_menu__'] = 'material';
            $this->out['__on_sub_menu__'] = 'materialBox';
            $this->out['__title__'] = '编辑素材';
            $this->tpl = 'material/editMaterial.tpl';
        }
    }

    public function getMonitor()
    {
        SrvAuth::checkOpen('material', 'materialBox');

        $this->outType = 'json';
        $game_id = $this->R('game_id', 'int', 0);
        $device_type = $this->R('device_type', 'int', 0);
        $this->out = $this->srv->getMonitorList($game_id, $device_type);
    }

    /**
     * 下载素材
     */
    public function download()
    {
        SrvAuth::checkOpen('material', 'materialBox');
        $this->outType = 'json';
        $ids = $this->R('ids');
        $this->out = $this->srv->download($ids);
    }
}