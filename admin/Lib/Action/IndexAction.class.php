<?php
class IndexAction extends AppAction {
    protected $offset = 15;

    public function index() {
        $channel  = D('Channel');

        import('ORG.Util.Page');

        $condition = '';

        // 如果指定查询关键字
        if (isset($_GET['q'])) {
            $condition .= " name LIKE '%{$_GET['q']}%' || url LIKE '%{$_GET['q']}%'";
            $this->data['q'] = $_GET['q'];
        }

        $channel_count = $channel->where($condition)->count('id');
        $page = new Page($channel_count, $this->offset);
        if (isset($_GET['q'])) {
            $page->parameter = 'q=' . urlencode($_GET['q']);
        }

        $this->data['list'] = $channel
            ->field("c.id id, c.name name, c.url url, c.deduction deduction, c.status status, c.created created, c.modified modified,
                    (SELECT COUNT(id) FROM record WHERE channel_id=c.id && redirected='1' && timeline BETWEEN " . strtotime(date('Y-m-d') . ' 00:00:00') . ' AND ' . strtotime(date('Y-m-d') . ' 23:59:59') . ") viewed")
            ->table('channel c')
            ->where($condition)
            ->order('id desc')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->data['pagination'] = $page->show();

        $this->assign($this->data);
        $this->display();
    }

    public function create() {
        $channel = D('Channel');

        if ($this->isPost()) {
            if ($channel->create() && $id = $channel->add()) {
                $this->assign('jumpUrl', U('/'));
                return $this->success('创建成功');
            } else {
                $this->assign('jumpUrl', U('/index/create'));
                return $this->error('创建失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function modify() {
        $channel = D('Channel');
        $this->data['channel'] = $channel->find($_GET['id']);

        if ($this->isPost()) {
            if ($channel->create() && $channel->save()) {
                $this->assign('jumpUrl', U('/index/modify', 'id=' . $_GET['id']));
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function remove() {
        $channel = D('Channel');

        if ($channel->delete($_GET['id'])) {
            $this->assign('jumpUrl', U('/'));
            return $this->success('删除成功');
        } else {
            $this->assign('jumpUrl', U('/', $_SESSION['listpage']));
            return $this->error('删除失败' . $channel->getError());
        }
    }
}
