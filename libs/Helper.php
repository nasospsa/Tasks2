<?php

Class Helper {

    static function get_tiny_url($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    static function secondsToTime($seconds) {
        // extract hours
        $hours = floor($seconds / (60 * 60));

        // extract minutes
        $divisor_for_minutes = $seconds % (60 * 60);
        $minutes = floor($divisor_for_minutes / 60);

        // extract the remaining seconds
        $divisor_for_seconds = $divisor_for_minutes % 60;
        $seconds = ceil($divisor_for_seconds);

        // return the final array
        $obj = array(
            "h" => (int) $hours,
            "m" => (int) $minutes,
            "s" => (int) $seconds,
        );
        return $obj;
    }

    static function dateChangeFormat($date) {
        $date = explode("/", $date);
        $new_format = $date[2] . "-" . $date[1] . "-" . $date[0];
        return $new_format;
    }

    static function generateRandStr($length) {
        $randstr = "";
        for ($i = 0; $i < $length; $i++) {
            $randnum = mt_rand(0, 61);
            if ($randnum < 10) {
                $randstr .= chr($randnum + 48);
            } else if ($randnum < 36) {
                $randstr .= chr($randnum + 55);
            } else {
                $randstr .= chr($randnum + 61);
            }
        }
        return $randstr;
    }

    static function array_in_array_mistakes($arr1, $arr2) {
        $mistakes = 0;
        foreach ($arr1 as $element_arr1) {
            if (!in_array($element_arr1, $arr2))
                $mistakes++;
        }
        return $mistakes;
    }

    static function array_not_in_array($arr1, $arr2) {
        $mistakes = array();
        foreach ($arr1 as $element_arr1) {
            if (!in_array($element_arr1, $arr2))
                $mistakes[$element_arr1] = $element_arr1;
        }
        return $mistakes;
    }

    static function array_not_in_array_by_keys($arr1, $arr2) {
        $mistakes = array();
        foreach ($arr1 as $key1 => $value1) {
            if (!in_array($key1, $arr2))
                $mistakes[$key1] = $value1;
        }
        return $mistakes;
    }

    static function nicetime($date) {

        if (empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        $now = time();
        $unix_date = strtotime($date);
        if (empty($unix_date)) {
            return "Bad date";
        }
        // is it future date or past date
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        }

        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j].= "s";
        }
        return "$difference $periods[$j] {$tense}";
    }

    static function sortArrayByArray($array, $orderArray) {
        $ordered = array();
        foreach ((array) $orderArray as $key) {
            if (array_key_exists($key, $array)) {
                $ordered[$key] = $array[$key];
                unset($array[$key]);
            }
        }
        return $ordered + $array;
    }

}

?>