<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML><html lang="en"><head><meta charset="UTF-8"><title>咬死猪渠道管理平台</title><link media="all" rel="stylesheet" href="/css/bootstrap.min.css" type="text/css" /><link media="all" rel="stylesheet" href="/css/admin.css" type="text/css" /></head><body><div class="navbar navbar-inverse navbar-fixed-top"><div class="navbar-inner"><div class="container-fluid"><a class="brand" href="__APP__/">咬死猪渠道管理平台</a></div></div></div><!--/.navbar .navbar-fixed-top--><div class="sidebar-nav"><div class="well"><ul class="nav nav-list"><li class="active"><a href="__APP__/"><i class="icon-zoom-in"></i> 渠道查看</a></li><li><a href="__APP__/index/create"><i class="icon-plus"></i> 添加渠道</a></li><li><div class="divider"></div></li><li><a href="__APP__/user/change_password"><i class="icon-user"></i> 修改密码</a></li><li><a href="__APP__/user/signout"><i class="icon-off"></i> 退出登录</a></li></ul></div></div><!--/.sidebar-nav--><div class="container-fluid content"><div class="row-fluid"><!-- Bread Crumb Navigation --><div class="span12"><div><ul class="breadcrumb"><li><a href="__APP__/">咬死猪渠道管理平台</a><span class="divider">/</span></li><li class="active">修改渠道 - "#<?php echo ($channel["id"]); ?> 「<?php echo ($channel["name"]); ?> : <?php echo ($channel["url"]); ?>」"</li></ul></div><div class="row-fluid"><div class="span12"><div class="box"><div class="box-container"><div class="box-content"><form class="form form-horizontal" method="post" action=""><div class="control-group"><label for="name" class="control-label"><span class="star">*</span> 渠道商：</label><div class="controls"><input type="text" class="input-xlarge" id="name" name="name" value="<?php echo ($channel["name"]); ?>" /></div></div><div class="control-group"><label for="url" class="control-label"><span class="star">*</span> 网址：</label><div class="controls"><div class="input-prepend"><span class="add-on">http://</span><input type="text" class="input-xlarge" id="url" name="url" value="<?php echo ($channel["url"]); ?>" /></div></div></div><div class="control-group"><label for="deduction" class="control-label">扣量：</label><div class="controls"><select id="deduction" name="deduction"><?php for ($i = 0; $i < 100; $i += 5): ?><option value="<?php echo ($i/100); ?>" <?php if($i/100 == $channel['deduction']): ?>selected="selected"<?php endif; ?>><?php echo ($i); ?>%</option><?php endfor; ?></select></div></div><div class="control-group"><label class="control-label">状态：</label><div class="controls"><label class="radio inline"><input type="radio" name="status" id="status_1" value="1" <?php if($channel['status'] == '1'): ?>checked="checked"<?php endif; ?>>                      启用
                    </label>                    &nbsp;&nbsp;
                    <label class="radio inline"><input type="radio" name="status" id="status_0" value="0" <?php if($channel['status'] == '0'): ?>checked="checked"<?php endif; ?>>                      停用
                    </label></div></div><div class="form-actions"><input type="hidden" name="id" value="<?php echo ($channel["id"]); ?>" /><input class="btn btn-primary" type="submit" name="submit" value=" 保存 " /></div></form></div></div></div></div></div><!--/.row-fluid--></div><!--/span12--></div><!--/row-fluid--></div><!--/.container-fluid--><hr /><div class="container"><p>&copy; 2012<?php if(date('Y') != '2012'): ?>-<?php echo date('Y'); endif; ?> YaoSiZhu.Hong. All Rights Reserved.</p></div><script src="/js/jquery.min.js" type="text/javascript"></script><script src="/js/bootstrap.min.js" type="text/javascript"></script><script src="/js/jquery.validate.min.js" type="text/javascript"></script><script type="text/javascript">  $('.form').validate({
    rules: {
      name: 'required',
      url: 'required'
    },
    messages: {
      name: '请输入渠道商名',
      url: '请输入渠道网址'
    }
  });
</script></body></html>