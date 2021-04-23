<?php

class MessageUtil {
    public static function errorMessage($code) {
        switch ($code) {
            case UNEXISTENT_ACCOUNT:
                return ERR_UNEXISTENT_ACCOUNT;
            case PASSWORD_MATCH:
                return ERR_PASSWORD_MATCH;
            case PASSWORD_SHORT:
                return ERR_PASSWORD_SHORT;
            case INVALID_EMAIL:
                return ERR_INVALID_EMAIL;
            case EMAIL_MATCH:
                return ERR_EMAIL_MATCH;
            case FORGOT_LINK_FAIL:
                return ERR_FORGOT_LINK_FAIL;
            case ACC_CREATE_FAIL:
                return ERR_ACC_CREATE_FAIL;
            case INVALID_CONFIRM_ID:
                return ERR_INVALID_CONFIRM_ID;
            case INVALID_AUTHENTICATION:
                return ERR_INVALID_AUTHENTICATION;
            case INVALID_PROFILE_IMAGE:
                return ERR_INVALID_PROFILE_IMAGE;
            case INVALID_NAME:
                return ERR_INVALID_NAME;
            case INVALID_GRADUATION_TITLE:
                return ERR_GRAD_TITLE;
            case INVALID_GRADUATION_INSTITUTION:
                return ERR_GRAD_INST;
            case INVALID_GRADUATION_START: case INVALID_WORK_START:
                return ERR_START;
            case INVALID_GRADUATION_END: case INVALID_WORK_END:
                return ERR_END;
            case INVALID_DATE_ORDER:
                return ERR_DATE_ORDER;
            case INVALID_GRADUATION_IMAGE: case INVALID_WORK_IMAGE: case INVALID_PROJ_IMAGE:
                return ERR_IMG;
            case UNEXISTENT_GRAD:
                return ERR_UNEXISTENT_GRAD;
            case INVALID_WORK_POSITION:
                return ERR_WORK_POSITION;
            case INVALID_WORK_COMPANY:
                return ERR_WORK_COMPANY;
            case INVALID_WORK_DESCRIPTION:
                return ERR_WORK_DESC;
            case UNEXISTENT_WORK:
                return ERR_UNEXISTENT_WORK;
            case INVALID_PROJ_NAME:
                return ERR_PROJ_NAME;
            case INVALID_PROJ_DESC:
                return ERR_PROJ_DESC;
            case INVALID_PROJ_TYPE:
                return ERR_PROJ_TYPE;
            case INVALID_PROJ_URL:
                return ERR_PROJ_URL;
            case INVALID_PROJ_IMAGE_DIMENS:
                return ERR_PROJ_IMG_DIMENS;
            case INVALID_CUSTOM_BASE_URL:
                return ERR_CUSTOM_BASE_URL;
            case INVALID_CUSTOM_TYPE:
                return ERR_CUSTOM_TYPE;
            case INVALID_CUSTOM_IMAGE:
                return ERR_CUSTOM_IMAGE;
            case UNEXISTENT_PROJ:
                return ERR_UNEXISTENT_PROJ;
            case INVALID_PERCENTAGE:
                return ERR_INVALID_PERCENTAGE;
            case INVALID_CATEGORY:
                return ERR_INVALID_CATEGORY;
            case INVALID_TECHNOLOGY:
                return ERR_INVALID_TECHNOLOGY;
            case INVALID_CUSTOM_CAT:
                return ERR_INVALID_CUSTOM_CAT;
            case INVALID_CUSTOM_TECH:
                return ERR_INVALID_CUSTOM_TECH;
            case INVALID_CUSTOM_COLOR:
                return ERR_INVALID_CUSTOM_COLOR;
            case UNEXISTENT_SKILL:
                return ERR_UNEXISTENT_SKILL;
            case INVALID_TRIVIA:
                return ERR_INVALID_TRIVIA;
            case INVALID_GREETINGS:
                return ERR_INVALID_GREETINGS;
            case INVALID_GOAL:
                return ERR_INVALID_GOAL;
            case INVALID_PHONE:
                return ERR_INVALID_PHONE;
            case INVALID_LINKEDIN:
                return ERR_INVALID_LINKEDIN;
            case INVALID_GIT:
                return ERR_INVALID_GIT;
            case INVALID_SITE:
                return ERR_INVALID_SITE;
            case INVALID_USERNAME:
                return ERR_INVALID_USERNAME;
            case TAKEN_USERNAME:
                return ERR_TAKEN_USERNAME;
            case OLD_PASSWORD_WRONG:
                return ERR_OLD_PASSWORD_WRONG;
            case INVALID_PALETTE:
                return ERR_INVALID_PALETTE;
            case MUST_CONFIRM:
                return ERR_MUST_CONFIRM;
            case RESEND_EMAIL_UNEXISTENT:
                return ERR_RESEND_EMAIL_UNEXISTENT;
            case RESEND_EMAIL_CONFIRMED:
                return ERR_RESEND_EMAIL_CONFIRMED;
            case UNKNOWN_ERROR:
                return ERR_UNKNOWN;
        }

        return "";
    }

    public static function successMessage($code) {
        switch ($code) {
            case FORGOT_LINK_SENT:
                return SUC_FORGOT_LINK_SENT;
            case ACCOUNT_CREATED:
                return SUC_REGISTRATION;
            case ACCOUNT_CONFIRMED:
                return SUC_CONFIRMATION;
            case ACCOUNT_EXISTS:
                return SUC_ACCOUNT_EXISTS;
            case GRAD_SAVED:
                return SUC_GRAD_SAVE;
            case GRAD_UPDATED:
                return SUC_GRAD_UPDATE;
            case GRAD_DELETED:
                return SUC_GRAD_DEL;
            case WORK_SAVED:
                return SUC_WORK_SAVE;
            case WORK_UPDATED:
                return SUC_WORK_UPDATE;
            case WORK_DELETED:
                return SUC_WORK_DEL;
            case PROJ_SAVED:
                return SUC_PROJ_SAVE;
            case PROJ_UPDATED:
                return SUC_PROJ_UPDATE;
            case PROJ_DELETED:
                return SUC_PROJ_DEL;
            case TRIVIA_SAVED:
                return SUC_TRIVIA_SAVE;
            case GREETINGS_SAVED:
                return SUC_GREETINGS_SAVE;
            case CONTACT_SAVED:
                return SUC_CONTACT_SAVE;
            case SKILL_SAVED:
                return SUC_SKILL_SAVED;
            case SKILL_UPDATED:
                return SUC_SKILL_UPDATED;
            case SKILL_DELETED:
                return SUC_SKILL_DELETED;
            case SETTINGS_SAVED:
                return SUC_SETTINGS_SAVED;
            case SETTINGS_PASSWORD_SAVED:
                return SUC_SETTINGS_PASSWORD_SAVED;
            case RESEND_EMAIL:
                return SUC_RESEND_EMAIL;
        }

        return "";
    }
}