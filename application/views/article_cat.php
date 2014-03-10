<div id="right">
<fieldset>
    <legend>文章分类管理</legend> 
	<a href="#" onclick="show();"><input class="btn" type="button" value='创建分类'></a>
	<div id="create" style="display:none;margin-top: 20px;">
		<form action="<?php echo site_url('article_category/edit'); ?>" method="post" id="cat_form">
		  <input type="text" name="name" id="name">
		  <input class="btn" type="submit" value="确定">
		</form>
	</div>
	<?php
		 if($list){ 
	?>
	<table class="table table-striped table-hover " style="font-size: 13px;">
		<tr><th>序号</th><th>分类名</th><th>操作</th></tr>
	<?php
            $i=1;
	 		foreach ($list as $value){
	 ?>	
	 	<tr style="height:10px;">
		 	<td><?php echo $i;$i++; ?></td>
		 	<td><span id="cat<?php echo $value['id'];?>" onclick="changeshow('<?php echo $value['id']; ?>')"><a><?php echo $value['name']; ?></a></span>
		 		<form style="margin: 0;" id="cform<?php echo $value['id']; ?>" action="<?php echo site_url('article_category/edit/'.$value['id']); ?>" method="post">
		 			<span id="catid<?php echo $value['id']; ?>" style="display:none;"><input  class="input-medium search-query" style="height:25px;" type="text" name="name" value="<?php echo $value['name'];?>" onblur="submitform('<?php echo $value['id']; ?>')"></span></td>
		 		</form>
		 	<td><a href="<?php echo site_url('article_category/delete/'.$value['id'])?>" onclick="return confirm('确定要删除？')">删除</a></td>
	 	</tr>
		<script>
			function changeshow(id){
				$("#cat"+id).css('display','none');
				$("#catid"+id).css('display','');
			}
			function submitform(d){
				$("#cform"+d).submit();
			}
			
		</script>
	 <?php 
	 		}
	?>
	
	</table>
	<?php }else{ ?>
		未创建分类
	<?php } ?>
</fieldset>
	<div id="page" style="text-align: center"><?php echo $this->pagination->create_links()?></div>
</div>
	
<script>
function show(){
	$("#create").css('display','');
}
$("#cat_form").submit(function(){
	if($("#name").val() == ''){
		alert('请填写分类名');
		return false;
	}
});
</script>