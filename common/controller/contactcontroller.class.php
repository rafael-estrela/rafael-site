<?php

class ContactController {
    use InternalController {
        InternalController::__construct as private __icConstruct;
    }

    function saveContact() {
        $this->validateProfessionalDao();

        $this->professionalDao->updatePhone($this->professional);
        $this->professionalDao->updateLinkedIn($this->professional);
        $this->professionalDao->updateGit($this->professional);
        $this->professionalDao->updateSite($this->professional);
    }

    function isEditing() { return false; }
}