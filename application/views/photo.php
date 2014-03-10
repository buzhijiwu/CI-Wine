
<script>
    function changecatid(){
        document.forms[0].submit();
    }

</script>
<div id="right">
    <fieldset>
        <legend>相册管理</legend>
        <a href="<?php echo site_url('photo/add_edit_show')?>" style="margin-bottom: 20px;"><button class="btn" type="button">添加图片</button></a>
        <form method="post" action="<?php echo site_url('photo/search')?>" style="float: right;margin-right: 40px;">
            <select name="cid" onchange="changecatid()">
                <option >--请选择分类--</option>
                <?php foreach($cat_list as $value){?>
                <option value="<?php echo$value['id']?>"><?php echo $value['name']?></option>
                <?php }?>
            </select>
        </form>
        <?php if (isset($list)){ ?>
            <table class="table table-striped table-hover" style="font-size: 13px;">
                <tr align="center" valign="middle" height="30">
                    <th width="10%"  bgcolor="#cccccc" style="text-align: center">序号</th>
                    <th width="45%"  bgcolor="#cccccc"style="text-align: center">图片名称</th>
                    <th width="10%" bgcolor="#cccccc"style="text-align: center">图片类别</th>
                    <th colspan="2" bgcolor="#cccccc"style="text-align: center">操作</th>
                </tr>
                <?php
                $i=1;
                foreach ($list as $item){

                    ?>
                    <tr valign="middle">
                        <td bgcolor="#eeeeee" height="25" style="text-align: center;"><?php echo $i;$i++;?></td>
                        <td bgcolor="#eeeeee"><?php echo str_cut($item['title'],30);?></td>
                        <td bgcolor="#eeeeee" style="text-align: center;"><?php echo $item['name'] ;?></td>
                        <td bgcolor="#eeeeee" style="text-align: center;"><a href="<?php echo site_url('photo/add_edit_show/'.$item['id']); ?>" >编辑</a></td>
                        <td bgcolor="#eeeeee" style="text-align: center;"><a href="<?php echo site_url('photo/delete/'.$item['id']);?>" onclick="return confirm('是否删除')">删除</a></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        }else{
            echo '暂无内容';
        }
        ?>
    </fieldset>
</div>
