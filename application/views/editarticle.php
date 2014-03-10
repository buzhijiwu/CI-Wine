<script>
 KindEditor.ready(function(K) {
	 var options = {

	            cssPath : '/css/index.css',
	            filterMode : true
	             
	        };
        window.editor = K.create('#content',options);

   });

       
</script>

    <div id="right">
    <fieldset>
    <legend>编辑文章</legend>
    <div style="position:relative;left:10px;top:10px">
        <form action="<?php echo site_url('article/edit')?>" method="post" enctype="multipart/form-data">
            <?php echo form_hidden('aid', $aid);?>
            <table>
                <tr>
                    <td>标题：</td>
                    <td><input type="text" style="width: 200px;height: 24px;" id="title" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>类型：</td>
                    <td><?php $js = 'id="type"'; echo form_dropdown('cat_id',$category,$cat_id,$js) ;?></td>
                </tr>
                <tr>
                    <td>URL：</td>
                    <td>
                        <input type="text" style="width: 200px;height: 24px;" id="url" name="url" value="<?php echo $url; ?>">
                        &nbsp;&nbsp;&nbsp;<span style="color: red;">(推荐应用必须填写URL)</span>
                    </td>
                </tr>
                <tr>
                    <td>简介：</td>
                    <td><textarea rows="2" cols="50" id="shortdesc"  name="shortdesc"><?php echo $shortdesc; ?></textarea></td>
                </tr>
                <tr>
                    <td>内容：</td>
                    <td><textarea  style="width:700px;height:300px;" rows="10" cols="50" name="content" id="content"><?php echo $content; ?></textarea></td>
                </tr>
                <tr>
                    <td>图片：</td>
                    <td>
                        <input type="file" name="userfile">
                        <span style="color: red;">(上滑图片只能传jpg格式)</span>
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <td><input type="submit" class="btn" value="提交" onclick="return checkinfo();"></td><td><a href="<?php echo site_url('article/index');?>"><input class="btn" type="button" value="取消"></a></td>
                </tr>
            </table>
        </form>
    </div>
    </fieldset>
    </div>
    <script>
    function checkinfo(){
		if($('#title').val().trim() == '' ){
			alert('请填写标题');
			return false;
		}else if($('#type').val() == '0'){
			alert('请选择类型');
			return false;
		}
		
    } 
    </script>

