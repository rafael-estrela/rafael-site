<?php

class GraduationController {
    use ImageUploadController {
        ImageUploadController::__construct as private __iucConstruct;
    }

    private $graduation;
    private $graduationDao;

    public function __construct($connection) {
        $this->__iucConstruct(
            $connection,
            GRAD_IMG_BASE_PATH,
            'g'
        );
    }

    public function getGraduation() {
        return $this->graduation;
    }

    public function setGraduation($graduation) {
        $this->graduation = $graduation;
    }

    public function getGraduationById($id) {
        $this->validateGraduationDao();

        $this->graduation = $this->graduationDao->graduationById($id, $this->userId);
    }

    public function saveGraduation($userId) {
        $this->validateGraduationDao();

        $this->graduationDao->registerGraduation($this->graduation, $userId);

        $this->graduation->id = $this->lastSaved($userId);
    }

    public function updateGraduation() {
        $this->validateGraduationDao();

        $this->graduationDao->updateGraduation($this->graduation, $this->userId);
    }

    public function deleteGraduation($id) {
        $this->validateGraduationDao();

        $this->getGraduationById($id);

        $this->graduationDao->deleteGraduation($id, $this->userId);

        $this->deleteFile($this->graduation->image);
    }

    public function isEditing() {
        return $this->graduation != null;
    }

    public function validDate($date) {
        $arrDate = explode('-', $date);

        return count($arrDate) == 3 && checkdate($arrDate[1], $arrDate[2], $arrDate[0]);
    }

    public function saveFile($tmpUrl) {
        $fileName = null;

        if ($tmpUrl != null) {
            $fileName = $this->regularFileName($this->graduation->id);

            $this->saveFileToDir($tmpUrl, $fileName);
        } else {
            $this->getGraduationById($this->graduation->id);
            $this->deleteFile($this->graduation->image);
        }

        $this->updateFileUrl($fileName);
    }

    private function lastSaved($userId) {
        $this->validateGraduationDao();

        $gradList = $this->graduationDao->graduationListByProfessional($userId, true);

        return end($gradList)->id;
    }

    private function updateFileUrl($fileName) {
        $this->validateGraduationDao();

        $this->graduationDao->updateFileUrl($fileName, $this->graduation->id, $this->userId);
    }

    private function validateGraduationDao() {
        if ($this->graduationDao == null)
            $this->graduationDao = new GraduationDAO($this->connection);
    }
}