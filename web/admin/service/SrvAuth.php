<?php

define("COOKIE_ADMIN_DOMAIN", $_SERVER['SERVER_NAME']);

class SrvAuth
{

    public static $ADMIN_LOGIN_KEY = 'Hxdv34^#$vn@bKdb65';
    public static $public_auth = '';
    public static $menu = '';
    public static $name = '';
    public static $cname = '';
    public static $id = '';
    public static $info = null;
    public static $auth_parent_id = '', $auth_game_id = '', $auth_channel_id = '', $auth_user_id = '';

    /**
     * 检查是否登录
     * @return bool
     */
    public static function checkLogin()
    {
        self::$menu = $_SESSION['role_menu'];
        self::$public_auth = $_SESSION['role_fun'];
        self::$name = $_SESSION['username'];
        self::$cname = $_SESSION['usercname'];
        self::$id = $_SESSION['userid'];
        self::$auth_parent_id = $_SESSION['auth_parent_id'];
        self::$auth_game_id = $_SESSION['auth_game_id'];
        self::$auth_channel_id = $_SESSION['auth_channel_id'];
        self::$auth_user_id = $_SESSION['auth_user_id'];

        if ($_SESSION['username']) {
            return true;
        }

        self::logout();
        return false;
    }

    /**
     * 登录
     * @param $name
     * @param $password
     * @param $captcha
     * @param $keep
     * @return bool|string
     */
    public function login($name, $password, $captcha, $keep)
    {
        if (!$name || !$password) {
            return '请填写完整';
        }

        if (!$this->isCaptchaRight($captcha)) {
            return '验证码错误';
        }

        $modAuth = new ModAuth();
        $info = $modAuth->getLoginInfo($name);
        if (empty($info)) {
            self::setNeedCaptcha();
            return '用户名或密码错误';
        }

        if ($info['state'] == 1) {
            return '该用户已被禁止登录';
        }

        if (self::signPwd($name, $password, $info['salt']) !== strtolower($info['pwd'])) {
            self::setNeedCaptcha();
            return '用户名或密码错误';
        }

        $modAuth->updateLoginInfo($name);

        //设置登录状态
        self::set_cookie($info, $keep);

        return true;
    }

    /**
     * 密码加盐
     * @param $name
     * @param $password
     * @param $salt
     * @return string
     */
    public static function signPwd($name, $password, $salt)
    {
        return strtolower(md5($password . $name . $salt . $password . SET_PWD_KEY));
    }

    /**
     * 退出登录
     */
    public static function logout()
    {
        if (!$_COOKIE['ht_keep']) {
            setcookie('ht_name', '', 0, '/', COOKIE_ADMIN_DOMAIN);
            setcookie('ht_keep', 0, 0, '/', COOKIE_ADMIN_DOMAIN);
        }

        self::$public_auth = '';
        self::$name = '';
        self::$menu = '';
        self::$id = '';
        self::$auth_parent_id = '';
        self::$auth_game_id = '';
        self::$auth_channel_id = '';
        self::$auth_user_id = '';

        session_unset();
        session_destroy();
    }

    /**
     * 设置cookie
     * @param $user
     * @param $keep
     */
    public static function set_cookie($user, $keep = 0)
    {
        $time = 0;
        if ($keep) {
            $time = time() + 15 * 86400;
        }

        $user['admin_id'] && $_SESSION['userid'] = $user['admin_id'];
        $user['user'] && $_SESSION['username'] = $user['user'];
        $user['name'] && $_SESSION['usercname'] = $user['name'];
        $user['role_menu'] && $_SESSION['role_menu'] = $user['role_menu'];
        $user['role_fun'] && $_SESSION['role_fun'] = $user['role_fun'];
        $user['auth_parent_id'] && $_SESSION['auth_parent_id'] = $user['auth_parent_id'];
        $user['auth_game_id'] && $_SESSION['auth_game_id'] = $user['auth_game_id'];
        $user['auth_channel_id'] && $_SESSION['auth_channel_id'] = $user['auth_channel_id'];
        $user['auth_user_id'] && $_SESSION['auth_user_id'] = $user['auth_user_id'];

        setcookie('ht_name', $user['user'], $time, '/', COOKIE_ADMIN_DOMAIN);
        setcookie('ht_keep', $keep, $time, '/', COOKIE_ADMIN_DOMAIN);
    }

