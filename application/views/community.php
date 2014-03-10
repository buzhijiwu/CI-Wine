<div id="right">
<fieldset>
    <legend>贴子</legend>
<?php if (isset($list)){ ?>
   <table class="table table-striped table-hover" style="font-size: 13px;">
        <tr align="center" valign="middle" height="30">
            <th width="10%"  bgcolor="#cccccc" style="text-align: center">主题</th>
            <th width="45%"  bgcolor="#cccccc"style="text-align: center">信息</th>
            <th width="10%" bgcolor="#cccccc"style="text-align: center">作者</th>
            <th width="15%" bgcolor="#cccccc"style="text-align: center">时间</th>
            <th colspan="2" bgcolor="#cccccc"style="text-align: center">操作</th>
        </tr>
        <?php
        foreach ($list as $item){
        	
            ?>
            <tr valign="middle">
                <td bgcolor="#eeeeee" height="25" style="text-align: center;"><?php echo ($item['subject']);?></td>
                <td bgcolor="#eeeeee" title="<?php echo $item['message']; ?>"><?php echo str_cut($item['message'],30);?></td>
                <td bgcolor="#eeeeee" style="text-align: center;" ><?php echo $item['user_name'] ;?></td>
                <td bgcolor="#eeeeee" style="text-align: center;"><?php echo $item['create_time'] ;?></td>
                <td bgcolor="#eeeeee" style="text-align: center;"><a href="<?php echo site_url('community/post_delete/'.$item['pid']);?>" onclick="return confirm('是否删除')">删除</a></td>
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
	<div id="page" style="text-align: center"><?php echo $this->pagination->create_links(); ?></div>
</div>

