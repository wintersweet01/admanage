<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/14
 * Time: 15:15
 */
class CtlServer extends Controller{

    private $srv;
    public function __construct(){
        $this->srv = new SrvServer();
    }

    public function mergeServerList(){
        SrvAuth::checkOpen('Server','mergeServerList');
        $page = $this->R('page','int',1);
        $game_id = $this->R('game_id','int',0);
        $merge_server_id = $this->R('merge_server_id','int',0);
        $this->outType = 'smarty';
        $this->out['data'] = $this->srv->mergeServerList($page,$game_id,$merge_server_id);

        $this->out['_games'] = $this->srv->getAllGame();
        $this->out['_server'] = $this->srv->getAllServer();
        if($game_id){
            $this->srvData = new SrvData();

            $this->out['_game_server'] =$this->srvData->getGameServer($game_id);
        }

        $this->out['__on_menu__'] = 'Server';
        $this->out['__on_sub_menu__'] = 'mergeServerList';
        $this->out['__title__'] = '合服管理';
        $this->tpl = 'server/mergeServerList.tpl';
    }
    public function mergeServer(){
        SrvAuth::checkOpen('Server','mergeServerList');
        $this->outType = 'smarty';
        $this->out['__on_menu__'] = 'Server';
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $this->out['__on_sub_menu__'] = 'mergeServerList';
        $this->out['__title__'] = '合服操作';
        $this->tpl = 'server/mergeServer.tpl';
    }
    public function mergeServerAct(){
        SrvAuth::checkOpen('Server','mergeServerList');
        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data,$_POST);
        $data = array(
            'game_id' => $this->post('game_id','int',0),
            'server_id' => $this->post('server_id'),
            'merge_server_id'=>$this->post('merge_server_id'),
            'date'=>$this->post('date'),
        );

        $this->out = $this->srv->mergeServerAct($data);
    }
    public function serverPlanList(){
        SrvAuth::checkOpen('Server','serverPlanList');
        $page = $this->R('page','int',1);
        $game_id = $this->R('game_id','int',0);
        $this->outType = 'smarty';
        $this->out['data'] = $this->srv->serverPlanList($page,$game_id);

        $this->out['_games'] = $this->srv->getAllGame();
        $this->out['_server'] = $this->srv->getAllServer();

        $this->out['__on_menu__'] = 'Server';
        $this->out['__on_sub_menu__'] = 'serverPlanList';
        $this->out['__title__'] = '服务器列表';
        $this->tpl = 'server/serverPlanList.tpl';
    }

    public function serverPlan(){
        SrvAuth::checkOpen('Server','serverPlanList');
        $this->outType = 'smarty';
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $this->out['__on_menu__'] = 'Server';
        $this->out['__on_sub_menu__'] = 'serverPlanList';
        $this->out['__title__'] = '开服计划';
        $this->tpl = 'server/serverPlan.tpl';
    }

    public function serverPlanAct(){
        SrvAuth::checkOpen('Server','serverPlanList');
        $this->outType = 'smarty';

        $this->out = $this->srv->serverPlanAct();
        $srvPlatform = new SrvPlatform();
        $this->out['_games'] = $srvPlatform->getAllGame();
        $this->out['__on_menu__'] = 'Server';
        $this->out['__on_sub_menu__'] = 'serverPlanList';
        $this->out['__title__'] = '开服计划';
        $this->tpl = 'server/serverPlan.tpl';
    }

    public function linkServerExcel(){
        SrvAuth::checkOpen('Server','serverPlanList');

        $this->outType = 'string';
        $game_id = $this->R('game_id');
        $data = $this->srv->linkServerExcel($game_id);

        SrvPHPExcel::downloadExcel('开服计划录入',$data['header'],$data['data']);
    }

}