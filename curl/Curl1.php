<?php

/**基础curl实现，支持毫秒级
 */
function curl($url,$timeout=1100,$connect_timeout=2000, $host=''){
    $new_ch = curl_init();
    curl_setopt($new_ch,CURLOPT_URL, $url );
    curl_setopt($new_ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($new_ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.)");
    curl_setopt($new_ch,CURLOPT_TIMEOUT_MS,   $timeout); //置cURL允许执行的最长毫秒数。
    curl_setopt($new_ch,CURLOPT_CONNECTTIMEOUT_MS,   $connect_timeout); //尝试连接等待的时间，以毫秒为单位。如果设置为0，则无限等待。 
    curl_setopt($new_ch,CURLOPT_RETURNTRANSFER,true);
    if ($host != '') {
        curl_setopt($new_ch,CURLOPT_HTTPHEADER,$host); //设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
    }
    curl_setopt ($new_ch, CURLOPT_NOSIGNAL, true); //dns解析超时忽略
    $result = curl_exec($new_ch);

    $code  = curl_errno($new_ch);
    curl_close($new_ch);
    return $result;
}

/**基础curl实现，支持毫秒级
 *
 */
public static function curl_post($url,$args,$timeout=1000,$connect_timeout=300){
    $new_ch = curl_init();
    curl_setopt($new_ch,CURLOPT_URL, $url );
    curl_setopt($new_ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($new_ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.)");
    curl_setopt($new_ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($new_ch,CURLOPT_TIMEOUT_MS,   $timeout);
    curl_setopt($new_ch,CURLOPT_CONNECTTIMEOUT_MS,   $connect_timeout);
    curl_setopt($new_ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($new_ch,CURLOPT_POST, true);
    curl_setopt($new_ch,CURLOPT_POSTFIELDS, $args);
    $result = curl_exec($new_ch);
    $code  = curl_errno($new_ch);
    curl_close($new_ch);
    return $result;
}

