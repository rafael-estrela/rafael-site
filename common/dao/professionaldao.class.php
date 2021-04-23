<?php

class ProfessionalDAO{
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    private const USER_TABLE = 'user';
    private const COL_PASSWORD = 'password';

    private const PROFESSIONAL_TABLE = 'professional';
    private const COL_PROFESSIONAL_USER_ID = 'professional_user_id';
    private const COL_USER_ID = 'user_id';

    private const ACCESS_TABLE = 'access_log';
    private const COL_ACCESS_DATE = 'access_date';

    private const ACCESS_VIEW = 'v_access_year';
    private const COL_YEAR = 'year';
    private const COL_MONTH = 'month';
    private const COL_TOTAL = 'total';

    private const PROFESSIONAL_VIEW = 'v_professional_user_dashboard';
    private const COL_ID = 'id';
    private const COL_EMAIL = 'email';
    private const COL_NAME = 'name';
    private const COL_USERNAME = 'username';
    private const COL_DESC = 'description';
    private const COL_GOAL = 'goal';
    private const COL_PHONE = 'phone';
    private const COL_GIT = 'github';
    private const COL_LINKEDIN = 'linkedin';
    private const COL_SITE = 'site';
    private const COL_PIC = 'picture';
    private const COL_ACCESS_COUNT = 'access_count';
    private const COL_PALETTE = 'palette';
    private const COL_PALETTE_ID = 'palette_id';

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function validateUserPass($id, $pass) {
        $where = [
            self::COL_ID." = $id",
            self::COL_PASSWORD." = $pass"
        ];

        return $this->count(self::USER_TABLE, $where) > 0;
    }

    public function updateUserPassword($id, $pass) {
        $where = [self::COL_ID." = $id"];

        $this->update(self::USER_TABLE, [self::COL_PASSWORD => $pass], $where);
    }

    public function userById($id) {
        $where = [self::COL_ID." = $id"];

        $rows = $this->retrieveAll(self::PROFESSIONAL_VIEW, $where);

        if (count($rows) == 0) return null;

        return $this->professionalByAssoc($rows[0]);
    }

    public function professionalResumeData($professional, $withLinks, $forDash = true) {
        $workDao = new WorkDAO($this->con);
        $gradDao = new GraduationDAO($this->con);
        $portfolioDao = new PortfolioDAO($this->con);
        $skillDao = new SkillDao($this->con);

        $professional->graduation = $gradDao->graduationListByProfessional($professional->id);
        $professional->workplaces = $workDao->workListByProfessional($professional->id);
        $professional->projects = $portfolioDao->projectListById($professional->id, $withLinks);
        $professional->skills = $skillDao->skillListById($professional->id, $forDash);
    }

    public function incrementAccessCount($id) {
        $where = [self::COL_ID." = $id"];

        $this->increment(self::PROFESSIONAL_VIEW, self::COL_ACCESS_COUNT, 1, $where);
    }

    public function accessHistory($userId) {
        $where = [self::COL_USER_ID." = $userId"];

        $data = $this->retrieveAll(self::ACCESS_VIEW, $where);

        if (count($data) == 0) return new Chart(true);

        return $this->accessHistoryByAssoc($data);
    }

    public function retrieveAccessCount($pro) {
        $lastMonth = $this->countDaysInterval(
            self::ACCESS_TABLE,
            self::COL_ACCESS_DATE,
            30, [self::COL_PROFESSIONAL_USER_ID." = $pro->id"]
        );

        $lastWeek = $this->countDaysInterval(
            self::ACCESS_TABLE,
            self::COL_ACCESS_DATE,
            7, [self::COL_PROFESSIONAL_USER_ID." = $pro->id"]
        );

        $where = [self::COL_ID.' = '.$pro->id];
        $content = [self::COL_ACCESS_COUNT];

        $value = $this->retrieveAll(self::PROFESSIONAL_VIEW, $where, $content);

        $pro->accessCount = $value[0][self::COL_ACCESS_COUNT];
        $pro->monthCount = $lastMonth;
        $pro->weekCount = $lastWeek;
    }

