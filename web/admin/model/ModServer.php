<?php
class ModServer extends Model{

    public function __construct()
    {
        parent::__construct('default');
    }

    public function serverPlanList($page=0,$game_id){
        if($page){
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        }
        $sql = "select * from " .LibTable::$data_game_server . " where 1 ";
        $sql_count = "select count(*) as c from ".LibTable::$data_game_server." where 1 ";
        $param = array();
        if($game_id){
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
            $sql_count .= ' and game_id = :game_id ';
        }



        $sql .= " order by `date` desc {$limit}";

        $count = $this->getOne($sql_count,$param);

        if(!$count['c']) return array();
        return array(
            'list' => $this->query($sql,$param),
            'total' => $count['c'],
        );
    }


    public function mergeServerList($page=0,$game_id,$merge_server_id){
        if($page){
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        }

        $sql = "select * from " .LibTable::$sy_game_server_merge . " where 1 ";
        $sql_count = "select count(*) as c from ".LibTable::$sy_game_server_merge." where 1 ";
        $param = array();
        if($game_id){
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
            $sql_count .= ' and game_id = :game_id ';
        }
        if($merge_server_id){
            $param['merge_server_id'] = $merge_server_id;
            $sql .= ' and merge_server_id =:merge_server_id';
            $sql_count .= ' and merge_server_id =:merge_server_id';
        }


        $sql .= "  order by `merge_date` desc {$limit}";

        $count = $this->getOne($sql_count,$param);

        if(!$count['c']) return array();
        return array(
            'list' => $this->query($sql,$param),
            'total' => $count['c'],
        );
    }

    public function getGameList($page=0){
        
        if($page){
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page,DEFAULT_ADMIN_PAGE_NUM);
        }

        $sql = "select * from `".LibTable::$sy_game."` {$limit}";
        $count = $this->getOne("select count(*) as c from `".LibTable::$sy_game."`");
        if(!$count['c']) return array();
        return array(
            'list' => $this->query($sql),
            'total' => $count['c'],
        );
    }

    public function getAllServer(){
        $sql = "select * from " .LibTable::$data_game_server . " where 1 ";
        return  $this->query($sql);
    }



    public function gameServerMerge($game_id){
        $sql = "select * from `".LibTable::$sy_game_server_merge."` where `game_id`=:game_id";
        $result = $this->query($sql,array('game_id' => $game_id));
        $data = array();
        if(!empty($result)){
            foreach($result as $v){
                $data[$v['server_id']] = $v['merge_server_id'];
            }
        }
        return $data;
    }
    public function insertMergeServer($insert){
        return $this->insert($insert,false,LibTable::$sy_game_server_merge);
    }
    public function checkMergeExist($data,$server_id){
        $sql = "select count(*) as c from " . LibTable::$sy_game_server_merge . " where `game_id` = {$data['game_id']} and `merge_server_id` = {$data['merge_server_id']} and `server_id` = {$server_id}";
        return $this->getOne($sql);
    }
}