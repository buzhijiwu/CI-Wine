 <div id="right">
    <fieldset>
    <?php if ($share_id){ ?>
    	<legend>编辑分享</legend>
    <?php }else{ ?>
    	<legend>添加分享</legend>
    <?php } ?>
    <div style="position:relative;left:10px;top:10px">
        <form id="share_form" action="<?php echo site_url('welife/edit')?>" method="post" enctype="multipart/form-data">
            <?php echo form_hidden('share_id', $share_id);?>
            <?php echo form_hidden('user_id', $user_id);?>
            <table>
                <tr>
                    <td>分享标题：</td>
                    <td><input type="text" id="share_title" name="share_title" value="<?php echo $share_title; ?>"></td>
                </tr>
                <tr>
                    <td>分享内容：</td>
                    <td><textarea style="width:700px;height:300px;" rows="10" cols="50"  id="share_content"  name="share_content"><?php echo $share_content; ?></textarea></td>
                </tr>
               
               
                <tr>
                    <td>图片：</td>
                    <td>
                        <input type="file" name="share_pic" id="share_pic">
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <td><input type="submit" class="btn" value="提交"></td><td><a href="<?php echo site_url('Share');?>"><input class="btn" type="button" value="取消"></a></td>
                </tr>
            </table>
        </form>
    </div>
    </fieldset>
    </div>
    <script>
    $("#share_form").submit(function(){
    	if($("#share_title").val() == ''){
    		alert('请填写视频名称');
    		return false;
    	}
    	if($("#shate_content").val() == ''){
    		alert('请填写分享内容');
    		return false;
    	}
//    	if($("input[name='user_id']").val() == 'null'){
//	    	if($("#share_pic").val() == ''){
//	    		alert('请上传图片');
//	    		return false;
//	    	}
//    	}
    });
    </script>