    /**
     * COOKIE加盐
     * @param $name
     * @param $utime
     * @param $menu
     * @param $id
     * @param $public_auth
     * @return string
     */
    public static function getCookieSign($name, $utime, $menu, $id, $public_auth)
    {
        return md5($name . self::$ADMIN_LOGIN_KEY . $utime . $menu . $id, $public_auth);
    }

    /**
     * 获取cookie值
     * @param $cookie_name
     * @param bool|true $safe
     * @return bool|string
     */
    public static function get_cookie($cookie_name, $safe = true)
    {
        $value = $_COOKIE[$cookie_name];
        if ($value) {
            if ($safe) {
                LibUtil::clean_xss($value);
            }
            return $value;
        }
        return '';
    }

    /**
     * 设置需要验证码
     */
    public static function setNeedCaptcha()
    {
        $captchaKey = 'NeedCaptcha' . LibUtil::getIp();
        $c = LibMemcache::get($captchaKey);
        $t = $c + 1;
        LibMemcache::set($captchaKey, $t);
        return $t;
    }

    /**
     * 删除是否需要验证码
     */
    public static function delNeedCaptcha()
    {
        LibMemcache::delete('NeedCaptcha' . LibUtil::getIp());
    }

    /**
     * 判断是否需要验证码
     * @return array|string
     */
    public static function isNeedCaptcha()
    {
        $result = false;
        $c = LibMemcache::get('NeedCaptcha' . LibUtil::getIp());
        //累计输入错误大于3次就需要验证码
        if ($c > 3) {
            $result = true;
        }
        return $result;
    }

    /**
     * 检验验证码
     * @param $captcha
     * @return bool
     */
    public function isCaptchaRight($captcha)
    {
        //不需要验证码
        if (!self::isNeedCaptcha()) {
            return true;
        }

        $key = 'Captcha' . LibUtil::getIp();
        $verify = LibMemcache::get($key);
        LibMemcache::delete($key);
        if ($verify != $captcha) {
            return false;
        }
        self::delNeedCaptcha();

        return true;
    }

    /**
     * 获取导航
     * @return array
     */
    public static function getMenu()
    {
        $open = explode('|', $_SESSION['role_menu']);
        $all_menu = LibUtil::config('ConfMenu');
        $first_menu_conf = LibUtil::config('ConfFirstMenu');
        $retData = array();
        $retData['first_menu_conf'] = $first_menu_conf;
        //超级管理员
        if ($_SESSION['userid'] == 1) {
            $first_menu = array('*');
            $retData['first_menu'] = $first_menu;
            $retData['menu'] = $all_menu;
            return $retData;
        }

        $menu = array();
        $dd = array();
        $first_menu = array();
        foreach ($open as $val) {
            $m = explode('-', $val);
            $dd[$m[0]][] = $m[1];
            $menu[$m[0]] = $all_menu[$m[0]];
            array_push($first_menu, $all_menu[$m[0]]['first_menu']);
        }
        foreach ($menu as $k => &$v) {
            foreach ($v['menu'] as $kk => &$vv) {
                if (!in_array($kk, $dd[$k])) {
                    unset($v['menu'][$kk]);
                }
            }
        }
        $first_menu = array_unique(array_filter($first_menu));
        $retData['menu'] = $menu;
        $retData['first_menu'] = $first_menu;
        return $retData;
    }

    /**
     * 检验是否有菜单权限
     * @param $ct
     * @param $ac
     * @return bool
     */
    public static function checkOpen($ct, $ac)
    {
        //超级管理员
        if ($_SESSION['userid'] == 1) {
            return true;
        }

        $ignore = array(
            '', 'base', 'attachment'
        );
        if (in_array($ct, $ignore)) return true;

        $menu = explode('|', $_SESSION['role_menu']);
        foreach ($menu as $m) {
            if (is_array($ac)) {
                foreach ($ac as $v) {
                    $_m = $ct . '-' . $v;
                    if ($m == $_m) {
                        return true;
                    }
                }
            } else {
                $_m = $ct . '-' . $ac;
                if ($m == $_m) {
                    return true;
                }
            }
        }

        exit('no auth!');
    }

