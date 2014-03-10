<div id="right">
<fieldset>
    <legend>视频管理</legend> 
    <form id="formaction" action="<?php echo site_url('video') ;?>" method="post">
		    <table width="100%">
		        <tr>       	
		            <td width="45%">
						<a href="<?php echo site_url('video/showedit'); ?>" ><input class="btn" type="button" value='添加视频'></a>		            <td>
		                <input class="input-medium search-query" style="height:30px;width:250px;" type="text" name="name" id="name" placeholder="请输入要查询的视频名称"><input class="btn" type="submit" value="搜素">
		            </td>
		        </tr>
		    </table>
		</form>
	
	
	<?php
		 if($list){ 
	?>
	<table class="table table-striped table-hover " style="font-size: 13px;">
		<tr><th>id号</th><th>视频名</th><th>类别</th><th>时长</th><th colspan="2">操作</th></tr>
	<?php 
	 		foreach ($list as $value){
	 ?>	
	 	<tr style="height:10px;" valign="middle">
		 	<td bgcolor="#eeeeee"><?php echo $value['video_id']; ?></td>
		 	<td bgcolor="#eeeeee"><span id="cat<?php echo $value['video_id'];?>" ><?php echo $value['video_name']; ?></span></td>
		 	<td bgcolor="#eeeeee"><span id="cat<?php echo $value['video_category'];?>" ><?php echo $value['video_category']; ?></span></td>
		 	<td bgcolor="#eeeeee"><?php echo $value['video_length'][0].':'.$value['video_length'][1].':'.$value['video_length'][2]?></td>
		 	<td bgcolor="#eeeeee"><a href="<?php echo site_url('video/showedit/'.$value['video_id']); ?>">编辑</a></td>
		 	<td bgcolor="#eeeeee"><a href="<?php echo site_url('video/delete/'.$value['video_id'])?>" onclick="return confirm('确定要删除？')">删除</a></td>
	 	</tr>
		
	 <?php 
	 		}
	?>
	
	</table>
	<?php }else{ ?>
		<br>还未上传视频
	<?php } ?>
</fieldset>
	<div id="page" style="text-align: center"><?php echo $this->pagination->create_links()?></div>
</div>
	
<script>
function show(){
	$("#create").css('display','');
}
$("#video_form").submit(function(){
	if($("#name").val() == ''){
		alert('请填写视频名称');
		return false;
	}
	if($("#url").val() == ''){
		alert('请填写视频地址');
		return false;
	}
	if($("#video_length").val() == ''){
		alert('请填写视频地址');
		return false;
	}
});
</script>
