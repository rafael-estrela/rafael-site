<?php

class WorkDAO {
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    private const WORK_TABLE = 'work';
    private const COL_ID = 'id';
    private const COL_USER_ID = 'professional_user_id';
    private const COL_POSITION = 'position';
    private const COL_COMPANY = 'company';
    private const COL_DESC = 'description';
    private const COL_START = 'start_period';
    private const COL_END = 'end_period';
    private const COL_IMG = 'image';
    private const COL_VISIBLE = 'visible';

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function workListByProfessional($id, $byId = false) {
        $where = [self::COL_USER_ID." = $id"];

        $orderBy = '';

        if ($byId) {
            $orderBy = self::COL_ID;
        } else {
            $orderBy = self::COL_START." DESC";
        }

        $data = $this->retrieveAll(
            self::WORK_TABLE, $where,
            '*', false, false, $orderBy
        );

        return $this->workListByAssoc($data);
    }

    public function workById($workId, $userId) {
        $where = [
            self::COL_ID." = $workId",
            self::COL_USER_ID." = $userId"
        ];

        $data = $this->retrieveAll(self::WORK_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->workByAssoc($data[0]);
    }

    public function registerWork($work, $userId) {
        if ($userId == -1) return;

        $values = $this->valuesByModel($work);
        $values[self::COL_USER_ID] = $userId;

        $this->insert(self::WORK_TABLE, $values);
    }

    public function updateWork($work, $userId) {
        $values = $this->valuesByModel($work);
        $where = [
            self::COL_ID." = $work->id",
            self::COL_USER_ID." = $userId"
        ];

        $this->update(self::WORK_TABLE, $values, $where);
    }

    public function deleteWork($id, $userId) {
        $where = [
            self::COL_ID." = $id",
            self::COL_USER_ID." = $userId"
        ];

        $this->delete(self::WORK_TABLE, $where);
    }

    public function updateFileUrl($url, $workId, $userId) {
        $where = [
            self::COL_ID." = $workId",
            self::COL_USER_ID." = $userId"
        ];

        $this->update(
            self::WORK_TABLE,
            [self::COL_IMG => $url],
            $where
        );
    }

    private function valuesByModel($work) {
        $values = [
            self::COL_POSITION => $work->position,
            self::COL_COMPANY => $work->company,
            self::COL_DESC => $work->description,
            self::COL_START => $work->startPeriod,
            self::COL_END => $work->endPeriod,
            self::COL_VISIBLE => $work->visible ? 1 : 0
        ];

        if ($work->image != null) $values[self::COL_IMG] = $work->image;

        return $values;
    }

    private function workListByAssoc($assoc) {
        $list = array();

        foreach ($assoc as $line) {
            $list[] = $this->workByAssoc($line);
        }

        return $list;
    }

    private function workByAssoc($assoc) {
        $work = new Work();

        $work->id = $assoc[self::COL_ID];
        $work->position = $assoc[self::COL_POSITION];
        $work->company = $assoc[self::COL_COMPANY];
        $work->description = $assoc[self::COL_DESC];
        $work->startPeriod = $assoc[self::COL_START];
        $work->endPeriod = $assoc[self::COL_END];
        $work->image = $assoc[self::COL_IMG];
        $work->visible = $assoc[self::COL_VISIBLE];

        return $work;
    }
}