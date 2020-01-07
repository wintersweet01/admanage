<?php


class CtlDirectionalPackage extends Controller
{
    private  $srv;

    public function __construct()
    {
        $this->srv = new SrvDirectionalPackage();
    }

    /**
     * 获取定向包
     */
    public function getDirectionalPackage()
    {
        $page = $this->get('page');
        $this->out = $this->srv->getDirectionalPackage($page);
    }

    /**
     * 保存定向包
     */
    public function addDirectionalPackage()
    {
        $this->out = $this->srv->addDirectionalPackage($_POST);
    }
}