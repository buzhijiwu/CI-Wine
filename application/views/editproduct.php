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
        <legend>编辑商品</legend>
        <div style="position:relative;left:10px;top:10px">
            <form action="<?php echo site_url('product/edit')?>" method="post" enctype="multipart/form-data">
                <?php echo form_hidden('pid', $pid);?>
                <table>
                    <tr>
                        <td>标题：</td>
                        <td><input type="text" style="width: 200px;height: 24px;" id="pname" name="pname" value="<?php echo $pname; ?>"></td>
                    </tr>
                    <tr>
                        <td>类型：</td>
                        <td><?php $js = 'id="type"'; echo form_dropdown('cat_id',$category,$cat_id,$js) ;?></td>
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
                        </td>
                    </tr>
                    <tr style="text-align: center;">
                        <td><input type="submit" class="btn" value="提交" onclick="return checkinfo();"></td><td><a href="<?php echo site_url('product/index');?>"><input class="btn" type="button" value="取消"></a></td>
                    </tr>
                </table>
            </form>
        </div>
    </fieldset>
</div>
<script>
    function checkinfo(){
        if($('#pname').val().trim() == '' ){
            alert('请填写商品名称');
            return false;
        }else if($('#type').val() == '0'){
            alert('请选择类型');
            return false;
        }

    }
</script>

