<?php

class HomeController {
    use InternalController {
        InternalController::__construct as private __icConstruct;
    }

    public function __construct($connection) {
        $this->__icConstruct($connection);
    }

    public function refreshAccess() {
        $this->validateProfessionalDao();

        $this->professionalDao->retrieveAccessCount($this->professional);
    }

    public function updateAccessCount() {
        $this->validateProfessionalDao();

        $this->professionalDao->incrementAccessCount($this->professional->id);
    }

    public function getProfessionalByUsername($username) {
        $this->validateProfessionalDao();

        $this->professional = $this->professionalDao->professionalByUsername($username);
    }

    public function getAccessHistory() {
        $this->validateProfessionalDao();

        return $this->professionalDao->accessHistory($this->userId);
    }

    public function paletteNameById($id) {
        $paletteDao = new PaletteDao($this->connection);

        $palette = $paletteDao->paletteById($id);

        if ($palette == null) return 'autumn';

        return $palette->name;
    }

    function isEditing() { return false; }
}