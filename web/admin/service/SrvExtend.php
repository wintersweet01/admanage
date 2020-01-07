<?php

class SrvExtend
{
    public $mod;

    public function __construct()
    {
        $this->mod = new ModExtend();
    }

    public function landHeatMap($model_id)
    {
        $info = $this->mod->landHeatMap($model_id);
        if ($info['list']) {

            foreach ($info['list'] as $key => $val) {
                $x = $val['x'] * 600 / 10000;
                $y = $val['y'];
                $info['click'][(int)($x)][(int)($y)] += 1;
            }
            foreach ($info['click'] as $key => $val) {
                foreach ($val as $k => $v) {
                    $info['max'] = ($v > $info['max']) ? $v : $info['max'];
                }
            }
        }
        return $info;
    }

    public function getLinkList($is_excel = 0, $page, $parent_id, $game_id, $package_name, $channel_id, $keyword, $user_id = 0, $create_user = '', $status = 0)
    {
        $create_user == '' && $create_user = SrvAuth::$name;
        $create_user == 'all' && $create_user = '';

        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getLinkList($is_excel, $page, $parent_id, $game_id, $package_name, $channel_id, $keyword, $user_id, $create_user, $status);
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['parent_id'] = $parent_id;
        $info['game_id'] = $game_id;
        $info['channel_id'] = $channel_id;
        $info['user_id'] = $user_id;
        $info['create_user'] = $create_user;
        LibUtil::clean_xss($keyword);
        $info['keyword'] = $keyword;
        LibUtil::clean_xss($package_name);
        $info['package_name'] = $package_name;
        $info['status'] = $status;

        $srvAd = new SrvAd();
        $srvPlatform = new SrvPlatform();
        $allgame = $srvPlatform->getAllGame(true);
        $allChannel = $srvAd->getAllChannel();

        $info['_games'] = $allgame;
        $info['_channels'] = $allChannel;

        if ($info['game_id']) {
            $modPlatform = new ModPlatform();
            $info['_packages'] = $modPlatform->getPackageByGame($info['game_id']);
        }

        if ($info['total'] > 0) {
            if ($channel_id) {
                $info['users'] = $this->mod->getUserByChannel($channel_id);
            }

            $modAd = new ModAd();
            $channels = $modAd->getChannelList();
            $all_c = array();
            foreach ($channels['list'] as $c) {
                $all_c[$c['channel_id']] = $c['channel_short'];
            }

            foreach ($info['list'] as &$v) {
                $v['short_url'] = AD_DOMAIN_SHORT . $v['monitor_url'];
                $v['model_name'] = $this->mod->getModelName($v['page_id']);
                $v['monitor_url'] = $srvAd->getMonitorUrl($all_c[$v['channel_id']], $v['monitor_url'], $v['platform']);
                $v['administrator'] = $v['administrator'] ? $v['administrator'] : $v['create_user'];

                //CDN投放地址，替换自定义投放地址域名
                $v['local_url'] = '';
                if ($v['jump_url'] && filter_var($v['jump_url'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                    preg_match('/^http[s]?:\/\/(.*)\/(.*)\/index\.html$/', $v['jump_url'], $matches);

                    //本地预览地址
                    if (TG_LOCAL_URL && filter_var(TG_LOCAL_URL, FILTER_VALIDATE_URL)) {
                        $v['local_url'] = TG_LOCAL_URL . $matches[2] . '/index.html';
                    }

                    //替换自定义域名
                    if ($v['domain'] && filter_var($v['domain'], FILTER_VALIDATE_URL)) {
                        if (substr($v['domain'], -1) != '/') {
                            $v['domain'] = $v['domain'] . '/';
                        }
                        $v['jump_url'] = $v['domain'] . $matches[2] . '/index.html';
                    }
                } else {
                    $v['jump_url'] = '';
                }

                //下载地址，替换自定义下载地址域名
                $v['download_url'] = '';
                if ($v['down_url'] && filter_var($v['down_url'], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                    $v['download_url'] = $v['down_url'];
                    if ($v['download_domain'] && filter_var($v['download_domain'], FILTER_VALIDATE_URL)) {
                        if (substr($v['download_domain'], -1) != '/') {
                            $v['download_domain'] = $v['download_domain'] . '/';
                        }
                        $v['download_url'] = $v['download_domain'] . substr(strrchr($v['down_url'], "/"), 1);
                    }
                }
            }
        }

        if ($is_excel > 0) {
            $headerArray = array(
                '游戏名称', '游戏包', '渠道名称', '推广名称', '下载地址', '监测地址'
            );
            $excel_data = array();
            foreach ($info['list'] as $key => $v) {
                $excel_data[] = array(
                    ' ' . $allgame['list'][$v['game_id']],
                    ' ' . $v['package_name'],
                    $allChannel[$v['channel_id']],
                    $v['name'],
                    $v['jump_url'],
                    $v['monitor_url'],
                );
            }

            $filename = '推广链管理';
            return array(
                'filename' => $filename, 'headerArray' => $headerArray, 'data' => $excel_data
            );
        }

        return $info;
    }

    /**
     * 推广链回调日志
     * @param $page
     * @param $monitor_id
     * @param $type
     * @param $sdate
     * @param $edate
     * @param string $keyword
     * @param int $is_excel
     * @return array
     */
    public function getChannelLog($page, $monitor_id, $type, $sdate, $edate, $keyword = '', $is_excel = 0)
    {
        if (!$sdate) {
            $sdate = date('Y-m-d', time() - 86400);
        }
        if (!$edate) {
            $edate = date('Y-m-d', time());
        }

        $info = $this->mod->getChannelLog($page, $monitor_id, $type, $sdate, $edate, $keyword, $is_excel);

        if ($is_excel > 0) {
            $headerArray = array(
                '推广名称', '时间', '类型', 'URL', '参数', '结果'
            );

            $excel_data = array();
            foreach ($info['list'] as $key => $val) {
                $excel_data[] = array(
                    $val['monitor_name'],
                    date('Y-m-d H:i:s', $val['upload_time']),
                    $val['upload_type'],
                    $val['url'],
                    $val['param'],
                    $val['result'],
                );
            }

            return array(
                'filename' => '回调日志',
                'headerArray' => $headerArray,
                'data' => $excel_data
            );
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        $info['sdate'] = $sdate;
        $info['edate'] = $edate;
        $info['type'] = $type;
        $info['keyword'] = $keyword;

        return $info;
    }

    public function linkCostExcel($parent_id = 0, $game_id = 0, $channel_id = 0, $create_user = '')
    {
        $info = $this->mod->getLinkList(1, 0, $parent_id, $game_id, '', $channel_id, '', 0, $create_user);
        $header = array(
            '日期', '推广ID（勿动此列）', '游戏名称（勿动此列）', '包标识（勿动此列）', '渠道名称（勿动此列）', '推广名称（勿动此列）', '成本（单位：元）', '展示', '点击', '游戏id（勿动此列）', '渠道id（勿动此列）'
        );
        $data = array();
        $srvPlatform = new SrvPlatform();
        $srvAd = new SrvAd();

        $games = $srvPlatform->getAllGame();
        $channels = $srvAd->getAllChannel();
        $date = date('Y/m/d', strtotime('yesterday'));
        foreach ($info['list'] as $v) {
            $data[] = array(
                $date,
                $v['monitor_id'],
                $games[$v['game_id']],
                $v['package_name'],
                $channels[$v['channel_id']],
                $v['name'],
                '',
                '',
                '',
                $v['game_id'],
                $v['channel_id'],
            );
        }
        return array(
            'header' => $header,
            'data' => $data,
        );
    }

    public function getLinkInfo($monitor_id)
    {
        $result = $this->mod->getLinkInfo($monitor_id);
        if (!empty($result)) {
            $result['users'] = $this->mod->getUserByChannel($result['channel_id']);
            $modPlatform = new ModPlatform();
            $result['_packages'] = $modPlatform->getPackageByGame($result['game_id']);
            $result['_models'] = $this->getModelByGame($result['game_id']);
            $result['page_info'] = $this->mod->getLandPageInfo($result['page_id']);
            $result['page_info']['header_info'] = json_decode($result['page_info']['header_info'], true);
        }
        return $result;
    }

    public function addLinkAction($monitor_id, $data)
    {
        if ($data['name'] == '') {
            return array('state' => false, 'msg' => '推广名称不能为空');
        }
        if ($data['game_id'] == '') {
            return array('state' => false, 'msg' => '游戏不能为空');
        }
        if ($data['channel_id'] == '') {
            return array('state' => false, 'msg' => '渠道不能为空');
        }
        if ($data['package_name'] == '') {
            return array('state' => false, 'msg' => '推广包不能为空');
        }
        if ($data['user_id'] == '') {
            return array('state' => false, 'msg' => '投放账号不能为空');
        }
        if ($data['create_user'] == '') {
            return array('state' => false, 'msg' => '负责人不能为空');
        }

        if (strpos($data['package_name'], 'android')) {
            $same_package = $this->mod->getSamePackage($data['package_name'], $monitor_id);
            if (!empty($same_package)) {
                return array('state' => false, 'msg' => '该安卓包已经创建了一个推广计划，请更换游戏包或者新建一个包');
            }

            if ($data['number'] > 1) {
                return array('state' => false, 'msg' => '一个安卓包只能创建一个推广计划');
            }
        }

        $same_name = $this->mod->getSameName($data['name'], $monitor_id);
        if (!empty($same_name)) {
            return array('state' => false, 'msg' => '名称已存在,请更换');
        }

        $out = array();
        if ($monitor_id) {
            unset($data['number']);
            $result = $this->mod->updateLinkAction($monitor_id, $data);
        } else {
            if ($data['number'] < 1) {
                return array('state' => false, 'msg' => '生成链接数量不正确');
            }

            $multi_data = array();
            if ($data['number'] == 1) {
                $_multi_data = $data;
                unset($_multi_data['number']);
                $_multi_data['create_time'] = time();
                $_multi_data['monitor_url'] = base_convert(LibUtil::makeOrderNum() . mt_rand(10000, 99999), 10, 36);
                $multi_data[] = $_multi_data;
                $out[$data['name']] = $_multi_data['monitor_url'];
            } else {
                for ($i = 0; $i < $data['number']; $i++) {
                    $_multi_data = $data;
                    unset($_multi_data['number']);
                    $_multi_data['name'] .= '-' . ($i + 1);
                    $_multi_data['create_time'] = time();
                    $_multi_data['monitor_url'] = base_convert(LibUtil::makeOrderNum() . mt_rand(10000, 99999), 10, 36);
                    $multi_data[] = $_multi_data;
                    $out[$_multi_data['name']] = $_multi_data['monitor_url'];
                }
            }
            $result = $this->mod->addLinkAction($multi_data);
        }

        if (!empty($result)) {
            if (is_array($result)) {
                foreach ($result as $monitor_id) {
                    $this->clearCacheLink($monitor_id);
                }
            } else {
                $this->clearCacheLink($monitor_id);
            }

            return array('state' => true, 'msg' => '操作成功', 'data' => $out);
        } else {
            return array('state' => false, 'msg' => '操作失败[2]');
        }
    }

    /**
     * 删除推广链接
     * @param int $monitor_id
     * @return array
     */
    public function delLink($monitor_id = 0)
    {
        if ($monitor_id <= 0) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $info = $this->mod->getLinkInfo($monitor_id);
        if (empty($info)) {
            return array('state' => false, 'msg' => '记录不存在');
        }

        $ret = $this->mod->delLink($monitor_id);
        if (!$ret) {
            return array('state' => false, 'msg' => '删除失败');
        }

        //删除CDN落地页
        if ($info['page_url']) {
            $dir = CDN_DIR . $info['page_url'] . '/';
            if (is_dir($dir)) {
                LibUtil::delDir($dir);
            }
        }

        //删除CDN安卓包
        if ($info['device_type'] == PLATFORM['android'] && $info['down_url']) {
            $apk = substr(strrchr($info['down_url'], '/'), 1);
            if ($apk && is_file(APK_DIR . $apk)) {
                unlink(APK_DIR . $apk);
            }

            $ModPlatform = new ModPlatform();
            $ModPlatform->delPackage($info['package_name']);
            $ModPlatform->delPackageRefresh($info['package_name']);
        }

        $this->mod->delLandPageAction($info['page_id']);

        //删除缓存
        LibRedis::delete(strtoupper(LibRedis::$prefix_monitor_code . $info['monitor_url']));
        LibRedis::delete(strtoupper(LibRedis::$prefix_package_name . $info['package_name']));

        return array('state' => true, 'msg' => '删除成功');
    }

    /**
     * 停用推广链接
     * @param int $monitor_id
     * @return array
     */
    public function stopLink($monitor_id = 0)
    {
        if ($monitor_id <= 0) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $info = $this->mod->getLinkInfo($monitor_id);
        if (empty($info)) {
            return array('state' => false, 'msg' => '记录不存在');
        }

        $ret = $this->mod->updateLinkAction($monitor_id, array('status' => 1));
        if (!$ret) {
            return array('state' => false, 'msg' => '停用失败');
        }

        //删除CDN落地页
        if ($info['page_url']) {
            $dir = CDN_DIR . $info['page_url'] . '/';
            if (is_dir($dir)) {
                LibUtil::delDir($dir);
            }
        }

        //删除CDN安卓包
        if ($info['device_type'] == PLATFORM['android'] && $info['down_url']) {
            $apk = substr(strrchr($info['down_url'], '/'), 1);
            if ($apk && is_file(APK_DIR . $apk)) {
                unlink(APK_DIR . $apk);
            }

            //$ModPlatform = new ModPlatform();
            //$ModPlatform->delPackage($info['package_name']);
            //$ModPlatform->delPackageRefresh($info['package_name']);
        }

        return array('state' => true, 'msg' => '停用成功');
    }

    /**
     * 批量停用链接
     * @param array $monitorIdArr
     * @return array
     */
    public function stopLinkBatch($monitorIdArr)
    {
        if (empty($monitorIdArr)) {
            return array();
        }
        $monitorInfo = $this->mod->getLinkInfoBatch($monitorIdArr);
        if (empty($monitorInfo)) {
            return array('state' => false, '', 'msg' => '记录不存在');
        }
        $retData = array();
        foreach ($monitorInfo as $row) {
            //更新状态
            $ret = $this->mod->updateLinkAction($row['monitor_id'], array('status' => 1));
            if (!$ret) continue;
            //删除CDN落地页
            if ($row['page_url']) {
                $dir = CDN_DIR . $row['page_url'] . '/';
                if (is_dir($dir)) {
                    LibUtil::delDir($dir);
                }
            }
            //删除CDN安卓包
            if ($row['device_type'] == PLATFORM['android'] && $row['down_url']) {
                $apk = substr(strrchr($row['down_url'], '/'), 1);
                if ($apk && is_file(APK_DIR . $apk)) {
                    unlink(APK_DIR . $apk);
                }
                //$ModPlatform = new ModPlatform();
                //$ModPlatform->delPackage($info['package_name']);
                //$ModPlatform->delPackageRefresh($info['package_name']);
            }
            $retData[] = $row['monitor_id'];
        }
        $count = count($retData);
        return array('state' => true, 'data' => $retData, 'msg' => $count . '条停用成功');
    }

    public function getAllPage()
    {
        $info = $this->mod->getAllPage();
        return $info;
    }

    public function getLandPageList($page, $game_id, $model_id, $company_id, $name)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getLandPageList($page, $game_id, $model_id, $company_id, $name);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $info['game_id'] = $game_id;
        $info['model_id'] = $model_id;
        $info['company_id'] = $company_id;

        LibUtil::clean_xss($name);
        $info['name'] = $name;

        return $info;
    }

    public function getAllModel()
    {
        $info = $this->mod->getLandModelList();
        $models = array();
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                $models[$v['model_id']] = $v;
            }
        }
        return $models;
    }

    public function getModelByGame($game_id)
    {
        $info = $this->mod->getLandModelList($game_id);
        $models = array();
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                $v['update_time'] = date('Y-m-d H:i:s', $v['update_time']);
                $models[$v['model_id']] = $v;
            }
        }
        return $models;
    }

    public function getAllCompany()
    {
        $modAd = new ModAd();
        $info = $modAd->getAdCompanyList();

        $company = array();
        if ($info['total'] > 0) {
            foreach ($info['list'] as $v) {
                $company[$v['company_id']] = $v['company_name'];
            }
        }

        return $company;
    }

    public function getLandCountList($page, $page_id)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getLandCountList($page, $page_id);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        $info['page_id'] = $page_id;

        return $info;
    }


    public function getLandHourCountList($page, $code)
    {
        $page = $page < 1 ? 1 : $page;
        $info = $this->mod->getLandHourCountList($page, $code);
        $modAd = new ModAd();

        $channels = $modAd->getChannelList();
        $all_c = array();
        foreach ($channels['list'] as $c) {
            $all_c[$c['channel_id']] = $c['channel_short'];
        }
        $v = $this->mod->getLinkInfoByCode($code);
        $info = array_merge($info, $v);
        $srvAd = new SrvAd();
        $info['monitor_url'] = $srvAd->getMonitorUrl($all_c[$v['channel_id']], $v['monitor_url']);

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;

        LibUtil::clean_xss($code);
        $info['code'] = $code;

        return $info;
    }

    public function getLandPageInfo($page_id)
    {
        $result = $this->mod->getLandPageInfo($page_id);
        $result['header_info'] = json_decode($result['header_info'], true);
        return $result;
    }

    public function changeModel($page_url, $model_id)
    {
        $data = $this->mod->getLandPageInfoByPageUrl($page_url);
        if (empty($data)) return array('state' => false, 'msg' => 'error');
        $data['model_id'] = $model_id;
        $page_id = $data['page_id'];
        unset($data['page_id']);
        $data['header_info'] = json_decode($data['header_info'], true);
        $data['header_title'] = $data['header_info']['header_title'];
        $data['header_sub_title'] = $data['header_info']['header_sub_title'];
        $data['header_button'] = $data['header_info']['header_button'];
        return $this->addLandPageAction($page_id, 0, $data);
    }

    public function addLandPageAction($page_id, $new, $data)
    {
        if ($data['model_id'] == '') {
            return array('state' => false, 'msg' => '模板ID不能为空');
        }
        if ($data['game_id'] == '') {
            return array('state' => false, 'msg' => '游戏不能为空');
        }
        if ($data['page_name'] == '') {
            return array('state' => false, 'msg' => '落地页名称不能为空');
        }

        $header = [];
        if ($data['auto_header']) {
            $header = array(
                'header_title' => $data['header_title'],
                'header_sub_title' => $data['header_sub_title'],
                'header_button' => $data['header_button'],
            );
            $data['header_info'] = json_encode($header);
        }
        unset($data['header_title']);
        unset($data['header_sub_title']);
        unset($data['header_button']);

        $isdel = false;
        if ($page_id && $new == 0) {
            $pageinfo = $this->mod->getLandPageInfo($page_id);
            $url = $pageinfo['page_url'];

            //更换模板时，删掉旧模板
            if ($pageinfo['model_id'] != $data['model_id'] && $url) {
                $isdel = true;
            }

            $result = $this->mod->updateLandPageAction($page_id, $data);
        } else {
            $data['success_time'] = time();
            $data['page_url'] = $url = LibUtil::makeOrderNum();
            $page_id = $result = $this->mod->addLandPageAction($data);
        }
        if (!$result) {
            return array('state' => false, 'msg' => '操作失败[1:' . $result . ']');
        }

        $dir = CDN_DIR . $url . '/';
        if ($isdel && $url && is_dir($dir)) {
            LibUtil::delDir($dir);
        }

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        //html
        $model_info = $this->mod->getLandModelInfo($data['model_id']);
        $modPlatform = new ModPlatform();

        $package_info = $modPlatform->getPackageInfoByPackageName($data['package_name']);
        $game_info = $modPlatform->getGameInfo($data['game_id']);

        if ($model_info['model_type'] == 0) {//整张图片方式上传
            $img_html = $this->cutImg($model_info['img'], $model_info['cut_size'], $dir);
            if (!$img_html) {
                return array('state' => false, 'msg' => '切图失败');
            }
            $result = $this->makeHtml($dir, $img_html, $game_info, $package_info, $data['company_id'], $data['auto_jump'], $data['display_foot'], $page_id, $data['model_id'], $data['click_body'], $header, $data['code']);
        }

        if ($model_info['model_type'] == 1) {//压缩包方式上传
            if (!$this->unzip($model_info['zip'], $dir)) {
                return array('state' => false, 'msg' => '解压失败');
            }
            $result = $this->modifyHtml($dir, $package_info, $data['company_id'], $data['auto_jump'], $data['display_foot'], $page_id, $data['model_id'], $data['click_body'], $header, $game_info, $data['code']);
        }

        if (!$result) {
            return array('state' => true, 'msg' => '生成html失败');
        }

        $this->mod->updateLandPageAction($page_id, array('success_time' => time()));
        return array('state' => true, 'msg' => '操作成功', 'page_id' => $page_id, 'url' => $url);
    }

    public function delLandPageAction($page_id)
    {
        $result = $this->mod->delLandPageAction($page_id);
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function getLandModelList($game_id, $page, $sort = '')
    {
        $page_num = 15;
        $page = $page < 1 ? 1 : $page;

        if ($sort) {
            $info = $this->mod->getLandModelListBySort($game_id, $page, $page_num, $sort);
        } else {
            $info = $this->mod->getLandModelList($game_id, $page, $page_num);
        }

        foreach ($info['list'] as &$i) {
            $i['model_url'] = LAND_MODEL_URL . $i['model_url'] . '/';
            $i['model_zip'] = UPLOAD_MODEL_URL . '/' . $i['zip'];
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, $page_num);
        $info['page_num'] = $page_num;

        return $info;
    }

    public function getLandModelInfo($model_id)
    {
        $result = $this->mod->getLandModelInfo($model_id);
        return $result;
    }


    public function editLandModelInfo($model_id)
    {
        $dir = RUNTIME_DIR . '/tmp/' . self::getLandPageDir($model_id);
        $model_info = $this->mod->getLandModelInfo($model_id);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $this->unzip($model_info['zip'], $dir);
        $file = file_get_contents($dir . '/index.html');
        require LIB . '/library/simple_html_dom.php';
        $html = new simple_html_dom();
        $obj = $html->load($file);
        $text = array();
        foreach ($obj->find('text') as $i => $o) {
            if (trim($o->plaintext)) {
                $text[$i] = trim($o->plaintext);
            };
        }
        $img = array();
        foreach ($obj->find('img') as $j => $_img) {
            if (trim($_img->src)) {
                $img[$j] = trim($_img->src);
            };
        }
        $new_img = array();
        $array_count = array_count_values($img);
        foreach ($array_count as $src => $count) {
            if ($count < 3) {
                $new_img[array_search($src, $img)] = array(
                    'src' => (strpos($src, 'http') === 0 || strpos($src, '//') === 0) ? $src : CDN_URL . self::getLandPageDir($model_id) . '/' . $src,
                    'size' => getimagesize((strpos($src, 'http') === 0 || strpos($src, '//') === 0) ? $src : CDN_URL . self::getLandPageDir($model_id) . '/' . $src));
            }
        }

        return array('img' => $new_img, 'text' => $text);
    }

    public function insertUpload($model_id, $name, $type = array())
    {
        if (empty($type)) {
            $type = array('.jpg', '.png', '.jpeg');
        }
        if ($model_id == 0) {
            return LibUtil::retData(false, array(), 'id为空');
        }
        $dir = RUNTIME_DIR . '/tmp/' . self::getLandPageDir($model_id);
        $result = LibFile::upload($name, $dir, '.', 10240, $type);
        if ($result['state']) {
            return array('state' => true, 'url' => $result['url'], 'msg' => '上传成功', 'base64' => $this->base64EncodeImage($result['file']));
        }
        return array('state' => false, 'msg' => $result['msg']);
    }

    public function base64EncodeImage($image_file)
    {
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    public function editModelAction($param)
    {
        $model_id = $param['model_id'];
        unset($param['model_id']);
        $tmp_dir = RUNTIME_DIR . '/tmp/' . self::getLandPageDir($model_id);
        $data = $this->mod->getLandModelInfo($model_id);
        $file = file_get_contents($tmp_dir . '/index.html');

        $text = array();
        $img = array();
        foreach ($param as $name => $value) {
            if (preg_match('/text_(\d+)/', $name, $number)) {
                //text
                $text[$number[1]] = $value;
            }

            if (preg_match('/img_(\d+)/', $name, $number)) {
                //img
                if (strpos($value, './') === 0) {
                    $img[$number[1]] = $value;
                }
            }
        }

        require LIB . '/library/simple_html_dom.php';

        $html = new simple_html_dom();
        $obj = $html->load($file);
        if (!empty($text)) {
            foreach ($obj->find('text') as $i => $o) {
                if ($text[$i]) {
                    Debug::log($text[$i]);
                    $o->innertext = $text[$i];
                };
            }
        }

        if (!empty($img)) {
            foreach ($obj->find('img') as $j => $_img) {
                if ($img[$j]) {
                    $_img->src = $img[$j];
                };
            }
        }

        $result = $obj->save($tmp_dir . '/index.html');
        if (!$result) {
            return LibUtil::retData(false, array(), '保存文件失败');
        }

        if (!$this->zip($data['zip'], $tmp_dir)) {
            return LibUtil::retData(false, array(), '压缩文件失败');
        }
        $dir = LAND_MODEL_DIR . self::getLandPageDir($model_id) . '/';
        if (!$this->unzip($data['zip'], $dir)) {
            return LibUtil::retData(false, array(), '重新生成模板失败');
        }
        $result = $this->modifyHtml($dir, array(), $data['company_id']);
        if ($result) {
            return LibUtil::retData(true, array());
        } else {
            return LibUtil::retData(false, array(), '重新生成模板失败');
        }
    }

    public function addLandModel($model_id, $data)
    {
        if ($data['game_id'] <= 0) {
            return array('state' => false, 'msg' => '游戏不能为空');
        }
        if (!$data['model_name']) {
            return array('state' => false, 'msg' => '模板名称不能为空');
        }

        $zip = '';
        $data['administrator'] = $_SESSION['username'];
        $data['update_time'] = time();
        $data['model_type'] = 1;

        if ($model_id) {
            $info = $this->getLandModelInfo($model_id);
            if (empty($info)) {
                return array('state' => false, 'msg' => '模板不存在');
            }

            //替换为新缩略图
            if ($data['thumb']) {
                @unlink(PIC_UPLOAD_DIR . $info['thumb']);
            }

            if (!$data['zip']) {
                unset($data['zip']);
            }
            if (!$data['thumb']) {
                unset($data['thumb']);
            }

            $zip = UPLOAD_MODEL_DIR . '/' . $info['zip'];
            $data['model_url'] = self::getLandPageDir($model_id);
            $result = $this->mod->updateLandModel($model_id, $data);
            if (!$result) {
                return array('state' => false, 'msg' => '更新失败');
            }
        } else {
            if (!$data['zip']) {
                return array('state' => false, 'msg' => '请上传模板压缩包');
            }
            if (!$data['thumb']) {
                return array('state' => false, 'msg' => '请上传缩略图');
            }

            $model_id = $this->mod->addLandModel($data);
            if (!$model_id) {
                return array('state' => false, 'msg' => '保存失败[2]');
            }

            $result = $this->mod->updateLandModel($model_id, array('model_url' => self::getLandPageDir($model_id)));
            if (!$result) {
                return array('state' => false, 'msg' => '保存失败[3]');
            }
        }

        if ($data['zip']) {
            $tmp_file = RUNTIME_DIR . '/tmp/' . $data['zip'];
            if (!is_file($tmp_file)) {
                return array('state' => false, 'msg' => '上传文件已失效，请重新上传');
            }

            if ($zip && is_file($zip)) {
                unlink($zip);
            }

            $zip = UPLOAD_MODEL_DIR . '/' . $data['zip'];
            if (!is_dir(dirname($zip))) {
                mkdir(dirname($zip), 0755, true);
            }

            $result = rename($tmp_file, $zip);
            if (!$result) {
                return array('state' => false, 'msg' => '保存失败[1]');
            }
            unlink($tmp_file);

            $dir = LAND_MODEL_DIR . self::getLandPageDir($model_id) . '/';
            //删除旧模板文件
            if (is_dir($dir)) {
                LibUtil::delDir($dir);
            }

            mkdir($dir, 0755, true);
            if ($msg = LibUtil::unzip($zip, $dir) !== true) {
                return array('state' => false, 'msg' => $msg);
            }
            $result = $this->modifyModelHtml($dir);
            if (!$result) {
                return array('state' => true, 'msg' => '模板生成失败');
            }
        }

        return array('state' => true, 'msg' => '保存成功');
    }

    /**
     * 生成落地页model html
     * @param $dir
     * @param $img_html
     * @param $game_info
     * @return bool|int
     */
    private function makeModelHtml($dir, $img_html)
    {
        $data['img'] = $img_html;
        //$data['game_name'] = $game_info['name'];

        $data['href'] = '';
        $data['header'] = '';
        $data['footer'] = '';
        $data['action'] = '<script>document.domain="' . GLOBAL_DOMAIN . '";</script>';

        $html = file_get_contents(TEMPLATE_FILE . 'img.html');
        foreach ($data as $key => $value) {
            $html = str_replace('<{$' . $key . '}>', $value, $html);
        }
        return file_put_contents($dir . 'index.html', $html);
    }

    /**
     * 生成zip落地页model html
     * @param $dir
     * @return bool|int
     */
    private function modifyModelHtml($dir)
    {
        $html = file_get_contents($dir . 'index.html');
        if (!preg_match('/name=\"viewport\"/', $html)) {
            $html = preg_replace('/<head>/', '<head><meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">', $html);
        }
        $html = str_replace('</body>', "<script>document.domain=\"" . GLOBAL_DOMAIN . "\";</script>\n</body>", $html);
        return file_put_contents($dir . 'index.html', $html);
    }

    private function modifyHtml($dir, $package_info = array(), $company = '', $auto_jump = 0, $foot_display = 1, $page_id = 0, $model_id = 0, $click_body = 0, $header = array(), $game_info = array(), $code = '')
    {
        $modAd = new ModAd();
        $company_info = $modAd->getAdCompanyInfo($company);

        $html = file_get_contents($dir . 'index.html');

        if (!preg_match('/name=\"viewport\"/', $html)) {
            $html = preg_replace('/<head>/', '<head><meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">', $html);
        }

        if (!empty($header)) {
            $html = preg_replace('/<body(\s)*(.*?)>/', '<body$1$2>' . $this->makeHeaderHtml($header, ($package_info['spec_icon'] ? $package_info['spec_icon'] : $game_info['icon'])), $html);
        }

        if ($foot_display) {
            $html = str_replace('</body>', $this->makeFooterHtml($company_info) . '</body>', $html);
        }

        if ($package_info) {
            $html = str_replace('</body>', $this->makeHrefHtml($package_info, $auto_jump, $model_id, $page_id) . '</body>', $html);
        }

        if ($page_id) {
            $html = str_replace('</body>', $this->makeActionHtml($model_id, $page_id, $click_body) . '</body>', $html);
        }

        //JS代码
        if ($code) {
            $html = str_replace('</body>', $code . '</body>', $html);
        }

        return file_put_contents($dir . 'index.html', $html);
    }

    private function makeHtml($dir, $img_html, $game_info, $package_info, $company, $auto_jump = 0, $foot_display = 1, $page_id = 0, $model_id = 0, $click_body = 0, $header = array(), $code = '')
    {

        $data['img'] = $img_html;
        $data['game_name'] = $package_info['spec_name'] ? $package_info['spec_name'] : $game_info['name'];

        $modAd = new ModAd();
        $company_info = $modAd->getAdCompanyInfo($company);

        $data['href'] = $this->makeHrefHtml($package_info, $auto_jump, $model_id, $page_id);
        $data['footer'] = '';
        $data['action'] = '';
        $data['header'] = '';

        if (!empty($header)) {
            $data['header'] = $this->makeHeaderHtml($header, ($package_info['spec_icon'] ? $package_info['spec_icon'] : $game_info['icon']));
        }

        if ($foot_display) {
            $data['footer'] = $this->makeFooterHtml($company_info);
        }

        if ($page_id) {
            $data['action'] = $this->makeActionHtml($model_id, $page_id, $click_body);
        }
        $html = file_get_contents(TEMPLATE_FILE . 'img.html');
        if ($click_body == 1) {
            $html = preg_replace('/<a(\s)*(.*?)>(.*?)<\/a>/s', "$3", $html);
        }
        foreach ($data as $key => $value) {
            $html = str_replace('<{$' . $key . '}>', $value, $html);
        }

        //JS代码
        if ($code) {
            $html = str_replace('</body>', $code . '</body>', $html);
        }

        return file_put_contents($dir . 'index.html', $html);
    }

    private function makeActionHtml($model_id, $page_id, $click_body)
    {
        $data['action_url'] = TJ_LAND_URL . '?lid=' . $page_id . '&mid=' . $model_id;
        $action_html = file_get_contents(TEMPLATE_FILE . 'action.html');
        if ($click_body == 1) {
            //不要点击页面就跳转
            $action_html = preg_replace('/<script(\s)*(.*?)>.*?<\/script>/s', '', $action_html);
        }
        foreach ($data as $key => $value) {
            $action_html = str_replace('<{$' . $key . '}>', $value, $action_html);
        }
        return $action_html;
    }

    private function makeHrefHtml($package_info, $auto_jump = 0, $model_id = 0, $page_id = 0)
    {
        $data['download_url'] = $package_info['platform'] == PLATFORM['ios'] ? APPSTORE_URL . $package_info['down_url'] : $package_info['down_url'];
        $data['action_url'] = TJ_LAND_URL . '?lid=' . $page_id . '&mid=' . $model_id;
        $data['auto_jump'] = (int)$auto_jump;
        $href_html = file_get_contents(TEMPLATE_FILE . 'href.html');
        foreach ($data as $key => $value) {
            $href_html = str_replace('<{$' . $key . '}>', $value, $href_html);
        }
        return $href_html;
    }

    private function makeHeaderHtml($header, $icon)
    {
        $data['icon'] = $icon;
        $data['title'] = $header['header_title'];
        $data['sub_title'] = html_entity_decode($header['header_sub_title']);
        $data['button'] = $header['header_button'];
        $header_html = file_get_contents(TEMPLATE_FILE . 'header.html');
        foreach ($data as $key => $value) {
            $header_html = str_replace('<{$' . $key . '}>', $value, $header_html);
        }
        return $header_html;
    }

    private function makeFooterHtml($company = array())
    {
        $footer_html = file_get_contents(TEMPLATE_FILE . 'footer.html');
        $footer = array(
            'company_name', 'record_no', 'domain', 'www', 'icp', 'service_tel', 'address'
        );
        $data = array();
        foreach ($footer as $f) {
            if ($company[$f]) {
                $data[$f] = $company[$f];
            }
        }
        foreach ($data as $key => $value) {
            $footer_html = str_replace('<{$' . $key . '}>', $value, $footer_html);
        }
        $footer_html = preg_replace('/<\{(.*?)\}>/', '', $footer_html);
        return $footer_html;
    }

    private function cutImg($img, $count, $dir)
    {
        $img = PIC_UPLOAD_DIR . $img;
        list($width, $height) = getimagesize($img);
        $info = pathinfo($img);
        $size = ceil($height / $count);
        $img_html = array();
        $name = substr(md5($dir), 10, 6);
        for ($i = 0; $i < $count; $i++) {
            if (!is_dir($dir . 'images/')) {
                mkdir($dir . 'images/', 0755, true);
            }
            $dst = 'images/' . $name . '_' . $i . '.' . $info['extension'];
            $start_y = $i * $size;
            $dst_height = $size;
            if ($i + 1 == $count) {
                $dst_height = $height - $i * $size;
            }
            $result = LibImg::imagecut($img, $dir . $dst, 0, $start_y, $width, $dst_height, $width, $dst_height, '#ffffff', 75);
            if (!$result['state']) {
                return false;
            }
            $img_html[] = '<img src="' . $dst . '" />';
        }
        return join('', $img_html);
    }

    private function unzip($zip, $dir)
    {
        $file = UPLOAD_MODEL_DIR . '/' . $zip;
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            if ($zip->open($file) !== true) {
                return false;
            }
            $zip->extractTo(str_replace("\\", "/", $dir));
            $zip->close();
        } else {
            exec('cd ' . $dir . ';unzip -o ' . $file, $out, $status);
            if ($status !== 0) {
                return false;
            }
        }
        return true;
    }

    private function zip($zip, $dir)
    {
        exec('cd ' . $dir . ';zip -rm ' . PIC_UPLOAD_DIR . $zip . ' ./*', $out, $status);
        Debug::log($out);
        if ($status !== 0) {
            return false;
        }
        return true;
    }

    private static function getLandPageDir($model_id)
    {
        return 'model_' . md5(LAND_PAGE_KEY . $model_id . LAND_PAGE_KEY);
    }

    public function delLandModel($model_id)
    {
        $info = $this->mod->getLandPageInfoByModel($model_id);
        if (!empty($info)) {
            return array('state' => false, 'msg' => '该模板还在使用中，不能删除');
        }

        $row = $this->mod->getLandModelInfo($model_id);
        if (empty($row)) {
            return array('state' => false, 'msg' => '模板不存在');
        }

        //删除模板目录
        $dir = LAND_MODEL_DIR . self::getLandPageDir($model_id);
        if (is_dir($dir)) {
            //exec('rm -rf ' . $dir, $out, $status);
            LibUtil::delDir($dir);
        }
        //删除模板压缩包
        if ($row['zip']) {
            unlink(UPLOAD_MODEL_DIR . '/' . $row['zip']);
        }
        //删除缩略图
        if ($row['thumb']) {
            unlink(PIC_UPLOAD_DIR . $row['thumb']);
        }

        $result = $this->mod->delLandModel($model_id);
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function modifyLandPageAllAction($monitor_id, $data)
    {
        if (!$monitor_id) {
            return array('state' => false, 'msg' => '推广链id不能为空');
        }

        $ids = array();
        $monitor_id = explode(',', $monitor_id);
        foreach ($monitor_id as $v) {
            if (intval($v)) {
                $ids[] = intval($v);
            }
        }
        foreach ($data as $key => $val) {
            if (!$val) {
                unset($data[$key]);
            }
        }

        if (empty($data)) {
            return array('state' => false, 'msg' => '无修改数据');
        }

        $result = $this->mod->modifyLandPageAllAction($ids, $data);
        if ($result) {
            return array('state' => true, 'msg' => '操作成功');
        } else {
            return array('state' => false, 'msg' => '操作失败');
        }
    }

    public function getUserByChannel($channel_id)
    {
        return $this->mod->getUserByChannel($channel_id);
    }

    public function costUploadAction($file = '')
    {
        if (!$file) {
            return array('state' => false, 'msg' => '请先上传文件');
        }

        $_file = RUNTIME_DIR . '/tmp/' . $file;
        if (!is_file($_file)) {
            return array('state' => false, 'msg' => '上传文件已失效，请重新上传');
        }

        $c = $t = 0;
        $data = SrvPHPExcel::excel2array($_file);
        $modData = new ModData();
        foreach ($data as $v) {
            $t++;

            $date = $v[0];
            if (empty($date)) {
                continue;
            }

            if (preg_match('/^\d{1,2}\/\d{1,2}\/20\d\d/', $v[0])) {
                $_date = explode('/', $v[0]);
                $date = $_date[2] . '/' . $_date['0'] . '/' . $_date[1];
            }
            if (preg_match('/^20\d\d\/\d{1,2}\/\d{1,2}$/', $v[0])) {
                $date = $v[0];
            }

            if (!$date) {
                unlink($_file);
                return array('state' => true, 'msg' => '日期格式不正确' . $v[0]);
            }

            $package_name = trim($v[3]);
            $monitor_id = (int)$v[1];
            $cost = (int)($v[6] * 100); //单位：分
            $display = (int)$v[7];
            $click = (int)$v[8];
            $game_id = (int)$v[9];
            $channel_id = (int)$v[10];

            if (empty($package_name) || $monitor_id <= 0 || $game_id <= 0 || $channel_id <= 0) {
                continue;
            }
            if ($cost <= 0 && $display <= 0 && $click <= 0) {
                continue;
            }

            $modData->uploadData($date, $monitor_id, $package_name, $cost, $display, $click, $game_id, $channel_id);
            $ret = $modData->affectedRows();
            if ($ret) {
                $c++;
            }
        }
        unlink($_file);

        return array('state' => true, 'msg' => "共上传 <b>{$t}</b> 条记录，成功录入（更新） <b>{$c}</b> 条记录");
    }

    public function costUploadList($param = [], $page = 1, $limit = 15, $upload = 0)
    {
        $parent_id = isset($param['parent_id']) ? (int)$param['parent_id'] : 0;
        $game_id = (int)$param['game_id'];
        $package_name = trim($param['package_name']);
        $channel_id = (int)$param['channel_id'];
        $create_user = trim($param['create_user']);
        $date = trim($param['date']);

        $create_user == '' && $create_user = SrvAuth::$name;
        $create_user == 'all' && $create_user = '';
        $page = $page < 1 ? 1 : $page;
        $games = LibUtil::config('games');

        if ($upload) {
            $srvAd = new SrvAd();
            $channels = $srvAd->getAllChannel();

            $date > date('Y-m-d') && $date = '';
            $date || $date = date('Y-m-d', strtotime('yesterday'));

            $old = [];
            $tmp = $this->mod->costUploadList(0, $limit, $parent_id, $game_id, $package_name, $channel_id, $create_user, $date);
            foreach ($tmp['list'] as $row) {
                $key = $row['date'] . $row['game_id'] . $row['package_name'] . $row['channel_id'] . $row['monitor_id'];
                $old[$key] = $row;
            }

            $info = $this->mod->getLinkList(0, $page, $parent_id, $game_id, $package_name, $channel_id, '', 0, $create_user, '', $limit);
            foreach ($info['list'] as &$v) {
                $v['id'] = 0;
                $v['date'] = $date;
                $v['game_name'] = $games[$v['game_id']]['name'];
                $v['device_type'] = &$v['platform'];
                $v['channel_name'] = $channels[$v['channel_id']];
                $v['monitor_name'] = &$v['name'];

                $key = $v['date'] . $v['game_id'] . $v['package_name'] . $v['channel_id'] . $v['monitor_id'];
                if (isset($old[$key])) {
                    $v = $old[$key];
                }

                $v['parent_name'] = $games[$v['parent_id']]['name'];
                $v['upload'] = 1;
            }
        } else {
            $info = $this->mod->costUploadList($page, $limit, $parent_id, $game_id, $package_name, $channel_id, $create_user, $date);
            foreach ($info['list'] as &$v) {
                $v['parent_name'] = $games[$v['parent_id']]['name'];
            }
        }
        return $info;
    }

    public function costUploadEdit($field = '', $value = 0, $data = [])
    {
        $key = array('cost_yuan', 'display', 'click');
        if (!in_array($field, $key)) {
            return array('state' => false, 'msg' => '参数错误');
        }
        if ($field == 'cost_yuan') {
            $field = 'cost';
            $value = $value * 100; //单位：分
        }

        $ret = $this->mod->costUploadEdit($field, $value, $data);
        if ($ret) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    public function costUploadDel($id = '')
    {
        if (!$id) {
            return array('state' => false, 'msg' => '请选择要删除的记录');
        }

        $result = $this->mod->costUploadDel($id);
        if ($result) {
            return array('state' => true, 'msg' => '删除成功');
        } else {
            return array('state' => false, 'msg' => '删除失败');
        }
    }

    /**
     * 更新链接缓存
     * @param int $monitor_id
     * @return array
     */
    public function clearCacheLink($monitor_id = 0)
    {
        $info = $this->mod->getAllLink($monitor_id);
        foreach ($info as &$row) {
            if ($row['domain']) {
                if (substr($row['domain'], -1) != '/') {
                    $row['domain'] .= '/';
                }
                $row['jump_url'] = $row['domain'] . $row['page_url'] . '/index.html';
            }

            if ($row['device_type'] == PLATFORM['ios']) {
                $row['down_url'] = APPSTORE_URL . $row['down_url'];
            }

            //监测地址缓存
            if ($row['monitor_url']) {
                $cache = array(
                    'monitor_id' => $row['monitor_id'],
                    'game_id' => $row['game_id'],
                    'package_name' => $row['package_name'],
                    'device_type' => $row['device_type'],
                    'channel_short' => $row['channel_short'],
                    'jump_url' => $row['jump_url'], //落地页地址
                    'down_url' => $row['down_url'], //下载地址
                    'jump_model' => (int)$row['jump_model'],
                );
                LibRedis::set(strtoupper(LibRedis::$prefix_monitor_code . $row['monitor_url']), $cache);
            }

            //安卓游戏包信息缓存
            if ($row['package_name'] && $row['device_type'] == PLATFORM['android']) {
                $cache = array(
                    'monitor_id' => $row['monitor_id'],
                    'game_id' => $row['game_id'],
                    'channel_id' => $row['channel_id'],
                    'device_type' => $row['device_type']
                );
                LibRedis::set(strtoupper(LibRedis::$prefix_package_name . $row['package_name']), $cache);
            }
        }

        return array('state' => true);
    }

    /**
     * 根据游戏和渠道获取已使用的包名
     * @return array
     */
    public function getLinkPackageName()
    {
        $data = [];
        $arr = $this->mod->getAllLink();
        foreach ($arr as $row) {
            //IOS不做过滤
            if ($row['device_type'] == PLATFORM['ios']) {
                continue;
            }

            $data[$row['package_name']] = 1;
        }
        return $data;
    }

    public function linkDiscountList($param = [], $page = 1, $limit = 15)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $channel_id = (int)$param['channel_id'];
        $create_user = trim($param['create_user']);
        $keyword = trim($param['keyword']);

        $create_user == '' && $create_user = SrvAuth::$name;
        $create_user == 'all' && $create_user = '';

        $games = LibUtil::config('games');
        $info = $this->mod->getAdDiscountList($parent_id, $game_id, $channel_id, $create_user, $keyword, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['parent_name'] = $games[$row['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['discount_pay'] = round($row['discount_pay'], 2) . '%';
            $row['discount_reg'] = round($row['discount_reg'], 2) . '%';
        }
        return $info;
    }

    public function linkDiscountAdd($param = [])
    {
        $monitor_id = (int)$param['monitor_id'];
        $open_sdate = trim($param['open_sdate']);
        $open_edate = trim($param['open_edate']);
        $is_open = (int)$param['is_open'];
        $discount_pay = (float)$param['discount_pay'];
        $discount_reg = (float)$param['discount_reg'];
        $discount_sdate = trim($param['discount_sdate']);
        $discount_edate = trim($param['discount_edate']);
        $is_discount = (int)$param['is_discount'];

        if (!$monitor_id || !$open_sdate || !$open_edate) {
            return array('state' => false, 'msg' => '必填项不能为空');
        }

        //次日生效
        $update_text = json_encode(array(
            'discount_pay' => $discount_pay,
            'discount_reg' => $discount_reg,
            'discount_sdate' => $discount_sdate,
            'discount_edate' => $discount_edate,
            'is_discount' => $is_discount
        ));

        $insertData = array(
            'monitor_id' => $monitor_id,
            'open_sdate' => $open_sdate,
            'open_edate' => $open_edate,
            'is_open' => $is_open,
            'update_text' => $update_text
        );
        $updateData = array(
            'open_sdate' => $open_sdate,
            'open_edate' => $open_edate,
            'is_open' => $is_open,
            'update_text' => $update_text
        );

        $ret = $this->mod->insertOrUpdate($insertData, $updateData, LibTable::$ad_discount);
        if ($ret) {
            return array('state' => true, 'msg' => '保存成功，投放实时生效，扣量次日生效');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    public function getAdDiscount($monitor_id)
    {
        return $this->mod->getAdDiscount($monitor_id);
    }

    public function getAdDiscountAll()
    {
        $data = [];
        $info = $this->mod->getAdDiscountAll();
        foreach ($info as $row) {
            $data[$row['monitor_id']] = $row;
        }
        return $data;
    }

    public function getAsoDiscountAll()
    {
        $data = [];
        $info = $this->mod->getAdDiscountAll();
        foreach ($info as $row) {
            $data[$row['game_id']] = $row;
        }
        return $data;
    }

    public function linkDiscountDel($id = '')
    {
        if (!$id) {
            return array('state' => false, 'msg' => '请选择要删除的记录');
        }

        $result = $this->mod->linkDiscountDel($id);
        if ($result) {
            return array('state' => true, 'msg' => '删除成功');
        } else {
            return array('state' => false, 'msg' => '删除失败');
        }
    }

    /**
     * 获取分成比例
     * @param array $param
     * @param int $page
     * @param int $limit
     * @param int $upload
     * @return array
     */
    public function getSplitManage($param = array(), $page = 1, $limit = 15, $upload = 0)
    {
        $parent_id = isset($param['parent_id']) ? (int)$param['parent_id'] : 0;
        $game_id = (int)$param['game_id'];
        $channel_id = (int)$param['channel_id'];
        $month = trim($param['month']);

        $page = $page < 1 ? 1 : $page;
        $gamesConf = LibUtil::config('games');
        $games = (new SrvPlatform())->getAllGame(false);
        $info = array();
        if ($upload) {

        } else {
            $info = $this->mod->splitManageList($parent_id, $game_id, $channel_id, $month, $page, $limit);
            foreach ($info['list'] as &$row) {
                $parent_id = $gamesConf[$row['game_id']]['parent_id'];
                $row['parent_id'] = $parent_id;
                $row['parent_name'] = $games[$parent_id];
                $row['cp_split'] = round($row['cp_split'], 2) . "%";
                $row['channel_split'] = round($row['channel_split'], 2) . "%";
            }
        }
        return $info;
    }

    /**
     * 获取导出的相关信息
     * @param int $parent_id
     * @param int $game_id
     * @param int $channel_id
     * @param int $create_user //负责人
     * @return  array
     */
    public function splitManageExcel($parent_id = 0, $game_id = 0, $channel_id = 0, $create_user = 0)
    {
        $info = $this->mod->getLinkList(1, 0, $parent_id, $game_id, '', $channel_id, '', 0, $create_user);
        $gameConf = $games = LibUtil::config('games');
        $games = (new SrvPlatform())->getAllGame(false);
        $channels = (new SrvAd())->getAllChannel();
        $header = array(
            '推广ID（此列勿动）', '推广名称（此列勿动）', '游戏包名（此列勿动）', '母游戏（此列勿动）', '母游戏ID（此列勿动）', '子游戏（此列勿动）', '子游戏ID（此列勿动）', '渠道（此列勿动）', '渠道ID（此列勿动）', '研发分成比例（%）', '渠道分成比例（%）', '月份'
        );
        foreach ($info['list'] as $v) {
            $pid = $gameConf[$v['game_id']]['parent_id'];
            if (!$parent_id) continue;
            $data[] = array(
                $v['monitor_id'],
                $v['package_name'],
                $v['name'],
                $games[$pid],
                $pid,
                $games[$v['game_id']],
                $v['game_id'],
                $channels[$v['channel_id']],
                $v['channel_id'],
                '',
                '',
                ''
            );
        }
        return array(
            'header' => $header,
            'data' => $data,
        );
    }

    /**
     * 获取导出的相关信息
     * @param int $parent_id
     * @param int $game_id
     * @param int $channel_id
     * @param int $create_user //负责人
     * @return  array
     */

    public function splitUploadAction($file = '')
    {
        if (!$file) {
            return array('state' => false, 'msg' => '请先上传文件');
        }

        $_file = RUNTIME_DIR . '/tmp/' . $file;
        if (!is_file($_file)) {
            return array('state' => false, 'msg' => '上传文件已失效，请重新上传');
        }

        $c = $t = 0;
        $data = SrvPHPExcel::excel2array($_file);
        $modData = new ModData();
        foreach ($data as $v) {
            $t++;

            $date = $v[8];
            if (empty($date)) {
                continue;
            }

            if (preg_match('/^\d{1,2}\/\d{1,2}\/20\d\d/', $v[8])) {
                $_date = explode('/', $v[8]);
                $date = $_date[2] . '/' . $_date[0];
            }
            if (preg_match('/^20\d\d\/\d{1,2}\/\d{1,2}$/', $v[8])) {
                $_date = explode('/', $v[8]);
                $date = $_date[0] . "/" . $_date[1];
            }

            if (!$date) {
                unlink($_file);
                return array('state' => true, 'msg' => '日期格式不正确' . $v[8]);
            }
            $parent_name = trim($v[0]);
            $parent_id = (int)$v[1];
            $game_name = trim($v[2]);
            $game_id = (int)$v[3];
            $channel_id = isset($v[5]) ? (int)$v[5] : 0;

            if (empty($parent_name) || empty($parent_id) || empty($game_name) || empty($game_id)) {
                continue;
            }
            $cp_split = isset($v[6]) ? (strstr($v[6], '%') ? substr($v[6], 0, strlen($v[6] - 1)) : round($v[6], 2)) : 0;
            $channel_split = isset($v[7]) ? (strstr($v[7], '%') ? substr($v[7], 0, strlen($v[7] - 1)) : round($v[7], 2)) : 0;

            if ($cp_split > 100 || $channel_split > 100) {
                return array('state' => true, 'msg' => '分成比例错误，比例应大于等于0或小于等于100');
            }

            $modData->uploadSplitData($game_id, $channel_id, $date, $cp_split, $channel_split);
            $ret = $modData->affectedRows();
            if ($ret) {
                $c++;
            }
        }
        unlink($_file);
        return array('state' => true, 'msg' => "共上传 <b>{$t}</b> 条记录，成功录入（更新） <b>{$c}</b> 条记录");
    }

    public function splitUploadEdit($field = '', $value = 0, $data = [])
    {
        $key = array('cp_split', 'channel_split', 'month');
        if (!in_array($field, $key)) {
            return array('state' => false, 'msg' => '参数错误');
        }
        $data[$field] = $value;
        if (($data['cp_split'] + $data['channel_split']) > 100) {
            //return array('state'=>false,'msg'=>'参数错误');
        }
        $ret = $this->mod->splitUploadEdit($field, $value, $data);
        if ($ret) {
            return array('state' => true, 'msg' => '保存成功');
        } else {
            return array('state' => false, 'msg' => '保存失败');
        }
    }

    /**
     * 删除成本信息
     * @param $id
     * @return array
     */
    public function splitDel($id)
    {
        if (empty($id)) {
            return LibUtil::retData(false, array(), 'ID不能为空，删除失败');
        }
        $ret = $this->mod->splitDel($id);
        if ($ret) {
            return LibUtil::retData(true, array('id' => $id), '删除成功');
        }
        return LibUtil::retData(false, array(), '删除失败');
    }

    /**
     * ASO联运扣量添加
     * @param array $param
     * @return array
     */
    public function asoDiscountAdd($param = array())
    {
        if (empty($param)) {
            return LibUtil::retData(false, array(), '添加失败');
        }

        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];
        $open_sdate = trim($param['open_sdate']);
        $open_edate = trim($param['open_edate']);
        $is_open = (int)$param['is_open'];
        $discount_pay = (float)$param['discount_pay'];
        $discount_reg = (float)$param['discount_reg'];
        $discount_sdate = trim($param['discount_sdate']);
        $discount_edate = trim($param['discount_edate']);
        $is_discount = (int)$param['is_discount'];

        if ((empty($parent_id) && empty($game_id)) || empty($open_edate) || empty($open_sdate)) {
            return LibUtil::retData(false, array(), '保存失败！必选项不能为空');
        }

        //获取对应的game
        $gameIds = array();
        if (empty($game_id) && !empty($parent_id)) {
            $allGame = (new SrvPlatform())->getAllGame(true);
            $parentList = $allGame['parent'];
            $parentList = array_column($parentList, null, 'id');

            if (isset($parentList[$parent_id]) && !empty($parentList[$parent_id]['children'])
                && is_array($parentList[$parent_id]['children'])) {
                foreach ($parentList[$parent_id]['children'] as $row) {
                    if (empty($row['id'])) continue;
                    array_push($gameIds, $row['id']);
                }
            }
        } else {
            $gameIds = array($game_id);
        }

        if (empty($gameIds)) {
            return LibUtil::retData(false, array(), '保存失败！未获取到游戏信息，请勾选');
        }
        $retBack = array();
        foreach ($gameIds as $id) {
            //次日生效 扣量信息
            $update_text = array(
                'discount_pay' => $discount_pay,
                'discount_reg' => $discount_reg,
                'discount_sdate' => $discount_sdate,
                'discount_edate' => $discount_edate,
                'is_discount' => $is_discount
            );
            $update_text = json_encode($update_text);

            //当日生效 投放显示
            $insertData = array(
                'game_id' => (int)$id,
                'open_sdate' => $open_sdate,
                'open_edate' => $open_edate,
                'is_open' => $is_open,
                'update_text' => $update_text
            );
            $updateData = array(
                'open_sdate' => $open_sdate,
                'open_edate' => $open_edate,
                'is_open' => $is_open,
                'is_discount' => $is_discount,
                'update_text' => $update_text
            );

            $ret = $this->mod->insertOrUpdate($insertData, $updateData, LibTable::$aso_discount);
            if ($ret) {
                $retBack['suc'][] = $id;
            }
        }
        $retBack['fail'] = array_diff($retBack['suc'], $gameIds);
        return LibUtil::retData(true, $retBack, '保存成功，投放实时生效，扣量次日生效');
    }

    /**
     * 获取ASO扣量列表
     * @param array $param
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function asoDiscountList($param = array(), $page = 1, $limit = DEFAULT_ADMIN_PAGE_NUM)
    {
        $parent_id = (int)$param['parent_id'];
        $game_id = (int)$param['game_id'];

        $games = LibUtil::config('games');
        $info = $this->mod->getAsoDiscountList($parent_id, $game_id, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['parent_name'] = $games[$row['parent_id']]['name'];
            $row['game_name'] = $games[$row['game_id']]['name'];
            $row['discount_pay'] = round($row['discount_pay'], 2) . '%';
            $row['discount_reg'] = round($row['discount_reg'], 2) . '%';
        }
        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        LibUtil::clean_xss($sdate);
        LibUtil::clean_xss($edate);
        return $info;
    }

    /**
     * 编辑ASO扣量信息
     * @param int $game_id
     * @return array
     */
    public function getAsoDiscount($game_id)
    {
        $game_id = (int)$game_id;
        if (empty($game_id)) {
            return array();
        }

        $info = $this->mod->getAsoDiscountRow($game_id);
        $gameInfo = (new SrvPlatform())->getGameInfo($game_id);
        $info['parent_id'] = $gameInfo['parent_id'];
        return $info;
    }

    /**
     * 删除扣量配置
     * @param string $id
     * @return array
     */
    public function asoDiscountDel($id = '')
    {
        if (!$id) {
            return array('state' => false, 'msg' => '请选择要删除的记录');
        }
        $result = $this->mod->asoDiscountDel($id);
        if ($result) {
            return array('state' => true, 'msg' => '删除成功');
        } else {
            return array('state' => false, 'msg' => '删除失败');
        }
    }

    /**
     * 根据推广链ID获取点击广告信息
     * @param string $keyword
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function clickAd($keyword = '', $page = 1, $limit = 10)
    {
        $ip = new LibIp();
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->getClickAdList($keyword, $page, $limit);
        foreach ($info['list'] as &$row) {
            $row['device_id'] = $row['device_id'] ? $row['device_id'] : $row['sum_device_id'];

            if ($row['click_ip']) {
                $r = $ip->getlocation($row['click_ip']);
                $row['area'] = $r['country'] . ' ' . $r['isp'];
            }
        }

        return $info;
    }

    /**
     * 手动上报广告回调
     * @param string $type
     * @param int $id
     * @return array
     */
    public function clickAdUpload($type = '', $id = 0)
    {
        if (!$type || !$id) {
            return LibUtil::retData(false, array(), '参数不全');
        }

        $info = $this->mod->getClickAdInfo($id);
        if (empty($info)) {
            return LibUtil::retData(false, array(), '记录不存在');
        }

        $ext = json_decode($info['ext'], true);
        $monitor['ext'] = $ext;
        $monitor['monitor_id'] = $info['monitor_id'];

        $ip = $info['click_ip'];
        $time = time();
        $uid = rand(100000, 999999);
        $money_arr = array(10, 20, 30, 50, 100);
        $money = $money_arr[array_rand($money_arr)] * 100;
        $pay_data = array(
            'order_id' => LibUtil::makeOrderNum() . rand(1000, 9999),
            'uid' => $uid,
            'money' => $money, //单位：分
            'pay_time' => $time,
            'game_id' => 10000,
            'device_type' => 2,
            'reg_game_id' => 10000,
            'reg_device_type' => 2,
            'reg_time' => $time,
        );

        $ret = '';
        switch ($type) {
            case 'active':
                $ret = YX::call('/monitor/adUpload/' . $ext['callback'] . 'Upload', $monitor, $time, $ip);
                break;
            case 'reg':
                $ret = YX::call('/monitor/adUpload/' . $ext['callback'] . 'RegUpload', $monitor, $time, $ip, $uid);
                break;
            case 'pay':
                $ret = YX::call('/monitor/adUpload/' . $ext['callback'] . 'PayUpload', $monitor, $pay_data);
                break;
        }

        return LibUtil::retData(true, array('result' => $ret), '上报成功');
    }
}