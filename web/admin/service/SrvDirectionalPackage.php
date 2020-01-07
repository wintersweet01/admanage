<?php


class SrvDirectionalPackage
{
    protected $mod;

    public function __construct()
    {
        $this->mod = new ModDirectionalPackage();
    }

    public function getDirectionalPackage($page)
    {
        $page = $page < 1 ?: 1;
        $result = $this->mod->getDirectionalPackage($page);
        $result['page_num'] = DEFAULT_ADMIN_PAGE_NUM;
        return ['state' => 1, 'msg' => '操作成功', 'data' => $result];

    }

    /**
     * 添加定向包
     * @param array $data
     * @return array
     */
    public function addDirectionalPackage(array $data)
    {
        if (empty($data))
            return ['state' => 0, 'msg' => '参数错误'];
        if (empty($data['delivery_range'])) // 投放位置
            return ['state' => 0, 'msg' => '投放范围为必填参数'];
        if ($data['delivery_range'] == 'UNION' && empty($data['union_video_type'])) // 投放形式
            return ['state' => 0, 'msg' => '投放范围选择穿山甲时，投放形式必填'];
        if ($data['district'] == 'CITY' && empty($data['city'])) // 所选城市id数组
            return ['state' => 0, 'msg' => '地域类型为城市时必填'];
        if ($data['district'] == 'BUSINESS_DISTRICT' && empty($data['business_ids'])) // 所选商圈id数组
            return ['state' => 0, 'msg' => '地域类型为商圈时，商圈ID数组必填'];
        if (!empty($data['launch_price']) && list($_minP, $_maxP) = $data['launch_price']) {
            if ($_minP < 0)
                return ['state' => 0, 'msg' => '手机价格不能低于0元'];
            if ($_maxP > 11000)
                return ['state' => 0, 'msg' => '手机价格不能高于11000元'];
        }
        if (!is_numeric($data['budget']) || $data['budget'] < 300)
            return ['state' => 0, 'msg' => '广告最低预算为300元'];
        $param ['package_name'] = $data['package_name'];
        unset($data['package_name']);
        $param['content'] = json_encode($data);
        $param['create_time'] = $param['update_time'] = date('Y-m-d H:i:s');
        $result = $this->mod->addPackage($param);
        return $result ? ['state' => 1, 'msg' => '添加成功'] : ['state' => 0, 'msg' => '操作失败'];
    }
}