<?php

class SrvIndex
{
    private $mod;

    public function __construct()
    {
        $this->mod = new ModIndex();
    }

    public function dataIndex()
    {
        $info = $this->mod->dataIndex();
        if ($info['list']['reg_money'][0]['reg_user']) {
            $info['list']['cost']['reg_cost'] = number_format($info['list']['cost']['cost'] / 100 / $info['list']['reg_money'][0]['reg_user'], '2', '.', '');

        } else {
            $info['list']['cost']['reg_cost'] = 0.00;
        }
        $info['list']['cost']['cost'] = number_format($info['list']['cost']['cost'] / 100, '0', '.', '');
        foreach ($info['list']['reg_money'] as $key => $val) {
            $info['list']['reg_money'][$key]['pay_money'] = number_format($val['pay_money'] / 100, '0', '.', '');
        }
        foreach ($info['list']['pay_hour'] as $key => $val) {
            $info['list']['pay_hour'][$key]['money'] = number_format($val['money'] / 100, '0', '.', '');
        }
        foreach ($info['list']['pay_hour'] as $key => $val) {
            $temp_date = explode(' ', $val['date']);
            $info['list']['hour_pay'][$temp_date[0]][] = $val;
        }

        foreach ($info['list']['hour_pay'] as $key => $val) {
            foreach ($val as $k => $v) {
                $temp_hour = explode(' ', $v['date']);

                $temp_hour = explode(':', $temp_hour[1]);

                $temp_arr[$key][(int)$temp_hour[0]] = $v;
            }

        }
        foreach ($temp_arr as $key => $val) {
            for ($i = 0; $i < 24; $i++) {
                if (!$val[$i]) {
                    $temp_arr[$key][$i]['money'] = 0;
                    if ($i < 10) {
                        $t_hour = $key . ' ' . '0' . $i . ':00:00';
                    } else {
                        $t_hour = $key . ' ' . $i . ':00:00';
                    }


                    $temp_arr[$key][$i]['date'] = $t_hour;

                }
            }
            ksort($temp_arr[$key]);
        }
        $info['list']['hour_pay'] = $temp_arr;
        unset($temp_arr);
        $pm = array();
        foreach ($info['list']['pay_month'] as $key => $val) {
            $pm[$val['month']] = $val;
        }
        $info['list']['pay_month'] = $pm;
        unset($pm);
        foreach ($info['list']['pay_month'] as $key => $val) {
            for ($i = 1; $i <= 12; $i++) {
                if (!$info['list']['pay_month'][$i]['month']) {
                    $info['list']['pay_month'][$i]['month'] = $i;
                    $info['list']['pay_month'][$i]['money'] = 0;
                }

            }
        }
        foreach ($info['list']['pay_month'] as $key => $val) {
            $info['list']['pay_month'][$key]['money'] = number_format($val['money'] / 100, '0', '.', '');
        }
        ksort($info['list']['pay_month']);
        foreach ($info['list']['pay_habit'] as $key => $val) {
            $info['list']['pay_habit'][$key]['level_money'] = number_format($val['level_money'] / 100, '0', '.', '');
            $info['list']['pay_habit'][$key]['color'] = $this->random_color();
        }
        return $info;
    }

    public function random_color()
    {
        mt_srand();
        $c = '';
        while (strlen($c) < 6) {
            $c .= sprintf("%02X", mt_rand(0, 255));
        }
        return $c;
    }

    /**
     * 获取当前管理员信息
     * @return array|bool|resource|string
     */
    public function getAdminInfo()
    {
        return $this->mod->getAdminInfo();
    }

    /**
     * 修改个人信息
     * @param $user
     * @param $data
     */
    public function modifyAdminInfo($user, $data)
    {
        if (!$data['password'] || !$data['password1'] || !$data['password2']) {
            LibUtil::response('请输入密码');
        }
        if (SrvAuth::signPwd($user['user'], $data['password'], $user['salt']) !== strtolower($user['pwd'])) {
            LibUtil::response('原密码不正确');
        }
        if ($data['password'] == $data['password1']) {
            LibUtil::response('原密码和新密码不能一样');
        }
        if (strlen($data['password1']) < 6) {
            LibUtil::response('密码不能低于6位');
        }
        if ($data['password1'] != $data['password2']) {
            LibUtil::response('两次密码不一致');
        }

        $result = $this->mod->modifyAdminInfo($data);
        if ($result) {
            LibUtil::response('修改成功', 1);
        } else {
            LibUtil::response('修改失败');
        }
    }
}