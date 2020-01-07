<?php

class SrvDestribuReceipt
{
    private $mod;

    public function __construct()
    {
        $this->mod = new ModDestribuReceipt();
    }

    public function destribuReceiptDate($game_id, $sdate, $edate)
    {
        if ($sdate == '') {
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info = $this->mod->destribuReceiptDate($game_id, $sdate, $edate);
        if ($info['list']) {
            foreach ($info['list'] as $key => $val) {
                foreach ($val as $k => $v) {
                    $info['list'][$key][$k]['income'] = $v['income'] / 100;
                    $info['list'][$key]['total_income'] += $v['income'] / 100;
                    $info['total'][$k]['income'] += $v['income'] / 100;
                    $info['all'] += $v['income'] / 100;
                }

            }
            foreach ($info['list'] as $key => $val) {
                $total = $val['total_income'];
                unset($info['list'][$key]['total_income']);
                $total = array_merge(array('total_income' => $total), $info['list'][$key]);
                $info['list'][$key] = $total;
            }
        }
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['game_id'] = $game_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    public function destribuReceiptGame($game_id, $sdate, $edate)
    {
        if ($sdate == '') {
            $sdate = date('Y-m-d', strtotime('-1 month'));
        }
        if ($edate == '') {
            $edate = date('Y-m-d');
        }
        $info = $this->mod->destribuReceiptGame($game_id, $sdate, $edate);
        if ($info['list']) {
            foreach ($info['list'] as $key => $val) {
                foreach ($val as $k => $v) {
                    $info['list'][$key][$k]['income'] = $v['income'] / 100;
                    $info['list'][$key]['total_income'] += $v['income'] / 100;
                    $info['total'][$k]['income'] += $v['income'] / 100;
                    $info['all'] += $v['income'] / 100;
                }
            }
            foreach ($info['list'] as $key => $val) {
                $total = $val['total_income'];
                unset($info['list'][$key]['total_income']);
                $total = array_merge(array('total_income' => $total), $info['list'][$key]);
                $info['list'][$key] = $total;
            }
        }
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['game_id'] = $game_id;
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        return $info;
    }

    public function destribuConfig($game_id, $channel, $area, $prop)
    {

        $arr['game_id'] = $game_id;
        $arr['channel'] = $channel;
        $temp = explode('-', $area);
        $arr['money1'] = $temp[0];
        $arr['money2'] = $temp[1];
        $arr['prop'] = $prop;

        return $arr;
    }

    public function destribuConfigAction($data, $is_edit, $money1, $money2)
    {
        //check
        if (!$data['game_id']) {
            return array(
                'state' => false,
                'msg' => '请选择游戏！'
            );
        }
        if (!$data['channel_id']) {
            return array(
                'state' => false,
                'msg' => '请选择渠道！'
            );
        }

        $str = '';
        $str .= '<?php return ';
        $arr = LibUtil::config('ConfDestribu');
        if ($is_edit) {
            unset($arr[$data['game_id']][$data['channel_id']][$money1 . '-' . $money2]);
        }


        $count = count($data['money1']);
        for ($i = 0; $i < $count; $i++) {
            if ($data['money1'][$i] < 0) {
                return array(
                    'state' => false,
                    'msg' => '请填写金额1！'
                );
            }

            if (!$data['prop'][$i]) {
                return array(
                    'state' => false,
                    'msg' => '请填写比例！'
                );
            }

            if ($data['prop'][$i] <= 0 || $data['prop'][$i] > 1) {
                return array(
                    'state' => false,
                    'msg' => '比例必须为0.00~1.00区间范围！'
                );
            }
        }
        for ($i = 0; $i < $count; $i++) {


            $arr[$data['game_id']][$data['channel_id']][$data['money1'][$i] . '-' . $data['money2'][$i]] = $data['prop'][$i];
        }

        $str .= var_export($arr, 1);
        $root = dirname(dirname(__FILE__));
        file_put_contents($root . '/config/ConfDestribu.php', $str . ';');
        return array(
            'state' => true,
            'msg' => '配置修改成功！'
        );
    }


}