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
    <?php if ($video_id){ ?>
    	<legend>编辑视频</legend>
    <?php }else{ ?>
    	<legend>添加视频</legend>
    <?php } ?>
    <div style="position:relative;left:10px;top:10px">
        <form id="video_form" action="<?php echo site_url('video/edit')?>" method="post" enctype="multipart/form-data">
            <?php echo form_hidden('video_id', $video_id);?>
            <table>
                <tr>
                    <td>视频名称：</td>
                    <td><input type="text" id="video_name" name="video_name" value="<?php echo $video_name; ?>"></td>
                </tr>
                <tr>
                    <td>视频地址：</td>
                    <td><input type="text" id="video_url" name="video_url" value="<?php echo $video_url; ?>"></td>
                </tr>
                <tr>
                    <td>视频类别：</td>
                    <td style="">
                        <?php
                            if($video_category == '1'){
                        ?>
                              <input type="radio" name="video_category"  id="video_category" value="0"/>我的空间&nbsp;&nbsp;
                              <input type="radio" name="video_category"  id="video_category" value="1" checked="true"/>空间社区
                        <?php
                        }else{
                        ?>
                              <input type="radio" name="video_category"  id="video_category" value="0" checked="true"/>我的空间&nbsp;&nbsp;
                              <input type="radio" name="video_category"  id="video_category" value="1"/>空间社区
                        <?php
                            }
                        ?>

                    </td>
                </tr>
                <tr>
                    <td>描述：</td>
                    <td><br/><textarea  style="width:700px;height:300px;" rows="10" cols="50" name="content" id="content"><?php echo $content; ?></textarea></td>
                </tr>
               
                <tr>
                    <td>时长：</td>
                    <td>时：<?php echo form_dropdown('hour', $showhour, $video_length[0],'id="hour"'); ?>分：<?php echo form_dropdown('minute', $showminute, $video_length[1],'id="minute"'); ?>秒：<?php echo form_dropdown('second', $showminute, $video_length[2],'id="second"'); ?></td>
                </tr>
                <tr>
                    <td>图片：</td>
                    <td>
                        <input type="file" name="video_image">
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <td><input type="submit" class="btn" value="提交" onclick="return checkinfo();"></td><td><a href="<?php echo site_url('video');?>"><input class="btn" type="button" value="取消"></a></td>
                </tr>
            </table>
        </form>
    </div>
    </fieldset>
    </div>
    <script>
    $("#video_form").submit(function(){
    	if($("#video_name").val() == ''){
    		alert('请填写视频名称');
    		return false;
    	}
    	if($("#video_name").val().length > 20){
    		alert('请填写视频名称太长');
    		return false;
    	}
    	if($("#video_url").val().trim() == ''){
    		alert('请填写视频地址');
    		return false;
    	}
    	if($("#video_url").val().indexOf('youku.com') == -1){
    		alert('请填写优酷视频地址');
    		return false;
    	}
    	
    	if($("#video_length").val() == ''){
    		alert('请填写视频时长');
    		return false;
    	}
    });
    </script>

