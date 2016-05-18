<?php
/**
    * @brief 获取数组内容
    *
    * @param $array
    * @param $key
    * @param $default
    *
    * @return
 */
function get($array, $key, $default = NULL)
{
    $value = is_array($array) ? $array[$key] : $array->$key;
    return isset($value) ? $value : $default;
}

/**
* @brief 抽取数组指定下标的值，返回新数组
    *
    * @param $array
    * @param $keys
    * @param $default
    *
    * @return
 */
function extract($array, array $keys, $default = NULL)
{
    $type = is_array($array);

    $found = array();
    foreach ($keys as $key)
    {
        $value = $type ? $array[$key] : $array->$key;
        $found[$key] = isset($value) ? $value : $default;
    }

    return $found;
}


/**
    * @brief 数组转换
    *           $columnKey:null      $indexKey:null       返回全部列,自然数组
    *           $columnKey:notnull   $indexKey:null       返回指定列,自然数组
    *           $columnKey:null      $indexKey:notnull    返回全部列,以$indexKey为下标的关联数组
    *           $columnKey:notnull   $indexKey:notnull    返回指定列,以$indexKey为下标的关联数组
    *
    * @param $input
    * @param $columnKey
    * @param $indexKey
    *
    * @return
 */
function column(array $input, $columnKey, $indexKey = NULL)
{
    $result = array();

    if (NULL === $indexKey)
    {
        if (NULL === $columnKey)
        {
            $result = array_values($input);
        }
        else
        {
            foreach ($input as $row)
            {
                $result[] = $row[$columnKey];
            }
        }
    }
    else
    {
        if (NULL === $columnKey)
        {
            foreach ($input as $row)
            {
                $result[$row[$indexKey]] = $row;
            }
        }
        else
        {
            foreach ($input as $row)
            {
                $result[$row[$indexKey]] = $row[$columnKey];
            }
        }
    }

    return $result;
}

function getClientRealIp()
{/*{{{*/
    $realip = '';
    if (!empty($_SERVER["HTTP_CLIENT_IP"]))  {
        $realip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        //可能有多层代理
        $ips = explode (",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
                $realip = trim($ips[$i]);
                break;
            }
        }
    }
    return $realip ? $realip : $_SERVER["REMOTE_ADDR"];
}/*}}}*/

function microtime_float() {/*{{{*/
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }   /*}}}*/

/** 去除javascript相关标签和事件
 *
 */
function strip_html($htmlcode){/*{{{*/
    $htmlcode = trim($htmlcode);
    $search = array(
        "'<script[^>]*?>.*?</script>'si",//过滤SCRIPT标记
        "'<iframe[^>]*?>.*?</iframe>'si" //过滤IFRAME标记
    );
    $replace = "";

    $aDisabledAttributes = array(
        'onabort', 'onactivate', 'onafterprint',
        'onafterupdate', 'onbeforeactivate', 'onbeforecopy',
        'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus',
        'onbeforepaste', 'onbeforeprint', 'onbeforeunload',
        'onbeforeupdate', 'onblur', 'onbounce',
        'oncellchange', 'onchange', 'onclick',
        'oncontextmenu', 'oncontrolselect', 'oncopy',
        'oncut', 'ondataavaible', 'ondatasetchanged',
        'ondatasetcomplete', 'ondblclick', 'ondeactivate',
        'ondrag', 'ondragdrop', 'ondragend', 'ondragenter',
        'ondragleave', 'ondragover', 'ondragstart', 'ondrop',
        'onerror', 'onerrorupdate', 'onfilterupdate',
        'onfinish', 'onfocus', 'onfocusin', 'onfocusout',
        'onhelp', 'onkeydown', 'onkeypress', 'onkeyup',
        'onlayoutcomplete', 'onload', 'onlosecapture',
        'onmousedown', 'onmouseenter', 'onmouseleave',
        'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup',
        'onmousewheel', 'onmove', 'onmoveend', 'onmovestart',
        'onpaste', 'onpropertychange', 'onreadystatechange',
        'onreset', 'onresize', 'onresizeend', 'onresizestart',
        'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll',
        'onselect', 'onselectionchange', 'onselectstart',
        'onstart', 'onstop', 'onsubmit', 'onunload'
    );

    $htmlcode = preg_replace($search,$replace,$htmlcode);
    $aDisabledAttributes = @implode('|', $aDisabledAttributes);
    $htmlcode = preg_replace('/<(.*?)>/ie',
        "'<' . preg_replace(array(
            '/text\/javascript/i',
            '/(" . $aDisabledAttributes . ")[ \\t\\n]*/i'),
    array('text\/html', 'data-evt'), stripslashes('\\1')) . '>'", $htmlcode );
    return $htmlcode;
}/*}}}*/

