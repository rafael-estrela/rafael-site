<?php

class PostRegistrationController {
    use ImageUploadController {
        ImageUploadController::__construct as private __iucConstruct;
    }

    private $userDao;

    public function __construct($connection) {
        $this->__iucConstruct($connection, PROFILE_IMG_BASE_PATH, 'profile');
    }

    public function saveProfessional() {
        $this->validateProfessionalDao();

        $this->professional->id = $this->userId;

        $this->professionalDao->postRegistration($this->professional);
    }

    public function updateProfessional() {
        $this->validateProfessionalDao();

        $this->professional->id = $this->userId;

        $this->professionalDao->updateProfessionalBySettings($this->professional);
    }

    public function saveFile($tmpUrl) {
        $fileName = null;

        if ($tmpUrl != null) {
            $fileName = $this->regularFileName($this->userId);

            $this->saveFileToDir($tmpUrl, $fileName);
        }

        $this->professional->picture = $fileName;

        $this->updateFileUrl($fileName);
    }

    public function usernameIsTaken($username) {
        $this->validateProfessionalDao();

        return $this->professionalDao->professionalByUsernameExceptMe($username, $this->userId) != null;

    }

    public function matchUserPassword($oldPassword) {
        $this->validateProfessionalDao();

        return $this->professionalDao->validateUserPass($this->userId, $oldPassword);
    }

    public function updateUserPassword($newPassword) {
        $this->validateProfessionalDao();

        $this->professionalDao->updateUserPassword($this->userId, $newPassword);
    }

    public function getColorPalettes() {
        $paletteDao = new PaletteDao($this->connection);
        return $paletteDao->getColorPalettes();
    }

    private function updateFileUrl($fileName) {
        $this->validateProfessionalDao();

        $this->professionalDao->updateProfilePicUrl($fileName, $this->userId);
    }

    private function lastSaved($userId) { return null; }

    private function isEditing() { return false; }

    private function regularFileName($id) {
        $date = date('Y-m-d-H:m:s');

        return $this->prefix."_$id"."_$date.jpg";
    }
}