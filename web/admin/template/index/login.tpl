<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="no-cache"> 
<meta http-equiv="Expires" content="0"> 
<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, user-scalable=no">
<title><{$title}></title>
<link href="<{$smarty.const.SYS_STATIC_URL}>/css/login.css?v=20180712" type="text/css" rel="stylesheet">
</head>
<body>
<div class="htmleaf-container">
	<div class="wrapper">
		<div class="container">
			<h1>SDK联运后台</h1>
			<form class="form" method="post">
				<input name="username" placeholder="用户名" required type="text">
				<input name="password" placeholder="密码" required type="password">
				<div class="code"<{if $isNeedCaptcha}> style="display: block;"<{/if}>>
					<input name="code" placeholder="验证码" type="text"<{if $isNeedCaptcha}> required<{/if}>>
					<span><img src="?ct=captcha" id="js-mVcodeImg"/></span>
				</div>
				<div class="keep">
					<input type="checkbox" placeholder="保持登录" name="keep" value="1" /> <label for="keep">保持登录15天</label>
				</div>
				<button type="submit">登录</button>
			</form>
		</div>
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
</div>
<script src="<{$smarty.const.SYS_STATIC_URL}>/js/jquery/jquery-3.3.1.min.js"></script>
<script src="<{$smarty.const.SYS_STATIC_URL}>/js/login.js?v=20180712"></script>
</body>
</html>