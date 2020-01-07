<?php

/**
 * 联运分发-数据配置
 * 2019-06-27
 * Class CtlUnionConfig
 */

class CtlUnionConfig extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvUnion();
    }

    /**
     * 获取游戏列表
     */
    public function gameList()
    {
        SrvAuth::checkOpen('unionConfig', 'gameList');

        $this->outType = 'smarty';
        $data = $this->srv->getGameList(0);

        $this->out['data'] = $data;
        $this->out['__on_menu__'] = 'unionConfig';
        $this->out['__on_sub_menu__'] = 'gameList';
        $this->out['__title__'] = '游戏管理';
        $this->tpl = 'union/gameList.tpl';
    }

    /**
     * 添加游戏
     */
    public function gameAdd()
    {
        SrvAuth::checkOpen('unionConfig', 'gameList');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->post('data');
            parse_str($data, $param);

            $this->out = $this->srv->gameAdd($param);
        } else {
            $this->outType = 'smarty';
            $game_id = $this->R('game_id', 'int', 0);
            $children_id = 0;

            if ($game_id) {
                $data = $this->srv->getGameInfo($game_id);
                $data['config'] = unserialize($data['config']);
                $data['ratio'] || $data['ratio'] = 100;

                $children_id = (int)$data['inherit'];
            } else {
                $data['game_id'] = $game_id;
                $data['ratio'] = 100;
                $data['unit'] = 0;
                $data['type'] = 'android';
                $data['is_login'] = 1;
                $data['is_pay'] = 1;
                $data['lock'] = 0;
            }

            $widgets = array(
                'game' => array(
                    'id' => 'parent_id', //自定义ID
                    'type' => 'game', //插件类型
                    'data' => $this->srv->getAllGame(), //游戏数据树
                    'default_value' => empty($data) ? 0 : (int)$data['parent_id'], //默认值
                    'default_text' => '选择母游戏', //默认显示内容
                    'disabled' => false, //是否不可选
                    'parent' => true, //是否开启只可选择父游戏
                    'children' => true, //是否开启子游戏选择
                    'children_default_value' => $children_id, //子游戏默认值
                    'children_default_text' => '选择子游戏', //子游戏默认显示内容
                    'children_inherit' => true, //过滤继承的游戏
                    'children_attr' => 'style="width: 150px"',
                    'attr' => 'style="width: 150px"' //标签属性参数
                ),
            );

            $this->out['data'] = $data;
            $this->out['widgets'] = $widgets;
            $this->out['__on_menu__'] = 'unionConfig';
            $this->out['__on_sub_menu__'] = 'gameList';
            $this->out['__title__'] = '添加/修改游戏';
            $this->tpl = 'union/gameAdd.tpl';
        }
    }

    /**
     * 下载游戏参数
     */
    public function downloadGameParam()
    {
        SrvAuth::checkOpen('unionConfig', 'gameList');

        $this->outType = 'string';
        $game_id = $this->R('game_id', 'int', 0);
        $this->srv->downloadGameParam($game_id);
    }

    /**
     * 平台管理
     */
    public function platformList()
    {
        SrvAuth::checkOpen('unionConfig', 'platformList');

        $this->outType = 'smarty';
        $data = $this->srv->getPlatformList(0);

        $this->out['data'] = $data;
        $this->out['__on_menu__'] = 'unionConfig';
        $this->out['__on_sub_menu__'] = 'platformList';
        $this->out['__title__'] = '平台管理';
        $this->tpl = 'union/platformList.tpl';
    }

    /**
     * 添加/编辑平台
     */
    public function platformAdd()
    {
        SrvAuth::checkOpen('unionConfig', 'platformList');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->post('data');
            parse_str($data, $param);

            $this->out = $this->srv->platformAdd($param);
        } else {
            $this->outType = 'smarty';
            $platform_id = $this->R('platform_id', 'int', 0);

            if ($platform_id) {
                $data = $this->srv->getPlatformInfo($platform_id);
                $data['config'] = unserialize($data['config']);
            } else {
                $data['platform_id'] = $platform_id;
                $data['is_login'] = 1;
                $data['is_pay'] = 1;
                $data['lock'] = 0;
            }

            $this->out['data'] = $data;
            $this->out['__on_menu__'] = 'unionConfig';
            $this->out['__on_sub_menu__'] = 'platformList';
            $this->out['__title__'] = '添加/修改游戏';
            $this->tpl = 'union/platformAdd.tpl';
        }
    }

    /**
     * 添加/编辑平台游戏
     */
    public function platformAddGame()
    {
        SrvAuth::checkOpen('unionConfig', 'platformList');

        if ($_POST) {
            $this->outType = 'json';

            $data = $this->post('data');
            parse_str($data, $param);

            $this->out = $this->srv->platformAddGame($param);
        } else {
            $this->outType = 'smarty';
            $platform_id = (int)$this->R('platform_id', 'int', 0);
            $game_id = (int)$this->R('game_id', 'int', 0);
            $type = $this->R('type');
            $platform = $this->srv->getAllPlatform();
            $exclude_game = array();

            if ($type == 'edit') {
                $data = $this->srv->getPlatformGameInfo($platform_id, $game_id);
                $data['config'] = unserialize($data['config']);
            } else {
                $data['game_id'] = $game_id;
                $data['platform_id'] = $platform_id;
                $data['is_login'] = 1;
                $data['is_pay'] = 1;
                $data['lock'] = 0;

                //排除已添加的平台
                if ($game_id > 0) {
                    $info = $this->srv->getPlatformGameList(0, $game_id, 0);
                    foreach ($info['platform'] as $pid => $row) {
                        if (isset($platform[$pid])) {
                            unset($platform[$pid]);
                        }
                    }
                }

                //排除已添加的游戏
                if ($platform_id > 0) {
                    $info = $this->srv->getPlatformGameList(0, 0, $platform_id);
                    $exclude_game = array_keys($info['game']);
                }
            }
            $data['type'] = $type;

            $widgets = array(
                'game' => array(
                    'type' => 'game', //插件类型
                    'data' => $this->srv->getAllGame($exclude_game), //游戏数据树
                    'default_value' => (int)$game_id, //默认值
                    'default_text' => '选择游戏',
                    'disabled' => $game_id > 0 ? true : false, //是否不可选
                    'parent' => false, //是否开启只可选择父游戏
                    'attr' => 'style="width: 150px"' //标签属性参数
                ),
            );

            $this->out['data'] = $data;
            $this->out['widgets'] = $widgets;
            $this->out['_platform'] = $platform;
            $this->out['__on_menu__'] = 'unionConfig';
            $this->out['__on_sub_menu__'] = 'platformList';
            $this->out['__title__'] = '添加/修改游戏';
            $this->tpl = 'union/platformAddGame.tpl';
        }
    }

    /**
     * 下载平台对应游戏参数
     */
    public function downloadPlatformGameParam()
    {
        SrvAuth::checkOpen('unionConfig', 'platformList');

        $this->outType = 'string';
        $platform_id = $this->R('platform_id', 'int', 0);
        $game_id = $this->R('game_id', 'int', 0);
        $this->srv->downloadPlatformGameParam($platform_id, $game_id);
    }

    /**
     * 设置平台缓存
     */
    public function setPlatformCache()
    {
        $this->outType = 'json';
        $this->out = $this->srv->setPlatformCache();
    }

    /**
     * 设置游戏缓存
     */
    public function setGameCache()
    {
        $this->outType = 'json';
        $this->out = $this->srv->setGameCache();
    }
}