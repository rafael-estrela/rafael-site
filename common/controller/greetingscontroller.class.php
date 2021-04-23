<?php

class GreetingsController {
    use InternalController {
        InternalController::__construct as private __icConstruct;
    }

    private $greetings;
    private $goal;

    public function __construct($connection) {
        $this->__icConstruct($connection);
    }

    public function setGreetings($greetings) {
        $this->greetings = $greetings;
    }

    public function setGoal($goal) {
        $this->goal = $goal;
    }

    public function saveGreetings() {
        $this->validateProfessionalDao();

        $this->professionalDao->updateDesc($this->professional);
        $this->professionalDao->updateGoal($this->professional);
    }

    function isEditing() { return false; }
}