    /**
     * 检查是否有公共权限
     * @param $type
     * @param bool $exit
     * @return bool
     */
    public static function checkPublicAuth($type, $exit = true)
    {
        //超级管理员
        if ($_SESSION['userid'] == 1) {
            return true;
        }

        $auth = explode('|', $_SESSION['role_fun']);
        $_type = explode(',', $type);
        foreach ($_type as $_t) {
            if (in_array($_t, $auth)) {
                return true;
            }
        }

        if ($exit) {
            exit('no auth!');
        } else {
            return false;
        }
    }

    /**
     * 根据游戏、渠道投放账号权限返回SQL形式字符串
     * @param string $parent_id
     * @param string $game_id
     * @param string $channel_id
     * @param string $user_id
     * @return string
     */
    public static function getAuthSql($parent_id = 'parent_id', $game_id = 'game_id', $channel_id = 'channel_id', $user_id = 'user_id')
    {
        //超级管理员不检查
        if (SrvAuth::$id == 1) {
            return '';
        }

        $games = LibUtil::config('games');
        $channel_user = LibUtil::config('channel_user');
        $condition = '';

        //母游戏和子游戏权限
        if ($parent_id && self::$auth_parent_id) {
            $arr_parent_id = explode(',', self::$auth_parent_id);
            $arr_game_id = $parent = [];
            if ($game_id && self::$auth_game_id) {
                $arr_game_id = explode(',', self::$auth_game_id);
                foreach ($arr_game_id as $key => $gid) {
                    $pid = (int)$games[$gid]['parent_id'];

                    //已有母游戏权限，其所有子游戏都有权限
                    if ($gid <= 0 || in_array($pid, $arr_parent_id)) {
                        unset($arr_game_id[$key]);
                        continue;
                    }

                    $parent[$pid] = $pid;
                }
            }

            if (empty($arr_game_id)) {
                $condition .= " AND {$parent_id} IN(" . self::$auth_parent_id . ")";
            } else {
                $condition .= " AND ({$parent_id} IN(" . self::$auth_parent_id . ") OR {$game_id} IN(" . implode(',', array_merge($arr_game_id, $parent)) . "))";
            }
        } elseif ($game_id && self::$auth_game_id) {
            $parent = [];
            $arr_game_id = explode(',', self::$auth_game_id);
            foreach ($arr_game_id as $key => $gid) {
                $pid = (int)$games[$gid]['parent_id'];

                $parent[$pid] = $pid;
            }

            $condition .= " AND {$game_id} IN(" . implode(',', array_merge($arr_game_id, $parent)) . ")";
        }

        //渠道和投放账号权限
        if ($channel_id && self::$auth_channel_id) {
            $arr_channel_id = explode(',', self::$auth_channel_id);
            $arr_user_id = [];
            if ($user_id && self::$auth_user_id) {
                $arr_user_id = explode(',', self::$auth_user_id);
                foreach ($arr_user_id as $key => $uid) {
                    //已有渠道选择，其所有投放账号都有权限
                    if ($uid <= 0 || in_array($channel_user[$uid]['channel_id'], $arr_channel_id)) {
                        unset($arr_user_id[$key]);
                    }
                }
            }

            if (empty($arr_user_id)) {
                $condition .= " AND {$channel_id} IN(" . self::$auth_channel_id . ")";
            } else {
                $condition .= " AND ({$channel_id} IN(" . self::$auth_channel_id . ") OR {$user_id} IN(" . implode(',', $arr_user_id) . "))";
            }
        } elseif ($user_id && self::$auth_user_id) {
            $condition .= " AND {$user_id} IN(" . self::$auth_user_id . ")";
        }

        return $condition;
    }

