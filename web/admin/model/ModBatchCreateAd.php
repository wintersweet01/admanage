<?php
/**
 * 批量创建广告模型
 * Class ModBatchCreateAd
 * @author dyh
 * @version 2020/01/11
 */

class ModBatchCreateAd extends Model
{
    public function __construct()
    {
        parent::__construct('default');
    }

    public function createAd(array $param)
    {
        return $this->insert($param, true, LibTable::$batch_create_ad);
    }
}