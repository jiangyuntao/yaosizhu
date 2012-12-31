<?php
class IndexAction extends Action {
    public function index() {
        // 默认跳转网址
        $default_url = 'http://www.baidu.com';

        // 通过 http://yaosizhu/?id=xxxx 传递过来的值
        $channel_id = intval($_GET['id']);

        $chanel = D('Channel');

        if (!($channel_data = $chanel->find($channel_id)) || !$channel_data['status']) {
            // 如果渠道商 ID 不存在，或者状态为停用，跳转到默认页面
            redirect($default_url);
            return;

        } else {
            // 当天的时间区间
            $today_sql = strtotime(date('Y-m-d') . ' 00:00:00') . ' AND ' . strtotime(date('Y-m-d') . ' 23:59:59');

            // 扣量
            $deduction = (int) ($channel_data['deduction'] * 100);

            $record = D('Record');

            // 最后一条记录
            $last_record = $record->order('id desc')->find();

            // 若干查询用来确定是否扣量
            $last_redirected = $record->query("
                SELECT id
                FROM __TABLE__
                WHERE id>(SELECT MAX(id) FROM __TABLE__ WHERE redirected='0')
                    && redirected='1' && timeline BETWEEN {$today_sql}
                ORDER BY id ASC
            ");
            $last_unredirected = $record->query("
                SELECT id
                FROM __TABLE__
                WHERE id>(SELECT MAX(id) FROM __TABLE__ WHERE redirected='1')
                    && redirected='0' && timeline BETWEEN {$today_sql}
                ORDER BY id ASC
            ");
            if (!$last_redirected) {
                $last_redirected = $record->query("
                    SELECT id
                    FROM __TABLE__
                    WHERE id>=(SELECT MAX(id) FROM __TABLE__ WHERE id<'{$last_unredirected[0]['id']}' && redirected='0')
                        && redirected='1' && timeline BETWEEN {$today_sql}
                    ORDER BY id ASC
                ");
            }
            if (!$last_unredirected) {
                $last_unredirected = $record->query("
                    SELECT id
                    FROM __TABLE__
                    WHERE id>=(SELECT MAX(id) FROM __TABLE__ WHERE id<'{$last_unredirected[0]['id']}' && redirected='1')
                        && redirected='0' && timeline BETWEEN {$today_sql}
                    ORDER BY id ASC
                ");
            }
            $last_redirected_count = count($last_redirected);
            $last_unredirected_count = count($last_unredirected);

            if (($last_record['redirected'] && $last_redirected_count < 100 - $deduction) || (!$last_record['redirected'] && $last_unredirected_count >= $deduction)) {
                // 扣量达到百分比后开始正常跳转到渠道商网站
                $record->add(array(
                    'channel_id' => $channel_data['id'],
                    'redirected' => '1',
                    'timeline' => time()
                ));
                redirect(strpos($channel_data['url'], 'http') !== false ? $channel_data['url'] : 'http://' . $channel_data['url']);
                return;

            } else {
                // 扣量未达百分比跳转到默认网站
                $record->add(array(
                    'channel_id' => $channel_data['id'],
                    'redirected' => '0',
                    'timeline' => time()
                ));
                redirect($default_url);
                return;
            }
        }
    }
}
