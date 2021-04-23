<?php

class SkillDao {
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    private const SKILL_VIEW = 'v_skill';

    private const SKILL_CONFIRMED_TABLE = 'skill_confirmed';
    private const SKILL_PROFESSIONAL_TABLE = 'skill_professional';
    private const TMP_SKILL_TABLE = 'skill';

    private const COL_ID = 'id';
    private const COL_NAME = 'name';

    private const COL_SKILL_ID = 'skill_id';
    private const COL_PROFESSIONAL_ID = 'professional_id';
    private const COL_PERCENT = 'percentage';
    private const COL_VISIBLE = 'visible';

    private const COL_ENTRY_COUNT = 'entry_count';

    public function skillListById($professionalId, $forDash = true) {
        $where = [self::COL_PROFESSIONAL_ID." = $professionalId"];
        $orderBy = $forDash ? self::COL_NAME : self::COL_PERCENT." DESC";

        $data = $this->retrieveAll(
            self::SKILL_VIEW, $where,
            '*', false, false, $orderBy
        );

        return $this->skillListByAssoc($data);
    }

    public function skillListByName($skill) {
        $where = [self::COL_NAME." LIKE %$skill%"];

        $data = $this->retrieveAll(
            self::SKILL_CONFIRMED_TABLE, $where,
            '*', false, false, self::COL_NAME
        );

        return $this->confirmedSkillListByAssoc($data);
    }

    public function mappedSkillByName($skill) {
        $where = [self::COL_NAME." = $skill"];

        $data = $this->retrieveAll(
            self::TMP_SKILL_TABLE, $where,
            '*', false, false, self::COL_NAME
        );

        $result = $this->tempSkillsListByAssoc($data);

        if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }

    public function mapSkill($skill) {
        $values = [
            self::COL_NAME => $skill,
            self::COL_ENTRY_COUNT => 1
        ];

        $this->insert(self::TMP_SKILL_TABLE, $values);

        $insertedSkill = $this->retrieveAll(
            self::TMP_SKILL_TABLE,
            [self::COL_NAME." = $skill"]
        );

        return $this->tempSkillsByAssoc($insertedSkill[0]);
    }

    public function loadSkill($skillId, $proId) {
        $where = [
            self::COL_SKILL_ID." = $skillId",
            self::COL_PROFESSIONAL_ID." = $proId"
        ];

        $data = $this->retrieveAll(
            self::SKILL_VIEW, $where,
            '*', false, false,
            self::COL_NAME
        );

        if (count($data) == 0) return null;

        return $this->skillByAssoc($data[0]);
    }

    public function incrementSkill($tempSkill) {
        $where = [self::COL_ID." = ".$tempSkill->skillId];

        $this->increment(
            self::TMP_SKILL_TABLE,
            self::COL_ENTRY_COUNT,
            1,
            $where
        );
    }

    public function saveSkill($skill) {
        $values = [
            self::COL_SKILL_ID => $skill->skillId,
            self::COL_PROFESSIONAL_ID => $skill->professionalId,
            self::COL_PERCENT => $skill->percentage,
            self::COL_VISIBLE => $skill->visible ? 1 : 0
        ];

        $this->insert(self::SKILL_PROFESSIONAL_TABLE, $values);
    }

    public function updateSkill($skill) {
        $values = [
            self::COL_PERCENT => $skill->percentage,
            self::COL_VISIBLE => $skill->visible ? 1 : 0
        ];

        $where = [
            self::COL_PROFESSIONAL_ID." = ".$skill->professionalId,
            self::COL_SKILL_ID." = ".$skill->skillId
        ];

        $this->update(self::SKILL_PROFESSIONAL_TABLE, $values, $where);
    }

    public function deleteSkill($skill) {
        $where = [
            self::COL_SKILL_ID." = $skill->skillId",
            self::COL_PROFESSIONAL_ID." = $skill->professionalId"
        ];

        $this->delete(self::SKILL_PROFESSIONAL_TABLE, $where);
    }

    private function skillListByAssoc($assoc) {
        $list = array();

        foreach($assoc as $item) {
            $list[] = $this->skillByAssoc($item);
        }

        return $list;
    }

    private function skillByAssoc($assoc) {
        $skill = new Skill();

        $skill->skillId = $assoc[self::COL_SKILL_ID];
        $skill->professionalId = $assoc[self::COL_PROFESSIONAL_ID];
        $skill->name = $assoc[self::COL_NAME];
        $skill->percentage = $assoc[self::COL_PERCENT];
        $skill->visible = $assoc[self::COL_VISIBLE];

        return $skill;
    }

    private function tempSkillsListByAssoc($assoc) {
        $list = array();

        foreach($assoc as $item) {
            $list[] = $this->tempSkillsByAssoc($item);
        }

        return $list;
    }

    private function tempSkillsByAssoc($assoc) {
        $skill = new Skill();

        $skill->skillId = $assoc[self::COL_ID];
        $skill->name = $assoc[self::COL_NAME];
        $skill->entryCount = $assoc[self::COL_ENTRY_COUNT];

        return $skill;
    }

    private function confirmedSkillListByAssoc($assoc) {
        $list = array();

        foreach($assoc as $item) {
            $list[] = $this->confirmedSkillByAssoc($item);
        }

        return $list;
    }

    private function confirmedSkillByAssoc($assoc) {
        $skill = new Skill();

        $skill->skillId = $assoc[self::COL_ID];
        $skill->name = $assoc[self::COL_NAME];

        return $skill;
    }
}