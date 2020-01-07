<?php

class SrvOperateReceipt
{
    private $mod;

    public function __construct()
    {
        $this->mod = new ModOperateReceipt();
    }

    public function operateReceipt($type, $parent_id, $sdate, $edate)
    {
        if ($sdate == '') {
            $sdate = date('Y-m-d',strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'label' => '选择游戏',
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $parent_id, //默认值
                'default_text' => '全部', //默认显示内容
                'parent' => true, //是否开启只可选择父游戏
            ),
        );

        $data = $total = $channel = $tmp = [];
        $info = $this->mod->operateReceipt($type, $parent_id, $sdate, $edate);
        foreach ($info as $row) {
            $row['income'] /= 100;

            if ($type == 2) {
                $row['group_name'] = $games['list'][$row['group_name']];
            }

            $tmp['总计']['合计'] += $row['income'];
            $tmp['总计'][$row['channel_name']] += $row['income'];

            $tmp[$row['group_name']]['合计'] += $row['income'];
            $tmp[$row['group_name']][$row['channel_name']] = $row['income'];

            $channel['合计'] = '合计';
            $channel[$row['channel_name']] = $row['channel_name'];
        }

        $data['list'] = $tmp;
        $data['channel'] = $channel;

        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);

        $data['parent_id'] = $parent_id;
        $data['sdate'] = $sdate;
        $data['edate'] = $edate;
        $data['widgets'] = $widgets;

        return $data;
    }
}