<?php

class MultiCurl {

    public static function get($urls, $delay = 1) {
        $queue = curl_multi_init();
        $map = array();

        foreach ($urls as $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url['url']);
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 600);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 200);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL, true);
            if (isset($url['host'])) {
                $host = '';
                $host = array("Host: ".$url['host']);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
            }
            curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, true);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 3600);
            curl_multi_add_handle($queue, $ch);
            $map[$url['url']] = $ch;
        }

        $active = null;
        do {
            $mrc = curl_multi_exec($queue, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active > 0 && $mrc == CURLM_OK) {
            if (curl_multi_select($queue, 0.5) != -1) {
                do {
                    $mrc = curl_multi_exec($queue, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }

        $responses = array();
        foreach ($map as $url=>$ch) {
            $info = curl_getinfo($ch);
            $result = curl_multi_getcontent($ch);
            $error = curl_error($ch);
            $responses[$url] = compact("result", "info", "error");
            curl_multi_remove_handle($queue, $ch);
            curl_close($ch);
        }

        curl_multi_close($queue);
        return $responses;
    }
}
