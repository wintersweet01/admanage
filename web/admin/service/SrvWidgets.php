<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/1/15
 * Time: 15:46
 */

class SrvWidgets
{
    public $mod;

    public function __construct()
    {
        $this->mod = new ModWidgets();
    }

    /**
     * 获取游戏列表
     * @param bool $auth 是否开启权限验证
     * @return array
     */
    public function getAllGame($auth = true)
    {
        $info = $this->mod->getGameList($auth);
        $data = $list = [];
        foreach ($info['list'] as &$v) {
            $v['config'] = unserialize($v['config']);
            $data[$v['game_id']] = array(
                'pid' => $v['parent_id'],
                'id' => $v['game_id'],
                'text' => $v['name'],
                'inherit' => (int)$v['config']['inherit'],
            );

            $list[$v['game_id']] = $v['name'];
        }

        return array(
            'parent' => LibUtil::build_tree($data, 0),
            'list' => $list
        );
    }
}