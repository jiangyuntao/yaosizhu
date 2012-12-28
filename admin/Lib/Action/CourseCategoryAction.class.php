<?php
class CourseCategoryAction extends AppAction {
    protected $offset = 15;

    public function index() {
        $course_category  = D('CourseCategory');

        import('ORG.Util.Page');

        $condition = '';

        // 如果指定查询关键字
        if (isset($_GET['q'])) {
            $condition .= "title LIKE '%{$_GET['q']}%'";
            $this->data['q'] = $_GET['q'];
        }

        $course_category_count = $course_category->where($condition)->count('id');
        $page = new Page($course_category_count, $this->offset);
        if (isset($_GET['q'])) {
            $page->parameter = 'q=' . urlencode($_GET['q']);
        }

        $this->data['list'] = $course_category->where($condition)
            ->order('sortorder desc, id desc')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        $this->data['pagination'] = $page->show();

        $this->assign($this->data);
        $this->display();
    }

    public function create() {
        $course_category = D('CourseCategory');

        if ($this->isPost()) {
            if ($course_category->create() && $id = $course_category->add()) {
                // 根据 id 更新 sortorder
                $course_category->where("id='{$id}'")->save(array('sortorder' => $id));

                $this->assign('jumpUrl', U('/course_category/index'));
                return $this->success('创建成功');
            } else {
                $this->assign('jumpUrl', U('/course_category/create'));
                return $this->error('创建失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function modify() {
        $course_category = D('CourseCategory');
        $this->data['course_category'] = $course_category->find($_GET['id']);

        if ($this->isPost()) {
            if ($course_category->create() && $course_category->save()) {
                $this->assign('jumpUrl', U('/course_category/modify', 'id=' . $_GET['id']));
                return $this->success('修改成功');
            } else {
                return $this->error('修改失败');
            }
        }

        $this->assign($this->data);
        $this->display();
    }

    public function remove() {
        $course_category = D('CourseCategory');
        $category = $course_category->find($_GET['id']);

        if ($course_category->delete($_GET['id'])) {
            $this->picture_remove($category['picture']);
            $this->assign('jumpUrl', U('/course_category/index'));
            return $this->success('删除成功');
        } else {
            $this->assign('jumpUrl', U('/course_category/index/', $_SESSION['listpage']));
            return $this->error('删除失败' . $course_category->getError());
        }
    }

    /**
     * 重新排序
     *
     * @access public
     * @return void
     */
    public function resort() {
        if ($this->isAjax()) {
            $course_category = D('CourseCategory');

            $orders = json_decode($_POST['orders']);
            $ids = implode(',', $orders);
            $original_categories = $course_category->where("id in({$ids})")->order('sortorder desc, id desc')->select();

            foreach ($orders as $key => $id) {
                foreach ($original_categories as $category_key => $category) {
                    if ($key == $category_key && $id != $original_categories[$key]['id']) {
                        $data = array(
                            'sortorder' => $original_categories[$key]['sortorder']
                        );
                        $course_category->where("id='{$id}'")->save($data);
                        break;
                    }
                }
            }
        }
    }

    public function picture_upload() {
        if (!empty($_FILES)) {
            $tmp_file = $_FILES['Filedata']['tmp_name'];
            $ext = strtolower(substr(strrchr($_FILES['Filedata']['name'], '.'), 1));
            $target_path = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/' . date('Ym/d/');
            mkdir($target_path, 0777, true);
            $target_file =  str_replace('//', '/', $target_path) . md5($_FILES['Filedata']['name'] . microtime(true)) . '.' . $ext;

            // 后缀检查
            $allowed_ext = array('gif', 'bmp', 'jpg', 'jpeg', 'png');
            if (!in_array($ext, $allowed_ext)) {
                $this->ajaxReturn('', '请上传图片文件', 0);
            }

            move_uploaded_file($tmp_file, $target_file);

            // 缩放图片
            /**
            vendor('WideImage.WideImage');
            WideImage::load($target_file)
                ->resize($this->data['setting']['course_picture_width'], $this->data['setting']['course_picture_height'])
                ->saveToFile($target_file);
            /**/

            $this->ajaxReturn(array(
                'picture' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $target_file)
            ), '', 1);
        }
    }

    /**
     * 删除图片
     *
     * @access public
     * @return void
     */
    public function picture_remove($picture = '') {
        if (!$picture) {
            $picture = $_POST['picture'];
        }
        $picture = realpath('..') . $picture;

        if (file_exists($picture)) {
            @unlink($picture);
        }
    }
}
