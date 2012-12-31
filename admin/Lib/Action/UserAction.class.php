<?php
class UserAction extends Action {
    protected $auth = array();
    protected $data = array();
    protected $offset = 15;

    public function __construct() {
        parent::__construct();

        load('extend');
        import('ORG.Crypt.Crypt');
        import('ORG.Util.Cookie');

        $this->assign('waitSecond', 2);
    }

    public function change_password() {
        $user = D('User');
        $this->data['user'] = $user->find($_POST['id']);

        if ($this->isPost()) {
            if (!$_POST['password_original']) {
                return $this->error('原密码错误');
            }

            if (strlen($_POST['password']) < 5) {
                return $this->error('密码至少5位');
            }

            if ($_POST['password'] != $_POST['password_repeat']) {
                return $this->error('两次输入的新密码不一致');
            }

            if ($user->encryptPassword($_POST['password_original']) != $user->password) {
                return $this->error('原密码错误');
            }

            $user->password = $user->encryptPassword($_POST['password']);
            $user->modified = time();

            if ($user->save()) {
                $this->assign('jumpUrl', U('/user/change_password'));
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function signout() {
        Cookie::delete('auth');
        $this->redirect('user/signin');
    }

    public function signin() {
        // 已登录用户，跳转到首页
        if (unserialize(Crypt::decrypt(COOKIE::get('auth'), C('SALT'), true))) {
            $this->redirect('/');
        }

        if ($this->isPost()) {
            $user = D('User');
            if (!$user->where("username='{$_POST['username']}'")->find()) {
                $this->assign('jumpUrl', U('user/signin'));
                return $this->error('登录失败！用户名错误');
            }
            if ($user->password != $user->encryptPassword($_POST['password'])) {
                $this->assign('jumpUrl', U('user/signin'));
                return $this->error('登录失败！密码错误');
            }
            if (!$user->is_admin) {
                $this->assign('jumpUrl', U('user/signin'));
                return $this->error('您不是管理员');
            }

            if (isset($_POST['remember'])) {
                Cookie::set('auth', Crypt::encrypt(serialize(array(
                    'id' => $user->id,
                    'username' => $user->username,
                )), C('SALT'), true), $_POST['remember']);
            } else {
                Cookie::set('auth', Crypt::encrypt(serialize(array(
                    'id' => $user->id,
                    'username' => $user->username,
                )), C('SALT'), true));
            }

            $user->signin_time = time();
            $user->signin_ip = get_client_ip();
            $user->save();

            $this->assign('jumpUrl', U('/index'));
            return $this->success('登录成功！');
        }

        $this->display();
    }

}
