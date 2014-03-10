<div id="right">
<fieldset>
  <legend>修改用户密码</legend>
	<form action="<?php echo site_url('user/update_password')?>" method="post">
		<table>
		 <caption><?php echo $user_name; ?></caption>
		 <tr><td>新密码：</td><td><input type="text" name="userpassword" id="userpassword"></td></tr>
		 <tr><td colspan="2"><input type="hidden" name='uid' value="<?php echo $id; ?>"></td></tr>
		 <tr><td colspan="2"><input class="btn" type="submit" value="修改"></td></tr>
		</table>
	</form>
</fieldset>
</div>
