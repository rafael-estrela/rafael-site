<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/skillcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/skilldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/skill.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';

$controller = new SkillController(new PDOConnection());

if (isset($_COOKIE[COOKIE_INDEX])) {
    $userId = $_COOKIE[COOKIE_INDEX];

    if (isset($_SESSION[SESSION_PREFIX.$userId])) {
        $controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$userId]));
    } else {
        header('location:../login/');

        return;
    }
} else {
    header('location:../login/');

    return;
}

$baseErr = 'location:'.BASE_ADMIN_URL.'skill';

if (isset($_GET['del'])) {
    $id = $_GET['del'];

    $controller->getSkillById($id);

    if ($controller->getSkill() == null) {
        header('location:'.BASE_ADMIN_URL.'skill/err='.UNEXISTENT_SKILL);
    } else {
        $controller->deleteSkill();

        header('location:'.BASE_ADMIN_URL.'skill/suc='.SKILL_DELETED);
    }

    return;
}

if (isset($_POST['percent']) && isset($_POST['name'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $percent = filter_var($_POST['percent'], FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($name) || mb_strlen($name, 'utf8') > 100) {
        header($baseErr.'/err='.INVALID_TECHNOLOGY);

        return;
    } else if (!preg_match("/^0$|^[1-9][0-9]?$|^100$/", $percent)) {
        header($baseErr.'/err='.INVALID_PERCENTAGE);

        return;
    }

    $base = 'location:'.BASE_ADMIN_URL.'skill';
    $code = 0;

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        $mappedSkill = $controller->mappedSkill($name);

        if ($mappedSkill == null) {
            $newSkill = $controller->mapSkill($name);
            $id = $newSkill->skillId;
        } else {
            $id = $mappedSkill->skillId;

            if ($mappedSkill->entryCount < 15) {
                $controller->incrementSkill($mappedSkill);
            }
        }
    }

    $controller->getSkillById($id);

    if ($controller->getSkill() == null) {
        $baseErr = $baseErr.'/err=';
        $code = SKILL_SAVED;

        $controller->setSkill(new Skill());

        $controller->getSkill()->skillId = $id;
        $controller->getSkill()->percentage = $percent;
        $controller->getSkill()->visible = !isset($_POST['visible']);

        $controller->saveSkill();
    } else {
        $baseErr = $baseErr."/$id/err=";
        $base = $base.'/'.$id;
        $code = SKILL_UPDATED;

        $controller->getSkill()->percentage = $percent;
        $controller->getSkill()->visible = !isset($_POST['visible']);

        $controller->updateSkill();
    }

    header($base.'/suc='.$code);
} else header('location:'.BASE_ADMIN_URL.'skill/err='.UNKNOWN_ERROR);