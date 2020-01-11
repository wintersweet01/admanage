<?php
/**
 * 推广链与转化目标关联模型
 * Class ModMonitorConvert
 * @author dyh
 */

class ModMonitorConvert extends Model
{

    /**
     * ModMonitorConvert constructor.
     */
    public function __construct()
    {
        parent::__construct('default');
    }

    public function addConvertId(array $data)
    {
        return $this->insert($data, true, LibTable::$monitor_convert);
    }
}