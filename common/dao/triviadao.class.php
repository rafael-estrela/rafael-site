<?php

class TriviaDao {
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    private const TABLE_TRIVIA = 'trivia';

    private const COL_ID = 'id';
    private const COL_USER_ID = 'professional_user_id';
    private const COL_VALUE = 'value';

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function saveTrivia($trivia) {
        $this->insert(self::TABLE_TRIVIA, $this->valuesByModel($trivia));
    }

    public function updateTrivia($trivia) {
        $where = [
            self::COL_ID." = $trivia->id",
            self::COL_USER_ID." = $trivia->professionalId"
        ];

        $this->update(self::TABLE_TRIVIA, $this->valuesByModel($trivia), $where);
    }

    public function deleteTrivia($trivia) {
        $where = [
            self::COL_ID." = $trivia->id",
            self::COL_USER_ID." = $trivia->professionalId"
        ];

        $this->delete(self::TABLE_TRIVIA, $where);
    }

    public function loadTrivia($userId) {
        $where = [self::COL_USER_ID." = $userId"];

        $data = $this->retrieveAll(self::TABLE_TRIVIA, $where);

        if (count($data) == 0) return [];

        return $this->listFromAssoc($data);
    }

    private function valuesByModel($trivia) {
        $values = [
            self::COL_USER_ID => $trivia->professionalId,
            self::COL_VALUE => $trivia->value
        ];

        return $values;
    }

    private function listFromAssoc($assoc) {
        $list = array();

        foreach($assoc as $trivia) {
            $list[] = $this->triviaFromAssoc($trivia);
        }

        return $list;
    }

    private function triviaFromAssoc($assoc) {
        $trivia = new Trivia();

        $trivia->id = $assoc[self::COL_ID];
        $trivia->professionalId = $assoc[self::COL_USER_ID];
        $trivia->value = $assoc[self::COL_VALUE];

        return $trivia;
    }
}