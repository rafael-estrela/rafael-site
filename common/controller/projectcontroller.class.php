<?php

class ProjectController {
    use ImageUploadController {
        ImageUploadController::__construct as private __iucConstruct;
    }

    private $project;
    private $portfolioDao;

    public function __construct($connection) {
        $this->__iucConstruct(
            $connection,
            PROJ_IMG_BASE_PATH,
            'p'
        );
    }

    public function getProjectById($id) {
        $this->validatePortfolioDao();

        $this->project = $this->portfolioDao->projectById($id, $this->userId, true);
    }

    public function saveProject($userId) {
        $this->validatePortfolioDao();

        $this->portfolioDao->registerProject($this->project, $userId);

        if ($this->project->links != null) {
            $this->saveLinks();
        }

        $this->project->id = $this->lastSaved($userId);
    }

    public function updateProject() {
        $this->validatePortfolioDao();

        $this->portfolioDao->updateProject($this->project, $this->userId);
        $this->updateLinks();
    }

    public function deleteProject($id) {
        $this->validatePortfolioDao();

        $this->getProjectById($id);

        $this->portfolioDao->deleteProjectLinks($this->project);
        $this->portfolioDao->deleteProject($this->project, $this->userId);

        $this->deleteFile($this->project->image);
    }

    public function getProjectTypes() {
        $this->validatePortfolioDao();

        return array_map(
            function($type) {
                $type->image = ICON_BASE_PATH.$type->image;
                return $type;
            }, $this->portfolioDao->projectTypeList()
        );
    }

    public function getProject() {
        return $this->project;
    }

    public function setProject($project) {
        $this->project = $project;
    }

    public function isEditing() {
        return $this->project != null;
    }

    public function validDimensions($file) {
        $info = $file['tmp_name'];

        list($w, $h) = getimagesize($info);

        return $w == $h;
    }

    public function saveFile($tmpUrl) {
        $fileName = null;

        if ($tmpUrl != null) {
            $fileName = $this->regularFileName($this->project->id);

            $this->saveFileToDir($tmpUrl, $fileName);
        } else {
            $this->getProjectById($this->project->id);
            $this->deleteFile($this->project->image);
        }

        $this->updateFileUrl($fileName);
    }

    public function saveTempIcon($file) {
        $url = $this->resizeIfNeeded($file);

        if ($url == null) {
            $fileName = $this->tmpIconFileName();

            $path = TMP_IMG_BASE_PATH.$fileName;

            $this->saveToTemp($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path);

            return $path;
        }

        return $url;
    }

    public function updateFileUrl($fileName) {
        $this->validatePortfolioDao();

        $this->portfolioDao->updateFileUrl($fileName, $this->project->id, $this->userId);
    }

    public function lastSaved($userId) {
        $this->validatePortfolioDao();

        $portfolio = $this->portfolioDao->projectListById($userId, false, true);

        return end($portfolio)->id;
    }

    public function urlsByType($id) {
        $this->validatePortfolioDao();

        $type = $this->portfolioDao->projectTypeById($id);

        if ($type != null) {
            $type->image = ICON_BASE_PATH.$type->image;
        }

        return $type;
    }

    public function typeById($typeId) {
        $this->validatePortfolioDao();

        $data = $this->portfolioDao->projectTypeById($typeId);

        return $data;
    }

    private function saveLinks() {
        $projList = $this->portfolioDao->projectListById($this->userId, false, true);

        if (count($projList) == 0) return;

        $this->project->id = end($projList)->id;

        $links = $this->project->links;

        if ($links != null) {
            foreach($links as $link) {
                $link->projectId = $this->project->id;

                $this->portfolioDao->saveLink($link);
            }
        }
    }

    private function updateLinks() {
        $originalLinks = $this->portfolioDao->projectById($this->project->id, $this->userId, true)->links;

        $links = $this->project->links;

        $deletedLinks = array_udiff(
            $originalLinks, $links, function($old, $new) {
                return $old->id == $new->id ? 0 : -1 ;
            }
        );

        $newLinks = array_filter(
            $links, function($link) {
                return $link->id == null;
            }
        );

        $updatedLinks = array_filter(
            $links, function($link) {
                return $link->id != null;
            }
        );

        if ($originalLinks != null) {
            if ($links == null || count($links) == 0) {
                $deletedLinks = $originalLinks;
                $updatedLinks = [];
            }
        }

        $mapFunction = function($link) {
            $link->projectId = $this->project->id;
            return $link;
        };

        $mappedDeleted = array_map($mapFunction, $deletedLinks);
        $mappedNew = array_map($mapFunction, $newLinks);
        $mappedUpdated = array_map($mapFunction, $updatedLinks);

        foreach($mappedDeleted as $link) {
            $this->portfolioDao->deleteLink($link);
        }

        foreach($mappedUpdated as $link) {
            $this->portfolioDao->updateLink($link);
        }

        foreach ($mappedNew as $link) {
            $this->portfolioDao->saveLink($link);
        }
    }

    private function saveIcon($path, $name) {
        $currPath = $_SERVER['DOCUMENT_ROOT'].$path;
        $newPath = $_SERVER['DOCUMENT_ROOT'].ICON_BASE_PATH.$name;

        rename($currPath, $newPath);
    }

    private function tmpIconFileName() {
        return 'ic_t_'.date('Y-m-d-H:m:s').'.png';
    }

    private function validatePortfolioDao() {
        if ($this->portfolioDao == null)
            $this->portfolioDao = new PortfolioDAO(new PDOConnection());
    }

    private function resizeIfNeeded($file) {
        $info = $file['tmp_name'];

        list($w, $h) = getimagesize($info);

        if ($w == 50 && $h == 50) return null;

        $src = imagecreatefromstring(file_get_contents($info));
        $dst = imagecreatetruecolor(50, 50);

        imagealphablending($dst, false);
        imagesavealpha($dst,true);

        $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);

        imagefilledrectangle($dst, 0, 0, 50, 50, $transparent);

        imagecopyresampled(
            $dst, $src,
            0, 0,
            0, 0,
            50, 50,
            $w, $h
        );

        $fullName = TMP_IMG_BASE_PATH.$this->tmpIconFileName();

        imagedestroy($src);
        imagepng($dst, $_SERVER['DOCUMENT_ROOT'].$fullName);
        imagedestroy($dst);

        return $fullName;
    }
}