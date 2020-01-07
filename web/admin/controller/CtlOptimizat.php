<?php
/**
 * Class CtlOptimizat
 * @author dyh
 * @version 2019-12-02
 */

class CtlOptimizat extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvOptimizat();
    }

    public function getBusinessTree()
    {
        $this->out = $this->srv->getBusinessTree(['region_type' => 'BUSINESS_DISTRICT'], [
            'Access-Token:32e02251a7d8797202a57913524f5b46039cf937',
            'Content-Type:application/json'
        ]);
    }

    public function addDirectional()
    {
        $this->outType = 'smarty';
        $this->tpl = 'adCnter/selectDirectional.tpl';
    }

    public function selectMaterial()
    {
        $this->outType = 'smarty';
        $this->tpl = 'adCnter/selectMaterial.tpl';
    }

    public function selectCopywriting()
    {
        $id = $this->get('material_id', 'int', 0);
        $this->out['material_id'] = $id;
        $this->outType = 'smarty';
        $this->tpl = 'adCnter/selectCopywriting.tpl';
    }


    public function addJrttAd()
    {
        $this->outType = 'smarty';
        $this->out['__title__'] = '新建广告';
        $this->out['channelId'] = 35;
        $this->out['__on_menu__'] = 'optimizat';
        $this->out['__on_sub_menu__'] = 'addAd';
        $this->tpl = 'adCnter/add.tpl';
    }

    public function getMediaAcc()
    {
        $channel = $this->get('channel_id');
        $game_id = $this->get('game_id');

        $this->out = $this->srv->getMediaAcc($channel, $game_id);
    }

    public function adCnter()
    {
        $this->outType = 'smarty';
        $this->out['data'] = [];
        $this->out['__title__'] = '新建广告';
        $this->out['__on_menu__'] = 'optimizat';
        $this->out['__on_sub_menu__'] = 'adCnter';
        $this->tpl = 'adCnter/list.tpl';
    }

    public function downloadMaterial()
    {
        $this->outType = 'json';
        $ids = $this->R('ids');
        $this->out = $this->srv->download($ids);
    }

    public function delAdMaterial()
    {
        $id = $this->post('id', 'int', 0);
        $this->out = $this->srv->delAdMaterial($id);
    }

    public function deleteCopywriting()
    {
        $id = $this->get('id', 'int', 0);
        if($id <= 0)
            $this->out = ['code' => 0, 'msg' => '参数错误'];
        $this->out = $this->srv->deleteCopywriting(['id' => $id]);
    }

    public function adCopywriting()
    {
        $type = $this->R('type', 'string', 'smarty');
        $this->outType = $type;
        $param = [
            'page' => $this->R('page', 'int', 1),
            'keyword'=> $this->R('keyword', ''),
            'channel' => $this->R('channel'),
        ];
        $pageSize = $this->R('page_size', 'int', '0');
        $data = $this->srv->adCopywriting($param, $pageSize);
        if($type == 'json'){
            $this->out = $data;
        }else{
            $this->out['data'] = $data;
            $this->out['__title__'] = '文案管理';
            $this->out['__on_menu__'] = 'optimizat';
            $this->out['__on_sub_menu__'] = 'adCopywriting';
            $this->tpl = 'adCopywriting/list.tpl';
        }
    }

    public function editCopywritingAction()
    {
        $this->outType = 'json';
        $param = [
            'content' => $this->R('content'),
            'tag' => $this->R('tag'),
            'channel' => $this->R('channel')
        ];
        $id = $this->post('id', 'int');
        $this->out = $this->srv->updateCopywriting($param, ['id' => $id]);
    }

    public function addCopywriting()
    {
        $this->outType = 'smarty';
        $id = $this->R('id', 'int', 0);
        if($id > 0) {
            SrvAuth::checkPublicAuth('edit');
            $this->out['info'] = $this->srv->getCopywritingById($id);
        }else {
            SrvAuth::checkPublicAuth('add');
        }
        $this->out['__title__'] = '文案管理';
        $this->out['__on_menu__'] = 'optimizat';
        $this->out['__on_sub_menu__'] = 'addCopywriting';
        $this->tpl = 'adCopywriting/add.tpl';
    }

    public function addCopywritingAction()
    {
        $this->outType = 'json';
        $param = [
            'content' => $this->R('content'),
            'tag' => $this->R('tag'),
            'channel' => $this->R('channel')
        ];
        $this->out = $this->srv->addCopywriting($param);
    }

    public function adMaterial()
    {
        $type = $this->R('type', 'string', 'smarty');
        $this->outType = $type;

        $srvAdmin = new SrvAdmin();
        $srvMaterial = new SrvMaterial();

        $param = array(
            'material_id' => $this->R('material_id', 'int', 0),
            'page' => $this->R('page', 'int', 0),
            'parent_id' => $this->R('parent_id', 'int', 0),
            'sdate' => $this->R('sdate'),
            'edate' => $this->R('edate'),
            'upload_user' => $this->R('upload_user'),
            'material_type' => $this->R('material_type'),
            'material_source' => $this->R('material_source'),
            'material_wh' => $this->R('material_wh'),
            'material_name' => $this->R('material_name'),
            'material_tag' => $this->R('material_tag')
        );

        $data = $this->srv->adMaterial($param, $this->R('page_size', 'int', '0'));
        if($type == 'json'){
            $types =  LibUtil::config('ConfMaterial');
            foreach ($data['list'] as &$val)
                $val['material_type'] = $types[$val['material_type']];
            $this->out = $data;
        }else {
            $this->out['data'] = $data;
            $this->out['_tag'] = $srvMaterial->getMaterialTag(); // 使用原有素材标签
            $this->out['_size'] = $this->srv->getMaterialSize();
            $this->out['_admins'] = $srvAdmin->getAllAdmin();
            $this->out['_types'] = LibUtil::config('ConfMaterial');

            $this->out['__on_menu__'] = 'optimizat';
            $this->out['__on_sub_menu__'] = 'adMaterial';
            $this->out['__title__'] = '素材库';
            $this->tpl = 'adMaterial/list.tpl';
        }
    }

    public function addAdMaterial()
    {
        $this->outType = 'smarty';
        $this->out['__on_menu__'] = 'optimizat';
        $this->out['__on_sub_menu__'] = 'addAdMaterial';
        $this->out['__title__'] = '添加广告素材';
        $this->out['_types'] = LibUtil::config('ConfMaterial');
        $this->tpl = 'adMaterial/add.tpl';
    }

    public function editAdMaterial()
    {
        $id = $this->R('material_id', 'int');
        $this->out['data'] = $this->srv->getAdmaterialById($id);
        $this->outType = 'smarty';
        $this->out['__on_menu__'] = 'optimizat';
        $this->out['__on_sub_menu__'] = 'editAdMaterial';
        $this->out['__title__'] = '编辑广告素材';
        $this->out['_types'] = LibUtil::config('ConfMaterial');
        $this->tpl = 'adMaterial/edit.tpl';
    }

    public function editAdMaterialAction()
    {
        $param = [
            'material_name' => $this->post('material_name'),
            'material_type' => $this->post('material_type'),
            'material_source' => $this->post('material_source'),
            'material_tag' => $this->post('material_tag'),
        ];
        $where = ['material_id' => $this->post('material_id', 'int', 0)];
        $this->out = $this->srv->editAdMaterial($param, $where);
    }

    public function addAdMaterialAction()
    {
        $this->outType = 'json';
        $data = array(
            'material_name' => $this->post('material_name'),
            'make_date' => $this->post('make_date'),
            'material_type' => $this->post('material_type', 'int', 0),
            'material_x' => $this->post('material_x', 'int', 0),
            'material_y' => $this->post('material_y', 'int', 0),
            'material_source' => $this->post('material_source'),
            'material_tag' => $this->post('material_tag'),
            'upload_file' => $this->post('upload_file'),
            'thumb' => $this->post('upload_thumb')
        );
        $this->out = $this->srv->uploadMaterial($data);
    }

    public function getGames()
    {
        $this->outType = 'json';
        $platform = new SrvPlatform();
        $this->out = $platform->getAllGame(true);
    }

    public function test()
    {
        $platform = new SrvPlatform();
        echo '<pre>';
        $games = $platform->getAllGame(true);
        print_r($games); die;
        var_dump(mime_content_type('/home/vagrant/code/admin/web/admin/uploads/1912/051443073069_4ed60b8aa9.jpg'));die;
        $result = md5_file(APP_ROOT.'/uploads/1912/021748442193_81cc954b0b.png');
//        $platform = new SrvJrttAction();
        $platform = new SrvGdtAction();
        $this->outType = 'json';
        try{
            $platform->setIsDebug(true);
//            curl 'https://api.e.qq.com/v1.1/adgroups/add?access_token=<ACCESS_TOKEN>&timestamp=<TIMESTAMP>&nonce=<NONCE>' \
//            -d 'account_id=<ACCOUNT_ID>' \
//            -d 'campaign_id=<CAMPAIGN_ID>' \
//            -d 'adgroup_name=推广广告' \
//            -d 'promoted_object_type=PROMOTED_OBJECT_TYPE_LINK' \
//            -d 'begin_date=2017-04-25' \
//            -d 'end_date=2017-05-01' \
//            -d 'billing_event=BILLINGEVENT_CLICK' \
//            -d 'bid_amount=200' \
//            -d 'optimization_goal=OPTIMIZATIONGOAL_CLICK' \
//            -d 'time_series=010100100110100010101010010101010101010100101010101010010101010101001010101010100101010101010111110010101001010110110100110001011001010100101010101010110011001010101010100101100101101110101010101010100110100110010100110101110111101110110110110110110110101101101101110110011101011101101011101101101101001010110111010111011010110110111011' \
//            -d 'site_set=["SITE_SET_QZONE"]' \
//            -d 'daily_budget=10000' \
//            -d 'targeting_id=<TARGETING_ID>' \
//            -d 'scene_spec={"mobile_union":["MOBILE_UNION_IN_WECHAT"]}' \
//            -d 'configured_status=AD_STATUS_NORMAL' \
//            -d 'customized_category=本地生活,餐饮' \
//            -d 'user_action_sets=[]' \
//            -d 'additional_user_action_sets=[]' \
//            -d 'cpc_expand_enabled=false' \
//            -d 'cpc_expand_targeting={}' \
//            -d 'cold_start_audience=[1024]' \
//            -d 'expand_targeting=[]' \
//            -d 'deep_conversion_spec={
//    "deep_conversion_behavior_spec": {
//        "bid_amount": 200
//    },
//    "deep_conversion_worth_spec": []
//}'

            $data = [
                'account_id' => 2915553993320755,
                'campaign_id' => 15112121,
                'campaign_name'=> '嘻嘻哈哈',
                'campaign_type' => 'CAMPAIGN_TYPE_NORMAL',
                'adgroup_name' => '卡科技付款',
                'adcreative_name'=> '拉卡拉卡',
                'adcreative_template_id' => (int)'111212',
                'promoted_object_type' => 'PROMOTED_OBJECT_TYPE_ECOMMERCE',
                'begin_date' => date('Y-m-d H:i:s'),
                'end_date' => date('Y-m-d H:i:s', strtotime("+1 day")),
                'billing_event' => 'BILLINGEVENT_CLICK',
                'bid_amount' => 1,
                'optimization_goal' => 'OPTIMIZATIONGOAL_CLICK',
                'time_series' => '010100100110100010101010010101010101010100101010101010010101010101001010101010100101010101010111110010101001010110110100110001011001010100101010101010110011001010101010100101100101101110101010101010100110100110010100110101110111101110110110110110110110101101101101110110011101011101101011101101101101001010110111010111011010110110111011',
                'automatic_site_enabled' => true,
                'site_set' => ['SITE_SET_QZONE'],
                'daily_budget' => 10000,
                'scene_spec' => ['mobile_union' => ["MOBILE_UNION_IN_WECHAT"]],
                'configured_status'=> 'AD_STATUS_NORMAL',
                'customized_category' => '本地生活，餐饮',
                'user_action_sets' => [],
//                'image_signature' => md5_file(APP_ROOT.'/uploads/1912/021748442193_81cc954b0b.png'),
            ];
//            $files = ['image_file' => ['path' => APP_ROOT.'/uploads/1912/021748442193_81cc954b0b.png', 'type' => mime_content_type(APP_ROOT.'/uploads/1912/021748442193_81cc954b0b.png'), 'name' =>'021748442193_81cc954b0b.png']];
            $header = ['Access-Token: 32e02251a7d8797202a57913524f5b46039cf937'];
            $result = $platform->createAdOriginality($data, '32e02251a7d8797202a57913524f5b46039cf937', $header);
            var_dump($result);die;
            $data = [
//                'advertiser_id' => '2915553993320755',
//                'campaign_id' => '1651802104293502',
//                'name' => '广告名称',
//                'delivery_range' => 'UNION',
//                'union_video_type' => 'ORIGINAL_VIDEO',
//                'budget_mode'=> 'BUDGET_MODE_DAY',
//                'budget' => 100,
//                'schedule_type' => 'SCHEDULE_FROM_NOW',
//                'pricing' => 'PRICING_CPC',
//                'bid' => '1',
//                'flow_control_mode' => 'FLOW_CONTROL_MODE_FAST',
//                'download_type' => 'DOWNLOAD_URL',
//                'download_url' => 'http://www.hutao.com',
//                'app_type' => 'APP_ANDROID',
//                'package' => 'install package name',
//                'external_url'=> 'http://www.baidu.com'
            ];
            $result = $platform->thirdIndustryList(['level' => 2, 'type'=>'ADVERTISER'], ['Access-Token: 32e02251a7d8797202a57913524f5b46039cf937']);
            var_dump($result);
            /*$platform->setIsDebug(true);
            var_dump($platform->createAdGroup([
                'advertiser_id' => (int)$this->post('advertiser_id'),
                'campaign_name' => $this->post('campaign_name'),
                'operation' => $this->post('operation'),
                'budget_mode' => $this->post('budget_mode'),
                'budget' => $this->post('budget'),
                'landing_type' => $this->post('landing_type'),
                'unique_fk' => $this->post('unique_fk')
            ]));*/
        }catch (Exception $e){
            var_dump($e->getMessage());die;
        }
    }
}