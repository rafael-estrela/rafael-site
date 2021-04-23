<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public static function sendConfirmationEmail($cid, $email) {
        $body = self::confirmationEmailBody($cid);
        $altBody = self::confirmationEmailAltBody();

        return self::sendEmail(CONFIRMATION_EMAIL_SUBJECT, $body, $altBody, $email);
    }

    public static function sendResetPasswordEmail($cid, $email) {
        $body = self::resetPasswordEmailBody($cid);
        $altBody = self::resetPasswordEmailAltBody();

        return self::sendEmail(PASSWORD_RESET_EMAIL_SUBJECT, $body, $altBody, $email);
    }

    private static function confirmationEmailBody($cid) {
        $second = str_replace("clique aqui", '<a href="http://localhost'.BASE_ADMIN_URL.'confirm/'.$cid.'/">clique aqui</a>', CONFIRMATION_EMAIL_BODY_SECOND);

        $emailBody = '
            <table style="border: 1px; width: 100%; border-spacing: 0;">
                <tr>
                    <td style="padding: 10px 0; background-color: #9ea9f0; text-align: center">
                        <h1 style="font-family: \'Impact\', \'Charcoal\', sans-serif">'.CONFIRMATION_EMAIL_TITLE.'</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 60px; text-align: justify">
                        <p style="margin: 20px 0; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.CONFIRMATION_EMAIL_BODY_FIRST.'</p>
                        <p style="margin-bottom: 20px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.$second.'</p>
                        <p style="margin-bottom: 20px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.CONFIRMATION_EMAIL_BODY_BYE.'</p>
                        <p style="margin-bottom: 20px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.EMAIL_BODY_SENDER.'</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; background-color: #a773c3; text-align: center; color: white; font-family: \'Impact\', \'Charcoal\', sans-serif; font-size: 1.5em">'.EXT_TITLE.', '.date('Y').'</td>
                </tr>
            </table>';

        return $emailBody;
    }

    private static function resetPasswordEmailBody($cid) {
        $first = str_replace("esse link", '<a href="http://localhost'.BASE_ADMIN_URL.'resetPassword/'.$cid.'/">esse link</a>', PASSWORD_RESET_EMAIL_BODY_FIRST);

        $emailBody = '
            <table style="border: 1px; width: 100%; border-spacing: 0;">
                <tr>
                    <td style="padding: 10px 0; background-color: #9ea9f0; text-align: center">
                        <h1 style="font-family: \'Impact\', \'Charcoal\', sans-serif">'.PASSWORD_RESET_EMAIL_TITLE.'</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 60px; text-align: justify">
                        <p style="margin: 20px 0; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.$first.'</p>
                        <p style="margin-bottom: 20px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.PASSWORD_RESET_EMAIL_BODY_BYE.'</p>
                        <p style="margin-bottom: 20px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; font-size: 1.2em">'.EMAIL_BODY_SENDER.'</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; background-color: #a773c3; text-align: center; color: white; font-family: \'Impact\', \'Charcoal\', sans-serif; font-size: 1.5em">'.EXT_TITLE.', '.date('Y').'</td>
                </tr>
            </table>';

        return $emailBody;
    }

    private static function confirmationEmailAltBody() {
        $emailBody = CONFIRMATION_EMAIL_TITLE."\n\n".
                    CONFIRMATION_EMAIL_BODY_FIRST."\n".
                    CONFIRMATION_EMAIL_BODY_SECOND."\n".
                    CONFIRMATION_EMAIL_BODY_BYE."\n\n".
                    EMAIL_BODY_SENDER."\n\n\n".
                    EXT_TITLE.', '.date('Y');

        return $emailBody;
    }

    private static function resetPasswordEmailAltBody() {
        $emailBody = PASSWORD_RESET_EMAIL_TITLE."\n\n".
            PASSWORD_RESET_EMAIL_BODY_FIRST."\n".
            PASSWORD_RESET_EMAIL_BODY_BYE."\n\n".
            EMAIL_BODY_SENDER."\n\n\n".
            EXT_TITLE.', '.date('Y');

        return $emailBody;
    }

    private static function sendEmail($title, $body, $altBody, $destination) {
        $headers = "MIME-Version: 1.1\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= "X-Priority: 1\n";
        $headers .= "From: T.Indica <".EMAIL_SENDER.">\n";

        $sent = false;
        $trials = 0;

        while(!$sent && $trials < 3) {
            $sent = mail($destination, $title, $body, $headers, "-r".EMAIL_SENDER);
            $trials++;
        }

        return $sent;
        /*$mailer = new PHPMailer(true);

        try {
            $mailer->setLanguage('pt_br', '../mailer/language/');
            $mailer->isSMTP();
            $mailer->CharSet = 'UTF-8';
            $mailer->Host = SMTP_HOST;
            $mailer->SMTPAuth = true;
            $mailer->Username = EMAIL_SENDER;
            $mailer->Password = EMAIL_PASSWORD;

            $mailer->From = EMAIL_SENDER;
            $mailer->FromName = EMAIL_SENDER_NAME;

            $mailer->addAddress($destination);

            $mailer->isHTML(true);

            $mailer->Subject = $title;
            $mailer->Body = $body;
            $mailer->AltBody = $altBody;

            $mailer->send();

            $mailer->clearAllRecipients();
        } catch (Exception $e) {
            echo $e;
        }*/
    }
}