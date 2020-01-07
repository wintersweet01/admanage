<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/3/12
 * Time: 12:01
 */

class CtlData4 extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvData();
    }

    /**
     * 按天每小时新增注册
     */
    public function regHour()
    {
        SrvAuth::checkOpen('data4', 'regHour');

        $day = [];
        for ($i = 0; $i < 24; $i++) {
            $day[] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);

            $this->out = $this->srv->regHour2($param, $day);
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $srvPlatform->getAllGame(true), //游戏数据树
                    'default_value' => 0, //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => 0, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'attr' => '' //标签属性参数
                ),
            );

            $this->out['day'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'regHour';
            $this->out['__title__'] = '按天每小时新增注册';
            $this->tpl = 'data/regHour2.tpl';
        }
    }

    /**
     * 基础数据
     */
    public function overview2()
    {
        SrvAuth::checkOpen('data4', 'overview2');

        $day = array(2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150, 180);
        $dayLtv = array(1, 7, 15, 30);
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);
            $row = $this->srv->getOverview2($param, $day, $dayLtv);
            $this->out = array(
                'code' => 0,
                'count' => count($row['list']),
                'data' => $row['list'],
                'totalData' => $row['total'],
                'msg' => '',
                'query' => $row['query']
            );
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $games, //游戏数据树
                    'default_value' => 0, //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => 0, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                ),
            );

            $this->out['ltv_day'] = json_encode($dayLtv);
            $this->out['day'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'overview2';
            $this->out['__title__'] = '基础数据';
            $this->tpl = 'data/overview2.tpl';
        }
    }

    /**
     * 按天每小时充值
     */
    public function payHour()
    {
        SrvAuth::checkOpen('data4', 'payHour');

        $day = [];
        for ($i = 0; $i < 24; $i++) {
            $day[] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }

        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';

            $data = $this->R('data');
            parse_str($data, $param);

            $this->out = $this->srv->payHour($param, $day);
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $srvPlatform->getAllGame(true), //游戏数据树
                    'default_value' => 0, //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'game_id',
                    'children_default_value' => 0, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'attr' => '' //标签属性参数
                ),
            );

            $this->out['day'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'payHour';
            $this->out['__title__'] = '按天每小时充值';
            $this->tpl = 'data/payHour.tpl';
        }
    }

    /**
     * 按天实时在线
     */
    public function onlineHour()
    {
        SrvAuth::checkOpen('data4', 'onlineHour');

        $josn = $this->R('json', 'int', 0);
        if ($josn) {
            $this->outType = 'json';

            $param = [];
            $data = $this->R('data');
            if ($data) {
                parse_str($data, $param);
            }

            $this->out = $this->srv->onlineHour($param);
        } else {
            $this->outType = 'smarty';

            $srvPlatform = new SrvPlatform();
            $widgets = array(
                'game' => array(
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $srvPlatform->getAllGame(true),
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'disabled' => false,
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => 0,
                    'children_default_text' => '选择子游戏'
                ),
            );

            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'onlineHour';
            $this->out['__title__'] = '按天每小时充值';
            $this->tpl = 'data/onlineHour.tpl';
        }
    }

    /**
     * LTV
     */
    public function ltv()
    {
        SrvAuth::checkOpen('data4', 'ltv');

        $data = $this->post('data');
        parse_str($data, $param);

        empty($param['type']) && $param['type'] = 7;
        $data = $this->srv->ltvNew($param, true);

        if ($_POST) {
            $this->outType = 'json';
            $this->out = $data;
        } else {
            $this->outType = 'smarty';

            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $data['games'], //游戏数据树
                    'default_value' => (int)$data['parent_id'], //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_id' => 'children_id', //子游戏ID
                    'children_default_value' => (int)$data['children_id'], //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                )
            );

            $this->out['widgets'] = $widgets;
            $this->out['data'] = $data;
            $this->out['day'] = json_encode($data['day']);
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'ltv';
            $this->out['__title__'] = 'LTV';
            $this->tpl = 'data/ltvNew2.tpl';
        }
    }

    /**
     * 按服充值统计表
     */
    public function serverView()
    {
        SrvAuth::checkOpen('data4', 'serverView');
        $this->outType = 'smarty';
        $parent_id = $this->R('parent_id');
        $game_id = $this->R('children_id');
        $device_type = $this->R('device_type', 'int');
        $server_start = $this->R('server_start', 'int');
        $server_end = $this->R('server_end', 'int');
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');
        $page = $this->R('page', 'int', 1);
        $type = $this->R('type', 'int', 1);
        $user_type = $this->R('user_type', 'int', 2);
        $showType = $this->R('show_type', 'array', array(1, 2));

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);

        $data = $this->srv->getServerView($parent_id, $game_id, $device_type, $type, $server_start, $server_end, $sdate, $edate, $page);
        $widgets = array(
            'game' => array(
                'label' => '母游戏',
                'id' => 'parent_id[]', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $parent_id, //默认值
                'multiple' => true, //是否多选
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'attr' => 'style="width: 50px;"', //标签属性参数
                'children' => true, //是否开启子游戏选择
                'children_id' => 'children_id[]', //子游戏ID
                'children_label' => '子游戏', //子游戏标签
                'children_default_value' => $game_id, //子游戏默认值
                'children_inherit' => false, //过滤继承的游戏
                'children_multiple' => true, //是否多选
                'children_attr' => 'style="width: 120px;"', //标签属性参数
            )
        );

        $this->out['widgets'] = $widgets;
        $this->out['data'] = $data;
        $this->out['type'] = $type;
        $this->out['user_type'] = $user_type;
        $this->out['show_type'] = $showType;
        $this->out['__on_menu__'] = 'data4';
        $this->out['__on_sub_menu__'] = 'serverView';
        $this->out['__title__'] = '按服充值统计';
        $this->tpl = 'data/serverView.tpl';
    }

    public function overview2ByHour()
    {
        SrvAuth::checkOpen('data4', 'overview2ByHour');
        $day = array(2, 3, 4, 5, 6, 7, 15, 30, 45, 60, 90, 120, 150, 180);
        $dayLtv = array(1, 7, 15, 30);
        $json = $this->R('json', 'int', 0);
        if ($json) {
            //获取数据
            $this->outType = 'json';
            $data = $this->R('data');
            parse_str($data, $param);
            $row = $this->srv->getOverview2ByHour($param, $day, $dayLtv);

            $this->out = array(
                'code' => 0,
                'count' => count($row['list']),
                'data' => $row['list'],
                'totalData' => $row['total'],
                'msg' => '',
                'query' => $row['query']
            );
        } else {
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $game = $srvPlatform->getAllGame(true);

            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $game,
                    'default_value' => 0,
                    'default_text' => '选择母游戏',
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => 0,
                    'children_default_text' => '选择子游戏',
                ),
            );
            $this->out['ltv_hour'] = json_encode($dayLtv);
            $this->out['hour'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'overview2ByHour';
            $this->out['__title__'] = '基础数据(分时)';
            $this->tpl = 'data/overview2hour.tpl';
        }
    }

    //新增玩家数据
    public function newUserData()
    {
        SrvAuth::checkOpen('data4', 'newUserData');
        $json = $this->R('json', 'int', 0);
        if ($json) {
            $this->outType = 'json';
            $data = $this->R('data');
            $page = $this->R('page', 'int', 0);
            $limit = $this->R('limit', 'int', 0);
            parse_str($data, $param);
            $row = $this->srv->getNewUserData($param, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => (int)$row['count'],
                'data' => isset($row['list']) ? $row['list'] : array(),
                'totalData' => $row['total'],
                'msg' => '',
                'query' => $row['query']
            );
        } else {
            //显示界面
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => '',
                    'default_text' => '选择母游戏',
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => '',
                    'children_default_text' => '选择子游戏',
                )
            );
            $this->out['limit_num'] = DEFAULT_ADMIN_PAGE_NUM;
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'newUserData';
            $this->out['__title__'] = '新增玩家数据';
            $this->tpl = 'data/newuserdata.tpl';
        }
    }

    //新增充值贡献
    public function newPayDevote()
    {
        SrvAuth::checkOpen('data4', 'newPayDevote');
        $json = $this->R('json', 'int', 0);
        $day = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 30, 45, 90);
        if ($json) {
            $this->outType = 'json';
            $data = $this->R('data');
            $page = $this->R('page', 'int', 0);
            $limit = $this->R('limit', 'int', 0);
            parse_str($data, $param);
            $row = $this->srv->getNewPayDevote($param, $day, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['count'],
                'data' => $row['list'],
                'totalData' => $row['total'],
                'msg' => '',
                'query' => $row['query']
            );
        } else {
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => '',
                    'default_text' => '选择母游戏',
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => '',
                    'children_default_text' => '选择子游戏',
                )
            );
            $this->out['limit_num'] = DEFAULT_ADMIN_PAGE_NUM;
            $this->out['day'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'newPayDevote';
            $this->out['__title__'] = '新增充值贡献';
            $this->tpl = 'data/newpaydevote.tpl';
        }
    }

    //新增付费渗透率
    public function newPayPermeability()
    {
        SrvAuth::checkOpen('data4', 'newPayPermeability');
        $json = $this->R('json', 'int', 0);
        $day = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 30, 45, 90);
        if ($json) {
            $this->outType = 'json';
            $limit = $this->R('limit', 'int', DEFAULT_ADMIN_PAGE_NUM);
            $page = $this->R('page', 'int', 0);
            $data = $this->R('data', 'string');
            parse_str($data, $param);
            $row = $this->srv->getNewPayPermeability($param, $day, $page, $limit);
            $this->out = array(
                'code' => 0,
                'count' => $row['count'],
                'data' => $row['data'],
                'totalData' => $row['total'],
                'msg' => '',
                'query' => $row['query'],
                'series' => $row['series'],
            );
        } else {
            $this->outType = 'smarty';
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => '',
                    'default_text' => '选择母游戏',
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => '',
                    'children_default_text' => '选择子游戏',
                )
            );
            $this->out['limit_num'] = DEFAULT_ADMIN_PAGE_NUM;
            $this->out['day'] = json_encode($day);
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'newPayPermeability';
            $this->out['__title__'] = '新增充值贡献';
            $this->tpl = 'data/newpaypermeability.tpl';
        }
    }

    public function dayChargeDataExcel()
    {
        SrvAuth::checkOpen('data4', 'dayChargeData');
        $day = array('1', '2', '3', '4', '5', '6', '7', '8_10', '11_20', '21_30', '1_30', '31_60', '61_');
        $param = array();
        $param['parent_id'] = $this->R('parent_id', 'int', 0);
        $param['game_id'] = $this->R('game_id', 'int', 0);
        $param['sdate'] = $this->R('sdate', 'string');
        $param['edate'] = $this->R('edate', 'string');
        $param['type'] = $this->R('type', 'int', 7);
        $param['show_type'] = $this->R('show_type', 'int', 0);
        $this->out['data'] = $this->srv->getDayChargeData($param, $day, 0, 0, 1);
        SrvPHPExcel::RecursionCreateExecl($this->out['data']['headerArray'], $this->out['data']['data'], $this->out['data']['filename'], 3);
    }

    public function dayChargeData()
    {
        SrvAuth::checkOpen('data4', 'dayChargeData');
        $json = $this->R('json', 'int', 0);
        $day = array('1', '2', '3', '4', '5', '6', '7', '8_10', '11_20', '21_30', '1_30', '31_60', '61_');
        if ($json) {
            $this->out = 'json';
            $page = $this->R('page', 'int', 0);
            $limit = $this->R('limit', 'int', 0);
            $data = $this->R('data');
            parse_str($data, $param);
            $row = $this->srv->getDayChargeData($param, $day, $page, $limit, 0);
            $this->out = array(
                'code' => 0,
                'msg' => '',
                'data' => $row['list'],
                'count' => $row['count'],
                'query' => $row['query'],
                'totalData' => $row['total'],
            );
        } else {
            $srvPlatform = new SrvPlatform();
            $games = $srvPlatform->getAllGame(true);
            $widgets = array(
                'game' => array(
                    'label' => '选择游戏',
                    'id' => 'parent_id',
                    'type' => 'game',
                    'data' => $games,
                    'default_value' => !empty($param['parent_id']) ? (int)$param['parent_id'] : '',
                    'default_text' => '选择母游戏',
                    'parent' => true,
                    'children' => true,
                    'children_id' => 'game_id',
                    'children_default_value' => !empty($param['game_id']) ? (int)$param['game_id'] : '',
                    'children_default_text' => '选择子游戏',
                )
            );
            $this->outType = 'smarty';
            $this->out['widgets'] = $widgets;
            $this->out['_games'] = $games;
            $this->out['limit_num'] = DEFAULT_ADMIN_PAGE_NUM;
            $this->out['show_type'] = 7;
            $this->out['day'] = json_encode($day);
            $this->out['__on_menu__'] = 'data4';
            $this->out['__on_sub_menu__'] = 'dayChargeData';
            $this->out['__title__'] = '每日充值统计';
            $this->tpl = 'data/daychargedata.tpl';
        }
    }
}