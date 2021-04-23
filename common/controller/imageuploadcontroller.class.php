<?php

trait ImageUploadController {
    use InternalController {
        InternalController::__construct as private __icConstruct;
    }

    protected $basePath;
    protected $prefix;

    public function __construct($connection, $basePath, $prefix) {
        $this->__icConstruct($connection);

        $this->basePath = $basePath;
        $this->prefix = $prefix;
    }

    public function validFile($file) {
        return in_array($file['type'], ['image/jpg', 'image/jpeg', 'image/png']);
    }

    public function saveFileToDir($tmpUrl, $fileName) {
        $path = $_SERVER['DOCUMENT_ROOT'].$this->basePath.$fileName;
        $this->saveToDir($_SERVER['DOCUMENT_ROOT'].$tmpUrl, $path);
    }

    public function saveTempFile($file) {
        $fileName = $this->tempFileName();

        $path = TMP_IMG_BASE_PATH.$fileName;

        $this->saveToTemp($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path);

        return $path;
    }

    private function saveToDir($currPath, $newPath) {
        rename($currPath, $newPath);
    }

    private function saveToTemp($currPath, $newPath) {
        move_uploaded_file($currPath, $newPath);
    }

    private function regularFileName($id) {
        $userId = $_COOKIE[COOKIE_INDEX];
        $date = date('Y-m-d-H:m:s');

        return $this->prefix."_$id"."_u_$userId"."_$date.jpg";
    }

    private function tempFileName() {
        $userId = $_COOKIE[COOKIE_INDEX];
        return $this->prefix."_tmp_u_$userId".'_'.date('Y-m-d-H:m:s').'.jpg';
    }

    protected function deleteFile($fileName) {
        $name = $_SERVER['DOCUMENT_ROOT'].$this->basePath.$fileName;

        if (file_exists($name))
            unlink($name);
    }

    abstract function saveFile($tmpUrl);
    abstract function updateFileUrl($fileName);
    abstract function lastSaved($userId);
}