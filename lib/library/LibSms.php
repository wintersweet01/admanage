<?php

include LIB . '/library/dayusms/aliyun-php-sdk-core/Config.php';
include_once LIB . '/library/dayusms/Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once LIB . '/library/dayusms/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';


class LibSms
{

    public static $template = array(
        'reg' => 'SMS_149101709',
        'find' => 'SMS_149101709',
        'bind' => 'SMS_149101709',
        'unbind' => 'SMS_149101709',
    );

    public static function send($type = 'reg', $phone = '', $code = '')
    {
        if (!$phone || !$code) {
            return array('state' => false, 'msg' => '参数错误');
        }

        $accessKeyId = "LTAINopyEVqpV6Q1";
        $accessKeySecret = "fjGd2RgtX1IpTbB2nCir7IZdolyvjL";
        //短信API产品名
        $product = "Dysmsapi";
        //短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        //暂时不支持多Region
        $region = "cn-hangzhou";

        //初始化访问的acsCleint
        $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
        $acsClient = new DefaultAcsClient($profile);

        $request = new Dysmsapi\Request\V20170525\SendSmsRequest;
        //必填-短信接收号码
        $request->setPhoneNumbers($phone);
        //必填-短信签名
        $request->setSignName("胡桃互娱");
        //必填-短信模板Code
        $request->setTemplateCode(self::$template[$type]);
        //选填-假如模板中存在变量需要替换则为必填(JSON格式)
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "code" => $code
        ), JSON_UNESCAPED_UNICODE));
        //选填-发送短信流水号
        $request->setOutId("");

        //发起访问请求
        $acsResponse = (array)$acsClient->getAcsResponse($request);
        //该死的阿里大鱼sdk，竟然改我的时区，垃圾sdk
        date_default_timezone_set('PRC');
        if ($acsResponse['Code'] != 'OK') {
            return array('state' => false, 'msg' => $acsResponse['Message']);
        }
        return array(
            'state' => true,
            'msg' => $acsResponse['BizId'],
        );
    }

}