<?php

class StringUtils {
    public static function mask($value, $mask) {
        $masked = '';
        $k = 0;

        if ($value == null || empty($value)) return $masked;

        for($i = 0; $i <= strlen($mask) - 1; $i++) {
            if($mask[$i] == '#') {
                if(isset($value[$k])) $masked .= $value[$k++];
            } else {
                if(isset($mask[$i])) $masked .= $mask[$i];
            }
        }

        return $masked;
    }

    public static function nl2p($value) {
        $newValue = "";

        $value = str_replace("&#10;", "\n", $value);

        $valueArr = explode("\n", $value);

        foreach($valueArr as $block) {
            $newValue .= "<p class='lead'>$block</p>";
        }

        return $newValue;
    }

    public static function periodString($start, $end) {
        $startStr = DateUtils::dbToPdf($start);

        if ($end == null) {
            $endStr = USER_CURRENT;
        } else {
            $endStr = DateUtils::dbToPdf($end);
        }

        return "$startStr - $endStr";
    }
}