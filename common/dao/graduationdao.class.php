<?php

class GraduationDAO {
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    private const GRADUATION_TABLE = 'graduation';
    private const COL_ID = 'id';
    private const COL_USER_ID = 'professional_user_id';
    private const COL_TITLE = 'title';
    private const COL_INSTITUTION = 'institution';
    private const COL_START = 'start_period';
    private const COL_END = 'end_period';
    private const COL_IMG = 'image';
    private const COL_VISIBLE = 'visible';

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function graduationListByProfessional($professionalId, $byId = false) {
        $where = [self::COL_USER_ID." = $professionalId"];

        $orderBy = '';

        if ($byId) {
            $orderBy = self::COL_ID;
        } else {
            $orderBy = self::COL_START." DESC";
        }

        $data = $this->retrieveAll(
            self::GRADUATION_TABLE, $where,
            '*', false, false, $orderBy
        );

        return $this->graduationListByAssoc($data);
    }

    public function graduationById($graduationId, $userId) {
        $where = [
            self::COL_ID." = $graduationId",
            self::COL_USER_ID." = $userId"
        ];

        $data = $this->retrieveAll(self::GRADUATION_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->graduationByAssoc($data[0]);
    }

    public function registerGraduation($graduation, $userId) {
        if ($userId == -1) return;

        $values = $this->valuesByModel($graduation);
        $values[self::COL_USER_ID] = $userId;

        $this->insert(self::GRADUATION_TABLE, $values);
    }

    public function updateGraduation($graduation, $userId) {
        $values = $this->valuesByModel($graduation);

        $where = [
            self::COL_ID." = $graduation->id",
            self::COL_USER_ID." = $userId"
        ];

        $this->update(self::GRADUATION_TABLE, $values, $where);
    }

    public function deleteGraduation($id, $userId) {
        $where = [
            self::COL_ID." = $id",
            self::COL_USER_ID." = $userId"
        ];

        $this->delete(self::GRADUATION_TABLE, $where);
    }

    public function updateFileUrl($url, $gradId, $userId) {
        $where = [
            self::COL_ID." = $gradId",
            self::COL_USER_ID." = $userId"
        ];

        $this->update(
            self::GRADUATION_TABLE,
            [self::COL_IMG => $url],
            $where
        );
    }

    private function valuesByModel($graduation) {
        $values = [
            self::COL_TITLE => $graduation->title,
            self::COL_INSTITUTION => $graduation->institution,
            self::COL_START => $graduation->startPeriod,
            self::COL_END => $graduation->endPeriod,
            self::COL_VISIBLE => $graduation->visible ? 1 : 0
        ];

        if ($graduation->image != null) $values[self::COL_IMG] = $graduation->image;

        return $values;
    }

    private function graduationListByAssoc($assoc) {
        $list = array();

        foreach ($assoc as $line) {
            $list[] = $this->graduationByAssoc($line);
        }

        return $list;
    }

    private function graduationByAssoc($assoc) {
        $grad = new Graduation();

        $grad->id = $assoc[self::COL_ID];
        $grad->title = $assoc[self::COL_TITLE];
        $grad->institution = $assoc[self::COL_INSTITUTION];
        $grad->startPeriod = $assoc[self::COL_START];
        $grad->endPeriod = $assoc[self::COL_END];
        $grad->image = $assoc[self::COL_IMG];
        $grad->visible = $assoc[self::COL_VISIBLE];

        return $grad;
    }
}