<head>
    <script charset="utf-8" src="<?php echo base_url();?>js/validate.js"></script>
</head>
<div id="right">
    <form id="product_form"  enctype="multipart/form-data" method="post" action="<?php echo site_url('photo/admin_add_edit'); ?>">
        <fieldset>
            <legend>添加相册图片</legend>
            <a href="<?php echo site_url('photo/index')?>" style="margin-bottom: 20px;"><button class="btn" type="button">返回相册列表</button></a>
            <label style="margin-top: 20px;">相册标题:</label>
            <input type="text" name="photo_title"  id="title" class="input-xxlarge" style="height: 30px;" placeholder="请输入标题">
            <label>上传图片:</label>
            <input type="file" name="photo_img" id="pts_img" accept="image/*"/>
            <label style="margin-top: 20px;">图片类型:</label>
            <select name="photo_cat" >
                <option >--请选择分类--</option>
                <?php foreach($cat_list as $value){?>
                    <option value="<?php echo$value['id']?>"><?php echo $value['name']?></option>
                <?php }?>
            </select>
            <label>是否全屏显示:</label>
            <select name="is_full">
                        <option value="1">全屏</option>
                        <option value="0">不全屏</option>
                    </select>
            <label>相册简介:</label>
            <textarea style="width: 500px;" rows="5" name="photo_content" id="photo_content"></textarea>

            </textarea>
            <br/>
            <button type="submit" class="btn" style="margin:20px auto;">添加</button>
        </fieldset>
    </form>
    <div style="clear:both;"></div>
</div>