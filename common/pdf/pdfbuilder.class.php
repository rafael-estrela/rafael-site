<?php

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;

class PDFBuilder {
    public static function buildUserPdf($professional) {
        try {
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'orientation' => 'P'
            ]);

            self::css($mpdf);
            self::personalData($professional, $mpdf);
            self::graduationData($professional, $mpdf);
            self::experienceData($professional, $mpdf);
            self::skillsData($professional, $mpdf);
            //self::triviaData($professional, $mpdf);

            $mpdf->Output("resume_$professional->username.pdf", Destination::DOWNLOAD);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param Mpdf $mpdf
     * @throws MpdfException
     */
    private static function css(Mpdf $mpdf) {
        $css = file_get_contents($_SERVER['DOCUMENT_ROOT'].BASE_COMMON_URL.'css/custom/pdf.css');

        $mpdf->WriteHTML($css, HTMLParserMode::HEADER_CSS);
    }

    /**
     * @param $professional
     * @param Mpdf $mpdf
     * @throws MpdfException
     *
     */
    private static function personalData($professional, Mpdf $mpdf) {
        $mpdf->WriteHTML("<div class=\"content\">", HTMLParserMode::DEFAULT_MODE, true, false);
            $mpdf->WriteHTML("<div class=\"personalData\">", HTMLParserMode::DEFAULT_MODE, false, false);
                $mpdf->WriteHTML("<div class=\"nameContainer\">", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<h1>$professional->name</h1>", HTMLParserMode::DEFAULT_MODE, false, false);
                $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
                $mpdf->WriteHTML("<div class=\"contactContainer\">", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<p><strong>E-mail: </strong>$professional->email</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML('<p><strong>Telefone: </strong>'.StringUtils::mask($professional->phone, "## #####-#####").'</p>', HTMLParserMode::DEFAULT_MODE, false, false);
                $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
            $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);

            $mpdf->WriteHTML("<h2>Objetivo</h2>", HTMLParserMode::DEFAULT_MODE, false, false);
            $mpdf->WriteHTML("<p>$professional->goal</p>", HTMLParserMode::DEFAULT_MODE, false, false);
        $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, true);
    }

    /**
     * @param $professional
     * @param Mpdf $mpdf
     * @throws MpdfException
     */
    private static function graduationData($professional, Mpdf $mpdf) {
        if (count($professional->graduation) == 0) return;

        $mpdf->WriteHTML("<div class=\"content\">", HTMLParserMode::DEFAULT_MODE, true, false);
            $mpdf->WriteHTML("<h2>Formação acadêmica</h2>", HTMLParserMode::DEFAULT_MODE, false, false);

            $mpdf->WriteHTML("<div>", HTMLParserMode::DEFAULT_MODE, false, false);
                foreach (array_filter($professional->graduation, function ($v) { return $v->visible; }) as $grad) {
                    $start = DateUtils::dbToPdf($grad->startPeriod);
                    $end = $grad->endPeriod == null ? 'Atualmente' : DateUtils::dbToPdf($grad->endPeriod);

                    $mpdf->WriteHTML("<div>", HTMLParserMode::DEFAULT_MODE, false, false);
                        $mpdf->WriteHTML("<hr>", HTMLParserMode::DEFAULT_MODE, false, false);
                        $mpdf->WriteHTML("<p class=\"title\">$grad->title</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                        $mpdf->WriteHTML("<p>$grad->institution</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                        $mpdf->WriteHTML("<p>$start - $end</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
                }
            $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
        $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, true);
    }

    /**
     * @param $professional
     * @param Mpdf $mpdf
     * @throws MpdfException
     */
    private static function experienceData($professional, Mpdf $mpdf) {
        if (count($professional->workplaces) == 0) return;

        $mpdf->WriteHTML("<div class=\"content\">", HTMLParserMode::DEFAULT_MODE, true, false);
            $mpdf->WriteHTML("<h2>Experiência profissional</h2>", HTMLParserMode::DEFAULT_MODE, false, false);

            $mpdf->WriteHTML("<div>", HTMLParserMode::DEFAULT_MODE, false, false);
            foreach (array_filter($professional->workplaces, function ($v) { return $v->visible; }) as $work) {
                $start = DateUtils::dbToPdf($work->startPeriod);
                $end = $work->endPeriod == null ? 'Atualmente' : DateUtils::dbToPdf($work->endPeriod);

                $mpdf->WriteHTML("<div>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<hr>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<p class=\"title\">$work->position</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<p>$work->company</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<p>$work->description</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<p>$start - $end</p>", HTMLParserMode::DEFAULT_MODE, false, false);
                $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
            }
            $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
        $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, true);
    }

    /**
     * @param $professional
     * @param Mpdf $mpdf
     * @throws MpdfException
     */
    private static function skillsData($professional, Mpdf $mpdf) {
        if (count($professional->skills) == 0) return;

        $mpdf->WriteHTML("<div class=\"content\">", HTMLParserMode::DEFAULT_MODE, true, false);
            $mpdf->WriteHTML("<h2>Conhecimento Técnico</h2>", HTMLParserMode::DEFAULT_MODE, false, false);
            $mpdf->WriteHTML("<hr>", HTMLParserMode::DEFAULT_MODE, false, false);

            $filteredSkills = array_filter($professional->skills, function ($v) { return $v->visible; });

            $mpdf->WriteHTML("<div>", HTMLParserMode::DEFAULT_MODE, false, false);
                foreach ($filteredSkills as $skill) {
                    $mpdf->WriteHTML("<div class=\"skill\">", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("<p>$skill->name - <span class=\"stars\">".SkillUtil::percentToStars($skill->percentage)."</span></p>", HTMLParserMode::DEFAULT_MODE, false, false);
                    $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
                }
            $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, false);
        $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, true);
    }

    /**
     * @param $professional
     * @param Mpdf $mpdf
     * @throws MpdfException
     */
    private static function triviaData($professional, Mpdf $mpdf) {
        if (count($professional->trivia) == 0) return;

        $mpdf->WriteHTML("<div class=\"content\">", HTMLParserMode::DEFAULT_MODE, true, false);
            $mpdf->WriteHTML("<h2>Informações adicionais</h2>", HTMLParserMode::DEFAULT_MODE, false, false);

            foreach ($professional->trivia as $info) {
                $mpdf->WriteHTML("<p>&bull; $info->value.</p>", HTMLParserMode::DEFAULT_MODE, false, false);
            }
        $mpdf->WriteHTML("</div>", HTMLParserMode::DEFAULT_MODE, false, true);
    }
}