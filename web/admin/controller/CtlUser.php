<?php

class CtlUser extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvUser();
    }

    /**
     * 用户关联信息
     */
    public function getUserRelate()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'smarty';

        $uid = trim($this->R('uid'));

        $this->out['uid'] = $uid;
        $this->out['__title__'] = '用户信息';
        $this->tpl = 'user/user_relate.tpl';
    }

    /**
     * 指定用户的关联IP/设备号列表
     */
    public function getUserRelateList()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';

        $page = $this->R('page', 'int', 1);
        $limit = $this->R('limit', 'int', 15);
        $type = trim($this->R('type'));
        $uid = trim($this->R('uid'));

        $data = $this->srv->getUserRelateList($type, $uid, $page, $limit);
        $this->out = array(
            'code' => 0,
            'count' => $data['total'],
            'data' => $data['list'],
            'msg' => ''
        );
    }

    /**
     * 查询对应IP/设备号的关联账号
     */
    public function getUserRelateInfo()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';

        $page = $this->R('page', 'int', 1);
        $limit = $this->R('limit', 'int', 15);
        $type = trim($this->R('type'));
        $content = trim($this->R('content'));

        $data = $this->srv->getUserRelateInfo($type, $content, $page, $limit);
        $this->out = array(
            'code' => 0,
            'count' => $data['total'],
            'data' => $data['list'],
            'msg' => ''
        );
    }

    /**
     * 封禁/解封操作
     */
    public function banHandle()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';

        $type = trim($this->R('type'));
        $handle = trim($this->R('handle'));
        $content = trim($this->R('content'));
        $uid = $this->R('uid', 'int', 0);
        $text = trim($this->R('text'));

        $this->out = $this->srv->banHandle($type, $handle, $content, $uid, $text);
    }

    /**
     * 标记白名单
     */
    public function whiteHandle()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';

        $type = trim($this->R('type'));
        $handle = trim($this->R('handle'));
        $content = trim($this->R('content'));

        $this->out = $this->srv->whiteHandle($type, $handle, $content);
    }

    /**
     * 踢下线
     */
    public function kickUser()
    {
        SrvAuth::checkPublicAuth('userInfo');
        $this->outType = 'json';

        $uid = $this->R('uid', 'int', 0);

        $this->out = $this->srv->kickUser($uid);
    }

    /**
     * 封禁管理列表
     */
    public function forbidden()
    {
        SrvAuth::checkOpen('user', 'forbidden');

        $this->outType = 'smarty';

        $this->out['__on_menu__'] = 'user';
        $this->out['__on_sub_menu__'] = 'forbidden';
        $this->out['__title__'] = '封禁管理';
        $this->tpl = 'user/forbidden.tpl';
    }

    /**
     * 添加封禁
     */
    public function forbiddenAdd()
    {
        SrvAuth::checkOpen('user', 'forbidden');

        $type = trim($this->R('type'));
        if ($_POST) {
            $this->outType = 'none';

            $content = trim($this->R('content'));
            $notes = trim($this->R('notes'));
            $handle = $this->R('handle');

            $this->srv->forbiddenAdd($type, $content, $notes, $handle);
            exit();
        }

        $_type = array(
            'ip' => 'IP',
            'device' => '设备号',
            'user' => '账号'
        );

        $this->outType = 'smarty';
        $this->out['type'] = $type;
        $this->out['type_name'] = $_type[$type];
        $this->out['__title__'] = '添加封禁';
        $this->tpl = 'user/forbiddenAdd.tpl';
    }

    /**
     * 导出封禁列表
     */
    public function forbiddenExport()
    {
        SrvAuth::checkOpen('user', 'forbidden');

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $this->outType = 'string';

        $type = trim($this->R('type'));
        $_type = array(
            'ip' => 'IP',
            'device' => '设备号',
            'user' => '账号'
        );

        $data = $this->srv->forbiddenExport($type);
        SrvPHPExcel::downloadExcel('封禁' . $_type[$type] . '记录', $data['header'], $data['data']);
    }

    /**
     * 获取封禁列表
     */
    public function getForbiddenList()
    {
        SrvAuth::checkOpen('user', 'forbidden');
        $this->outType = 'json';

        $page = $this->R('page', 'int', 1);
        $limit = $this->R('limit', 'int', 15);
        $type = trim($this->R('type'));
        $keyword = trim($this->R('keyword'));

        $data = $this->srv->getForbiddenList($type, $keyword, $page, $limit);
        $this->out = array(
            'code' => 0,
            'count' => $data['total'],
            'data' => $data['list'],
            'msg' => ''
        );
    }

    /**
     * 关联账号排行
     */
    public function relateHot()
    {
        SrvAuth::checkOpen('user', 'relateHot');

        $this->outType = 'smarty';

        $this->out['__on_menu__'] = 'user';
        $this->out['__on_sub_menu__'] = 'relateHot';
        $this->out['__title__'] = '关联排行';
        $this->tpl = 'user/relate_hot.tpl';
    }

    /**
     * 获取关联账号排行列表
     */
    public function getRelateHotList()
    {
        SrvAuth::checkOpen('user', 'relateHot');
        $this->outType = 'json';

        $page = $this->R('page', 'int', 1);
        $limit = $this->R('limit', 'int', 15);
        $show_whitelist = $this->R('whitelist', 'int', 0);
        $num = $this->R('num', 'int', 10);
        $type = trim($this->R('type'));

        $data = $this->srv->getRelateHotList($type, $num, $show_whitelist, $page, $limit);
        $this->out = array(
            'code' => 0,
            'count' => $data['total'],
            'data' => $data['list'],
            'msg' => ''
        );
    }
}