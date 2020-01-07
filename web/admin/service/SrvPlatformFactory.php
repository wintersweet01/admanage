<?php
/**
 * 第三方广告平台操作类
 * Class SrcPlatformAction
 */

class SrvPlatformFactory
{
    static public function factory($platform)
    {
        return new $platform();
    }
}