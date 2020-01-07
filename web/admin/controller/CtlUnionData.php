<?php

/**
 * 联运分发-数据统计
 * 2019-06-27
 * Class CtlUnionConfig
 */

class CtlUnionData extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvUnion();
    }
}