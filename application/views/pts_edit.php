<div id="right">

    <form id="product_form"  enctype="multipart/form-data" method="post" action="<?php echo site_url('Pts/admin_add'); ?>">
        <fieldset>
            <legend>添加葡萄树</legend>
            <a href="<?php echo site_url('Pts/index')?>" style="margin-bottom: 20px;"><button class="btn" type="button">返回葡萄树列表</button></a>
            <label style="margin-top: 20px;">葡萄树标题:</label>
            <input type="text" name="pts_title" value="<?php echo $res['pts_title']?>" id="title" class="input-xxlarge" style="height: 30px;" placeholder="请输入标题">
            <label>上传图片:</label>
            <input type="file" name="pts_img"/><span style="color: red;">*不上传则不修改</span>
            <label>是否全屏显示:</label>
            <select name="is_full">
                <?php if($res['is_full'] == 1){
                    echo '<option value="1" selected="selected">全屏</option><option value="0">不全屏</option>';
                }elseif($res['is_full'] == 0){
                    echo '<option value="1" >全屏</option><option value="0" selected="selected">不全屏</option>';
                }
                ?>
            </select>
            <label id="before_img">葡萄树内容:</label>
            <textarea style="width: 500px;" rows="5" name="pts_content" id="pts_content"><?php echo $res['pts_content']?>
            </textarea>

            <br/>
            <input type="hidden" name="id" value="<?php echo $res['id']?>">
            <button type="submit" class="btn" style="margin:20px auto;">确定</button>
        </fieldset>
    </form>
</div>