    public function updateDesc($professional) {
        $values = [self::COL_DESC => $professional->desc];
        $where = [self::COL_ID." = $professional->id"];

        $this->updateProfessional($values, $where);
    }

    public function updateGoal($professional) {
        $values = [self::COL_GOAL => $professional->goal];
        $where = [self::COL_ID." = $professional->id"];

        $this->updateProfessional($values, $where);
    }

    public function updatePhone($professional) {
        $values = [self::COL_PHONE => $professional->phone];
        $where = [self::COL_ID." = $professional->id"];

        $this->updateProfessional($values, $where);
    }

    public function updateLinkedIn($professional) {
        $values = [self::COL_LINKEDIN => $professional->linkedin];
        $where = [self::COL_ID." = $professional->id"];

        $this->updateProfessional($values, $where);
    }

    public function updateGit($professional) {
        $values = [self::COL_GIT => $professional->github];
        $where = [self::COL_ID." = $professional->id"];

        $this->updateProfessional($values, $where);
    }

    public function updateSite($professional) {
        $values = [self::COL_SITE => $professional->site];
        $where = [self::COL_ID." = $professional->id"];

        $this->updateProfessional($values, $where);
    }

    public function postRegistration($professional) {
        $values = [
            self::COL_USER_ID => $professional->id,
            self::COL_NAME => $professional->name,
            self::COL_PHONE => $professional->phone
        ];

        $this->insert(self::PROFESSIONAL_TABLE, $values);
    }

    public function updateProfessionalBySettings($professional) {
        $where = [self::COL_USER_ID." = $professional->id"];
        $values = [
            self::COL_USERNAME => $professional->username,
            self::COL_NAME => $professional->name,
            self::COL_PALETTE_ID => $professional->palette
        ];

        var_dump($values);

        $this->update(self::PROFESSIONAL_TABLE, $values, $where);
    }

    public function updateProfilePicUrl($fileName, $userId) {
        $where = [self::COL_ID." = $userId"];

        $this->update(self::PROFESSIONAL_VIEW, [self::COL_PIC => $fileName], $where);
    }

    public function professionalByUsername($username) {
        $where = [self::COL_USERNAME." LIKE $username"];

        $data = $this->retrieveAll(self::PROFESSIONAL_VIEW, $where);

        if (count($data) == 0) return null;

        return $this->professionalByAssoc($data[0]);
    }

    public function professionalByUsernameExceptMe($username, $userId) {
        $where = [
            self::COL_USERNAME." LIKE $username",
            self::COL_ID." <> $userId"
        ];

        $data = $this->retrieveAll(self::PROFESSIONAL_VIEW, $where);

        if (count($data) == 0) return null;

        return $this->professionalByAssoc($data[0]);
    }

    private function updateProfessional($values, $where) {
        $this->update(self::PROFESSIONAL_VIEW, $values, $where);
    }

    private function accessHistoryByAssoc($assoc) {
        $chart = new Chart();

        $structure = HistoryUtils::accessStructure($assoc);

        $chart->lastMonthsLabels = $structure[0];
        $chart->lastMonthsValues = $structure[1];

        return $chart;
    }

    private function professionalByAssoc($assoc) {
        $professional = new Professional();

        $professional->id = $assoc[self::COL_ID];
        $professional->name = $assoc[self::COL_NAME];
        $professional->username = $assoc[self::COL_USERNAME];
        $professional->desc = $assoc[self::COL_DESC];
        $professional->goal = $assoc[self::COL_GOAL];
        $professional->email = $assoc[self::COL_EMAIL];
        $professional->phone = $assoc[self::COL_PHONE];
        $professional->linkedin = $assoc[self::COL_LINKEDIN];
        $professional->site = $assoc[self::COL_SITE];
        $professional->github = $assoc[self::COL_GIT];
        $professional->picture = $assoc[self::COL_PIC];
        $professional->accessCount = $assoc[self::COL_ACCESS_COUNT];
        $professional->palette = $assoc[self::COL_PALETTE];

        return $professional;
    }
}