/**是否全英文字符或数字
 *
 */
function isAllLetter($str){/*{{{*/
    for($i=0;$i<strlen($str);$i++)
    {
       if( ord($str[$i]) > 127) return false;
    }
    return true;
}/*}}}*/


/** 处理query,去除换行符，截取120个字符
 *
 */
public static function formatQuery($query){
    $query = self::trimBr(trim($query));
    return self::iSubstr($query,120);
}

/**去除换行标示符 \r \n
 *
 */
public static function trimBr($str){
    //$str = iconv("UTF-8","GBK//IGNORE",$str);
    //$str = iconv("GBK","UTF-8//IGNORE",$str);
    return str_replace(array("\r","\n","\t",urldecode('%E2%80%86')),"",$str);
}

/**UTF-8 截取长度
 *
 */
public static function iSubStr($str, $len) {
    $i = 0;
    $tlen = 0;
    $tstr = '';
    while ($tlen < $len) {
        $chr = mb_substr($str, $i, 1, 'utf8');
        $chrLen = ord($chr) > 127 ? 3 : 1;
        if ($tlen + $chrLen > $len) break;
        $tstr .= $chr;
        $tlen += $chrLen;
        $i++;
    }
    return $tstr;
}

/*
 *防止xss漏洞
 *
 * */
public static function doSecure($opt)
{
    if( is_numeric($opt) ){
        $opt = $opt;
    }else{
        $opt = strip_tags($opt);
        $opt = htmlspecialchars($opt,ENT_QUOTES);
    }
    return $opt;
}


public static function getRealIP(){
    $realip = '0.0.0.0';
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
        foreach ($arr AS $ip) {
            $ip = trim($ip);
            if ($ip != 'unknown') {
                $realip = $ip;

                break;
            }
        }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $realip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $realip = $_SERVER['REMOTE_ADDR'];
        } else {
            $realip = '0.0.0.0';
        }
    }
    return $realip;
}

/**
 */
private function _intervalTime($m1, $m2, $round = 3) {
    return round($m2 -$m1), $round); //返回将 val 根据指定精度 precision（十进制小数点后数字的数目）进行四舍五入的结果。precision 也可以是负数或零（默认值）。
}

function http_build_multi_query($data, $key = null)
{
    $query = array();
    if(empty($data)) {
        return $key . '=';
    }
    $is_array_assoc = is_array_assoc($data);
    foreach($data as $k => $value) {
        if(is_string($value) || is_numeric($value)) {
            $brackets = $is_array_assoc ? '[' . $k . ']' : '[]';
            $query[] = urlencode(is_null($key) ? $k : $key . $brackets) . '=' .
            rawurlencode($value);
        } else 
        if(is_array($value)) {
            $nested = is_null($key) ? $k : $key . '[' . $k . ']';
            $query[] = http_build_multi_query($value, $nested);
        }
    }
    return implode('&', $query);
}

function _getSign($url_params)
{/*{{{*/
    ksort($url_params);
    //拼接query_str参数字符串
    $query_arr= '';
    foreach($url_params as $key => $val) {
        $val = is_array($val) ? json_encode($val) : $val;
        $query_str .= "{$key}={$val}&";
    }
    $query_str = trim($query_str,'&');
    $query_str .= '&sk=' . "keystr";
    $sign = md5($query_str);
    return $sign;
}/*}}}*/
function _checkSign()
{/*{{{*/
   $querystring_arrays = $_POST;
   ksort($querystring_arrays);//array 按照key 进行排序
   unset($querystring_arrays['sign']);
   $querystring = ''; 
   foreach ($querystring_arrays as $key=>$value) {//字符串拼接
       $querystring .= "{$key}={$value}&"; 
   } 
   $querystring = trim($querystring,'&');
   $querystring .= '&sk=' . "keystr";
   $sn = md5($querystring);//md5 hash 
   return $sn;
}/*}}}*/
