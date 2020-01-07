<?php
class SrvServer{

    private $mod;
    public function __construct(){
        $this->mod = new ModServer();
    }

    public function serverPlanList($page,$game_id){
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->serverPlanList($page,$game_id);
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(),$info['total'],$page,DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['game_id'] = $game_id;
        return $info;
    }

    public function getAllGame(){
        $info = $this->mod->getGameList();
        $games = array();
        if($info['total']>0){
            foreach($info['list'] as $v){
                $games[$v['game_id']] = $v['name'];
            }
        }
        return $games;
    }
    public function getAllServer(){
        $info = $this->mod->getAllServer();

        $data = array();
        if($info){
            foreach($info as $v){
                $data[$v['game_id']][$v['server_id']] = $v['server_name'];
            }
        }

        return $data;
    }
    public function mergeServerList($page,$game_id,$merge_server_id){
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->mergeServerList($page,$game_id,$merge_server_id);


        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(),$info['total'],$page,DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['game_id'] = $game_id;
        $info['merge_server_id'] = $merge_server_id;

        return $info;
    }

    public function mergeServerAct($data){
        foreach($data['server_id'] as $key=>$val){

            $is_exist = $this->mod->checkMergeExist($data,$val);

            $insert=array();
            if(!$is_exist['c']){
                $insert['game_id'] = $data['game_id'];
                $insert['merge_server_id'] = $data['merge_server_id'];
                $insert['server_id'] = $val;
                $insert['merge_date'] = $data['date'];

                $this->mod->insertMergeServer($insert);
            }
        }
        return array('state' => true,'msg' => '操作成功');

    }
    public function serverPlanAct(){

        $file = LibFile::upload('file',PIC_UPLOAD_DIR,'',1000,array('.xls','.xlsx'));

        if($file['state'] == false){
            return array('state' => false,'msg' => '上传失败');
        }
        $data = SrvPHPExcel::excel2array($file['file']);
        $modData = new ModData();

        foreach($data as $v){
            if(preg_match('/^\d{1,2}\/\d{1,2}\/20\d\d/',$v[0])){
                $_date = explode('/',$v[0]);
                $date = $_date[2].'/'.$_date['0'].'/'.$_date[1];
            }
            if(preg_match('/^20\d\d\/\d{1,2}\/\d{1,2}$/',$v[0])){
                $date = $v[0];
            }
            if(!$date){
                return array('state' => true,'msg' => '日期格式不正确'.$v[0]);
            }

            $modData->uploadServer($date,(int)$v[1],(int)$v[3],$v[4]);
        }
        return array('state' => true,'msg' => '上传成功');
    }
    public function linkServerExcel($game_id){
        $header = array(
            '开服日期','游戏ID（勿动此列）','游戏名称（勿动此列）','服务器ID','服务器名称',
        );
        $data = array();
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame();
        $srvAd = new SrvAd();
        $channels = $srvAd->getAllChannel();
        $date = date('Y/m/d',strtotime('yesterday'));
        $data[] = array(
            $date,
            $game_id,
            $games[$game_id],
            '','',
        );

        return array(
            'header' => $header,
            'data' => $data,
        );
    }

}