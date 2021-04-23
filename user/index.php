<?php session_start();

include_once '../common/resources/strings.php';

if (!isset($_GET['username'])) {
    include_once 'view/user-filter.php';
} else {
    include_once '../common/controller/basecontroller.class.php';
    include_once '../common/controller/internalcontroller.class.php';
    include_once '../common/controller/homecontroller.class.php';
    include_once '../common/controller/triviacontroller.class.php';
    include_once '../common/connection/pdoconnection.class.php';
    include_once '../common/dao/basedao.class.php';
    include_once '../common/dao/professionaldao.class.php';
    include_once '../common/dao/graduationdao.class.php';
    include_once '../common/dao/workdao.class.php';
    include_once '../common/dao/portfoliodao.class.php';
    include_once '../common/dao/skilldao.class.php';
    include_once '../common/dao/triviadao.class.php';
    include_once '../common/dao/palettedao.class.php';
    include_once '../common/model/basemodel.class.php';
    include_once '../common/model/professional.class.php';
    include_once '../common/model/graduation.class.php';
    include_once '../common/model/work.class.php';
    include_once '../common/model/project.class.php';
    include_once '../common/model/projectlink.class.php';
    include_once '../common/model/projecttype.class.php';
    include_once '../common/model/skill.class.php';
    include_once '../common/model/trivia.class.php';
    include_once '../common/model/palette.class.php';
    include_once '../common/util/stringutils.class.php';
    include_once '../common/util/dateutils.class.php';
    include_once '../common/util/skillutil.class.php';

    $con = new PDOConnection();

    $controller = new HomeController($con);
    $triviaController = new TriviaController($con);

    $username = $_GET['username'];

    if (empty($username)) {
        include_once 'view/user-filter.php';
    } else {
        $controller->getProfessionalByUsername($username);
        $triviaController->setProfessional($controller->getProfessional());

        if ($controller->getProfessional() == null) {
            $error = $username;
            include_once 'view/user-filter.php';
        } else {
            if (!isset($_COOKIE[COOKIE_INDEX]) || !isset($_SESSION[SESSION_PREFIX . $_COOKIE[COOKIE_INDEX]])) {
                $controller->updateAccessCount();
            }

            $controller->getProfessionalResume(true, false);
            $triviaController->loadTrivia($controller->getProfessional()->id);

            $pro = $controller->getProfessional();

            include_once 'view/user-content.php';
        }
    }
}
