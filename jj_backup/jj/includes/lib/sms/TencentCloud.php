<?php
namespace lib\sms;

class TencentCloud {
    private $secretId;
    private $secretKey;
    private $host;
    private $region;
    private $sdkAppId;
    private $signName;

    function __construct($secretId, $secretKey, $region = "ap-guangzhou", $sdkAppId = "", $signName = ""){
        $this->secretId = $secretId;
        $this->secretKey = $secretKey;
        $this->host = "sms.tencentcloudapi.com";
        $this->region = $region;
        $this->sdkAppId = $sdkAppId;
        $this->signName = $signName;
    }

    public function send($phone, $code, $templateId, $sessionContext = ""){
        if(empty($this->secretId) || empty($this->secretKey) || empty($this->sdkAppId) || empty($this->signName)){
            return "参数不全";
        }

        $param = array(
            "Nonce" => rand(10000, 99999),
            "Timestamp" => time(),
            "Region" => $this->region,
            "SecretId" => $this->secretId,
            "Version" => "2021-01-11",
            "Action" => "SendSms",
            "SmsSdkAppId" => $this->sdkAppId,
            "SignName" => $this->signName,
            "TemplateId" => $templateId,
            "TemplateParamSet.0" => $code,
            "PhoneNumberSet.0" => $phone,
            "SessionContext" => $sessionContext,
        );

        ksort($param);

        $signStr = "GET" . $this->host . "/?";
        foreach ( $param as $key => $value ) {
            $signStr = $signStr . $key . "=" . $value . "&";
        }
        $signStr = substr($signStr, 0, -1);

        $signature = base64_encode(hash_hmac("sha1", $signStr, $this->secretKey, true));
        
        $param["Signature"] = $signature;
        $paramStr = "";
        foreach ( $param as $key => $value ) {
            $paramStr = $paramStr . $key . "=" . urlencode($value) . "&";
        }
        $paramStr = substr($paramStr, 0, -1);

        $url = "https://" . $this->host . "/?" . $paramStr;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $output = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode == 200) {
            $result = json_decode($output, true);
            if (isset($result['Response']['Error'])) {
                return "发送失败: " . $result['Response']['Error']['Message'];
            } else {
                return true;
            }
        } else {
            return "网络请求失败，HTTP状态码: " . $httpCode;
        }
    }
}