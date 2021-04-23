<?php

class SkillController {
    use InternalController {
        InternalController::__construct as private __icConstruct;
    }

    private $skill;
    private $skillDao;

    public function __construct($connection) {
        $this->__icConstruct($connection);
    }

    public function getSkillsByName($skill) {
        $this->validateSkillDao();

        return $this->skillDao->skillListByName($skill);
    }

    public function mapSkill($name) {
        $treatedName = ucwords(strtolower($name));

        $this->validateSkillDao();

        return $this->skillDao->mapSkill($treatedName);
    }

    public function mappedSkill($skill) {
        $treatedName = ucwords(strtolower($skill));

        $this->validateSkillDao();

        return $this->skillDao->mappedSkillByName($treatedName);
    }

    public function getSkillById($id) {
        $this->validateSkillDao();

        $this->skill = $this->skillDao->loadSkill($id, $this->userId);
    }

    public function incrementSkill($tempSkill) {
        $this->validateSkillDao();

        $this->skillDao->incrementSkill($tempSkill);
    }

    public function saveSkill() {
        $this->validateSkillDao();

        $this->skill->professionalId = $this->userId;

        $this->skillDao->saveSkill($this->skill);
    }

    public function updateSkill() {
        $this->validateSkillDao();

        $this->skill->professionalId = $this->userId;

        $this->skillDao->updateSkill($this->skill);
    }

    public function deleteSkill($id = -1) {
        $oldId = -1;

        if ($id != -1) {
            $oldId = $this->skill->technologyId;
            $this->skill->technologyId = $id;
        }

        $this->validateSkillDao();

        $this->skill->professionalId = $this->userId;

        $this->skillDao->deleteSkill($this->skill);

        if ($oldId != -1) {
            $this->skill->technologyId = $oldId;
        }
    }

    public function isEditing() {
        return $this->skill != null;
    }

    public function getSkill() {
        return $this->skill;
    }

    public function setSkill($skill) {
        $this->skill = $skill;
    }

    private function validateSkillDao() {
        if ($this->skillDao == null)
            $this->skillDao = new SkillDao($this->connection);
    }
}