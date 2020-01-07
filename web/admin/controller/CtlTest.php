<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2018/12/26
 * Time: 18:20
 */

require_once LIB . '/library/GatewayClient/Gateway.php';

use GatewayClient\Gateway;

class CtlTest extends Controller
{
    private $mod;

    public function __construct()
    {
        //非超级管理员
        if (SrvAuth::$id != 1) {
            exit('forbidden');
        }

        $this->mod = new ModTest();
    }

    public function index()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        exit();


//        $data = array(
//            'active_time' => 1556071505,
//            'active_ip' => '14.29.126.87'
//        );
//        $ext = array(
//            'sum_device_id' => '0c6e040c06ab09bcf24e97dc96b845d2',
//            'callback_param' => 'COvAh4iL_vICEPvAh4iL_vICGJ7hy5jgASCPlofY3QEoh4jFx4v-8gIwDDgBQiEyMDE5MDQyNDEwMDQyODAxMDAyNTA2NjIwMzI4NTEwQzlIAVAA'
//        );
//
//        $monitor = array(
//            'monitor_id' => 5832,
//            'callback' => 'jrtt',
//            'ext' => $ext
//        );
//
//        $ret = YX::call('/monitor/adUpload/' . $monitor['callback'] . 'Upload', $monitor, $data['active_time'], $data['active_ip']);
//        var_dump($ret);
//        exit();

//        $package_name = 'dzy-lyftzcbb-yyb_android_yyb_1';
//        LibMemcache::delete(strtoupper(LibMemcacheName::$package_name . $package_name));
//        $package = LibMemcache::get(strtoupper(LibMemcacheName::$package_name . $package_name));
//        var_dump($package);
//        exit();
//
//
//        $this->outType = 'json';
//        $redis = LibRedis::getInstance();

        $uid = 116254;
        $user = LibRedis::get(LibRedis::$prefix_sdk_user . $uid);
        LibUtil::pr($user);
        exit();


        $cache_key = LibRedis::$prefix_sdk_update . '139_dzy-xbsh-jrtt_android_jrtt_149';
        $update = LibRedis::get($cache_key);
        print_r($update);
        exit();

        $arr = $redis->get(LibRedis::$prefix_sdk_channel_uid . '8751124_ 1108261557');
        var_dump($arr);
        exit();

        $keys = $redis->keys('*');
        //$active = $redis->lrange('active', 0, -1);
        //reg = $redis->lrange('reg', 0, -1);

        LibUtil::pr($keys);
        exit();

        $cache = $redis->get('CACHE_USER_162445');
        var_dump($cache);
        exit();

        $memcache = LibMemcache::getInstance();
        //$items = $memcache->getAllKeys();

