<?php
class Map
{/*{{{*/
    /** 
        * 获取两个经纬度之间的距离
        * @param $lat1 
        * @param $lng1 
        * @param $lat2 
        * @param $lng2 
     */ 
    public static function getDistance($lat1, $lng1, $lat2, $lng2)
    {/*{{{*/
        $EARTH_RADIUS = 6378.137;
        $radLat1 = self::rad($lat1);
        $radLat2 = self::rad($lat2);

        $a = $radLat1 - $radLat2;
        $b = self::rad($lng1) - self::rad($lng2);
        $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
        $s = $s *$EARTH_RADIUS;
        $s = round($s * 10000) / 10000;

        return $s;
    }/*}}}*/

    public static function rad($d)
    {/*{{{*/
        return $d * 3.1415926535898 / 180.0;
    }/*}}}*/
}/*}}}*/

