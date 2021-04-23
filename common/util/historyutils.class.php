<?php

class HistoryUtils {
    private const COL_YEAR = 'year';
    private const COL_MONTH = 'month';
    private const COL_TOTAL = 'total';

    public static function lastTwelveMonths($firstMonth, $firstYear) {
        $months = array();

        while(count($months) < 12) {
            array_unshift($months, self::monthNumberToName($firstMonth--)."/$firstYear");

            if ($firstMonth == 0) {
                $firstMonth = 12;
                $firstYear--;
            }
        }

        return $months;
    }

    public static function accessStructure($assoc) {
        $dict = self::accessDict($assoc);

        $currentMonth = date('n');
        $currentYear = date('Y');

        $months = array();
        $access = array();

        while (count($months) < 12) {
            if (!key_exists($currentYear, $dict)) {
                array_unshift($access, 0);
            } else {
                $yearAccess = $dict[$currentYear];

                if (!key_exists($currentMonth, $yearAccess)) {
                    array_unshift($access, 0);
                } else {
                    array_unshift($access, $yearAccess[$currentMonth]);
                }
            }

            array_unshift($months, self::monthNumberToName($currentMonth--)."/$currentYear");

            if ($currentMonth == 0) {
                $currentYear--;
                $currentMonth = 12;
            }
        }

        return [$months, $access];
    }

    private static function accessDict($assoc) {
        $values = array();

        foreach($assoc as $access)
            $values[$access[self::COL_YEAR]][$access[self::COL_MONTH]] = $access[self::COL_TOTAL];

        return $values;
    }

    private static function monthNumberToName($month) {
        switch ($month) {
            case 1:
                return 'Jan';
            case 2:
                return 'Fev';
            case 3:
                return 'Mar';
            case 4:
                return 'Abr';
            case 5:
                return 'Mai';
            case 6:
                return 'Jun';
            case 7:
                return 'Jul';
            case 8:
                return 'Ago';
            case 9:
                return 'Set';
            case 10:
                return 'Out';
            case 11:
                return 'Nov';
            case 12:
                return 'Dez';
            default:
                return '';
        }
    }
}