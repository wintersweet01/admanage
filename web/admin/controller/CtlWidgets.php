<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2019/1/15
 * Time: 10:53
 */

class CtlWidgets extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvWidgets();
    }

    public function index()
    {
        $data = $this->srv->getAllGame();
        LibUtil::pr($data);
        exit();
    }
}