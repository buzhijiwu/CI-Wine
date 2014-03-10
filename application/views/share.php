<div id="right">
<fieldset>
    <legend>分享管理</legend> 
    <form id="formaction" action="<?php echo site_url('welife') ;?>" method="post">
		    <table width="100%">
		        <tr>       	
		            <td width="45%">
						<a href="<?php echo site_url('welife/showedit'); ?>" ><input class="btn" type="button" value='添加分享'></a>		            <td>
		                <input class="input-medium search-query" style="height:30px;width:250px;" type="text" name="name" id="name" placeholder="请输入要查询的分享标题"><input class="btn" type="submit" value="搜素">
		            </td>
		        </tr>
		    </table>
		</form>
	
	
	<?php
		 if($list){ 
	?>
	<table class="table table-striped table-hover " style="font-size: 13px;">
		<tr><th>id号</th><th>分享标题</th><th>分享时间</th><th colspan="2">操作</th></tr>
	<?php 
	 		foreach ($list as $value){
	 ?>	
	 	<tr style="height:10px;">
		 	<td bgcolor="#eeeeee"><?php echo $value['share_id']; ?></td>
		 	<td bgcolor="#eeeeee"><?php echo $value['share_title']; ?></td>
		 	<td bgcolor="#eeeeee"><?php echo $value['create_time']; ?></td>
		 	<td bgcolor="#eeeeee"><a href="<?php echo site_url('welife/showedit/'.$value['share_id']); ?>">编辑</a></td>
		 	<td bgcolor="#eeeeee"><a href="<?php echo site_url('welife/delete/'.$value['share_id'])?>" onclick="return confirm('确定要删除？')">删除</a></td>
	 	</tr>
		
	 <?php 
	 		}
	?>
	
	</table>
	<?php }else{ ?>
		<br>还未添加分享
	<?php } ?>
</fieldset>
	<div id="page" style="text-align: center"><?php echo $this->pagination->create_links()?></div>
</div>

