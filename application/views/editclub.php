<script>
    KindEditor.ready(function(K) {
        var options = {

            cssPath : '/css/index.css',
            filterMode : true

        };
        window.editor = K.create('#club_content',options);
    });

</script>

<div id="right">
    <fieldset>
        <?php if ($club_id){ ?>
            <legend>编辑主题会所</legend>
        <?php }else{ ?>
            <legend>添加主题会所</legend>
        <?php } ?>
        <div style="position:relative;left:10px;top:10px">
            <form id="club_form" action="<?php echo site_url('club/edit')?>" method="post" enctype="multipart/form-data">
                <?php echo form_hidden('club_id', $club_id);?>
                <table>
                    <tr>
                        <td>会所名称：</td>
                        <td><input type="text" style="width: 200px;height: 25px;" id="club_name" name="club_name" value="<?php echo $club_name; ?>"></td>
                    </tr>
                    <tr>
                        <td>会所负责人：</td>
                        <td><input type="text" style="width: 200px;height: 25px;" id="club_name" name="club_manager" value="<?php echo $club_manager; ?>"></td>
                    </tr>
                    <tr>
                        <td>负责人电话：</td>
                        <td><input type="text" style="width: 200px;height: 25px;" id="club_name" name="manager_phone" value="<?php echo $manager_phone; ?>"></td>
                    </tr>
                    <tr>
                        <td>会所描述：</td>
                        <td><textarea style="width:700px;height:300px;" rows="10" cols="50"  id="club_content"  name="club_content"><?php echo $club_content; ?></textarea></td>
                    </tr>

                    <tr>
                        <td>图片：</td>
                        <td>
                            <input type="file" name="club_pic" id="club_pic">
                        </td>
                    </tr>
                    <tr style="text-align: center;">
                        <td><input type="submit" class="btn" value="提交"></td><td><a href="<?php echo site_url('club');?>"><input class="btn" type="button" value="取消"></a></td>
                    </tr>
                </table>
            </form>
        </div>
    </fieldset>
</div>
<script>
    $("#club_form").submit(function(){
        if($("#club_name").val() == ''){
            alert('请填写会所名称');
            return false;
        }
    });
</script>


