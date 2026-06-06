<?php
/* *
 * 配置文件
 */
 
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
switch ($conf['epay_v']) {
    case '2':
        $epay_config = [
            //支付接口地址
            'apiurl' => $payapi,
        
            //商户ID
            'pid' => $conf['epay_pid'],
        
            //平台公钥
            'platform_public_key' => $conf['epay_public_key'],
        
            //商户私钥
            'merchant_private_key' => $conf['epay_private_key'],
        ];
        break;
    default:
        $epay_config = [
            //支付接口地址
            'apiurl' => $payapi,
        
            //商户ID
            'pid' => $conf['epay_pid'],
        
            //商户KEY
            'key' => $conf['epay_key'],
        ];
        break;
}
?>