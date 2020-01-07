<?php

class ModKfVip extends Model
{

    const SERVER_LIMIT = 30;
    const SERVER_GROUP = 10;

    public function __construct()
    {
        parent::__construct('default');
    }

    public function getGameUserInfo($account, $fields = array())
    {
        if (empty($account)) return array();
        empty($fields) && $fields = array("`uid`", "`username`", "`phone`", "`status`", "`reg_time`");
        $fields = join(",", $fields);
        $sql = "select " . $fields . " from `" . LibTable::$sy_user . "` where `username`=:username";
        $row = $this->getOne($sql, array('username' => $account));
        if ($row) {
            return $row;
        }
        return array();
    }

    public function getRoleInfo($role_name, $parent_id, $server_id, $uid, $platform)
    {
        $sql = "select * from `" . LibTable::$user_role . "` 
        where `uid`=:uid and `device_type`=:platform 
        and `role_name`=:role_name and `server_id`=:server_id";
        $param = array(
            'uid' => $uid,
            'platform' => $platform,
            'role_name' => $role_name,
            'server_id' => $server_id
        );
        $row = $this->getOne($sql, $param);
        if ($row) {
            $roleGame = $row['game_id'];
            $sql = "select `game_id`,`parent_id` from `" . LibTable::$sy_game . "` where `game_id`=:game_id";
            $gameInfo = $this->getOne($sql, array('game_id' => $roleGame));
            if ($gameInfo && $gameInfo['parent_id'] == $parent_id) {
                return $row;
            }
        } else {
            return array();
        }
    }

    public function insertVipData($data, $model_id = 0)
    {
        if (!$model_id) {
            //新添加的数据
            $sql = "select * from `" . LibTable::$sy_vip . "` where `game_id`=:game_id and `role_id`=:role_id and `server_id`=:server_id";
            $row = $this->getOne($sql, array('game_id' => $data['game_id'], 'role_id' => $data['role_id'], 'server_id' => $data['server_id']));
            if ($row) {
                return false;//已经存在记录
            }
            $res = $this->insert($data, true, LibTable::$sy_vip);
        } else {
            //更新
            $res = $this->update($data, array('id' => $model_id), LibTable::$sy_vip);
        }
        return $res;
    }

    public function vipList($page = 0, $parent_id = 0, $game_id = 0, $belong_id = 0, $insr_id = 0, $account = '', $uid = 0, $sdate, $edate, $list_color = null)
    {
        $limit = '';
        $param = array();
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }
        $condition = ' 1 ';
        if ($parent_id > 0) {
            $param['parent_id'] = $parent_id;
            $condition .= " and a.`game_id`=:parent_id";
        }
        if ($belong_id) {
            $param['belong_id'] = $belong_id;
            $condition .= " and b.`admin_id`=:belong_id";
        }
        if ($insr_id) {
            $param['insr_id'] = $insr_id;
            $condition .= " and a.`insr_kefu`=:insr_id";
        }
        if ($account) {
            $sql = "select `uid` from `" . LibTable::$sy_user . "` where `username`=:username";
            $queRm['username'] = $account;
            $ret = $this->getOne($sql, $queRm);
            $uid = $ret['uid'];
        }
        if ($uid) {
            $param['uid'] = $uid;
            $condition .= " and a.`uid`=:uid";
        }
        if ($sdate) {
            $param['sdate'] = strtotime($sdate . " 00:00:00");
            $condition .= " and a.`insr_time`>=:sdate";
        }
        if ($edate) {
            $param['edate'] = strtotime($edate . " 23:23:59");
            $condition .= " and a.`insr_time`<=:edate";
        }

        $colorCond = ' 1 ';
        if ($list_color) {
            switch ($list_color) {
                case 1:
                    $colorCond .= " AND `diff_pay` >=5 AND `diff_pay`< 10 ";
                    break;
                case 2:
                    $colorCond .= " AND `diff_pay` >= 10 AND `diff_pay` < 30 ";
                    break;
                case 3:
                    $colorCond .= " AND `diff_pay` >= 30 ";
                    break;
                default:
                    break;
            }
        }
        $authorSql = SrvAuth::getAuthSql('a.`game_id`', '', '', '');
        $kfSql = SrvAuth::getKfSql('a.`insr_kefu`');///获取写入的客服或者管理员全部可见
        /// 获取客服对应的区服和游戏/母游戏内容（管理员全部可见）
        /// if(empty(game_id) && !empty(parent_id)) 母服下全服全选
        /// if(!empty(game_id) && !empty(parent_id)) 仅获取已选择的服game_id
        $sql = "SELECT a.*,b.`admin_id`,MAX(c.`login_time`) login_time,MAX(c.`pay_time`) pay_time,
                    DATEDIFF(DATE(NOW()),FROM_UNIXTIME(MAX(c.`pay_time`))) AS diff_pay,
                    DATEDIFF(DATE(NOW()),FROM_UNIXTIME(MAX(c.`login_time`))) AS diff_login
                    FROM `" . LibTable::$sy_vip . "` a 
                    LEFT JOIN `" . LibTable::$kf_game_server . "` b 
                        ON a.`game_id`=b.`parent_id` AND a.`server_id`=b.`server_id` AND a.`platform`=b.`platform`
                    LEFT JOIN `" . LibTable::$user_role . "` c FORCE INDEX(`uid`)
                        ON a.`uid`=c.`uid` AND a.`role_id`=c.`role_id` AND a.`server_id`=c.`server_id`
                 WHERE {$condition} {$authorSql} {$kfSql}
                 GROUP BY a.`game_id`,a.`uid`,a.`server_id`,a.`role_id`
                 HAVING {$colorCond} ";

