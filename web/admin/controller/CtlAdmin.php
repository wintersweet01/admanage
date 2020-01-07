<?php

class CtlAdmin extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvAdmin();
    }

    /**
     * 管理员列表
     */
    public function adminList()
    {
        SrvAuth::checkOpen('admin', 'adminList');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $this->out['data'] = $this->srv->getAdminList($page);
        $this->out['_userid_'] = SrvAuth::$id;
        $this->out['__on_menu__'] = 'admin';
        $this->out['__on_sub_menu__'] = 'adminList';
        $this->out['__title__'] = '管理员列表';
        $this->tpl = 'admin/list.tpl';
    }


    /**
     * 添加管理员页面
     */
    public function addAdmin()
    {
        SrvAuth::checkOpen('admin', 'adminList');

        $this->outType = 'smarty';
        $admin_id = $this->R('admin_id', 'int', 0);
        if ($admin_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();
        $games = $srvPlatform->getAllGame(true, false);

        $this->out['data'] = $this->srv->getAdminInfo($admin_id);
        $this->out['admin_id'] = $admin_id;
        $this->out['_games'] = $games['parent'];
        $this->out['_roles'] = $this->srv->getAllRole();
        $this->out['_channeluser'] = $srvAd->getAllChannelUser();
        $this->out['__on_menu__'] = 'admin';
        $this->out['__on_sub_menu__'] = 'adminList';
        $this->out['__title__'] = '添加/修改管理员';
        $this->tpl = 'admin/add.tpl';
    }

    public function addAdminAction()
    {
        SrvAuth::checkOpen('admin', 'adminList');
        $this->outType = 'json';

        $admin_id = $this->post('admin_id', 'int', 0);
        if ($admin_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }
        $data = array(
            'user' => $this->post('inputUser'),
            'name' => $this->post('name'),
            'pwd' => $this->post('inputPwd'),
            'pwd2' => $this->post('inputPwd2'),
            'role_id' => $this->post('role_id'),
            'parent_id' => $this->post('parent_id'),
            'game_id' => $this->post('game_id'),
            'channel_id' => $this->post('channel_id'),
            'user_id' => $this->post('user_id'),
        );
        $this->out = $this->srv->addAdminAction($admin_id, $data);
    }

    /**
     * 删除管理员
     */
    public function deleteAdmin()
    {
        SrvAuth::checkOpen('admin', 'adminList');
        SrvAuth::checkPublicAuth('del');

        $this->outType = 'none';
        $admin_id = $this->R('id');
        $this->srv->deleteAdmin($admin_id);
    }

    /**
     * 角色列表
     */
    public function roleList()
    {
        SrvAuth::checkOpen('admin', 'roleList');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $this->out['data'] = $this->srv->getRoleList($page);

        $this->out['__on_menu__'] = 'admin';
        $this->out['__on_sub_menu__'] = 'roleList';
        $this->out['__title__'] = '角色列表';
        $this->tpl = 'admin/role.tpl';
    }

    /**
     * 添加/编辑角色
     */
    public function roleAdd()
    {
        SrvAuth::checkOpen('admin', 'roleList');

        $this->outType = 'smarty';
        $role_id = $this->R('role_id', 'int', 0);
        if ($role_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $this->out['data']['info'] = $this->srv->getRoleInfo($role_id);
        $this->out['data']['role_id'] = $role_id;
        $this->out['data']['_menu'] = $this->srv->getMenu();
        $this->out['data']['_public_auth'] = $this->srv->getPublicAuth();
        $this->out['__on_menu__'] = 'admin';
        $this->out['__on_sub_menu__'] = 'roleList';
        $this->out['__title__'] = '添加/修改角色';
        $this->tpl = 'admin/roleAdd.tpl';
    }

    /**
     * 执行添加/编辑角色
     */
    public function roleAddAction()
    {
        SrvAuth::checkOpen('admin', 'roleList');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $role_id = $this->post('role_id', 'int', 0);
        if ($role_id) {
            SrvAuth::checkPublicAuth('edit');
        } else {
            SrvAuth::checkPublicAuth('add');
        }

        $data = array(
            'role_name' => $this->post('role_name'),
            'role_fun' => $this->post('role_fun'),
            'role_menu' => $this->post('role_menu')
        );
        $this->out = $this->srv->roleAddAction($role_id, $data);
    }

    /**
     * 删除角色
     */
    public function roleDelete()
    {
        SrvAuth::checkOpen('admin', 'roleList');
        SrvAuth::checkPublicAuth('del');

        $this->outType = 'none';
        $role_id = $this->R('id');
        $this->srv->roleDelete($role_id);
    }

    /**
     * 投放组管理
     */
    public function groupList()
    {
        SrvAuth::checkOpen('admin', 'groupList');

        if ($_POST) {
            $this->outType = 'json';

            $group_id = $this->post('group_id', 'int', 0);
            $ids = $this->post('ids');
            $this->out = $this->srv->updateChannelGroup($group_id, $ids);
        } else {
            $this->outType = 'smarty';

            $this->out['data'] = $this->srv->getGroupList();
            $this->out['__on_menu__'] = 'admin';
            $this->out['__on_sub_menu__'] = 'groupList';
            $this->out['__title__'] = '投放组管理';
            $this->tpl = 'admin/groupList.tpl';
        }
    }
}