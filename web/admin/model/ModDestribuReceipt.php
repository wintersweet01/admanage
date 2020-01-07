<?php
class ModDestribuReceipt extends Model{

    public function __construct()
    {
        parent::__construct('default');
    }

    public function destribuReceiptDate($game_id,$sdate,$edate){
        $sql = "select sum(`net_income`) as `income`,`date`,`channel_name` from " .LibTable::$data_finance . " where 1 ";
        $param = array();
        if($game_id){
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
        }
        if($sdate){
            $param['sdate'] = $sdate;
            $sql .= ' and date >= :sdate ';
        }
        if($edate){
            $param['edate'] = $edate;
            $sql .= ' and date <= :edate ';
        }
        $sql .= " group by `date`,`channel_name` order by `date` desc,`channel_name` asc ";
        $sql_channel = "select `channel_name` from " .LibTable::$data_finance . " group by `channel_name` ";

        $channel = $this->query($sql_channel);

        $data = $this->query($sql,$param);
        $info = array();
        foreach($data as $key=>$val){
            $info[$val['date']][] = $val;
        }
        $datas = array();
        foreach($info as $key=>$val){
            foreach($val as $k=>$v){
                $datas[$key][$v['channel_name']]=$v;
            }
        }
        unset($info);unset($data);
        foreach($datas as $key=>$val){
            foreach($channel as $k=>$v){
                if(!$val[$v['channel_name']]){
                    $datas[$key][$v['channel_name']]['income'] =0;
                    $datas[$key][$v['channel_name']]['date'] =$key;
                    $datas[$key][$v['channel_name']]['channel_name'] =$v['channel_name'];
                }
            }
            ksort($datas[$key]);
        }
        sort($channel);
        $info['list'] = $datas;
        $info['channel'] = $channel;
        return $info;
    }


    public function destribuReceiptGame($game_id,$sdate,$edate){
        $sql = "select sum(`net_income`) as `income`,`game_id`,`channel_name` from " .LibTable::$data_finance . " where 1 ";
        $param = array();
        if($game_id){
            $param['game_id'] = $game_id;
            $sql .= ' and game_id = :game_id ';
        }
        if($sdate){
            $param['sdate'] = $sdate;
            $sql .= ' and date >= :sdate ';
        }
        if($edate){
            $param['edate'] = $edate;
            $sql .= ' and date <= :edate ';
        }
        $sql .= " group by `game_id`,`channel_name` order by `game_id` asc,`channel_name` asc ";
        $sql_channel = "select `channel_name` from " .LibTable::$data_finance . " group by `channel_name`  ";

        $channel = $this->query($sql_channel);

        $data = $this->query($sql,$param);

        $info = array();
        foreach($data as $key=>$val){
            $info[$val['game_id']][] = $val;
        }

        $datas = array();
        foreach($info as $key=>$val){
            foreach($val as $k=>$v){
                $datas[$key][$v['channel_name']]=$v;
            }
        }
        unset($info);unset($data);

        foreach($datas as $key=>$val){
            foreach($channel as $k=>$v){
                if(!$val[$v['channel_name']]){
                    $datas[$key][$v['channel_name']]['income'] =0;
                    $datas[$key][$v['channel_name']]['date'] =$key;
                    $datas[$key][$v['channel_name']]['channel_name'] =$v['channel_name'];
                }
            }
            ksort($datas[$key]);
        }
        sort($channel);
        $info['list'] = $datas;
        $info['channel'] = $channel;
        return $info;
    }



}