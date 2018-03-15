<?php
namespace app\apiv1\service;

use app\lib\exception\WxChatException;
use think\Exception;

class Wx{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    /**
     * @return string
     * @throws Exception
     * 获取openId
     */
    public function get() {
        $result = curl_get($this->wxLoginUrl);
        $wxresult = json_decode($result,true);
        if(empty($wxresult)) {
            throw new Exception('获取session_key和openid异常，微信内部错误');
        }else {
            $loginFail = array_key_exists('errcode',$wxresult);
            if($loginFail) {
                $this->processLoginError($wxresult);
            }else {
                return  $wxresult['openid'];
            }
        }

    }

    /**
     * @param $wxresult
     * @throws WxChatException
     * 处理微信登录错误
     */
    protected function processLoginError($wxresult) {
        throw new WxChatException([
            'msg'=>$wxresult['errmsg'],
            'errorCode'=>$wxresult['errcode']
        ]);
    }

}