0. 上传全部文件
1. Apache 添加虚拟主机，DocumentRoot 值设置为项目目录下 webroot
2. 修改 application, admin 两个目录下的 Conf/config.php，其中 URL_CASE_INSENSITIVE 和 SALT 两项不要修改
3. 修改 application, admin 下的 Runtime 及其下目录文件为可写
4. 修改 application/Lib/Action/IndexAction.class.php 中 $default_url 值为扣量时显示的页面地址
5. 后台地址为 your_domain/admin.php
6. 前台地址为 your_domain/?id=xxx，此处 xxx 为渠道商 id 编号