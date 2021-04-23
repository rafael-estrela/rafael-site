<?php

class User {
    use BaseModel;

    private $id;
    private $email;
    private $password;
    private $confirmed;
    private $confirmationId;
}