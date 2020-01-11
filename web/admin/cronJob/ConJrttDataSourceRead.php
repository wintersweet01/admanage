<?php
set_time_limit(0);
/**
 * 更新今日头条人群包状态定时任务
 * 每10分钟执行一次
 * Class ConJrttDataSourceRead
 * @author dyh
 * @version 2020/1/11
 */

require "./Console.php"; // 命令行入口文件

class ConJrttDataSourceRead
{
    private $_mod_audience;

    private $_srv_ad;

    public function __construct()
    {
        $this->_mod_audience = new ModJrttCustomAudience();
        $this->_srv_ad = new SrvBatchCreateAd();
    }

    public function handle()
    {
        $this->_dataSourceRead();
    }

    private function _dataSourceRead()
    {
        $page = 1;
        $limit = 10;
        do {
            $list = $this->_mod_audience->getAudienceList(['status' => 0], $page, $limit);
            foreach ($list as $item) {
                try {
                    $header = ["Access-Token: {$item['access_token']}"];
                    $read_response = $this->_srv_ad->dataSourceRead($item['account_id'], $header, [$item['data_source_id']]);
                    $info = $this->_sourceReadResponseStore($item['id'], $read_response);
                    $info && $this->_publishCustomAudience($item['account_id'], $read_response['data_list']['default_audience']['custom_audience_id'], $header);
                } catch (Exception $e) {
                    Debug::log($e->getMessage(), 'console-err');
                }
            }
            $page++;
            $max_page = ceil($list['total'] / $limit);
        } while ($page <= $max_page);
    }

    private function _sourceReadResponseStore(int $id, array $data)
    {
        if (empty($data['data_list']['default_audience']['custom_audience_id']))
            return false;
        $audience = $data['data_list']['default_audience'];
        $update_data = [
            'custom_audience_id' => $audience['custom_audience_id'],
            'name' => $audience['name'],
            'status' => $audience['status'],
            'push_status' => $audience['push_status'],
            'upload_num' => $audience['upload_num'],
            'cover_num' => $audience['cover_num'],
            'isdel' => $audience['isdel'],
            'expiry_date' => strtotime($audience['expiry_date']),
            'tag' => $audience['tag'],
            'update_time' => time(),
        ];
        return $this->_mod_audience->updateCustomAudience($id, $update_data);
    }

    private function _publishCustomAudience($advertiser_id, $custom_audience_id, $header)
    {
        // TODO:: 推送同主体人群包 pushCustomAudience
        return $this->_srv_ad->customAudiencePublish($advertiser_id, $custom_audience_id, $header);
    }

    private function pushCustomAudience()
    {
//        $this->_srv_ad->customAudiencePush();
    }
}

$con = new ConJrttDataSourceRead();
$con->handle();