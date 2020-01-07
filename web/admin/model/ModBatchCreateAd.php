<?php


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