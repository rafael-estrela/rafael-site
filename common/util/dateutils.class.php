<?php

class DateUtils {
    public static function brToDb($date) {
        $dateArr = explode("/", $date);

        if (count($dateArr) != 3) return '';

        return implode("-", array_reverse($dateArr));
    }

    public static function dbToBr($date) {
        $dateArr = explode("-", $date);

        if (count($dateArr) != 3) return '';

        return implode("/", array_reverse($dateArr));
    }

    public static function dbToPdf($date) {
        $dateArr = explode("-", $date);

        if (count($dateArr) != 3) return '';

        $monthYear = array($dateArr[0], $dateArr[1]);

        return implode("/", array_reverse($monthYear));
    }

    public static function isOrderCorrect($startDate, $endDate) {
        $startTimestamp = strtotime(self::brToDb($startDate));
        $endTimestamp = strtotime(self::brToDb($endDate));

        return $endTimestamp >= $startTimestamp;
    }
}