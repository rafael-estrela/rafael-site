<?php

trait InternalController {
    use BaseController {
        BaseController::__construct as private __bcConstruct;
    }

    private $userId;
    private $professionalDao;
    private $professional;

    public function __construct($connection) {
        $this->__bcConstruct($connection);

        if (isset($_COOKIE[COOKIE_INDEX])) $this->userId = $_COOKIE[COOKIE_INDEX];
    }

    public function getProfessionalResume($withLinks, $forDash = true) {
        $this->validateProfessionalDao();

        $this->professionalDao->professionalResumeData($this->professional, $withLinks, $forDash);
    }

    public function getUserById() {
        $this->validateProfessionalDao();

        $this->professional = $this->professionalDao->userById($this->userId);
    }

    protected function validateProfessionalDao() {
        if ($this->professionalDao == null)
            $this->professionalDao = new ProfessionalDAO($this->connection);
    }

    public function getProfessional() {
        return $this->professional;
    }

    public function setProfessional($professional) {
        $this->professional = $professional;
    }

    public function getUserId() {
        return $this->userId;
    }

    abstract function isEditing();
}