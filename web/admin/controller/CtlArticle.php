<?php

/**
 * Created by PhpStorm.
 * User: qinsh
 * Date: 2018/3/26 0026
 * Time: 15:14
 */
class CtlArticle extends Controller
{

    private $srv;

    public function __construct()
    {
        $this->srv = new SrvArticle();

        $this->out['__domain__'] = ROOT_DOMAIN;
    }

    /**
     * 文章管理
     */
    public function article()
    {
        SrvAuth::checkOpen('article', 'article');

        $this->outType = 'smarty';
        $page = $this->R('page', 'int', 1);
        $parent_id = (int)$this->R('parent_id', 'int', 0);
        $children_id = (int)$this->R('children_id', 'int', 0);
        $type = $this->R('type', 'int', 0);
        $title = $this->R('title');

        $game_id = $children_id > 0 ? $children_id : ($parent_id > 0 ? $parent_id : 0);
        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $parent_id, //默认值
                'default_text' => '选择母游戏', //默认显示内容
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_default_value' => $children_id, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
            ),
        );

        $this->out['data'] = $this->srv->getArticleList($page, $title, $type, $game_id);
        $this->out['widgets'] = $widgets;
        $this->out['_games'] = $games['list'];
        $this->out['__on_menu__'] = 'article';
        $this->out['__on_sub_menu__'] = 'article';
        $this->out['__title__'] = '文章管理';
        $this->tpl = 'article/article.tpl';
    }

    /**
     * 添加文章
     */
    public function articleAdd()
    {
        SrvAuth::checkOpen('article', 'article');

        $this->outType = 'smarty';

        $id = $this->R('id', 'int', 0);
        if ($id > 0) {
            $data = $this->srv->getArticleInfo($id);
        } else {
            $data['aid'] = $id;
            $data['type'] = 1;
        }

        $parent_id = 0;
        $game_id = 0;
        if ($data['game_id'] > 0) {
            $_games = LibUtil::config('games');
            $pid = (int)$_games[$data['game_id']]['parent_id'];
            if ($pid > 0) {
                $parent_id = &$pid;
                $game_id = (int)$data['game_id'];
            } else {
                $parent_id = (int)$data['game_id'];
            }
        }

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => $parent_id, //默认值
                'default_text' => '选择母游戏', //默认显示内容
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_default_value' => $game_id, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
                'children_attr' => 'style="width: 200px"',
                'attr' => 'style="width: 150px"' //标签属性参数
            ),
        );

        $this->out['data'] = $data;
        $this->out['widgets'] = $widgets;
        $this->out['_static_url_'] = str_ireplace('https://', 'http://', CDN_STATIC_URL);
        $this->out['__on_menu__'] = 'article';
        $this->out['__on_sub_menu__'] = 'article';
        $this->out['__title__'] = '添加文章';
        $this->tpl = 'article/article_add.tpl';
    }

    /**
     * 保存文章
     */
    public function articleAddAction()
    {
        SrvAuth::checkOpen('article', 'article');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $id = $this->post('id', 'int', 0);
        $parent_id = (int)$this->post('parent_id', 'int', 0);
        $children_id = (int)$this->post('children_id', 'int', 0);
        $game_id = $children_id > 0 ? $children_id : ($parent_id > 0 ? $parent_id : 0);
        $data = array(
            'title' => trim($this->post('title')),
            'shorttitle' => trim($this->post('shorttitle')),
            'color' => trim($this->post('color')),
            'isjump' => (int)$this->post('isjump', 'int', 0),
            'isstrong' => (int)$this->post('isstrong', 'int', 0),
            'redirecturl' => trim($this->post('redirecturl')),
            'htmlurl' => '',
            'type' => (int)$this->post('type', 'int', 1),
            'author' => trim($this->post('author')),
            'source' => trim($this->post('source')),
            'game_id' => $game_id,
            'description' => $this->post('description'),
            'content' => $this->post('content')
        );

        $arr = $this->srv->articleAddAction($id, $data);
        if ($arr['state']) {
            //生成HTML
            $id = $id > 0 ? $id : $arr['data']['id'];
            $this->articleHtml($id);
        }

        $this->outType = 'json';
        $this->out = $arr;
    }

    /**
     * 预览
     */
    public function articlePreview()
    {
        SrvAuth::checkOpen('article', 'article');

        $this->outType = 'smarty';

        $id = $this->R('id', 'int', 0);
        if ($id <= 0) {
            exit('参数错误');
        }

        $data = $this->srv->getArticleInfo($id);
        if ($data['isjump'] && $data['redirecturl']) {
            header("Location: {$data['redirecturl']}");
            exit();
        }

        $data['addtime'] = $data['addtime'] ? date('Y-m-d H:i', $data['addtime']) : '-';
        $this->out['data'] = $data;
        $this->tpl = 'article/article_html.tpl';
    }

    /**
     * 生成文章HTML页面
     * @param int $id
     * @return array|bool
     * @throws SmartyException
     */
    public function articleHtml($id = 0)
    {
        if ($id <= 0) {
            return false;
        }

        $this->outType = 'none';
        $data = $this->srv->getArticleInfo($id);
        if (empty($data)) {
            return false;
        }

        $date = $data['addtime'] > 0 ? date('Ym', $data['addtime']) : date('Ym');
        $path = 'article/' . $date . '/';
        $filepath = CDN_STATIC_DIR . '/' . $path;
        if (!is_dir($filepath)) {
            mkdir($filepath, 0775, true);
        }

        $filename = $filepath . $id . '.html';
        $url = CDN_STATIC_URL . $path . $id . '.html';

        //跳转
        if ($data['isjump']) {
            unlink($filename);
            return true;
        }

        $data['addtime'] = $data['addtime'] ? date('Y-m-d H:i', $data['addtime']) : '-';
        $this->out['data'] = $data;
        $temp = $this->view('article/article_html.tpl', true);

        $ret = file_put_contents($filename, $temp);
        if (!$ret) {
            return false;
        }

        return $this->srv->articleAddAction($id, array('htmlurl' => $url));
    }

    /**
     * 生成文章HTML
     */
    public function articleHtmlAction()
    {
        $id = $this->R('id', 'int', 0);
        if ($id <= 0) {
            LibUtil::response('参数错误');
        }
        $ret = $this->articleHtml($id);
        if ($ret) {
            LibUtil::response('生成成功', 1);
        } else {
            LibUtil::response('生成失败');
        }
    }

    /**
     * 删除文章
     */
    public function articleDel()
    {
        $this->outType = 'none';

        $id = $this->R('id', 'int', 0);
        $this->srv->articleDel($id);
    }

    /**
     * 推送消息
     */
    public function articlePush()
    {
        $this->outType = 'json';

        $id = $this->R('id', 'int', 0);
        $this->out = $this->srv->articlePush($id);
    }

    /**
     * 快速发布公告
     */
    public function articleNotice()
    {
        SrvAuth::checkOpen('article', 'article');

        $this->outType = 'smarty';

        $srvPlatform = new SrvPlatform();
        $games = $srvPlatform->getAllGame(true);
        $widgets = array(
            'game' => array(
                'id' => 'parent_id', //自定义ID
                'type' => 'game', //插件类型
                'data' => $games, //游戏数据树
                'default_value' => 0, //默认值
                'default_text' => '选择母游戏', //默认显示内容
                'disabled' => false, //是否不可选
                'parent' => true, //是否开启只可选择父游戏
                'children' => true, //是否开启子游戏选择
                'children_default_value' => 0, //子游戏默认值
                'children_default_text' => '选择子游戏', //子游戏默认显示内容
                'children_inherit' => false, //过滤继承的游戏
                'children_attr' => 'style="width: 200px"',
                'attr' => 'style="width: 150px"' //标签属性参数
            ),
        );

        $this->out['widgets'] = $widgets;
        $this->out['_static_url_'] = str_ireplace('https://', 'http://', CDN_STATIC_URL);
        $this->out['__title__'] = '快速发布公告';
        $this->tpl = 'article/article_notice.tpl';
    }

    /**
     * 保存快速公告
     */
    public function articleNoticeAction()
    {
        SrvAuth::checkOpen('article', 'article');

        $this->outType = 'json';
        $data = $this->post('data');
        parse_str($data, $_POST);
        $parent_id = (int)$this->post('parent_id', 'int', 0);
        $children_id = (int)$this->post('children_id', 'int', 0);
        $game_id = $children_id > 0 ? $children_id : ($parent_id > 0 ? $parent_id : 0);
        $data = array(
            'title' => $this->post('title'),
            'type' => 1,
            'author' => 'admin',
            'game_id' => $game_id,
            'content' => $this->post('content')
        );

        $arr = $this->srv->articleAddAction(0, $data);
        if ($arr['state']) {
            $id = $arr['data']['id'];

            //生成HTML
            $this->articleHtml($id);

            //推送
            $this->outType = 'none';
            $this->srv->articlePush($id);
        }

        $this->outType = 'json';
        $this->out = $arr;
    }
}