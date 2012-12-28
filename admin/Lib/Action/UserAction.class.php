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

    public function index() {
        $this->data['auth'] = $this->auth = unserialize(Crypt::decrypt(COOKIE::get('auth'), C('SALT'), true));

        $user  = D('User');

        import('ORG.Util.Page');

        $condition = '';

        // 如果指定查询关键字
        if (isset($_GET['q'])) {
            $condition .= "username LIKE '%{$_GET['q']}%'";
            $this->data['q'] = $_GET['q'];
        }

        $user_count = $user->where($condition)->count('id');
        $page = new Page($user_count, $this->offset);
        if (isset($_GET['q'])) {
            $page->parameter = 'q=' . urlencode($_GET['q']);
        }

        $this->data['list'] = $user->where($condition)
            ->order('id desc')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->data['pagination'] = $page->show();

        $this->assign($this->data);
        $this->display();
    }

    public function create() {
        $this->data['auth'] = $this->auth = unserialize(Crypt::decrypt(COOKIE::get('auth'), C('SALT'), true));

        $user = D('User');

        if ($this->isPost()) {
            $_POST['password'] = $user->encryptPassword($_POST['password']);

            if ($user->create() && $id = $user->add()) {
                $this->assign('jumpUrl', U('/user/index'));
                return $this->success('创建成功');
            } else {
                $this->assign('jumpUrl', U('/user/create'));
                return $this->error('创建失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function modify() {
        $this->data['auth'] = $this->auth = unserialize(Crypt::decrypt(COOKIE::get('auth'), C('SALT'), true));

        $user = D('User');
        $this->data['user'] = $user->find($_GET['id']);

        if ($this->isPost()) {
            if ($user->where("id!='{$_GET['id']}' && username='{$_POST['username']}'")->count('id')) {
                return $this->error('该用户名已经存在');
            }

            if ($_POST['password']) {
                $_POST['password'] = $user->encryptPassword($_POST['password']);
            } else {
                $_POST['password'] = $this->data['user']['password'];
            }

            if ($user->create() && $user->save()) {
                $this->assign('jumpUrl', U('/user/modify', 'id=' . $_GET['id']));
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function remove() {
        $user = D('User');

        if ($user->delete($_GET['id'])) {
            $this->assign('jumpUrl', U('/user/index'));
            return $this->success('删除成功');
        } else {
            $this->assign('jumpUrl', U('/user/index/', $_SESSION['listpage']));
            return $this->error('删除失败' . $user->getError());
        }
    }

    public function change_password() {
        if ($this->isPost()) {
            if (!$_POST['password_original']) {
                return $this->error('原密码错误1');
            }

            if (strlen($_POST['password']) < 5) {
                return $this->error('密码至少5位');
            }

            if ($_POST['password'] != $_POST['password_repeat']) {
                return $this->error('两次输入的新密码不一致');
            }

            $user = D('User');
            $user->find($_GET['id']);

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
            $this->redirect('/index');
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
