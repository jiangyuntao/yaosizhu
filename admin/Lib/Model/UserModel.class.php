<?php
class UserModel extends AppModel {
    public function encryptPassword($password = '') {
        import('ORG.Crypt.Crypt');
        return md5(Crypt::encrypt($password, C('SALT'), true));
    }
}
