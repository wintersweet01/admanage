<?php

class ModMaterial extends Model
{

    public function __construct()
    {
        $this->conn = 'default';
    }

    public function materialData($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate, $psdate, $pedate, $is_excel = 0)
    {
        if ($is_excel == 0) {
            $conn = $this->connDb($this->conn);
            $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);
        }

        $param = [];
        $condition1 = $condition2 = $condition3 = "";
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $condition3 .= " AND g.`parent_id`=:parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
            $condition2 .= " AND a.`game_id` = :game_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND a.`device_type` = :device_type";
            $condition2 .= " AND a.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $condition1 .= " AND b.`date` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $condition1 .= " AND b.`date` <= :edate";
        }
        if ($psdate) {
            $param['psdate'] = $psdate;
            $condition2 .= " AND b.`date` >= :psdate";
        }
        if ($pedate) {
            $param['pedate'] = $pedate;
            $condition2 .= " AND b.`date` <= :pedate";
        }
        if ($upload_user) {
            $param['upload_user'] = "%$upload_user%";
            $condition3 .= " AND a.`upload_user` LIKE :upload_user";
        }

        $sql = "SELECT a.material_id, a.material_name, a.game_id, a.upload_user, a.test_start, a.test_end, c.display, c.cost, c.click, d.reg, d.retain, e.money, e.sum_pay, e.count_pay 
                FROM `" . LibTable::$material . "` a 
                INNER JOIN material_land b ON a.material_id = b.material_id
                LEFT JOIN (
                    SELECT a.material_id, SUM(b.display) display, SUM(b.cost) cost, SUM(b.click) click 
                    FROM `" . LibTable::$material_land . "` a
                    LEFT JOIN material e ON a.material_id = e.material_id
                    LEFT JOIN `" . LibTable::$data_upload . "` b ON a.package_name = b.package_name
                    WHERE 1 {$condition1} AND ((a.device_type = " . PLATFORM['android'] . " AND a.package_name = b.package_name) OR (a.device_type = " . PLATFORM['ios'] . " AND a.package_name = b.package_name AND a.monitor_id = b.monitor_id))
                    GROUP BY a.material_id
                ) c ON a.material_id = c.material_id
                LEFT JOIN (
                    SELECT a.material_id, SUM(b.reg) reg, SUM(b.retain2) retain 
                    FROM `" . LibTable::$material_land . "` a
                    LEFT JOIN material e ON a.material_id = e.material_id
                    LEFT JOIN `" . LibTable::$data_retain . "` b ON a.package_name = b.package_name
                    WHERE 1 {$condition1} AND ((a.device_type = " . PLATFORM['android'] . " AND a.package_name = b.package_name) OR (a.device_type = " . PLATFORM['ios'] . " AND a.package_name = b.package_name AND a.monitor_id = b.monitor_id))
                    GROUP BY a.material_id
                ) d ON a.material_id = d.material_id
                LEFT JOIN (
                    SELECT material_id, SUM(m) money, SUM(c) sum_pay, COUNT(*) count_pay 
                    FROM (
                        SELECT a.material_id, SUM(b.money) m, COUNT(*) c
                        FROM `" . LibTable::$material_land . "` a 
                        LEFT JOIN material e ON a.material_id = e.material_id
                        LEFT JOIN `" . LibTable::$data_pay . "` b ON a.package_name = b.package_name
                        LEFT JOIN `" . LibTable::$user_ext . "` c ON b.uid = c.uid
                        WHERE 1 {$condition2} AND ((a.device_type = " . PLATFORM['android'] . " AND a.package_name = b.package_name) OR (a.device_type = " . PLATFORM['ios'] . " AND a.package_name = b.package_name AND a.monitor_id = c.monitor_id))
                        GROUP BY a.material_id, b.uid
                    ) tmp GROUP BY material_id
                ) e ON a.material_id = e.material_id
                LEFT JOIN `" . LibTable::$sy_game . "` as g ON a.`game_id`= g.`game_id`
                WHERE a.test_start > 0 AND a.test_end > 0 {$condition3} 
                GROUP BY a.material_id 
                ORDER BY a.`material_id` DESC {$limit}";
        //echo $sql;

        $sql_count = "SELECT COUNT(*) AS c FROM `" . LibTable::$material . "` a 
                      INNER JOIN material_land b ON a.material_id = b.material_id 
                      LEFT JOIN `" . LibTable::$sy_game . "` as g ON a.`game_id`= g.`game_id`
                      WHERE a.test_start > 0 AND a.test_end > 0 {$condition3} 
                      GROUP BY a.material_id";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c']
        );
    }

    public function materialData2($page, $upload_user, $parent_id, $game_id, $device_type, $sdate, $edate)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($page, DEFAULT_ADMIN_PAGE_NUM);

        $param = [];
        $condition1 = $condition2 = $condition3 = "";
        if ($parent_id) {
            $param['parent_id'] = $parent_id;
            $condition3 .= " AND g.`parent_id`=:parent_id";
        }
        if ($game_id) {
            $param['game_id'] = $game_id;
            $condition1 .= " AND a.`game_id` = :game_id";
        }
        if ($device_type) {
            $param['device_type'] = $device_type;
            $condition1 .= " AND a.`device_type` = :device_type";
        }
        if ($sdate) {
            $param['sdate'] = $sdate;
            $condition1 .= " AND b.`date` >= :sdate";
        }
        if ($edate) {
            $param['edate'] = $edate;
            $condition1 .= " AND b.`date` <= :edate";
        }
        if ($upload_user) {
            $param['upload_user'] = "%$upload_user%";
            $condition3 .= " AND a.`upload_user` LIKE :upload_user";
        }

        $sql = "SELECT a.material_id, a.material_name, a.game_id, a.upload_user, a.test_start, a.test_end, c.display, c.cost, c.click, d.reg, d.retain 
                FROM `" . LibTable::$material . "` a 
                INNER JOIN material_land b ON a.material_id = b.material_id
                LEFT JOIN (
                    SELECT a.material_id, SUM(b.display) display, SUM(b.cost) cost, SUM(b.click) click 
                    FROM `" . LibTable::$material_land . "` a
                    LEFT JOIN material e ON a.material_id = e.material_id
                    LEFT JOIN `" . LibTable::$data_upload . "` b ON a.package_name = b.package_name
                    WHERE 1 {$condition1} AND ((a.device_type = " . PLATFORM['android'] . " AND a.package_name = b.package_name) OR (a.device_type = " . PLATFORM['ios'] . " AND a.package_name = b.package_name AND a.monitor_id = b.monitor_id))
                    GROUP BY a.material_id
                ) c ON a.material_id = c.material_id
                LEFT JOIN (
                    SELECT a.material_id, SUM(b.reg) reg, SUM(b.retain2) retain 
                    FROM `" . LibTable::$material_land . "` a
                    LEFT JOIN material e ON a.material_id = e.material_id
                    LEFT JOIN `" . LibTable::$data_retain . "` b ON a.package_name = b.package_name
                    WHERE 1 {$condition1} AND ((a.device_type = " . PLATFORM['android'] . " AND a.package_name = b.package_name) OR (a.device_type = " . PLATFORM['ios'] . " AND a.package_name = b.package_name AND a.monitor_id = b.monitor_id))
                    GROUP BY a.material_id
                ) d ON a.material_id = d.material_id
                LEFT JOIN `" . LibTable::$sy_game . "` as g ON a.`game_id`=g.`game_id`
                WHERE a.test_start > 0 AND a.test_end > 0 {$condition3} 
                GROUP BY a.material_id 
                ORDER BY a.`material_id` DESC {$limit}";

        $sql_count = "SELECT COUNT(*) AS c FROM `" . LibTable::$material . "` a 
                      INNER JOIN material_land b ON a.material_id = b.material_id 
                      WHERE a.test_start > 0 AND a.test_end > 0 {$condition3} 
                      GROUP BY a.material_id";
        $count = $this->getOne($sql_count, $param);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $param),
            'total' => $count['c']
        );
    }

    public function materialBox($param)
    {
        $conn = $this->connDb($this->conn);
        $limit = $conn->getLimit($param['page'], DEFAULT_ADMIN_PAGE_NUM);

        $where = [];
        $condition = "";
        if ($param['material_id'] > 0) {
            $condition .= " AND a.material_id = :material_id";
            $where['material_id'] = $param['material_id'];
        }
        if ($param['parent_id']) {
            $condition .= " AND c.`parent_id`=:parent_id";
            $where['parent_id'] = $param['parent_id'];
        }
        if ($param['game_id']) {
            $condition .= " AND a.game_id = :game_id";
            $where['game_id'] = $param['game_id'];
        }
        if ($param['channel_id']) {
            $condition .= " AND a.channel_id IN(:channel_id)";
            $where['channel_id'] = $param['channel_id'];
        }
        if ($param['sdate']) {
            $condition .= " AND a.make_date >= :sdate";
            $where['sdate'] = $param['sdate'];
        }
        if ($param['edate']) {
            $condition .= " AND a.make_date <= :edate";
            $where['edate'] = $param['edate'];
        }
        if ($param['upload_user']) {
            $condition .= " AND a.upload_user = :upload_user";
            $where['upload_user'] = $param['upload_user'];
        }
        if ($param['material_type']) {
            $condition .= " AND a.material_type = :material_type";
            $where['material_type'] = $param['material_type'];
        }
        if ($param['material_source']) {
            $param['material_source'] == -1 && $param['material_source'] = '';
            $condition .= " AND a.material_source = :material_source";
            $where['material_source'] = $param['material_source'];
        }
        if ($param['material_wh']) {
            $condition .= " AND a.material_wh = :material_wh";
            $where['material_wh'] = $param['material_wh'];
        }
        if ($param['material_name']) {
            $condition .= " AND a.material_name LIKE :material_name";
            $where['material_name'] = "%{$param['material_name']}%";
        }
        if ($param['material_tag']) {
            $condition .= " AND a.material_tag LIKE :material_tag";
            $where['material_tag'] = "%{$param['material_tag']}%";
        }

        $sql = "SELECT a.*, b.material_count FROM " . LibTable::$material . " a 
                LEFT JOIN (
                    SELECT material_id, COUNT(*) material_count FROM material_land GROUP BY material_id
                ) b ON a.material_id = b.material_id 
                LEFT JOIN `" . LibTable::$sy_game . "` as c ON a.`game_id`=c.`game_id` 
                WHERE 1 {$condition} ORDER BY a.`material_id` DESC {$limit}";
        $sql_count = "SELECT COUNT(*) AS c FROM " . LibTable::$material . " a LEFT JOIN `" . LibTable::$sy_game . "` as c ON a.`game_id`=c.`game_id` WHERE 1 {$condition}";
        $count = $this->getOne($sql_count, $where);
        if (!$count['c']) return array();
        return array(
            'list' => $this->query($sql, $where),
            'total' => $count
        );
    }

    public function changeTime($data)
    {
        $update = array(
            $data['type'] => strtotime($data['time']),
        );
        $where = array('material_id' => $data['material_id']);
        $res = $this->update($update, $where, LibTable::$material);
        return $res;
    }

    public function getMaterialSize()
    {
        return $this->query("SELECT `material_wh` FROM " . LibTable::$material . " GROUP BY `material_wh` ORDER BY `material_wh`");
    }

    public function getMaterialTag()
    {
        return $this->query("SELECT `tag_name` FROM " . LibTable::$tag . " GROUP BY `tag_name` ORDER BY `tag_name`");
    }

    public function insertTag($data)
    {
        return $this->insertOrUpdate($data, $data, LibTable::$tag);
    }

    public function materialTotal($parent_id = 0, $game_id = 0, $channel_id = 0, $upload_user = '', $sdate = '', $edate = '')
    {
        $where = [];
        $condition = "";
        if ($parent_id > 0) {
            $condition .= " AND `g`.`parent_id` = :parent_id";
            $where['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $condition .= " AND `a`.`game_id` = :game_id";
            $where['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND `a`.`channel_id` = :channel_id";
            $where['channel_id'] = $channel_id;
        }
        if ($upload_user) {
            $condition .= " AND `a`.`upload_user` = :upload_user";
            $where['upload_user'] = $upload_user;
        }
        if ($sdate && $edate) {
            $condition .= " AND `a`.`make_date` BETWEEN :sdate AND :edate";
            $where['sdate'] = $sdate;
            $where['edate'] = $edate;
        }

        $fields1 = $fields2 = $fields3 = '';
        $types = LibUtil::config('ConfMaterial');
        foreach ($types as $key => $val) {
            $fields1 .= "SUM(IF(`material_type` = {$key}, 1, 0)) AS `t{$key}`,";
            $fields2 .= "0 AS `t{$key}`,";
            $fields3 .= "SUM(`t{$key}`) AS `type{$key}`,";
        }

        $sql = "SELECT `upload_user`, {$fields3} SUM(`s1`) AS `source1`, SUM(`s2`) AS `source2`, SUM(`d`) AS `display`, SUM(`c`) AS `click`, SUM(`r`) AS `reg` 
                FROM (
                    SELECT `upload_user`, {$fields1} SUM(IF(`material_source` = '', 1, 0)) AS `s1`, SUM(IF(`material_source` != '', 1, 0)) AS `s2`, 0 AS `d`, 0 AS `c`, 0 AS `r` 
                    FROM `" . LibTable::$material . "` AS `a`
                    LEFT JOIN `" . LibTable::$sy_game . "` AS `g` ON `a`.`game_id`=g.`game_id`
                         WHERE 1 {$condition} GROUP BY `upload_user` 
                    UNION ALL 
                    SELECT `a`.`upload_user`, {$fields2} 0 AS `s1`, 0 AS `s2`, SUM(`c`.`display`) AS `d`, SUM(`c`.`click`) AS `c`, 0 AS `r` 
                    FROM `" . LibTable::$material_land . "` AS `b` 
                    LEFT JOIN `" . LibTable::$material . "` AS `a` ON `a`.`material_id` = `b`.`material_id` 
                    LEFT JOIN `" . LibTable::$data_upload . "` AS `c` ON (`c`.`device_type` = " . PLATFORM['android'] . " AND `b`.`package_name` = `c`.`package_name`) OR (`c`.`device_type` = " . PLATFORM['ios'] . " AND `b`.`package_name` = `c`.`package_name` AND `b`.`monitor_id` = `c`.`monitor_id`) 
                    LEFT JOIN `" . LibTable::$sy_game . "` AS `g` ON `a`.`game_id`= `g`.`game_id`
                    WHERE `c`.`date` BETWEEN FROM_UNIXTIME(`a`.`test_start`, '%Y-%m-%d') AND FROM_UNIXTIME(`a`.`test_end`, '%Y-%m-%d') {$condition} 
                    GROUP BY `a`.`upload_user` 
                    UNION ALL 
                    SELECT `a`.`upload_user`, {$fields2} 0 AS `s1`, 0 AS `s2`, 0 AS `d`, 0 AS `c`, SUM(`c`.`reg`) AS `r` 
                    FROM `" . LibTable::$material_land . "` AS `b` 
                    LEFT JOIN `" . LibTable::$material . "` AS `a` ON `a`.`material_id` = `b`.`material_id` 
                    LEFT JOIN `" . LibTable::$data_reg . "` AS `c` ON (`c`.`device_type` = " . PLATFORM['android'] . " AND `b`.`package_name` = `c`.`package_name`) OR (`c`.`device_type` = " . PLATFORM['ios'] . " AND `b`.`package_name` = `c`.`package_name` AND `b`.`monitor_id` = `c`.`monitor_id`) 
                    LEFT JOIN `" . LibTable::$sy_game . "` AS `g` ON `a`.`game_id`= `g`.`game_id`
                    WHERE `c`.`date` BETWEEN FROM_UNIXTIME(`a`.`test_start`, '%Y-%m-%d') AND FROM_UNIXTIME(`a`.`test_end`, '%Y-%m-%d') {$condition} 
                    GROUP BY `a`.`upload_user`
                ) tmp  GROUP BY `upload_user` ORDER BY `click` DESC";
        return $this->query($sql, $where);
    }

    public function materialDay($parent_id = 0, $game_id = 0, $channel_id = 0, $upload_user = '', $sdate = '', $edate = '')
    {
        $where = [];
        $condition = "";
        if ($parent_id > 0) {
            $condition .= " AND `g`.`parent_id` = :parent_id";
            $where['parent_id'] = $parent_id;
        }
        if ($game_id > 0) {
            $condition .= " AND `a`.`game_id` = :game_id";
            $where['game_id'] = $game_id;
        }
        if ($channel_id > 0) {
            $condition .= " AND `a`.`channel_id` = :channel_id";
            $where['channel_id'] = $channel_id;
        }
        if ($upload_user) {
            $condition .= " AND `a`.`upload_user` = :upload_user";
            $where['upload_user'] = $upload_user;
        }
        if ($sdate && $edate) {
            $condition .= " AND `a`.`make_date` BETWEEN :sdate AND :edate";
            $where['sdate'] = $sdate;
            $where['edate'] = $edate;
        }

        $fields1 = $fields2 = $fields3 = '';
        $types = LibUtil::config('ConfMaterial');
        foreach ($types as $key => $val) {
            $fields1 .= "SUM(IF(`material_type` = {$key}, 1, 0)) AS `t{$key}`,";
            $fields2 .= "0 AS `t{$key}`,";
            $fields3 .= "SUM(`t{$key}`) AS `type{$key}`,";
        }

        $sql = "SELECT `make_date`, {$fields3} SUM(`s1`) AS `source1`, SUM(`s2`) AS `source2`, SUM(`d`) AS `display`, SUM(`c`) AS `click`, SUM(`r`) AS `reg` 
                FROM (
                    SELECT `make_date`, {$fields1} SUM(IF(`material_source` = '', 1, 0)) AS `s1`, SUM(IF(`material_source` != '', 1, 0)) AS `s2`, 0 AS `d`, 0 AS `c`, 0 AS `r` 
                    FROM `" . LibTable::$material . "` AS `a` 
                    LEFT JOIN `" . LibTable::$sy_game . "` AS `g` ON `a`.`game_id`=g.`game_id`
                    WHERE 1 {$condition} GROUP BY `make_date` 
                    UNION ALL 
                    SELECT `a`.`make_date`, {$fields2} 0 AS `s1`, 0 AS `s2`, SUM(`c`.`display`) AS `d`, SUM(`c`.`click`) AS `c`, 0 AS `r` 
                    FROM `" . LibTable::$material_land . "` AS `b` 
                    LEFT JOIN `" . LibTable::$material . "` AS `a` ON `a`.`material_id` = `b`.`material_id` 
                    LEFT JOIN `" . LibTable::$data_upload . "` AS `c` ON (`c`.`device_type` = " . PLATFORM['android'] . " AND `b`.`package_name` = `c`.`package_name`) OR (`c`.`device_type` = " . PLATFORM['ios'] . " AND `b`.`package_name` = `c`.`package_name` AND `b`.`monitor_id` = `c`.`monitor_id`) 
                    LEFT JOIN `" . LibTable::$sy_game . "` AS `g` ON `a`.`game_id`= `g`.`game_id`
                    WHERE `c`.`date` BETWEEN FROM_UNIXTIME(`a`.`test_start`, '%Y-%m-%d') AND FROM_UNIXTIME(`a`.`test_end`, '%Y-%m-%d') {$condition} 
                    GROUP BY `a`.`make_date` 
                    UNION ALL 
                    SELECT `a`.`make_date`, {$fields2} 0 AS `s1`, 0 AS `s2`, 0 AS `d`, 0 AS `c`, SUM(`c`.`reg`) AS `r` 
                    FROM `" . LibTable::$material_land . "` AS `b` 
                    LEFT JOIN `" . LibTable::$material . "` AS `a` ON `a`.`material_id` = `b`.`material_id` 
                    LEFT JOIN `" . LibTable::$data_reg . "` AS `c` ON (`c`.`device_type` = " . PLATFORM['android'] . " AND `b`.`package_name` = `c`.`package_name`) OR (`c`.`device_type` = " . PLATFORM['ios'] . " AND `b`.`package_name` = `c`.`package_name` AND `b`.`monitor_id` = `c`.`monitor_id`) 
                    LEFT JOIN `" . LibTable::$sy_game . "` AS `g` ON `a`.`game_id`= `g`.`game_id`
                    WHERE `c`.`date` BETWEEN FROM_UNIXTIME(`a`.`test_start`, '%Y-%m-%d') AND FROM_UNIXTIME(`a`.`test_end`, '%Y-%m-%d') {$condition} 
                    GROUP BY `a`.`make_date`
                ) tmp  GROUP BY `make_date` ORDER BY `click` DESC";
        return $this->query($sql, $where);
    }

    public function getMonitor($monitor_id)
    {
        $sql = "select `monitor_id`, `name`, `package_name` from " . LibTable::$ad_project . " where `monitor_id` = :monitor_id ";
        return $this->getOne($sql, array('monitor_id' => $monitor_id));
    }

    public function getMaterialInfo($material_id)
    {
        return $this->getOne("SELECT * FROM " . LibTable::$material . " WHERE `material_id` = $material_id");
    }

    public function insertMaterial($data)
    {
        return $this->insert($data, true, LibTable::$material);
    }

    public function updateMaterial($material_id, $data)
    {
        return $this->update($data, array('material_id' => $material_id), LibTable::$material);
    }

    public function delMaterial($material_id)
    {
        return $this->query("DELETE FROM " . LibTable::$material . " WHERE `material_id` = $material_id");
    }

    public function getMonitorList($game_id = 0, $device_type = 0)
    {
        $sql = "SELECT a.`monitor_id`, a.`name`, a.`package_name` FROM " . LibTable::$ad_project . " a 
                LEFT JOIN " . LibTable::$sy_game_package . " b ON b.`package_name` = a.`package_name` WHERE 1";
        if ($game_id) {
            $sql .= " AND a.`game_id` = $game_id ";
        }
        if ($device_type) {
            $sql .= " AND b.`platform` = $device_type ";
        }
        return $this->query($sql);
    }

    public function getChannelList()
    {
        return $this->query("SELECT * FROM `" . LibTable::$channel . "` ORDER BY `channel_short`");
    }

    public function insertMaterialLand($data)
    {
        return $this->insert($data, true, LibTable::$material_land);
    }

    public function delMaterialLand($material_id)
    {
        return $this->query("DELETE FROM " . LibTable::$material_land . " WHERE `material_id` = $material_id");
    }

    public function getMaterialLandList($material_id)
    {
        $param = [];
        $condition = "";
        if (is_numeric($material_id)) {
            $param['material_id'] = $material_id;
            $condition .= " AND a.`material_id` = :material_id";
        } else {
            $param['ids'] = $material_id['ids'];
            $condition .= " AND a.`material_id` IN(:ids)";

            if ($material_id['game_id']) {
                $param['game_id'] = $material_id['game_id'];
                $condition .= " AND a.`game_id` = :game_id";
            }
            if ($material_id['device_type']) {
                $param['device_type'] = $material_id['device_type'];
                $condition .= " AND a.`device_type` = :device_type";
            }
        }

        $sql = "SELECT a.*, b.`name` AS `monitor_name` FROM `" . LibTable::$material_land . "` a 
                LEFT JOIN `" . LibTable::$ad_project . "` b ON a.`monitor_id` = b.`monitor_id` 
                WHERE 1 {$condition} ORDER BY a.`package_name`";
        return $this->query($sql, $param);
    }

    public function getDownload($ids)
    {
        $sql = "SELECT material_id, material_name, file FROM `" . LibTable::$material . "` WHERE material_id IN(:material_id) ORDER BY `material_id`";
        return $this->query($sql, array('material_id' => $ids));
    }
}