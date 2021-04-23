<?php

class TriviaController {
    use InternalController {
        InternalController::__construct as private __icConstruct;
    }

    private $trivia;
    private $triviaDao;

    public function __construct($connection) {
        $this->__icConstruct($connection);
        $this->trivia = array();
    }

    public function getTrivia() {
        return $this->trivia;
    }

    public function setTrivia($trivia) {
        $this->trivia = $trivia;
    }

    public function loadTrivia($id = null) {
        if ($id == null) $id = $this->userId;

        $this->validateTriviaDao();

        $this->trivia = $this->triviaDao->loadTrivia($id);

        if ($this->professional != null)
            $this->professional->trivia = $this->trivia;
    }

    public function saveTrivia($list) {
        $this->validateTriviaDao();

        $this->loadTrivia();

        $originalTrivia = $this->trivia;

        $deletedTrivia = array_udiff(
            $originalTrivia, $list, function($old, $new) {
                return $old->id == $new->id ? 0 : -1;
            }
        );

        $newTrivia = array_filter(
            $list, function($trivia) {
                return $trivia->id == null;
            }
        );

        $updatedTrivia = array_filter(
            $list, function($trivia) {
                return $trivia->id != null;
            }
        );

        if ($originalTrivia != null) {
            if ($list == null || count($list) == 0) {
                $deletedTrivia = $originalTrivia;
            }
        }

        $mapFunction = function($trivia) {
            $trivia->professionalId = $this->userId;
            return $trivia;
        };

        $mappedDeleted = array_map($mapFunction, $deletedTrivia);
        $mappedNew = array_map($mapFunction, $newTrivia);
        $mappedUpdated = array_map($mapFunction, $updatedTrivia);

        foreach($mappedNew as $trivia) {
            $this->triviaDao->saveTrivia($trivia);
        }

        foreach($mappedUpdated as $trivia) {
            $this->triviaDao->updateTrivia($trivia);
        }

        foreach($mappedDeleted as $trivia) {
            $this->triviaDao->deleteTrivia($trivia);
        }
    }

    private function validateTriviaDao() {
        if ($this->triviaDao == null)
            $this->triviaDao = new TriviaDao($this->connection);
    }

    public function isEditing() { return false; }
}