<?php

class CtlKfVip extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvKfVip();
    }

    //VIP列表
    public function vipManage()
    {
        SrvAuth::checkOpen('kfVip', 'vipManage');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $belong_id = $this->R('belong_id', 'int', 0);
        $insr_id = $this->R('insr_id', 'int', 0);
        $account = $this->R('account');
        $uid = $this->R('uid', 'int', 0);
        $page = $this->R('page', 'int', 0);
        $sdate = $this->R('sdate');
        $edata = $this->R('edate');
        $list_color = $this->R('list_color');
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $data = $this->srv->getKfVipList($parent_id, $game_id, $belong_id, $insr_id, $account, $uid, $page, $sdate, $edata, $list_color);
        $status = LibUtil::config('ConfVipStatus');
        $admins = SrvAuth::allAuth(true);
        //$belong_info = $this->srv->getGameServerBelongInfo();//使用redis
        $belong_info = array();
        $data['game_id'] = $game_id;
        $data['parent_id'] = $parent_id;
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => false,
                'children_id' => 'game_id',
                'children_default_value' => $game_id,
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );
        $this->out['data'] = $data;
        $this->out['_admins'] = $admins;
        $this->out['_belong_info'] = $belong_info;
        $this->out['status'] = $status;
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'vipManage';
        $this->out['__title__'] = 'VIP管理';
        $this->tpl = 'service/vip_list.tpl';
    }

    //VIP录入/更新
    public function vipInsr()
    {
        $model_id = $this->R('model_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        if ($model_id > 0) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        if ($_POST) {
            $this->outType = 'json';
            $data = array(
                'game_id' => $this->R('game_id', 'int', 0),//母游戏ID
                //'account' => $this->R('account'),
                'uid' => $this->R('uid', 'int', 0),
                'role_info' => $this->R('role_info', 'string', ''),
                'server_id' => $this->R('server_id', 'int', 0),
                'touch_time' => $this->R('touch_time'),
                'real_name' => $this->R('real_name'),
                'phone' => $this->R('phone'),
                'birth' => $this->R('birth'),
                'mail' => $this->R('mail'),
                'qq_num' => $this->R('qq_num'),
                'wx_num' => $this->R('wx_num'),
                'img' => $this->R('img'),
                'model_id' => $model_id,
                'platform' => $this->R('platform', 'int'),
                'check_btn' => $this->R('check_btn', 'int', 1)
            );
            $res = $this->srv->addVipUser($data);
            if ($res['state']) {
                $this->out['err_code'] = 200;
            } else {
                $this->out['err_code'] = 500;
                $this->out['msg'] = $res['msg'];
            }
        } else {
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'id' => 'game_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => $game_id,
                    'default_text' => '选择游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => false,
                    'children_id' => '',
                    'children_default_value' => '',
                    'children_default_text' => '',
                    'attr' => 'style="width: 150px;"'
                )
            );
            $data = $this->srv->getVipRow($model_id);
            $dataRow = $data['data'];
            $role_info = $this->srv->fetchRoleList($dataRow['game_id'], $dataRow['server_id'], $dataRow['uid']);
            $unions = array();
            $this->out['role_list'] = $role_info['data']['list'];
            $this->out['data'] = $dataRow;
            $this->out['model_id'] = $model_id;
            $this->out['widgets'] = $widgets;
            $this->out['games'] = $games;
            $this->out['unions'] = $unions;
            $this->out['__on_menu__'] = 'kfVip';
            $this->out['__on_sub_menu__'] = 'vipManage';
            $this->out['__title__'] = 'VIP录入';
            $this->tpl = 'service/vip_add.tpl';
        }
    }

    //VIP 批量删除
    public function batch_del()
    {
        SrvAuth::checkPublicAuth('del');
        $ids = $this->post('ids', 'array', array());
        $this->outType = 'json';
        $res = $this->srv->delVip($ids);
        $this->out = $res;
    }

    //撤销
    public function cancel()
    {
        SrvAuth::checkPublicAuth('del');
        $this->outType = 'json';
        $id = $this->post('data_id', 'int', 0);
        if (!$id) {
            $this->out = LibUtil::retData(false, array(), '删除失败');
            return;
        }
        $res = $this->srv->cancel($id);
        $this->out = $res;
    }

    //VIP业绩
    public function vipAchieve()
    {
        SrvAuth::checkOpen('kfVip', 'vipAchieve');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $account = $this->R('account');//玩家账号
        $kf_name = $this->R('kf_name');

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);

        $data = $this->srv->getVipAchieve($parent_id, $sdate, $edate, $account, $kf_name);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => false,
                'children_id' => 'game_id',
                'children_default_value' => '',
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'vipAchieve';
        $this->out['__title__'] = 'VIP业绩';
        $this->tpl = 'service/vip_achievement.tpl';
    }

    //查看明细
    public function viewlist()
    {
        //SrvAuth::checkOpen('KfVip', 'vipAchieve');
        $this->outType = 'smarty';

        $game_id = $this->get('game_id', 'int', 0);
        $parent_id = $this->get('parent_id', 'int', 0);
        $sdate = $this->get('sdate');
        $edate = $this->get('edate');
        $account = $this->get('account');//玩家账号
        $kf_name = $this->get('kf_name');
        $kfid = $this->get('kfid', 'int', 0);
        $uid = $this->get('uid', 'int', 0);
        $page = $this->get('page');

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array();
        foreach ($games['parent'] as $rows) {
            if ($rows['id'] == $parent_id) {
                $widgets = $rows['children'];
            }
        }
        $data = $this->srv->getViewList($game_id, $parent_id, $sdate, $edate, $account, $kfid, $uid, $page);

        $param['sdate'] = $sdate;
        $param['edate'] = $edate;
        $param['parent_id'] = $parent_id;
        $param['kf_name'] = $kf_name;
        $param['kfid'] = $kfid;
        $this->out['param'] = $param;
        $this->out['data'] = $data;
        $this->out['widg'] = $widgets;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'vipAchieve';
        $this->out['__title__'] = 'VIP业绩明细';
        $this->tpl = 'service/view_list.tpl';
    }

    //VIP档案管理
    public function vipRecord()
    {
        SrvAuth::checkOpen('kfVip', 'vipRecord');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $name = $this->R('name');
        $account = $this->R('account');
        $uid = $this->R('uid', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $page = $this->R('page', 'int', 0);

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $data = $this->srv->getviprecord($game_id, $name, $account, $uid, $sdate, $edate, $page, $parent_id);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => true,
                'children_id' => 'game_id',
                'children_default_value' => $game_id,
                'children_default_text' => '选择子游戏',
                'attr' => 'style="width: 150px;"'
            )
        );
        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'vipRecord';
        $this->out['__title__'] = 'VIP档案管理';
        $this->tpl = 'service/vip_record.tpl';
    }

    //用户联系
    public function userLink()
    {
        SrvAuth::checkOpen('kfVip', 'userLink');
        $this->outType = 'smarty';

        $parent_id = $this->R('parent_id', 'int', 0);
        $linker = $this->R('linker', 'int', 0);
        $server_id = $this->R('server_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $admins = SrvAuth::allAuth(true);
        $data = $this->srv->getUserLink($parent_id, $linker, $server_id, $sdate, $edate);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id',
                'type' => 'game',
                'data' => $games,
                'default_value' => $parent_id,
                'default_text' => '选择母游戏',
                'disabled' => false,
                'parent' => true,
                'children' => false,
                'children_id' => '',
                'children_default_value' => '',
                'children_default_text' => '',
                'attr' => 'style="width: 150px;"'
            )
        );
        $this->out['_admins'] = $admins;
        $this->out['data'] = $data;
        $this->out['_games'] = $games;
        $this->out['widgets'] = $widgets;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'userLink';
        $this->out['__title__'] = '用户联系';
        $this->tpl = 'service/user_link.tpl';
    }

    //产看用户联系明细
    public function viewUserLink()
    {
        SrvAuth::checkOpen('kfVip', 'userLink');
        $this->outType = 'smarty';
        $kfid = $this->get('kfid', 'int', 0);
        $parent_id = $this->get('parent_id', 'int', 0);
        $server_id = $this->get('server_id', 'int', 0);
        $sdate = $this->get('sdate');
        $edate = $this->get('edate');
        $page = $this->get('page', 'int', 0);
        $status = $this->get('status', 'int', 0);
        $uid = $this->get('uid');
        $statusConf = LibUtil::config('ConfVipStatus');
        $admins = SrvAuth::allAuth(true);
        $games = (new SrvPlatform())->getAllGame(false);
        unset($statusConf['3']);
        $param = array(
            'kfid' => $kfid,
            'parent_id' => $parent_id,
            'server_id' => $server_id,
            'sdate' => $sdate,
            'edate' => $edate
        );
        $data = $this->srv->viewLinkInfo($kfid, $parent_id, $server_id, $status, $uid, $sdate, $edate, $page);
        $this->out['data'] = $data;
        $this->out['_games'] = $games;
        $this->out['_admins'] = $admins;
        $this->out['param'] = $param;
        $this->out['_status'] = $statusConf;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'userLink';
        $this->out['__title__'] = '用户联系明细';
        $this->tpl = "service/view_link.tpl";
    }

    //导出联系列表
    public function userLinkDownload()
    {
        SrvAuth::checkOpen('kfVip', 'userLink');
        $this->outType = 'json';
        $kfid = $this->post('kfid', 'int', 0);
        $parent_id = $this->post('parent_id', 'int', 0);
        $server_id = $this->post('server_id', 'int', 0);
        $sdate = $this->post('sdate', 'string');
        $edate = $this->post('edate', 'string');
        $status = $this->post('status', 'int', 0);
        $uid = $this->post('uid', 'int', 0);
        $param['kfid'] = $kfid;
        $param['parent_id'] = $parent_id;
        $param['server_id'] = $server_id;
        $param['sdate'] = $sdate;
        $param['edate'] = $edate;
        $param['status'] = $status;
        $param['uid'] = $uid;
        $this->out = $this->srv->viewLinkInfoDownload($param);
    }

    //客服VIP权限管理
    public function author()
    {
        SrvAuth::checkOpen('kfVip', 'author');
        $this->outType = 'smarty';
        $admins = SrvAuth::allAuth();
        $authorPubPower = SrvAuth::$public_auth;
        $authPub = explode("|", $authorPubPower);
        $kfAdmin = array();
        foreach ($admins as $rows) {
            //超级管理员/客服管理员 能看见全部消息
            //if ((SrvAuth::$id != 1 && SrvAuth::$id != $rows['admin_id'] && !in_array(SrvAuth::$name, KF_ADMIN)) || $rows['admin_id'] == 1) continue;
            //if(!$rows['is_kf'])continue; //使用客服唯一标识
            if ((SrvAuth::$id != 1 && SrvAuth::$id != $rows['admin_id'] && !in_array('kfvip', $authPub)) || $rows['admin_id'] == 1) continue;
            array_push($kfAdmin, $rows);
        }
        $this->out['author'] = $kfAdmin;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'author';
        $this->out['__title__'] = '权限管理';
        $this->tpl = 'service/author.tpl';
    }

    //进行授权管理
    public function authorPower()
    {
        $authorId = $this->R('author_id', 'int', 0);
        $parent_id = $this->R('parent_id', 'int', 0);
        if ($_POST) {
            //编辑和新增
            $parent_id = $this->post('parent_id', 'int', 0);
            $data = $this->post('data', 'json', '');
            $author_id = $this->post('author_id', 'int', 0);
            $info = $this->post('info', 'json', '');
            //$res = $this->srv->addAuthorServerPowerP($data, $author_id, $parent_id);
            $res = $this->srv->addAuthorServerPower($info, $author_id, $parent_id);

            if ($res['state']) {
                $this->out['err_code'] = '200';
            } else {
                $this->out['err_code'] = '500';
                $this->out['msg'] = $res['msg'];
            }
        } else {
            //展示
            $page = $this->R('page', 'int', 0);
            $platform = $this->R('platform', 'int', 0);
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $admins = SrvAuth::allAuth();
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => $parent_id,
                    'default_text' => '选择游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => false,
                    'children_id' => '',
                    'children_default_value' => '',
                    'children_default_text' => '',
                    'attr' => 'style="width: 150px;"'
                )
            );
            //获取所有母游戏下的区服列表
            $gamePSer = $this->srv->getGameParentServer($authorId, $parent_id);
            //获取用户已经勾选的区服
            $adminSelect = $this->srv->getAdminSelectServer($authorId);
            $this->out['_page'] = $page;
            $this->out['_games'] = $games;
            $this->out['widgets'] = $widgets;
            $this->out['_admins'] = $admins;
            $this->out['author_id'] = $authorId;
            $this->out['admin_select'] = $adminSelect;
            $this->out['parent_server'] = $gamePSer;
            $this->out['parent_id'] = $parent_id;
            $this->out['__on_menu__'] = 'kfVip';
            $this->out['__on_sub_menu__'] = 'author';
            $this->out['__title__'] = '游戏区服授权';
            $this->tpl = 'service/author_power.tpl';
        }
    }

    //获取更多服务器
    public function more_server()
    {

        $more = $this->get('more', 'int', 0);
        $platform = $this->get('platform', 'int', 0);
        $parent_id = $this->get('parent_id', 'int', 0);
        $authorId = $this->R('author_id', 'int', 0);
        $data = $this->srv->getMoreGameServer($more, $platform, $parent_id, $authorId);
        $this->outType = 'json';
        $this->out = $data;
    }

    //查看权限范围
    public function viewAuthorPower()
    {
        SrvAuth::checkPublicAuth('service');///是否具备客服功能 一般客服都具备
        $this->outType = 'smarty';

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(false);
        $allAuthor = SrvAuth::allAuth();

        $authorId = $this->R('author_id');
        $data = $this->srv->viewAuthorPowerP($authorId);
        $this->out['_games'] = $games;
        $this->out['all_admin'] = $allAuthor;
        $this->out['author_id'] = $authorId;
        $this->out['data'] = $data;
        $this->out['__on_menu__'] = 'kfVip';
        $this->out['__on_sub_menu__'] = 'author';
        $this->out['__title__'] = '查看我的权限';
        $this->tpl = 'service/view_power.tpl';
    }

    //检查信息是否存在
    public function infoCheck()
    {
        $this->outType = 'json';
        $data = $this->post('data');
        $dataType = $this->post('data_type');
        $ret = $this->srv->infoCheck($data, $dataType);
        $this->out = $ret;
    }

    //获取角色信息
    public function fetch_role()
    {
        //SrvAuth::checkOpen('kfVip', 'vipInsr');
        $this->outType = 'json';
        $parent_id = $this->post('parent_id');
        $server_id = $this->post('server_id');
        $uid = $this->post('uid');
        $data = $this->srv->fetchRoleList($parent_id, $server_id, $uid);
        $this->out['state'] = $data['state'];
        $this->out['list'] = $data['data']['list'];
    }

    //批量审核功能
    public function batch_pass()
    {
        SrvAuth::checkOpen('kfVip', 'vipManage');
        SrvAuth::checkPublicAuth('edit');

        $ids = $this->post('ids');
        $this->outType = 'json';
        $this->out = $this->srv->batchCheck($ids);
    }

    //VIP档案管理导出
    public function recordDownload()
    {
        SrvAuth::checkOpen('kfVip', 'vipRecord');
        $this->outType = 'json';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $name = $this->R('name', 'string', '');
        $account = $this->R('account', 'string', '');
        $uid = $this->R('uid', 'string', '');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $param['parent_id'] = $parent_id;
        $param['game_id'] = $game_id;
        $param['name'] = trim($name);
        $param['account'] = trim($account);
        $param['uid'] = (int)$uid;
        $param['sdate'] = $sdate;
        $param['edate'] = $edate;
        $this->out = $this->srv->recordDownload($param);
    }

    //VIP列表导出
    public function vipListDownload()
    {
        SrvAuth::checkOpen('kfVip', 'vipManage');
        $this->outType = 'json';
        $parent_id = $this->R('parent_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $belong_id = $this->R('belong_id', 'int', 0);
        $insr_id = $this->R('insr_id', 'int', 0);
        $account = $this->R('account');
        $uid = $this->R('uid', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $list_color = $this->R('list_color');

        $param = array();
        $param['parent_id'] = $parent_id;
        $param['game_id'] = $game_id;
        $param['belong_id'] = $belong_id;
        $param['insr_id'] = $insr_id;
        $param['account'] = $account;
        $param['uid'] = $uid;
        $param['sdate'] = $sdate;
        $param['edate'] = $edate;
        $param['list_color'] = $list_color;

        $this->out = $this->srv->vipListDownload($param);
    }
}

?>