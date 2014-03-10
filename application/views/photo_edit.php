<head>
</head>
<div id="right">
    <form id="product_form"  enctype="multipart/form-data" method="post" action="<?php echo site_url('photo/admin_add_edit'); ?>">
        <fieldset>
            <legend>修改图片</legend>
            <a href="<?php echo site_url('photo/index')?>" style="margin-bottom: 20px;"><button class="btn" type="button">返回相册列表</button></a>
            <label style="margin-top: 20px;">相册标题:</label>
            <input type="text" name="photo_title" value="<?php echo $info['title']?>" id="title" class="input-xxlarge" style="height: 30px;" placeholder="请输入标题">
            <label>上传图片:</label>
            <input type="file" name="photo_img" id="pts_img" accept="image/*"/><span style="font-size: 12px;color: red;">* 不选择则不修改图片</span>
            <label style="margin-top: 20px;">图片类型:</label>
            <select name="photo_cat" >
                <?php foreach($cat_list as $value){?>
                    <?php if($value['id'] == $info['cid']){?>
                    <option value="<?php echo$value['id']?>" selected="selected"><?php echo $value['name']?></option>
                     <?php }else{?>
                        <option value="<?php echo$value['id']?>" ><?php echo $value['name']?></option>
                        <?php }?>
                <?php }?>
            </select>
            <label>是否全屏显示:</label>
            <select name="is_full">
                <?php if($info['is_full']==1){?>
                        <option value="1" selected="selected">全屏</option>
                        <option value="0">不全屏</option>
                <?php }else{?>
                    <option value="1">全屏</option>
                <option value="0"  selected="selected">不全屏</option>
                <?php }?>
            </select>
            <label>相册简介:</label>
            <textarea style="width: 500px;" rows="5" name="photo_content" id="photo_content">
            <?php echo $info['intro']?>
            </textarea>
            <br/>
            <button type="submit" class="btn" style="margin:20px auto;">确定</button>
        </fieldset>
        <input type="hidden" name="id" value="<?php echo $info["id"]?>">
    </form>
    <div style="clear:both;"></div>
</div>