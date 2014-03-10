
    <script>
        function changecatid(){
            document.forms[0].submit();
        }

    </script>
<div id="right">
<fieldset>
    <legend>文章管理</legend>
<form id="formaction" action="<?php echo site_url('article/index') ;?>" method="post">
    <table width="100%">
        <tr>
            <td width="45%">
                <a href="<?php echo site_url('article/showeidt') ;?>"><input class="btn" type="button" value="添加文章"></a>
            </td>
            <td>
              
                <?php
                $js = 'id="catid" onChange="changecatid();"';
                echo form_dropdown('cat_id',$cats,$catid,$js);
                ?>
            </td>
        </tr>
    </table>
</form>
<?php if (isset($list)){ ?>
   <table class="table table-striped table-hover" style="font-size: 13px;">
        <tr align="center" valign="middle" height="30">
            <th width="10%"  bgcolor="#cccccc" style="text-align: center">序号</th>
            <th width="45%"  bgcolor="#cccccc"style="text-align: center">标题</th>
            <th width="10%" bgcolor="#cccccc"style="text-align: center">类别</th>
            <th width="15%" bgcolor="#cccccc"style="text-align: center">创建日期</th>
            <th colspan="2" bgcolor="#cccccc"style="text-align: center">操作</th>
        </tr>
        <?php
        $i = 1;
        foreach ($list as $item){
        	
            ?>
            <tr valign="middle">
                <td bgcolor="#eeeeee" height="25" style="text-align: center;"><?php echo $i;$i++;?></td>
                <td bgcolor="#eeeeee"><?php echo str_cut($item['title'],30);?></td>
                <td bgcolor="#eeeeee" style="text-align: center;"><?php echo $item['name'] ;?></td>
                <td bgcolor="#eeeeee" style="text-align: center;"><?php echo $item['createtime'] ;?></td>
                <td bgcolor="#eeeeee" style="text-align: center;">
                    <a href="<?php echo site_url('article/showeidt/'.$item['aid']); ?>">编辑</a>
                </td>
                <td bgcolor="#eeeeee" style="text-align: center;">
                    <a href="<?php echo site_url('article/delete/'.$item['aid']);?>" onclick="return confirm('是否删除')">删除</a>
                </td>
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
	<div id="page" style="text-align: center"><?php echo $this->pagination->create_links()?></div>
</div>
