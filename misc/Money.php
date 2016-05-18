<?php

class Money
{
    /*{{{*/
    public static function fenToYuan($fen)
    {
        $result = self::fenToYuanBase($fen);
        return $result;
    }
    public static function yuanToFen($yuan)
    {
        if (empty($yuan) || !is_numeric($yuan)) {
            return 0;
        }
        $result = number_format($yuan * 100, 0, '', '');

        return $result;
    }
    public static function yuanToWan($yuan)
    {
        if ($yuan >= 100000) {
            $yuan = number_format($yuan / 10000, 0, '.', '').'万';
        } elseif ($yuan >= 10000) {
            $yuan = number_format($yuan / 10000, 1, '.', '').'万';
        }

        return $yuan;
    }
    public static function fenToYuanBase($fen)
    {
        if (empty($fen) || !is_numeric($fen)) {
            return 0;
        }

        if ($fen % 100 == 0) {
            $result = number_format($fen / 100, 2, '.', ',');
        } elseif ($fen % 10 == 0) {
            $result = number_format($fen / 100, 2, '.', ',');
        } else {
            $result = number_format($fen / 100, 2, '.', ',');
        }

        return $result;
    }
    public static function rebateFmt($fen)
    {
        if (empty($fen) || !is_numeric($fen)) {
            return 0;
        }

        if ($fen % 100 == 0) {
            $result = number_format($fen / 100, 0, '', '');
        } elseif ($fen % 10 == 0) {
            $result = number_format($fen / 100, 1, '.', '');
        } else {
            $result = number_format($fen / 100, 1, '.', '');
        }

        return $result;
    }
    public static function fmtShow($money)
    {
        return (strstr($money, '.') !== false) ? trim(trim(strval($money), '0'), '.') : $money;
    }
}/*}}}*/