        echo "<pre>";
        //print_r($keys);
        print_r($active);
        print_r($reg);
        //var_dump($items);
        echo "</pre>";
        exit();
    }

    /**
     * 更新游戏
     */
    public function updateGame()
    {
        $package = array();
        $tmp = $this->mod->getPackageAll();
        foreach ($tmp as $row) {
            $package[$row['game_id']] = $row['platform'];
        }

        $ModPlatform = new ModPlatform();
        $info = $ModPlatform->getGameList(0);
        foreach ($info['list'] as $row) {
            $game_id = $row['game_id'];
            $config = unserialize($row['config']);

            $data = array(
                'type' => $row['parent_id'] == 0 ? 0 : 1,
                'device_type' => isset($package[$row['game_id']]) ? $package[$row['game_id']] : ((int)$config['h5'] ? 3 : 2)
            );

            if ($row['parent_id'] == 213 && !isset($package[$row['game_id']])) {
                $data['type'] = 2;
            }

            $ModPlatform->updateGameAction($game_id, $data);
        }

        $SrvPlatform = new SrvPlatform();
        $SrvPlatform->clearCacheAll();
    }

    public function getLoginStat()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '512M');

        $header = array();
        for ($i = 0; $i < 31; $i++) {
            $header[] = date('Y-m-d', strtotime("2019-08-01 +{$i} day"));
        }

        $data = array();
        $info = $this->mod->getLoginStat(174, '2019-08-01', '2019-08-30');
        foreach ($info as $row) {
            $arr = array(
                $row['date'] => (int)$row['num']
            );
            $sdate = date('Y-m-d', strtotime($row['date'] . ' +1 day'));
            $tmp = $this->mod->getLoginStat(174, $sdate, '2019-08-31', explode(',', $row['ids']));
            foreach ($tmp as $v) {
                $arr[$v['date']] = (int)$v['num'];
            }

            $_tmp = array();
            foreach ($header as $d) {
                $_tmp[] = $arr[$d];
            }
            $data[] = $_tmp;
        }

        SrvPHPExcel::downloadExcel('我在江湖8月活跃', $header, $data);
    }

    public function ip()
    {
        $ip = array(
            '223.150.234.199',
            '207.226.141.205',
            '117.136.62.197',
            '202.159.118.50',
            '41.210.252.16',
            '159.148.119.39',
            '204.16.1.182',
            '193.37.152.206'
        );

        $obj = new LibIp();
        foreach ($ip as $i) {
            $r = $obj->getlocation($i);
            //$b = $obj::ipToProvince($i);
            $b = LibIp::ipApi($i);

            LibUtil::pr($r);
            LibUtil::pr($b);

            if (preg_match('/美国/', $r['country'])) {
                echo "=============";
            }

            echo "<br>";
        }

        exit();
    }

    public function payUpload()
    {
        $json = '{"callback":"ks","callback_reg":1,"callback_pay":1,"callback_url":"http:\/\/ad.partner.gifshow.com\/track\/activate?callback=-Q9IcO4-mvJlaD4b5AWbsZ1i-2plsePnWaPoY_XG1b8T6G94EtP9gV9gxkD4KZ5qK3VjZ6S_HUxV5QX8uZgv6YSAFTN_ACRsjvMCOCe6HovMNC6CN_rM3iWxjV2b9ZnsfLjI7vz9KdCcvuQ9P1_YJG4RwJIbzSLYKTK9Kz-ocnh9ZNtcT6g_qh721piuQBRJaOrGM54NA0NsNKZdJwq8xonrCBW4vfsMYUiAPWw_7w4Tp9TkNd7NnYt-_UFp0jP_"}';
        $ext = json_decode($json, true);
        $url = urldecode($ext['callback_url']);
        if (!$url) {
            return false;
        }

        $money_arr = array(10, 20, 30, 50, 100);
        $money = $money_arr[array_rand($money_arr)];
        $event_type = 3; //付费
        $event_time = time() * 1000; //毫秒
        $purchase_amount = $money; //金额，单位：元

        $url .= "&event_type={$event_type}&event_time={$event_time}&purchase_amount={$purchase_amount}";
        $result = LibUtil::request($url);
        echo $url;
        echo "<br>";
        var_dump($result);
        exit();
    }

    public function online()
    {
        //连接创玩SDK注册端口
        Gateway::$registerAddress = '127.0.0.1:1238';

//        $t1 = microtime(true);
//        $online = array();
//        $groupList = Gateway::getAllGroupIdList();
//        foreach ($groupList as $group) {
//            if (stripos($group, 'game') === 0) {
//                $game_id = intval(substr($group, 4));
//                $count = Gateway::getClientIdCountByGroup($group);
//                if ($count > 0) {
//                    $online[$game_id] = $count;
//                }
//            }
//        }
//        $t2 = microtime(true);
//        echo '耗时' . round($t2 - $t1, 3) . '秒<br>';
//
//        arsort($online);
//        LibUtil::pr($online);
//        exit();

        //----------------------------------------------

        $t1 = microtime(true);
        $online = array();
        $data = Gateway::getAllClientSessions();
        foreach ($data as $row) {
            $arr = $row['data'];
            if (empty($arr)) {
                continue;
            }

            if ((int)$arr['game_id'] <= 0) {
                continue;
            }

            $online[$arr['game_id']] += 1;
        }
        $t2 = microtime(true);
        echo '耗时' . round($t2 - $t1, 3) . '秒<br>';

        arsort($online);
        LibUtil::pr($online);
        exit();

        echo "websocket:";
        LibUtil::pr($websocket);
        echo "\n\n";
        exit();

        echo "总计：$online <br>";

        LibUtil::pr($onlines);
        echo "\n\n";

        $t2 = microtime(true);
        $m = memory_get_usage();
        echo '耗时' . round($t2 - $t1, 3) . '秒<br>';
        echo 'Now memory_get_usage: ' . round($m / 1024 / 1024, 2) . 'MB<br />';
        exit();
    }
}