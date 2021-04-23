<?php

class PortfolioDAO {
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    private const PROJ_TABLE = 'project';
    private const COL_ID = 'id';
    private const COL_NAME = 'name';
    private const COL_DESC = 'description';
    private const COL_IMG = 'image';
    private const COL_BASE_URL = 'base_url';
    private const COL_VISIBLE = 'visible';

    private const TYPE_TABLE = 'project_type';

    private const COL_USER_ID = 'professional_user_id';
    private const LINK_VIEW = 'v_project_link_type';
    private const COL_PROJ_ID = 'project_id';
    private const COL_URL = 'url';
    private const COL_TYPE = 'type';
    private const COL_TYPE_ID = 'type_id';

    private const LINK_TABLE = 'project_link';

    private const COL_PROJ_TYPE_ID = 'project_type_id';

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function projectListById($professionalId, $withLinks, $byId = false) {
        $where = [self::COL_USER_ID." = $professionalId"];

        if ($byId) {
            $orderBy = self::COL_ID;
        } else {
            $orderBy = self::COL_NAME;
        }

        $data = $this->retrieveAll(
            self::PROJ_TABLE, $where,
            '*', false, false, $orderBy
        );

        return $this->projectListByAssoc($data, $withLinks);
    }

    public function projectById($projectId, $userId, $withLinks) {
        $where = [
            self::COL_ID." = $projectId",
            self::COL_USER_ID." = $userId"
        ];

        $data = $this->retrieveAll(self::PROJ_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->projectByAssoc($data[0], $withLinks);
    }

    public function projectLinksById($projectId) {
        $where = [self::COL_PROJ_ID." = $projectId"];

        return $this->retrieveAll(self::LINK_VIEW, $where);
    }

    public function registerProject($proj, $userId) {
        if ($userId == -1) return;

        $values = $this->valuesByModel($proj);
        $values[self::COL_USER_ID] = $userId;

        $this->insert(self::PROJ_TABLE, $values);
    }

    public function updateProject($proj, $userId) {
        $values = $this->valuesByModel($proj);
        $where = [
            self::COL_ID." = $proj->id",
            self::COL_USER_ID." = $userId"
        ];

        $this->update(self::PROJ_TABLE, $values, $where);
    }

    public function deleteProject($project, $userId) {
        $where = [
            self::COL_ID." = $project->id",
            self::COL_USER_ID." = $userId"
        ];

        $this->delete(self::PROJ_TABLE, $where);
    }

    public function deleteProjectLinks($project) {
        $where = [self::COL_PROJ_ID." = $project->id"];

        $this->delete(self::LINK_TABLE, $where);
    }

    public function updateFileUrl($url, $workId, $userId) {
        $where = [
            self::COL_ID." = $workId",
            self::COL_USER_ID." = $userId"
        ];

        $this->update(
            self::PROJ_TABLE,
            [self::COL_IMG => $url],
            $where
        );
    }

    public function projectTypeList($where = false) {
        $data = $this->retrieveAll(
            self::TYPE_TABLE, $where,
            '*', false, false, self::COL_NAME
        );

        return $this->typeListByAssoc($data);
    }

    public function locateType($name) {
        return $this->projectTypeList('LOWER('.self::COL_NAME.") LIKE $name");
    }

    public function projectTypeById($id) {
        $where = [self::COL_ID." = $id"];

        $data = $this->retrieveAll(self::TYPE_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->typeByAssoc($data[0]);
    }

    public function saveLink($link) {
        $values = $this->valuesByLink($link);
        $this->insert(self::LINK_TABLE, $values);
    }

    public function updateLink($link) {
        $where = [self::COL_ID." = $link->id", self::COL_PROJ_ID." = $link->projectId"];
        $this->update(self::LINK_TABLE, $this->valuesByLink($link), $where);
    }

    public function deleteLink($link) {
        $where = [self::COL_ID." = $link->id", self::COL_PROJ_ID." = $link->projectId"];
        $this->delete(self::LINK_TABLE, $where);
    }

    private function valuesByModel($proj) {
        $values = [
            self::COL_NAME => $proj->name,
            self::COL_DESC => $proj->description,
            self::COL_VISIBLE => $proj->visible ? 1 : 0
        ];

        if ($proj->image != null) $values[self::COL_IMG] = $proj->image;

        return $values;
    }

    private function valuesByType($type) {
        $values = [
            self::COL_NAME => $type->name,
            self::COL_IMG => $type->image,
            self::COL_BASE_URL => $type->baseUrl
        ];

        return $values;
    }

    private function valuesByLink($link) {
        $values = [
            self::COL_PROJ_ID => $link->projectId,
            self::COL_PROJ_TYPE_ID => $link->type->id,
            self::COL_URL => $link->url
        ];

        return $values;
    }

    private function projectListByAssoc($assoc, $withLinks) {
        $list = array();

        foreach($assoc as $item) {
            $list[] = $this->projectByAssoc($item, $withLinks);
        }

        return $list;
    }

    private function projectByAssoc($assoc, $withLinks) {
        $project = new Project();

        $project->id = $assoc[self::COL_ID];
        $project->name = $assoc[self::COL_NAME];
        $project->description = $assoc[self::COL_DESC];
        $project->image = $assoc[self::COL_IMG];
        $project->visible = $assoc[self::COL_VISIBLE];

        if ($withLinks) {
            $links = $this->projectLinksById($project->id);
            $project->links = $this->linkListByAssoc($links);
        }

        return $project;
    }

    private function typeListByAssoc($assoc) {
        $list = array();

        foreach($assoc as $item) {
            $list[] = $this->typeByAssoc($item);
        }

        return $list;
    }

    private function linkListByAssoc($assoc) {
        $list = array();

        foreach($assoc as $item) {
            $list[] = $this->linkByAssoc($item);
        }

        return $list;
    }

    private function linkByAssoc($assoc) {
        $link = new ProjectLink();

        $link->id = $assoc[self::COL_ID];
        $link->url = $assoc[self::COL_URL];
        $link->type = $this->typeByAssocFromView($assoc);
        $link->projectId = $assoc[self::COL_PROJ_ID];

        return $link;
    }

    private function typeByAssoc($assoc) {
        $type = new ProjectType();

        $type->id = $assoc[self::COL_ID];
        $type->name = $assoc[self::COL_NAME];
        $type->image = $assoc[self::COL_IMG];
        $type->baseUrl = $assoc[self::COL_BASE_URL];

        return $type;
    }

    private function typeByAssocFromView($assoc) {
        $type = new ProjectType();

        $type->id = $assoc[self::COL_TYPE_ID];
        $type->name = $assoc[self::COL_TYPE];
        $type->image = $assoc[self::COL_IMG];
        $type->baseUrl = $assoc[self::COL_BASE_URL];

        return $type;
    }
}