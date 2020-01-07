<?php

class CtlOperateReceipt extends Controller
{
    private $srv;

    public function __construct()
    {
        $this->srv = new SrvOperateReceipt();
    }

    public function operateReceiptDate()
    {
        SrvAuth::checkOpen('operateReceipt', 'operateReceiptDate');
        $this->outType = 'smarty';

        $parent_id = $this->R('parent_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->operateReceipt(1, $parent_id, $sdate, $edate);
        $this->out['data'] = $data;
        $this->out['widgets'] = $data['widgets'];
        $this->out['__on_menu__'] = 'operateReceipt';
        $this->out['__on_sub_menu__'] = 'operateReceiptDate';
        $this->out['__title__'] = '营业收入（按日期）';
        $this->tpl = 'finance/operateReceiptDate.tpl';
    }

    public function operateReceiptGame()
    {
        SrvAuth::checkOpen('operateReceipt', 'operateReceiptGame');
        $this->outType = 'smarty';

        $parent_id = $this->R('parent_id', 'int', 0);
        $sdate = $this->R('sdate');
        $edate = $this->R('edate');

        $data = $this->srv->operateReceipt(2, $parent_id, $sdate, $edate);
        $this->out['data'] = $data;
        $this->out['widgets'] = $data['widgets'];
        $this->out['__on_menu__'] = 'operateReceipt';
        $this->out['__on_sub_menu__'] = 'operateReceiptGame';
        $this->out['__title__'] = '营业收入（按游戏）';
        $this->tpl = 'finance/operateReceiptGame.tpl';
    }

}