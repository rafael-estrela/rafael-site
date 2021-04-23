<?php

trait BaseModel{
    public function expose(){
        return get_object_vars($this);
    }

    public function toJson(){
        return json_encode($this->expose(), JSON_PRETTY_PRINT);
    }

    public function __construct(){
    }

    public function __destruct(){
    }

    public function __get($name){
        return $this->$name;
    }

    public function __set($name, $value){
        $this->$name = $value;
    }
}