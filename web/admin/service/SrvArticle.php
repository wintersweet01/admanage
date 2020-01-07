<?php

require_once LIB . '/library/GatewayClient/Gateway.php';

use GatewayClient\Gateway;

/**
 * Created by PhpStorm.
 * User: qinsh
 * Date: 2018/3/26 0026
 * Time: 15:14
 */
class SrvArticle
{

    private $mod;

    public function __construct()
    {
        $this->mod = new ModArticle();
    }

    public function getArticleList($page = 1, $title = '', $type = 0, $game_id = 0)
    {
        $page = $page < 1 ? 1 : $page;

        $info = $this->mod->getArticleList($page, $title, $type, $game_id);
        foreach ($info['list'] as &$row) {
            $row['addtime'] = $row['addtime'] ? date('Y-m-d H:i:s', $row['addtime']) : '-';

            switch ($row['type']) {
                case 1:
                    $row['type'] = '公告';
                    break;
                case 2:
                    $row['type'] = '常见问题';
                    break;
                default:
                    $row['type'] = '未指定';
                    break;
            }

            $postfix = '';
            if ($row['isjump']) {
                $postfix .= '跳 ';
            }
            if ($row['isstrong']) {
                $postfix .= '粗 ';
            }
            if ($row['ispush']) {
                $postfix .= '推 ';
            }
            $row['postfix'] = $postfix != '' ? '[<font color="#ff0000">' . substr($postfix, 0, -1) . '</font>]' : '';
        }

        $info['page_html'] = LibPage::page(LibUtil::getRequestUrlNoXss(), $info['total']['c'], $page, DEFAULT_ADMIN_PAGE_NUM);
        $info['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        $info['game_id'] = $game_id;
        $info['type'] = $type;
        LibUtil::clean_xss($title);
        $info['title'] = $title;

        return $info;
    }

    public function getArticleInfo($id)
    {
        if ($id <= 0) {
            return array();
        }
        return $this->mod->getArticleInfo($id);
    }

    public function articleAddAction($id, $data)
    {
        $data['administrator'] = SrvAuth::$name;
        if ($id > 0) {
            $result = $this->mod->updateArticle($id, $data);
        } else {
            $text = preg_replace('/<[^>]+>/', '', $data['content']);
            if (!$data['title']) {
                return LibUtil::retData(false, [], '请添加正文标题');
            }
            if (!$data['isjump'] && !$text) {
                return LibUtil::retData(false, [], '请添加内容');
            }

            $data['addtime'] = time();
            $id = $this->mod->addArticle($data);
            $result = true;
        }

        if ($result) {
            return LibUtil::retData(true, array('id' => $id), '保存成功');
        } else {
            return LibUtil::retData(false, [], '保存失败');
        }
    }

    public function articleDel($id)
    {
        if ($id <= 0) {
            LibUtil::response('参数错误');
        }

        $data = $this->getArticleInfo($id);
        if (empty($data)) {
            LibUtil::response('文章不存在');
        }

        $result = $this->mod->articleDel($id);
        if ($result) {
            $date = $data['addtime'] > 0 ? date('Ym', $data['addtime']) : date('Ym');
            $filename = CDN_STATIC_DIR . '/article/' . $date . '/' . $id . '.html';
            unlink($filename);

            LibUtil::response('删除成功', 1);
        } else {
            LibUtil::response('删除失败');
        }
    }

    public function articlePush($id)
    {
        if ($id <= 0) {
            return LibUtil::retData(false, [], '参数错误');
        }

        $data = $this->getArticleInfo($id);
        if (empty($data)) {
            return LibUtil::retData(false, [], '文章不存在');
        }

        if ($data['isjump']) {
            return LibUtil::retData(false, [], '该文章属于跳转类，不能推送');
        }

        $ip = LibUtil::getIp();
        if ($ip == '127.0.0.1') {
            return LibUtil::retData(false, [], '当前为本地测试，不能推送');
        }

        $result = $this->mod->updateArticle($id, array('ispush' => 1));
        if (!$result) {
            return LibUtil::retData(false, [], '推送失败');
        }

        $gids = array();
        if ($data['game_id'] > 0) {
            $games = LibUtil::config('games');
            if ($games[$data['game_id']]['parent_id'] > 0) { //指定子游戏
                $gids[] = 'game' . $data['game_id'];
            } else { //只指定母游戏
                foreach ($games as $v) {
                    if ($v['parent_id'] == $data['game_id']) {
                        $gids[] = 'game' . $v['game_id'];
                    }
                }
            }
        }

        $json = json_encode(array(
            'type' => 'notice',
            'code' => 1,
            'message' => '',
            'data' => array(
                'id' => $data['aid'],
                'title' => $data['title'],
                'content' => $data['content']
            )
        ));

        //连接创玩SDK注册端口
        Gateway::$registerAddress = '127.0.0.1:1238';

        if (!empty($gids)) {
            Gateway::sendToGroup($gids, $json);
        } else {
            // 向所有人发送
            Gateway::sendToAll($json);
        }

        return LibUtil::retData(true, [], '推送成功， 在线玩家即可收到提示');
    }
}