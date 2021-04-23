<?php

class Chart {
    use BaseModel {
        BaseModel::__construct as private __bmConstruct;
    }

    private $lastMonthsLabels;
    private $lastMonthsValues;

    public function __construct($noRecords = null) {
        $this->__bmConstruct();

        if ($noRecords === true) {
            $this->lastMonthsLabels = HistoryUtils::lastTwelveMonths(date('m'), date('Y'));
            $this->lastMonthsValues = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        }
    }
}