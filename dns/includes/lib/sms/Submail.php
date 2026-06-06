<?php
namespace lib\sms;

class Submail {
    private $appid;
    private $appkey;

    function __construct($appid, $appkey){
        $this->appid = $appid;
        $this->appkey = $appkey;
    }

    /**
     * 发送短信
     * @param string $phone 手机号
     * @param string $code 验证码或变量内容
     * @param string $moban 短信模板，{code}为变量占位符
     * @param string $sign 短信签名（不带中括号）
     * @return true|string 成功返回true，失败返回错误信息
     */
    public function send($phone, $code, $moban, $sign){
        if(empty($this->appid)||empty($this->appkey)) return false;
        $content = '【'.$sign.'】'.str_replace('{code}', $code, $moban);
        $params = [
            'appid' => $this->appid,
            'to' => $phone,
            'content' => $content,
            'signature' => $this->appkey
        ];
        $url = 'https://api-v4.mysubmail.com/sms/send?' . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($result, true);
        if(isset($res['status']) && $res['status'] === 'success'){
            return true;
        }else{
            return isset($res['msg']) ? $res['msg'] : '发送失败';
        }
    }
}