    /**
     * @param string $field
     * @return string
     */
    public static function getKfSql($field = '')
    {
        //管理员和客服主管可以看见所有客服的消息
        //|| SrvAuth::$kf_admin
        $authPub = explode("|", self::$public_auth);
        if (SrvAuth::$id == 1 || in_array(SrvAuth::$name, KF_ADMIN) || in_array('kfvip', $authPub)) {
            return '';
        }
        $ret = " AND {$field} = " . SrvAuth::$id;
        return $ret;
    }

    /**
     * 根据权限返回渠道ID
     * @return array
     */
    public static function getAuthChannel()
    {
        $channel_user = LibUtil::config('channel_user');
        $channel = [];

        if (self::$auth_channel_id) {
            $arr_channel_id = explode(',', self::$auth_channel_id);
            foreach ($arr_channel_id as $cid) {
                if ($cid <= 0) continue;
                $channel[$cid] = (int)$cid;
            }
        }

        if (self::$auth_user_id) {
            $arr_user_id = explode(',', self::$auth_user_id);
            foreach ($arr_user_id as $uid) {
                $cid = $channel_user[$uid]['channel_id'];
                if ($cid <= 0) continue;
                $channel[$cid] = (int)$cid;
            }
        }

        return $channel;
    }

    /**回用户组
     * 根据权限返
     * @return array
     */
    public static function getAuthChannelGroup()
    {
        $channel_user = LibUtil::config('channel_user');
        $groups = [];

        foreach ($channel_user as $row) {
            if (self::$auth_channel_id) {
                $arr_channel_id = explode(',', self::$auth_channel_id);
                if (in_array($row['channel_id'], $arr_channel_id)) {
                    $groups[$row['group_id']] = (int)$row['group_id'];
                }
            }

            if (self::$auth_user_id) {
                $arr_user_id = explode(',', self::$auth_user_id);
                if (in_array($row['user_id'], $arr_user_id)) {
                    $groups[$row['group_id']] = (int)$row['group_id'];
                }
            }
        }

        return $groups;
    }

    /**
     * 增加权限
     * @param int $parent_id
     * @param int $game_id
     * @param int $channel_id
     * @param int $user_id
     * @return bool|int
     */
    public static function addAuth($parent_id = 0, $game_id = 0, $channel_id = 0, $user_id = 0)
    {
        $id = $_SESSION['userid'];
        if (!$id) return false;

        $data = [];

        //没有游戏所有权限的时候才添加
        if ($_SESSION['auth_parent_id'] || $_SESSION['auth_game_id']) {
            if ($parent_id > 0) {
                $data['auth_parent_id'] = $_SESSION['auth_parent_id'] ? $_SESSION['auth_parent_id'] . ',' . $parent_id : $parent_id;
                $_SESSION['auth_parent_id'] = $data['auth_parent_id'];
            }
            if ($game_id > 0) {
                $data['auth_game_id'] = $_SESSION['auth_game_id'] ? $_SESSION['auth_game_id'] . ',' . $game_id : $game_id;
                $_SESSION['auth_game_id'] = $data['auth_game_id'];
            }
        }

        //没有渠道和账号所有权限的时候才添加
        if ($_SESSION['auth_channel_id'] || $_SESSION['auth_user_id']) {
            if ($channel_id > 0) {
                $data['auth_channel_id'] = $_SESSION['auth_channel_id'] ? $_SESSION['auth_channel_id'] . ',' . $channel_id : $channel_id;
                $_SESSION['auth_channel_id'] = $data['auth_channel_id'];
            }
            if ($user_id > 0) {
                $data['auth_user_id'] = $_SESSION['auth_user_id'] ? $_SESSION['auth_user_id'] . ',' . $user_id : $user_id;
                $_SESSION['auth_user_id'] = $data['auth_user_id'];
            }
        }

        $ret = true;
        if (!empty($data)) {
            $modAuth = new ModAuth();
            $ret = $modAuth->updateAdminInfo($id, $data);
        }

        return $ret;
    }

    /**
     * 获取后台所有管理员
     * @param boolean $notAuth
     * @return array
     */
    public static function allAuth($notAuth = false)
    {
        $modAuth = new ModAuth();
        $row = $modAuth->getAll();
        $row = array_column($row, null, 'admin_id');
        if ($notAuth) {
            unset($row[1]);
        }
        return $row;
    }
}