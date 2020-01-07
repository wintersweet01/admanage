<?php
//格式：渠道简称（和后台配置的渠道要匹配）=>渠道参数
//这里是对接过的渠道，你们可以自己重新根据对方的文档来对接，也可以直接用
return array(
    'jrtt' => '&os=__OS__&imei=__IMEI__&idfa=__IDFA__&time=__TS__&ip=__IP__&callback_param=__CALLBACK_PARAM__&ua=__UA__', //今日头条
    'uc' => '&imei={IMEI_SUM}&idfa={IDFA_SUM}&time={TS}&ip={IP}&callback_url={CALLBACK_URL}&ua={UA}', //UC头条
    'gdt' => '', //广点通
    'bd' => '&idfa={{IDFA}}&imei={{IMEI_MD5}}&os={{OS}}&ip={{IP}}&ts={{TS}}&pid={{PLAN_ID}}&uid={{UNIT_ID}}&aid={{IDEA_ID}}&click_id={{CLICK_ID}}&callback_url={{CALLBACK_URL}}&ua={{UA}}', //百度
    'ks' => '&imei=__IMEI2__&idfa=__IDFA2__&time=__TS__&ip=__IP__&callback=__CALLBACK__', //快手
    'mp' => '', //微信
    'momo' => '&imei=[IMEI]&idfa=[IDFA]&ts=[TS]&callback_url=[CALLBACK]&ua=[UA]', //陌陌
    'yk' => '&imei=__IMEI__&idfa=__IDFA__&os=__OS__&ip=__IP__&clickid=__REQUESTID__', //优酷
    'zy' => '&imei=__IMEI__&idfa=__IDFA__&ip=__IP__&callback_url=__CALLBACK__', //最右
    'iqy' => '&imei=__IMEI__&idfa=__IDFA__&ip=__IP__&time=__TS__&os=__OS__&callback_url=__CALLBACK_URL__&ua=__UA__', //爱奇艺
    'tanv' => '&imei=%IMEI%&idfa=%IDFA%&time=%TIME%&ip=%IP%&callback_url=%CALLBACK%', //TANV，巨鲨
);