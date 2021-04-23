<?php

class WorkController {
    use ImageUploadController {
        ImageUploadController::__construct as private __iucConstruct;
    }

    private $work;
    private $workDao;

    public function __construct($connection) {
        $this->__iucConstruct(
            $connection,
            WORK_IMG_BASE_PATH,
            'w'
        );
    }

    public function getWork() {
        return $this->work;
    }

    public function setWork($work) {
        $this->work = $work;
    }

    public function getWorkById($id) {
        $this->validateWorkDao();

        $this->work = $this->workDao->workById($id, $this->userId);
    }

    public function saveWork($userId) {
        $this->validateWorkDao();

        $this->workDao->registerWork($this->work, $userId);

        $this->work->id = $this->lastSaved($userId);
    }

    public function updateWork() {
        $this->validateWorkDao();

        $this->workDao->updateWork($this->work, $this->userId);
    }

    public function deleteWork($id) {
        $this->validateWorkDao();

        $this->getWorkById($id);

        $this->workDao->deleteWork($id, $this->userId);

        $this->deleteFile($this->work->image);
    }

    public function isEditing() {
        return $this->work != null;
    }

    public function validDate($date) {
        $arrDate = explode('-', $date);

        return count($arrDate) == 3 && checkdate($arrDate[1], $arrDate[2], $arrDate[0]);
    }

    public function saveFile($tmpUrl) {
        $fileName = null;

        if ($tmpUrl != null) {
            $fileName = $this->regularFileName($this->work->id);

            $this->saveFileToDir($tmpUrl, $fileName);
        } else {
            $this->getWorkById($this->work->id);
            $this->deleteFile($this->work->image);
        }

        $this->updateFileUrl($fileName);
    }

    private function updateFileUrl($fileName) {
        $this->validateWorkDao();

        $this->workDao->updateFileUrl($fileName, $this->work->id, $this->userId);
    }

    private function lastSaved($userId) {
        $this->validateWorkDao();

        $workList = $this->workDao->workListByProfessional($userId, true);

        return end($workList)->id;
    }

    private function validateWorkDao() {
        if ($this->workDao == null)
            $this->workDao = new WorkDAO($this->connection);
    }
}