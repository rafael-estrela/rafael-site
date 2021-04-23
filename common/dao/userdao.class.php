<?php

class UserDAO{
    use BaseDAO {
        BaseDAO::__construct as private __bdConstruct;
    }

    private const USER_TABLE = 'user';
    private const COL_ID = 'id';
    private const COL_EMAIL = 'email';
    private const COL_PASSWORD = 'password';
    private const COL_CONFIRMED = 'confirmed';
    private const COL_CONFIRMATION_ID = 'confirmation_id';
    private const COL_RESET_PASSWORD_ID = 'reset_password_id';

    public function __construct($con) {
        $this->__bdConstruct($con);
    }

    public function accountExists($email) {
        $where = [self::COL_EMAIL." LIKE $email"];

        return $this->count(self::USER_TABLE, $where) > 0;
    }

    public function accountByEmail($email) {
        $where = [self::COL_EMAIL." LIKE $email"];

        $data = $this->retrieveAll(self::USER_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->idByAssoc($data[0]);
    }

    public function fullAccountByEmail($email) {
        $where = [self::COL_EMAIL." LIKE $email"];

        $data = $this->retrieveAll(self::USER_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->accountByAssoc($data[0]);
    }

    public function accountByPasswordCid($cid) {
        $where = [self::COL_RESET_PASSWORD_ID." = $cid"];

        $data = $this->retrieveAll(self::USER_TABLE, $where);

        if (count($data) == 0) return null;

        return $this->idByAssoc($data[0]);
    }

    public function saveResetPasswordCode($userId, $cid) {
        $where = [self::COL_ID." = $userId"];

        $this->update(self::USER_TABLE, [self::COL_RESET_PASSWORD_ID => $cid], $where);
    }

    public function createAccount($email, $password) {
        $confirmationId = RegistrationUtil::confirmationId($email);

        $this->insert(
            self::USER_TABLE, [
                self::COL_EMAIL => $email,
                self::COL_PASSWORD => $password,
                self::COL_CONFIRMATION_ID => $confirmationId
            ]
        );
    }

    public function confirmUser($confirmationId) {
        $where = [self::COL_CONFIRMATION_ID." = $confirmationId"];

        $amount = $this->count(self::USER_TABLE, $where);

        if ($amount == 0) {
            return INVALID_CONFIRM_ID;
        } else {
            $this->update(
                self::USER_TABLE, [
                    self::COL_CONFIRMED => true,
                    self::COL_CONFIRMATION_ID => null,
                ], $where
            );

            return ACCOUNT_CONFIRMED;
        }
    }

    public function updateUserPassword($cid, $newPass) {
        $where = [self::COL_RESET_PASSWORD_ID." = $cid"];

        $amount = $this->count(self::USER_TABLE, $where);

        if ($amount == 0) {
            return INVALID_CONFIRM_ID;
        } else {
            $this->update(
                self::USER_TABLE, [
                    self::COL_PASSWORD => $newPass,
                    self::COL_RESET_PASSWORD_ID => null,
                ], $where
            );

            return ACCOUNT_CONFIRMED;
        }
    }

    public function login($email, $password) {
        $where = [
            self::COL_EMAIL." LIKE $email",
            self::COL_PASSWORD." LIKE $password"
        ];

        $select = [self::COL_ID, self::COL_CONFIRMATION_ID];

        $account = $this->retrieveAll(self::USER_TABLE, $where, $select);

        if (count($account) == 0) {
            return -1;
        }

        $assoc = $account[0];

        if ($assoc[self::COL_CONFIRMATION_ID] == null) {
            return $this->idByAssoc($account[0]);
        }

        return -2;
    }

    private function idByAssoc($assoc) {
        return $assoc[self::COL_ID];
    }

    private function accountByAssoc($assoc) {
        $account = new User();

        $account->id = $assoc[self::COL_ID];
        $account->email = $assoc[self::COL_EMAIL];
        $account->confirmed = $assoc[self::COL_CONFIRMED];
        $account->confirmationId = $assoc[self::COL_CONFIRMATION_ID];

        return $account;
    }
}