        $sqlCount = "SELECT COUNT(*) AS c FROM (" . $sql . ") tmp ";

        //$sql = "SELECT __FIELD__ FROM `" . LibTable::$sy_vip . "` AS a WHERE {$condition} {$authorSql} {$kfSql} ORDER BY a.`touch_time` DESC ";
        $row = $this->getOne($sqlCount, $param);
        $count = $row['c'];
        if (!$count) {
            return array();
        }
        unset($row);
        $sqlRow = $sql . " ORDER BY a.touch_time DESC " . $limit;
        $row = $this->query($sqlRow, $param);
        /*$sql = "select max(`login_time`) login_time,max(`pay_time`) pay_time from `" . LibTable::$user_role . "`
                    where `server_id`=:server_id and `role_id`=:role_id and `uid`=:uid";*/

        $sqluid = "select `username` from `" . LibTable::$sy_user . "` where `uid`=:uid";

        foreach ($row as &$res) {
            $temp = array();
            /*$temp['role_id'] = $res['role_id'];
            $temp['server_id'] = $res['server_id'];
            $temp['uid'] = $res['uid'];
            $info = $this->getOne($sql, $temp);*/
            $userInfo = $this->getOne($sqluid, ['uid' => $res['uid']]);
            $res['account'] = $userInfo['username'];
            /*$res['login_time'] = $info['login_time'];
            $res['pay_time'] = $info['pay_time'];*/
        }
        return array(
            'list' => $row,
            'total' => $count
        );
    }

    public function check($type, $id)
    {
        $sql = "select * from `" . LibTable::$sy_vip . "` where `id`=:id";
        $row = $this->getOne($sql, array('id' => $id));
        if (!$row) {
            return false;
        }
        $ret = $this->update(array('status' => intval($type)), array('id' => $id), LibTable::$sy_vip);
        return $ret;
    }

    public function getVipRow($model_id)
    {
        $sql = "select * from `" . LibTable::$sy_vip . "` where id=:id";
        $row = $this->getOne($sql, array('id' => $model_id));
        return $row;
    }

    public function cancel($id)
    {
        $sql = "select * from `" . LibTable::$sy_vip . "` where `id`=:id";
        $row = $this->getOne($sql, array('id' => intval($id)));
        if (!$row) {
            return false;
        }
        $ret = $this->delete(array('id' => $id), 0, LibTable::$sy_vip);
        return $ret;
    }

    public function infoCheck($type, $data)
    {
        $res = false;
        $sql = '';
        $rows = $param = array();
        switch ($type) {
            case 'account':
                $sql = "select `uid` as res from `" . LibTable::$sy_user . "` where `username`=:username";
                $param['username'] = trim($data);
                break;
            case 'uid':
                $sql = "select `uid` as res from `" . LibTable::$sy_user . "` where `uid`=:uid";
                $param['uid'] = trim($data);
                break;
            case 'role_name':
                $sql = "select `uid` as res from `" . LibTable::$user_role . "` where `role_name`=:role_name";
                $param['role_name'] = trim($data);
                break;
            case 'server_id':
                $sql = "select `id` as res from `" . LibTable::$data_game_server . "` where `server_id`=:server_id";
                $param['server_id'] = intval($data);
                break;
            default:
                return $res;
                break;
        }
        if (!empty($sql) && !empty($param)) {
            $rows = $this->getOne($sql, $param);
        }
        if (!empty($rows)) {
            return array('status' => true, 'info' => $rows['res']);
        }
        return array();
    }

    public function getVipAchieve($parent_id = 0, $sdate, $edate, $account, $kf_name)
    {
        $condition = ' 1 ';
        $where = '';
        $param = $cond = array();

        $param['sdate'] = strtotime($sdate . " 00:00:00");
        $param['edate'] = strtotime($edate . " 23:59:59");
        $condition .= " and a.`pay_time`>=:sdate and a.`pay_time`<=:edate";

        if ($parent_id > 0) {
            $condition .= " and g.`parent_id`=:parent_id";
            $param['parent_id'] = $parent_id;
        }

        if ($account) {
            $condition .= ' and c.`username`=:username';
            $param['username'] = $account;
        }
        if ($kf_name) {
            $sql = "select `admin_id` from `" . LibTable::$admin_user . "`";
            $where .= ' where `name`=:kf_name';
            $cond['kf_name'] = $kf_name;
            $kfInfo = $this->getOne($sql . $where, $cond);
            if (!empty($kfInfo)) {
                $kf_id = $kfInfo['admin_id'];
                $condition .= " and b.insr_kefu=:kefu";
                $param['kefu'] = $kf_id;
            } else {
                return array();
            }
        }
        $authorSql = SrvAuth::getAuthSql('g.`parent_id`', 'g.`game_id`', '', '');
        $kfSql = SrvAuth::getKfSql('b.`insr_kefu`');
        //录入人业绩
        $sql = "select count(c.`role_id`) as pay_man,sum(c.`total_charge`) as pay_money,c.`insr_kefu`,c.`parent_id`,c.`account`
              from (
                    select a.`uid`,a.`game_id`,a.`role_id`,sum(a.`total_fee`) as total_charge,b.`insr_kefu`,
                      b.`game_id` as parent_id,c.`username` `account`
                    from `" . LibTable::$sy_order . "` as a
                        inner join `" . LibTable::$sy_game . "` as g
                            using(`game_id`)
                        inner join `" . LibTable::$sy_vip . "` as b
                            force index(uid)
                            force index(game_id)
                            on a.`uid`=b.`uid` 
                            and g.`parent_id`=b.`game_id` 
                            and a.`server_id`=b.`server_id` 
                            and a.`role_id`=b.`role_id`
                        left join `" . LibTable::$sy_user . "` as c
                            on a.`uid`=c.`uid`    
                    where {$condition} {$authorSql} {$kfSql}
                    and a.`pay_time` >= b.`touch_time`
                        and b.`status`=2 and a.`is_pay`=" . PAY_STATUS['已支付'] . "
                    group by parent_id,a.`uid`,a.`role_id`
                ) as c where c.`total_charge` >= " . VIP_ACH * MONEY_CONF . " group by c.`insr_kefu`,c.`parent_id`";

        return array(
            'list' => $row = $this->query($sql, $param),
        );
    }

    public function getViewList($game_id, $parent_id, $sdate, $edate, $account, $kfid, $uid, $page)
    {

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $condition = ' 1 ';
        $param = array();

        $param['sdate'] = strtotime($sdate . " 00:00:00");
        $param['edate'] = strtotime($edate . " 23:59:59");
        $condition .= " and a.`pay_time`>=:sdate and a.`pay_time`<=:edate";
        if ($game_id) {
            $param['game_id'] = $game_id;
            $condition .= " and a.`game_id`=:game_id";
        }
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $condition .= " and b.`game_id`=:parent_id";
        }
        if ($account) {
            $param['username'] = $account;
            $condition .= " and c.`username`=:username";
        }
        if ($uid) {
            $param['uid'] = $uid;
            $condition .= " and b.`uid`=:uid";
        }
        if ($kfid) {
            $param['kfid'] = $kfid;
            $condition .= " and b.`insr_kefu`=:kfid";
        } else {
            return array();
        }
        $authorSql = SrvAuth::getAuthSql('g.`parent_id`', 'g.`game_id`', '', '');
        $kfSql = SrvAuth::getKfSql('b.`insr_kefu`');

        $sql = " select count(*) as c 
        from (
          select sum(a.`total_fee`) as total_charge,1 from `" . LibTable::$sy_order . "` as a
			inner join `" . LibTable::$sy_game . "` as g
		       using(`game_id`)
			inner join `" . LibTable::$sy_vip . "` as b
                on a.`uid`=b.`uid` 
                and g.`parent_id`=b.`game_id` 
                and a.`server_id`=b.`server_id` 
                and a.`role_id`=b.`role_id`
            left join `" . LibTable::$sy_user . "` as c 
                on a.`uid`=c.`uid`    
			where {$condition} {$authorSql} {$kfSql}
             and b.`status` = 2 and a.`is_pay`=" . PAY_STATUS['已支付'] . "
             and a.`pay_time`>=b.`touch_time`
			group by b.`uid`,a.role_id
			having total_charge >= " . VIP_ACH * MONEY_CONF . "
        ) as tm ";
        $row = $this->getOne($sql, $param);
        $count = $row['c'];
        if (!$count) {
            return array();
        }

        $sql = "select a.`uid`,a.`game_id`,a.`role_id`,a.`role_name` as rolename,sum(a.`total_fee`) as total_charge,b.`insr_kefu`
            ,a.`server_id`,c.`username` `account`
        from `" . LibTable::$sy_order . "` as a 
            inner join `" . LibTable::$sy_game . "` as g
               using(`game_id`)
            inner join `" . LibTable::$sy_vip . "` as b
                on a.`uid`=b.`uid` 
                and a.`server_id`=b.`server_id` 
                and g.`parent_id`= b.`game_id` 
                and a.`role_id`=b.`role_id`
            left join `" . LibTable::$sy_user . "` as c
                on a.`uid`=c.`uid`
            where {$condition} {$authorSql} {$kfSql}
                and a.`pay_time` >= b.`touch_time`
                and b.`status` = 2 and a.`is_pay`=" . PAY_STATUS['已支付'] . "
            group by b.`uid`,a.`role_id`
            having total_charge >= " . VIP_ACH * MONEY_CONF . "
            order by total_charge desc
                {$limit}";

        return array(
            'list' => $this->query($sql, $param),
            'total' => $count
        );
    }

    public function getVipRecord($game_id, $name, $account, $uid, $sdate, $edate, $page, $parent_id)
    {
        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $condition = $condition_user = $cond_day = ' where 1 ';
        $param = $param_user = array();

        if ($game_id) {
            $param['game_id'] = $game_id;
            $param_user['game_id'] = $game_id;
            $condition_user .= ' and a.`game_id`=:game_id';
            $condition .= ' and b.`game_id`=:game_id';
        }
        $kfid = 0;
        if ($name) {
            $sql = "select `admin_id` from `" . LibTable::$admin_user . "` where `name`=:name";
            $kfInfo = $this->getOne($sql, array('name' => $name));
            if (empty($kfInfo)) {
                return array();
            } else {
                $kfid = $kfInfo['admin_id'];
            }
        }
        if ($account) {
            $param['username'] = $account;
            $param_user['username'] = $account;
            $condition_user .= " and c.`username`=:username";
        }
        if ($uid) {
            $param['uid'] = $uid;
            $param_user['uid'] = $uid;
            $condition .= " and b.`uid`=:uid";
            $condition_user .= " and b.`uid`=:uid";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $param_user['game_id'] = $game_id;
            $condition .= ' and a.`game_id`=:game_id';
            $condition_user .= ' and b.`game_id`=:game_id';
            $cond_day = $condition;
        }
        if ($parent_id) {
            $param_user['parent_id'] = $parent_id;
            $param['parent_id'] = $parent_id;
            $condition_user .= ' and a.`game_id`=:parent_id';
            $condition .= " and b.`game_id`=:parent_id";
        }

        if ($kfid) {
            $param['insr_kefu'] = $kfid;
            $param_user['insr_kefu'] = $kfid;
            $condition .= ' and b.`insr_kefu`=:insr_kefu';
            $condition_user .= ' and a.`insr_kefu`=:insr_kefu';
        }
        $param['sdate'] = strtotime($sdate . " 00:00:00");
        $param['edate'] = strtotime($edate . " 23:59:59");
        $condition .= " and a.`pay_time`>=:sdate and a.`pay_time`<=:edate";

        $authorSql = SrvAuth::getAuthSql('', 'b.`game_id`', '', '');
        $kfSql = SrvAuth::getKfSql('a.`insr_kefu`');
        //VIP档案 客服有区服权限可见
        $sql = "select count(*) as c from (select a.id from
                `" . LibTable::$sy_vip . "` as a
				left join `" . LibTable::$user_role . "` as b
				force index(uid)
				on a.`server_id`=b.`server_id` and a.`role_id`=b.`role_id` and a.`uid`=b.`uid`
				left join `" . LibTable::$sy_user . "` as c
				on a.`uid`=c.`uid`
				inner join `" . LibTable::$kf_game_server . "` as k
				on a.`insr_kefu`=k.`admin_id` and a.`server_id`=k.`server_id` and a.`game_id`=k.`parent_id`
				{$condition_user} {$authorSql} {$kfSql}
			    and a.`status` = 2 
			    group by a.`server_id`,a.`uid`,b.`role_id`
			) as tmp";
        $row = $this->getOne($sql, $param_user);

        $count = $row['c'];
        if (!$count) {
            return array();
        }

        $sql = "select * from (
			select a.*,b.`total_fee`,b.`pay_time`,c.`charge_ext`,d.`day_charge` from 
			(
				select a.`game_id` as `c_parent_id`,
				a.`uid`,b.`game_id`,
				a.`role_id`,
				a.`server_id`,
				a.`rolename`,
				max(b.`login_time`) as login_time,
				sum(b.`pays`) as pays,
				a.`insr_kefu`,
				a.`insr_time`,
				a.`touch_time`,
				a.`platform`,
				c.`username` `account`
				from `" . LibTable::$sy_vip . "` as a
				    force index(game_id)
				left join `" . LibTable::$user_role . "` as b
				    force index(game_id)
				    force index(uid)
				on a.`server_id`=b.`server_id` and a.`uid`=b.`uid` and a.`role_id`=b.`role_id`
				left join `" . LibTable::$sy_user . "` as c
				on a.`uid`=c.`uid`
				inner join `" . LibTable::$kf_game_server . "` as k
				on a.`insr_kefu`=k.`admin_id` and a.`server_id`=k.`server_id` and a.`game_id`=k.`parent_id`
				{$condition_user} {$authorSql} {$kfSql} and a.`status` = 2 
				group by a.`server_id`,a.`uid`,b.`role_id`
			) as a
			left join
			(
			    -- 最后充值金额
				select tc.`total_fee`,tc.`role_id`,tc.`game_id`,tc.`server_id`,tc.`pay_time`,tc.uid
				from `" . LibTable::$sy_order . "` as tc inner join (
					select a.`role_id`,a.`server_id`,a.`game_id`,max(a.`pay_time`) as pay_time,a.`total_fee`,sum(a.`total_fee`)
									from `" . LibTable::$sy_order . "` as a
									left join `" . LibTable::$sy_game . "` as g on a.`game_id`=g.`game_id`
									inner join `" . LibTable::$sy_vip . "` as b
									    force index(game_id)
										on a.`server_id`=b.`server_id` and a.`role_id`=b.`role_id` and a.`uid`=b.`uid`
									and b.`game_id`=g.`parent_id`
									{$condition}
									and b.`status` = 2 and a.`is_pay`=" . PAY_STATUS['已支付'] . "
									group by a.`role_id`,a.`game_id`,a.`server_id`
					) as ta on tc.`role_id`= ta.`role_id` and tc.`game_id`= ta.`game_id` and ta.`server_id` = tc.`server_id`
					and tc.`pay_time`= ta.`pay_time`
			) as b
		    on  a.`server_id`= b.`server_id` and a.`uid`= b.`uid` and a.`role_id`= b.`role_id`
			left join
			(
			    -- 联系后充值金额
				select a.`game_id`,a.`role_id`,a.`server_id`,sum(a.`total_fee`) as charge_ext,a.uid
				from `" . LibTable::$sy_order . "` as a 
				left join `" . LibTable::$sy_game . "` as g on a.`game_id`= g.`game_id`
				left join `" . LibTable::$sy_vip . "` as b
				    force index(game_id)
				    on a.`server_id`= b.`server_id` and a.`uid`= b.`uid` and b.`game_id`= g.`parent_id` and a.`role_id`=b.`role_id`
				{$condition}
				and a.`pay_time` >= b.`touch_time`
				and b.`status`= 2 and a.`is_pay`= " . PAY_STATUS['已支付'] . "
				group by a.`role_id`,a.`server_id`,a.`game_id`
			) as c
			on a.`uid`= c.`uid` and a.`server_id`= c.`server_id` and a.`role_id`= c.`role_id`
			left join
			(
			    -- 当天充值金额
			    select b.`game_id`,b.`role_id`,b.`server_id`,sum(b.`total_fee`) as day_charge,b.uid
			    from `" . LibTable::$sy_order . "` as b
			    {$cond_day} {$authorSql}
			    and b.pay_time >= DATE_FORMAT(NOW(),'%Y-%m-%d 00:00:00') and b.pay_time <= DATE_FORMAT(NOW(),'%Y-%m-%d 23:59:59')
			   group by b.`role_id`,b.`server_id`,b.`game_id`
			) as d
			on a.`uid`=d.`uid` and a.`server_id`=d.`server_id` and a.`role_id` = d.`role_id`
) as tm
group by tm.`role_id`,tm.`server_id`,tm.`game_id`,tm.`insr_kefu` ORDER BY `charge_ext` DESC {$limit}";
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count
        );
    }

    public function getUserLink($parent_id, $linker, $server_id, $sdate, $edate)
    {
        $condition = $cond = $condKf = ' 1 ';
        $param = $dateParam = array();
        $link = $insr = 0;
        if ($parent_id) {
            ///选择了母游戏
            $condition .= ' and b.`parent_id`=:parent_id';
            $condKf .= ' and b.`game_id`=:parent_id';
            $param['parent_id'] = $parent_id;
        }

        if ($linker) {
            $condition .= ' and b.`admin_id`=:admin_id';
            $condKf .= ' and b.`insr_kefu`=:admin_id';
            $param['admin_id'] = $linker;
        }
        if ($server_id) {
            $condition .= ' and a.`server_id`=:server_id';
            $condKf .= ' and b.`server_id`=:server_id';
            $param['server_id'] = $server_id;
        }

        if ($sdate) {
            $cond .= ' and a.`pay_time`>=:sdate';
            $param['sdate'] = strtotime($sdate);
        }
        if ($edate) {
            $cond .= ' and a.`pay_time`<=:edate';
            $param['edate'] = strtotime($edate);
        }
        $monthCharge = VIP_ACH * MONEY_CONF;
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');
        $kfSql = SrvAuth::getKfSql('b.`admin_id`');
        $insrkfSql = SrvAuth::getKfSql('b.`insr_kefu`');
        ///获取达标账户
        $sql = "select 1 as c,b.`admin_id` from
                (
	              select a.`uid`,a.`role_id`,a.`game_id`,a.`server_id`,g.`parent_id`,sum(a.`total_fee`) as t_fee,a.`device_type`
	                from `" . LibTable::$sy_order . "` as a
	                force index(`pay_time`)
	                left join `" . LibTable::$sy_game . "` as g on a.`game_id` = g.`game_id` 
	                where {$cond} and a.`is_pay`=" . PAY_STATUS['已支付'] . "
	              group by `uid`,`server_id`,`role_id`,FROM_UNIXTIME(`pay_time`,'%Y-%m')
	              having t_fee >= {$monthCharge}
                ) as a
            inner join `" . LibTable::$kf_game_server . "` as b
            on a.`parent_id`=b.`parent_id` and a.`server_id`=b.`server_id` and a.`device_type`=b.`platform`
            where {$condition} {$authorSql} {$kfSql}
            group by a.`uid`,a.`server_id`,a.`role_id`,b.`admin_id`";

        $willLink = $this->query($sql, $param);

        ///获取 录入的
        $sql = "select count(*) as c,`insr_kefu` from `" . LibTable::$sy_vip . "` as b where {$condKf} {$insrkfSql} and `status`=2 group by `insr_kefu`";
        $kfInsr = $this->query($sql, $param);
        return array(
            'link' => $willLink,
            'insr' => $kfInsr
        );
    }

    public function getAuthorChecked($authorId)
    {
        $sql = "select * from `" . LibTable::$admin_user . "` where `admin_id`=:admin_id";
        $row = $this->getOne($sql, array('admin_id' => $authorId));
        if (empty($authorId) || empty($row)) {
            return array();
        }
        //$sql = "select concat_ws('_',`parent_id`,`game_id`,`server_id`) as pgs from `" . LibTable::$kf_game_server . "` where `admin_id`=:admin_id";
        $sql = "select concat_ws('_',`parent_id`,`platform`,`server_id`) as pgs from `" . LibTable::$kf_game_server . "` where `admin_id`=:admin_id";
        $rows = $this->query($sql, array('admin_id' => intval($authorId)));
        return $rows;
    }

    public function addAuthorServerPower($data, $id, $parent_id)
    {
        if (empty($id) || empty($parent_id)) return false;
        $this->startWork();
        $resDel = $this->delete(array('admin_id' => $id, 'parent_id' => $parent_id), 0, LibTable::$kf_game_server);
        $resInsr = true;
        !empty($data) && $resInsr = $this->multiInsert($data, LibTable::$kf_game_server);
        if ($resDel && $resInsr) {
            $this->commit();
            //LibRedis::delete(AUTHOR_POWER_KEY);
            return true;
        } else {
            $this->rollBack();
            return false;
        }
    }

    public function addAuthorServerPowerByStatus($data,$id,$parent_id)
    {
        if(empty($id) || empty($parent_id)) return false;
        foreach ($data as $listRow){
            if($listRow['status'] == 'y'){
                //insert or update
                $insrt = $update = array();
                $insrt = $update = array(
                    'parent_id'=>$listRow['parent_id'],
                    'server_id'=>$listRow['server_id'],
                    'admin_id'=>$listRow['admin_id'],
                    'platform'=>$listRow['platform'],
                    'gn_time'=>$listRow['gn_time']
                );
                $update['gn_time'] = $listRow['gn_time'];
                $this->insertOrUpdate($insrt,$update,LibTable::$kf_game_server);
            }elseif($listRow['status'] == 'n'){
                //delete
                $where = array();
                $where['parent_id'] = $listRow['parent_id'];
                $where['server_id'] = $listRow['server_id'];
                $where['admin_id'] = $listRow['admin_id'];
                $where['platform'] = $listRow['platform'];
                $this->delete($where,1,LibTable::$kf_game_server);
            }
        }
        return true;
    }

    public function getAllGS()
    {
        $sql = "select `game_id`,`server_id`,`server_name`,concat_ws('_',`game_id`,`server_id`) as gs from `" . LibTable::$data_game_server . "`";
        $row = $this->query($sql);
        return $row;
    }

    public function getBelongInfo()
    {
        $sql = "select `admin_id`,concat_ws('_',`parent_id`,`platform`,`server_id`) as gs from `" . LibTable::$kf_game_server . "`";
        $row = $this->query($sql);
        return $row;
    }

    public function viewLinkInfo($kfid, $parent_id, $server_id, $status, $uid, $sdate, $edate, $page = 0)
    {
        if (empty($kfid)) return array();
        $condition = $cond_date = $cond2 = ' 1 ';
        $param = $c_param = array();

        $limit = '';
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        if ($parent_id) {
            $condition .= ' and b.`parent_id`=:parent_id';
            $param['parent_id'] = $parent_id;
        }
        if ($kfid) {
            //归属人
            $condition .= ' and b.`admin_id`=:admin_id';
            $param['admin_id'] = $kfid;
        }
        if ($server_id) {
            $condition .= ' and a.`server_id`=:server_id';
            $param['server_id'] = $server_id;
        }

        if ($status) {
            if ($status == 1) {
                $cond2 .= " and IFNULL(`touch_time`,'0')='0' and IFNULL(`insr_kefu`,'0')='0'";
            } elseif ($status == 2) {
                $cond2 .= " and IFNULL(`touch_time`,'0') != '0' and IFNULL(`insr_kefu`,'0') != '0' and `status`=2";
            }
        }

        if ($uid) {
            $condition .= ' and a.`uid`=:uid';
            $param['uid'] = $uid;
        }
        if ($sdate) {
            $cond_date .= ' and `pay_time`>=:sdate';
            $c_param['sdate'] = $param['sdate'] = strtotime($sdate . " 00:00:00");
        }
        if ($edate) {
            $cond_date .= ' and `pay_time`<=:edate';
            $c_param['edate'] = $param['edate'] = strtotime($edate . " 23:59:59");
        }
        $monthCharge = VIP_ACH * MONEY_CONF;
        $authorSql = SrvAuth::getAuthSql('b.`parent_id`', 'a.`game_id`', '', '');

        //查询范围内 累计充值达3000的用户
        $sql = " from (
            select a.*,b.`admin_id` from 
            (
                select a.`uid`,a.`role_id`,a.`role_name`,a.`game_id`,a.`server_id`,g.`parent_id`,a.`device_type`,sum(a.`total_fee`) as t_fee
                from `" . LibTable::$sy_order . "` as a
                FORCE INDEX(pay_time) 
                left join `" . LibTable::$sy_game . "` as g 
                on a.`game_id`=g.`game_id`
                where {$cond_date} and a.`is_pay`=" . PAY_STATUS['已支付'] . "
                group by `uid`,`server_id`,`role_id`,FROM_UNIXTIME(`pay_time`,'%Y-%m')
                having t_fee >= {$monthCharge}
            ) as a inner join `" . LibTable::$kf_game_server . "` as b
                on a.`parent_id`= b.`parent_id` and a.`server_id`=b.`server_id` and a.`device_type`=b.`platform`
                where {$condition} {$authorSql}
                group by a.`uid`,a.`server_id`,a.`role_id`
        ) as a left join `" . LibTable::$sy_vip . "` as b
            FORCE INDEX(uid)
			FORCE INDEX(game_id)
		on a.`parent_id`=b.`game_id` and a.`server_id`=b.`server_id` and a.`uid`=b.`uid`
		where {$cond2}";

        $filed = "select count(*) as c ";
        $row = $this->getOne($filed . $sql, $param);
        $count = $row['c'];
        if (!$count) {
            return array();
        }

        $field = "select a.*,b.`touch_time`,b.`insr_kefu`,b.`status`,concat_ws('_',a.uid,a.server_id,a.role_id) as gsi ";
        $data = $this->query($field . $sql . $limit, $param);
        $data = array_column($data, null, 'gsi');
        $userInfo = array();
        foreach ($data as $value) {
            $temp = array();
            $temp['uid'] = $value['uid'];
            $temp['server_id'] = $value['server_id'];
            $temp['role_id'] = $value['role_id'];
            array_push($userInfo, $temp);
        }
        //获取最后登录时间累计充值
        $userRow = array();
        if (!empty($userInfo)) {
            $sqlLogin = "select `login_time`,concat_ws('_',`uid`,`server_id`,`role_id`) as gsl
              from `" . LibTable::$user_role . "`
              where `uid`=:uid and `server_id`=:server_id and `role_id`=:role_id";
            $sqlCharge = "select sum(`total_fee`) as charge_money,concat_ws('_',`uid`,`server_id`,`role_id`)
                    from `" . LibTable::$sy_order . "`
                    where `uid`=:uid and `server_id`=:server_id and `role_id`=:role_id
                    and `is_pay`=" . PAY_STATUS['已支付'] . " and {$cond_date}";
            foreach ($userInfo as $paramRow) {
                $temp = array();
                $loginRow = $this->getOne($sqlLogin, $paramRow);
                $chargeRow = $this->getOne($sqlCharge, array_merge($paramRow, $c_param));
                $temp['login_time'] = $loginRow['login_time'];
                $temp['charge_money'] = $chargeRow['charge_money'];
                $userRow[$loginRow['gsl']] = $temp;
            }
        }
        //获取达标时间
        $reachInfo = array();
        if (!empty($userInfo)) {
            $sql = "select `total_fee`,`pay_time`,concat_ws('_',`uid`,`server_id`,`role_id`) as gsl from `" . LibTable::$sy_order . "`
            where {$cond_date} and `is_pay`=" . PAY_STATUS['已支付'] . "
            and `uid`=:uid and `server_id`=:server_id and `role_id`=:role_id
            order by `pay_time` asc";
            static $role_money = 0;
            foreach ($userInfo as $info) {
                if (!$info) continue;
                $row = $this->query($sql, array_merge($info, $c_param));
                if (!$row) continue;
                foreach ($row as $order) {
                    $role_money += $order['total_fee'];
                    if ($role_money >= $monthCharge) {
                        //print $order['gsl'].":".$role_money."<\n>";
                        $reachInfo[$order['gsl']]['reach_time'] = $order['pay_time'];
                        $role_money = 0;
                        break;
                    }
                }
            }
        }

        return array(
            'normal' => $data,///这就是分页标准
            'login_charge' => $userRow,
            'reach_time' => $reachInfo,
            'total' => $count
        );
    }

    public function delVip($ids)
    {
        if (empty($ids)) return false;
        $ids = array_unique(array_filter($ids));

        $hasRow = "select * from `" . LibTable::$sy_vip . "` where `id`=:id";
        $effRow = array();
        foreach ($ids as $id) {
            $row = $this->getOne($hasRow, array('id' => $id));
            if (empty($row)) continue;
            $this->startWork();
            $res = $this->delete(array('id' => $id), 0, LibTable::$sy_vip);
            if ($res) {
                array_push($effRow, $id);
                $this->commit();
            } else {
                $this->rollBack();
            }
        }

        if (count($effRow) > 0) {
            return true;
        }
        return false;
    }

    public function vip_list($game_id, $page)
    {
        $limit = '';
        $where = ' 1 ';
        $param = array();
        if ($page > 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }
        if ($game_id) {
            $where .= ' and `game_id`=:game_id';
            $param['game_id'] = $game_id;
        }

        $sql = "select count(*) as c from `" . LibTable::$sy_vip . "` where {$where}";
        $count = $this->getOne($sql, $param);
        if ($count['c'] > 0) {
            $count = $count['c'];
        } else {
            return array();
        }

        $sql = "select * from `" . LibTable::$sy_vip . "` where {$where} {$limit}";
        return array(
            'list' => $this->query($sql, $param),
            'count' => $count
        );
    }

    public function gameParentServer($parentIds)
    {
        ini_set('memory_limit', '64M');
        set_time_limit(600);

        if (empty($parentIds)) return array();

        $limit = self::SERVER_LIMIT;
        $gameServerRow = array();
        $parentIds = array_shift($parentIds);
        if (empty($parentIds)) return array();
        foreach (PLATFORM as $plat) {
            $platform = intval($plat);
            $sqlG = "select a.`game_id` from `" . LibTable::$sy_game_package . "` as a 
                    left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
                    where b.`parent_id`=:parent_id and a.`platform`=:platform";
            $gameRows = $this->query($sqlG, array('parent_id' => $parentIds, 'platform' => $plat));
            $list = array();
            foreach ($gameRows as $game) {
                if (empty($game['game_id'])) continue;
                array_push($list, $game['game_id']);
            }
            if (!empty($list)) {
                $sql = "select MIN(tmp.server_id) as mi,tmp.server_id,tmp.game_id from ( 
                    select id,`server_id`,`game_id` from `" . LibTable::$data_game_server . "`                                 
                where `game_id` in ('" . join("','", $list) . "') and `server_id` != '' 
                ) tmp group by tmp.server_id order by id limit {$limit};";
                $rows = $this->query($sql);
                foreach ($rows as $gameSer) {
                    $temp = array();
                    $temp['parent_id'] = $parentIds;
                    $temp['platform'] = $platform;
                    $temp['server_id'] = $gameSer['server_id'];
                    array_push($gameServerRow, $temp);
                }
            }
        }
        $info = array();
        foreach ($gameServerRow as &$res) {
            $info[$res['parent_id']][$res['platform']][] = $res['server_id'];//母游戏下的所有区服
        }
        foreach ($info as &$plat) {
            foreach ($plat as $pKey => &$ser) {
                $ser = array_filter($ser);
                sort($ser);
                $ser = array_unique($ser);
                $plat[$pKey] = array_chunk($ser, self::SERVER_GROUP);//十个为一行
            }
        }
        return $info;
    }

    public function MoreGameServer($more, $platform, $parent_id)
    {

        $param = array();
        $limit = '';
        $condition = ' a.`platform`=:platform and b.`parent_id`=:parent_id';
        $param['platform'] = $platform;
        $param['parent_id'] = $parent_id;
        if ($more > 0) {
            $limitS = ($more * self::SERVER_LIMIT);
            $limit = " limit " . $limitS . "," . self::SERVER_LIMIT;
        }
        $sql = "select a.`game_id` from `" . LibTable::$sy_game_package . "` as a 
                    left join `" . LibTable::$sy_game . "` as b on a.`game_id`=b.`game_id`
                    where {$condition}";
        $row = $this->query($sql, $param);
        if (empty($row)) return array();
        $gameIds = array();
        foreach ($row as $game_id) {
            if (empty($game_id)) continue;
            array_push($gameIds, $game_id['game_id']);
        }
        $gameIds = array_unique($gameIds);
        $sql = "select distinct(`server_id`) from `" . LibTable::$data_game_server . "` 
        where `game_id` in ('" . join("','", $gameIds) . "') and `server_id` != '' order by `server_id`+0 asc {$limit}";
        $data = $this->query($sql);
        return $data;
    }

    public function adminSelect($authorId)
    {
        if (empty($authorId)) return array();
        $sql = "select `parent_id`,`server_id` from `" . LibTable::$kf_game_server . "` where `admin_id`=:admin_id";
        $rows = $this->query($sql, array('admin_id' => $authorId));
        return $rows;
    }

    public function adminSelectServer($authorId)
    {
        if (empty($authorId)) return array();
        $sql = "select `parent_id`,`platform`,`server_id` from `" . LibTable::$kf_game_server . "` where `admin_id`=:admin_id";
        $row = $this->query($sql, array('admin_id' => $authorId));
        return $row;
    }

    public function fetchRoleList($parent_id, $server_id, $uid)
    {
        $sql = "select `game_id` from `" . LibTable::$sy_game . "` where `parent_id`=:parent_id";
        $gamesList = $this->query($sql, array('parent_id' => $parent_id));
        if (!empty($gamesList)) {
            $games = $roles = array();
            foreach ($gamesList as $row) {
                array_push($games, $row['game_id']);
            }
            $sql = "select `role_id`,`role_name` from `" . LibTable::$sy_order . "` 
                        where `game_id` in ('" . join("','", $games) . "') 
                        and `server_id`=:server_id
                        and `uid`=:uid and `is_pay`=" . PAY_STATUS['已支付'] . " group by `role_id`,`role_name`";
            $param = array(
                'server_id' => (int)$server_id,
                'uid' => (int)$uid
            );
            $roleInfo = $this->query($sql, $param);
            foreach ($roleInfo as $r) {
                if (empty($r['role_id']) || empty($r['role_name'])) continue;
                $temp = array();
                $temp['id'] = $r['role_id'];
                $temp['name'] = $r['role_name'];
                array_push($roles, $temp);
            }
            return $roles;
        } else {
            return array();
        }
    }

    public function batchCheck($ids)
    {
        if (empty($ids)) return false;
        $backIds = array();
        foreach ($ids as $id) {
            $ret = $this->update(array('status' => 2), array('id' => $id), LibTable::$sy_vip);
            if ($ret) {
                $backIds['succ'][] = $id;
            } else {
                $backIds['fail'][] = $id;
            }
        }
        return $backIds;
    }
}

?>