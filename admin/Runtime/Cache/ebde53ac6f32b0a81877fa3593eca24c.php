<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML><html lang="en"><head><meta charset="UTF-8"><title>页面提示</title><meta http-equiv='Refresh' content='<?php echo ($waitSecond); ?>;URL=<?php echo ($jumpUrl); ?>'><link media="all" rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" /><link media="all" rel="stylesheet" href="/css/admin.css" type="text/css" /></head><body><div class="container-fluid" style="margin-top: 160px;"><div class="row-fluid"><div class="span4">&nbsp;</div><div class="span4"><div class="page-header"><h4><center><?php echo ($msgTitle); echo ($message); ?></center></h4></div><div><?php if(isset($message)): ?><div class="alert alert-success"><?php echo ($msgTitle); echo ($message); ?> ——
              <?php if(isset($closeWin)): ?>页面将在 <span class="wait"><?php echo ($waitSecond); ?></span> 秒后自动关闭，如果不想等待请点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 关闭
              <?php else: ?>                  页面将在 <span class="wait"><?php echo ($waitSecond); ?></span> 秒后自动跳转，如果不想等待请点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 跳转<?php endif; ?></div><?php else: ?><div class="alert alert-error"><?php echo ($msgTitle); echo ($error); ?> ——
              <?php if(isset($closeWin)): ?>页面将在 <span class="wait"><?php echo ($waitSecond); ?></span> 秒后自动关闭，如果不想等待请点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 关闭
              <?php else: ?>                  页面将在 <span class="wait"><?php echo ($waitSecond); ?></span> 秒后自动跳转，如果不想等待请点击 <a href="<?php echo ($jumpUrl); ?>">这里</a> 跳转<?php endif; ?></div><?php endif; ?></div><!--/span--><div class="span4">&nbsp;</div></div><!--/span--></div><!--/row--><script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script><script src="/js/bootstrap.min.js" type="text/javascript"></script></body></html>