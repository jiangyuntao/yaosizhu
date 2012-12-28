<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>页面提示 - 大开网</title>
<meta http-equiv='Refresh' content='{$waitSecond};URL={$jumpUrl}'>
<link media="all" rel="stylesheet" href="/style/bootstrap.min.css" type="text/css" />
<link media="all" rel="stylesheet" href="/style/admin.css" type="text/css" />
</head>
<body>
<div class="container-fluid" style="margin-top: 160px;">
  <div class="row-fluid">
    <div class="span4">&nbsp;</div>
    <div class="span4">
      <div class="page-header">
        <h4><center>{$msgTitle} {$message}</center></h4>
      </div>
      <div>
            <present name="message" >
            <div class="alert alert-success">
              {$msgTitle}{$message} ——
              <present name="closeWin" >
                  页面将在 <span class="wait">{$waitSecond}</span> 秒后自动关闭，如果不想等待请点击 <a href="{$jumpUrl}">这里</a> 关闭
              <else/>
                  页面将在 <span class="wait">{$waitSecond}</span> 秒后自动跳转，如果不想等待请点击 <a href="{$jumpUrl}">这里</a> 跳转
              </present>
            </div>
            <else/>
            <div class="alert alert-error">
              {$msgTitle}{$error} ——
              <present name="closeWin" >
                  页面将在 <span class="wait">{$waitSecond}</span> 秒后自动关闭，如果不想等待请点击 <a href="{$jumpUrl}">这里</a> 关闭
              <else/>
                  页面将在 <span class="wait">{$waitSecond}</span> 秒后自动跳转，如果不想等待请点击 <a href="{$jumpUrl}">这里</a> 跳转
              </present>
            </div>
            </present>
      </div>
      <!--/span--> 
    <div class="span4">&nbsp;</div>
  </div>
  <!--/span--> 
</div>
<!--/row-->

<script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="/js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>
