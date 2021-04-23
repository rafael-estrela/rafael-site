<?php

include_once '../../common/resources/strings.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/homecontroller.class.php';
include_once '../../common/controller/triviacontroller.class.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/dao/graduationdao.class.php';
include_once '../../common/dao/workdao.class.php';
include_once '../../common/dao/portfoliodao.class.php';
include_once '../../common/dao/skilldao.class.php';
include_once '../../common/dao/triviadao.class.php';
include_once '../../common/dao/palettedao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/model/graduation.class.php';
include_once '../../common/model/work.class.php';
include_once '../../common/model/project.class.php';
include_once '../../common/model/projectlink.class.php';
include_once '../../common/model/projecttype.class.php';
include_once '../../common/model/skill.class.php';
include_once '../../common/model/trivia.class.php';
include_once '../../common/model/palette.class.php';
include_once '../../common/util/stringutils.class.php';
include_once '../../common/util/dateutils.class.php';
include_once '../../common/util/skillutil.class.php';
include_once '../../composer/vendor/autoload.php';
include_once '../../common/pdf/pdfbuilder.class.php';

// VALIDATE AUTH HEADERS
$con = new PDOConnection();

$controller = new HomeController($con);
$triviaController = new TriviaController($con);

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    if (empty($username)) {
        $code = 400;
    } else {
        $controller->getProfessionalByUsername($username);
        $triviaController->setProfessional($controller->getProfessional());

        if ($controller->getProfessional() == null) {
            $code = 400;
        } else {
            $controller->getProfessionalResume(true, false);
            $triviaController->loadTrivia($controller->getProfessional()->id);

            $pro = $controller->getProfessional();

            PDFBuilder::buildUserPdf($pro);
        }
    }

    return;
}