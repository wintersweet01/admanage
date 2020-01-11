<?php

class CtlJrtt extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvJrttAction();
    }

    /**
     * 刷新access_token
     */
    public function refreshToken()
    {
        $user_id = $this->R('user_id');
        $this->out = $this->srv->refreshToken($user_id);
    }

    /**
     * 授权回调
     */
    public function authCallback()
    {
        $state = $this->R('state');
        $auth_code = $this->R('auth_code');
        $result = $this->srv->authCallback($state, $auth_code);
        if ($result['code'] == 'F')
            exit($result['msg']);

        echo '<script language="javascript">setTimeout(function() {window.opener=null;window.open(\'\',\'_self\');window.close();}, 2000);</script>';
        exit('授权成功');
    }

    public function createAdConvert()
    {
        $monitor_id = $this->post('monitor_id'); // 推广链id
        $app_id = $this->post('app_id');
        $convert_type = $this->post('convert_type');
        $srv = new SrvBatchCreateAd();
        $response = $srv->createAdConvert($monitor_id, $app_id, $convert_type);
    }

    /**
     * 批量创建广告
     */
    public function batchCreateAd()
    {
        $data = [
            'game_id' => $this->post('game_id'),
            'type' => $this->post('type'),
            'image_list' => $this->post('image_list'),
            'user_id' => $this->post('user_id'),
            'channel_id' => $this->post('channel_id'),
            'package_id' => $this->post('package_id'),
            'operation' => $this->post('operation'),
            'title_list' => $this->post('title_list'),
        ];

        $srv = new SrvBatchCreateAd();
        try{
            $result = $srv->createAd($data);
            $this->out = $result;
        }catch (Exception $e){
            $this->out = ['code' => 'F', 'msg' => $e->getMessage()];
        }
    }

    /**
     * 获取行业列表
     * @throws Exception
     */
    public function getIndustry()
    {
        $this->out = $this->srv->getIndustry([], ['Access-Token:32e02251a7d8797202a57913524f5b46039cf937']);
    }

    /**
     * 查询广告主对应人群包
     */
    public function audienceSelect()
    {
        $param = [
            'advertiser_id' => '2915553993320755',
            'select_type' => 1,
            'offset' => $this->R('offset', 'int', 0),
            'limit' => $this->R('limit', 'int', 30)
        ];
        $this->out = $this->srv->audienceSelect($param, ['Access-Token:32e02251a7d8797202a57913524f5b46039cf937']);
    }


    /**
     * 获取兴趣关键词
     * @throws Exception
     */
    public function getInterestKeyword()
    {
        $json = <<<JSON
{"msg": "\u6210\u529f", "code": 0, "data": {"key_words": [{"num": "92\u4e07", "id": "220008639", "name": "\u6e38\u620f\u76f4\u64ad"}, {"num": "180\u4e07", "id": "149827", "name": "\u6e38\u620f\u5385"}, {"num": "23\u4e07", "id": "50312195", "name": "\u6e38\u620f\u5145\u503c"}, {"num": "230\u4e07", "id": "32089951", "name": "\u6e38\u620f\u6392\u884c\u699c"}, {"num": "1600\u4e07", "id": "410691", "name": "\u6e38\u620f\u738b"}, {"num": "3.0\u4e07", "id": "600922187", "name": "\u6e38\u620f\u52a0\u901f"}, {"num": "60\u4e07", "id": "358173161", "name": "\u6e38\u620f\u4e0b\u8f7d"}, {"num": "49\u4e07", "id": "254041433", "name": "\u6e38\u620f\u63a8\u8350"}, {"num": "30\u4e07", "id": "241136", "name": "\u6e38\u620f\u5e01"}], "query_id": "1577090012513575502"}}
JSON;
        $this->out = json_decode($json, true);
        /* $param = [
             'advertiser_id' => '2915553993320755',
             'query_words' => $this->R('query_words')
         ];
         $this->srv->getInterestKeyword($param,['Access-Token:32e02251a7d8797202a57913524f5b46039cf937'] );*/
    }

    /**
     * 获取兴趣类目
     * @throws Exception
     */
    public function getInterestCategory()
    {
        $json = <<<JSON
{"msg": "\u6210\u529f", "code": 0, "data": [{"num": "1.2\u4ebf", "children": [{"num": "1.2\u4ebf", "children": [{"num": "1300\u4e07", "children": [{"num": "570\u4e07", "id": "16020101", "name": "\u52a8\u4f5c\u5192\u9669\u6e38\u620f"}, {"num": "1200\u4e07", "id": "16020102", "name": "\u683c\u6597\u6e38\u620f"}], "name": "\u52a8\u4f5c\u6e38\u620f", "id": "160201"}, {"num": "4400\u4e07", "children": [{"num": "2000\u4e07", "id": "16020301", "name": "\u52a8\u4f5c\u89d2\u8272\u626e\u6f14\u6e38\u620f"}, {"num": "2300\u4e07", "id": "16020302", "name": "\u7b56\u7565\u56de\u5408\u89d2\u8272\u626e\u6f14\u6e38\u620f"}, {"num": "2900\u4e07", "id": "16020303", "name": "\u5f00\u653e\u4e16\u754c\u89d2\u8272\u626e\u6f14\u6e38\u620f"}, {"num": "650\u4e07", "id": "16020304", "name": "\u5361\u724c\u89d2\u8272\u626e\u6f14\u6e38\u620f"}], "name": "\u89d2\u8272\u626e\u6f14\u6e38\u620f", "id": "160203"}, {"num": "3700\u4e07", "children": [{"num": "2900\u4e07", "id": "16020401", "name": "\u4eba\u7269/\u52a8\u7269\u517b\u6210\u7c7b\u6e38\u620f"}, {"num": "1900\u4e07", "id": "16020403", "name": "\u57ce\u5e02\u5efa\u9020/\u7ecf\u8425\u7ba1\u7406\u7c7b\u6e38\u620f"}], "name": "\u6a21\u62df\u6e38\u620f", "id": "160204"}, {"num": "4300\u4e07", "children": [{"num": "1300\u4e07", "id": "16020501", "name": "\u56de\u5408\u5236\u7b56\u7565\u6e38\u620f"}, {"num": "1800\u4e07", "id": "16020502", "name": "\u5373\u65f6\u5236\u6218\u7565\u6e38\u620f"}, {"num": "1900\u4e07", "id": "16020503", "name": "MOBA"}, {"num": "950\u4e07", "id": "16020504", "name": "\u5854\u9632\u6e38\u620f"}], "name": "\u6218\u7565\u6e38\u620f", "id": "160205"}, {"num": "3700\u4e07", "children": [{"num": "780\u4e07", "id": "16020601", "name": "\u7b2c\u4e00\u4eba\u79f0/\u7b2c\u4e09\u4eba\u79f0\u5c04\u51fb"}, {"num": "1700\u4e07", "id": "16020603", "name": "\u98de\u884c/\u8f7d\u5177\u5c04\u51fb\u6e38\u620f"}], "name": "\u5c04\u51fb\u6e38\u620f", "id": "160206"}, {"num": "3400\u4e07", "id": "160207", "name": "\u7ade\u901f\u6e38\u620f"}, {"num": "3000\u4e07", "children": [{"num": "2800\u4e07", "id": "16020801", "name": "\u7bee\u7403"}, {"num": "190\u4e07", "id": "16020802", "name": "\u8db3\u7403"}], "name": "\u8fd0\u52a8\u6e38\u620f", "id": "160208"}, {"num": "3800\u4e07", "id": "160211", "name": "\u97f3\u4e50\u6e38\u620f"}, {"num": "2100\u4e07", "id": "160212", "name": "\u76ca\u667a\u7c7b\u6e38\u620f"}, {"num": "2600\u4e07", "id": "160213", "name": "\u6d88\u9664\u7c7b\u6e38\u620f"}, {"num": "1700\u4e07", "id": "160214", "name": "\u5361\u724c\u7c7b\u6e38\u620f"}, {"num": "320\u4e07", "id": "160215", "name": "\u89e3\u8c1c\u7c7b\u6e38\u620f"}, {"num": "1900\u4e07", "id": "160216", "name": "\u8dd1\u9177\u7c7b\u6e38\u620f"}, {"num": "1500\u4e07", "id": "160227", "name": "\u68cb\u7c7b\u6e38\u620f"}], "name": "\u6e38\u620f\uff08\u6309\u73a9\u6cd5\uff09", "id": "1602"}, {"num": "6500\u4e07", "children": [{"num": "1700\u4e07", "id": "160401", "name": "\u4e09\u56fd"}, {"num": "1400\u4e07", "id": "160404", "name": "\u4f20\u5947"}, {"num": "1800\u4e07", "id": "160407", "name": "\u50f5\u5c38"}, {"num": "730\u4e07", "id": "160413", "name": "\u751f\u5b58/\u5927\u9003\u6740"}, {"num": "970\u4e07", "id": "160416", "name": "\u57ce\u5e02\u5efa\u8bbe"}, {"num": "2800\u4e07", "id": "160419", "name": "\u5bab\u5ef7"}, {"num": "1600\u4e07", "id": "160423", "name": "\u6355\u9c7c"}, {"num": "1800\u4e07", "id": "160426", "name": "\u4ed9\u4fa0/\u6b66\u4fa0"}, {"num": "1600\u4e07", "id": "160432", "name": "\u79d1\u5e7b/\u9b54\u5e7b"}, {"num": "2200\u4e07", "id": "160435", "name": "\u7f8e\u5c11\u5973"}, {"num": "390\u4e07", "id": "160437", "name": "\u897f\u6e38"}, {"num": "3400\u4e07", "id": "160439", "name": "\u8d5b\u8f66"}, {"num": "3100\u4e07", "id": "160440", "name": "\u4f53\u80b2"}, {"num": "1400\u4e07", "id": "160443", "name": "\u65e5\u5f0f"}], "name": "\u6e38\u620f\uff08\u6309\u4e3b\u9898\uff09", "id": "1604"}], "name": "\u6e38\u620f", "id": "16"}, {"num": "4800\u4e07", "children": [{"num": "3300\u4e07", "children": [{"num": "3300\u4e07", "id": "180201", "name": "\u706b\u9505"}], "name": "\u7f8e\u98df", "id": "1802"}, {"num": "2900\u4e07", "children": [{"num": "610\u4e07", "id": "180301", "name": "\u6d77\u9c9c/\u6c34\u4ea7\u54c1"}, {"num": "2500\u4e07", "id": "180302", "name": "\u6c34\u679c"}], "name": "\u98df\u54c1\u751f\u9c9c", "id": "1803"}, {"num": "990\u4e07", "children": [{"num": "640\u4e07", "id": "180501", "name": "\u767d\u9152"}, {"num": "540\u4e07", "id": "180502", "name": "\u8461\u8404\u9152"}, {"num": "450\u4e07", "id": "180506", "name": "\u6d0b\u9152"}], "name": "\u9152\u6c34", "id": "1805"}, {"num": "1100\u4e07", "children": [{"num": "660\u4e07", "id": "180601", "name": "\u8c03\u5473\u54c1"}, {"num": "230\u4e07", "id": "180605", "name": "\u9762"}, {"num": "430\u4e07", "id": "180609", "name": "\u5357\u5317\u5e72\u8d27"}], "name": "\u7cae\u6cb9\u8c03\u5473", "id": "1806"}, {"num": "2500\u4e07", "id": "1807", "name": "\u5730\u65b9\u7279\u4ea7"}, {"num": "890\u4e07", "children": [{"num": "670\u4e07", "id": "180805", "name": "\u8702\u871c/\u67da\u5b50\u8336"}], "name": "\u996e\u6599\u51b2\u8c03", "id": "1808"}, {"num": "2300\u4e07", "children": [{"num": "290\u4e07", "id": "180901", "name": "\u82b1\u679c\u8336"}, {"num": "330\u4e07", "id": "180902", "name": "\u4e4c\u9f99\u8336/\u94c1\u89c2\u97f3"}, {"num": "390\u4e07", "id": "180903", "name": "\u9f99\u4e95/\u7eff\u8336"}, {"num": "280\u4e07", "id": "180905", "name": "\u666e\u6d31/\u9ed1\u8336"}, {"num": "290\u4e07", "id": "180909", "name": "\u7ea2\u8336"}, {"num": "220\u4e07", "id": "180911", "name": "\u767d\u8336"}], "name": "\u8317\u8336", "id": "1809"}, {"num": "2200\u4e07", "children": [{"num": "350\u4e07", "id": "182001", "name": "\u575a\u679c\u7092\u8d27"}, {"num": "270\u4e07", "id": "182006", "name": "\u871c\u996f\u679c\u5e72"}, {"num": "680\u4e07", "id": "182007", "name": "\u719f\u98df\u814a\u5473"}], "name": "\u4f11\u95f2\u98df\u54c1", "id": "1820"}], "name": "\u9910\u996e\u7f8e\u98df", "id": "18"}, {"num": "6100\u4e07", "children": [{"num": "5000\u4e07", "id": "1702", "name": "\u5a5a\u604b\u4ea4\u53cb"}, {"num": "3200\u4e07", "id": "1703", "name": "\u5a5a\u5e86"}, {"num": "2500\u4e07", "children": [{"num": "2100\u4e07", "id": "170401", "name": "\u65c5\u62cd"}, {"num": "2500\u4e07", "id": "170402", "name": "\u672c\u5730\u62cd\u6444"}], "name": "\u5a5a\u7eb1\u6444\u5f71", "id": "1704"}, {"num": "3200\u4e07", "children": [{"num": "2400\u4e07", "id": "170501", "name": "\u4e2a\u4eba\u5199\u771f"}, {"num": "2700\u4e07", "id": "170504", "name": "\u513f\u7ae5\u7167"}, {"num": "2800\u4e07", "id": "170505", "name": "\u4eb2\u5b50\u7167"}], "name": "\u6444\u5f71\u5199\u771f", "id": "1705"}, {"num": "1900\u4e07", "id": "1707", "name": "\u9c9c\u82b1\u901f\u9012"}, {"num": "630\u4e07", "id": "1708", "name": "\u519c\u8d44\u7eff\u690d\u4fee\u5efa\u79cd\u690d"}, {"num": "1300\u4e07", "id": "1709", "name": "\u5bb6\u653f"}, {"num": "800\u4e07", "children": [{"num": "250\u4e07", "id": "171601", "name": "\u897f\u533b"}], "name": "\u533b\u7597\u670d\u52a1", "id": "1716"}, {"num": "210\u4e07", "id": "1717", "name": "\u5fc3\u7406\u5065\u5eb7\u670d\u52a1"}], "name": "\u751f\u6d3b\u670d\u52a1", "id": "17"}, {"num": "3600\u4e07", "children": [{"num": "2900\u4e07", "children": [{"num": "2800\u4e07", "id": "120101", "name": "\u6807\u51c6\u5316\u5bb6\u88c5\uff08\u88c5\u4fee\u5957\u9910\uff09"}, {"num": "2400\u4e07", "id": "120102", "name": "\u4e2a\u6027\u5316\u5bb6\u88c5"}, {"num": "340\u4e07", "id": "120103", "name": "\u5237\u65b0\u4e0e\u9632\u6c34"}, {"num": "2300\u4e07", "id": "120104", "name": "\u5bb6\u88c5\u5e73\u53f0"}], "name": "\u88c5\u4fee\u8bbe\u8ba1", "id": "1201"}, {"num": "1300\u4e07", "children": [{"num": "560\u4e07", "id": "120202", "name": "\u5ba2\u5385\u5bb6\u5177"}, {"num": "650\u4e07", "id": "120203", "name": "\u5367\u5ba4\u5bb6\u5177"}], "name": "\u5bb6\u5177", "id": "1202"}, {"num": "1400\u4e07", "children": [{"num": "520\u4e07", "id": "120301", "name": "\u536b\u6d74\u4e3b\u6750"}, {"num": "710\u4e07", "id": "120302", "name": "\u53a8\u623f\u4e3b\u6750"}, {"num": "450\u4e07", "id": "120303", "name": "\u6cb9\u6f06\u6d82\u6599"}, {"num": "1100\u4e07", "id": "120305", "name": "\u5730\u677f"}, {"num": "290\u4e07", "id": "120307", "name": "\u95e8"}, {"num": "580\u4e07", "id": "120308", "name": "\u58c1\u7eb8"}], "name": "\u5efa\u6750\u706f\u9970", "id": "1203"}, {"num": "850\u4e07", "children": [{"num": "150\u4e07", "id": "120405", "name": "\u63d2\u5ea7\u5f00\u5173"}], "name": "\u4e94\u91d1\u7535\u5de5", "id": "1204"}, {"num": "1000\u4e07", "children": [{"num": "740\u4e07", "id": "120501", "name": "\u5bb6\u7eba"}, {"num": "420\u4e07", "id": "120502", "name": "\u58c1\u6302\u6446\u4ef6\u8d34\u4ef6"}, {"num": "99\u4e07", "id": "120503", "name": "\u5730\u6bef\u5730\u57ab"}], "name": "\u5bb6\u5c45\u7528\u54c1\u53ca\u9970\u54c1", "id": "1205"}], "name": "\u5bb6\u5c45\u5bb6\u88c5", "id": "12"}, {"num": "5800\u4e07", "children": [{"num": "330\u4e07", "id": "1501", "name": "\u529e\u516c\u6587\u6559"}, {"num": "1800\u4e07", "id": "1502", "name": "\u6c42\u804c\u62db\u8058"}, {"num": "1200\u4e07", "children": [{"num": "490\u4e07", "id": "150301", "name": "\u5efa\u7b51\u65bd\u5de5"}, {"num": "880\u4e07", "id": "150302", "name": "\u5efa\u7b51\u6750\u6599"}], "name": "\u5efa\u7b51\u5de5\u7a0b", "id": "1503"}, {"num": "1300\u4e07", "id": "1504", "name": "\u7535\u5b50\u7535\u5de5"}, {"num": "2000\u4e07", "id": "1505", "name": "\u5316\u5de5\u6750\u6599"}, {"num": "1400\u4e07", "id": "1506", "name": "\u673a\u68b0\u5668\u6750"}, {"num": "2800\u4e07", "children": [{"num": "630\u4e07", "id": "150700", "name": "\u4e92\u8054\u7f51\u8f6f\u4ef6\u52a0\u76df"}, {"num": "1600\u4e07", "id": "150703", "name": "\u5bb6\u5c45\u5efa\u6750\u62db\u5546\u52a0\u76df"}, {"num": "1500\u4e07", "id": "150705", "name": "\u623f\u4ea7\u52a0\u76df"}, {"num": "990\u4e07", "id": "150708", "name": "\u6559\u80b2\u57f9\u8bad\u52a0\u76df"}, {"num": "280\u4e07", "id": "150710", "name": "\u673a\u68b0\u7535\u5b50\u52a0\u76df"}, {"num": "430\u4e07", "id": "150711", "name": "\u6c7d\u8f66\u4ea7\u54c1\u52a0\u76df"}, {"num": "690\u4e07", "id": "150712", "name": "\u751f\u6d3b\u670d\u52a1\u52a0\u76df"}, {"num": "1200\u4e07", "id": "150713", "name": "\u751f\u6d3b\u7528\u54c1\u52a0\u76df"}, {"num": "800\u4e07", "id": "150716", "name": "\u7f8e\u5bb9\u7f8e\u53d1\u51cf\u80a5\u52a0\u76df"}, {"num": "1400\u4e07", "id": "150719", "name": "\u98df\u54c1\u996e\u6599\u52a0\u76df"}, {"num": "1500\u4e07", "id": "150720", "name": "\u9910\u996e\u52a0\u76df"}], "name": "\u62db\u5546\u52a0\u76df", "id": "1507"}, {"num": "1500\u4e07", "id": "1508", "name": "\u519c\u6797\u7267\u6e14"}, {"num": "690\u4e07", "id": "1509", "name": "\u8282\u80fd\u73af\u4fdd"}, {"num": "65\u4e07", "id": "1510", "name": "\u5b89\u5168\u5b89\u4fdd"}, {"num": "950\u4e07", "id": "1511", "name": "\u7269\u6d41\u8fd0\u8f93"}, {"num": "2100\u4e07", "children": [{"num": "1300\u4e07", "id": "151202", "name": "\u5e7f\u544a\u4ee3\u7406"}, {"num": "670\u4e07", "id": "151203", "name": "\u7b56\u5212\u670d\u52a1"}], "name": "\u8425\u9500\u5e7f\u544a", "id": "1512"}, {"num": "1600\u4e07", "children": [{"num": "110\u4e07", "id": "151301", "name": "\u54a8\u8be2\u4ee3\u7406"}, {"num": "1000\u4e07", "id": "151303", "name": "\u8d22\u52a1\u7a0e\u52a1"}, {"num": "170\u4e07", "id": "151304", "name": "\u79fb\u6c11\u4e2d\u4ecb"}], "name": "\u4e13\u4e1a\u54a8\u8be2", "id": "1513"}, {"num": "330\u4e07", "id": "1514", "name": "\u5c55\u4f1a\u670d\u52a1"}, {"num": "3200\u4e07", "id": "1515", "name": "\u670d\u52a1\u5916\u5305"}, {"num": "190\u4e07", "id": "1516", "name": "IT\u670d\u52a1"}, {"num": "1100\u4e07", "id": "1517", "name": "\u6cd5\u5f8b\u670d\u52a1"}, {"num": "550\u4e07", "id": "1518", "name": "\u62cd\u5356\u670d\u52a1"}, {"num": "3100\u4e07", "id": "1519", "name": "\u9879\u76ee\u6295\u8d44"}, {"num": "3200\u4e07", "id": "1520", "name": "\u4e2a\u4f53\u521b\u4e1a"}], "name": "\u5546\u52a1\u670d\u52a1", "id": "15"}, {"num": "4700\u4e07", "children": [{"num": "1900\u4e07", "children": [{"num": "380\u4e07", "id": "70109", "name": "\u7535\u5b50\u79e4/\u5065\u5eb7\u7c7b\u4eea\u5668"}, {"num": "1000\u4e07", "id": "70110", "name": "\u6309\u6469\u6905"}, {"num": "1500\u4e07", "id": "70111", "name": "\u6309\u6469\u5668"}], "name": "\u4e2a\u62a4\u7535\u5668", "id": "701"}, {"num": "1900\u4e07", "children": [{"num": "1500\u4e07", "id": "70211", "name": "\u7535\u70ed\u6c34\u5668"}, {"num": "190\u4e07", "id": "70221", "name": "\u7ede\u8089\u673a"}, {"num": "640\u4e07", "id": "70223", "name": "\u591a\u7528\u9014\u9505"}, {"num": "1300\u4e07", "id": "70231", "name": "\u69a8\u6c41\u673a/\u539f\u6c41\u673a"}, {"num": "75\u4e07", "id": "70239", "name": "\u7535\u9676\u7089"}], "name": "\u53a8\u536b\u5bb6\u7535", "id": "702"}, {"num": "410\u4e07", "id": "703", "name": "\u5546\u7528\u7535\u5668"}, {"num": "4200\u4e07", "children": [{"num": "4200\u4e07", "id": "70402", "name": "\u51b0\u7bb1"}, {"num": "1900\u4e07", "id": "70403", "name": "\u7a7a\u8c03"}], "name": "\u5927\u5bb6\u7535", "id": "704"}, {"num": "3000\u4e07", "children": [{"num": "650\u4e07", "id": "70501", "name": "\u97f3\u54cd"}, {"num": "2700\u4e07", "id": "70503", "name": "\u5bb6\u5ead\u5f71\u9662"}, {"num": "1300\u4e07", "id": "70504", "name": "\u5e73\u677f\u7535\u89c6"}], "name": "\u5ba2\u5385\u5bb6\u7535", "id": "705"}, {"num": "1400\u4e07", "children": [{"num": "570\u4e07", "id": "70703", "name": "\u7a7a\u6c14\u51c0\u5316\u5668"}, {"num": "470\u4e07", "id": "70706", "name": "\u51c0\u6c34\u5668"}, {"num": "960\u4e07", "id": "70709", "name": "\u626b\u5730\u673a\u5668\u4eba"}, {"num": "210\u4e07", "id": "70717", "name": "\u5438\u5c18\u5668/\u9664\u87a8\u4eea"}, {"num": "190\u4e07", "id": "70718", "name": "\u996e\u6c34\u673a"}, {"num": "1100\u4e07", "id": "70720", "name": "\u53d6\u6696\u7535\u5668"}, {"num": "370\u4e07", "id": "70723", "name": "\u76f8\u673a\u548c\u76f8\u673a\u914d\u4ef6"}], "name": "\u751f\u6d3b\u5bb6\u7535", "id": "707"}], "name": "\u5bb6\u7535\u6570\u7801", "id": "7"}, {"num": "1.1\u4ebf", "children": [{"num": "3300\u4e07", "children": [{"num": "3300\u4e07", "id": "10101", "name": "\u5c11\u513f\u65e9\u6559"}], "name": "\u65e9\u6559\u4e0e\u5b66\u524d\u6559\u80b2", "id": "101"}, {"num": "3900\u4e07", "children": [{"num": "1000\u4e07", "id": "10201", "name": "\u5c0f\u5b66\u8f85\u5bfc"}, {"num": "<1\u4e07", "id": "10202", "name": "\u521d\u4e2d\u8f85\u5bfc"}, {"num": "1000\u4e07", "id": "10203", "name": "\u9ad8\u4e2d\u8f85\u5bfc"}, {"num": "2400\u4e07", "id": "10204", "name": "\u4e2d\u5c0f\u5b66\u7d20\u8d28\u6559\u80b2"}], "name": "\u4e2d\u5c0f\u5b66\u6559\u80b2", "id": "102"}, {"num": "8200\u4e07", "children": [{"num": "2000\u4e07", "id": "10402", "name": "\u8bbe\u8ba1\u7c7b\u57f9\u8bad\u4e0e\u6559\u80b2"}, {"num": "3000\u4e07", "id": "10403", "name": "\u5efa\u9020\u5e08\u8d44\u683c\u8003\u8bd5"}, {"num": "2600\u4e07", "id": "10404", "name": "\u6d88\u9632\u5de5\u7a0b\u57f9\u8bad\u4e0e\u6559\u80b2"}, {"num": "5200\u4e07", "id": "10405", "name": "\u53a8\u5e08\u57f9\u8bad\u4e0e\u8003\u8bd5"}, {"num": "950\u4e07", "id": "10406", "name": "\u4f01\u4e1a\u7ba1\u7406\u57f9\u8bad"}, {"num": "2900\u4e07", "children": [{"num": "2900\u4e07", "id": "1041001", "name": "\u4f1a\u8ba1\u5e08\u8d44\u683c\u8003\u8bd5"}], "name": "\u8d22\u7ecf\u8003\u8bd5", "id": "10410"}, {"num": "3400\u4e07", "id": "10412", "name": "\u7f8e\u5bb9\u7f8e\u53d1\u7f8e\u7532\u6559\u80b2"}, {"num": "4200\u4e07", "id": "10413", "name": "\u9a7e\u9a76\u57f9\u8bad\u4e0e\u8003\u8bd5"}, {"num": "910\u4e07", "id": "10415", "name": "\u8425\u9500\u7ba1\u7406\u6559\u80b2"}], "name": "\u804c\u4e1a\u6559\u80b2", "id": "104"}, {"num": "3400\u4e07", "children": [{"num": "860\u4e07", "id": "10501", "name": "\u6210\u4eba\u5b66\u5386\u6559\u80b2"}, {"num": "2100\u4e07", "id": "10503", "name": "\u7814\u7a76\u751f\u535a\u58eb\u751f\u6559\u80b2"}, {"num": "960\u4e07", "id": "10504", "name": "MBA/EMBA"}], "name": "\u5b66\u5386\u6559\u80b2", "id": "105"}, {"num": "2300\u4e07", "children": [{"num": "1700\u4e07", "id": "10601", "name": "\u9752\u5c11\u5e74\u82f1\u8bed"}, {"num": "2100\u4e07", "id": "10602", "name": "\u6210\u4eba\u82f1\u8bed"}], "name": "\u8bed\u8a00\u57f9\u8bad", "id": "106"}, {"num": "2500\u4e07", "id": "109", "name": "\u51fa\u56fd\u7559\u5b66"}], "name": "\u6559\u80b2", "id": "1"}, {"num": "3500\u4e07", "children": [{"num": "3000\u4e07", "id": "501", "name": "\u62a4\u80a4\u62a4\u7406"}, {"num": "2300\u4e07", "children": [{"num": "1400\u4e07", "children": [{"num": "1400\u4e07", "id": "5020110", "name": "\u7f8e\u5986/\u9762\u90e8\u5de5\u5177"}], "name": "\u7f8e\u5986\u5de5\u5177", "id": "50201"}, {"num": "2200\u4e07", "children": [{"num": "1900\u4e07", "id": "5020203", "name": "\u5507\u5f69\u5507\u871c/\u5507\u91c9"}, {"num": "1900\u4e07", "id": "5020209", "name": "\u7c89\u5e95\u6db2/\u818f"}, {"num": "1700\u4e07", "id": "5020210", "name": "\u9999\u6c34"}, {"num": "1700\u4e07", "id": "5020212", "name": "\u773c\u5f71/\u773c\u7ebf\u7b14/\u773c\u7ebf\u6db2"}, {"num": "1800\u4e07", "id": "5020213", "name": "\u53e3\u7ea2"}, {"num": "2000\u4e07", "id": "5020215", "name": "\u776b\u6bdb\u818f/\u589e\u957f\u6db2"}, {"num": "1300\u4e07", "id": "5020217", "name": "\u9694\u79bb\u971c/\u5986\u524d\u4e73"}, {"num": "490\u4e07", "id": "5020218", "name": "\u7709\u7b14/\u7709\u7c89"}, {"num": "1400\u4e07", "id": "5020219", "name": "\u906e\u7455"}], "name": "\u9999\u6c34\u5f69\u5986", "id": "50202"}], "name": "\u7f8e\u5986", "id": "502"}, {"num": "2600\u4e07", "id": "504", "name": "\u6d17\u53d1\u62a4\u53d1\u62a4\u7406"}, {"num": "2300\u4e07", "children": [{"num": "1100\u4e07", "id": "50516", "name": "\u7f8e\u53d1\u9020\u578b"}], "name": "\u7f8e\u53d1\u5047\u53d1/\u9020\u578b", "id": "505"}, {"num": "83\u4e07", "id": "506", "name": "\u6574\u5f62"}, {"num": "230\u4e07", "id": "507", "name": "\u51cf\u80a5\u7626\u8eab"}], "name": "\u7f8e\u5986\u62a4\u80a4\u62a4\u7406", "id": "5"}, {"num": "7500\u4e07", "children": [{"num": "2700\u4e07", "children": [{"num": "540\u4e07", "id": "80101", "name": "\u534e\u4e1c"}, {"num": "1200\u4e07", "id": "80102", "name": "\u534e\u5357"}, {"num": "980\u4e07", "id": "80103", "name": "\u534e\u5317"}, {"num": "1200\u4e07", "id": "80104", "name": "\u534e\u4e2d"}, {"num": "450\u4e07", "id": "80105", "name": "\u4e1c\u5317"}, {"num": "530\u4e07", "id": "80106", "name": "\u897f\u5317"}, {"num": "670\u4e07", "id": "80107", "name": "\u897f\u5357"}, {"num": "910\u4e07", "id": "80108", "name": "\u6e2f\u6fb3\u53f0"}], "name": "\u56fd\u5185\u6e38", "id": "801"}, {"num": "2600\u4e07", "children": [{"num": "1100\u4e07", "id": "80201", "name": "\u4e1c\u5357\u4e9a"}, {"num": "130\u4e07", "id": "80202", "name": "\u65e5\u97e9"}, {"num": "18\u4e07", "id": "80203", "name": "\u5357\u4e9a"}, {"num": "380\u4e07", "id": "80204", "name": "\u4e9a\u6d32\u5176\u5b83"}, {"num": "35\u4e07", "id": "80205", "name": "\u6b27\u6d32"}, {"num": "200\u4e07", "id": "80209", "name": "\u5927\u6d0b\u6d32"}], "name": "\u5883\u5916\u6e38", "id": "802"}, {"num": "4500\u4e07", "children": [{"num": "470\u4e07", "id": "80701", "name": "\u9ad8\u7aef\u9152\u5e97"}, {"num": "44\u4e07", "id": "80702", "name": "\u4e2d\u7aef\u9152\u5e97"}, {"num": "220\u4e07", "id": "80703", "name": "\u7ecf\u6d4e\u9152\u5e97"}, {"num": "1300\u4e07", "id": "80704", "name": "\u5546\u52a1\u9152\u5e97"}, {"num": "610\u4e07", "id": "80705", "name": "\u6c11\u5bbf"}, {"num": "2600\u4e07", "id": "80706", "name": "\u516c\u5bd3"}], "name": "\u9152\u5e97\u4f4f\u5bbf", "id": "807"}, {"num": "1200\u4e07", "children": [{"num": "1100\u4e07", "id": "80802", "name": "\u673a\u7968"}], "name": "\u4ea4\u901a\u7968\u52a1", "id": "808"}, {"num": "2100\u4e07", "children": [{"num": "50\u4e07", "id": "80901", "name": "\u540d\u80dc\u53e4\u8ff9"}, {"num": "830\u4e07", "id": "80902", "name": "\u81ea\u7136\u98ce\u5149"}, {"num": "1100\u4e07", "id": "80903", "name": "\u4e3b\u9898\u4e50\u56ed"}], "name": "\u666f\u70b9\u7968\u52a1", "id": "809"}], "name": "\u65c5\u6e38", "id": "8"}, {"num": "2700\u4e07", "children": [{"num": "1300\u4e07", "id": "301", "name": "\u8425\u517b\u8f85\u98df"}, {"num": "2200\u4e07", "children": [{"num": "2200\u4e07", "id": "30301", "name": "\u5a74\u5e7c\u5976\u7c89"}], "name": "\u5976\u7c89", "id": "303"}, {"num": "400\u4e07", "children": [{"num": "400\u4e07", "id": "30404", "name": "\u5a74\u513f\u5c3f\u88e4"}], "name": "\u5c3f\u88e4\u6e7f\u5dfe", "id": "304"}, {"num": "1200\u4e07", "id": "306", "name": "\u7ae5\u978b"}, {"num": "1100\u4e07", "children": [{"num": "890\u4e07", "id": "30701", "name": "\u76ca\u667a\u73a9\u5177"}, {"num": "940\u4e07", "id": "30702", "name": "\u5a03\u5a03\u73a9\u5177"}, {"num": "61\u4e07", "id": "30707", "name": "\u79ef\u6728"}, {"num": "470\u4e07", "id": "30708", "name": "\u9065\u63a7\u98de\u673a"}, {"num": "96\u4e07", "id": "30711", "name": "\u9065\u63a7\u8f66"}, {"num": "80\u4e07", "id": "30712", "name": "\u673a\u5668\u4eba"}], "name": "\u513f\u7ae5\u73a9\u5177", "id": "307"}, {"num": "1300\u4e07", "id": "308", "name": "\u5988\u5988\u4e13\u533a"}, {"num": "1100\u4e07", "id": "317", "name": "\u5582\u517b\u7528\u54c1"}, {"num": "310\u4e07", "id": "318", "name": "\u7ae5\u88c5"}, {"num": "280\u4e07", "id": "319", "name": "\u6d17\u62a4\u7528\u54c1"}], "name": "\u6bcd\u5a74", "id": "3"}, {"num": "5000\u4e07", "children": [{"num": "3800\u4e07", "children": [{"num": "3700\u4e07", "id": "110101", "name": "\u804a\u5929\u4ea4\u53cb"}, {"num": "3600\u4e07", "id": "110102", "name": "\u5a5a\u604b"}], "name": "\u793e\u4ea4", "id": "1101"}, {"num": "3800\u4e07", "children": [{"num": "3800\u4e07", "children": [{"num": "3800\u4e07", "id": "11020103", "name": "\u77ed\u89c6\u9891"}], "name": "\u89c6\u9891", "id": "110201"}], "name": "\u5f71\u97f3\u64ad\u653e", "id": "1102"}, {"num": "4400\u4e07", "children": [{"num": "4300\u4e07", "id": "110303", "name": "\u7535\u5b50\u4e66"}], "name": "\u8d44\u8baf\u9605\u8bfb", "id": "1103"}, {"num": "3900\u4e07", "id": "1104", "name": "\u6444\u5f71\u56fe\u50cf"}, {"num": "4000\u4e07", "children": [{"num": "2300\u4e07", "id": "110501", "name": "\u5b66\u4e60\u5de5\u5177"}], "name": "\u8003\u8bd5\u5b66\u4e60", "id": "1105"}, {"num": "3500\u4e07", "children": [{"num": "3300\u4e07", "id": "110601", "name": "\u7535\u5546\u5e73\u53f0"}, {"num": "3000\u4e07", "id": "110602", "name": "\u56e2\u8d2d/\u4f18\u60e0"}], "name": "\u7f51\u8d2d\u5e73\u53f0", "id": "1106"}, {"num": "3900\u4e07", "children": [{"num": "2100\u4e07", "id": "110805", "name": "\u623f\u4ea7\u5bb6\u5c45"}, {"num": "2400\u4e07", "id": "110806", "name": "\u6c7d\u8f66\u8d44\u8baf"}], "name": "\u751f\u6d3b\u4f11\u95f2", "id": "1108"}, {"num": "3800\u4e07", "children": [{"num": "2000\u4e07", "id": "110903", "name": "\u65c5\u6e38\u4f4f\u5bbf"}, {"num": "3500\u4e07", "id": "110904", "name": "\u65c5\u884c\u653b\u7565"}, {"num": "1700\u4e07", "id": "110905", "name": "\u7528\u8f66\u79df\u8f66"}], "name": "\u65c5\u6e38\u51fa\u884c", "id": "1109"}, {"num": "3100\u4e07", "id": "1110", "name": "\u5065\u5eb7\u8fd0\u52a8"}, {"num": "2200\u4e07", "id": "1111", "name": "\u529e\u516c\u5546\u52a1"}, {"num": "2500\u4e07", "id": "1112", "name": "\u80b2\u513f\u4eb2\u5b50"}], "name": "\u5e94\u7528\u8f6f\u4ef6", "id": "11"}, {"num": "4600\u4e07", "children": [{"num": "510\u4e07", "children": [{"num": "250\u4e07", "id": "90201", "name": "\u6d74\u5ba4\u7528\u54c1"}, {"num": "130\u4e07", "id": "90203", "name": "\u6d17\u6652/\u71a8\u70eb"}, {"num": "220\u4e07", "id": "90204", "name": "\u96e8\u4f1e\u96e8\u5177"}, {"num": "130\u4e07", "id": "90206", "name": "\u51c0\u5316\u9664\u5473"}], "name": "\u751f\u6d3b\u65e5\u7528", "id": "902"}, {"num": "1300\u4e07", "children": [{"num": "1200\u4e07", "id": "90305", "name": "\u4fdd\u6e29\u676f"}, {"num": "460\u4e07", "id": "90307", "name": "\u73bb\u7483\u676f"}, {"num": "120\u4e07", "id": "90309", "name": "\u9152\u676f/\u9152\u5177"}], "name": "\u6c34\u5177\u9152\u5177", "id": "903"}, {"num": "510\u4e07", "children": [{"num": "390\u4e07", "id": "90402", "name": "\u8336\u58f6"}, {"num": "410\u4e07", "id": "90404", "name": "\u6574\u5957\u8336\u5177"}, {"num": "310\u4e07", "id": "90406", "name": "\u8336\u676f"}], "name": "\u8336\u5177", "id": "904"}, {"num": "210\u4e07", "id": "905", "name": "\u5496\u5561\u5177"}, {"num": "990\u4e07", "children": [{"num": "950\u4e07", "children": [{"num": "470\u4e07", "id": "9060101", "name": "\u53a8\u623f\u7f6e\u7269\u67b6"}, {"num": "150\u4e07", "id": "9060102", "name": "\u4fdd\u9c9c\u76d2"}, {"num": "900\u4e07", "id": "9060106", "name": "\u53a8\u623f\u5200\u5177"}, {"num": "110\u4e07", "id": "9060108", "name": "\u76d8\u5b50\u7897/\u9910\u5177"}], "name": "\u53a8\u623f\u914d\u4ef6", "id": "90601"}, {"num": "460\u4e07", "children": [{"num": "460\u4e07", "id": "9060206", "name": "\u7092\u9505"}], "name": "\u70f9\u996a\u9505\u5177", "id": "90602"}], "name": "\u53a8\u5177", "id": "906"}, {"num": "1300\u4e07", "children": [{"num": "230\u4e07", "id": "90701", "name": "\u6e05\u6d01\u5237\u5177"}, {"num": "390\u4e07", "id": "90703", "name": "\u62d6\u628a/\u626b\u628a"}, {"num": "360\u4e07", "id": "90704", "name": "\u624b\u5957/\u978b\u5957/\u56f4\u88d9"}, {"num": "120\u4e07", "id": "90705", "name": "\u62b9\u5e03/\u767e\u6d01\u5e03"}, {"num": "110\u4e07", "id": "90706", "name": "\u5176\u5b83\u6e05\u6d01\u5de5\u5177"}, {"num": "1100\u4e07", "id": "90711", "name": "\u6cb9\u6c61\u6e05\u6d01\u5242"}, {"num": "160\u4e07", "id": "90713", "name": "\u6d01\u5395\u5242"}, {"num": "200\u4e07", "id": "90717", "name": "\u9a71\u868a\u9a71\u866b"}], "name": "\u6e05\u6d01\u7528\u5177", "id": "907"}, {"num": "340\u4e07", "id": "908", "name": "\u7eb8\u54c1/\u6e7f\u5dfe"}, {"num": "560\u4e07", "id": "909", "name": "\u8863\u7269\u6e05\u6d01"}, {"num": "600\u4e07", "children": [{"num": "590\u4e07", "id": "91201", "name": "\u7b14\u7c7b"}], "name": "\u6587\u5177", "id": "912"}, {"num": "3200\u4e07", "id": "913", "name": "\u4e50\u5668"}, {"num": "1200\u4e07", "id": "914", "name": "\u56fe\u4e66"}, {"num": "390\u4e07", "id": "915", "name": "\u9c9c\u82b1/\u7eff\u690d"}, {"num": "1500\u4e07", "id": "916", "name": "\u793c\u54c1"}, {"num": "3000\u4e07", "children": [{"num": "580\u4e07", "id": "91802", "name": "\u836f\u54c1\u4fdd\u5065"}], "name": "\u533b\u7597\u4fdd\u5065", "id": "918"}, {"num": "220\u4e07", "id": "919", "name": "\u68cb\u724c\u9ebb\u5c06"}, {"num": "820\u4e07", "id": "920", "name": "\u706b\u673a"}], "name": "\u65e5\u7528\u767e\u8d27", "id": "9"}, {"num": "2900\u4e07", "children": [{"num": "210\u4e07", "id": "1001", "name": "\u5ba0\u7269\u4e3b\u7cae"}, {"num": "2200\u4e07", "children": [{"num": "2200\u4e07", "id": "100201", "name": "\u5976\u7c89"}], "name": "\u533b\u7597\u4fdd\u5065", "id": "1002"}, {"num": "1200\u4e07", "id": "1003", "name": "\u5ba0\u7269\u5bb6\u5177"}, {"num": "290\u4e07", "id": "1004", "name": "\u6d17\u62a4\u7f8e\u5bb9"}, {"num": "950\u4e07", "id": "1005", "name": "\u5ba0\u7269\u96f6\u98df"}], "name": "\u5ba0\u7269\u751f\u6d3b", "id": "10"}, {"num": "3500\u4e07", "children": [{"num": "3000\u4e07", "children": [{"num": "2700\u4e07", "children": [{"num": "2600\u4e07", "id": "6010111", "name": "\u65e0\u7ebf\u8033\u673a"}, {"num": "84\u4e07", "id": "6010113", "name": "\u624b\u673a\u652f\u67b6"}, {"num": "760\u4e07", "id": "6010114", "name": "\u624b\u673a\u8d34\u819c"}], "name": "\u624b\u673a\u914d\u4ef6", "id": "60101"}], "name": "\u624b\u673a", "id": "601"}, {"num": "2200\u4e07", "id": "606", "name": "\u529e\u516c\u8bbe\u5907"}, {"num": "280\u4e07", "id": "607", "name": "\u7535\u8111\u6574\u673a"}, {"num": "180\u4e07", "children": [{"num": "85\u4e07", "id": "60901", "name": "\u9f20\u6807"}, {"num": "140\u4e07", "id": "60914", "name": "\u6444\u50cf\u5934"}], "name": "\u5916\u8bbe\u4ea7\u54c1", "id": "609"}], "name": "\u624b\u673a\u7535\u8111", "id": "6"}, {"num": "3500\u4e07", "children": [{"num": "2900\u4e07", "children": [{"num": "2700\u4e07", "children": [{"num": "240\u4e07", "id": "13020102", "name": "\u6b63\u88c5\u978b"}, {"num": "290\u4e07", "id": "13020103", "name": "\u589e\u9ad8\u978b"}, {"num": "210\u4e07", "id": "13020105", "name": "\u5de5\u88c5\u978b"}, {"num": "150\u4e07", "id": "13020109", "name": "\u7537\u9774"}, {"num": "300\u4e07", "id": "13020110", "name": "\u4f20\u7edf\u5e03\u978b"}], "name": "\u6d41\u884c\u7537\u978b", "id": "130201"}, {"num": "660\u4e07", "children": [{"num": "500\u4e07", "id": "13020206", "name": "\u51c9\u978b"}, {"num": "100\u4e07", "id": "13020207", "name": "\u5355\u978b"}, {"num": "260\u4e07", "id": "13020214", "name": "\u5185\u589e\u9ad8"}, {"num": "170\u4e07", "id": "13020220", "name": "\u9ad8\u8ddf\u978b"}, {"num": "76\u4e07", "id": "13020221", "name": "\u9a6c\u4e01\u9774"}], "name": "\u65f6\u5c1a\u5973\u978b", "id": "130202"}], "name": "\u978b\u9774", "id": "1302"}, {"num": "1900\u4e07", "children": [{"num": "530\u4e07", "children": [{"num": "170\u4e07", "id": "13030102", "name": "\u8d35\u91d1\u5c5e\u624b\u956f/\u624b\u94fe/\u811a\u94fe"}, {"num": "320\u4e07", "id": "13030103", "name": "\u8d35\u91d1\u5c5e\u6212\u6307"}, {"num": "310\u4e07", "id": "13030104", "name": "\u8d35\u91d1\u5c5e\u9879\u94fe"}], "name": "\u8d35\u91d1\u5c5e\u9996\u9970", "id": "130301"}, {"num": "1800\u4e07", "children": [{"num": "500\u4e07", "id": "13020203", "name": "\u5b9d\u77f3\u9879\u94fe"}], "name": "\u5b9d\u77f3\u9996\u9970", "id": "130302"}], "name": "\u73e0\u5b9d\u9996\u9970", "id": "1303"}, {"num": "1200\u4e07", "id": "1304", "name": "\u65f6\u5c1a\u9970\u54c1"}, {"num": "1700\u4e07", "children": [{"num": "510\u4e07", "id": "130501", "name": "\u7537\u7528\u5185\u8863"}, {"num": "1500\u4e07", "children": [{"num": "1300\u4e07", "id": "13050201", "name": "\u6587\u80f8"}, {"num": "1100\u4e07", "id": "13050202", "name": "\u7761\u8863/\u5bb6\u5c45\u670d"}, {"num": "500\u4e07", "id": "13050205", "name": "\u79cb\u8863\u79cb\u88e4"}, {"num": "160\u4e07", "id": "13050206", "name": "\u889c\u5b50"}, {"num": "650\u4e07", "id": "13050207", "name": "\u8fde\u88e4\u889c/\u4e1d\u889c"}, {"num": "610\u4e07", "id": "13050208", "name": "\u5185\u88e4"}], "name": "\u5973\u7528\u5185\u8863", "id": "130502"}], "name": "\u5185\u8863", "id": "1305"}, {"num": "2900\u4e07", "children": [{"num": "1900\u4e07", "children": [{"num": "160\u4e07", "id": "13060109", "name": "\u6bdb\u8863/\u9488\u7ec7\u886b/\u7f8a\u7ed2\u886b"}, {"num": "290\u4e07", "id": "13060128", "name": "\u6253\u5e95\u88e4"}, {"num": "510\u4e07", "id": "13060129", "name": "\u8fde\u8863\u88d9"}], "name": "\u5973\u88c5", "id": "130601"}, {"num": "430\u4e07", "children": [{"num": "170\u4e07", "id": "13060201", "name": "\u6bdb\u7ebf\u5e3d"}, {"num": "290\u4e07", "id": "13060205", "name": "\u7537\u58eb\u8170\u5e26/\u793c\u76d2"}, {"num": "420\u4e07", "id": "13060207", "name": "\u592a\u9633\u955c/\u9632\u8f90\u5c04\u773c\u955c"}, {"num": "310\u4e07", "id": "13060225", "name": "\u8001\u82b1\u955c"}], "name": "\u670d\u9970\u914d\u4ef6", "id": "130602"}, {"num": "1200\u4e07", "children": [{"num": "210\u4e07", "id": "13060301", "name": "\u9a6c\u7532/\u80cc\u5fc3"}, {"num": "590\u4e07", "id": "13060302", "name": "\u68c9\u670d"}, {"num": "82\u4e07", "id": "13060303", "name": "\u98ce\u8863"}, {"num": "490\u4e07", "id": "13060304", "name": "T\u6064"}, {"num": "410\u4e07", "id": "13060305", "name": "\u7f8a\u6bdb\u886b/\u7f8a\u7ed2\u886b/\u9488\u7ec7\u886b/\u6bdb\u8863"}, {"num": "390\u4e07", "id": "13060306", "name": "\u5510\u88c5/\u4e2d\u5c71\u88c5"}, {"num": "370\u4e07", "id": "13060310", "name": "\u725b\u4ed4\u88e4"}, {"num": "190\u4e07", "id": "13060312", "name": "\u536b\u8863"}, {"num": "760\u4e07", "id": "13060314", "name": "\u6bdb\u5462\u5927\u8863"}, {"num": "210\u4e07", "id": "13060315", "name": "\u5de5\u88c5"}, {"num": "520\u4e07", "id": "13060317", "name": "\u5939\u514b"}, {"num": "270\u4e07", "id": "13060318", "name": "\u886c\u886b"}, {"num": "370\u4e07", "id": "13060321", "name": "\u52a0\u7ed2\u88e4"}, {"num": "160\u4e07", "id": "13060322", "name": "\u897f\u670d"}, {"num": "200\u4e07", "id": "13060323", "name": "\u897f\u88e4"}, {"num": "350\u4e07", "id": "13060324", "name": "\u4f11\u95f2\u88e4"}, {"num": "1000\u4e07", "id": "13060325", "name": "\u897f\u670d\u5957\u88c5"}, {"num": "260\u4e07", "id": "13060326", "name": "\u7fbd\u7ed2\u670d"}, {"num": "130\u4e07", "id": "13060328", "name": "\u771f\u76ae\u76ae\u8863"}], "name": "\u7537\u88c5", "id": "130603"}], "name": "\u670d\u9970", "id": "1306"}, {"num": "2500\u4e07", "children": [{"num": "2100\u4e07", "children": [{"num": "1600\u4e07", "id": "13070103", "name": "\u5355\u80a9\u5305/\u659c\u630e\u5305"}, {"num": "2100\u4e07", "id": "13070104", "name": "\u624b\u63d0\u5305"}], "name": "\u5973\u5305", "id": "130701"}, {"num": "300\u4e07", "children": [{"num": "250\u4e07", "id": "13070206", "name": "\u7537\u58eb\u94b1\u5305"}, {"num": "160\u4e07", "id": "13070208", "name": "\u5355\u80a9/\u659c\u630e\u5305"}, {"num": "95\u4e07", "id": "13070209", "name": "\u53cc\u80a9\u5305"}, {"num": "190\u4e07", "id": "13070210", "name": "\u5546\u52a1\u516c\u6587\u5305"}], "name": "\u7537\u5305", "id": "130702"}], "name": "\u7bb1\u5305", "id": "1307"}, {"num": "1600\u4e07", "children": [{"num": "1100\u4e07", "id": "130901", "name": "\u53e4\u73a9\u7389\u5668"}, {"num": "150\u4e07", "id": "130902", "name": "\u5b57\u753b"}, {"num": "230\u4e07", "id": "130903", "name": "\u6728\u624b\u4e32/\u628a\u4ef6"}], "name": "\u6587\u73a9\u53e4\u8463", "id": "1309"}], "name": "\u670d\u9970\u978b\u5e3d\u7bb1\u5305", "id": "13"}, {"num": "4700\u4e07", "children": [{"num": "470\u4e07", "id": "1402", "name": "\u653f\u6cbb"}, {"num": "400\u4e07", "id": "1403", "name": "\u5546\u4e1a\u4e0e\u7ecf\u6d4e"}, {"num": "270\u4e07", "id": "1404", "name": "\u6148\u5584"}, {"num": "1200\u4e07", "id": "1406", "name": "\u73af\u4fdd"}, {"num": "3100\u4e07", "children": [{"num": "3000\u4e07", "id": "140802", "name": "\u97f3\u4e50"}, {"num": "2500\u4e07", "id": "140809", "name": "\u7535\u5f71\uff08\u6309\u4e3b\u9898\uff09"}, {"num": "2500\u4e07", "id": "140810", "name": "\u7535\u5f71\uff08\u6309\u5730\u57df\uff09"}], "name": "\u5a31\u4e50/\u540d\u4eba", "id": "1408"}, {"num": "3300\u4e07", "children": [{"num": "240\u4e07", "id": "141502", "name": "\u7ed8\u753b"}, {"num": "68\u4e07", "id": "141504", "name": "\u4e66\u6cd5"}], "name": "\u6587\u5316\u827a\u672f", "id": "1415"}, {"num": "4200\u4e07", "children": [{"num": "2100\u4e07", "id": "142900", "name": "\u623f\u4ea7\u5176\u4ed6"}, {"num": "4000\u4e07", "children": [{"num": "3100\u4e07", "id": "14290101", "name": "\u666e\u901a\u4f4f\u5b85\u4ea4\u6613"}, {"num": "570\u4e07", "id": "14290102", "name": "\u522b\u5885\u8c6a\u5b85\u4ea4\u6613"}, {"num": "92\u4e07", "id": "14290103", "name": "\u5546\u7528\u623f\u4ea4\u6613"}], "name": "\u623f\u4ea7\u4ea4\u6613", "id": "142901"}, {"num": "3400\u4e07", "children": [{"num": "3100\u4e07", "id": "14290201", "name": "\u666e\u901a\u4f4f\u5b85\u79df\u8d41"}], "name": "\u623f\u5c4b\u79df\u8d41", "id": "142902"}], "name": "\u623f\u4ea7", "id": "1429"}], "name": "\u65b0\u95fb\u8d44\u8baf", "id": "14"}, {"num": "4600\u4e07", "children": [{"num": "2300\u4e07", "children": [{"num": "2300\u4e07", "children": [{"num": "2300\u4e07", "id": "20050201", "name": "\u519b\u4e8b\u6218\u4e89"}], "name": "\u519b\u4e8b\u5c0f\u8bf4", "id": "200502"}], "name": "\u5386\u53f2\u519b\u4e8b", "id": "2005"}, {"num": "1300\u4e07", "children": [{"num": "1300\u4e07", "children": [{"num": "1300\u4e07", "id": "20070201", "name": "\u4fa6\u63a2\u63a8\u7406"}], "name": "\u60ac\u7591\u7075\u5f02", "id": "200702"}], "name": "\u79d1\u5e7b\u7075\u5f02", "id": "2007"}, {"num": "1200\u4e07", "children": [{"num": "1200\u4e07", "id": "202904", "name": "\u6cd5\u5f8b"}], "name": "\u4eba\u6587\u793e\u79d1", "id": "2029"}, {"num": "200\u4e07", "id": "2034", "name": "\u6559\u80b2"}], "name": "\u5c0f\u8bf4\u52a8\u6f2b\u9605\u8bfb", "id": "20"}, {"num": "3600\u4e07", "children": [{"num": "3500\u4e07", "id": "201", "name": "\u6c7d\u8f66\uff08\u6309\u52a8\u529b\uff09"}, {"num": "3500\u4e07", "id": "202", "name": "\u6c7d\u8f66\uff08\u6309\u7c7b\u578b\uff09"}, {"num": "3500\u4e07", "id": "204", "name": "\u6c7d\u8f66\uff08\u6309\u5ea7\u4f4d\uff09"}, {"num": "210\u4e07", "id": "206", "name": "\u6469\u6258\u8f66"}, {"num": "2700\u4e07", "id": "211", "name": "\u4e8c\u624b\u6c7d\u8f66"}, {"num": "1200\u4e07", "id": "212", "name": "\u6c7d\u8f66\u79df\u8d41"}, {"num": "1500\u4e07", "children": [{"num": "280\u4e07", "id": "21301", "name": "\u6c7d\u8f66\u88c5\u9970"}, {"num": "530\u4e07", "id": "21302", "name": "\u8f66\u8f7d\u7535\u5668"}], "name": "\u6c7d\u8f66\u7528\u54c1", "id": "213"}, {"num": "1800\u4e07", "children": [{"num": "1700\u4e07", "id": "21402", "name": "\u6c7d\u8f66\u4fdd\u517b"}], "name": "\u6c7d\u8f66\u670d\u52a1", "id": "214"}], "name": "\u4ea4\u901a", "id": "2"}, {"num": "2400\u4e07", "children": [{"num": "1500\u4e07", "children": [{"num": "730\u4e07", "id": "190203", "name": "\u8dd1\u6b65\u673a"}, {"num": "530\u4e07", "id": "190217", "name": "\u5065\u8179\u8f6e"}], "name": "\u5065\u8eab\u8bad\u7ec3", "id": "1902"}, {"num": "630\u4e07", "id": "1903", "name": "\u51b0\u4e0a\u8fd0\u52a8"}, {"num": "1200\u4e07", "id": "1904", "name": "\u9a91\u884c\u8fd0\u52a8"}, {"num": "920\u4e07", "children": [{"num": "220\u4e07", "id": "190507", "name": "\u5e10\u7bf7/\u57ab\u5b50"}], "name": "\u6237\u5916\u88c5\u5907", "id": "1905"}, {"num": "150\u4e07", "id": "1906", "name": "\u4f53\u80b2\u7528\u54c1"}, {"num": "1300\u4e07", "id": "1907", "name": "\u5782\u9493\u7528\u54c1"}, {"num": "450\u4e07", "id": "1908", "name": "\u8fd0\u52a8\u978b\u5305"}, {"num": "150\u4e07", "id": "1909", "name": "\u8fd0\u52a8\u670d\u9970"}, {"num": "160\u4e07", "id": "1910", "name": "\u8fd0\u52a8\u62a4\u5177"}, {"num": "380\u4e07", "id": "1911", "name": "\u6e38\u6cf3\u7528\u54c1"}, {"num": "430\u4e07", "id": "1912", "name": "\u745c\u4f3d\u821e\u8e48"}, {"num": "78\u4e07", "id": "1913", "name": "\u6237\u5916\u978b\u670d"}], "name": "\u8fd0\u52a8\u6237\u5916", "id": "19"}, {"num": "1.0\u4ebf", "children": [{"num": "6300\u4e07", "children": [{"num": "2500\u4e07", "children": [{"num": "1300\u4e07", "id": "4010101", "name": "\u666e\u5361"}, {"num": "250\u4e07", "id": "4010102", "name": "\u91d1\u5361"}, {"num": "370\u4e07", "id": "4010103", "name": "\u767d\u91d1\u5361"}], "name": "\u4fe1\u7528\u5361", "id": "40101"}, {"num": "3200\u4e07", "children": [{"num": "170\u4e07", "id": "4010202", "name": "\u8f66\u8d37"}, {"num": "1800\u4e07", "id": "4010203", "name": "\u6d88\u8d39\u8d37\u6b3e"}], "name": "\u4e2a\u4eba\u8d37\u6b3e", "id": "40102"}], "name": "\u94f6\u884c", "id": "401"}, {"num": "350\u4e07", "children": [{"num": "340\u4e07", "id": "40201", "name": "\u80a1\u7968"}], "name": "\u8bc1\u5238", "id": "402"}, {"num": "4200\u4e07", "children": [{"num": "1200\u4e07", "id": "40302", "name": "\u4eba\u8eab\u4fdd\u9669"}, {"num": "3100\u4e07", "id": "40303", "name": "\u75be\u75c5\u4fdd\u9669"}], "name": "\u4fdd\u9669", "id": "403"}, {"num": "2400\u4e07", "children": [{"num": "1300\u4e07", "id": "40601", "name": "\u8d37\u6b3e\u670d\u52a1"}], "name": "\u4e92\u8054\u7f51\u91d1\u878d", "id": "406"}], "name": "\u91d1\u878d", "id": "4"}]}
JSON;
        $data = json_decode($json, true);
        $this->out = $data;
        /*$param = [
            'advertiser_id' => '2915553993320755'
        ];
        $this->out = $this->srv->getInterestCategory($param, ['Access-Token:32e02251a7d8797202a57913524f5b46039cf937']);*/
    }

    /**
     * 获取行为类目词
     * @throws Exception
     */
    public function getActionCategory()
    {
        $param = [
            'advertiser_id' => '2915553993320755',
            'action_scene' => $this->R('action_scene'),
            'action_days' => $this->R('action_days')
        ];
        // TODO::测试环境不支持联调啊...
        $this->out = $this->srv->getActionCategory($param, ['Access-Token:32e02251a7d8797202a57913524f5b46039cf937']);
    }

    /**
     * 行为关键词查询
     */
    public function actionKeyword()
    {
        $json = <<<JSON
{
  "msg":"成功",
  "code":0,
  "data":{
    "list":[
      {
        "num":"<1万",
        "id":"472054399",
        "name":"崩坏3"
      },
      {
        "num":"82万",
        "id":"71465",
        "name":"手机游戏"
      },
      {
        "num":"110万",
        "id":"20947",
        "name":"卡通"
      },
      {
        "num":"410万",
        "id":"2519770",
        "name":"卡牌手游"
      },
      {
        "num":"1000万",
        "id":"226282",
        "name":"像素"
      },
      {
        "num":"200万",
        "id":"910848",
        "name":"桌游"
      },
      {
        "num":"<1万",
        "id":"151134",
        "name":"写实"
      },
      {
        "num":"1600万",
        "id":"164176",
        "name":"手游"
      },
      {
        "num":"<1万",
        "id":"3086456",
        "name":"掌机游戏"
      },
      {
        "num":"250万",
        "id":"2442050",
        "name":"唯美"
      },
      {
        "num":"6.6万",
        "id":"2506057",
        "name":"大逃杀"
      },
      {
        "num":"9.0万",
        "id":"511534",
        "name":"主机游戏"
      },
      {
        "num":"50万",
        "id":"40210",
        "name":"网游"
      },
      {
        "num":"490万",
        "id":"3961954",
        "name":"变态版"
      },
      {
        "num":"<1万",
        "id":"2495054",
        "name":"穿越火线"
      },
      {
        "num":"900万",
        "id":"17628",
        "name":"武侠"
      },
      {
        "num":"<1万",
        "id":"317598",
        "name":"网络游戏"
      },
      {
        "num":"50万",
        "id":"66178",
        "name":"水墨"
      },
      {
        "num":"<1万",
        "id":"50212378",
        "name":"魔幻小说"
      },
      {
        "num":"160万",
        "id":"38839",
        "name":"日系"
      },
      {
        "num":"100万",
        "id":"199083",
        "name":"街机"
      },
      {
        "num":"15万",
        "id":"517933969",
        "name":"贪吃蛇大作战"
      },
      {
        "num":"490万",
        "id":"39933",
        "name":"射击"
      },
      {
        "num":"3.8万",
        "id":"216184",
        "name":"任天堂"
      },
      {
        "num":"290万",
        "id":"65267",
        "name":"画质"
      },
      {
        "num":"<1万",
        "id":"542810",
        "name":"五子棋"
      },
      {
        "num":"370万",
        "id":"18118",
        "name":"动作"
      },
      {
        "num":"1.7万",
        "id":"17006",
        "name":"ps4"
      },
      {
        "num":"1.1万",
        "id":"717281",
        "name":"页游"
      },
      {
        "num":"7.8万",
        "id":"538633",
        "name":"单机游戏"
      },
      {
        "num":"370万",
        "id":"40377",
        "name":"冒险"
      },
      {
        "num":"<1万",
        "id":"47780086",
        "name":"神庙逃亡"
      },
      {
        "num":"300万",
        "id":"355277896",
        "name":"魔幻手游"
      },
      {
        "num":"18万",
        "id":"212075",
        "name":"推理"
      },
      {
        "num":"650万",
        "id":"16329",
        "name":"剧情"
      }
    ],
    "query_id":"1576744941470336005"
  }
}
JSON;

        $this->out = json_decode($json, true);
        /*$param = [
            'advertiser_id' => '2915553993320755',
            'query_words' => $this->get('query_words'),
            'action_scene' => $this->get('action_scene'),
            'action_days' => $this->get('action_days'),
        ];
        $this->out = $this->srv->getActionKeyword($param, ['Access-Token:32e02251a7d8797202a57913524f5b46039cf937']);*/
    }

    /**
     * 行为兴趣关键词推荐
     */
    public function keywordSuggest()
    {
        $json = <<<JSON
{
    "msg":"成功",
    "code":0,
    "data":{
        "key_words":[
            {
                "num":"<1万",
                "id":"2400931",
                "name":"哈哈"
            },
            {
                "num":"2.3万",
                "id":"94903",
                "name":"咆哮"
            },
            {
                "num":"<1万",
                "id":"3449397",
                "name":"大话三国"
            },
            {
                "num":"<1万",
                "id":"604778384",
                "name":"搞笑排行榜"
            },
            {
                "num":"750万",
                "id":"2416310",
                "name":"哈哈哈"
            },
            {
                "num":"58万",
                "id":"37691",
                "name":"颠覆"
            },
            {
                "num":"<1万",
                "id":"2878264",
                "name":"逗逼"
            },
            {
                "num":"<1万",
                "id":"2380974549",
                "name":"搞笑手游"
            },
            {
                "num":"<1万",
                "id":"115794844",
                "name":"无下限"
            },
            {
                "num":"1500万",
                "id":"265529",
                "name":"魔性"
            },
            {
                "num":"<1万",
                "id":"315887567",
                "name":"超时空乱斗"
            },
            {
                "num":"<1万",
                "id":"5960481",
                "name":"妖妖灵"
            },
            {
                "num":"<1万",
                "id":"2314624363",
                "name":"爆笑大乱斗"
            },
            {
                "num":"4.9万",
                "id":"5784967",
                "name":"捉妖记"
            },
            {
                "num":"<1万",
                "id":"74828382",
                "name":"翻滚吧"
            },
            {
                "num":"<1万",
                "id":"6718047",
                "name":"卡牌西游"
            },
            {
                "num":"830万",
                "id":"2421705",
                "name":"爆笑"
            },
            {
                "num":"<1万",
                "id":"2414827018",
                "name":"桃园三兄弟"
            },
            {
                "num":"7.1万",
                "id":"2427921",
                "name":"无厘头"
            },
            {
                "num":"<1万",
                "id":"2314665729",
                "name":"斗妖传"
            },
            {
                "num":"410万",
                "id":"311135",
                "name":"鬼畜"
            },
            {
                "num":"<1万",
                "id":"307810181",
                "name":"作妖计"
            },
            {
                "num":"1.2万",
                "id":"2382255176",
                "name":"鬼畜手游"
            },
            {
                "num":"10万",
                "id":"705137",
                "name":"合体技"
            },
            {
                "num":"<1万",
                "id":"2314616121",
                "name":"战斗吧弱鸡"
            },
            {
                "num":"<1万",
                "id":"60197402",
                "name":"爆笑三国"
            },
            {
                "num":"<1万",
                "id":"272183537",
                "name":"时空大乱斗"
            },
            {
                "num":"12万",
                "id":"606755190",
                "name":"魔性手游"
            },
            {
                "num":"<1万",
                "id":"638189683",
                "name":"跨时空"
            },
            {
                "num":"<1万",
                "id":"2389530256",
                "name":"爆笑手游"
            },
            {
                "num":"<1万",
                "id":"2372912572",
                "name":"妖怪饶命"
            },
            {
                "num":"25万",
                "id":"2446735",
                "name":"封神榜"
            },
            {
                "num":"76万",
                "id":"2613224",
                "name":"哪吒"
            },
            {
                "num":"<1万",
                "id":"2908528",
                "name":"贱萌"
            },
            {
                "num":"<1万",
                "id":"65177742",
                "name":"尖叫鸡"
            },
            {
                "num":"<1万",
                "id":"2381265026",
                "name":"冲啊三国"
            },
            {
                "num":"<1万",
                "id":"260144",
                "name":"卧龙传说"
            },
            {
                "num":"<1万",
                "id":"417619889",
                "name":"鬼畜三国"
            },
            {
                "num":"14万",
                "id":"2522611",
                "name":"逗比"
            },
            {
                "num":"<1万",
                "id":"2389265090",
                "name":"鬼畜大乱斗"
            },
            {
                "num":"52万",
                "id":"7703672",
                "name":"乱斗"
            },
            {
                "num":"<1万",
                "id":"2985988",
                "name":"封神记"
            },
            {
                "num":"22万",
                "id":"47809533",
                "name":"十万个冷笑话"
            },
            {
                "num":"<1万",
                "id":"532043652",
                "name":"搞笑游戏"
            },
            {
                "num":"860万",
                "id":"4783338",
                "name":"脑洞"
            },
            {
                "num":"<1万",
                "id":"50046005",
                "name":"桃园结义"
            },
            {
                "num":"150万",
                "id":"2413722",
                "name":"恶搞"
            },
            {
                "num":"78万",
                "id":"66401118",
                "name":"脑洞大开"
            },
            {
                "num":"180万",
                "id":"17870",
                "name":"周星驰"
            },
            {
                "num":"<1万",
                "id":"193060066",
                "name":"时空乱斗"
            },
            {
                "num":"<1万",
                "id":"2494583343",
                "name":"魔性三国"
            },
            {
                "num":"<1万",
                "id":"1200894603",
                "name":"热血武道会"
            },
            {
                "num":"<1万",
                "id":"2320594976",
                "name":"内涵三国"
            },
            {
                "num":"410万",
                "id":"2519770",
                "name":"卡牌手游"
            },
            {
                "num":"<1万",
                "id":"663686748",
                "name":"恶搞三国"
            },
            {
                "num":"4.8万",
                "id":"2395135145",
                "name":"恶搞手游"
            },
            {
                "num":"69万",
                "id":"2417475",
                "name":"磕头"
            },
            {
                "num":"3.7万",
                "id":"50521569",
                "name":"道友请留步"
            },
            {
                "num":"<1万",
                "id":"2571092",
                "name":"桃园三结义"
            },
            {
                "num":"<1万",
                "id":"4954130",
                "name":"封神传"
            },
            {
                "num":"<1万",
                "id":"656597004",
                "name":"鬼畜游戏"
            },
            {
                "num":"8.9万",
                "id":"165131",
                "name":"冷笑话"
            },
            {
                "num":"4.0万",
                "id":"66344",
                "name":"糗事"
            },
            {
                "num":"280万",
                "id":"20699",
                "name":"笑话"
            },
            {
                "num":"<1万",
                "id":"2455540",
                "name":"无节操"
            },
            {
                "num":"770万",
                "id":"15363",
                "name":"段子"
            },
            {
                "num":"1.4万",
                "id":"452588418",
                "name":"鬼畜合体"
            },
            {
                "num":"490万",
                "id":"17999",
                "name":"奇葩"
            },
            {
                "num":"61万",
                "id":"16517",
                "name":"内涵"
            },
            {
                "num":"2800万",
                "id":"299422",
                "name":"小游戏"
            },
            {
                "num":"24万",
                "id":"71772006",
                "name":"跑酷游戏"
            },
            {
                "num":"160万",
                "id":"54526199",
                "name":"大作战"
            },
            {
                "num":"44万",
                "id":"2574635",
                "name":"大乱斗"
            },
            {
                "num":"<1万",
                "id":"71556103",
                "name":"恶搞游戏"
            },
            {
                "num":"310万",
                "id":"170937",
                "name":"大魔王"
            },
            {
                "num":"<1万",
                "id":"642119117",
                "name":"收集癖"
            },
            {
                "num":"<1万",
                "id":"722978951",
                "name":"卡牌合成"
            },
            {
                "num":"<1万",
                "id":"639259587",
                "name":"回合三国"
            },
            {
                "num":"<1万",
                "id":"51106524",
                "name":"水煮三国"
            },
            {
                "num":"<1万",
                "id":"50357849",
                "name":"乱斗三国"
            },
            {
                "num":"<1万",
                "id":"223407944",
                "name":"暴走三国"
            },
            {
                "num":"18万",
                "id":"97438",
                "name":"刘关张"
            },
            {
                "num":"<1万",
                "id":"77178104",
                "name":"山海伏妖录"
            },
            {
                "num":"<1万",
                "id":"50559615",
                "name":"爆笑西游"
            },
            {
                "num":"<1万",
                "id":"54522690",
                "name":"王尼玛"
            },
            {
                "num":"<1万",
                "id":"199439367",
                "name":"捉妖记2"
            },
            {
                "num":"420万",
                "id":"2403060",
                "name":"笑点"
            },
            {
                "num":"<1万",
                "id":"2660034",
                "name":"大笑江湖"
            },
            {
                "num":"53万",
                "id":"2424467",
                "name":"搞怪"
            },
            {
                "num":"<1万",
                "id":"5107246",
                "name":"猴赛雷"
            },
            {
                "num":"<1万",
                "id":"2414827016",
                "name":"笑得肚子痛"
            },
            {
                "num":"42万",
                "id":"88547",
                "name":"如来"
            },
            {
                "num":"29万",
                "id":"1623830",
                "name":"整蛊"
            },
            {
                "num":"150万",
                "id":"59828",
                "name":"张飞"
            },
            {
                "num":"<1万",
                "id":"2352456038",
                "name":"嬉妖记"
            },
            {
                "num":"<1万",
                "id":"3544088",
                "name":"蓬莱仙岛"
            },
            {
                "num":"3.7万",
                "id":"2461436",
                "name":"逗乐"
            },
            {
                "num":"1300万",
                "id":"2402946",
                "name":"有趣"
            }
        ],
        "query_id":"1576831244303489865"
    }
}
JSON;

        $this->out = json_decode($json, true);
        /*$param = [
            'advertiser_id' => $this->get('advertiser_id'),
            'id' => $this->get('id'), // 类目或关键字id
            'tag_type' => $this->get('tag_type'), // 类目还是关键字
            'targeting_type' => $this->get('targeting_type'),
            'action_scene' => $this->get('action_scene'),
            'action_days' => $this->get('action_days'),
        ];
        $this->out = $this->srv->keywordSuggest($param, ['Access-Token:32e02251a7d8797202a57913524f5b46039cf937']);*/
    }
}